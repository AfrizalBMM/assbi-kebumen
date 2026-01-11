<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\MatchGame;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function edit(MatchGame $match)
    {
        $this->authorizeEO($match);

        $players = $match->homeClub->players
            ->merge($match->awayClub->players);

        return view('eo.matches.edit', compact('match','players'));

    }

    public function update(Request $request, MatchGame $match)
    {
        $this->authorizeEO($match);

        $data = $request->validate([
            'match_date' => 'required|date',
            'match_time' => 'required',
            'venue' => 'required|string',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
        ]);

        // Jika skor diisi → match selesai
        if ($request->filled('home_score') && $request->filled('away_score')) {
            $data['status'] = 'finished';
        }

        // SIMPAN MATCH
        $match->update($data);

        // SIMPAN STATISTIK PEMAIN (PER MATCH)
        if ($request->has('stats')) {
            foreach ($request->stats as $playerId => $stat) {
                \App\Models\MatchPlayerStat::updateOrCreate(
                    [
                        'match_game_id' => $match->id,
                        'player_id' => $playerId
                    ],
                    [
                        'goals' => $stat['goals'] ?? 0,
                        'yellow_cards' => $stat['yellow_cards'] ?? 0,
                        'red_cards' => $stat['red_cards'] ?? 0,
                        'minutes_played' => $stat['minutes_played'] ?? 0,
                    ]
                );
            }
        }

        return back()->with('success','Match diperbarui');
    }


    private function authorizeEO(MatchGame $match)
    {
        abort_if(
            $match->tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );
    }
}

