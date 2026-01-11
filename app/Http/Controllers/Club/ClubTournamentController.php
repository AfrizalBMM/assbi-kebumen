<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentRegistration;

class ClubTournamentController extends Controller
{
    public function index()
    {
        $club = auth()->user()->club;

        $tournaments = Tournament::where('status','open')->get();

        return view('club.tournaments.index', compact('tournaments','club'));
    }

    public function register(Tournament $tournament)
    {
        $club = auth()->user()->club;

        // 1️⃣ Club harus verified
        if ($club->status !== 'verified') {
            return back()->withErrors('Club belum diverifikasi admin');
        }

        // 2️⃣ Minimal pemain
        if ($club->players()->count() < 14) {
            return back()->withErrors('Minimal 14 pemain');
        }

        // 3️⃣ Validasi usia
        $limit = (int) str_replace('U','',$tournament->category);

        $invalid = $club->players()
            ->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > ?", [$limit])
            ->count();

        if ($invalid > 0) {
            return back()->withErrors('Ada pemain tidak sesuai kategori usia');
        }

        TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'club_id' => $club->id
        ]);

        return back()->with('success','Berhasil mendaftar');
    }
}
