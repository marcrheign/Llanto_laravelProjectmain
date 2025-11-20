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
<body class="bg-gray-100 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100">
    <div class="min-h-screen">
        <div class="flex min-h-screen flex-col md:flex-row">
            <aside class="bg-white shadow-md dark:bg-gray-950 md:w-64">
                <div class="flex h-full flex-col p-6">
                    <div class="mb-10">
                        <div class="text-2xl font-bold text-blue-600">Game Vault</div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track your collection</p>
                    </div>

                    <nav class="flex-1 space-y-2">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition hover:bg-blue-50 hover:text-blue-600
                           {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-200' : 'text-gray-600 dark:text-gray-300' }}">
                            <span class="h-2 w-2 rounded-full bg-current"></span>
                            Dashboard
                        </a>
                        <a href="{{ route('platforms.index') }}"
                           class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition hover:bg-blue-50 hover:text-blue-600
                           {{ request()->routeIs('platforms.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-200' : 'text-gray-600 dark:text-gray-300' }}">
                            <span class="h-2 w-2 rounded-full bg-current"></span>
                            Platforms
                        </a>
                    </nav>

                    <div class="mt-10 rounded-lg bg-gray-100 p-4 text-sm dark:bg-gray-800">
                        <p class="font-semibold">{{ auth()->user()?->name ?? 'Player One' }}</p>
                        <p class="text-gray-500 dark:text-gray-400">{{ auth()->user()?->email ?? 'demo@example.com' }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                    class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="flex-1">
                <header class="flex items-center justify-between border-b border-gray-200 bg-white px-6 py-4 dark:border-gray-800 dark:bg-gray-950 md:hidden">
                    <div>
                        <p class="text-sm text-gray-500">Welcome back</p>
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

                <main class="p-6 md:p-10">
                    @if(session('success'))
                        <div class="mb-4 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-900 shadow-sm dark:border-green-800/60 dark:bg-green-900/20 dark:text-green-200">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-800/60 dark:text-green-200">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold">Success</p>
                                <p class="mt-1 text-sm">{{ session('success') }}</p>
                            </div>
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

