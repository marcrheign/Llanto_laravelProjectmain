@extends('layouts.app')

@section('title', 'Platforms')

@section('content')
<div class="space-y-8">
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950 lg:col-span-2">
            <h2 class="mb-4 text-lg font-semibold">Add New Platform</h2>
            <form action="{{ route('platforms.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                @csrf
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Platform Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Manufacturer</label>
                    <input type="text" name="manufacturer" value="{{ old('manufacturer') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('description') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="w-full rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        Add Platform
                    </button>
                </div>
            </form>
        </div>

        @php
            $totalGames = $platforms->sum('games_count');
        @endphp
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <p class="text-sm text-gray-500 dark:text-gray-400">Collection Overview</p>
            <h2 class="mt-2 text-3xl font-bold">{{ $platforms->count() }} Platforms</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $totalGames }} games catalogued</p>
            <div class="mt-6 space-y-3">
                @foreach ($platforms->take(3) as $platform)
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3 text-sm dark:border-gray-800">
                        <div>
                            <p class="font-semibold">{{ $platform->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $platform->manufacturer ?? 'Unknown' }}</p>
                        </div>
                        <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-300">{{ $platform->games_count }} games</span>
                    </div>
                @endforeach
                @if ($platforms->isEmpty())
                    <p class="text-sm text-gray-500 dark:text-gray-400">Add a platform to see stats.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold">Platforms Directory</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage every system in your collection</p>
            </div>
            <span class="text-sm text-gray-500">{{ $platforms->count() }} total</span>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Platform</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Manufacturer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Year</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Games</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($platforms as $platform)
                        <tr class="text-sm">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                <p class="font-semibold">{{ $platform->name }}</p>
                                @if ($platform->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($platform->description, 60) }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $platform->manufacturer ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $platform->release_year ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                                    {{ $platform->games_count }} games
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div x-data="{ open: false }" class="inline-block">
                                        <button type="button" @click="open = true"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">Edit</button>
                                        <div x-cloak x-show="open" x-transition
                                             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                                            <div class="w-full max-w-lg rounded-2xl bg-white p-6 dark:bg-gray-900">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-lg font-semibold">Edit {{ $platform->name }}</h3>
                                                    <button type="button" @click="open = false" class="text-gray-500 hover:text-gray-700">×</button>
                                                </div>
                                                <form method="POST" action="{{ route('platforms.update', $platform) }}" class="mt-6 space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Platform Name</label>
                                                        <input type="text" name="name" value="{{ $platform->name }}" required
                                                               class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                    </div>
                                                    <div class="grid gap-4 md:grid-cols-2">
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Manufacturer</label>
                                                            <input type="text" name="manufacturer" value="{{ $platform->manufacturer }}"
                                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                        </div>
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Release Year</label>
                                                            <input type="number" name="release_year" value="{{ $platform->release_year }}"
                                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                                        <textarea name="description" rows="3"
                                                                  class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ $platform->description }}</textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end gap-3">
                                                        <button type="button" @click="open = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 dark:border-gray-700 dark:text-gray-300">Cancel</button>
                                                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('platforms.destroy', $platform) }}" onsubmit="return confirm('Delete this platform? Games will keep their platform set to N/A.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                No platforms added yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

