<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class AdminTournamentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $tournaments = Tournament::with('eventOrganizer')
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.tournaments.index',
            compact('tournaments','status')
        );
    }

    public function show(Tournament $tournament)
    {
        $tournament->load([
            'eventOrganizer',
            'collaborators',
            'groups.clubs',
            'matches.homeClub',
            'matches.awayClub'
        ]);

        return view('admin.tournaments.show', compact('tournament'));
    }

    public function suspend(Request $request, Tournament $tournament)
    {
        $request->validate([
            'admin_note' => 'required|string'
        ]);

        $tournament->update([
            'status' => 'suspended',
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success','Turnamen disuspend');
    }

    public function activate(Tournament $tournament)
    {
        $tournament->update([
            'status' => 'open',
            'admin_note' => null,
        ]);

        return back()->with('success','Turnamen diaktifkan kembali');
    }
}
