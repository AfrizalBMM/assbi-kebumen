@extends('layouts.admin')
@section('title','Monitor Turnamen')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-lg font-semibold">Daftar Turnamen</h2>

    <form>
        <select name="status" onchange="this.form.submit()"
                class="border px-2 py-1 text-sm rounded">
            <option value="">Semua Status</option>
            @foreach(['draft','open','ongoing','finished','suspended'] as $st)
                <option value="{{ $st }}" @selected($status==$st)>
                    {{ ucfirst($st) }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<div class="bg-white rounded shadow">
    <table class="w-full text-sm">
        <thead class="border-b">
            <tr>
                <th class="p-3 text-left">Nama Turnamen</th>
                <th>Kategori</th>
                <th>EO</th>
                <th>Status</th>
                <th class="text-right p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tournaments as $tournament)
            <tr class="border-b">
                <td class="p-3">{{ $tournament->name }}</td>
                <td>{{ $tournament->category }}</td>
                <td>{{ $tournament->mainEO->name }}</td>
                <td class="font-semibold">{{ ucfirst($tournament->status) }}</td>
                <td class="text-right p-3">
                    <a href="{{ route('admin.tournaments.show',$tournament) }}"
                       class="text-blue-600 hover:underline">
                        Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $tournaments->links() }}
</div>

@endsection
