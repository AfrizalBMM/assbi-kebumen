@extends('layouts.public')

@section('content')
<h1 class="text-2xl font-bold mb-6">
{{ ucfirst($type) }}
</h1>

<div class="grid md:grid-cols-3 gap-6">
@foreach($posts as $p)
<div class="bg-white shadow rounded overflow-hidden">
    <img src="{{ asset('storage/'.$p->thumbnail) }}"
         class="w-full h-40 object-cover">

    <div class="p-4">
        <h2 class="font-semibold mb-2">{{ $p->title }}</h2>
        <a href="/{{ $type }}s/{{ $p->slug }}"
           class="text-blue-800 text-sm font-semibold">
            Baca →
        </a>
    </div>
</div>
@endforeach
</div>

<div class="mt-6">
{{ $posts->links() }}
</div>
@endsection
