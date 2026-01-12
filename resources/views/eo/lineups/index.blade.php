@extends('layouts.eo')

@section('title','Formasi Club')

<table class="w-full bg-white rounded shadow">
<tr>
    <th>Club</th>
    <th>Match</th>
    <th>Formasi</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
@foreach($lineups as $l)
<tr class="border-b">
    <td>{{ $l->club->name }}</td>
    <td>{{ $l->match_name }}</td>
    <td>{{ $l->formation }}</td>
    <td>{{ ucfirst($l->status) }}</td>
    <td>
        <a href="{{ route('eo.lineups.show',$l) }}" class="text-blue-600">
            Lihat
        </a>
    </td>
</tr>
@endforeach
</table>
@endsection
