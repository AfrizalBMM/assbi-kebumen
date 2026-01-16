@extends('layouts.club')

@section('title','Detail Turnamen')

@section('content')

<div class="max-w-4xl mx-auto px-6">

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-2xl font-bold text-blue-900">
                    {{ $tournament->name }}
                </h2>
                <p class="text-sm text-gray-500">
                    {{ $tournament->category }}
                </p>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-semibold
                {{ $tournament->status=='open'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-100 text-gray-600' }}">
                {{ strtoupper($tournament->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">

            <div>📍 <b>Lokasi:</b> {{ $tournament->location ?? '-' }}</div>
            <div>📅 <b>Periode:</b>
                {{ \Carbon\Carbon::parse($tournament->start_date)->format('d M Y') }}
                –
                {{ \Carbon\Carbon::parse($tournament->end_date)->format('d M Y') }}
            </div>

            <div>👥 <b>Kuota:</b>
                {{ $tournament->registrations_count ?? 0 }}
                /
                {{ $tournament->max_participants ?? '∞' }} club
            </div>

            <div>💰 <b>Biaya:</b>
                {{ $tournament->registration_fee
                    ? 'Rp '.number_format($tournament->registration_fee,0,',','.')
                    : 'Gratis' }}
            </div>

        </div>

        <div class="mt-6 flex justify-end gap-3">

            <a href="{{ route('club.tournaments.index') }}"
            class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm">
                ← Kembali
            </a>

            {{-- AKSI DAFTAR --}}
            @if($totalPlayers < 12)

                <button disabled
                    class="px-5 py-2 rounded-lg bg-gray-300
                        text-gray-600 text-sm font-semibold
                        cursor-not-allowed">
                    Tidak Bisa Daftar
                </button>

            @elseif($eligible12 == 0)

                <button disabled
                    class="px-5 py-2 rounded-lg bg-gray-300
                        text-gray-600 text-sm font-semibold
                        cursor-not-allowed">
                    Tidak Bisa Daftar
                </button>

            @else

                <form method="POST"
                    action="{{ route('club.tournaments.register',$tournament) }}">
                    @csrf
                    <button class="px-5 py-2 rounded-lg bg-green-600
                                hover:bg-green-700 text-white
                                text-sm font-semibold">
                        Daftar Turnamen
                    </button>
                </form>

            @endif

        </div>

        {{-- INFO ATURAN --}}
        <div class="mt-3 text-right space-y-1">

            @if($totalPlayers < 12)
                <p class="text-xs text-red-600">
                    ❗ Minimal <b>12 pemain</b> untuk mendaftar turnamen
                </p>

            @elseif($eligible12 == 0)
                <p class="text-xs text-red-600">
                    ❗ Minimal memiliki <b>1 pemain usia 12 tahun ke atas</b>
                </p>

            @else
                <p class="text-xs text-gray-500">
                    Aturan: minimal usia pemain untuk mengikuti turnamen adalah <b>12 tahun</b>
                </p>
            @endif

        </div>


    </div>

</div>

@endsection
