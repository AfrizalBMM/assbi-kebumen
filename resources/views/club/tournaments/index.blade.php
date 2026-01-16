@extends('layouts.club')

@section('title','Turnamen Terbuka')

@section('content')

<div class="max-w-7xl mx-auto px-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            🏆 Turnamen Terbuka
        </h2>

        <span class="text-sm text-gray-500">
            Total: {{ $tournaments->count() }} turnamen
        </span>
    </div>

    {{-- EMPTY STATE --}}
    @if($tournaments->count() === 0)
        <div class="bg-white rounded-xl shadow p-10 text-center text-gray-500">
            <p class="text-lg font-semibold mb-2">Belum ada turnamen terbuka</p>
            <p class="text-sm">Silakan cek kembali nanti.</p>
        </div>
    @else

    {{-- GRID CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($tournaments as $t)

        <div class="bg-white rounded-xl shadow hover:shadow-lg transition border">

            {{-- HEADER CARD --}}
            <div class="p-5 border-b">
                <h3 class="text-lg font-semibold text-blue-900 mb-1">
                    {{ $t->name }}
                </h3>

                <span class="inline-block text-xs px-3 py-1 rounded-full
                    bg-blue-100 text-blue-700 font-semibold">
                    {{ $t->category }}
                </span>
            </div>

            {{-- BODY CARD --}}
            <div class="p-5 space-y-3 text-sm text-gray-600">

                <div class="flex items-center gap-2">
                    📅
                    <span>
                        {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }}
                        –
                        {{ \Carbon\Carbon::parse($t->end_date)->format('d M Y') }}
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    📍 <span>{{ $t->location ?? '-' }}</span>
                </div>

                <div class="flex items-center gap-2">
                    👥
                    <span>
                        {{ $t->registrations_count ?? 0 }}
                        /
                        {{ $t->max_participants ?? '∞' }} club
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    💰
                    <span>
                        {{ $t->registration_fee
                            ? 'Rp '.number_format($t->registration_fee,0,',','.')
                            : 'Gratis' }}
                    </span>
                </div>

                <div>
                    <span class="inline-block px-3 py-1 text-xs rounded-full font-semibold
                        {{ $t->status=='open'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-gray-100 text-gray-600' }}">
                        {{ strtoupper($t->status) }}
                    </span>
                </div>

            </div>

            {{-- FOOTER CARD --}}
            <div class="p-5 border-t">

                <div class="flex justify-between items-start gap-4">

                    {{-- DETAIL --}}
                    <a href="{{ route('club.tournaments.show',$t) }}"
                    class="text-sm text-blue-600 hover:underline">
                        Detail
                    </a>

                    {{-- AKSI DAFTAR --}}
                    <div class="text-right">

                        @if($totalPlayers < 12)

                            <button disabled
                                class="bg-gray-300 text-gray-600 px-4 py-2 rounded-lg
                                    text-sm font-semibold cursor-not-allowed">
                                Tidak Bisa Daftar
                            </button>

                            <p class="mt-2 text-xs text-red-600">
                                ❗ Minimal <b>12 pemain</b> untuk mendaftar
                            </p>

                        @elseif($eligible12 == 0)

                            <button disabled
                                class="bg-gray-300 text-gray-600 px-4 py-2 rounded-lg
                                    text-sm font-semibold cursor-not-allowed">
                                Tidak Bisa Daftar
                            </button>

                            <p class="mt-2 text-xs text-red-600">
                                ❗ Minimal <b>1 pemain usia 12 tahun ke atas</b>
                            </p>

                        @else

                            <form method="POST"
                                action="{{ route('club.tournaments.register',$t) }}">
                                @csrf
                                <button
                                    class="bg-green-600 hover:bg-green-700
                                        text-white px-4 py-2 rounded-lg
                                        text-sm font-semibold">
                                    Daftar
                                </button>
                            </form>

                        @endif

                    </div>

                </div>

            </div>


        </div>

        @endforeach

    </div>

    @endif

</div>

@endsection
