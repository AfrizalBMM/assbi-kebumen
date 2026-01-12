@extends('layouts.admin')
@section('title','Detail Club')
@section('page_title','Detail Club')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">{{ $club->name }}</h2>
            <p class="text-sm text-muted">Detail informasi club</p>
        </div>

        <a href="{{ route('admin.clubs.index') }}"
           class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition text-sm">
            ← Kembali
        </a>
    </div>

    {{-- Info Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 grid grid-cols-2 gap-6">

        <div class="space-y-3">
            <div>
                <p class="text-xs text-muted">Email</p>
                <p class="font-medium">{{ $club->email ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-muted">Telepon</p>
                <p class="font-medium">{{ $club->phone ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-muted">Alamat</p>
                <p class="font-medium">{{ $club->address ?? '-' }}</p>
            </div>
        </div>

        <div class="space-y-3">
            <div>
                <p class="text-xs text-muted">Status</p>
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                    {{ $club->status == 'active'
                        ? 'bg-successSoft text-success'
                        : 'bg-dangerSoft text-danger' }}">
                    {{ ucfirst($club->status) }}
                </span>
            </div>

            <div>
                <p class="text-xs text-muted">Total Pemain</p>
                <p class="text-2xl font-bold text-primary">
                    {{ $club->players->count() }}
                </p>
            </div>
        </div>

    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3">

        @if($club->status == 'active')
            <form method="POST" action="{{ route('admin.clubs.suspend',$club) }}">
                @csrf
                <button class="px-4 py-2 rounded-lg bg-danger text-white text-sm hover:bg-danger/90 transition">
                    Suspend
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.clubs.activate',$club) }}">
                @csrf
                <button class="px-4 py-2 rounded-lg bg-success text-white text-sm hover:bg-success/90 transition">
                    Aktifkan
                </button>
            </form>
        @endif

        <a href="{{ route('admin.clubs.edit',$club) }}"
           class="px-4 py-2 rounded-lg bg-primary text-white text-sm hover:bg-primary/90 transition">
            Edit Club
        </a>

    </div>

    {{-- Player List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-slate-800">Daftar Pemain</h3>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-muted">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-center">Posisi</th>
                    <th class="px-6 py-3 text-center">Tanggal Lahir</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($club->players as $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 font-medium text-slate-800">
                        {{ $p->name }}
                    </td>

                    <td class="px-6 py-3 text-center">
                        <span class="px-2 py-1 rounded bg-primarySoft text-primary text-xs font-semibold">
                            {{ $p->position }}
                        </span>
                    </td>

                    <td class="px-6 py-3 text-center text-muted">
                        {{ \Carbon\Carbon::parse($p->birth_date)->format('d M Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection
