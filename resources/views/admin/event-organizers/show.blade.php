@extends('layouts.admin')
@section('title','Detail Event Organizer')
@section('page_title','Detail Event Organizer')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

{{-- Info EO --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

<div class="flex justify-between items-start">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">
            {{ $eo->name }}
        </h2>
        <p class="text-muted mt-1">{{ $eo->email }}</p>
    </div>

    <span class="px-4 py-1.5 rounded-full text-sm font-semibold
        {{ $eo->status=='active'
            ? 'bg-successSoft text-success'
            : ($eo->status=='pending'
                ? 'bg-yellow-100 text-yellow-700'
                : 'bg-dangerSoft text-danger') }}">
        {{ ucfirst($eo->status) }}
    </span>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 text-sm">
    <div><span class="text-muted">Contact Person</span><br><b>{{ $eo->contact_person ?? '-' }}</b></div>
    <div><span class="text-muted">Telepon</span><br><b>{{ $eo->phone ?? '-' }}</b></div>
    <div><span class="text-muted">Email</span><br><b>{{ $eo->email }}</b></div>
    <div><span class="text-muted">Alamat</span><br><b>{{ $eo->address ?? '-' }}</b></div>
</div>

@if($eo->admin_note)
<div class="mt-4 p-4 bg-dangerSoft text-danger rounded-lg text-sm">
    Catatan Admin: {{ $eo->admin_note }}
</div>
@endif

<div class="flex gap-3 mt-6">
    <a href="{{ route('admin.event-organizers.edit',$eo) }}"
       class="px-4 py-2 rounded-lg bg-primarySoft text-primary font-semibold hover:bg-primary/10">
        Edit EO
    </a>

    @if($eo->status === 'active')
        <form method="POST" action="{{ route('admin.event-organizers.suspend',$eo) }}">
            @csrf
            <button class="px-4 py-2 rounded-lg bg-danger text-white hover:bg-danger/90">
                Suspend
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.event-organizers.activate',$eo) }}">
            @csrf
            <button class="px-4 py-2 rounded-lg bg-success text-white hover:bg-success/90">
                Aktifkan
            </button>
        </form>
    @endif
</div>

</div>

{{-- Turnamen EO --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b font-semibold">
        Turnamen EO
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-muted">
            <tr>
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Periode</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($eo->tournaments as $t)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">{{ $t->name }}</td>
                <td class="px-6 py-3 text-center">{{ ucfirst($t->status) }}</td>
                <td class="px-6 py-3 text-center text-muted">
                    {{ $t->start_date }} – {{ $t->end_date }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-6 text-center text-muted">
                    Belum ada turnamen
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>

@endsection
