@extends('layouts.club')

@section('content')
<h2 class="text-lg font-semibold mb-4">Turnamen Terbuka</h2>

<table class="w-full bg-white text-sm">
<tr>
    <th>Nama</th>
    <th>Kategori</th>
    <th>Periode</th>
    <th>Aksi</th>
</tr>

@foreach($tournaments as $t)
<tr>
    <td>{{ $t->name }}</td>
    <td>{{ $t->category }}</td>
    <td>{{ $t->start_date }} - {{ $t->end_date }}</td>
    <td>
        <form method="POST"
              action="{{ route('club.tournaments.register',$t) }}">
            @csrf
            <button class="bg-green-600 text-white px-3 py-1 rounded">
                Daftar
            </button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection
