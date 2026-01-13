<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClubDashboardController extends Controller
{
    public function index()
    {
        $club = auth()->user()->club->load('players.stats','tournaments');

        // Top scorer
        $topScorer = $club->players->sortByDesc(fn($p)=>$p->stats->sum('goals'))->first();

        // Most minutes
        $mostMinutes = $club->players->sortByDesc(fn($p)=>$p->stats->sum('minutes_played'))->first();

        // Top 5 performers
        $topPlayers = $club->players->map(function($p){
            return [
                'player' => $p,
                'matches' => $p->stats->count(),
                'goals' => $p->stats->sum('goals'),
                'assists' => $p->stats->sum('assists'),
                'minutes' => $p->stats->sum('minutes_played'),
            ];
        })->sortByDesc('goals')->take(5);

        return view('club.dashboard', compact(
            'club',
            'topScorer',
            'mostMinutes',
            'topPlayers'
        ));
    }

}
