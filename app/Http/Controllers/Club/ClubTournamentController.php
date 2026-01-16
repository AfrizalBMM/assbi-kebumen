<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Carbon\Carbon;

class ClubTournamentController extends Controller
{
    public function index()
    {
        $club = auth()->user()->club->load('players');

        $totalPlayers = $club->players->count();

        $eligible12 = $club->players
            ->filter(fn($p) => Carbon::parse($p->birth_date)->age >= 12)
            ->count();

        $tournaments = Tournament::where('status','open')
            ->withCount('registrations')
            ->latest()
            ->get();

        return view('club.tournaments.index', compact(
            'tournaments',
            'club',
            'totalPlayers',
            'eligible12'
        ));
    }

    public function show(Tournament $tournament)
    {
        $club = auth()->user()->club->load('players');

        $totalPlayers = $club->players->count();

        $eligible12 = $club->players
            ->filter(fn($p) => Carbon::parse($p->birth_date)->age >= 12)
            ->count();

        return view('club.tournaments.show', compact(
            'tournament',
            'club',
            'totalPlayers',
            'eligible12'
        ));
    }

    public function register(Tournament $tournament)
    {
        $club = auth()->user()->club;

        // 1️⃣ Club harus verified
        if ($club->status !== 'verified') {
            return back()->withErrors('Club belum diverifikasi admin');
        }

        // 2️⃣ Minimal jumlah pemain
        if ($club->players()->count() < 12) {
            return back()->withErrors('Minimal 12 pemain untuk mendaftar turnamen');
        }

        // 3️⃣ WAJIB ada minimal 1 pemain usia >= 12 tahun
        $hasMinAge = $club->players()
            ->whereDate('birth_date', '<=', now()->subYears(12))
            ->exists();

        if (!$hasMinAge) {
            return back()->withErrors(
                'Minimal memiliki 1 pemain usia 12 tahun ke atas untuk mendaftar turnamen'
            );
        }

        // 4️⃣ Validasi kategori usia (jika format U12, U13, U15, dst)
        if (preg_match('/U(\d+)/', $tournament->category, $m)) {

            $maxAge = (int) $m[1];

            $invalid = $club->players()
                ->whereRaw(
                    "TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > ?",
                    [$maxAge]
                )
                ->exists();

            if ($invalid) {
                return back()->withErrors(
                    'Ada pemain yang melebihi batas usia kategori '.$tournament->category
                );
            }
        }

        // 5️⃣ Cegah daftar ganda
        $already = TournamentRegistration::where('tournament_id',$tournament->id)
            ->where('club_id',$club->id)
            ->exists();

        if ($already) {
            return back()->withErrors('Club sudah terdaftar di turnamen ini');
        }

        // 6️⃣ Simpan pendaftaran
        TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'club_id' => $club->id
        ]);

        // 🧾 ACTIVITY LOG
        logActivity(
            'register',
            $tournament,
            'Club '.$club->name.' mendaftar ke turnamen '.$tournament->name
        );

        return back()->with('success','Berhasil mendaftar turnamen');
    }

}
