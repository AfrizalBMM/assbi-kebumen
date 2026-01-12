@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title','Dashboard')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-muted">Total Club</p>
            <p class="text-3xl font-bold text-primary mt-2">
                {{ $totalClubs }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-muted">Menunggu Verifikasi</p>
            <p class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $pendingClubs }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-muted">Club Terverifikasi</p>
            <p class="text-3xl font-bold text-success mt-2">
                {{ $verifiedClubs }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-muted">Total User</p>
            <p class="text-3xl font-bold text-primary mt-2">
                {{ $totalUsers }}
            </p>
        </div>

    </div>


    {{-- PENDING CLUBS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-slate-800">
                Club Menunggu Verifikasi
            </h3>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                {{ $pendingClubs }} Pending
            </span>
        </div>

        <div class="overflow-x-auto">
        @if($latestPendingClubs->count())
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-muted">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Club</th>
                        <th class="px-6 py-3 text-left">Pelatih</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                @foreach($latestPendingClubs as $club)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 font-medium">
                            {{ $club->name }}
                        </td>
                        <td class="px-6 py-3 text-muted">
                            {{ $club->coach_name ?? '-' }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.clubs.show', $club->id) }}"
                               class="px-4 py-1.5 rounded-lg bg-primarySoft text-primary text-xs font-semibold hover:bg-primary/10">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="p-6 text-sm text-muted">
                Tidak ada club yang menunggu verifikasi.
            </div>
        @endif
        </div>

    </div>

    {{-- EXTRA DASHBOARD BLOCKS --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

    {{-- Top Scorers --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-slate-800">Top Scorer</h3>
        </div>
        <div class="divide-y">
            @forelse($topScorers as $p)
                <div class="px-6 py-3 flex justify-between items-center">
                    <div>
                        <p class="font-medium">{{ $p->name }}</p>
                        <p class="text-xs text-muted">{{ $p->club->name }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-primarySoft text-primary text-xs font-bold">
                        {{ $p->total_goals }} Gol
                    </span>
                </div>
            @empty
                <div class="px-6 py-4 text-sm text-muted">Belum ada data.</div>
            @endforelse
        </div>
    </div>

    {{-- Statistik Pemain --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-slate-800">Statistik Pemain</h3>
        </div>
        <div class="p-6 grid grid-cols-2 gap-4 text-center">
            <div>
                <p class="text-sm text-muted">Total Pemain</p>
                <p class="text-3xl font-bold text-primary">{{ $totalPlayers }}</p>
            </div>
            <div>
                <p class="text-sm text-muted">Pemain Aktif</p>
                <p class="text-3xl font-bold text-success">{{ $activePlayers }}</p>
            </div>
            <div>
                <p class="text-sm text-muted">Pemain Suspended</p>
                <p class="text-3xl font-bold text-danger">{{ $suspendedPlayers }}</p>
            </div>
            <div>
                <p class="text-sm text-muted">Rata-rata Usia</p>
                <p class="text-3xl font-bold text-slate-800">{{ $avgAge }} th</p>
            </div>
        </div>
    </div>

    {{-- Aktivitas Terakhir --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-slate-800">Aktivitas Terbaru</h3>
        </div>
        <div class="divide-y max-h-[320px] overflow-auto">
            @forelse($recentActivities as $log)
                <div class="px-6 py-3">
                    <p class="text-sm">
                        <span class="font-semibold">{{ $log->user->name ?? 'System' }}</span>
                        {{ $log->description }}
                    </p>
                    <p class="text-xs text-muted mt-1">
                        {{ $log->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <div class="px-6 py-4 text-sm text-muted">Belum ada aktivitas.</div>
            @endforelse
        </div>
    </div>

</div>


</div>

@endsection
