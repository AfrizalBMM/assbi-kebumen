@extends('layouts.eo')
@section('title','Buat Turnamen')

@section('content')
<form method="POST"
      action="{{ route('eo.tournaments.store') }}"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-xl">

@csrf

<div class="mb-3">
    <label class="text-sm">Nama Turnamen</label>
    <input name="name" class="w-full border rounded px-3 py-2" required>
</div>

<div class="mb-3">
    <label class="text-sm">Kategori (U10, U12, dll)</label>
    <input name="category" class="w-full border rounded px-3 py-2" required>
</div>

<div class="grid grid-cols-2 gap-4 mb-3">
    <div>
        <label class="text-sm">Tanggal Mulai</label>
        <input type="date" name="start_date" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="text-sm">Tanggal Selesai</label>
        <input type="date" name="end_date" class="w-full border rounded px-3 py-2">
    </div>
</div>

<div class="mb-3">
    <label class="text-sm">Lokasi</label>
    <input name="location" class="w-full border rounded px-3 py-2">
</div>

<div class="grid grid-cols-2 gap-4 mb-3">
    <div>
        <label class="text-sm">Max Peserta</label>
        <input type="number" name="max_participants" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="text-sm">Biaya Pendaftaran</label>
        <input type="number" name="registration_fee" class="w-full border rounded px-3 py-2">
    </div>
</div>

<div class="mb-3">
    <label class="text-sm">Deskripsi</label>
    <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
</div>

<div class="mb-4">
    <label class="text-sm">PDF Regulasi</label>
    <input type="file" name="regulation_pdf"
           accept="application/pdf"
           class="w-full border rounded px-3 py-2">
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan (Draft)
</button>
</form>
@endsection
