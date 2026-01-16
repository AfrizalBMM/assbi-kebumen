@extends('layouts.eo')
@section('title','Detail Turnamen')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-xl">

<h2 class="text-lg font-semibold mb-2">{{ $tournament->name }}</h2>

<p>Kategori: {{ $tournament->category }}</p>
<p>Periode: {{ $tournament->start_date }} – {{ $tournament->end_date }}</p>
<p>Status: <strong>{{ strtoupper($tournament->status) }}</strong></p>

@if($tournament->regulation_pdf)
<a href="{{ asset('storage/'.$tournament->regulation_pdf) }}"
   target="_blank"
   class="inline-block mt-3 text-blue-600 underline">
    Download Regulasi
</a>
@endif

@if($tournament->status === 'draft')
<form method="POST"
      action="{{ route('eo.tournaments.publish',$tournament) }}"
      class="mt-4">
    @csrf
    <button class="bg-success text-white px-4 py-2 rounded-lg font-semibold">
        Publish Turnamen
    </button>
</form>
@endif



</div>
@endsection
