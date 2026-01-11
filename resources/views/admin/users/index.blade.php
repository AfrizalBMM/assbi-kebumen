@extends('layouts.admin')
@section('title','User Management')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-lg font-semibold">Data User</h2>

    <div class="flex gap-2">
        <form>
            <select name="role" onchange="this.form.submit()"
                class="border px-2 py-1 text-sm rounded">
                <option value="">Semua Role</option>
                @foreach(['admin','eo','club'] as $r)
                    <option value="{{ $r }}" @selected($role==$r)>
                        {{ strtoupper($r) }}
                    </option>
                @endforeach
            </select>
        </form>

        <a href="{{ route('admin.users.create') }}"
           class="bg-green-600 text-white px-3 py-2 rounded text-sm">
            + User
        </a>
    </div>
</div>

<div class="bg-white rounded shadow">
<table class="w-full text-sm">
    <thead class="border-b">
        <tr>
            <th class="p-3 text-left">Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th class="text-right p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr class="border-b">
            <td class="p-3">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ strtoupper($user->role) }}</td>
            <td>{{ ucfirst($user->status) }}</td>
            <td class="text-right p-3">
                <a href="{{ route('admin.users.show',$user) }}"
                   class="text-blue-600 hover:underline">Detail</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
