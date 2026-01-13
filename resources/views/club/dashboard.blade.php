@extends('layouts.club')
@section('title','Dashboard Club')

@section('content')

@php
    $players = $club->players ?? collect();
    $tournaments = $club->tournaments ?? collect();
@endphp

{{-- ===== ROW 1 : KPI CARDS ===== --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-blue-600">
        <p class="text-sm text-gray-500">Total Pemain</p>
        <p class="text-3xl font-bold text-blue-900">{{ $players->count() }}</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-green-600">
        <p class="text-sm text-gray-500">Pemain Aktif</p>
        <p class="text-3xl font-bold text-green-700">{{ $players->where('status','active')->count() }}</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-purple-600">
        <p class="text-sm text-gray-500">KTA Terbit</p>
        <p class="text-3xl font-bold text-purple-700">{{ $players->whereNotNull('kta_number')->count() }}</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow border-l-4 border-orange-500">
        <p class="text-sm text-gray-500">Turnamen Diikuti</p>
        <p class="text-3xl font-bold text-orange-600">{{ $tournaments->count() }}</p>
    </div>

</div>


{{-- ===== ROW 2 : KTA PROGRESS (FULL WIDTH) ===== --}}
@php
    $total = max($players->count(),1);
    $kta = $players->whereNotNull('kta_number')->count();
    $percent = round(($kta / $total) * 100);
@endphp

<div class="bg-white p-6 rounded-xl shadow mb-6">
    <div class="flex justify-between mb-2">
        <h3 class="font-semibold text-gray-700">Progress Kartu Tanda Anggota</h3>
        <span class="text-sm text-gray-500">{{ $kta }} / {{ $players->count() }} pemain</span>
    </div>

    <div class="w-full bg-gray-200 rounded-full h-4">
        <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $percent }}%"></div>
    </div>

    <p class="text-xs text-gray-500 mt-2">{{ $percent }}% pemain sudah memiliki KTA resmi</p>
</div>


{{-- ===== ROW 3 : PROFILE & AGE ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold mb-4 text-gray-700">Profil Club</h3>
        <p><b>Nama:</b> {{ $club->name }}</p>
        <p><b>Pelatih:</b> {{ $club->coach_name }}</p>
        <p><b>Telp:</b> {{ $club->coach_phone }}</p>
        <p><b>Alamat:</b> {{ $club->address }}</p>

        <p class="mt-3">
            <b>Status:</b>
            <span class="px-3 py-1 rounded text-sm {{ $club->status=='active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ strtoupper($club->status) }}
            </span>
        </p>
    </div>

    @php
        $avg = $players->count()
            ? round($players->avg(fn($p)=>\Carbon\Carbon::parse($p->birth_date)->age))
            : 0;
    @endphp

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold mb-4 text-gray-700">Statistik Usia</h3>
        <p class="text-4xl font-bold text-blue-800">{{ $avg }} th</p>
        <p class="text-sm text-gray-500 mb-3">Rata-rata usia pemain</p>

        <div class="text-sm space-y-1">
            <p>GK: {{ $players->where('position','GK')->count() }}</p>
            <p>DF: {{ $players->where('position','DF')->count() }}</p>
            <p>MF: {{ $players->where('position','MF')->count() }}</p>
            <p>FW: {{ $players->where('position','FW')->count() }}</p>
        </div>
    </div>

</div>


{{-- ===== ROW 4 : TOP PLAYERS ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Top Scorer</h3>
        <p class="text-xl font-bold text-blue-900">{{ $topScorer?->name ?? '-' }}</p>
        <p class="text-sm">{{ $topScorer?->stats->sum('goals') ?? 0 }} gol</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Most Minutes</h3>
        <p class="text-xl font-bold text-green-800">{{ $mostMinutes?->name ?? '-' }}</p>
        <p class="text-sm">{{ $mostMinutes?->stats->sum('minutes_played') ?? 0 }} menit</p>
    </div>

</div>

{{-- ===== ROW : POSISI & TOURNAMENT ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    {{-- DISTRIBUSI POSISI --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold text-gray-700 mb-4">Distribusi Posisi</h3>

        @php
            $gk = $players->where('position','GK')->count();
            $df = $players->where('position','DF')->count();
            $mf = $players->where('position','MF')->count();
            $fw = $players->where('position','FW')->count();
            $max = max($gk,$df,$mf,$fw,1);
        @endphp

        @foreach(['GK'=>$gk,'DF'=>$df,'MF'=>$mf,'FW'=>$fw] as $pos=>$val)
            <div class="mb-3">
                <div class="flex justify-between text-sm">
                    <span>{{ $pos }}</span>
                    <span>{{ $val }} pemain</span>
                </div>
                <div class="w-full bg-gray-200 h-3 rounded-full">
                    <div class="bg-blue-600 h-3 rounded-full"
                         style="width: {{ round(($val/$max)*100) }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- RIWAYAT TOURNAMENT --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-700">Riwayat Tournament</h3>
            <a href="{{ route('club.tournaments.index') }}"
               class="text-sm text-blue-600 hover:underline">
                Lihat semua
            </a>
        </div>

        @if($tournaments->count() == 0)
            <p class="text-sm text-gray-500">Belum mengikuti turnamen.</p>
        @else
            <table class="w-full text-sm">
                <thead class="border-b text-gray-500">
                    <tr>
                        <th class="py-2 text-left">Turnamen</th>
                        <th>Status</th>
                        <th class="text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tournaments->take(5) as $t)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 font-semibold">{{ $t->name }}</td>
                            <td>
                                <span class="px-2 py-1 text-xs rounded
                                {{ $t->status=='active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ strtoupper($t->status) }}
                                </span>
                            </td>
                            <td class="text-right text-sm">
                                {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>



{{-- ===== ROW 7 : TOP 5 PERFORMA PEMAIN ===== --}}
<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h3 class="font-semibold text-gray-700 mb-4">Top 5 Performa Pemain</h3>

    <table class="w-full text-sm">
        <thead class="border-b text-gray-500">
            <tr>
                <th class="py-2 text-left">Pemain</th>
                <th>Posisi</th>
                <th>Main</th>
                <th>Gol</th>
                <th>Assist</th>
                <th>Menit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topPlayers as $row)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2 font-semibold">{{ $row['player']->name }}</td>
                    <td class="text-center">{{ $row['player']->position }}</td>
                    <td class="text-center">{{ $row['matches'] }}</td>
                    <td class="text-center font-bold text-blue-700">{{ $row['goals'] }}</td>
                    <td class="text-center">{{ $row['assists'] }}</td>
                    <td class="text-center">{{ $row['minutes'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



@endsection
