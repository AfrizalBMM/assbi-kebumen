@extends('layouts.club')
@section('title','Data Pemain')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="text-lg font-semibold">Data Pemain</h2>

    <a href="{{ route('club.players.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded text-sm">
        + Tambah Pemain
    </a>
</div>

<div class="flex justify-between items-center px-5 py-3 border-b bg-gray-50">
    <div class="font-semibold text-gray-700">
        Total: {{ $players->count() }} Pemain
    </div>

    <div class="flex gap-2">
        <input type="text"
               placeholder="Cari pemain..."
               class="border px-3 py-1.5 rounded text-sm focus:ring focus:ring-blue-200">
    </div>
</div>


<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">

<table class="min-w-full text-sm text-gray-700">
    <thead class="bg-gray-50 border-b">
        <tr>
            <th class="px-4 py-3 text-left font-semibold">Pemain</th>
            <th class="px-4 py-3 text-center font-semibold">Posisi</th>
            <th class="px-4 py-3 text-left font-semibold">NIK</th>
            <th class="px-4 py-3 text-center font-semibold">Usia</th>
            <th class="px-4 py-3 text-center font-semibold">Status</th>
            <th class="px-4 py-3 text-right font-semibold">Aksi</th>
        </tr>
    </thead>

    <tbody class="divide-y">
    @foreach($players as $p)
        <tr class="hover:bg-gray-50 transition">

            {{-- Pemain (Foto + Nama) --}}
            <td class="px-4 py-3 flex items-center gap-3">
                @if($p->photo)
                    <img src="{{ asset('storage/'.$p->photo) }}"
                         class="w-10 h-10 rounded-full object-cover border">
                @else
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                        N/A
                    </div>
                @endif

                <div>
                    <div class="font-semibold text-gray-900">{{ $p->name }}</div>
                    <div class="text-xs text-gray-500">{{ $p->birth_place ?? '-' }}</div>
                </div>
            </td>

            {{-- Posisi --}}
            <td class="px-4 py-3 text-center">
                <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-700">
                    {{ $p->position }}
                </span>
            </td>

            {{-- NIK --}}
            <td class="px-4 py-3">
                {{ $p->nik ?? '-' }}
            </td>

            {{-- Usia --}}
            <td class="px-4 py-3 text-center">
                {{ \Carbon\Carbon::parse($p->birth_date)->age }} th
            </td>

            {{-- Status --}}
            <td class="px-4 py-3 text-center">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                {{ $p->status=='active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($p->status) }}
                </span>
            </td>

            {{-- Aksi --}}
            <td class="px-4 py-3 text-right space-x-2">
                <a href="{{ route('club.players.edit',$p) }}"
                   class="inline-flex items-center px-3 py-1.5 text-xs rounded bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                    Edit
                </a>

                <form method="POST"
                      action="{{ route('club.players.destroy',$p) }}"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus pemain?')"
                            class="inline-flex items-center px-3 py-1.5 text-xs rounded bg-red-100 text-red-700 hover:bg-red-200 transition">
                        Hapus
                    </button>
                </form>
            </td>

        </tr>
    @endforeach
    </tbody>
</table>

</div>

@endsection
