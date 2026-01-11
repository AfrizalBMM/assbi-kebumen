<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\MatchPlayerStat;

class PlayerPublicController extends Controller
{
    public function show(Player $player)
    {
        // Statistik per turnamen
        $stats = MatchPlayerStat::where('player_id', $player->id)
            ->with('matchGame.tournament')
            ->get()
            ->groupBy(fn($s) => $s->matchGame->tournament_id);

        // Total statistik
        $totals = [
            'goals' => $stats->flatten()->sum('goals'),
            'yellow_cards' => $stats->flatten()->sum('yellow_cards'),
            'red_cards' => $stats->flatten()->sum('red_cards'),
            'minutes_played' => $stats->flatten()->sum('minutes_played'),
        ];

        return view('public.players.show', compact(
            'player','stats','totals'
        ));
    }
}
