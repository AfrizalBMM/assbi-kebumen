@extends('layouts.admin')
@section('title','Tambah User')

@section('content')
<h2 class="text-lg font-semibold mb-4">Tambah User</h2>

<form method="POST" action="{{ route('admin.users.store') }}">
@csrf

<input name="name" placeholder="Nama" class="border p-2 w-full mb-2">
<input name="email" placeholder="Email" class="border p-2 w-full mb-2">
<input name="password" placeholder="Password" class="border p-2 w-full mb-2">

<select name="role" class="border p-2 w-full mb-2">
    <option value="admin">Admin</option>
    <option value="eo">EO</option>
    <option value="club">Club</option>
</select>

<select name="club_id" class="border p-2 w-full mb-2">
    <option value="">-- Pilih Club --</option>
    @foreach($clubs as $c)
        <option value="{{ $c->id }}">{{ $c->name }}</option>
    @endforeach
</select>

<select name="event_organizer_id" class="border p-2 w-full mb-2">
    <option value="">-- Pilih EO --</option>
    @foreach($eos as $e)
        <option value="{{ $e->id }}">{{ $e->name }}</option>
    @endforeach
</select>

<button class="bg-blue-600 text-white px-4 py-2">Simpan</button>

</form>

@endsection
