@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
<h1 class="text-2xl font-bold mb-6">SSB & Club ASSBI Kebumen</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
@foreach($clubs as $club)
<a href="/clubs/{{ $club->slug }}"
   class="bg-white p-4 shadow rounded text-center hover:shadow-lg">
    <img src="{{ $club->logo
        ? asset('storage/'.$club->logo)
        : asset('img/club-default.png') }}"
         class="w-20 h-20 mx-auto mb-2 object-contain">
    <div class="font-semibold text-sm">{{ $club->name }}</div>
</a>
@endforeach
</div>
</div>


{{ $clubs->links() }}
@endsection
