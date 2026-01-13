@extends('layouts.club')

@section('title','Profil Club')

@section('content')

<div class="max-w-7xl mx-auto px-6">

    <h2 class="text-2xl font-bold mb-6">Profil Club</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- PANEL KIRI --}}
        <div class="bg-white p-6 rounded-xl shadow flex flex-col items-center">
            <div class="text-center">
                @if($club->logo)
                    <img src="{{ asset('storage/'.$club->logo) }}"
                         class="w-32 h-32 mx-auto rounded-full object-cover">
                @else
                    <div class="w-32 h-32 mx-auto bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                        LOGO
                    </div>
                @endif

                <h3 class="mt-4 text-lg font-semibold">{{ $club->name }}</h3>
                <p class="text-sm text-gray-500">{{ $club->short_name }}</p>

                <span class="inline-block mt-2 px-3 py-1 text-xs rounded
                    {{ $club->status=='active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($club->status) }}
                </span>
            </div>
        </div>

        {{-- PANEL KANAN --}}
        <div class="lg:col-span-3 bg-white p-8 rounded-xl shadow">

            <form id="clubProfileForm"
                method="POST"
                action="{{ route('club.profile.update') }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm">Nama Club</label>
                        <input name="name"
                            value="{{ old('name',$club->name) }}"
                            class="w-full border px-3 py-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm">Nama Singkat</label>
                        <input name="short_name"
                            value="{{ old('short_name',$club->short_name) }}"
                            class="w-full border px-3 py-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm">Nama Pelatih</label>
                        <input name="coach_name"
                            value="{{ old('coach_name',$club->coach_name) }}"
                            class="w-full border px-3 py-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm">No. HP Pelatih</label>
                        <input name="coach_phone"
                            value="{{ old('coach_phone',$club->coach_phone) }}"
                            class="w-full border px-3 py-2 rounded">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm">Alamat</label>
                        <textarea name="address"
                                class="w-full border px-3 py-2 rounded"
                                rows="3">{{ old('address',$club->address) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm">Logo Club</label>
                        <input type="file" name="logo">
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-6 flex justify-end">
                    <button type="button"
                        onclick="confirmAction(
                            'Simpan perubahan profil club ini?',
                            'warning',
                            ()=> document.getElementById('clubProfileForm').submit()
                        )"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection
