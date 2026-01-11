@extends('layouts.admin')
@section('title','Edit Banner')

@section('content')
<h2 class="text-lg font-semibold mb-4">Edit Banner</h2>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.banners.update',$banner) }}"
      class="bg-white p-6 shadow rounded max-w-lg">
@csrf @method('PUT')

<label>Judul</label>
<input name="title" value="{{ $banner->title }}" class="w-full border p-2 mb-3">

<label>Link</label>
<input name="link" value="{{ $banner->link }}" class="w-full border p-2 mb-3">

<label>Urutan</label>
<input name="order" value="{{ $banner->order }}" class="w-full border p-2 mb-3">

<label>Gambar Baru</label>
<input type="file" name="image" class="mb-3">

<label class="flex items-center gap-2">
    <input type="checkbox" name="is_active" {{ $banner->is_active?'checked':'' }}>
    Aktif
</label>

<button class="bg-blue-700 text-white px-4 py-2 rounded mt-4">
    Update
</button>
</form>
@endsection
