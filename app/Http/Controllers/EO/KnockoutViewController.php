<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\MatchGame;

class KnockoutViewController extends Controller
{
    public function index(Tournament $tournament)
    {
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );

        $matches = MatchGame::where('tournament_id',$tournament->id)
            ->where('stage','!=','group')
            ->orderByRaw("FIELD(stage,'quarter_final','semi_final','final')")
            ->get();

        return view('eo.tournaments.knockout',
            compact('tournament','matches'));
    }
}
