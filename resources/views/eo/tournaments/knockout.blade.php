@extends('layouts.eo')

<h2 class="text-lg font-semibold mb-4">
    Knockout – {{ $tournament->name }}
</h2>

<table class="w-full bg-white text-sm">
<tr>
    <th>Stage</th>
    <th>Pertandingan</th>
    <th>Skor</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

@foreach($matches as $m)
<tr>
    <td>{{ strtoupper(str_replace('_',' ',$m->stage)) }}</td>
    <td>{{ $m->homeClub->name }} vs {{ $m->awayClub->name }}</td>
    <td>{{ $m->home_score ?? '-' }} : {{ $m->away_score ?? '-' }}</td>
    <td>{{ $m->status }}</td>
    <td>
        <a href="{{ route('eo.matches.edit',$m) }}"
           class="text-blue-600">
            Input Skor
        </a>
    </td>
</tr>
@endforeach
</table>

@if($matches->count() > 0 && $matches->where('status','!=','finished')->count() == 0)
<form method="POST"
      action="{{ route('eo.tournaments.generateNextStage',$tournament) }}"
      class="mt-6">
@csrf
<button class="bg-purple-600 text-white px-4 py-2 rounded">
    Generate Next Stage
</button>
</form>
@endif
