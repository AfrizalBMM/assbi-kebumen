@extends('layouts.admin')
@section('title','Detail Turnamen')

@section('content')

<div class="bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">{{ $tournament->name }}</h2>

    <p><strong>Kategori:</strong> {{ $tournament->category }}</p>
    <p><strong>Periode:</strong>
        {{ $tournament->start_date }} s/d {{ $tournament->end_date }}
    </p>
    <p><strong>Lokasi:</strong> {{ $tournament->location }}</p>

    <p class="mt-2">
        <strong>EO Utama:</strong>
        {{ $tournament->eventOrganizer->name }}
    </p>

    @if($tournament->collaborators->count())
        <p class="mt-2"><strong>EO Kolaborasi:</strong></p>
        <ul class="list-disc ml-5">
            @foreach($tournament->collaborators as $eo)
                <li>{{ $eo->name }}</li>
            @endforeach
        </ul>
    @endif

    <p class="mt-2">
        <strong>Status:</strong> {{ ucfirst($tournament->status) }}
    </p>

    @if($tournament->admin_note)
        <div class="mt-3 text-red-600 text-sm">
            Catatan Admin: {{ $tournament->admin_note }}
        </div>
    @endif

    <div class="flex gap-2 mt-6">

        @if($tournament->status !== 'suspended')
            <form method="POST"
                  action="{{ route('admin.tournaments.suspend',$tournament) }}">
                @csrf
                <input type="text"
                       name="admin_note"
                       placeholder="Alasan suspend"
                       class="border px-2 py-1 text-sm rounded">
                <button class="bg-red-600 text-white px-4 py-2 rounded">
                    Suspend
                </button>
            </form>
        @endif

        @if($tournament->status === 'suspended')
            <form method="POST"
                  action="{{ route('admin.tournaments.activate',$tournament) }}">
                @csrf
                <button class="bg-green-600 text-white px-4 py-2 rounded">
                    Aktifkan
                </button>
            </form>
        @endif

    </div>

</div>

@endsection
