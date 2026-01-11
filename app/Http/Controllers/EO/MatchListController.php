<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\MatchGame;

class MatchListController extends Controller
{
    public function index(Tournament $tournament)
    {
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );

        $matches = MatchGame::where('tournament_id',$tournament->id)
            ->where('stage','group')
            ->orderBy('tournament_group_id')
            ->get();

        return view('eo.tournaments.matches',
            compact('tournament','matches'));
    }
}

