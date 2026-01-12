<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Lineup;

class EOFormasiController extends Controller
{
    public function index()
    {
        $lineups = Lineup::where('status','submitted')->get();
        return view('eo.lineups.index',compact('lineups'));
    }

    public function show(Lineup $lineup)
    {
        $lineup->load('players.player');

        return view('eo.lineups.show',compact('lineup'));
    }

    public function approve(Lineup $lineup)
    {
        abort_if($lineup->status != 'submitted',403);

        $lineup->update([
            'status'=>'approved',
            'eo_note'=>null
        ]);

        return back()->with('success','Formasi disetujui');
    }

    public function requestRevision(Request $request, Lineup $lineup)
    {
        abort_if($lineup->status != 'submitted',403);

        $request->validate([
            'eo_note'=>'required'
        ]);

        $lineup->update([
            'status'=>'draft',
            'eo_note'=>$request->eo_note
        ]);

        return back()->with('success','Revisi dikirim ke club');
    }


}

