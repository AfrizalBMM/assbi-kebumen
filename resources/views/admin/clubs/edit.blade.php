@extends('layouts.admin')
@section('title','Edit Club')

@section('content')

<h2 class="text-lg font-semibold mb-4">Edit Club</h2>

<form method="POST"
      action="{{ route('admin.clubs.update',$club) }}"
      class="bg-white p-6 rounded shadow max-w-xl">

@csrf
@method('PUT')

<label class="text-sm">Nama Club</label>
<input name="name"
       value="{{ $club->name }}"
       class="w-full border px-3 py-2 mb-3" required>

<label class="text-sm">Email</label>
<input name="email"
       value="{{ $club->email }}"
       class="w-full border px-3 py-2 mb-3">

<label class="text-sm">Telepon</label>
<input name="phone"
       value="{{ $club->phone }}"
       class="w-full border px-3 py-2 mb-3">

<label class="text-sm">Alamat</label>
<textarea name="address"
          class="w-full border px-3 py-2 mb-3">{{ $club->address }}</textarea>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan
</button>

<a href="{{ route('admin.clubs.show',$club) }}"
   class="ml-2 text-gray-600">Batal</a>

</form>

@endsection
