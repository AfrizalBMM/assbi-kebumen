@extends('layouts.public')

@section('content')
<div class="max-w-6xl mx-auto">

<div class="mb-4">
    <h1 class="text-2xl font-bold">{{ $tournament->name }}</h1>

    <div class="flex flex-wrap items-center gap-3 mt-1 text-sm">
        <span class="text-gray-600">
            {{ \Carbon\Carbon::parse($tournament->start_date)->format('d M Y') }}
            –
            {{ \Carbon\Carbon::parse($tournament->end_date)->format('d M Y') }}
        </span>

        <span class="px-3 py-1 rounded text-white
            @if($tournament->status=='ongoing') bg-green-600
            @elseif($tournament->status=='open') bg-yellow-500
            @elseif($tournament->status=='finished') bg-gray-500
            @else bg-gray-400
            @endif">
            {{ strtoupper($tournament->status) }}
        </span>

        <span class="text-gray-600">
            Peserta:
            {{ $tournament->registrations->where('status','approved')->count() }}
            / {{ $tournament->max_participants }}
        </span>

        @if($tournament->regulation_pdf)
            <a href="{{ asset('storage/'.$tournament->regulation_pdf) }}"
               target="_blank"
               class="text-blue-600 underline">
                📄 Regulasi
            </a>
        @endif
    </div>
</div>

<hr class="my-4">

{{-- ================= GROUPS ================= --}}
<h2 class="font-semibold text-lg mb-2">Grup Peserta</h2>
<div class="grid md:grid-cols-2 gap-4">
@foreach($tournament->groups as $group)
    <div class="bg-white p-4 shadow rounded">
        <strong>{{ $group->name }}</strong>
        <ul class="list-disc ml-5 mt-2 text-sm">
            @foreach($group->clubs as $club)
                <li>
                    <a href="{{ url('/clubs/'.$club->slug) }}"
                       class="text-blue-700 hover:underline">
                        {{ $club->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endforeach
</div>

<hr class="my-6">

{{-- ================= STANDINGS ================= --}}
<h2 class="font-semibold text-lg mb-3">Klasemen Grup</h2>

@foreach($tournament->groups as $group)
<div class="mb-6">
    <h3 class="font-semibold mb-2">{{ $group->name }}</h3>

    <table class="w-full text-sm bg-white shadow rounded">
        <tr class="border-b bg-gray-100">
            <th>Club</th><th>Main</th><th>W</th><th>D</th><th>L</th>
            <th>GF</th><th>GA</th><th>GD</th><th>Poin</th>
        </tr>

        @foreach($standings[$group->id] as $row)
        <tr class="border-b">
            <td class="p-1">
                <a href="{{ url('/clubs/'.$row['club']->slug) }}"
                   class="text-blue-700 hover:underline">
                    {{ $row['club']->name }}
                </a>
            </td>
            <td class="text-center">{{ $row['played'] }}</td>
            <td class="text-center">{{ $row['win'] }}</td>
            <td class="text-center">{{ $row['draw'] }}</td>
            <td class="text-center">{{ $row['loss'] }}</td>
            <td class="text-center">{{ $row['gf'] }}</td>
            <td class="text-center">{{ $row['ga'] }}</td>
            <td class="text-center">{{ $row['gd'] }}</td>
            <td class="text-center font-bold">{{ $row['points'] }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endforeach

<hr class="my-6">

{{-- ================= MATCHES ================= --}}
<h2 class="font-semibold text-lg mb-2">Jadwal & Hasil</h2>

<table class="w-full text-sm bg-white shadow rounded">
<thead class="border-b bg-gray-100">
<tr>
    <th class="p-2">Tanggal</th>
    <th>Pertandingan</th>
    <th>Lapangan</th>
    <th class="text-center">Skor</th>
</tr>
</thead>
<tbody>
@foreach($matches as $m)
<tr class="border-b">
    <td class="p-2">
        {{ \Carbon\Carbon::parse($m->match_date)->format('d M') }}
        {{ substr($m->match_time,0,5) }}
    </td>
    <td class="p-2">
        {{ $m->homeClub->name }} vs {{ $m->awayClub->name }}
    </td>
    <td class="p-2">{{ $m->venue }}</td>
    <td class="p-2 text-center font-semibold">
        @if($m->status == 'finished')
            {{ $m->home_score }} - {{ $m->away_score }}
        @else
            -
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>

<hr class="my-6">

{{-- ================= TOP SCORER ================= --}}
<h2 class="font-semibold text-lg mb-2">Top Scorer</h2>

<table class="w-full text-sm bg-white shadow rounded">
<tr class="bg-gray-100">
    <th>#</th><th>Pemain</th><th>Club</th><th>Gol</th>
</tr>
@foreach($topScorers as $i=>$p)
<tr class="border-b">
    <td class="text-center">{{ $i+1 }}</td>
    <td>
        <a href="{{ url('/players/'.$p->player->id) }}"
           class="text-blue-700 hover:underline">
           {{ $p->player->name }}
        </a>
    </td>
    <td>{{ $p->player->club->name }}</td>
    <td class="text-center font-bold">{{ $p->goals }}</td>
</tr>
@endforeach
</table>

<hr class="my-8">

{{-- ================= KNOCKOUT ================= --}}
<h2 class="text-xl font-bold mb-4">Bagan Knockout</h2>

<div class="grid md:grid-cols-3 gap-6">

@foreach(['quarter_final'=>'8 Besar','semi_final'=>'Semifinal','final'=>'Final'] as $key=>$label)
<div>
<h3 class="font-semibold mb-2">{{ $label }}</h3>

@foreach($knockouts[$key] ?? [] as $m)
<div class="bg-white p-2 shadow mb-2 text-sm text-center">
    {{ $m->homeClub->name }}
    <strong>{{ $m->home_score }}</strong>
    vs
    <strong>{{ $m->away_score }}</strong>
    {{ $m->awayClub->name }}
</div>

@if($key=='final' && $m->status=='finished')
<div class="bg-green-100 p-3 text-center font-bold">
🏆 Juara:
{{ $m->home_score > $m->away_score ? $m->homeClub->name : $m->awayClub->name }}
</div>
@endif

@endforeach
</div>
@endforeach

</div>
</div>

@endsection
