@extends('layouts.admin')
@section('title','Konten')
@section('page_title','Konten ASSBI')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">
            Konten ASSBI
        </h2>

        <div class="flex items-center gap-3">
            <form method="GET">
                <select name="type"
                        onchange="this.form.submit()"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary">
                    <option value="">Semua</option>
                    <option value="news" @selected(request('type')=='news')>Berita</option>
                    <option value="article" @selected(request('type')=='article')>Artikel</option>
                    <option value="announcement" @selected(request('type')=='announcement')>Pengumuman</option>
                </select>
            </form>

            <a href="{{ route('admin.posts.create') }}"
               class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary/90">
                + Tambah Konten
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-muted">
                <tr>
                    <th class="px-6 py-3 text-left">Judul</th>
                    <th class="px-6 py-3 text-center">Tipe</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @forelse($posts as $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3">
                        <p class="font-semibold text-slate-800">{{ $p->title }}</p>
                        <p class="text-xs text-muted">{{ $p->created_at->format('d M Y') }}</p>
                    </td>

                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-primarySoft text-primary">
                            {{ strtoupper($p->type) }}
                        </span>
                    </td>

                    <td class="px-6 py-3 text-center">
                        @if($p->is_published)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-successSoft text-success">
                                Published
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                                Draft
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-3 text-right space-x-3">
                        <a href="{{ route('admin.posts.edit',$p) }}"
                           class="text-primary hover:underline text-sm">
                           Edit
                        </a>

                        @if(!$p->is_published)
                            <form method="POST" action="{{ route('admin.posts.publish',$p) }}" class="inline">
                                @csrf
                                <button class="text-success hover:underline text-sm">
                                    Publish
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.posts.unpublish',$p) }}" class="inline">
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
                    <td colspan="4" class="px-6 py-10 text-center text-muted">
                        Belum ada konten
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

    {{ $posts->withQueryString()->links() }}

</div>

@endsection
