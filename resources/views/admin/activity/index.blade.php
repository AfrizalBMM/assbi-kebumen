@extends('layouts.admin')
@section('title','Activity Log')
@section('page_title','Audit Aktivitas Sistem')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">
            Audit Aktivitas Sistem
        </h2>
    </div>

    {{-- Filters --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-wrap gap-3">

        <form>
            <select name="role"
                onchange="this.form.submit()"
                class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary">
                <option value="">Semua Role</option>
                <option value="admin" @selected(request('role')=='admin')>Admin</option>
                <option value="eo" @selected(request('role')=='eo')>EO</option>
                <option value="club" @selected(request('role')=='club')>Club</option>
            </select>
        </form>

        <form class="flex-1">
            <input name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari aktivitas, user, atau objek..."
                   class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:ring-primary focus:border-primary">
        </form>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-muted">
                <tr>
                    <th class="px-6 py-3 text-left">Waktu</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-center">Role</th>
                    <th class="px-6 py-3 text-left">Aktivitas</th>
                    <th class="px-6 py-3 text-left">Objek</th>
                    <th class="px-6 py-3 text-center">IP</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @foreach($logs as $log)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-muted">
                        {{ $log->created_at->format('d M Y H:i') }}
                    </td>

                    <td class="px-6 py-3 font-medium">
                        {{ $log->user->name ?? 'System' }}
                    </td>

                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $log->role=='admin'
                            ? 'bg-primarySoft text-primary'
                            : ($log->role=='eo'
                                ? 'bg-purple-100 text-purple-700'
                                : 'bg-blue-100 text-blue-700') }}">
                            {{ strtoupper($log->role) }}
                        </span>
                    </td>

                    <td class="px-6 py-3">
                        {{ $log->description }}
                    </td>

                    <td class="px-6 py-3 text-muted">
                        {{ class_basename($log->target_type) }}
                    </td>

                    <td class="px-6 py-3 text-center text-muted">
                        {{ $log->ip_address ?? '-' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <div>
        {{ $logs->links() }}
    </div>

</div>

@endsection
