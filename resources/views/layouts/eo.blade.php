<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Admin ASSBI')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-[#0A1F44] text-white flex flex-col">
        <div class="p-5 text-xl font-bold border-b border-blue-800">
            Event Organizer
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm">

        {{-- sidebar menu EO --}}
        <a href="{{ route('eo.dashboard') }}">Dashboard</a>
        <a href="{{ route('eo.tournaments.index') }}">Turnamen Saya</a>
        <a href="{{ route('eo.tournaments.matches',1) }}">Match</a>
        <a href="{{ route('eo.tournaments.standings',1) }}">Klasemen</a>


        </nav>

        <div class="p-4 border-t border-blue-800">
            <form method="POST" action="/logout">
                @csrf
                <button class="w-full bg-red-600 py-2 rounded text-sm hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-blue-900">
                @yield('page_title','Dashboard')
            </h1>

            <div class="text-sm text-gray-600">
                {{ auth()->user()->name }}
            </div>
        </header>

        {{-- Content --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
