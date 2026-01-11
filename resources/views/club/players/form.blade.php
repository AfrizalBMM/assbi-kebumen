<div class="mb-3">
    <label class="text-sm">Nama Lengkap</label>
    <input name="name"
           value="{{ old('name',$player->name ?? '') }}"
           class="w-full border rounded px-3 py-2"
           required>
</div>

<div class="mb-3">
    <label class="text-sm">Tempat Lahir</label>
    <input name="birth_place"
           value="{{ old('birth_place',$player->birth_place ?? '') }}"
           class="w-full border rounded px-3 py-2"
           required>
</div>

<div class="mb-3">
    <label class="text-sm">Tanggal Lahir</label>
    <input type="date"
           name="birth_date"
           value="{{ old('birth_date',$player->birth_date ?? '') }}"
           class="w-full border rounded px-3 py-2"
           required>
</div>

<div class="mb-3">
    <label class="text-sm">Posisi</label>
    <select name="position"
            class="w-full border rounded px-3 py-2" required>
        @foreach(['GK','DF','MF','FW'] as $pos)
            <option value="{{ $pos }}"
                @selected(($player->position ?? '') == $pos)>
                {{ $pos }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="text-sm">Foto Pemain (Opsional)</label>
    <input type="file" name="photo" class="w-full border px-2 py-1">
</div>

<div class="mb-3">
    <label class="text-sm">Dokumen (PDF Opsional)</label>
    <input type="file" name="document_pdf" accept="application/pdf"
           class="w-full border px-2 py-1">
</div>

<div class="mb-3">
    <label class="text-sm">NIK (Opsional)</label>
    <input name="nik"
           value="{{ old('nik',$player->nik ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>
