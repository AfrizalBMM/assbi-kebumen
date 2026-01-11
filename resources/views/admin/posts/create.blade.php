@extends('layouts.admin')

<form method="POST" enctype="multipart/form-data"
 action="{{ isset($post)?route('admin.posts.update',$post):route('admin.posts.store') }}">
@csrf
@isset($post) @method('PUT') @endisset

<input name="title" value="{{ $post->title ?? '' }}"
 class="border w-full p-2 mb-3" placeholder="Judul">

<select name="type" class="border w-full p-2 mb-3">
<option value="news">Berita</option>
<option value="article">Artikel</option>
<option value="announcement">Pengumuman</option>
</select>

<textarea name="content" rows="6"
 class="border w-full p-2 mb-3">{{ $post->content ?? '' }}</textarea>

<input type="file" name="thumbnail" class="mb-3">

<button class="bg-blue-700 text-white px-4 py-2 rounded">
Simpan
</button>
</form>

