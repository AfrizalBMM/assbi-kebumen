<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;

class AdminClubController extends Controller
{
    public function index()
    {
        $clubs = Club::withCount('players')->latest()->paginate(10);
        return view('admin.clubs.index', compact('clubs'));
    }

    public function show(Club $club)
    {
        $club->load(['players','tournaments']);
        return view('admin.clubs.show', compact('club'));
    }

    public function edit(Club $club)
    {
        return view('admin.clubs.edit', compact('club'));
    }

    public function update(Request $request, Club $club)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'nullable|email',
            'phone'=>'nullable',
            'address'=>'nullable',
        ]);

        $club->update($data);

        return redirect()
            ->route('admin.clubs.show',$club)
            ->with('success','Data club diperbarui');
    }

    public function suspend(Club $club)
    {
        $club->update(['status'=>'suspended']);
        return back()->with('success','Club disuspend');
    }

    public function activate(Club $club)
    {
        $club->update(['status'=>'active']);
        return back()->with('success','Club diaktifkan');
    }
}

