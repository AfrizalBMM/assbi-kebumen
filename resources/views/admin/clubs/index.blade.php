@extends('layouts.admin')
@section('title','Data Club')
@section('page_title','Data Club')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Data Club</h2>
            <p class="text-sm text-muted">Daftar seluruh club yang terdaftar</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-muted">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Nama Club</th>
                    <th class="px-6 py-3 text-left font-semibold">Email</th>
                    <th class="px-6 py-3 text-center font-semibold">Pemain</th>
                    <th class="px-6 py-3 text-center font-semibold">Status</th>
                    <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @foreach($clubs as $club)
                <tr class="hover:bg-gray-50 transition">

                    {{-- Nama --}}
                    <td class="px-6 py-3 font-medium text-slate-800">
                        {{ $club->name }}
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-3 text-muted">
                        {{ $club->email ?? '-' }}
                    </td>

                    {{-- Pemain --}}
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full bg-primarySoft text-primary text-xs font-semibold">
                            {{ $club->players_count }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $club->status=='active'
                            ? 'bg-successSoft text-success'
                            : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($club->status) }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-3 text-right">
                        <a href="{{ route('admin.clubs.show',$club) }}"
                           class="inline-flex items-center px-4 py-1.5 rounded-lg text-xs font-semibold
                                  bg-primarySoft text-primary hover:bg-primary/10 transition">
                            Detail
                        </a>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $clubs->links() }}
    </div>

</div>

@endsection
