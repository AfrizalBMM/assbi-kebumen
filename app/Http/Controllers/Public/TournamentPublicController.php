<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\MatchGame;
use App\Models\MatchPlayerStat;

class TournamentPublicController extends Controller
{
    public function index()
    {
        $upcoming = Tournament::where('status','open')
            ->orderBy('start_date')
            ->get();

        $ongoing = Tournament::where('status','ongoing')
            ->get();

        $finished = Tournament::where('status','finished')
            ->orderByDesc('end_date')
            ->limit(10)
            ->get();

        return view('public.tournaments.index', compact(
            'upcoming','ongoing','finished'
        ));
    }


    public function show($slug)
    {
        $tournament = Tournament::where('slug',$slug)
            ->with('groups.clubs')
            ->firstOrFail();

        $matches = MatchGame::where('tournament_id',$tournament->id)
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->get();

        $standings = [];

        foreach ($tournament->groups as $group) {

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

            $groupMatches = MatchGame::where('tournament_group_id',$group->id)
                ->where('status','finished')
                ->get();

            foreach ($groupMatches as $m) {
                $home = &$table[$m->home_club_id];
                $away = &$table[$m->away_club_id];

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
                    $home['points']++;
                    $away['points']++;
                }
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

        $knockouts = MatchGame::where('tournament_id',$tournament->id)
        ->whereIn('stage',['quarter_final','semi_final','final'])
        ->orderByRaw("FIELD(stage,'quarter_final','semi_final','final')")
        ->get()
        ->groupBy('stage');


        // Top scorer tetap
        $topScorers = MatchPlayerStat::whereHas('match', function($q) use($tournament){
                $q->where('tournament_id',$tournament->id);
            })
            ->selectRaw('player_id, SUM(goals) as goals')
            ->groupBy('player_id')
            ->orderByDesc('goals')
            ->with('player.club')
            ->limit(10)
            ->get();

        return view('public.tournaments.show', compact(
        'tournament','matches','topScorers','standings','knockouts'
        ));

    }
}

