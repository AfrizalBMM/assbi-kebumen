@extends('layouts.eo')

@section('title','Turnamen Saya')
@section('page_title','Turnamen Saya')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Turnamen Event Organizer
            </h2>
            <p class="text-sm text-muted">
                Kelola seluruh turnamen yang Anda selenggarakan
            </p>
        </div>

        <a href="{{ route('eo.tournaments.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-success text-white text-sm font-semibold hover:bg-success/90 transition">
            ➕ Buat Turnamen
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-muted">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Turnamen</th>
                    <th class="px-6 py-3 text-center">Kategori</th>
                    <th class="px-6 py-3 text-center">Periode</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @forelse($tournaments as $t)
                <tr class="hover:bg-gray-50 transition">

                    {{-- NAMA --}}
                    <td class="px-6 py-3">
                        <div class="font-medium text-slate-800">
                            {{ $t->name }}
                        </div>

                        <div class="text-xs text-muted mt-0.5">
                            📍 {{ $t->location ?? 'Lokasi belum ditentukan' }}
                        </div>
                    </td>


                    {{-- KATEGORI --}}
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full bg-primarySoft text-primary text-xs font-semibold">
                            {{ $t->category }}
                        </span>
                    </td>

                    {{-- PERIODE --}}
                    <td class="px-6 py-3 text-center text-muted">
                        {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }}
                        –
                        {{ \Carbon\Carbon::parse($t->end_date)->format('d M Y') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $t->status === 'draft'
                                ? 'bg-gray-200 text-gray-700'
                                : ($t->status === 'published'
                                    ? 'bg-successSoft text-success'
                                    : 'bg-dangerSoft text-danger') }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-3 text-right space-x-3">

                        <a href="{{ route('eo.tournaments.show',$t) }}"
                           class="text-primary font-semibold hover:underline">
                            Detail
                        </a>

                        @if($t->status === 'draft')
                            <a href="{{ route('eo.tournaments.edit',$t) }}"
                               class="text-yellow-600 font-semibold hover:underline">
                                Edit
                            </a>
                        @endif

                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-muted">
                        Belum ada turnamen yang dibuat.
                        <br>
                        <a href="{{ route('eo.tournaments.create') }}"
                           class="inline-block mt-3 text-primary font-semibold hover:underline">
                            Buat turnamen pertama →
                        </a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $tournaments->links() }}
    </div>

</div>

@endsection
