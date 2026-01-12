@extends('layouts.admin')
@section('title','Detail Pemain')
@section('page_title','Detail Pemain')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">{{ $player->name }}</h2>

        <a href="{{ route('admin.players.index') }}"
           class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-sm">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 grid grid-cols-3 gap-6">

        {{-- Foto --}}
        <div class="col-span-1 flex justify-center">
            <img src="{{ asset('storage/'.$player->photo) }}"
                 class="w-40 h-40 object-cover rounded-xl border">
        </div>

        {{-- Info --}}
        <div class="col-span-2 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-muted">Club</p>
                <p class="font-semibold">{{ $player->club->name }}</p>
            </div>

            <div>
                <p class="text-xs text-muted">Tanggal Lahir</p>
                <p class="font-semibold">{{ $player->birth_date }}</p>
            </div>

            <div>
                <p class="text-xs text-muted">NIK</p>
                <p class="font-semibold">{{ $player->nik ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-muted">Status</p>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                {{ $player->status=='active'
                    ? 'bg-successSoft text-success'
                    : 'bg-dangerSoft text-danger' }}">
                    {{ ucfirst($player->status) }}
                </span>
            </div>
        </div>

    </div>

    {{-- Statistik --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 grid grid-cols-3 text-center">
        <div>
            <p class="text-sm text-muted">Gol</p>
            <p class="text-3xl font-bold text-primary">
                {{ $player->stats->sum('goals') }}
            </p>
        </div>
        <div>
            <p class="text-sm text-muted">Kartu Kuning</p>
            <p class="text-3xl font-bold text-yellow-600">
                {{ $player->stats->sum('yellow_cards') }}
            </p>
        </div>
        <div>
            <p class="text-sm text-muted">Kartu Merah</p>
            <p class="text-3xl font-bold text-danger">
                {{ $player->stats->sum('red_cards') }}
            </p>
        </div>
    </div>

    {{-- Dokumen --}}
    @if($player->document)
    <div>
        <a href="{{ asset('storage/'.$player->document) }}"
           target="_blank"
           class="inline-flex px-4 py-2 rounded-lg bg-primary text-white text-sm hover:bg-primary/90">
            📄 Lihat Dokumen
        </a>
    </div>
    @endif

    {{-- Action --}}
    <div>
        @if($player->status=='active')
            <form method="POST" action="{{ route('admin.players.suspend',$player) }}">
                @csrf
                <button class="px-6 py-2 rounded-lg bg-danger text-white hover:bg-danger/90">
                    Suspend
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.players.activate',$player) }}">
                @csrf
                <button class="px-6 py-2 rounded-lg bg-success text-white hover:bg-success/90">
                    Aktifkan
                </button>
            </form>
        @endif
    </div>

</div>

@endsection
