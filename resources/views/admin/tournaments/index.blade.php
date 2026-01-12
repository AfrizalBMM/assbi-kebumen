@extends('layouts.admin')
@section('title','Monitor Turnamen')
@section('page_title','Monitor Turnamen')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header & Filter --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">
            Daftar Turnamen
        </h2>

        <form>
            <select name="status"
                    onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary">
                <option value="">Semua Status</option>
                @foreach(['draft','open','ongoing','finished','suspended'] as $st)
                    <option value="{{ $st }}" @selected($status==$st)>
                        {{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-muted">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Turnamen</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">EO</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @foreach($tournaments as $tournament)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 font-medium">
                        {{ $tournament->name }}
                    </td>
                    <td class="px-6 py-3 text-muted">
                        {{ $tournament->category }}
                    </td>
                    <td class="px-6 py-3 text-muted">
                        {{ $tournament->mainEO->name }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $tournament->status=='open' ? 'bg-blue-100 text-blue-700'
                           : ($tournament->status=='ongoing' ? 'bg-green-100 text-green-700'
                           : ($tournament->status=='finished' ? 'bg-gray-200 text-gray-700'
                           : ($tournament->status=='suspended' ? 'bg-red-100 text-red-700'
                           : 'bg-yellow-100 text-yellow-700'))) }}">
                            {{ ucfirst($tournament->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <a href="{{ route('admin.tournaments.show',$tournament) }}"
                           class="px-4 py-1.5 rounded-lg bg-primarySoft text-primary text-xs font-semibold hover:bg-primary/10">
                            Detail
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    {{ $tournaments->links() }}

</div>

@endsection
