@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title','Dashboard')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- ================= STAT CARDS (ENTERPRISE) ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Total Club --}}
        <div class="bg-white rounded-xl p-6 border border-primarySoft shadow-sm">
            <p class="text-sm text-muted">Total Club</p>
            <p class="text-3xl font-bold text-primary mt-2">
                {{ $totalClubs }}
            </p>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-muted">Menunggu Verifikasi</p>
            <div class="flex items-center gap-2 mt-2">
                <p class="text-3xl font-bold text-primary">
                    {{ $pendingClubs }}
                </p>
                <span class="badge badge-warning">Pending</span>
            </div>
        </div>

        {{-- Verified --}}
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-muted">Club Terverifikasi</p>
            <div class="flex items-center gap-2 mt-2">
                <p class="text-3xl font-bold text-primary">
                    {{ $verifiedClubs }}
                </p>
                <span class="badge badge-success">Aktif</span>
            </div>
        </div>

        {{-- Total User --}}
        <div class="bg-white rounded-xl p-6 border border-primarySoft shadow-sm">
            <p class="text-sm text-muted">Total User</p>
            <p class="text-3xl font-bold text-primary mt-2">
                {{ $totalUsers }}
            </p>
        </div>

    </div>

    {{-- ================= CLUB & EO PENDING ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- CLUB --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b bg-primarySoft flex justify-between items-center">
                <h3 class="font-semibold text-primary">
                    Club Menunggu Verifikasi
                </h3>
                <span class="badge badge-warning">
                    {{ $pendingClubs }} Pending
                </span>
            </div>

            <div class="overflow-x-auto">
            @if($latestPendingClubs->count())
                <table class="w-full text-sm">
                    <thead class="text-primary">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama Club</th>
                            <th class="px-6 py-3 text-left">Pelatih</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                    @foreach($latestPendingClubs as $club)
                        <tr class="hover:bg-primarySoft transition">
                            <td class="px-6 py-3 font-medium text-slate-800">
                                {{ $club->name }}
                            </td>
                            <td class="px-6 py-3 text-muted">
                                {{ $club->coach_name ?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <span class="badge badge-warning">Pending</span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('admin.clubs.show', $club->id) }}"
                                   class="btn-ghost text-xs">
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

        {{-- EO --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b bg-primarySoft flex justify-between items-center">
                <h3 class="font-semibold text-primary">
                    EO Menunggu Verifikasi
                </h3>
                <span class="badge badge-warning">
                    {{ $pendingEOs }} Pending
                </span>
            </div>

            <div class="overflow-x-auto">
            @if($latestPendingEOs->count())
                <table class="w-full text-sm">
                    <thead class="text-primary">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama EO</th>
                            <th class="px-6 py-3 text-left">Contact</th>
                            <th class="px-6 py-3 text-left">Telepon</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                    @foreach($latestPendingEOs as $eo)
                        <tr class="hover:bg-primarySoft transition">
                            <td class="px-6 py-3 font-medium text-slate-800">
                                {{ $eo->name }}
                            </td>
                            <td class="px-6 py-3 text-muted">
                                {{ $eo->contact_person }}
                            </td>
                            <td class="px-6 py-3 text-muted">
                                {{ $eo->phone }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <span class="badge badge-warning">Pending</span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('admin.event-organizers.show', $eo->id) }}"
                                   class="btn-ghost text-xs">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-6 text-sm text-muted">
                    Tidak ada EO yang menunggu verifikasi.
                </div>
            @endif
            </div>
        </div>

    </div>

    {{-- ================= EXTRA DASHBOARD ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

        {{-- TOP SCORER --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-slate-800">
                    Top Scorer
                </h3>
            </div>
            <div class="divide-y">
                @forelse($topScorers as $p)
                    <div class="px-6 py-3 flex justify-between items-center">
                        <div>
                            <p class="font-medium">{{ $p->name }}</p>
                            <p class="text-xs text-muted">{{ $p->club->name }}</p>
                        </div>
                        <span class="badge badge-success">
                            {{ $p->total_goals }} Gol
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-4 text-sm text-muted">
                        Belum ada data.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- STATISTIK PEMAIN --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-slate-800">
                    Statistik Pemain
                </h3>
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

        {{-- AKTIVITAS --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-slate-800">
                    Aktivitas Terbaru
                </h3>
            </div>
            <div class="divide-y max-h-[320px] overflow-auto">
                @forelse($recentActivities as $log)
                    <div class="px-6 py-3">
                        <p class="text-sm">
                            <span class="font-semibold">
                                {{ $log->user->name ?? 'System' }}
                            </span>
                            {{ $log->description }}
                        </p>
                        <p class="text-xs text-muted mt-1">
                            {{ $log->created_at->diffForHumans() }}
                        </p>
                    </div>
                @empty
                    <div class="px-6 py-4 text-sm text-muted">
                        Belum ada aktivitas.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection
