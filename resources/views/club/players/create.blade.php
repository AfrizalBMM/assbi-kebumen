@extends('layouts.club')
@section('title','Tambah Pemain')

@section('content')
<form method="POST"
      action="{{ route('club.players.store') }}"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-xl">

@csrf

@include('club.players.form')

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan
</button>
</form>
@endsection
