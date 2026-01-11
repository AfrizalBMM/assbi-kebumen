@extends('layouts.public')

@section('content')
<h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>

@if($post->thumbnail)
<img src="{{ asset('storage/'.$post->thumbnail) }}"
     class="w-full max-h-96 object-cover my-4">
@endif

<div class="prose max-w-none">
{!! nl2br(e($post->content)) !!}
</div>
@endsection
