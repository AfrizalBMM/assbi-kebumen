@extends('layouts.eo')

<h2 class="text-lg font-semibold mb-4">
    Grup – {{ $tournament->name }}
</h2>

<form method="POST" action="{{ route('eo.groups.auto',$tournament) }}">
@csrf
<button class="bg-blue-600 text-white px-3 py-2 rounded mb-4">
    Generate Otomatis
</button>
</form>

<div class="grid grid-cols-4 gap-4">
@foreach($groups as $g)
<div class="bg-white p-3 rounded shadow">
    <h3 class="font-semibold">{{ $g->name }}</h3>

    @foreach($g->clubs as $club)
        <div class="flex justify-between text-sm mt-2">
            <span>{{ $club->name }}</span>
            <form method="POST"
                  action="{{ route('eo.groups.removeClub',$g) }}">
                @csrf
                <input type="hidden" name="club_id" value="{{ $club->id }}">
                <button class="text-red-600">x</button>
            </form>
        </div>
    @endforeach
</div>
@endforeach
</div>

<form method="POST"
      action="{{ route('eo.tournaments.generateMatches',$tournament) }}"
      class="mt-6">
@csrf
<button class="bg-green-600 text-white px-4 py-2 rounded">
    Generate Jadwal Pertandingan
</button>
</form>


@endsection
