@extends('layouts.admin')
@section('title','Event Organizer')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-lg font-semibold">Daftar Event Organizer</h2>

    <form>
        <select name="status" onchange="this.form.submit()"
                class="border rounded px-2 py-1 text-sm">
            <option value="">Semua Status</option>
            @foreach(['pending','verified','rejected','suspended'] as $st)
                <option value="{{ $st }}" @selected($status==$st)>
                    {{ ucfirst($st) }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<div class="bg-white rounded shadow">
    <table class="w-full text-sm">
        <thead class="border-b">
            <tr>
                <th class="p-3 text-left">Nama EO</th>
                <th>Contact Person</th>
                <th>Status</th>
                <th class="text-right p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventOrganizers as $eo)
            <tr class="border-b">
                <td class="p-3">{{ $eo->name }}</td>
                <td>{{ $eo->contact_person }}</td>
                <td>
                    <span class="font-semibold">
                        {{ ucfirst($eo->status) }}
                    </span>
                </td>
                <td class="text-right p-3">
                    <a href="{{ route('admin.event-organizers.show',$eo) }}"
                       class="text-blue-600 hover:underline">
                        Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $eventOrganizers->links() }}
</div>

@endsection
