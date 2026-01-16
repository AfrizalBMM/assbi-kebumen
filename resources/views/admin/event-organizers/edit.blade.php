@extends('layouts.admin')
@section('title','Edit Event Organizer')
@section('page_title','Edit Event Organizer')

@section('content')

<div class="max-w-4xl mx-auto">

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

<h2 class="text-xl font-bold text-slate-800 mb-6">
    Edit Event Organizer
</h2>

<form method="POST"
      action="{{ route('admin.event-organizers.update',$eventOrganizer) }}">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <div>
        <label class="text-sm text-muted">Nama EO</label>
        <input name="name"
               value="{{ $eventOrganizer->name }}"
               class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary"
               required>
    </div>

    <div>
        <label class="text-sm text-muted">Contact Person</label>
        <input name="contact_person"
               value="{{ $eventOrganizer->contact_person }}"
               class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
    </div>

    <div>
        <label class="text-sm text-muted">Email</label>
        <input name="email"
               value="{{ $eventOrganizer->email }}"
               class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
    </div>

    <div>
        <label class="text-sm text-muted">Telepon</label>
        <input name="phone"
               value="{{ $eventOrganizer->phone }}"
               class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
    </div>

    <div class="md:col-span-2">
        <label class="text-sm text-muted">Alamat</label>
        <textarea name="address"
                  rows="3"
                  class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">{{ $eventOrganizer->address }}</textarea>
    </div>

</div>

<div class="flex justify-end gap-3 mt-6">
    <a href="{{ route('admin.event-organizers.show',$eventOrganizer) }}"
       class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
        Batal
    </a>

    <button class="px-5 py-2 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90">
        Simpan
    </button>
</div>

</form>

</div>
</div>

@endsection
