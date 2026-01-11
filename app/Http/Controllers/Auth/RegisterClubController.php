<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterClubController extends Controller
{
    public function create()
    {
        return view('auth.register-club');
    }

    public function store(Request $request)
    {
        // VALIDATION
        $request->validate([
            'club_name'    => 'required|string|max:255',
            'coach_name'  => 'required|string|max:255',
            'coach_phone' => 'required|digits_between:9,13|unique:clubs,coach_phone',
            'address'     => 'required|string',

            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
        ]);

        // Jangan boleh pakai 08...,
        if (str_starts_with($request->coach_phone, '0')) {
            return back()
                ->withErrors(['coach_phone' => 'Nomor HP jangan diawali 0. Gunakan format 812xxxx karena +62 otomatis.'])
                ->withInput();
        }

        // Format nomor ke 62xxxxxxxx
        $phone = '62' . $request->coach_phone;

        // Double safety check (kalau ada yang lolos)
        if (\App\Models\Club::where('coach_phone', $phone)->exists()) {
            return back()
                ->withErrors(['coach_phone' => 'Nomor HP ini sudah terdaftar.'])
                ->withInput();
        }

        // 1️⃣ Buat Club
        $club = \App\Models\Club::create([
            'name'        => $request->club_name,
            'coach_name' => $request->coach_name,
            'coach_phone'=> $phone,
            'address'    => $request->address,
            'status'     => 'pending',
        ]);

        // 2️⃣ Buat User login club
        \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role'     => 'club',
            'status'   => 'pending',
            'club_id'  => $club->id,
        ]);

        return redirect()->route('register.success')
            ->with('success', 'Registrasi club berhasil. Menunggu verifikasi admin.');

    }

}
