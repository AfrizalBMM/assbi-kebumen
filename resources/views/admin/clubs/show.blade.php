@extends('layouts.admin')
@section('title','Detail Club')

@section('content')

<h2 class="text-xl font-bold mb-4">{{ $club->name }}</h2>

<div class="bg-white p-4 rounded shadow">

    <p><strong>Email:</strong> {{ $club->email }}</p>
    <p><strong>Telepon:</strong> {{ $club->phone }}</p>
    <p><strong>Alamat:</strong> {{ $club->address }}</p>

    <p class="mt-2">
        <strong>Status:</strong>
        <span class="{{ $club->status=='active' ? 'text-green-600':'text-red-600' }}">
            {{ ucfirst($club->status) }}
        </span>
    </p>

    <p class="mt-2">
        <strong>Total Pemain:</strong> {{ $club->players->count() }}
    </p>

    <div class="flex gap-2 mt-4">

        @if($club->status == 'active')
            <form method="POST"
                  action="{{ route('admin.clubs.suspend',$club) }}">
            @csrf
            <button class="bg-red-600 text-white px-3 py-2 rounded">
                Suspend
            </button>
            </form>
        @else
            <form method="POST"
                  action="{{ route('admin.clubs.activate',$club) }}">
            @csrf
            <button class="bg-green-600 text-white px-3 py-2 rounded">
                Aktifkan
            </button>
            </form>
        @endif

        <a href="{{ route('admin.clubs.edit',$club) }}"
           class="bg-blue-600 text-white px-3 py-2 rounded">
            Edit Club
        </a>
    </div>

</div>

<h3 class="font-semibold mt-6">Daftar Pemain</h3>
<table class="w-full bg-white text-sm mt-2">
<tr>
    <th>Nama</th>
    <th>Posisi</th>
    <th>Tgl Lahir</th>
</tr>

@foreach($club->players as $p)
<tr>
    <td>{{ $p->name }}</td>
    <td>{{ $p->position }}</td>
    <td>{{ $p->birth_date }}</td>
</tr>
@endforeach
</table>

@endsection
