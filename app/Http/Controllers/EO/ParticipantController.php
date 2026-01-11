<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Tournament $tournament)
    {
        // EO hanya boleh akses turnamen miliknya
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );

        $registrations = TournamentRegistration::where('tournament_id', $tournament->id)
            ->with('club')
            ->get();

        return view('eo.tournaments.participants',
            compact('tournament','registrations')
        );
    }

    public function approve(TournamentRegistration $registration)
    {
        $this->authorizeEO($registration);

        $registration->update(['status' => 'approved']);

        return back()->with('success','Club disetujui');
    }

    public function reject(Request $request, TournamentRegistration $registration)
    {
        $this->authorizeEO($registration);

        $request->validate([
            'eo_note' => 'required|string'
        ]);

        $registration->update([
            'status' => 'rejected',
            'eo_note' => $request->eo_note
        ]);

        return back()->with('success','Club ditolak');
    }

    private function authorizeEO(TournamentRegistration $registration)
    {
        abort_if(
            $registration->tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );
    }
}
