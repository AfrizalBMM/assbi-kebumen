<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
            'name'        => 'required',
            'short_name'  => 'nullable',
            'coach_name'  => 'required',
            'coach_phone' => 'nullable',
            'address'     => 'nullable',
            'logo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = uniqid().'.jpg';

            $img = Image::read($file)
                ->scale(500, 500)
                ->toJpeg(75);

            Storage::disk('public')->put('clubs/logos/'.$filename, $img);

            $data['logo'] = 'clubs/logos/'.$filename;
        }

        $club->update($data);

        // 🧾 ACTIVITY LOG
        logActivity(
            'update',
            $club,
            'Memperbarui profil club '.$club->name
        );

        return back()->with('success','Profil club diperbarui');
    }

}
