@extends('layouts.admin')
@section('title','Edit Konten')
@section('page_title','Edit Konten')

@section('content')

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.posts.update',$post) }}"
      class="max-w-4xl mx-auto space-y-6">
    @csrf
    @method('PUT')

    @include('admin.posts.form', ['post'=>$post])

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.posts.index') }}"
           class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200">
            Batal
        </a>
        <button class="px-6 py-2 rounded-lg bg-primary text-white hover:bg-primary/90">
            Update
        </button>
    </div>
</form>

@endsection
