@extends('layouts.club')
@section('title','Background KTA')
@section('page_title','Background KTA')

@section('content')

<div class="max-w-5xl mx-auto p-6">

<h2 class="text-xl font-bold mb-4">Background KTA</h2>

<form id="bgForm" class="bg-white p-6 rounded shadow mb-6">
@csrf

<label>Nama Template</label>
<input id="bgName"
       name="name"
       required
       class="border px-3 py-2 rounded w-full mb-3">


<input type="file" id="bgInput" accept="image/*" hidden>

<button type="button"
 onclick="document.getElementById('bgInput').click()"
 class="bg-blue-600 text-white px-4 py-2 rounded">
Pilih Gambar
</button>

<img id="cropImage" class="mt-4 max-w-full hidden">

<button id="cropBtn" type="button"
 class="mt-4 bg-green-600 text-white px-4 py-2 rounded hidden">
Crop & Simpan
</button>

</form>

<div class="grid grid-cols-3 gap-4">
@foreach($items as $bg)
<div class="border rounded p-3 text-center relative">

    <img src="{{ asset('storage/'.$bg->image_path) }}" class="w-full rounded mb-2">

    <div class="text-sm font-semibold mb-2">{{ $bg->name }}</div>

    @if($bg->is_active)
        <span class="text-green-600 text-xs font-bold">AKTIF</span>
    @else
        <div class="flex justify-center gap-2">
            <form method="POST" action="{{ route('club.kta-backgrounds.update',$bg) }}">
                @csrf @method('PUT')
                <button class="text-blue-600 text-xs">Gunakan</button>
            </form>

            <form method="POST"
                  action="{{ route('club.kta-backgrounds.destroy',$bg) }}"
                  onsubmit="return confirm('Hapus background ini?')">
                @csrf @method('DELETE')
                <button class="text-red-600 text-xs">Hapus</button>
            </form>
        </div>
    @endif

</div>

@endforeach
</div>

</div>

@endsection

@push('scripts')
<script>
let cropper;

const bgInput = document.getElementById('bgInput');
const cropImage = document.getElementById('cropImage');
const cropBtn = document.getElementById('cropBtn');
const nameField = document.getElementById('bgName');

bgInput.onchange = e => {
    cropImage.src = URL.createObjectURL(e.target.files[0]);
    cropImage.classList.remove('hidden');

    cropper = new Cropper(cropImage, {
        aspectRatio: 620/874,
        viewMode: 1,
        autoCropArea: 1
    });

    cropBtn.classList.remove('hidden');
};

cropBtn.onclick = () => {
    if (!nameField.value.trim()) {
        showWarning('Nama template wajib diisi sebelum menyimpan background KTA.');
        nameField.focus();
        return;
    }

    const canvas = cropper.getCroppedCanvas({ width:620, height:874 });

    canvas.toBlob(blob => {
        const formData = new FormData();
        formData.append('image', blob, 'kta-bg.png');
        formData.append('name', nameField.value);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("club.kta-backgrounds.store") }}', {
            method: 'POST',
            body: formData
        })
        .then(async r => {
            const data = await r.json();
            if(!r.ok) throw data;
            return data;
        })
        .then(() => location.reload())
        .catch(e => {
            alert("Upload gagal: " + (e.error ?? 'unknown error'));
        });

    });
};

function showWarning(message){
    document.getElementById('confirmMessage').innerText = message;
    document.getElementById('confirmModal').classList.remove('hidden');

    const box = document.getElementById('confirmBox');
    const btn = document.getElementById('confirmOk');

    box.className = "bg-white w-[420px] rounded-xl shadow-xl p-6 border-t-8 border-yellow-500";
    btn.className = "hidden"; // tidak perlu tombol OK
}
</script>
@endpush

</div>
