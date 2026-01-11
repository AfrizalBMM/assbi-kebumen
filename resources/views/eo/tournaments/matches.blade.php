@extends('layouts.eo')

<h2 class="text-lg font-semibold mb-4">
    Jadwal Grup – {{ $tournament->name }}
</h2>

<table class="w-full bg-white text-sm">
<tr>
    <th>Grup</th>
    <th>Pertandingan</th>
    <th>Jadwal</th>
    <th>Skor</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

@foreach($matches as $m)
<tr>
    <td>{{ $m->group->name }}</td>
    <td>{{ $m->homeClub->name }} vs {{ $m->awayClub->name }}</td>
    <td>
        {{ $m->match_date ?? '-' }} {{ $m->match_time ?? '' }}<br>
        <span class="text-xs">{{ $m->venue }}</span>
    </td>
    <td>
        {{ $m->home_score ?? '-' }} : {{ $m->away_score ?? '-' }}
    </td>
    <td>{{ $m->status }}</td>
    <td>
        <a href="{{ route('eo.matches.edit',$m) }}"
           class="text-blue-600">
            Input
        </a>
    </td>
</tr>
@endforeach
</table>
