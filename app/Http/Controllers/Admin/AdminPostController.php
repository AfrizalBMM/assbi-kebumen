<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;

        $posts = Post::when($type, fn($q)=>$q->where('type',$type))
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts','type'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required',
            'content'=>'required',
            'type'=>'required|in:news,article,announcement',
            'thumbnail'=>'nullable|image|max:2048'
        ]);

        if($request->hasFile('thumbnail')){
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('posts','public');
        }

        $data['slug'] = Str::slug($data['title']).'-'.uniqid();
        $data['is_published'] = false;

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success','Konten dibuat (Draft)');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'=>'required',
            'content'=>'required',
            'type'=>'required|in:news,article,announcement',
            'thumbnail'=>'nullable|image|max:2048',
            'is_published'=>'nullable|boolean'
        ]);

        if($request->hasFile('thumbnail')){
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('posts','public');
        }

        $post->update($data);

        return back()->with('success','Konten diperbarui');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success','Konten dihapus');
    }

    public function publish(Post $post)
    {
        $post->update(['is_published'=>true]);
        return back()->with('success','Konten dipublish');
    }

    public function unpublish(Post $post)
    {
        $post->update(['is_published'=>false]);
        return back()->with('success','Konten disembunyikan');
    }
}
