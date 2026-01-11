<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalClubs'      => Club::count(),
            'pendingClubs'    => Club::where('status', 'pending')->count(),
            'verifiedClubs'   => Club::where('status', 'verified')->count(),
            'totalUsers'      => User::count(),
            'latestPendingClubs' => Club::where('status', 'pending')
                                        ->latest()
                                        ->limit(5)
                                        ->get(),
        ]);
    }
}
