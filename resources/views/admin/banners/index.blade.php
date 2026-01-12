@extends('layouts.admin')
@section('title','Banner')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
            🖼 Banner Slider
        </h2>

        <a href="{{ route('admin.banners.create') }}"
           class="btn-primary">
            + Tambah Banner
        </a>
    </div>

    {{-- Table Card --}}
    <div class="card overflow-hidden">

        <table class="table">
            <thead>
                <tr>
                    <th class="text-left">Preview</th>
                    <th>Judul</th>
                    <th class="text-center">Urutan</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($banners as $b)
                <tr>
                    <td class="flex items-center gap-3">
                        <img src="{{ asset('storage/'.$b->image) }}"
                             class="h-12 w-24 object-cover rounded shadow border">
                    </td>

                    <td class="font-medium">
                        {{ $b->title ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $b->order }}
                    </td>

                    <td class="text-center">
                        @if($b->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-muted">Nonaktif</span>
                        @endif
                    </td>

                    <td class="text-right space-x-2">
                        <a href="{{ route('admin.banners.edit',$b) }}"
                           class="btn-ghost text-sm">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.banners.destroy',$b) }}"
                              class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus banner?')"
                                    class="btn-danger text-sm px-3 py-1.5">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>
@endsection
