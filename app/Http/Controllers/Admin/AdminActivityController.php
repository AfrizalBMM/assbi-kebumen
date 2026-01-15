<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%'.$request->search.'%')
                ->orWhere('action', 'like', '%'.$request->search.'%')
                ->orWhereHas('user', function($u) use ($request) {
                        $u->where('name', 'like', '%'.$request->search.'%');
                });
            });
        }

        $logs = $query->paginate(30);

        return view('admin.activity.index', compact('logs'));
    }

}
