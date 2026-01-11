<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login — ASSBI Kebumen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 flex items-center justify-center px-4">

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">

    {{-- Header --}}
    <div class="bg-blue-900 text-white p-6 text-center">
        <h1 class="text-2xl font-bold">ASSBI Kebumen</h1>
        <p class="text-sm text-blue-200 mt-1">
            Sistem Resmi Kompetisi & Pembinaan SSB
        </p>
    </div>

    {{-- Body --}}
    <div class="p-6">

        {{-- Session Status --}}
        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input type="password"
                       name="password"
                       required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember --}}
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                           name="remember"
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    Ingat saya
                </label>

                <a href="{{ route('password.request') }}"
                   class="text-blue-700 hover:underline">
                    Lupa password?
                </a>
            </div>

            {{-- Button --}}
            <button type="submit"
                class="w-full bg-blue-800 hover:bg-blue-900 text-white py-3 rounded-lg font-semibold transition">
                Masuk
            </button>
        </form>

        {{-- Register --}}
        <div class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun?
            <div class="flex justify-center gap-3 mt-3">
                <a href="/register/club"
                   class="px-4 py-2 border border-blue-800 text-blue-800 rounded hover:bg-blue-50">
                    Daftar Club
                </a>
                <a href="/register/eo"
                   class="px-4 py-2 border border-yellow-500 text-yellow-600 rounded hover:bg-yellow-50">
                    Daftar EO
                </a>
            </div>
        </div>

    </div>
</div>

</body>
</html>
