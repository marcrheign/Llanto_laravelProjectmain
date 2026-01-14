<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Game Vault')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none !important;}</style>
</head>
<body class="bg-gradient-to-br from-gray-950 via-slate-900 to-blue-950 text-gray-100 antialiased">
    <div class="pointer-events-none fixed inset-0 -z-10 opacity-70 blur-[120px]" aria-hidden="true">
        <div class="absolute -top-32 left-1/2 h-80 w-80 -translate-x-1/2 rounded-full bg-blue-400/30"></div>
        <div class="absolute top-10 left-10 h-72 w-72 rounded-full bg-purple-400/20"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-indigo-400/20"></div>
    </div>
    <div class="min-h-screen">
        <div class="flex min-h-screen flex-col md:flex-row text-gray-100">
            <aside class="md:w-64 border-r border-white/5 bg-white/5 backdrop-blur-xl">
                <div class="flex h-full flex-col p-6">
                    <div class="mb-10">
                        <div class="text-2xl font-bold text-blue-600">Game Vault</div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track your collection</p>
                    </div>

                    <nav class="flex-1 space-y-2 text-gray-200">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition
                           {{ request()->routeIs('dashboard') ? 'bg-blue-600/20 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                            <span class="h-2 w-2 rounded-full bg-current/80"></span>
                            Dashboard
                        </a>
                        <a href="{{ route('platforms.index') }}"
                           class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition
                           {{ request()->routeIs('platforms.index') || request()->routeIs('platforms.store') || request()->routeIs('platforms.update') ? 'bg-blue-600/20 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                            <span class="h-2 w-2 rounded-full bg-current/80"></span>
                            Platforms
                        </a>
                        <div class="pt-4 mt-4 border-t border-white/10">
                            <p class="px-4 mb-2 text-xs uppercase tracking-wider text-gray-400">Trash</p>
                            <a href="{{ route('games.trash') }}"
                               class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition
                               {{ request()->routeIs('games.trash') ? 'bg-red-600/20 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                <span class="h-2 w-2 rounded-full bg-current/80"></span>
                                Games Trash
                            </a>
                            <a href="{{ route('platforms.trash') }}"
                               class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition
                               {{ request()->routeIs('platforms.trash') ? 'bg-red-600/20 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                <span class="h-2 w-2 rounded-full bg-current/80"></span>
                                Platforms Trash
                            </a>
                        </div>
                    </nav>

                    <div class="mt-10 rounded-lg border border-white/10 bg-white/5 p-4 text-sm text-gray-100">
                        <p class="font-semibold">{{ auth()->user()?->name ?? 'Player One' }}</p>
                        <p class="text-gray-500 dark:text-gray-400">{{ auth()->user()?->email ?? 'demo@example.com' }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                    class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-500">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="flex-1">
                <header class="flex items-center justify-between border-b border-white/10 bg-white/10 px-6 py-4 backdrop-blur md:hidden">
                    <div>
                        <p class="text-sm text-gray-300">Welcome back</p>
                        <h1 class="text-xl font-semibold">{{ auth()->user()?->name ?? 'Player One' }}</h1>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white">
                            Logout
                        </button>
                    </form>
                </header>

                <main class="p-6 md:p-10 text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                            <p class="font-semibold">Please fix the following:</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>

