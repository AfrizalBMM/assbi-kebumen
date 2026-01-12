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
        $club = Club::with(['players','tournaments'])->findOrFail($club->id);
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
        \DB::transaction(function() use ($club) {

            $club->update([
                'status' => 'suspended'
            ]);

            if ($club->user) {
                $club->user->update([
                    'status' => 'suspended'
                ]);
            }

        });

        return back()->with('success','Club dan akun login disuspend');
    }

    public function activate(Club $club)
    {
        \DB::transaction(function() use ($club) {

            // Aktifkan club
            $club->update([
                'status' => 'active'
            ]);

            // Aktifkan akun login club
            if ($club->user) {
                $club->user->update([
                    'status' => 'active'
                ]);
            }

        });

        return redirect()
            ->route('admin.clubs.show', $club->id)
            ->with('success','Club dan akun login telah diaktifkan');
    }


}

