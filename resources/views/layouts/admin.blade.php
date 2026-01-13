<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Admin ASSBI')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-background text-slate-800 font-sans">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-primary text-white flex flex-col shadow-lg">

        <div class="p-4 flex items-center gap-3 border-b border-white/10">
            <img
                src="{{ asset('assets/logo-assbi.png') }}"
                alt="ASSBI Logo"
                class="w-10 h-10 object-contain"
            >

            <div class="leading-tight">
                <div class="text-lg font-bold">ASSBI</div>
                <div class="text-xs text-white/70">ADMIN PANEL</div>
            </div>
        </div>


        <nav class="flex-1 p-4 space-y-1 text-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                📊 <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                👤 <span>User</span>
            </a>

            <a href="{{ route('admin.clubs.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                🏟️ <span>Club</span>
            </a>

            <a href="{{ route('admin.players.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                🧍 <span>Players</span>
            </a>


            <a href="{{ route('admin.event-organizers.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                🧑‍💼 <span>EO</span>
            </a>

            <a href="{{ route('admin.tournaments.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                🏆 <span>Turnamen</span>
            </a>

            <a href="{{ route('admin.banners.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                🖼 <span>Banner</span>
            </a>

            <a href="{{ route('admin.posts.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                📰 <span>Berita</span>
            </a>

            <a href="{{ route('admin.activity.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                📜 <span>Activity Log</span>
            </a>

        </nav>

    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-primary">
                @yield('page_title','Dashboard')
            </h1>

        <div class="flex items-center gap-4 text-sm">

            <div class="text-right">
                <div class="font-semibold text-gray-700">
                    {{ auth()->user()->name }}
                </div>
                <div class="text-xs text-gray-400">
                    ADMIN
                </div>
            </div>

            <form method="POST" action="/logout">
                @csrf
                <button
                    type="submit"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg bg-danger text-white hover:bg-danger/90 transition text-sm"
                >
                Logout
                </button>
            </form>

        </div>

        </header>

        {{-- Content --}}
        <main class="flex-1 p-6 overflow-y-auto bg-background">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
