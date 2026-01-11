@extends('layouts.public')

@section('content')
<h1 class="text-2xl font-bold">{{ $club->name }}</h1>

<img src="{{ $club->logo_url ?? asset('img/default-club.png') }}"
     class="w-24 mb-3">

<p>Email: {{ $club->email }}</p>
<p>Telepon: {{ $club->phone }}</p>

<h2 class="mt-6 font-semibold">Daftar Pemain</h2>

<table class="w-full text-sm">
@foreach($club->players as $p)
<tr class="border-b">
    <td>
        <img src="{{ $p->photo_url ?? asset('img/default-player.png') }}"
             class="w-10 inline">
    </td>
    <td>
        <a href="/players/{{ $p->id }}"
           class="text-blue-600 hover:underline">
           {{ $p->name }}
        </a>
    </td>
    <td>
        {{-- Sensor tanggal lahir --}}
        {{ \Carbon\Carbon::parse($p->birth_date)->format('Y') }}
    </td>
@endforeach
</table>
@endsection
