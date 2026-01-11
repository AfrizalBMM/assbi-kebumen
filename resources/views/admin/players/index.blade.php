@extends('layouts.admin')

<h2 class="text-lg font-semibold mb-4">Database Pemain</h2>

<form class="flex gap-2 mb-4">
<select name="club_id" class="border p-2">
<option value="">Semua Club</option>
@foreach($clubs as $c)
<option value="{{ $c->id }}" @selected($clubId==$c->id)>
{{ $c->name }}
</option>
@endforeach
</select>

<select name="u" class="border p-2">
<option value="">Semua Usia</option>
@foreach([10,12,15,17] as $uOpt)
<option value="{{ $uOpt }}" @selected($u==$uOpt)>
U{{ $uOpt }}
</option>
@endforeach
</select>

<button class="bg-blue-600 text-white px-4">Filter</button>
</form>

<table class="w-full bg-white text-sm">
<tr>
<th>Nama</th>
<th>Club</th>
<th>Tgl Lahir</th>
<th>Status</th>
<th></th>
</tr>

@foreach($players as $p)
<tr>
<td>{{ $p->name }}</td>
<td>{{ $p->club->name }}</td>
<td>{{ $p->birth_date }}</td>
<td>{{ $p->status }}</td>
<td>
<a href="{{ route('admin.players.show',$p) }}" class="text-blue-600">
Detail
</a>
</td>
</tr>
@endforeach
</table>

{{ $players->links() }}
