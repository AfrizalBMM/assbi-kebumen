@extends('layouts.eo')

<h2 class="text-lg font-semibold mb-4">
    {{ $match->homeClub->name }} vs {{ $match->awayClub->name }}
</h2>

<form method="POST" action="{{ route('eo.matches.update',$match) }}"
      class="bg-white p-6 rounded shadow max-w-lg">

@csrf
@method('PUT')

<label class="text-sm">Tanggal</label>
<input type="date" name="match_date"
       value="{{ $match->match_date }}"
       class="w-full border px-3 py-2 mb-3" required>

<label class="text-sm">Jam</label>
<input type="time" name="match_time"
       value="{{ $match->match_time }}"
       class="w-full border px-3 py-2 mb-3" required>

<label class="text-sm">Lapangan</label>
<input name="venue"
       value="{{ $match->venue }}"
       class="w-full border px-3 py-2 mb-3" required>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label>{{ $match->homeClub->name }}</label>
        <input type="number" name="home_score"
               value="{{ $match->home_score }}"
               class="w-full border px-3 py-2">
    </div>

    <div>
        <label>{{ $match->awayClub->name }}</label>
        <input type="number" name="away_score"
               value="{{ $match->away_score }}"
               class="w-full border px-3 py-2">
    </div>
</div>

<h3 class="mt-6 font-semibold">Statistik Pemain</h3>

<table class="w-full text-sm mt-2">
<tr class="border-b">
    <th>Pemain</th>
    <th>Gol</th>
    <th>Kuning</th>
    <th>Merah</th>
    <th>Menit</th>
</tr>

@foreach($players as $p)
@php
$stat = $p->matchStats->where('match_game_id',$match->id)->first();
@endphp
<tr class="border-b">
    <td>{{ $p->name }} ({{ $p->club->name }})</td>

    <td>
        <input type="number"
               name="stats[{{ $p->id }}][goals]"
               value="{{ $stat->goals ?? 0 }}"
               class="w-16 border px-1">
    </td>

    <td>
        <input type="number"
               name="stats[{{ $p->id }}][yellow_cards]"
               value="{{ $stat->yellow_cards ?? 0 }}"
               class="w-16 border px-1">
    </td>

    <td>
        <input type="number"
               name="stats[{{ $p->id }}][red_cards]"
               value="{{ $stat->red_cards ?? 0 }}"
               class="w-16 border px-1">
    </td>

    <td>
        <input type="number"
               name="stats[{{ $p->id }}][minutes_played]"
               value="{{ $stat->minutes_played ?? 0 }}"
               class="w-16 border px-1">
    </td>
</tr>
@endforeach
</table>



<button class="bg-green-600 text-white px-4 py-2 rounded mt-4">
    Simpan
</button>

</form>
