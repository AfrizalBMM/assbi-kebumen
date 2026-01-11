@extends('layouts.admin')
@section('page_title','Dashboard')

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

<div class="bg-white p-5 rounded shadow border-l-4 border-blue-900">
    <div class="text-gray-500 text-sm">Club</div>
    <div class="text-3xl font-bold">{{ \App\Models\Club::count() }}</div>
</div>

<div class="bg-white p-5 rounded shadow border-l-4 border-green-600">
    <div class="text-gray-500 text-sm">EO</div>
    <div class="text-3xl font-bold">{{ \App\Models\EventOrganizer::count() }}</div>
</div>

<div class="bg-white p-5 rounded shadow border-l-4 border-yellow-500">
    <div class="text-gray-500 text-sm">Turnamen</div>
    <div class="text-3xl font-bold">{{ \App\Models\Tournament::count() }}</div>
</div>

<div class="bg-white p-5 rounded shadow border-l-4 border-red-600">
    <div class="text-gray-500 text-sm">User</div>
    <div class="text-3xl font-bold">{{ \App\Models\User::count() }}</div>
</div>

</div>
