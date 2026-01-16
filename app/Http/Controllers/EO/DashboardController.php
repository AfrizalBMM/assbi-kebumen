<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\MatchGame;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $eo   = $user->eventOrganizer;

        // Statistik
        $totalTournaments = Tournament::where('event_organizer_id', $eo->id)->count();

        $activeTournaments = Tournament::where('event_organizer_id', $eo->id)
            ->where('status', 'published')
            ->count();

        $totalMatches = MatchGame::whereHas('tournament', function ($q) use ($eo) {
            $q->where('event_organizer_id', $eo->id);
        })->count();

        $pendingMatches = MatchGame::whereHas('tournament', function ($q) use ($eo) {
            $q->where('event_organizer_id', $eo->id);
        })->where('status', '!=', 'finished')->count();

        // Turnamen & match terbaru
        $latestTournaments = Tournament::where('event_organizer_id', $eo->id)
            ->latest()
            ->take(5)
            ->get();

        $latestMatches = MatchGame::whereHas('tournament', function ($q) use ($eo) {
            $q->where('event_organizer_id', $eo->id);
        })->latest()->take(5)->get();

        // 🔥 AKTIVITAS KHUSUS EO (INI YANG TADI HILANG)
        $eoActivities = ActivityLog::where('user_id', $user->id)
            ->whereIn('action', [
                'create',
                'update',
                'publish',
                'close',
                'generate',
                'approve'
            ])
            ->latest()
            ->take(6)
            ->get();

        return view('eo.dashboard', compact(
            'totalTournaments',
            'activeTournaments',
            'totalMatches',
            'pendingMatches',
            'latestTournaments',
            'latestMatches',
            'eoActivities'
        ));
    }
}
