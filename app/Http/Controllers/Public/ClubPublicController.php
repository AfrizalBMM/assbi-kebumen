<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Club;

class ClubPublicController extends Controller
{
    public function index()
    {
        $clubs = Club::where('status','active')
            ->orderBy('name')
            ->paginate(20);

        return view('public.clubs.index', compact('clubs'));
    }

    public function show($slug)
    {
        $club = Club::where('slug',$slug)
            ->with('players')
            ->firstOrFail();

        return view('public.clubs.show', compact('club'));
    }
}

