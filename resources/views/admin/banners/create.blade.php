@extends('layouts.admin')
@section('title','Tambah Banner')

@section('content')
<h2 class="text-lg font-semibold mb-4">Tambah Banner</h2>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.banners.store') }}"
      class="bg-white p-6 shadow rounded max-w-lg">
@csrf

<label>Judul</label>
<input name="title" class="w-full border p-2 mb-3">

<label>Link (opsional)</label>
<input name="link" class="w-full border p-2 mb-3">

<label>Urutan</label>
<input name="order" type="number" class="w-full border p-2 mb-3">

<label>Gambar</label>
<input type="file" name="image" class="mb-4">

<button class="bg-blue-700 text-white px-4 py-2 rounded">
    Simpan
</button>
</form>
@endsection
