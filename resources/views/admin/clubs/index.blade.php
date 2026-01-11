@extends('layouts.admin')
@section('title','Data Club')

@section('content')
<h2 class="text-lg font-semibold mb-4">Data Club</h2>

<table class="w-full bg-white rounded shadow text-sm">
<thead>
<tr class="border-b">
    <th class="p-3">Nama</th>
    <th>Email</th>
    <th>Pemain</th>
    <th>Status</th>
    <th class="text-right p-3">Aksi</th>
</tr>
</thead>
<tbody>
@foreach($clubs as $club)
<tr class="border-b">
    <td class="p-3">{{ $club->name }}</td>
    <td>{{ $club->email }}</td>
    <td>{{ $club->players_count }}</td>
    <td>{{ ucfirst($club->status) }}</td>
    <td class="text-right p-3">
        <a href="{{ route('admin.clubs.show',$club) }}"
           class="text-blue-600">Detail</a>
    </td>
</tr>
@endforeach
</tbody>
</table>

<div class="mt-4">{{ $clubs->links() }}</div>
@endsection
