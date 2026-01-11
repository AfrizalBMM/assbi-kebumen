@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- STATISTIC CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded shadow p-4">
        <div class="text-sm text-gray-500">Total Club</div>
        <div class="text-2xl font-bold">{{ $totalClubs }}</div>
    </div>

    <div class="bg-white rounded shadow p-4">
        <div class="text-sm text-gray-500">Menunggu Verifikasi</div>
        <div class="text-2xl font-bold text-yellow-600">{{ $pendingClubs }}</div>
    </div>

    <div class="bg-white rounded shadow p-4">
        <div class="text-sm text-gray-500">Club Terverifikasi</div>
        <div class="text-2xl font-bold text-green-600">{{ $verifiedClubs }}</div>
    </div>

    <div class="bg-white rounded shadow p-4">
        <div class="text-sm text-gray-500">Total User</div>
        <div class="text-2xl font-bold">{{ $totalUsers }}</div>
    </div>

</div>

{{-- PENDING CLUBS --}}
<div class="bg-white rounded shadow">
    <div class="border-b px-4 py-3 font-semibold">
        Club Menunggu Verifikasi
    </div>

    <div class="p-4">
        @if($latestPendingClubs->count())
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">Nama Club</th>
                        <th>Pelatih</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestPendingClubs as $club)
                        <tr class="border-b">
                            <td class="py-2">{{ $club->name }}</td>
                            <td>{{ $club->coach_name ?? '-' }}</td>
                            <td>
                                <span class="text-yellow-600 font-semibold">
                                    Pending
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.clubs.show', $club->id) }}"
                                   class="text-blue-600 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-sm text-gray-500">
                Tidak ada club yang menunggu verifikasi.
            </p>
        @endif
    </div>
</div>

@endsection
