@extends('layouts.eo')

@section('title','Detail Formasi')

<h2 class="text-xl font-bold mb-4">
    {{ $lineup->club->name }} – {{ $lineup->match_name }}
</h2>

<div class="grid grid-cols-2 gap-4">

@if($lineup->status=='submitted')
<div class="flex gap-3 mb-4">

<form method="POST" action="{{ route('eo.lineups.approve',$lineup) }}">
    @csrf
    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Approve
    </button>
</form>

<form method="POST" action="{{ route('eo.lineups.request',$lineup) }}">
    @csrf
    <input name="eo_note"
           placeholder="Alasan revisi"
           class="border px-3 py-2 rounded">
    <button class="bg-red-600 text-white px-4 py-2 rounded">
        Request Revisi
    </button>
</form>

</div>
@endif


<div class="relative bg-green-600 h-[500px] rounded overflow-hidden">

    <!-- Garis luar -->
    <div class="absolute inset-2 border-2 border-white"></div>

    <!-- Garis tengah -->
    <div class="absolute top-1/2 left-0 w-full border-t-2 border-white"></div>

    <!-- Lingkar tengah -->
    <div class="absolute top-1/2 left-1/2 w-24 h-24 border-2 border-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>

    <!-- Kotak penalti kiri -->
    <div class="absolute left-2 top-1/2 w-24 h-48 border-2 border-white -translate-y-1/2"></div>

    <!-- Kotak penalti kanan -->
    <div class="absolute right-2 top-1/2 w-24 h-48 border-2 border-white -translate-y-1/2"></div>

    <!-- Titik penalti kiri -->
    <div class="absolute left-24 top-1/2 w-2 h-2 bg-white rounded-full -translate-y-1/2"></div>

    <!-- Titik penalti kanan -->
    <div class="absolute right-24 top-1/2 w-2 h-2 bg-white rounded-full -translate-y-1/2"></div>

@foreach($lineup->players->where('role','starter') as $p)
<div class="absolute bg-blue-700 text-white px-3 py-1 rounded"
     style="left:{{ $p->x }}px; top:{{ $p->y }}px">
    {{ $p->player->name }}
</div>
@endforeach

</div>

<div class="bg-white p-4 rounded shadow">
<h3 class="font-semibold mb-2">Cadangan</h3>

@foreach($lineup->players->where('role','bench') as $p)
    <div class="border-b py-1">{{ $p->player->name }}</div>
@endforeach

</div>

</div>
@endsection
