@extends('layouts.admin')
@section('title','Tambah Banner')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Page title --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Tambah Banner
        </h2>
        <p class="text-sm text-muted">
            Banner akan tampil di slider halaman depan ASSBI.
        </p>
    </div>

    {{-- Card --}}
    <div class="card">
        <div class="card-header">
            Form Banner
        </div>

        <div class="card-body">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('admin.banners.store') }}"
                  class="space-y-5">
                @csrf

                {{-- Judul --}}
                <div>
                    <label class="form-label">Judul Banner</label>
                    <input name="title"
                           placeholder="Contoh: ASSBI Cup 2025"
                           class="form-input">
                </div>

                {{-- Link --}}
                <div>
                    <label class="form-label">Link (Opsional)</label>
                    <input name="link"
                           placeholder="https://assbi.id/turnamen"
                           class="form-input">
                </div>

                {{-- Urutan --}}
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input name="order"
                           type="number"
                           value="0"
                           class="form-input">
                    <p class="text-xs text-muted mt-1">
                        Angka kecil tampil lebih dulu.
                    </p>
                </div>

                {{-- Gambar --}}
                <div>
                    <label class="form-label">Gambar Banner</label>
                    <input type="file"
                           name="image"
                           class="form-input">
                </div>

                {{-- Status --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" checked>
                    <span class="text-sm text-muted">
                        Aktifkan banner ini
                    </span>
                </div>

                {{-- Action --}}
                <div class="pt-6 flex gap-3">
                    <button class="btn-primary">
                        Simpan Banner
                    </button>

                    <a href="{{ route('admin.banners.index') }}"
                       class="btn-ghost">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
