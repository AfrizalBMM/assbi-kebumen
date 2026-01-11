<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentGroup;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        $groups = $tournament->groups()->with('clubs')->get();

        $clubs = TournamentRegistration::where('tournament_id',$tournament->id)
            ->where('status','approved')
            ->with('club')
            ->get();

        return view('eo.tournaments.groups',
            compact('tournament','groups','clubs')
        );
    }

    public function autoGenerate(Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        $clubs = TournamentRegistration::where('tournament_id',$tournament->id)
            ->where('status','approved')
            ->pluck('club_id')
            ->toArray();

        shuffle($clubs);

        $groupCount = ceil(count($clubs) / 4); // 4 per grup

        $tournament->groups()->delete();

        for ($i=0; $i<$groupCount; $i++) {
            TournamentGroup::create([
                'tournament_id' => $tournament->id,
                'name' => 'Grup '.chr(65+$i)
            ]);
        }

        $groups = $tournament->groups()->get();
        $i = 0;

        foreach ($clubs as $clubId) {
            $groups[$i % $groups->count()]
                ->clubs()
                ->attach($clubId);
            $i++;
        }

        return back()->with('success','Grup berhasil digenerate otomatis');
    }

    public function addClub(Request $request, TournamentGroup $group)
    {
        $group->clubs()->attach($request->club_id);
        return back();
    }

    public function removeClub(Request $request, TournamentGroup $group)
    {
        $group->clubs()->detach($request->club_id);
        return back();
    }

    private function authorizeEO(Tournament $tournament)
    {
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );
    }
}

