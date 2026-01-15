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
            <div class="text-center w-full">

                {{-- Logo --}}
                @if($club->logo)
                    <img src="{{ asset('storage/'.$club->logo) }}"
                        class="w-32 h-32 mx-auto rounded-full object-cover shadow">
                @else
                    <div class="w-32 h-32 mx-auto bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                        LOGO
                    </div>
                @endif

                <h3 class="mt-4 text-lg font-semibold">{{ $club->name }}</h3>
                <p class="text-sm text-gray-500">{{ $club->short_name }}</p>

                {{-- Status --}}
                <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full font-semibold
                    {{ $club->status=='active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($club->status) }}
                </span>

                {{-- Upload Logo --}}
                <div class="mt-5 w-full">
                    <label class="block text-xs font-semibold text-gray-500 mb-2">
                        Ganti Logo Club
                    </label>

                    <div class="flex flex-col items-center">

                        {{-- Preview --}}
                        <img id="logoPreview"
                            src="{{ $club->logo ? asset('storage/'.$club->logo) : '' }}"
                            class="w-24 h-24 rounded-full object-cover shadow mb-3
                                    {{ $club->logo ? '' : 'hidden' }}">

                        <label class="cursor-pointer inline-flex items-center gap-2
                                    px-4 py-2 rounded-lg bg-blue-50 text-blue-700
                                    hover:bg-blue-100 transition text-xs font-semibold">

                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 12h14M12 5v14"/>
                            </svg>

                            Pilih Logo

                            <input type="file" name="logo" form="clubProfileForm"
                                accept="image/*"
                                class="hidden"
                                onchange="previewLogo(event)">
                        </label>

                        <span id="logoFilename" class="mt-2 text-gray-500">
                            JPG / PNG, max 2MB
                        </span>
                    </div>
                </div>

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

<script>
function previewLogo(event) {
    const file = event.target.files[0];
    if (!file) return;

    document.getElementById('logoFilename').innerText = file.name;

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('logoPreview');
        img.src = e.target.result;
        img.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}
</script>


@endsection
