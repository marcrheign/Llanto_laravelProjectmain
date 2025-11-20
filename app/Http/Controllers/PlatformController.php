<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::withCount('games')->orderBy('name')->get();

        return view('platforms', compact('platforms'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatePlatform($request);

        Platform::create($validated);

        return redirect()->route('platforms.index')->with('success', 'Platform added successfully.');
    }

    public function update(Request $request, Platform $platform)
    {
        $validated = $this->validatePlatform($request, $platform->id);

        $platform->update($validated);

        return redirect()->route('platforms.index')->with('success', 'Platform updated successfully.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->route('platforms.index')->with('success', 'Platform deleted successfully.');
    }

    protected function validatePlatform(Request $request, ?int $platformId = null): array
    {
        $currentYear = (int) now()->year;

        return $request->validate([
            'name' => 'required|string|max:255|unique:platforms,name,' . $platformId,
            'manufacturer' => 'nullable|string|max:255',
            'release_year' => "nullable|integer|min:1970|max:$currentYear",
            'description' => 'nullable|string|max:1000',
        ]);
    }
}

