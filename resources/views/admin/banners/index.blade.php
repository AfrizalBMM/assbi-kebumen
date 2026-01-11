@extends('layouts.admin')
@section('title','Banner')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="text-lg font-semibold">Banner Slider</h2>

    <a href="{{ route('admin.banners.create') }}"
       class="bg-blue-700 text-white px-4 py-2 rounded">
        + Banner
    </a>
</div>

<table class="w-full bg-white shadow text-sm rounded">
<tr class="border-b bg-gray-100">
    <th class="p-2">Preview</th>
    <th>Judul</th>
    <th>Urutan</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

@foreach($banners as $b)
<tr class="border-b">
    <td class="p-2">
        <img src="{{ asset('storage/'.$b->image) }}" class="h-12 rounded">
    </td>
    <td>{{ $b->title }}</td>
    <td>{{ $b->order }}</td>
    <td>
        @if($b->is_active)
            <span class="text-green-600">Aktif</span>
        @else
            <span class="text-gray-400">Nonaktif</span>
        @endif
    </td>
    <td class="space-x-2">
        <a href="{{ route('admin.banners.edit',$b) }}" class="text-blue-600">Edit</a>

        <form method="POST" action="{{ route('admin.banners.destroy',$b) }}" class="inline">
            @csrf @method('DELETE')
            <button class="text-red-600">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection
