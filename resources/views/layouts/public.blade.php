<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','ASSBI Kebumen')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 font-sans">

@include('public.partials.navbar')

{{-- OFFSET supaya tidak ketimpa navbar fixed --}}
<div class="pt-20 min-h-screen">

    @yield('content')

</div>

@include('public.partials.footer')

</body>
</html>
