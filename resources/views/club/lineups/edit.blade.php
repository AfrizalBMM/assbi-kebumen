@extends('layouts.club')
@section('title','Formasi')

@section('content')
<div class="w-full px-6">

<h2 class="text-xl font-bold mb-4">Formasi: {{ $lineup->formation }}</h2>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-4 gap-4">

{{-- ===== PEMAIN AKTIF ===== --}}
<div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-2">Pemain Aktif</h3>
    <div id="players" class="flex flex-wrap gap-2">
        @foreach($players as $p)
            @if(!$lineupPlayers->where('player_id',$p->id)->count())
            <div class="player player-card"
                 draggable="true"
                 data-id="{{ $p->id }}"
                 data-position="{{ $p->position }}">
                <img src="{{ asset('storage/'.$p->photo) }}">
                <div class="player-name">{{ $p->name }}</div>
            </div>
            @endif
        @endforeach
    </div>
</div>

{{-- ===== LAPANGAN (VERTIKAL) ===== --}}
<div id="field" class="col-span-2 relative h-[520px] rounded overflow-hidden bg-green-600">

    {{-- garis luar --}}
    <div class="absolute inset-2 border-2 border-white"></div>

    {{-- garis tengah --}}
    <div class="absolute left-1/2 top-2 bottom-2 border-l-2 border-white"></div>

    {{-- lingkar tengah --}}
    <div class="absolute left-1/2 top-1/2 w-28 h-28 border-2 border-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>

    {{-- kotak penalti atas --}}
    <div class="absolute top-2 left-1/2 w-52 h-28 border-2 border-white -translate-x-1/2"></div>

    {{-- kotak penalti bawah --}}
    <div class="absolute bottom-2 left-1/2 w-52 h-28 border-2 border-white -translate-x-1/2"></div>

    @foreach($lineupPlayers->where('role','starter') as $lp)
    <div class="player player-card absolute"
         draggable="true"
         data-id="{{ $lp->player->id }}"
         data-position="{{ $lp->player->position }}"
         style="left:{{ $lp->x }}%; top:{{ $lp->y }}%">
        <img src="{{ asset('storage/'.$lp->player->photo) }}">
        <div class="player-name">{{ $lp->player->name }}</div>
    </div>
    @endforeach

</div>

{{-- ===== CADANGAN ===== --}}
<div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-2">Cadangan</h3>
    <div id="bench" class="flex flex-wrap gap-2 min-h-[300px] border-2 border-dashed border-gray-300 rounded p-3 bg-gray-50">
        @foreach($lineupPlayers->where('role','bench') as $lp)
        <div class="player player-card"
             draggable="true"
             data-id="{{ $lp->player->id }}"
             data-position="{{ $lp->player->position }}">
            <img src="{{ asset('storage/'.$lp->player->photo) }}">
            <div class="player-name">{{ $lp->player->name }}</div>
        </div>
        @endforeach
    </div>
</div>

</div>

<div class="mt-4 flex gap-3">

    {{-- SIMPAN --}}
    <button type="button"
        class="bg-blue-600 text-white px-4 py-2 rounded"
        onclick="confirmAction(
            'Simpan perubahan formasi ini?',
            'info',
            ()=> saveLineup()
        )">
        Simpan
    </button>

    {{-- KIRIM KE EO --}}
    @if($lineup->status == 'draft')
    <form id="submitLineupForm" method="POST" action="{{ route('club.lineups.submit',$lineup) }}">
        @csrf
        <button type="button"
            class="bg-green-600 text-white px-4 py-2 rounded"
            onclick="confirmAction(
                'Kirim formasi ke EO? Setelah dikirim, formasi tidak bisa diubah.',
                'warning',
                ()=> {
                    if(validateSubmit()){
                        document.getElementById('submitLineupForm').submit();
                    }
                }
            )">
            Kirim ke EO
        </button>
    </form>
    @endif

</div>


</div>

{{-- ===== STYLE ===== --}}
<style>
.player-card{
    width:64px;
    display:flex;
    flex-direction:column;
    align-items:center;
    cursor:grab;
    position:relative;
}

.player-card img{
    width:52px;
    height:52px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #2563eb;
    background:white;
    box-shadow:0 4px 8px rgba(0,0,0,.25);
}

.player-card .player-name{
    margin-top:4px;
    font-size:10px;
    font-weight:600;
    text-align:center;
    line-height:1.1;
    color:#1e293b;
    background:white;
    padding:2px 6px;
    border-radius:6px;
    box-shadow:0 2px 5px rgba(0,0,0,.15);
}
</style>

{{-- ===== SCRIPT ===== --}}
<script>
let dragged = null;

document.addEventListener('dragstart', e => {
    const el = e.target.closest('.player');
    if (!el) return;
    dragged = el;
    e.dataTransfer.setData("text/plain", "");
});

/* ZONES */
const field   = document.getElementById('field');
const bench   = document.getElementById('bench');
const players = document.getElementById('players');

/* Allow drop */
[field, bench, players].forEach(zone => {
    zone.addEventListener('dragover', e => e.preventDefault());
});

/* ===== DROP KE LAPANGAN ===== */
field.addEventListener('drop', e => {
    e.preventDefault();

    const starters = field.querySelectorAll('.player').length;

    if (!field.contains(dragged) && starters >= 11) {
        alert("Maksimal 11 pemain di lapangan");
        return;
    }

    const rect = field.getBoundingClientRect();

    const x = e.clientX - rect.left - (dragged.offsetWidth / 2);
    const y = e.clientY - rect.top  - (dragged.offsetHeight / 2);

    dragged.style.position = 'absolute';
    dragged.style.left = x + 'px';
    dragged.style.top  = y + 'px';

    field.appendChild(dragged);
});

/* ===== DROP KE CADANGAN ===== */
bench.addEventListener('drop', e => {
    e.preventDefault();
    dragged.style.position = 'relative';
    dragged.style.left = 'auto';
    dragged.style.top  = 'auto';
    bench.appendChild(dragged);
});

/* ===== DROP KEMBALI KE PEMAIN AKTIF ===== */
players.addEventListener('drop', e => {
    e.preventDefault();
    dragged.style.position = 'relative';
    dragged.style.left = 'auto';
    dragged.style.top  = 'auto';
    players.appendChild(dragged);
});

/* ===== VALIDASI ===== */
function validateSubmit(){
    const starters = field.querySelectorAll('.player');
    const gk = [...starters].filter(p => p.dataset.position === 'GK');

    if(starters.length !== 11){
        alert("Harus tepat 11 pemain di lapangan");
        return false;
    }
    if(gk.length !== 1){
        alert("Harus ada tepat 1 GK");
        return false;
    }
    return true;
}

/* ===== SIMPAN ===== */
function saveLineup(){
    let data = [];

    const fieldRect = field.getBoundingClientRect();

    field.querySelectorAll('.player').forEach(p => {
        const x = p.offsetLeft / fieldRect.width * 100;
        const y = p.offsetTop  / fieldRect.height * 100;

        data.push({
            id: p.dataset.id,
            role: 'starter',
            x: x,
            y: y
        });
    });

    bench.querySelectorAll('.player').forEach(p => {
        data.push({
            id: p.dataset.id,
            role: 'bench'
        });
    });

    fetch('{{ route("club.lineups.save",$lineup) }}',{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Content-Type':'application/json'
        },
        body:JSON.stringify({players:data})
    }).then(()=>location.reload());
}

</script>


@endsection
