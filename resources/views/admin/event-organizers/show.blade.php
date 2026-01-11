@extends('layouts.admin')
@section('title','Detail Event Organizer')

@section('content')

<div class="bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">{{ $eo->name }}</h2>

    <p><strong>Contact Person:</strong> {{ $eo->contact_person }}</p>
    <p><strong>Telepon:</strong> {{ $eo->phone }}</p>
    <p><strong>Email:</strong> {{ $eo->email }}</p>
    <p><strong>Alamat:</strong> {{ $eo->address }}</p>

    <p class="mt-2">
        <strong>Status Operasional:</strong>
        <span class="{{ $eo->status=='active'?'text-green-600':'text-red-600' }}">
            {{ ucfirst($eo->status) }}
        </span>
    </p>

    @if($eo->admin_note)
        <div class="mt-3 text-red-600 text-sm">
            Catatan Admin: {{ $eo->admin_note }}
        </div>
    @endif

    <div class="flex gap-2 mt-6">

        <a href="{{ route('admin.event-organizers.edit',$eo) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            Edit EO
        </a>

        @if($eo->status === 'active')
            <form method="POST"
                  action="{{ route('admin.event-organizers.suspend',$eo) }}">
                @csrf
                <button class="bg-red-600 text-white px-4 py-2 rounded">
                    Suspend EO
                </button>
            </form>
        @else
            <form method="POST"
                  action="{{ route('admin.event-organizers.activate',$eo) }}">
                @csrf
                <button class="bg-green-600 text-white px-4 py-2 rounded">
                    Aktifkan EO
                </button>
            </form>
        @endif

    </div>

</div>

<h3 class="font-semibold mt-6">Turnamen EO</h3>

<table class="w-full bg-white text-sm mt-2">
<tr>
    <th>Nama</th>
    <th>Status</th>
    <th>Periode</th>
</tr>

@foreach($eo->tournaments as $t)
<tr>
    <td>{{ $t->name }}</td>
    <td>{{ $t->status }}</td>
    <td>{{ $t->start_date }} - {{ $t->end_date }}</td>
</tr>
@endforeach
</table>

@endsection
