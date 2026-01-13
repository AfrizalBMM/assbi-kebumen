@extends('layouts.club')

@section('title','Formasi')

@section('content')

<div class="max-w-7xl mx-auto px-6">


<div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Formasi</h2>

    <form method="POST" action="{{ route('club.lineups.store') }}">
        @csrf
        <button class="bg-green-600 text-white px-4 py-2 rounded">
            + Buat Formasi
        </button>
    </form>
</div>

<div class="bg-white rounded shadow">

<table class="w-full text-sm">
    <thead class="border-b">
        <tr>
            <th class="p-3 text-left">Match</th>
            <th>Formasi</th>
            <th>Status</th>
            <th class="p-3 text-right">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($lineups as $l)
        <tr class="border-b">
            <td class="p-3">{{ $l->match_name ?? 'Latihan' }}</td>
            <td>{{ $l->formation }}</td>
            <td>
                <span class="px-2 py-1 rounded text-xs
                {{ $l->status=='draft' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                    {{ ucfirst($l->status) }}
                </span>
            </td>
            <td class="p-3 text-right">
                <a href="{{ route('club.lineups.edit',$l) }}"
                   class="text-blue-600 hover:underline">
                    Buka
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</div>
</div>

@endsection
