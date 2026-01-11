<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Club;
use App\Models\EventOrganizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->role;

        $users = User::when($role, function ($q) use ($role) {
                $q->where('role',$role);
            })
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users','role'));
    }

    public function create()
    {
        return view('admin.users.create', [
            'clubs' => Club::all(),
            'eos' => EventOrganizer::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'role'=>'required|in:admin,eo,club',
            'club_id'=>'nullable',
            'event_organizer_id'=>'nullable'
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success','User berhasil dibuat');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user'=>$user,
            'clubs'=>Club::all(),
            'eos'=>EventOrganizer::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'role'=>'required|in:admin,eo,club',
            'club_id'=>'nullable',
            'event_organizer_id'=>'nullable'
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.users.show',$user)
            ->with('success','User diperbarui');
    }

    public function suspend(User $user)
    {
        $user->update(['status'=>'suspended']);
        return back()->with('success','User disuspend');
    }

    public function activate(User $user)
    {
        $user->update(['status'=>'active']);
        return back()->with('success','User diaktifkan');
    }

    public function resetPassword(User $user)
    {
        $user->update([
            'password'=>Hash::make('password')
        ]);

        return back()->with('success','Password direset ke: password');
    }
}
