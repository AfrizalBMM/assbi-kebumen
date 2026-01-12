@extends('layouts.admin')
@section('title','Edit Banner')

@section('content')

<div class="max-w-xl">

<h2 class="text-xl font-semibold text-primary mb-4">
    ✏ Edit Banner
</h2>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.banners.update',$banner) }}"
      class="card space-y-4">
@csrf @method('PUT')

<div>
    <label class="form-label">Judul</label>
    <input name="title" value="{{ $banner->title }}" class="form-input">
</div>

<div>
    <label class="form-label">Link</label>
    <input name="link" value="{{ $banner->link }}" class="form-input">
</div>

<div>
    <label class="form-label">Urutan</label>
    <input name="order" value="{{ $banner->order }}" class="form-input">
</div>

<div>
    <label class="form-label">Gambar Baru</label>
    <input type="file" name="image" class="form-input">
</div>

<div class="flex items-center gap-2">
    <input type="checkbox" name="is_active" {{ $banner->is_active?'checked':'' }}>
    <span class="text-sm text-muted">Banner aktif</span>
</div>

<div class="pt-4 flex gap-3">
    <button class="btn-primary">Update</button>
    <a href="{{ route('admin.banners.index') }}" class="btn-soft-muted">Batal</a>
</div>

</form>
</div>
@endsection
