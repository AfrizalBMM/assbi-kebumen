@extends('layouts.admin')
@section('title','Detail Turnamen')
@section('page_title','Detail Turnamen')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">
            {{ $tournament->name }}
        </h2>

        <a href="{{ route('admin.tournaments.index') }}"
           class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-sm">
            ← Kembali
        </a>
    </div>

    {{-- Info Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 grid grid-cols-2 gap-6">

        <div>
            <p class="text-xs text-muted">Kategori</p>
            <p class="font-semibold">{{ $tournament->category }}</p>
        </div>

        <div>
            <p class="text-xs text-muted">Periode</p>
            <p class="font-semibold">
                {{ $tournament->start_date }} – {{ $tournament->end_date }}
            </p>
        </div>

        <div>
            <p class="text-xs text-muted">Lokasi</p>
            <p class="font-semibold">{{ $tournament->location }}</p>
        </div>

        <div>
            <p class="text-xs text-muted">EO Utama</p>
            <p class="font-semibold">{{ $tournament->eventOrganizer->name }}</p>
        </div>

        <div>
            <p class="text-xs text-muted">Status</p>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
            {{ $tournament->status=='suspended'
                ? 'bg-dangerSoft text-danger'
                : 'bg-successSoft text-success' }}">
                {{ ucfirst($tournament->status) }}
            </span>
        </div>

    </div>

    {{-- EO Kolaborasi --}}
    @if($tournament->collaborators->count())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <p class="font-semibold mb-2">EO Kolaborasi</p>
        <ul class="list-disc ml-6 text-sm text-muted">
            @foreach($tournament->collaborators as $eo)
                <li>{{ $eo->name }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Admin Note --}}
    @if($tournament->admin_note)
    <div class="bg-dangerSoft border border-danger/20 text-danger rounded-xl p-4">
        <p class="font-semibold">Catatan Admin</p>
        <p class="text-sm">{{ $tournament->admin_note }}</p>
    </div>
    @endif

    {{-- Actions --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex gap-3">

        @if($tournament->status !== 'suspended')
            <form method="POST" action="{{ route('admin.tournaments.suspend',$tournament) }}"
                  class="flex gap-2">
                @csrf
                <input type="text"
                       name="admin_note"
                       placeholder="Alasan suspend"
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <button class="px-5 py-2 rounded-lg bg-danger text-white hover:bg-danger/90">
                    Suspend
                </button>
            </form>
        @endif

        @if($tournament->status === 'suspended')
            <form method="POST" action="{{ route('admin.tournaments.activate',$tournament) }}">
                @csrf
                <button class="px-5 py-2 rounded-lg bg-success text-white hover:bg-success/90">
                    Aktifkan
                </button>
            </form>
        @endif

    </div>

</div>

@endsection
