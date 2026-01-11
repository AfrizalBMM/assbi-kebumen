<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Post;
use App\Models\Club;
use App\Models\Player;
use App\Models\MatchGame;
use App\Models\MatchPlayerStat;
use App\Models\Banner;

class HomeController extends Controller
{
    public function __invoke()
    {
        $activeTournaments = Tournament::whereIn('status',['open','ongoing'])
            ->orderBy('start_date')
            ->limit(6)
            ->get();

        $upcomingTournaments = Tournament::where('status','draft')
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        $news = Post::latest()->limit(4)->get();

        $clubs = Club::where('status','active')
            ->withCount('players')
            ->limit(8)
            ->get();

        $topScorers = MatchPlayerStat::selectRaw('player_id, SUM(goals) as goals')
            ->groupBy('player_id')
            ->orderByDesc('goals')
            ->with('player.club')
            ->limit(5)
            ->get();

        $banners = \App\Models\TournamentBanner::where('is_active',1)
            ->where('is_approved',1)
            ->orderBy('order')
            ->get();

        return view('public.home', compact(
            'activeTournaments',
            'upcomingTournaments',
            'news',
            'clubs',
            'banners',
            'topScorers'
        ));
    }
}

