@extends('layouts.admin')
@section('title','Tambah User')
@section('page_title','Tambah User')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <h2 class="text-xl font-semibold text-slate-800 mb-6">Tambah User</h2>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-muted">Nama</label>
                <input name="name" required
                       class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label class="text-sm text-muted">Email</label>
                <input name="email" type="email" required
                       class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label class="text-sm text-muted">Password</label>
                <input name="password" type="password" required
                       class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label class="text-sm text-muted">Role</label>
                <select name="role"
                        class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
                    <option value="admin">Admin</option>
                    <option value="eo">EO</option>
                    <option value="club">Club</option>
                </select>
            </div>

            <div>
                <label class="text-sm text-muted">Club (jika role Club)</label>
                <select name="club_id"
                        class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
                    <option value="">-- Pilih Club --</option>
                    @foreach($clubs as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-muted">Event Organizer (jika role EO)</label>
                <select name="event_organizer_id"
                        class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
                    <option value="">-- Pilih EO --</option>
                    @foreach($eos as $e)
                        <option value="{{ $e->id }}">{{ $e->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                    Batal
                </a>

                <button class="px-6 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 transition">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
