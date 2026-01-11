@extends('layouts.eo')
@section('title','Edit Turnamen')

@section('content')
<form method="POST"
      action="{{ route('eo.tournaments.update',$tournament) }}"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-xl">

@csrf
@method('PUT')

@include('eo.tournaments.partials.form')

@if($tournament->regulation_pdf)
<div class="mb-3">
    <a href="{{ asset('storage/'.$tournament->regulation_pdf) }}"
       target="_blank"
       class="text-blue-600 underline text-sm">
        Lihat Regulasi PDF
    </a>
</div>
@endif

<button class="bg-yellow-600 text-white px-4 py-2 rounded">
    Update
</button>
</form>
@endsection
