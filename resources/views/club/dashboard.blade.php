@extends('layouts.club')

@section('title','Dashboard Club')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Pemain</h3>
        <p class="text-3xl font-bold text-blue-900">
            {{ auth()->user()->club->players()->count() ?? 0 }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Turnamen Diikuti</h3>
        <p class="text-3xl font-bold text-blue-900">
            {{ auth()->user()->club->tournaments()->count() ?? 0 }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Status Club</h3>
        <p class="text-lg font-semibold text-green-600">
            {{ strtoupper(auth()->user()->club->status) }}
        </p>
    </div>

</div>
@endsection
