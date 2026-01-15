<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class AdminClubController extends Controller
{
    public function index()
    {
        $clubs = Club::with('players')
            ->withCount('players')
            ->latest()
            ->paginate(10);

        // Hitung rata-rata usia pemain tiap club
        $clubs->getCollection()->transform(function ($club) {

            if ($club->players->count() == 0) {
                $club->avg_age = null;
                return $club;
            }

            $total = 0;

            foreach ($club->players as $player) {
                $total += Carbon::parse($player->birth_date)->age;
            }

            $club->avg_age = round($total / $club->players->count());

            return $club;
        });

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
            'name'    => 'required',
            'email'   => 'nullable|email',
            'phone'   => 'nullable',
            'address' => 'nullable',
        ]);

        $club->update($data);

        return redirect()
            ->route('admin.clubs.show', $club)
            ->with('success','Data club diperbarui');
    }

    public function suspend(Club $club)
    {
        DB::transaction(function() use ($club) {

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
        DB::transaction(function() use ($club) {

            $club->update([
                'status' => 'active'
            ]);

            if ($club->user) {
                $club->user->update([
                    'status' => 'active'
                ]);
            }

            // 🧾 ACTIVITY LOG
            logActivity(
                'activate',
                $club,
                'Admin mengaktifkan club '.$club->name
            );

        });

        return redirect()
            ->route('admin.clubs.show', $club->id)
            ->with('success','Club dan akun login telah diaktifkan');
    }

}
