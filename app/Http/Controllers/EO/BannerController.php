<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        $banners = $tournament->banners()->latest()->get();
        return view('eo.banners.index', compact('tournament','banners'));
    }

    public function store(Request $request, Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'link' => 'nullable|url'
        ]);

        $data['image'] = $request->file('image')->store('banners','public');
        $data['event_organizer_id'] = auth()->user()->eventOrganizer->id;

        $tournament->banners()->create($data);

        return back()->with('success','Banner dikirim, menunggu persetujuan Admin');
    }

    public function toggle(TournamentBanner $banner)
    {
        abort_if($banner->event_organizer_id !== auth()->user()->eventOrganizer->id, 403);

        $banner->update(['is_active'=>!$banner->is_active]);

        return back();
    }

    private function authorizeEO(Tournament $tournament)
    {
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );
    }
}
