@extends('layouts.admin')
@section('title','User Management')
@section('page_title','User Management')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Data User</h2>
            <p class="text-sm text-muted">Kelola seluruh akun di sistem ASSBI</p>
        </div>

        <div class="flex items-center gap-3">
            <form>
                <select name="role" onchange="this.form.submit()"
                        class="px-3 py-2 text-sm rounded-lg border border-gray-200 bg-white
                               focus:ring-primary focus:border-primary">
                    <option value="">Semua Role</option>
                    @foreach(['admin','eo','club'] as $r)
                        <option value="{{ $r }}" @selected($role==$r)>
                            {{ strtoupper($r) }}
                        </option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold
                      bg-primary text-white hover:bg-primary/90 transition">
                + Tambah User
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-muted">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Nama</th>
                    <th class="px-6 py-3 text-left font-semibold">Email</th>
                    <th class="px-6 py-3 text-center font-semibold">Role</th>
                    <th class="px-6 py-3 text-center font-semibold">Status</th>
                    <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">

                    {{-- Nama --}}
                    <td class="px-6 py-3 font-medium text-slate-800">
                        {{ $user->name }}
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-3 text-muted">
                        {{ $user->email }}
                    </td>

                    {{-- Role --}}
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $user->role=='admin' ? 'bg-primarySoft text-primary'
                           : ($user->role=='eo' ? 'bg-purple-100 text-purple-700'
                           : 'bg-blue-100 text-blue-700') }}">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $user->status=='active'
                            ? 'bg-successSoft text-success'
                            : ($user->status=='pending'
                                ? 'bg-yellow-100 text-yellow-700'
                                : 'bg-dangerSoft text-danger') }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-3 text-right">
                        <a href="{{ route('admin.users.show',$user) }}"
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
        {{ $users->links() }}
    </div>

</div>

@endsection
