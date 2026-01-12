<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lineup;
use App\Models\LineupPlayer;
use App\Models\Player;

class LineupController extends Controller
{
    public function index()
    {
        $lineups = Lineup::where('club_id', auth()->user()->club_id)->get();
        return view('club.lineups.index', compact('lineups'));
    }

    public function store()
    {
        $lineup = Lineup::create([
            'club_id'=>auth()->user()->club_id,
            'match_name'=>'Latihan',
            'formation'=>'4-4-2'
        ]);

        return redirect()->route('club.lineups.edit',$lineup);
    }

    public function edit(Lineup $lineup)
    {
        abort_if($lineup->club_id != auth()->user()->club_id,403);

        $players = Player::where('club_id',auth()->user()->club_id)
                    ->where('status','active')->get();

        $lineupPlayers = $lineup->players()->with('player')->get();

        return view('club.lineups.edit',compact('lineup','players','lineupPlayers'));
    }

    public function submit(Lineup $lineup)
    {
        abort_if($lineup->club_id != auth()->user()->club_id,403);

        $lineup->update(['status'=>'submitted']);

        return back()->with('success','Formasi dikirim ke EO');
    }

    public function save(Request $request, Lineup $lineup)
    {
        abort_if($lineup->club_id != auth()->user()->club_id,403);
        abort_if($lineup->status != 'draft',403);

        $players = $request->players;

        // Hapus lineup lama
        LineupPlayer::where('lineup_id',$lineup->id)->delete();

        foreach($players as $p){
            LineupPlayer::create([
                'lineup_id'=>$lineup->id,
                'player_id'=>$p['id'],
                'role'=>$p['role'],
                'x'=>$p['x'] ?? 0,
                'y'=>$p['y'] ?? 0
            ]);
        }

        return response()->json(['status'=>'ok']);
    }

}

