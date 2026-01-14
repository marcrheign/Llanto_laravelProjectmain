<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PlatformController extends Controller
{
    public function index(Request $request)
    {
        $query = Platform::withCount('games')->orderBy('name');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('manufacturer', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $platforms = $query->get();

        return view('platforms', compact('platforms'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatePlatform($request);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('platforms', 'public');
        }

        Platform::create($validated);

        return redirect()->route('platforms.index')->with('success', 'Platform added successfully.');
    }

    public function update(Request $request, Platform $platform)
    {
        $validated = $this->validatePlatform($request, $platform->id);

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($platform->photo) {
                Storage::disk('public')->delete($platform->photo);
            }
            $validated['photo'] = $request->file('photo')->store('platforms', 'public');
        }

        $platform->update($validated);

        return redirect()->route('platforms.index')->with('success', 'Platform updated successfully.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete(); // Soft delete

        return redirect()->route('platforms.index')->with('success', 'Platform moved to trash.');
    }

    public function trash()
    {
        $platforms = Platform::onlyTrashed()->withCount('games')->latest('deleted_at')->get();

        return view('platforms.trash', compact('platforms'));
    }

    public function restore($id)
    {
        $platform = Platform::onlyTrashed()->findOrFail($id);
        $platform->restore();

        return redirect()->route('platforms.trash')->with('success', 'Platform restored successfully.');
    }

    public function forceDelete($id)
    {
        $platform = Platform::onlyTrashed()->findOrFail($id);
        
        // Delete photo if exists
        if ($platform->photo) {
            Storage::disk('public')->delete($platform->photo);
        }
        
        $platform->forceDelete();

        return redirect()->route('platforms.trash')->with('success', 'Platform permanently deleted.');
    }

    public function exportPdf(Request $request)
    {
        $query = Platform::withCount('games')->orderBy('name');

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('manufacturer', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $platforms = $query->get();

        $pdf = Pdf::loadView('platforms.pdf', compact('platforms'));
        
        $filename = 'platforms_' . now()->format('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }

    protected function validatePlatform(Request $request, ?int $platformId = null): array
    {
        $currentYear = (int) now()->year;

        $rules = [
            'name' => 'required|string|max:255|unique:platforms,name,' . $platformId,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'manufacturer' => 'nullable|string|max:255',
            'release_year' => "nullable|integer|min:1970|max:$currentYear",
            'description' => 'nullable|string|max:1000',
        ];

        return $request->validate($rules);
    }
}
