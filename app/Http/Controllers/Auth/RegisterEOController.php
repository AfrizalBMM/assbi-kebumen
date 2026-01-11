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
        // VALIDATION
        $request->validate([
            'eo_name' => 'required|string|max:255',
            'phone'   => 'required|digits_between:9,13|unique:event_organizers,phone',
            'address' => 'required|string',

            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email',
            'password'=> 'required|min:6|confirmed',
        ]);

        // Tolak jika dia ngetik 08...
        if (str_starts_with($request->phone, '0')) {
            return back()
                ->withErrors(['phone'=>'Nomor HP jangan diawali 0. Gunakan format 812xxxx karena +62 sudah otomatis.'])
                ->withInput();
        }

        // 1️⃣ Buat User login
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'eo',
            'status' => 'pending',
        ]);

        // 2️⃣ Simpan EO
        $eo = \App\Models\EventOrganizer::create([
            'user_id' => $user->id,
            'name'    => $request->eo_name,
            'phone'   => '62' . $request->phone,
            'address' => $request->address,
            'status'  => 'pending',
        ]);

        return redirect()->route('register.success')
            ->with('success', 'Registrasi club berhasil. Menunggu verifikasi admin.');
    }

}
