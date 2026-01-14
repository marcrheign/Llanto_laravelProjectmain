@extends('layouts.app')

@section('title', 'Trash - Platforms')

@section('content')
<div class="space-y-8">
    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-gradient-to-br from-red-900 via-orange-900 to-amber-900 p-8 text-white shadow-2xl dark:border-gray-800">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-red-200">Trash Management</p>
                <h1 class="mt-3 text-3xl font-semibold lg:text-4xl">Deleted Platforms</h1>
                <p class="mt-4 max-w-2xl text-sm text-red-100">Restore or permanently delete platforms from your collection.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('platforms.index') }}" 
                   class="rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/20">
                    Back to Platforms
                </a>
            </div>
        </div>
    </section>

    <div class="rounded-3xl border border-gray-200 bg-white/90 p-6 shadow-xl dark:border-gray-800 dark:bg-gray-950">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h2 class="text-lg font-semibold">Trash Bin</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $platforms->count() }} deleted platform(s)</p>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-gray-100 shadow-sm dark:border-gray-800">
            <table class="min-w-full divide-y divide-gray-100 text-sm dark:divide-gray-800">
                <thead class="bg-gray-50/70 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Photo</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Platform</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Manufacturer</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Games</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Deleted At</th>
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
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-red-500 to-orange-600 text-xs font-semibold text-white">
                                        {{ $platform->initials() }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $platform->name }}</p>
                            </td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">{{ $platform->manufacturer ?? 'N/A' }}</td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">{{ $platform->games_count }} games</td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">{{ $platform->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <form method="POST" action="{{ route('platforms.restore', $platform->id) }}" onsubmit="return confirm('Restore this platform?');">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                            Restore
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('platforms.force-delete', $platform->id) }}" onsubmit="return confirm('Permanently delete this platform? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            Delete Forever
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Trash bin is empty. No deleted platforms.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

