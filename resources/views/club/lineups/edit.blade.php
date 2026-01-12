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

{{-- PEMAIN --}}
<div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-2">Pemain Aktif</h3>
    <div id="players" class="space-y-2">
        @foreach($players as $p)
            @if(!$lineupPlayers->where('player_id',$p->id)->count())
            <div class="player bg-blue-700 text-white px-3 py-1 rounded-full shadow text-xs cursor-move"
                 draggable="true"
                 data-id="{{ $p->id }}"
                 data-position="{{ $p->position }}">
                {{ $p->name }} ({{ $p->position }})
            </div>
            @endif
        @endforeach
    </div>
</div>

{{-- LAPANGAN --}}
<div id="field" class="col-span-2 relative h-[520px] rounded overflow-hidden" style="background:#1ea54c">

    <div class="absolute inset-2 border-2 border-white pointer-events-none"></div>
    <div class="absolute top-1/2 left-0 w-full border-t-2 border-white pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 w-28 h-28 border-2 border-white rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute left-2 top-1/2 w-28 h-52 border-2 border-white -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute right-2 top-1/2 w-28 h-52 border-2 border-white -translate-y-1/2 pointer-events-none"></div>

    @foreach($lineupPlayers->where('role','starter') as $lp)
    <div class="player bg-blue-700 text-white px-3 py-1 rounded-full shadow text-xs absolute cursor-move"
         draggable="true"
         data-id="{{ $lp->player->id }}"
         data-position="{{ $lp->player->position }}"
         style="left:{{ $lp->x }}px; top:{{ $lp->y }}px">
        {{ $lp->player->name }} ({{ $lp->player->position }})
    </div>
    @endforeach

</div>

{{-- CADANGAN --}}
<div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-2">Cadangan</h3>
    <div id="bench" class="space-y-2 min-h-[300px] border-2 border-dashed border-gray-300 rounded p-3 bg-gray-50">
        @foreach($lineupPlayers->where('role','bench') as $lp)
        <div class="player bg-gray-700 text-white px-3 py-1 rounded-full shadow text-xs cursor-move"
             draggable="true"
             data-id="{{ $lp->player->id }}"
             data-position="{{ $lp->player->position }}">
            {{ $lp->player->name }} ({{ $lp->player->position }})
        </div>
        @endforeach
    </div>
</div>

</div>

<div class="mt-4 flex gap-3">
    <button onclick="saveLineup()" class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>

    @if($lineup->status == 'draft')
    <form method="POST" action="{{ route('club.lineups.submit',$lineup) }}" onsubmit="return validateSubmit()">
        @csrf
        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Kirim ke EO
        </button>
    </form>
    @endif
</div>

</div>

<script>
let dragged = null;

document.querySelectorAll('.player').forEach(p => {
    p.addEventListener('dragstart', e => {
        dragged = e.target;
        e.dataTransfer.setData("text/plain", ""); // required for Firefox
    });
});

const field = document.getElementById('field');
const bench = document.getElementById('bench');

[field, bench].forEach(zone => {
    zone.addEventListener('dragover', e => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });
});

/* DROP KE LAPANGAN */
field.addEventListener('drop', e => {
    e.preventDefault();

    const starters = field.querySelectorAll('.player').length;
    if (!field.contains(dragged) && starters >= 11) {
        alert("Maksimal 11 pemain di lapangan");
        return;
    }

    const rect = field.getBoundingClientRect();
    dragged.style.position = 'absolute';
    dragged.style.left = (e.clientX - rect.left) + 'px';
    dragged.style.top  = (e.clientY - rect.top) + 'px';

    field.appendChild(dragged);
});

/* DROP KE CADANGAN */
bench.addEventListener('drop', e => {
    e.preventDefault();

    dragged.style.position = 'relative';
    dragged.style.left = 'auto';
    dragged.style.top  = 'auto';

    bench.appendChild(dragged);
});

/* VALIDASI SUBMIT */
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

/* SIMPAN */
function saveLineup(){
    let data = [];

    field.querySelectorAll('.player').forEach(p=>{
        data.push({
            id:p.dataset.id,
            role:'starter',
            x:p.offsetLeft,
            y:p.offsetTop
        });
    });

    bench.querySelectorAll('.player').forEach(p=>{
        data.push({
            id:p.dataset.id,
            role:'bench'
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
