@extends('layouts.admin')
@section('title','Edit Event Organizer')

@section('content')

<h2 class="text-lg font-semibold mb-4">Edit Event Organizer</h2>

<form method="POST"
      action="{{ route('admin.event-organizers.update',$eo) }}"
      class="bg-white p-6 rounded shadow max-w-xl">

@csrf
@method('PUT')

<label class="text-sm">Nama EO</label>
<input name="name"
       value="{{ $eo->name }}"
       class="w-full border px-3 py-2 mb-3" required>

<label class="text-sm">Contact Person</label>
<input name="contact_person"
       value="{{ $eo->contact_person }}"
       class="w-full border px-3 py-2 mb-3">

<label class="text-sm">Email</label>
<input name="email"
       value="{{ $eo->email }}"
       class="w-full border px-3 py-2 mb-3">

<label class="text-sm">Telepon</label>
<input name="phone"
       value="{{ $eo->phone }}"
       class="w-full border px-3 py-2 mb-3">

<label class="text-sm">Alamat</label>
<textarea name="address"
          class="w-full border px-3 py-2 mb-3">{{ $eo->address }}</textarea>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan
</button>

<a href="{{ route('admin.event-organizers.show',$eo) }}"
   class="ml-2 text-gray-600">Batal</a>

</form>

@endsection
