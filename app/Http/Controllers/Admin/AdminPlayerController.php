<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Club;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminPlayerController extends Controller
{
    public function index(Request $request)
    {
        $clubId = $request->club_id;
        $u = $request->u; // U10, U12

        $players = Player::with('club')
            ->when($clubId, fn($q)=>$q->where('club_id',$clubId))
            ->when($u, function($q) use ($u){
                $year = now()->subYears($u)->year;
                $q->whereYear('birth_date','>=',$year);
            })
            ->paginate(20);

        return view('admin.players.index', [
            'players'=>$players,
            'clubs'=>Club::all(),
            'clubId'=>$clubId,
            'u'=>$u
        ]);
    }

    public function show(Player $player)
    {
        $player->load('club','stats');
        return view('admin.players.show', compact('player'));
    }

    public function suspend(Player $player)
    {
        $player->update(['status'=>'suspended']);
        return back()->with('success','Pemain disuspend');
    }

    public function activate(Player $player)
    {
        $player->update(['status'=>'active']);
        return back()->with('success','Pemain diaktifkan');
    }
}
