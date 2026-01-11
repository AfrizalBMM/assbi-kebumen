@extends('layouts.admin')
@section('title','Activity Log')

@section('content')

<h2 class="text-xl font-bold mb-4">Audit Aktivitas Sistem</h2>

<div class="flex gap-3 mb-4">
<form>
    <select name="role" onchange="this.form.submit()" class="border px-3 py-2 text-sm">
        <option value="">Semua Role</option>
        <option value="admin">Admin</option>
        <option value="eo">EO</option>
        <option value="club">Club</option>
    </select>
</form>

<form>
    <input name="search"
           placeholder="Cari aktivitas..."
           class="border px-3 py-2 text-sm">
</form>
</div>

<table class="w-full bg-white shadow text-sm">
<tr class="border-b bg-gray-100">
    <th class="p-2">Waktu</th>
    <th>User</th>
    <th>Role</th>
    <th>Aktivitas</th>
    <th>Objek</th>
    <th>IP</th>
</tr>

@foreach($logs as $log)
<tr class="border-b hover:bg-gray-50">
    <td class="p-2">
        {{ $log->created_at->format('d M Y H:i') }}
    </td>
    <td>{{ $log->user->name ?? '-' }}</td>
    <td>
        <span class="px-2 py-1 text-xs rounded
            @if($log->role=='admin') bg-blue-100 text-blue-700
            @elseif($log->role=='eo') bg-green-100 text-green-700
            @else bg-yellow-100 text-yellow-700
            @endif">
            {{ strtoupper($log->role) }}
        </span>
    </td>
    <td>{{ $log->description }}</td>
    <td>{{ $log->model_type }}</td>
    <td>{{ $log->ip_address }}</td>
</tr>
@endforeach
</table>

<div class="mt-4">
    {{ $logs->links() }}
</div>

@endsection
