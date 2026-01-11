<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index($type)
    {
        abort_unless(in_array($type,['news','article','announcement']),404);

        $posts = Post::where('type',$type)
            ->where('is_published',true)
            ->latest()
            ->paginate(10);

        return view('public.posts.index', compact('posts','type'));
    }

    public function show($type, $slug)
    {
        abort_unless(in_array($type,['news','article','announcement']),404);

        $post = Post::where('type',$type)
            ->where('slug',$slug)
            ->where('is_published',true)
            ->firstOrFail();

        return view('public.posts.show', compact('post','type'));
    }
}


