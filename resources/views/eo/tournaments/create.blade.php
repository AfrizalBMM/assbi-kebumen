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
    <label class="text-sm font-medium text-slate-700">
        Kategori Usia
    </label>

    <select name="category"
            required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary">
        <option value="">-- Pilih Kategori Usia --</option>

        @foreach(config('age_categories') as $label => $range)
            <option value="{{ $label }}">
                {{ $label }} ({{ $range['min'] }}–{{ $range['max'] }} Tahun)
            </option>
        @endforeach
    </select>

    <p class="text-xs text-muted mt-1">
        Usia dihitung berdasarkan tanggal lahir pemain
    </p>
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
    <div class="mb-3">
        <label class="text-sm font-medium text-slate-700">
            Biaya Pendaftaran
        </label>

        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">
                Rp
            </span>

            <input type="text"
                id="registration_fee_display"
                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-primary focus:border-primary"
                placeholder="0"
                inputmode="numeric"
                autocomplete="off">

            <input type="hidden"
                name="registration_fee"
                id="registration_fee">
        </div>

        <p class="text-xs text-muted mt-1">
            Kosongkan atau isi 0 jika gratis
        </p>
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const displayInput = document.getElementById('registration_fee_display');
    const hiddenInput  = document.getElementById('registration_fee');

    function formatRupiah(value) {
        value = value.replace(/\D/g, '');
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    displayInput.addEventListener('input', function () {
        const raw = this.value.replace(/\D/g, '');
        this.value = formatRupiah(raw);
        hiddenInput.value = raw;
    });
});
</script>
@endpush


