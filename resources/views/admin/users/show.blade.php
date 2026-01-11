@extends('admin.layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Detail User</h1>

<ul>
    <li>Nama: {{ $user->name }}</li>
    <li>Email: {{ $user->email }}</li>
    <li>Role: {{ $user->role }}</li>
    <li>Status: {{ $user->status }}</li>
</ul>

<a href="{{ route('admin.users.index') }}" class="text-blue-600 mt-4 inline-block">
    Kembali
</a>
@endsection
