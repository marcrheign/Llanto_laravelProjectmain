<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('platform')->latest()->get();
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

        Game::create($validated);

        return redirect()->route('dashboard')->with('success', 'Game added successfully.');
    }

    public function update(Request $request, Game $game)
    {
        $validated = $this->validateGame($request);

        $game->update($validated);

        return redirect()->route('dashboard')->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('dashboard')->with('success', 'Game removed from your collection.');
    }

    protected function validateGame(Request $request): array
    {
        $currentYear = (int) now()->year;

        return $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'release_year' => "nullable|integer|min:1970|max:$currentYear",
            'status' => 'required|in:Backlog,Playing,Completed',
            'platform_id' => 'nullable|exists:platforms,id',
            'notes' => 'nullable|string|max:1000',
        ]);
    }
}

