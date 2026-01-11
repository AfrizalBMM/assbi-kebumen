@extends('layouts.public')

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="flex gap-6 items-center mb-6">
        <img src="{{ $player->photo_url ?? asset('img/default-player.png') }}"
             class="w-32 h-32 object-cover rounded border">

        <div>
            <h1 class="text-2xl font-bold">{{ $player->name }}</h1>
            <p class="text-gray-600">{{ $player->club->name }}</p>
            <p class="text-sm text-gray-500">
                Tahun Lahir: {{ \Carbon\Carbon::parse($player->birth_date)->format('Y') }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="bg-white shadow p-4 rounded text-center">
            <p class="text-gray-500 text-sm">Gol</p>
            <p class="text-2xl font-bold">{{ $totals['goals'] }}</p>
        </div>
        <div class="bg-white shadow p-4 rounded text-center">
            <p class="text-gray-500 text-sm">Kartu Kuning</p>
            <p class="text-2xl font-bold">{{ $totals['yellow_cards'] }}</p>
        </div>
        <div class="bg-white shadow p-4 rounded text-center">
            <p class="text-gray-500 text-sm">Kartu Merah</p>
            <p class="text-2xl font-bold">{{ $totals['red_cards'] }}</p>
        </div>
        <div class="bg-white shadow p-4 rounded text-center">
            <p class="text-gray-500 text-sm">Menit Bermain</p>
            <p class="text-2xl font-bold">{{ $totals['minutes_played'] }}</p>
        </div>
    </div>

    <h2 class="text-lg font-semibold mb-3">Riwayat Turnamen</h2>

    @foreach($stats as $tournamentStats)
        <div class="bg-white shadow rounded p-4 mb-4">
            <h3 class="font-semibold mb-2">
                {{ $tournamentStats->first()->matchGame->tournament->name }}
            </h3>

            <table class="w-full text-sm">
                <tr class="border-b">
                    <th class="text-left p-2">Pertandingan</th>
                    <th>Gol</th>
                    <th>Kuning</th>
                    <th>Merah</th>
                    <th>Menit</th>
                </tr>

                @foreach($tournamentStats as $s)
                <tr class="border-b">
                    <td class="p-2">
                        {{ $s->matchGame->homeClub->name }}
                        vs
                        {{ $s->matchGame->awayClub->name }}
                    </td>
                    <td class="text-center">{{ $s->goals }}</td>
                    <td class="text-center">{{ $s->yellow_cards }}</td>
                    <td class="text-center">{{ $s->red_cards }}</td>
                    <td class="text-center">{{ $s->minutes_played }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    @endforeach

</div>
@endsection
