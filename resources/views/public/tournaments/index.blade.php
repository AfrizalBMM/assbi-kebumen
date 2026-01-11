@extends('layouts.public')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-10">

<h1 class="text-2xl font-bold mb-6 text-blue-900">
    Turnamen ASSBI Kebumen
</h1>

{{-- ================= ONGOING ================= --}}
<h2 class="font-semibold text-lg mb-2">🟢 Sedang Berlangsung</h2>

<div class="grid md:grid-cols-3 gap-4 mb-6">
@forelse($ongoing as $t)
<a href="/tournaments/{{ $t->slug }}"
   class="bg-white p-4 shadow rounded border-l-4 border-green-600 hover:shadow-lg transition">

    <strong class="block">{{ $t->name }}</strong>
    <span class="text-sm text-gray-600">
        {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }}
        –
        {{ \Carbon\Carbon::parse($t->end_date)->format('d M Y') }}
    </span>
</a>
@empty
<p class="text-sm text-gray-500 col-span-3">
    Tidak ada turnamen berjalan
</p>
@endforelse
</div>

{{-- ================= UPCOMING ================= --}}
<h2 class="font-semibold text-lg mb-2">🟡 Akan Datang</h2>

<div class="grid md:grid-cols-3 gap-4 mb-6">
@forelse($upcoming as $t)
<a href="/tournaments/{{ $t->slug }}"
   class="bg-white p-4 shadow rounded border-l-4 border-yellow-500 hover:shadow-lg transition">

    <strong class="block">{{ $t->name }}</strong>
    <span class="text-sm text-gray-600">
        Mulai: {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }}
    </span>
</a>
@empty
<p class="text-sm text-gray-500 col-span-3">
    Tidak ada turnamen mendatang
</p>
@endforelse
</div>

{{-- ================= FINISHED ================= --}}
<h2 class="font-semibold text-lg mb-2">⚫ Turnamen Selesai</h2>

<div class="grid md:grid-cols-3 gap-4">
@forelse($finished as $t)
<a href="/tournaments/{{ $t->slug }}"
   class="bg-white p-4 shadow rounded border-l-4 border-gray-400 hover:shadow-lg transition">

    <strong class="block">{{ $t->name }}</strong>
    <span class="text-sm text-gray-600">
        Selesai: {{ \Carbon\Carbon::parse($t->end_date)->format('d M Y') }}
    </span>
</a>
@empty
<p class="text-sm text-gray-500 col-span-3">
    Belum ada turnamen selesai
</p>
@endforelse
</div>

</div>

@endsection
