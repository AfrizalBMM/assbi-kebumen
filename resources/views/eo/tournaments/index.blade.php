@extends('layouts.eo')
@section('title','Turnamen Saya')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="text-lg font-semibold">Turnamen EO</h2>

    <a href="{{ route('eo.tournaments.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded text-sm">
        + Buat Turnamen
    </a>
</div>

<div class="bg-white rounded shadow">
<table class="w-full text-sm">
    <thead class="border-b">
        <tr>
            <th class="p-3 text-left">Nama</th>
            <th>Kategori</th>
            <th>Periode</th>
            <th>Status</th>
            <th class="p-3 text-right">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tournaments as $t)
        <tr class="border-b">
            <td class="p-3">{{ $t->name }}</td>
            <td>{{ $t->category }}</td>
            <td>{{ $t->start_date }} – {{ $t->end_date }}</td>
            <td>
                <span class="px-2 py-1 rounded text-xs
                    {{ $t->status=='draft'?'bg-gray-200':
                       ($t->status=='published'?'bg-green-200':'bg-red-200') }}">
                    {{ strtoupper($t->status) }}
                </span>
            </td>
            <td class="p-3 text-right space-x-2">
                <a href="{{ route('eo.tournaments.show',$t) }}"
                   class="text-blue-600">Detail</a>

                @if($t->status==='draft')
                <a href="{{ route('eo.tournaments.edit',$t) }}"
                   class="text-yellow-600">Edit</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<div class="mt-4">{{ $tournaments->links() }}</div>
@endsection
