@extends('layouts.club')
@section('title','Data Pemain')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="text-lg font-semibold">Pemain Club</h2>

    <a href="{{ route('club.players.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded text-sm">
        + Tambah Pemain
    </a>
</div>

<div class="bg-white rounded shadow">
<table class="w-full text-sm">
    <thead class="border-b">
        <tr>
            <th class="p-3 text-left">Foto</th>
            <th>Nama</th>
            <th>Posisi</th>
            <th>Usia</th>
            <th>Status</th>
            <th class="p-3 text-right">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($players as $p)
        <tr class="border-b">
            <td class="p-3">
                @if($p->photo)
                    <img src="{{ asset('storage/'.$p->photo) }}"
                         class="w-10 h-10 rounded-full object-cover">
                @else
                    <img src="{{ asset('images/default-player.png') }}"
                         class="w-10 h-10 rounded-full">
                @endif
            </td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->position }}</td>
            <td>
                {{ \Carbon\Carbon::parse($p->birth_date)->age }} th
            </td>
            <td>{{ ucfirst($p->status) }}</td>
            <td class="p-3 text-right space-x-2">
                <a href="{{ route('club.players.edit',$p) }}"
                   class="text-blue-600">Edit</a>

                <form method="POST"
                      action="{{ route('club.players.destroy',$p) }}"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus pemain?')"
                            class="text-red-600">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection
