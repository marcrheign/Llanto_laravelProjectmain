<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::with('platform')->latest();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Filter by platform
        if ($request->filled('platform_id')) {
            $query->where('platform_id', $request->platform_id);
        }

        $games = $query->get();
        $platforms = Platform::orderBy('name')->get();

        $stats = [
            'totalGames' => Game::count(),
            'totalPlatforms' => Platform::count(),
            'completedGames' => Game::where('status', 'Completed')->count(),
        ];

        $recentGames = Game::with('platform')->latest()->take(5)->get();

        return view('dashboard', compact('games', 'platforms', 'stats', 'recentGames'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateGame($request);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('games', 'public');
        }

        Game::create($validated);

        return redirect()->route('dashboard')->with('success', 'Game added successfully.');
    }

    public function update(Request $request, Game $game)
    {
        $validated = $this->validateGame($request, $game->id);

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($game->photo) {
                Storage::disk('public')->delete($game->photo);
            }
            $validated['photo'] = $request->file('photo')->store('games', 'public');
        }

        $game->update($validated);

        return redirect()->route('dashboard')->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {
        $game->delete(); // Soft delete

        return redirect()->route('dashboard')->with('success', 'Game moved to trash.');
    }

    public function trash()
    {
        $games = Game::onlyTrashed()->with('platform')->latest('deleted_at')->get();
        $platforms = Platform::orderBy('name')->get();

        return view('games.trash', compact('games', 'platforms'));
    }

    public function restore($id)
    {
        $game = Game::onlyTrashed()->findOrFail($id);
        $game->restore();

        return redirect()->route('games.trash')->with('success', 'Game restored successfully.');
    }

    public function forceDelete($id)
    {
        $game = Game::onlyTrashed()->findOrFail($id);
        
        // Delete photo if exists
        if ($game->photo) {
            Storage::disk('public')->delete($game->photo);
        }
        
        $game->forceDelete();

        return redirect()->route('games.trash')->with('success', 'Game permanently deleted.');
    }

    public function exportPdf(Request $request)
    {
        $query = Game::with('platform')->latest();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('platform_id')) {
            $query->where('platform_id', $request->platform_id);
        }

        $games = $query->get();

        $pdf = Pdf::loadView('games.pdf', compact('games'));
        
        $filename = 'games_' . now()->format('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }

    protected function validateGame(Request $request, ?int $gameId = null): array
    {
        $currentYear = (int) now()->year;

        $rules = [
            'title' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'genre' => 'nullable|string|max:255',
            'release_year' => "nullable|integer|min:1970|max:$currentYear",
            'status' => 'required|in:Backlog,Playing,Completed',
            'platform_id' => 'nullable|exists:platforms,id',
            'notes' => 'nullable|string|max:1000',
        ];

        return $request->validate($rules);
    }
}
