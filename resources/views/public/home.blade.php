@extends('layouts.public')

@section('content')

{{-- ================= HERO ================= --}}
<section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-28">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            ASSBI Kabupaten Kebumen
        </h1>
        <p class="text-lg md:text-xl opacity-90 mb-6">
            Sistem Resmi Kompetisi & Pembinaan Sepak Bola
        </p>

        <div class="flex justify-center gap-4">
            <a href="/tournaments"
               class="bg-white text-blue-900 px-6 py-3 rounded-lg font-semibold shadow hover:bg-blue-100 transition">
                Lihat Turnamen
            </a>
            <a href="/clubs"
               class="border border-white px-6 py-3 rounded-lg hover:bg-white hover:text-blue-900 transition">
                Daftar Club
            </a>
        </div>
    </div>
</section>


<div class="swiper">
@foreach($banners as $b)
<a href="{{ $b->link ?? '/tournaments/'.$b->tournament->slug }}">
<img src="{{ asset('storage/'.$b->image) }}" class="w-full rounded-xl">
</a>
@endforeach
</div>


{{-- ================= TURNAMEN AKTIF ================= --}}
<section class="max-w-7xl mx-auto px-6 py-10">
    <h2 class="text-2xl font-bold mb-4 text-blue-900">🏆 Turnamen Aktif</h2>

    <div class="grid md:grid-cols-3 gap-6">
        @forelse($activeTournaments as $t)
        <div class="bg-white shadow rounded p-5 border-t-4 border-blue-800 hover:shadow-lg transition">
            <h3 class="font-semibold text-lg mb-1">{{ $t->name }}</h3>
            <p class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }}
                –
                {{ \Carbon\Carbon::parse($t->end_date)->format('d M Y') }}
            </p>

            <p class="text-sm mt-2 text-gray-700">{{ $t->location }}</p>

            <span class="inline-block mt-2 px-2 py-1 text-xs rounded
                @if($t->status=='ongoing') bg-green-100 text-green-700
                @elseif($t->status=='open') bg-yellow-100 text-yellow-700
                @else bg-gray-100 text-gray-600 @endif">
                {{ strtoupper($t->status) }}
            </span>

            <a href="/tournaments/{{ $t->slug }}"
               class="block mt-4 text-blue-800 font-semibold text-sm">
                Detail Turnamen →
            </a>
        </div>
        @empty
            <p class="text-gray-500 col-span-3">Belum ada turnamen aktif.</p>
        @endforelse
    </div>
</section>

{{-- ================= TURNAMEN AKAN DATANG ================= --}}
@if($upcomingTournaments->count())
<section class="bg-blue-50 py-10">
<div class="max-w-7xl mx-auto px-6">
    <h2 class="text-xl font-bold mb-4 text-blue-900">📅 Akan Datang</h2>
    <div class="grid md:grid-cols-3 gap-6">
        @foreach($upcomingTournaments as $t)
        <div class="bg-white p-4 shadow rounded hover:shadow-lg transition">
            <h3 class="font-semibold">{{ $t->name }}</h3>
            <p class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }}
            </p>
        </div>
        @endforeach
    </div>
</div>
</section>
@endif

{{-- ================= STATISTIK ================= --}}
<section class="py-10 bg-white">
<div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-6 text-center">

<div class="bg-blue-900 text-white p-6 rounded-lg shadow-lg hover:bg-blue-800 transition">
    <div class="text-3xl font-bold">{{ \App\Models\Club::count() }}</div>
    <p class="text-sm">Club</p>
</div>

<div class="bg-blue-900 text-white p-6 rounded-lg shadow-lg hover:bg-blue-800 transition">
    <div class="text-3xl font-bold">{{ \App\Models\Player::count() }}</div>
    <p class="text-sm">Pemain</p>
</div>

<div class="bg-blue-900 text-white p-6 rounded-lg shadow-lg hover:bg-blue-800 transition">
    <div class="text-3xl font-bold">{{ \App\Models\Tournament::count() }}</div>
    <p class="text-sm">Turnamen</p>
</div>

<div class="bg-blue-900 text-white p-6 rounded-lg shadow-lg hover:bg-blue-800 transition">
    <div class="text-3xl font-bold">{{ \App\Models\MatchGame::count() }}</div>
    <p class="text-sm">Pertandingan</p>
</div>

</div>
</section>

{{-- ================= CLUB ================= --}}
<section class="bg-gray-50 py-10">
<div class="max-w-7xl mx-auto px-6">
<h2 class="text-xl font-bold mb-4 text-blue-900">🏟️ Club Terdaftar</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
@foreach($clubs as $club)
<a href="/clubs/{{ $club->slug }}"
   class="block bg-white p-4 shadow rounded text-center hover:shadow-lg transition hover:-translate-y-1">
    <img src="{{ $club->logo ? asset('storage/'.$club->logo) : asset('img/club-default.png') }}"
         class="w-20 h-20 mx-auto mb-2 object-contain">

    <p class="font-semibold text-sm">{{ $club->name }}</p>
    <p class="text-xs text-gray-500">{{ $club->players_count }} pemain</p>
</a>
@endforeach
</div>
</div>
</section>

{{-- ================= TOP SCORER ================= --}}
<section class="bg-blue-900 text-white py-10">
<div class="max-w-7xl mx-auto px-6">
<h2 class="text-xl font-bold mb-4">🥇 Top Scorer Turnamen</h2>

<table class="w-full text-sm">
@forelse($topScorers as $i=>$s)
<tr class="border-b border-blue-700">
    <td class="py-2">{{ $i+1 }}</td>
    <td>{{ $s->player->name }}</td>
    <td>{{ $s->player->club->name }}</td>
    <td class="font-bold text-right">{{ $s->goals }}</td>
</tr>
@empty
<tr>
<td colspan="4" class="py-4 text-center text-blue-200">
Belum ada data gol
</td>
</tr>
@endforelse
</table>

</div>
</section>

{{-- ================= BERITA ================= --}}
<section class="max-w-7xl mx-auto px-6 py-10">
<h2 class="text-xl font-bold mb-4 text-blue-900">📰 Berita ASSBI</h2>

<div class="grid md:grid-cols-4 gap-6">
@foreach($news as $post)
<div class="bg-white shadow rounded overflow-hidden hover:shadow-lg transition">
    <img src="{{ $post->thumbnail ? asset('storage/'.$post->thumbnail) : asset('img/news-default.jpg') }}"
         class="w-full h-40 object-cover">

    <div class="p-4">
        <h3 class="font-semibold text-sm mb-2">
            {{ $post->title }}
        </h3>
        <a href="/news/{{ $post->slug }}"
           class="text-blue-800 text-sm font-semibold">
            Baca →
        </a>
    </div>
</div>
@endforeach
</div>
</section>
@endsection
