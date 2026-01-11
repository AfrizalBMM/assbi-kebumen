@extends('layouts.eo')
@section('title','Peserta Turnamen')

<h2 class="text-lg font-semibold mb-4">
    Peserta – {{ $tournament->name }}
</h2>

<table class="w-full bg-white text-sm">
<tr>
    <th>Club</th>
    <th>Jumlah Pemain</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

@foreach($registrations as $r)
<tr>
    <td>{{ $r->club->name }}</td>
    <td>{{ $r->club->players()->count() }}</td>
    <td>{{ strtoupper($r->status) }}</td>
    <td class="space-x-2">
        @if($r->status=='pending')
            <form method="POST"
                  action="{{ route('eo.registrations.approve',$r) }}"
                  class="inline">
                @csrf
                <button class="bg-green-600 text-white px-2 py-1 rounded">
                    Approve
                </button>
            </form>

            <form method="POST"
                  action="{{ route('eo.registrations.reject',$r) }}"
                  class="inline">
                @csrf
                <input name="eo_note" placeholder="Alasan"
                       class="border px-2 py-1 text-xs" required>
                <button class="bg-red-600 text-white px-2 py-1 rounded">
                    Reject
                </button>
            </form>
        @else
            —
        @endif
    </td>
</tr>
@endforeach
</table>
@endsection
