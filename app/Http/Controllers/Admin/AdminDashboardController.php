<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\User;
use App\Models\Player;
use App\Models\EventOrganizer;
use App\Models\ActivityLog;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ===== CLUB =====
        $totalClubs = Club::count();
        $pendingClubs = Club::where('status','pending')->count();
        $verifiedClubs = Club::where('status','active')->count();

        $latestPendingClubs = Club::where('status','pending')
            ->latest()
            ->take(5)
            ->get();

        // ===== EO =====
        $pendingEOs = EventOrganizer::where('status','pending')->count();
        $latestPendingEOs = EventOrganizer::where('status','pending')
            ->latest()
            ->take(5)
            ->get();

        // ===== USERS =====
        $totalUsers = User::count();

        // ===== PLAYERS =====
        $totalPlayers = Player::count();
        $activePlayers = Player::where('status','active')->count();
        $suspendedPlayers = Player::where('status','suspended')->count();

        $avgAge = round(
            Player::whereNotNull('birth_date')->get()
                ->avg(fn ($p) => Carbon::parse($p->birth_date)->age)
        );

        // ===== STATS =====
        $topScorers = Player::with('club')
            ->withSum('stats as total_goals', 'goals')
            ->orderByDesc('total_goals')
            ->take(5)
            ->get();

        // ===== ACTIVITY =====
        $recentActivities = ActivityLog::latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalClubs',
            'pendingClubs',
            'verifiedClubs',
            'latestPendingClubs',
            'pendingEOs',
            'latestPendingEOs',
            'totalUsers',
            'totalPlayers',
            'activePlayers',
            'suspendedPlayers',
            'avgAge',
            'topScorers',
            'recentActivities'
        ));
    }
}
