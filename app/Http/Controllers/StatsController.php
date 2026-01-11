<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\MatchPlayerStat;

class StatsController extends Controller
{
    public function topScorers(Tournament $tournament)
    {
        $topScorers = MatchPlayerStat::whereHas('match', function($q) use($tournament){
                $q->where('tournament_id', $tournament->id);
            })
            ->selectRaw('player_id, SUM(goals) as goals')
            ->groupBy('player_id')
            ->orderByDesc('goals')
            ->with('player.club')
            ->get();

        return view('stats.top_scorers', compact('tournament','topScorers'));
    }

    public function fairPlay(Tournament $tournament)
    {
        $fairPlay = MatchPlayerStat::whereHas('match', function($q) use($tournament){
                $q->where('tournament_id',$tournament->id);
            })
            ->selectRaw('player_id,
                SUM(yellow_cards) as yellow,
                SUM(red_cards) as red')
            ->groupBy('player_id')
            ->orderBy('red')
            ->orderBy('yellow')
            ->with('player.club')
            ->get();

        return view('stats.fair_play', compact('tournament','fairPlay'));
    }


}
