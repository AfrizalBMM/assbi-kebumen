<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterEOController extends Controller
{
    public function create()
    {
        return view('auth.register-eo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'eo_name'        => 'required|string|max:255',
            'contact_person'=> 'required|string|max:255',
            'phone'          => 'required|digits_between:9,13|unique:event_organizers,phone',
            'email_eo'       => 'nullable|email',
            'address'        => 'required|string',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:6|confirmed',
        ]);

        if (str_starts_with($request->phone, '0')) {
            return back()->withErrors([
                'phone' => 'Nomor HP jangan diawali 0. Gunakan format 812xxxx'
            ])->withInput();
        }

        // 1️⃣ User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'eo',
            'status'   => 'pending',
        ]);

        // 2️⃣ EO
        $eo = EventOrganizer::create([
            'user_id'        => $user->id,
            'name'           => $request->eo_name,
            'contact_person' => $request->contact_person,
            'phone'          => '62'.$request->phone,
            'email'          => $request->email_eo,
            'address'        => $request->address,
            'status'         => 'pending',
        ]);

        logActivity('register', $eo, 'EO '.$eo->name.' mendaftar');

        return redirect()->route('register.success')
            ->with('success','Registrasi EO berhasil, menunggu verifikasi admin.');
    }
}
