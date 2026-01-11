@extends('layouts.eo')

<h2 class="text-lg font-semibold mb-4">
    Klasemen – {{ $tournament->name }}
</h2>

@foreach($groups as $group)
<h3 class="font-semibold mt-6 mb-2">{{ $group->name }}</h3>

<table class="w-full bg-white text-sm">
<tr>
    <th>Club</th>
    <th>Main</th>
    <th>Menang</th>
    <th>Seri</th>
    <th>Kalah</th>
    <th>GF</th>
    <th>GA</th>
    <th>GD</th>
    <th>Poin</th>
</tr>

@foreach($standings[$group->id] as $row)
<tr>
    <td>{{ $row['club']->name }}</td>
    <td>{{ $row['played'] }}</td>
    <td>{{ $row['win'] }}</td>
    <td>{{ $row['draw'] }}</td>
    <td>{{ $row['loss'] }}</td>
    <td>{{ $row['gf'] }}</td>
    <td>{{ $row['ga'] }}</td>
    <td>{{ $row['gd'] }}</td>
    <td>{{ $row['points'] }}</td>
</tr>
@endforeach
</table>
@endforeach
