@extends('layouts.admin')
@section('title','Detail User')
@section('page_title','Detail User')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">Detail User</h2>

        <a href="{{ route('admin.users.index') }}"
           class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition text-sm">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 grid grid-cols-2 gap-6">

        <div>
            <p class="text-xs text-muted">Nama</p>
            <p class="font-semibold">{{ $user->name }}</p>
        </div>

        <div>
            <p class="text-xs text-muted">Email</p>
            <p class="font-semibold">{{ $user->email }}</p>
        </div>

        <div>
            <p class="text-xs text-muted">Role</p>
            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
            {{ $user->role=='admin' ? 'bg-primarySoft text-primary'
               : ($user->role=='eo' ? 'bg-purple-100 text-purple-700'
               : 'bg-blue-100 text-blue-700') }}">
                {{ strtoupper($user->role) }}
            </span>
        </div>

        <div>
            <p class="text-xs text-muted">Status</p>
            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
            {{ $user->status=='active'
                ? 'bg-successSoft text-success'
                : ($user->status=='pending'
                    ? 'bg-yellow-100 text-yellow-700'
                    : 'bg-dangerSoft text-danger') }}">
                {{ ucfirst($user->status) }}
            </span>
        </div>

    </div>

</div>

@endsection
