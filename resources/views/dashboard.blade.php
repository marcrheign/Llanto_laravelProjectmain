@extends('layouts.app')

@section('title', 'Game Dashboard')

@section('content')
<div class="space-y-8">
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/40 dark:text-blue-200">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Games</p>
                        <h2 class="text-3xl font-bold">{{ $stats['totalGames'] }}</h2>
                    </div>
                </div>
                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/40 dark:text-blue-200">
                    Collection
                </span>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-200">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                            <circle cx="12" cy="7" r="3"></circle>
                            <path d="M5 21v-4a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3v4"></path>
                            <path d="M4 21h16"></path>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Platforms Tracked</p>
                        <h2 class="text-3xl font-bold">{{ $stats['totalPlatforms'] }}</h2>
                    </div>
                </div>
                <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                    Systems
                </span>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-200">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Games Completed</p>
                        <h2 class="text-3xl font-bold">{{ $stats['completedGames'] }}</h2>
                    </div>
                </div>
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200">
                    Progress
                </span>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950 lg:col-span-2">
            <h2 class="mb-4 text-lg font-semibold">Add New Game</h2>
            <form action="{{ route('games.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                @csrf
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Genre</label>
                    <input type="text" name="genre" value="{{ old('genre') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    @php($statuses = ['Backlog', 'Playing', 'Completed'])
                    <select name="status" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', 'Backlog') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Platform</label>
                    <select name="platform_id" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Select platform (optional)</option>
                        @foreach ($platforms as $platform)
                            <option value="{{ $platform->id }}" @selected(old('platform_id') == $platform->id)>{{ $platform->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('notes') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="w-full rounded-lg bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-gray-900/30 transition hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-500/40">
                        Add Game
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <h2 class="mb-4 text-lg font-semibold">Recently Added</h2>
            <ul class="space-y-4">
                @forelse ($recentGames as $recent)
                    <li class="rounded-lg border border-gray-200 p-4 dark:border-gray-800">
                        <p class="font-medium">{{ $recent->title }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $recent->platform?->name ?? 'Platform N/A' }} • {{ $recent->status }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $recent->created_at->diffForHumans() }}</p>
                    </li>
                @empty
                    <li class="rounded-lg border border-dashed border-gray-300 p-4 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                        No games logged yet. Add one to get started!
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold">Game Library</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Every game you have tracked</p>
            </div>
            <span class="text-sm text-gray-500">{{ $games->count() }} total</span>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Genre</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Platform</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Year</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($games as $game)
                        <tr class="text-sm">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                <p class="font-semibold">{{ $game->title }}</p>
                                @if($game->notes)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($game->notes, 60) }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $game->genre ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $game->platform->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold
                                    @class([
                                        'bg-amber-100 text-amber-700' => $game->status === 'Backlog',
                                        'bg-blue-100 text-blue-700' => $game->status === 'Playing',
                                        'bg-emerald-100 text-emerald-700' => $game->status === 'Completed',
                                        'dark:bg-gray-800 dark:text-gray-300' => true,
                                    ])">
                                    {{ $game->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $game->release_year ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div x-data="{ open: false }" class="inline-block">
                                        <button type="button" @click="open = true"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                            Edit
                                        </button>
                                        <div x-cloak x-show="open"
                                             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                             x-transition>
                                            <div class="w-full max-w-xl rounded-2xl bg-white p-6 dark:bg-gray-900">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-lg font-semibold">Edit {{ $game->title }}</h3>
                                                    <button type="button" @click="open = false" class="text-gray-500 hover:text-gray-700">×</button>
                                                </div>
                                                <form method="POST" action="{{ route('games.update', $game) }}" class="mt-6 space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                                        <input type="text" name="title" value="{{ $game->title }}" required
                                                               class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                    </div>
                                                    <div class="grid gap-4 md:grid-cols-2">
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Genre</label>
                                                            <input type="text" name="genre" value="{{ $game->genre }}"
                                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                        </div>
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Release Year</label>
                                                            <input type="number" name="release_year" value="{{ $game->release_year }}"
                                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                        </div>
                                                    </div>
                                                    <div class="grid gap-4 md:grid-cols-2">
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                                            <select name="status" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                                @foreach ($statuses as $status)
                                                                    <option value="{{ $status }}" @selected($game->status === $status)>{{ $status }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Platform</label>
                                                            <select name="platform_id" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
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
                                                                  class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ $game->notes }}</textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end gap-3">
                                                        <button type="button" @click="open = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 dark:border-gray-700 dark:text-gray-300">Cancel</button>
                                                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('games.destroy', $game) }}" onsubmit="return confirm('Remove this game?');">
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