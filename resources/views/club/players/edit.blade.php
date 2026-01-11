@extends('layouts.club')
@section('title','Edit Pemain')

@section('content')
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
