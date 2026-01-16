@extends('layouts.eo')

@section('title','Dashboard EO')
@section('page_title','Dashboard')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

{{-- ================= STAT CARDS ================= --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <div class="bg-white rounded-xl p-6 border shadow-sm">
        <p class="text-sm text-muted">Total Turnamen</p>
        <p class="text-3xl font-bold text-primary mt-2">
            {{ $totalTournaments }}
        </p>
    </div>

    <div class="bg-white rounded-xl p-6 border shadow-sm">
        <p class="text-sm text-muted">Turnamen Aktif</p>
        <p class="text-3xl font-bold text-success mt-2">
            {{ $activeTournaments }}
        </p>
    </div>

    <div class="bg-white rounded-xl p-6 border shadow-sm">
        <p class="text-sm text-muted">Total Match</p>
        <p class="text-3xl font-bold text-primary mt-2">
            {{ $totalMatches }}
        </p>
    </div>

    <div class="bg-white rounded-xl p-6 border shadow-sm">
        <p class="text-sm text-muted">Match Belum Selesai</p>
        <p class="text-3xl font-bold text-yellow-600 mt-2">
            {{ $pendingMatches }}
        </p>
    </div>

</div>

{{-- ================= TURNAMEN TERAKHIR ================= --}}
<div class="bg-white rounded-xl shadow-sm border">

    <div class="px-6 py-4 border-b font-semibold">
        Turnamen Terakhir
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-muted">
            <tr>
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Periode</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
        @forelse($latestTournaments as $t)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">{{ $t->name }}</td>
                <td class="px-6 py-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $t->status === 'published'
                            ? 'bg-successSoft text-success'
                            : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($t->status) }}
                    </span>
                </td>
                <td class="px-6 py-3 text-center text-muted">
                    {{ $t->start_date }} – {{ $t->end_date }}
                </td>
                <td class="px-6 py-3 text-right">
                    <a href="{{ route('eo.tournaments.show',$t) }}"
                       class="text-primary font-semibold hover:underline">
                        Detail
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-6 text-center text-muted">
                    Belum ada turnamen
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- ================= MATCH TERAKHIR ================= --}}
<div class="bg-white rounded-xl shadow-sm border">

    <div class="px-6 py-4 border-b font-semibold">
        Match Terbaru
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-muted">
            <tr>
                <th class="px-6 py-3 text-left">Match</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Skor</th>
            </tr>
        </thead>

        <tbody class="divide-y">
        @forelse($latestMatches as $m)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">
                    {{ $m->homeClub->name }} vs {{ $m->awayClub->name }}
                </td>
                <td class="px-6 py-3 text-center text-muted">
                    {{ ucfirst($m->status) }}
                </td>
                <td class="px-6 py-3 text-center">
                    {{ $m->home_score ?? '-' }} : {{ $m->away_score ?? '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="px-6 py-6 text-center text-muted">
                    Belum ada match
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- ================= AKTIVITAS EO ================= --}}
<div class="bg-white rounded-xl shadow-sm border">

    <div class="px-6 py-4 border-b font-semibold">
        Aktivitas Terbaru Anda
    </div>

    <div class="divide-y">
        @forelse($eoActivities as $log)
            <div class="px-6 py-3 text-sm">
                <p>
                    {{ $log->description }}
                </p>
                <p class="text-xs text-muted mt-1">
                    {{ $log->created_at->diffForHumans() }}
                </p>
            </div>
        @empty
            <div class="px-6 py-6 text-sm text-muted">
                Belum ada aktivitas
            </div>
        @endforelse
    </div>

</div>


</div>

@endsection
