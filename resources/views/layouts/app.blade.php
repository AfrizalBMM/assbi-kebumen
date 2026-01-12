<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ASSBI Kebumen') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-background text-slate-900">

<div class="min-h-screen flex flex-col">

    @include('layouts.navigation')

    @if (isset($header))
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-4 px-6">
                <h1 class="text-lg font-semibold text-primary">
                    {{ $header }}
                </h1>
            </div>
        </header>
    @endif

    <main class="flex-1">
        {{ $slot }}
    </main>

</div>

</body>
</html>
