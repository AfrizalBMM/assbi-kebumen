<div class="mb-3">
    <label class="text-sm font-medium">Nama Turnamen</label>
    <input type="text"
           name="name"
           value="{{ old('name', $tournament->name ?? '') }}"
           class="w-full border rounded px-3 py-2"
           required>
</div>

<div class="mb-3">
    <label class="text-sm font-medium">Kategori (U10, U12, dll)</label>
    <input type="text"
           name="category"
           value="{{ old('category', $tournament->category ?? '') }}"
           class="w-full border rounded px-3 py-2"
           required>
</div>

<div class="grid grid-cols-2 gap-4 mb-3">
    <div>
        <label class="text-sm font-medium">Tanggal Mulai</label>
        <input type="date"
               name="start_date"
               value="{{ old('start_date', $tournament->start_date ?? '') }}"
               class="w-full border rounded px-3 py-2"
               required>
    </div>

    <div>
        <label class="text-sm font-medium">Tanggal Selesai</label>
        <input type="date"
               name="end_date"
               value="{{ old('end_date', $tournament->end_date ?? '') }}"
               class="w-full border rounded px-3 py-2"
               required>
    </div>
</div>

<div class="mb-3">
    <label class="text-sm font-medium">Lokasi</label>
    <input type="text"
           name="location"
           value="{{ old('location', $tournament->location ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="grid grid-cols-2 gap-4 mb-3">
    <div>
        <label class="text-sm font-medium">Max Peserta</label>
        <input type="number"
               name="max_participants"
               value="{{ old('max_participants', $tournament->max_participants ?? '') }}"
               class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="text-sm font-medium">Biaya Pendaftaran</label>
        <input type="number"
               name="registration_fee"
               value="{{ old('registration_fee', $tournament->registration_fee ?? '') }}"
               class="w-full border rounded px-3 py-2">
    </div>
</div>

<div class="mb-3">
    <label class="text-sm font-medium">Deskripsi</label>
    <textarea name="description"
              class="w-full border rounded px-3 py-2"
              rows="4">{{ old('description', $tournament->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="text-sm font-medium">
        PDF Regulasi <span class="text-xs text-gray-500">(Opsional)</span>
    </label>
    <p class="text-xs text-gray-500 mt-1">
        Boleh dikosongkan. Dapat diupload nanti sebelum publish.
    </p>

    <input type="file"
           name="regulation_pdf"
           accept="application/pdf"
           class="w-full border rounded px-3 py-2">
    <p class="text-xs text-gray-500 mt-1">
        Format PDF, maksimal 2MB
    </p>
</div>
