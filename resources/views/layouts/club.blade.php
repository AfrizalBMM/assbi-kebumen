<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Club ASSBI')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-[#0A1F44] text-white flex flex-col">

        <div class="p-5 text-xl font-bold border-b border-blue-800">
            🏟️ CLUB / SSB
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm">

            <a href="{{ route('club.dashboard') }}"
            class="block px-4 py-2 rounded hover:bg-blue-800 transition">
                📊 Dashboard
            </a>

            <a href="{{ route('club.profile') }}"
            class="block px-4 py-2 rounded hover:bg-blue-800 transition">
                📝 Profil Club
            </a>

            <a href="{{ route('club.players.index') }}"
            class="block px-4 py-2 rounded hover:bg-blue-800 transition">
                👥 Data Pemain
            </a>

            <a href="{{ route('club.lineups.index') }}"
            class="block px-4 py-2 rounded hover:bg-blue-800 transition">
                ⚽ Formasi
            </a>

            <a href="{{ route('club.tournaments.index') }}"
            class="block px-4 py-2 rounded hover:bg-blue-800 transition">
                🏆 Daftar Turnamen
            </a>

        </nav>


        {{-- Logout --}}
        <div class="p-4 border-t border-blue-800">
            <form method="POST" action="/logout">
                @csrf
                <button class="w-full bg-red-600 py-2 rounded text-sm hover:bg-red-700 transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN AREA --}}
    <div class="flex-1 flex flex-col">

        {{-- TOP BAR --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-blue-900">
                @yield('page_title','Dashboard Club')
            </h1>

            <div class="text-sm text-gray-600 flex items-center gap-3">
                <span>{{ auth()->user()->name }}</span>
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                    CLUB
                </span>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 bg-gray-100 overflow-hidden">
            <div class="w-full h-full overflow-auto px-6 py-4">
                @yield('content')
            </div>
        </main>

    </div>

</div>

</body>
</html>
