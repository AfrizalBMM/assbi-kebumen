@extends('layouts.admin')

@section('title','Konten')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-blue-900">
        📄 Konten ASSBI
    </h2>

    <div class="flex items-center gap-3">

        <form method="GET">
            <select name="type" onchange="this.form.submit()"
                class="border rounded px-3 py-2 text-sm focus:ring focus:ring-blue-200">
                <option value="">Semua</option>
                <option value="news" {{ request('type')=='news'?'selected':'' }}>Berita</option>
                <option value="article" {{ request('type')=='article'?'selected':'' }}>Artikel</option>
                <option value="announcement" {{ request('type')=='announcement'?'selected':'' }}>Pengumuman</option>
            </select>
        </form>

        <a href="{{ route('admin.posts.create') }}"
           class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded text-sm font-semibold">
            + Tambah Konten
        </a>
    </div>
</div>

<div class="bg-white shadow rounded overflow-hidden">

<table class="w-full text-sm">
<thead class="bg-blue-50 border-b">
<tr>
    <th class="p-3 text-left">Judul</th>
    <th class="p-3">Tipe</th>
    <th class="p-3">Status</th>
    <th class="p-3 text-right">Aksi</th>
</tr>
</thead>

<tbody>
@forelse($posts as $p)
<tr class="border-b hover:bg-gray-50">
    <td class="p-3">
        <div class="font-semibold">{{ $p->title }}</div>
        <div class="text-xs text-gray-500">{{ $p->created_at->format('d M Y') }}</div>
    </td>

    <td class="p-3 text-center">
        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
            {{ strtoupper($p->type) }}
        </span>
    </td>

    <td class="p-3 text-center">
        @if($p->is_published)
            <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Published</span>
        @else
            <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-600">Draft</span>
        @endif
    </td>

    <td class="p-3 text-right space-x-2">
        <a href="{{ route('admin.posts.edit',$p) }}"
           class="text-blue-600 hover:underline text-sm">
           Edit
        </a>

        @if(!$p->is_published)
            <form method="POST"
                  action="{{ route('admin.posts.publish',$p) }}"
                  class="inline">
                @csrf
                <button class="text-green-600 hover:underline text-sm">
                    Publish
                </button>
            </form>
        @else
            <form method="POST"
                  action="{{ route('admin.posts.unpublish',$p) }}"
                  class="inline">
                @csrf
                <button class="text-yellow-600 hover:underline text-sm">
                    Unpublish
                </button>
            </form>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="p-6 text-center text-gray-500">
        Belum ada konten
    </td>
</tr>
@endforelse
</tbody>
</table>

</div>

<div class="mt-6">
    {{ $posts->withQueryString()->links() }}
</div>

@endsection
