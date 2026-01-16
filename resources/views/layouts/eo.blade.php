<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','EO Panel - ASSBI')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-background font-sans">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-primary text-white flex flex-col">

        {{-- BRAND --}}
        <div class="p-5 text-lg font-bold border-b border-white/10 flex items-center gap-2">
            🏆 <span>EO Panel</span>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 p-4 space-y-1 text-sm">

            @php
                $isActive = fn($route) =>
                    request()->routeIs($route)
                        ? 'bg-white/10'
                        : '';

                $activeTournament = \App\Models\Tournament::where(
                    'event_organizer_id',
                    auth()->user()->eventOrganizer->id
                )->where('status','published')->latest()->first();
            @endphp

            {{-- DASHBOARD --}}
            <a href="{{ route('eo.dashboard') }}"
            class="flex items-center px-4 py-2 rounded-lg transition hover:bg-white/10 {{ $isActive('eo.dashboard') }}">
                📊 <span class="ml-3">Dashboard</span>
            </a>

            {{-- TOURNAMENT LIST --}}
            <a href="{{ route('eo.tournaments.index') }}"
            class="flex items-center px-4 py-2 rounded-lg transition hover:bg-white/10 {{ $isActive('eo.tournaments.*') }}">
                🏆 <span class="ml-3">Turnamen Saya</span>
            </a>

            {{-- SECTION TITLE --}}
            <div class="pt-3 mt-3 border-t border-white/10 text-xs uppercase tracking-wider text-white/60 px-4">
                Turnamen Aktif
            </div>

            {{-- MATCH --}}
            @if($activeTournament)
                <a href="{{ route('eo.tournaments.matches', $activeTournament) }}"
                class="flex items-center px-4 py-2 rounded-lg transition hover:bg-white/10">
                    ⚽ <span class="ml-3">Match</span>
                </a>
            @else
                <div class="flex items-center px-4 py-2 text-white/40 cursor-not-allowed">
                    ⚽ <span class="ml-3">Match</span>
                    <span class="ml-auto text-xs italic">Belum ada</span>
                </div>
            @endif

            {{-- STANDINGS --}}
            @if($activeTournament)
                <a href="{{ route('eo.tournaments.standings', $activeTournament) }}"
                class="flex items-center px-4 py-2 rounded-lg transition hover:bg-white/10">
                    📋 <span class="ml-3">Klasemen</span>
                </a>
            @else
                <div class="flex items-center px-4 py-2 text-white/40 cursor-not-allowed">
                    📋 <span class="ml-3">Klasemen</span>
                    <span class="ml-auto text-xs italic">Belum ada</span>
                </div>
            @endif

        </nav>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">

            <h1 class="text-lg font-semibold text-primary">
                @yield('page_title','Dashboard')
            </h1>

            <div class="flex items-center gap-4">

                {{-- USER NAME --}}
                <div class="text-sm text-muted font-medium">
                    {{ auth()->user()->name }}
                </div>

                {{-- LOGOUT BUTTON --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="inline-flex items-center gap-2
                            bg-danger text-white
                            px-4 py-2 rounded-lg
                            text-sm font-semibold
                            hover:bg-danger/90 transition">
                            Logout
                    </button>
                </form>


            </div>

        </header>


        {{-- CONTENT --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>
</div>

@stack('scripts')

</body>
</html>
