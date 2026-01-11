<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::where('club_id', auth()->user()->club_id)->get();
        return view('club.players.index', compact('players'));
    }

    public function create()
    {
        return view('club.players.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'position' => 'required|in:GK,DF,MF,FW',
            'photo' => 'nullable|image|max:2048',
            'document_pdf' => 'nullable|mimes:pdf|max:2048',
            'nik' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('players/photos', 'public');
        }

        if ($request->hasFile('document_pdf')) {
            $data['document_pdf'] = $request->file('document_pdf')->store('players/docs', 'public');
        }

        $data['club_id'] = auth()->user()->club_id;

        Player::create($data);

        return redirect()->route('club.players.index')
            ->with('success', 'Pemain ditambahkan');
    }

    public function edit(Player $player)
    {
        $this->authorizeClub($player);
        return view('club.players.edit', compact('player'));
    }

    public function update(Request $request, Player $player)
    {
        $this->authorizeClub($player);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'position' => 'required|in:GK,DF,MF,FW',
            'photo' => 'nullable|image|max:2048',
            'document_pdf' => 'nullable|mimes:pdf|max:2048',
            'nik' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('players/photos', 'public');
        }

        if ($request->hasFile('document_pdf')) {
            $data['document_pdf'] = $request->file('document_pdf')->store('players/docs', 'public');
        }

        $player->update($data);

        return back()->with('success', 'Pemain diperbarui');
    }

    public function destroy(Player $player)
    {
        $this->authorizeClub($player);
        $player->delete();

        return back()->with('success', 'Pemain dihapus');
    }

    private function authorizeClub(Player $player)
    {
        abort_if($player->club_id !== auth()->user()->club_id, 403);
    }
}
