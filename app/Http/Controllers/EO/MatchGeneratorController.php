<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\MatchGame;

class MatchGeneratorController extends Controller
{
    public function generateGroupMatches(Tournament $tournament)
    {
        // hanya EO pemilik
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );

        // hapus jadwal lama
        MatchGame::where('tournament_id',$tournament->id)
            ->where('stage','group')
            ->delete();

        foreach ($tournament->groups as $group) {

            $clubs = $group->clubs;

            for ($i = 0; $i < $clubs->count(); $i++) {
                for ($j = $i + 1; $j < $clubs->count(); $j++) {

                    MatchGame::create([
                        'tournament_id' => $tournament->id,
                        'tournament_group_id' => $group->id,
                        'home_club_id' => $clubs[$i]->id,
                        'away_club_id' => $clubs[$j]->id,
                        'stage' => 'group',
                        'status' => 'scheduled'
                    ]);
                }
            }
        }

        return back()->with('success','Jadwal grup berhasil digenerate');
    }
}
