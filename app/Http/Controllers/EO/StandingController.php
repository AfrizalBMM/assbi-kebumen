<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\MatchGame;

class StandingController extends Controller
{
    public function index(Tournament $tournament)
    {
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );

        $groups = $tournament->groups;

        $standings = [];

        foreach ($groups as $group) {

            $table = [];

            foreach ($group->clubs as $club) {
                $table[$club->id] = [
                    'club' => $club,
                    'played' => 0,
                    'win' => 0,
                    'draw' => 0,
                    'loss' => 0,
                    'gf' => 0,
                    'ga' => 0,
                    'gd' => 0,
                    'points' => 0,
                ];
            }

            $matches = MatchGame::where('tournament_group_id',$group->id)
                ->where('status','finished')
                ->get();

            foreach ($matches as $m) {
                $home = $table[$m->home_club_id];
                $away = $table[$m->away_club_id];

                $home['played']++;
                $away['played']++;

                $home['gf'] += $m->home_score;
                $home['ga'] += $m->away_score;
                $away['gf'] += $m->away_score;
                $away['ga'] += $m->home_score;

                if ($m->home_score > $m->away_score) {
                    $home['win']++;
                    $home['points'] += 3;
                    $away['loss']++;
                } elseif ($m->home_score < $m->away_score) {
                    $away['win']++;
                    $away['points'] += 3;
                    $home['loss']++;
                } else {
                    $home['draw']++;
                    $away['draw']++;
                    $home['points'] += 1;
                    $away['points'] += 1;
                }

                $table[$m->home_club_id] = $home;
                $table[$m->away_club_id] = $away;
            }

            foreach ($table as &$row) {
                $row['gd'] = $row['gf'] - $row['ga'];
            }

            usort($table, function ($a,$b) {
                return [$b['points'],$b['gd'],$b['gf']]
                     <=> [$a['points'],$a['gd'],$a['gf']];
            });

            $standings[$group->id] = $table;
        }

        return view('eo.tournaments.standings',
            compact('tournament','groups','standings')
        );
    }
}
