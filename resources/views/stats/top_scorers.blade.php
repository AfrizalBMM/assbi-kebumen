@extends('layouts.public')

<h2 class="text-xl font-bold mb-4">
Top Scorer – {{ $tournament->name }}
</h2>

<table class="w-full text-sm bg-white shadow">
<tr class="border-b">
    <th>#</th>
    <th>Pemain</th>
    <th>Club</th>
    <th>Gol</th>
</tr>

@foreach($topScorers as $i=>$row)
<tr class="border-b">
    <td>{{ $i+1 }}</td>
    <td>{{ $row->player->name }}</td>
    <td>{{ $row->player->club->name }}</td>
    <td class="font-bold">{{ $row->goals }}</td>
</tr>
@endforeach
</table>
