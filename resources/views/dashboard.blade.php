@extends('layouts.app')

@section('title', 'Game Dashboard')

@section('content')
@php
    $statusOptions = ['Backlog', 'Playing', 'Completed'];
    $statusStyles = [
        'Backlog' => ['chip' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-200', 'pill' => 'from-amber-500/20 to-amber-500/0 text-amber-600'],
        'Playing' => ['chip' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-200', 'pill' => 'from-blue-500/20 to-blue-500/0 text-blue-600'],
        'Completed' => ['chip' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200', 'pill' => 'from-emerald-500/20 to-emerald-500/0 text-emerald-600'],
    ];
@endphp
<div class="space-y-8">
    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-gradient-to-br from-gray-900 via-slate-900 to-blue-900 p-8 text-white shadow-2xl dark:border-gray-800">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Game Vault</p>
                <h1 class="mt-3 text-3xl font-semibold leading-tight lg:text-4xl">Stay on top of your backlog and celebrate every completion.</h1>
                <p class="mt-4 max-w-2xl text-sm text-blue-100">Track platforms, log progress, and keep your collection curated with a single dashboard experience.</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:w-1/2">
                <div class="rounded-2xl bg-white/5 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-wider text-blue-200">Games</p>
                    <p class="mt-2 text-3xl font-semibold">{{ $stats['totalGames'] }}</p>
                    <span class="text-xs text-blue-200">in collection</span>
                </div>
                <div class="rounded-2xl bg-white/5 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-wider text-blue-200">Platforms</p>
                    <p class="mt-2 text-3xl font-semibold">{{ $stats['totalPlatforms'] }}</p>
                    <span class="text-xs text-blue-200">tracked systems</span>
                </div>
                <div class="rounded-2xl bg-white/5 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-wider text-blue-200">Completed</p>
                    <p class="mt-2 text-3xl font-semibold">{{ $stats['completedGames'] }}</p>
                    <span class="text-xs text-blue-200">finished titles</span>
                </div>
            </div>
        </div>
    </section>

    <div class="flex flex-wrap gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Status overview</p>
        @foreach($statusOptions as $status)
            <span class="inline-flex items-center gap-2 rounded-full px-4 py-1 text-xs font-semibold {{ $statusStyles[$status]['chip'] }}">
                <span class="h-2 w-2 rounded-full bg-current"></span>
                {{ $status }}
                <span class="text-[11px] font-normal text-gray-500 dark:text-gray-300">({{ $games->where('status', $status)->count() }})</span>
            </span>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-gray-200 bg-white/80 p-6 shadow-xl ring-1 ring-gray-100 backdrop-blur dark:border-gray-800 dark:bg-gray-900 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Add New Game</h2>
                <span class="text-xs uppercase tracking-[0.25em] text-gray-400">Backlog input</span>
            </div>
            <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <div class="md:col-span-2">
                    <label class="mb-2 flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-blue-600">Required</span>
                        Title
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Elden Ring" required
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 text-gray-900 dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-100">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Photo (JPG/PNG, max 2MB)</label>
                    <input type="file" name="photo" accept="image/jpeg,image/png"
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 text-gray-900 dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Genre</label>
                    <input type="text" name="genre" value="{{ old('genre') }}" placeholder="Action-adventure"
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year') }}" placeholder="2024"
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100">
                        @foreach ($statusOptions as $status)
                            <option value="{{ $status }}" @selected(old('status', 'Backlog') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Platform</label>
                    <select name="platform_id"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100">
                        <option value="">Select platform (optional)</option>
                        @foreach ($platforms as $platform)
                            <option value="{{ $platform->id }}" @selected(old('platform_id') == $platform->id)>{{ $platform->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                    <textarea name="notes" rows="3" placeholder="Where did you leave off?"
                              class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100">{{ old('notes') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:shadow-lg hover:shadow-blue-600/30">
                        Add title to vault
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-800 dark:bg-gray-950">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Recently Added</h2>
                <span class="text-xs text-gray-400">Timeline</span>
            </div>
            <ul class="mt-4 space-y-4">
                @forelse ($recentGames as $recent)
                    <li class="relative rounded-2xl border border-gray-200/80 p-4 pl-5 dark:border-gray-800">
                        <span class="absolute left-2 top-5 h-2 w-2 rounded-full bg-blue-500"></span>
                        <p class="text-sm text-gray-400">{{ $recent->created_at->diffForHumans() }}</p>
                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $recent->title }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $recent->platform?->name ?? 'Platform N/A' }} · <span class="font-medium">{{ $recent->status }}</span>
                        </p>
                    </li>
                @empty
                    <li class="rounded-2xl border border-dashed border-gray-300 p-4 text-center text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                        No games logged yet. Add one to get started!
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-200 bg-white/90 p-6 shadow-xl dark:border-gray-800 dark:bg-gray-950">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h2 class="text-lg font-semibold">Game Library</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">A snapshot of every title you track</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('games.export-pdf', request()->query()) }}" 
                   class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export PDF
                </a>
                <span class="rounded-full bg-gray-100 px-4 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">{{ $games->count() }} titles</span>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <form method="GET" action="{{ route('dashboard') }}" class="mb-6 flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, genre, or notes..."
                       class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>
            <div class="min-w-[180px]">
                <select name="platform_id" 
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <option value="">All Platforms</option>
                    @foreach ($platforms as $platform)
                        <option value="{{ $platform->id }}" @selected(request('platform_id') == $platform->id)>{{ $platform->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" 
                    class="rounded-2xl bg-blue-600 px-6 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                Search
            </button>
            @if(request('search') || request('platform_id'))
                <a href="{{ route('dashboard') }}" 
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
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Title</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Genre</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Platform</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Year</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white/70 dark:divide-gray-900 dark:bg-gray-950/40">
                    @forelse ($games as $game)
                        <tr class="transition hover:bg-gray-50/70 dark:hover:bg-gray-900/60">
                            <td class="px-4 py-4 text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4">
                                @if($game->photo)
                                    <img src="{{ asset('storage/' . $game->photo) }}" alt="{{ $game->title }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-xs font-semibold text-white">
                                        {{ $game->initials() }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $game->title }}</p>
                                @if($game->notes)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($game->notes, 60) }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">{{ $game->genre ?? 'N/A' }}</td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">{{ $game->platform->name ?? 'N/A' }}</td>
                            <td class="px-4 py-4">
                                @php($style = $statusStyles[$game->status] ?? $statusStyles['Backlog'])
                                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r {{ $style['pill'] }} px-3 py-1 text-xs font-semibold">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                    {{ $game->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">{{ $game->release_year ?? '—' }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-4">
                                    <div x-data="{ open: false }" class="inline-block text-left">
                                        <button type="button" @click="open = true"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                            Edit
                                        </button>
                                        <div x-cloak x-show="open"
                                             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                             x-transition>
                                            <div class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-2xl dark:bg-gray-900">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-lg font-semibold">Edit {{ $game->title }}</h3>
                                                    <button type="button" @click="open = false" class="text-gray-500 hover:text-gray-700">×</button>
                                                </div>
                                                <form method="POST" action="{{ route('games.update', $game) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                                        <input type="text" name="title" value="{{ $game->title }}" required
                                                               class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                    </div>
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Photo (JPG/PNG, max 2MB)</label>
                                                        @if($game->photo)
                                                            <div class="mb-2">
                                                                <img src="{{ asset('storage/' . $game->photo) }}" alt="{{ $game->title }}" class="h-16 w-16 rounded-full object-cover">
                                                            </div>
                                                        @endif
                                                        <input type="file" name="photo" accept="image/jpeg,image/png"
                                                               class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                    </div>
                                                    <div class="grid gap-4 md:grid-cols-2">
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Genre</label>
                                                            <input type="text" name="genre" value="{{ $game->genre }}"
                                                                   class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                        </div>
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Release Year</label>
                                                            <input type="number" name="release_year" value="{{ $game->release_year }}"
                                                                   class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                        </div>
                                                    </div>
                                                    <div class="grid gap-4 md:grid-cols-2">
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                                            <select name="status" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                                @foreach ($statusOptions as $status)
                                                                    <option value="{{ $status }}" @selected($game->status === $status)>{{ $status }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Platform</label>
                                                            <select name="platform_id" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                                <option value="">Select platform (optional)</option>
                                                                @foreach ($platforms as $platform)
                                                                    <option value="{{ $platform->id }}" @selected($game->platform_id === $platform->id)>{{ $platform->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                                        <textarea name="notes" rows="3"
                                                                  class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ $game->notes }}</textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end gap-3">
                                                        <button type="button" @click="open = false" class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 dark:border-gray-700 dark:text-gray-300">Cancel</button>
                                                        <button type="submit" class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('games.destroy', $game) }}" onsubmit="return confirm('Move this game to trash? You can restore it later.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                No games tracked yet. Add your first game above!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection