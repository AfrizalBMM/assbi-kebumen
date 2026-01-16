@extends('layouts.admin')
@section('title','Detail Event Organizer')
@section('page_title','Detail Event Organizer')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

{{-- ================= HEADER EO ================= --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

    {{-- Header --}}
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                {{ $eventOrganizer->name }}
            </h2>
            <p class="text-sm text-muted mt-1">
                {{ $eventOrganizer->email ?? '-' }}
            </p>
        </div>

        {{-- Status Badge --}}
        <span class="px-4 py-1.5 rounded-full text-sm font-semibold
            {{ $eventOrganizer->status === 'active'
                ? 'bg-successSoft text-success'
                : ($eventOrganizer->status === 'pending'
                    ? 'bg-yellow-100 text-yellow-700'
                    : 'bg-dangerSoft text-danger') }}">
            {{ ucfirst($eventOrganizer->status) }}
        </span>
    </div>

    {{-- Info Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 text-sm">

        <div>
            <p class="text-muted">Contact Person</p>
            <p class="font-semibold">{{ $eventOrganizer->contact_person ?? '-' }}</p>
        </div>

        <div>
            <p class="text-muted">Telepon</p>
            <p class="font-semibold">{{ $eventOrganizer->phone ?? '-' }}</p>
        </div>

        <div>
            <p class="text-muted">Alamat</p>
            <p class="font-semibold">{{ $eventOrganizer->address ?? '-' }}</p>
        </div>

        <div>
            <p class="text-muted">Akun Login</p>
            <p class="font-semibold">{{ $eventOrganizer->user->email ?? '-' }}</p>
        </div>

        <div>
            <p class="text-muted">Status Akun</p>
            <p class="font-semibold
                {{ $eventOrganizer->user?->status === 'active'
                    ? 'text-success'
                    : 'text-danger' }}">
                {{ ucfirst($eventOrganizer->user->status ?? '-') }}
            </p>
        </div>

    </div>

    {{-- Admin Note --}}
    @if($eventOrganizer->admin_note)
        <div class="mt-5 p-4 bg-dangerSoft text-danger rounded-lg text-sm">
            <b>Catatan Admin:</b><br>
            {{ $eventOrganizer->admin_note }}
        </div>
    @endif

    {{-- ================= ACTION BAR ================= --}}
    <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t">

        {{-- Edit --}}
        <a href="{{ route('admin.event-organizers.edit',$eventOrganizer) }}"
           class="px-4 py-2 rounded-lg bg-primarySoft text-primary font-semibold hover:bg-primary/10">
            Edit EO
        </a>

        {{-- ===== PENDING ACTION ===== --}}
        @if($eventOrganizer->status === 'pending')

            <form method="POST"
                  action="{{ route('admin.event-organizers.approve',$eventOrganizer) }}">
                @csrf
                <button class="px-5 py-2 rounded-lg bg-success text-white font-semibold hover:bg-success/90">
                    Approve EO
                </button>
            </form>

            <button
                onclick="document.getElementById('rejectForm').classList.toggle('hidden')"
                class="px-5 py-2 rounded-lg bg-dangerSoft text-danger font-semibold hover:bg-danger/10">
                Reject EO
            </button>

        @endif

        {{-- ===== ACTIVE ACTION ===== --}}
        @if($eventOrganizer->status === 'active')
            <form method="POST"
                  action="{{ route('admin.event-organizers.suspend',$eventOrganizer) }}">
                @csrf
                <button class="px-4 py-2 rounded-lg bg-danger text-white hover:bg-danger/90">
                    Suspend EO
                </button>
            </form>
        @endif

        {{-- ===== SUSPENDED ACTION ===== --}}
        @if($eventOrganizer->status === 'suspended')
            <form method="POST"
                  action="{{ route('admin.event-organizers.activate',$eventOrganizer) }}">
                @csrf
                <button class="px-4 py-2 rounded-lg bg-success text-white hover:bg-success/90">
                    Aktifkan EO
                </button>
            </form>
        @endif

    </div>

    {{-- Reject Form --}}
    @if($eventOrganizer->status === 'pending')
    <form id="rejectForm"
          method="POST"
          action="{{ route('admin.event-organizers.reject',$eventOrganizer) }}"
          class="hidden mt-5 bg-dangerSoft/50 p-4 rounded-lg">
        @csrf

        <label class="text-sm font-semibold text-danger">
            Alasan Penolakan
        </label>

        <textarea name="admin_note"
                  required
                  rows="3"
                  class="w-full mt-2 border border-danger/30 rounded-lg px-3 py-2 text-sm"></textarea>

        <button class="mt-3 px-4 py-2 bg-danger text-white rounded-lg text-sm">
            Kirim Penolakan
        </button>
    </form>
    @endif

</div>

{{-- ================= TURNAMEN EO ================= --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b font-semibold">
        Turnamen Event Organizer
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
            @forelse($eventOrganizer->tournaments as $t)
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
