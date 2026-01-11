@extends('layouts.eo')

<h2 class="text-xl font-bold mb-4">Banner Turnamen – {{ $tournament->name }}</h2>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('eo.tournaments.banners.store',$tournament) }}"
      class="bg-white p-4 rounded shadow mb-6">
@csrf
<input name="title" placeholder="Judul" class="border px-3 py-2 w-full mb-2">
<input type="file" name="image" required class="mb-2">
<input name="link" placeholder="Link (opsional)" class="border px-3 py-2 w-full mb-2">
<button class="bg-blue-700 text-white px-4 py-2 rounded">
Upload Banner
</button>
</form>

<table class="w-full bg-white shadow">
<tr class="border-b">
    <th>Banner</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

@foreach($banners as $b)
<tr class="border-b">
<td><img src="{{ asset('storage/'.$b->image) }}" class="h-16"></td>
<td>
@if($b->is_approved)
<span class="text-green-600">Approved</span>
@else
<span class="text-yellow-600">Pending</span>
@endif
</td>
<td>
<form method="POST" action="{{ route('eo.banners.toggle',$b) }}">
@csrf
<button class="text-blue-600">
{{ $b->is_active ? 'Disable':'Enable' }}
</button>
</form>
</td>
</tr>
@endforeach
</table>
