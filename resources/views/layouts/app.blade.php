<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100 text-slate-900">
<div class="min-h-screen flex">

    <aside class="hidden md:flex md:w-64 md:flex-col bg-slate-950 text-white">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <a href="{{ route('dashboard') }}"
               class="text-lg font-bold tracking-tight">
                Domain Monitor
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-1">

            <a href="{{ route('dashboard') }}"
               class="block rounded-xl px-4 py-3 text-sm font-medium transition
               {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Dashboard
            </a>

            <a href="{{ route('domains.index') }}"
               class="block rounded-xl px-4 py-3 text-sm font-medium transition
               {{ request()->routeIs('domains.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Domains
            </a>
        </nav>

        <div class="border-t border-slate-800 p-4">
            <div class="mb-3 text-sm text-slate-300">
                {{ Auth::user()->name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full rounded-xl px-4 py-2 text-left text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    Log out
                </button>
            </form>
        </div>
    </aside>

    <div class="min-w-0 flex-1">

        <header class="border-b border-slate-200 bg-white">
            <div class="flex h-16 items-center justify-between px-6 lg:px-8">

                <div>
                    <h1 class="text-xl font-semibold text-slate-900">
                        @yield('header')
                    </h1>
                </div>

            </div>
        </header>

        <main class="p-6 lg:p-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<div id="toast" style="display: none;"></div>

</body>
</html>
