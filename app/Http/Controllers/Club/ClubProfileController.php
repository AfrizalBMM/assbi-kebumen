<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClubProfileController extends Controller
{
    public function edit()
    {
        $club = auth()->user()->club;
        return view('club.profile.edit', compact('club'));
    }

    public function update(Request $request)
    {
        $club = auth()->user()->club;

        $data = $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'coach_name' => 'nullable',
            'logo' => 'nullable|image',
            'document' => 'nullable|mimes:pdf,zip'
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clubs/logos', 'public');
        }

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('clubs/docs', 'public');
        }

        $club->update($data);

        return back()->with('success','Profil club diperbarui');
    }
}

