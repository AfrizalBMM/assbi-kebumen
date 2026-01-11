<h2 class="text-xl font-bold">{{ $player->name }}</h2>

<p>Club: {{ $player->club->name }}</p>
<p>Tanggal Lahir: {{ $player->birth_date }}</p>
<p>NIK: {{ $player->nik }}</p>

<img src="{{ asset('storage/'.$player->photo) }}" class="w-32 mt-3">

<a href="{{ asset('storage/'.$player->document) }}"
   class="text-blue-600" target="_blank">
Lihat Dokumen
</a>

<p class="mt-4">Gol: {{ $player->stats->goals ?? 0 }}</p>
<p>Kartu Kuning: {{ $player->stats->yellow_cards ?? 0 }}</p>
<p>Kartu Merah: {{ $player->stats->red_cards ?? 0 }}</p>

@if($player->status=='active')
<form method="POST" action="{{ route('admin.players.suspend',$player) }}">
@csrf
<button class="bg-red-600 text-white px-4 py-2">Suspend</button>
</form>
@else
<form method="POST" action="{{ route('admin.players.activate',$player) }}">
@csrf
<button class="bg-green-600 text-white px-4 py-2">Aktifkan</button>
</form>
@endif
