@extends('layouts.app')

@section('title', 'Platforms')

@section('content')
@php
    $totalGames = $platforms->sum('games_count');
    $topPlatforms = $platforms->sortByDesc('games_count')->take(3);
@endphp
<div class="space-y-8">
    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-gradient-to-br from-indigo-900 via-purple-900 to-blue-900 p-8 text-white shadow-2xl dark:border-gray-800">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-indigo-200">Systems dashboard</p>
                <h1 class="mt-3 text-3xl font-semibold lg:text-4xl">Log every platform that powers your sessions.</h1>
                <p class="mt-4 max-w-2xl text-sm text-indigo-100">Keep hardware notes, release years, and manufacturer details in one curated view.</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:w-1/2">
                <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-wider text-indigo-100">Platforms</p>
                    <p class="mt-2 text-3xl font-semibold">{{ $platforms->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-wider text-indigo-100">Games Linked</p>
                    <p class="mt-2 text-3xl font-semibold">{{ $totalGames }}</p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-wider text-indigo-100">Top Platform</p>
                    <p class="mt-2 text-base font-semibold">{{ optional($topPlatforms->first())->name ?? '—' }}</p>
                    <p class="text-xs text-indigo-100">{{ optional($topPlatforms->first())->games_count }} games</p>
                </div>
            </div>
        </div>
    </section>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-gray-200 bg-white/80 p-6 shadow-xl ring-1 ring-gray-100 backdrop-blur dark:border-gray-800 dark:bg-gray-900 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Add New Platform</h2>
                <span class="text-xs uppercase tracking-[0.25em] text-gray-400">Hardware intake</span>
            </div>
            <form action="{{ route('platforms.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Platform Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nintendo Switch" required
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-gray-900 dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-100">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Photo (JPG/PNG, max 2MB)</label>
                    <input type="file" name="photo" accept="image/jpeg,image/png"
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-gray-900 dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Manufacturer</label>
                    <input type="text" name="manufacturer" value="{{ old('manufacturer') }}" placeholder="Nintendo"
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-gray-900 dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year') }}" placeholder="2017"
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-gray-900 dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-100">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" rows="3" placeholder="Hybrid handheld and dockable home console."
                              class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 text-gray-900 dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-100">{{ old('description') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 text-sm font-semibold text-white transition hover:shadow-lg hover:shadow-indigo-600/30">
                        <span>Save platform</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-800 dark:bg-gray-950">
            <p class="text-sm text-gray-900 dark:text-gray-100">Collection Overview</p>
            <h2 class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $platforms->count() }} Platforms</h2>
            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $totalGames }} games catalogued</p>
            <div class="mt-6 space-y-3">
                @forelse ($topPlatforms as $platform)
                    <div class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm dark:border-gray-800">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $platform->name }}</p>
                            <p class="text-xs text-gray-700 dark:text-gray-300">{{ $platform->manufacturer ?? 'Unknown' }}</p>
                        </div>
                        <span class="text-xs font-semibold text-gray-900 dark:text-gray-100">{{ $platform->games_count }} games</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-900 dark:text-gray-100">Add a platform to see stats.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-200 bg-white/90 p-6 shadow-xl dark:border-gray-800 dark:bg-gray-950">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h2 class="text-lg font-semibold">Platforms Directory</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage every system in your collection</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('platforms.export-pdf', request()->query()) }}" 
                   class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export PDF
                </a>
                <span class="rounded-full bg-gray-100 px-4 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">{{ $platforms->count() }} total</span>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <form method="GET" action="{{ route('platforms.index') }}" class="mb-6 flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, manufacturer, or description..."
                       class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
            <button type="submit" 
                    class="rounded-2xl bg-indigo-600 px-6 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('platforms.index') }}" 
                   class="rounded-2xl border border-gray-200 bg-white px-6 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Clear Filters
                </a>
            @endif
        </form>

        <div class="mt-6 overflow-hidden rounded-2xl border border-gray-100 shadow-sm dark:border-gray-800">
            <table class="min-w-full divide-y divide-gray-100 text-sm dark:divide-gray-800">
                <thead class="bg-gray-50/70 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Photo</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Platform</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Manufacturer</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Year</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Games</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white/70 dark:divide-gray-900 dark:bg-gray-950/40">
                    @forelse ($platforms as $platform)
                        <tr class="transition hover:bg-gray-50/70 dark:hover:bg-gray-900/60">
                            <td class="px-4 py-4 text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4">
                                @if($platform->photo)
                                    <img src="{{ asset('storage/' . $platform->photo) }}" alt="{{ $platform->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-xs font-semibold text-white">
                                        {{ $platform->initials() }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $platform->name }}</p>
                                @if ($platform->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($platform->description, 60) }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">{{ $platform->manufacturer ?? 'N/A' }}</td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">{{ $platform->release_year ?? '—' }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                    {{ $platform->games_count }} games
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <div x-data="{ open: false }" class="inline-block">
                                        <button type="button" @click="open = true"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">Edit</button>
                                        <div x-cloak x-show="open" x-transition
                                             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                                            <div class="w-full max-w-lg rounded-3xl bg-white p-6 dark:bg-gray-900">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-lg font-semibold">Edit {{ $platform->name }}</h3>
                                                    <button type="button" @click="open = false" class="text-gray-500 hover:text-gray-700">×</button>
                                                </div>
                                                <form method="POST" action="{{ route('platforms.update', $platform) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Platform Name</label>
                                                        <input type="text" name="name" value="{{ $platform->name }}" required
                                                               class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                    </div>
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Photo (JPG/PNG, max 2MB)</label>
                                                        @if($platform->photo)
                                                            <div class="mb-2">
                                                                <img src="{{ asset('storage/' . $platform->photo) }}" alt="{{ $platform->name }}" class="h-16 w-16 rounded-full object-cover">
                                                            </div>
                                                        @endif
                                                        <input type="file" name="photo" accept="image/jpeg,image/png"
                                                               class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                    </div>
                                                    <div class="grid gap-4 md:grid-cols-2">
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Manufacturer</label>
                                                            <input type="text" name="manufacturer" value="{{ $platform->manufacturer }}"
                                                                   class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                        </div>
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Release Year</label>
                                                            <input type="number" name="release_year" value="{{ $platform->release_year }}"
                                                                   class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                                        <textarea name="description" rows="3"
                                                                  class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ $platform->description }}</textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end gap-3">
                                                        <button type="button" @click="open = false" class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 dark:border-gray-700 dark:text-gray-300">Cancel</button>
                                                        <button type="submit" class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('platforms.destroy', $platform) }}" onsubmit="return confirm('Move this platform to trash? You can restore it later.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
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





