@extends('layouts.club')
@section('title','Edit Pemain')

@section('content')

 @if($player->kta_path)

<div class="mb-4 p-4 bg-gray-50 border rounded-lg flex items-center gap-4">

    <img src="{{ asset('storage/'.$player->kta_path) }}"
         class="h-40 border rounded shadow">

    <div>
        <div class="font-semibold text-gray-700">
            Nomor KTA
        </div>

        <div class="text-sm text-gray-600 mb-2">
            {{ $player->kta_number }}
        </div>

        <a href="{{ asset('storage/'.$player->kta_path) }}"
           target="_blank"
           class="inline-block bg-green-600 text-white px-4 py-2 rounded text-sm">
            Download KTA
        </a>
    </div>

</div>

@else

<div class="mb-4 p-4 bg-yellow-50 border border-yellow-300 rounded-lg text-sm text-yellow-800">
    KTA belum tersedia.
</div>

@if($player->photo)
<form method="POST" action="{{ route('club.players.generateKta',$player) }}">
    @csrf
    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Generate KTA
    </button>
</form>
@endif

@endif

<form method="POST"
      action="{{ route('club.players.update',$player) }}"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-xl">

@csrf
@method('PUT')

@include('club.players.form')

@if($player->photo)
<img src="{{ asset('storage/'.$player->photo) }}"
     class="w-24 mt-4 rounded">
@endif

<button class="bg-green-600 text-white px-4 py-2 rounded mt-4">
    Update
</button>
</form>
@endsection
