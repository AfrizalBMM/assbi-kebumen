<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\MatchGame;
use App\Models\TournamentGroup;

class KnockoutController extends Controller
{
    public function generate(Tournament $tournament)
    {
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );

        $groups = $tournament->groups;

        $qualified = [];

        foreach ($groups as $group) {
            $standings = app(\App\Http\Controllers\EO\StandingController::class)
                ->index($tournament)->getData()['standings'][$group->id];

            $qualified[] = $standings[0]['club'];
            $qualified[] = $standings[1]['club'];
        }

        // hapus knockout lama
        MatchGame::where('tournament_id',$tournament->id)
            ->where('stage','!=','group')
            ->delete();

        // Pairing silang
        for ($i=0; $i<count($qualified); $i+=4) {
            MatchGame::create([
                'tournament_id' => $tournament->id,
                'home_club_id' => $qualified[$i]->id,
                'away_club_id' => $qualified[$i+3]->id,
                'stage' => 'quarter_final'
            ]);

            MatchGame::create([
                'tournament_id' => $tournament->id,
                'home_club_id' => $qualified[$i+1]->id,
                'away_club_id' => $qualified[$i+2]->id,
                'stage' => 'quarter_final'
            ]);
        }

        return back()->with('success','8 Besar berhasil digenerate');
    }

    public function generateNext(Tournament $tournament)
    {
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );

        $stages = [
            'quarter_final' => 'semi_final',
            'semi_final' => 'final'
        ];

        // cari stage aktif terakhir
        foreach ($stages as $current => $next) {
            $matches = MatchGame::where('tournament_id',$tournament->id)
                ->where('stage',$current)
                ->get();

            if ($matches->count() > 0) {
                // semua harus selesai
                if ($matches->where('status','!=','finished')->count() > 0) {
                    return back()->withErrors('Masih ada match belum selesai');
                }

                // ambil pemenang
                $winners = [];

                foreach ($matches as $m) {
                    $winners[] =
                        $m->home_score > $m->away_score
                        ? $m->home_club_id
                        : $m->away_club_id;
                }

                // hapus next stage lama
                MatchGame::where('tournament_id',$tournament->id)
                    ->where('stage',$next)
                    ->delete();

                // pairing
                for ($i=0; $i<count($winners); $i+=2) {
                    MatchGame::create([
                        'tournament_id' => $tournament->id,
                        'home_club_id' => $winners[$i],
                        'away_club_id' => $winners[$i+1],
                        'stage' => $next
                    ]);
                }

                return back()->with('success','Stage '.$next.' berhasil dibuat');
            }
        }

        return back()->withErrors('Tidak ada stage yang bisa diproses');
    }

}

