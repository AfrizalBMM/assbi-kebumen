@extends('layouts.admin')
@section('title','Database Pemain')
@section('page_title','Database Pemain')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Filter --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-wrap gap-3">

        <form class="flex flex-wrap gap-3">

            <select name="club_id"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Club</option>
                @foreach($clubs as $c)
                    <option value="{{ $c->id }}" @selected($clubId==$c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>

            <select name="u"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Usia</option>
                @foreach([10,12,15,17] as $uOpt)
                    <option value="{{ $uOpt }}" @selected($u==$uOpt)>
                        U{{ $uOpt }}
                    </option>
                @endforeach
            </select>

            <button class="px-4 py-2 rounded-lg bg-primary text-white text-sm hover:bg-primary/90">
                Filter
            </button>

        </form>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-muted">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Club</th>
                    <th class="px-6 py-3 text-center">Tanggal Lahir</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @foreach($players as $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 font-medium">{{ $p->name }}</td>
                    <td class="px-6 py-3 text-muted">{{ $p->club->name }}</td>
                    <td class="px-6 py-3 text-center text-muted">
                        {{ \Carbon\Carbon::parse($p->birth_date)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $p->status=='active'
                            ? 'bg-successSoft text-success'
                            : 'bg-dangerSoft text-danger' }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <a href="{{ route('admin.players.show',$p) }}"
                           class="px-4 py-1.5 rounded-lg bg-primarySoft text-primary text-xs font-semibold hover:bg-primary/10">
                            Detail
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    {{ $players->links() }}

</div>

@endsection
