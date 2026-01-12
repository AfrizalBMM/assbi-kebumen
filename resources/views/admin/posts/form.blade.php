<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">

    <div>
        <label class="text-sm text-muted">Judul</label>
        <input name="title"
               value="{{ old('title',$post->title ?? '') }}"
               class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary"
               required>
    </div>

    <div>
        <label class="text-sm text-muted">Tipe Konten</label>
        <select name="type"
                class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
            @foreach(['news'=>'Berita','article'=>'Artikel','announcement'=>'Pengumuman'] as $k=>$v)
                <option value="{{ $k }}" @selected(old('type',$post->type ?? '')==$k)>
                    {{ $v }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm text-muted">Isi Konten</label>
        <textarea name="content" rows="8"
            class="w-full mt-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">{{ old('content',$post->content ?? '') }}</textarea>
    </div>

    <div>
        <label class="text-sm text-muted">Thumbnail</label>
        <input type="file" name="thumbnail"
               class="block w-full text-sm text-gray-500">
        @if(!empty($post->thumbnail))
            <img src="{{ asset('storage/'.$post->thumbnail) }}"
                 class="w-40 mt-3 rounded border">
        @endif
    </div>

</div>
