<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 - Halaman Tidak Ditemukan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

<div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6 sm:p-8 text-center border-t-8 border-primary">

    {{-- Logo --}}
    <img src="{{ asset('assets/logo-assbi.png') }}"
         class="w-16 sm:w-20 mx-auto mb-4"
         alt="ASSBI Logo">

    <p class="text-lg sm:text-xl font-semibold text-slate-800 mb-2">
        Halaman Tidak Ditemukan
    </p>

    <p class="text-sm sm:text-base text-muted mb-6">
        Maaf, halaman yang Anda cari tidak tersedia atau sudah dipindahkan.
    </p>

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-center">

        {{-- BACK BUTTON --}}
        <a href="{{ url()->previous() }}"
           onclick="if (document.referrer === '') history.back();"
           class="w-full sm:w-auto px-5 py-3 rounded-lg bg-primarySoft text-primary font-semibold hover:bg-primary/10 transition text-center">
            ← Kembali
        </a>

        {{-- HOME --}}
        <a href="{{ url('/') }}"
           class="w-full sm:w-auto px-5 py-3 rounded-lg bg-primary text-white font-semibold hover:bg-blue-900 transition text-center">
            🏠 Web Utama
        </a>

    </div>

</div>

</body>
</html>
