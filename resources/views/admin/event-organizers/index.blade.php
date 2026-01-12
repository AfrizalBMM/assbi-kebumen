@extends('layouts.admin')
@section('title','Event Organizer')
@section('page_title','Event Organizer')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header & Filter --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">
            Event Organizer
        </h2>

        <form>
            <select name="status"
                    onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary">
                <option value="">Semua Status</option>
                @foreach(['pending','active','suspended'] as $st)
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
                    <th class="px-6 py-3 text-left">Nama EO</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @foreach($eos as $eo)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 font-medium">{{ $eo->name }}</td>
                    <td class="px-6 py-3 text-muted">{{ $eo->email }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $eo->status=='active'
                            ? 'bg-successSoft text-success'
                            : ($eo->status=='pending'
                                ? 'bg-yellow-100 text-yellow-700'
                                : 'bg-dangerSoft text-danger') }}">
                            {{ ucfirst($eo->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <a href="{{ route('admin.event-organizers.show',$eo) }}"
                           class="px-4 py-1.5 rounded-lg bg-primarySoft text-primary text-xs font-semibold hover:bg-primary/10">
                            Detail
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    </div>

    {{ $eos->links() }}

</div>

@endsection
