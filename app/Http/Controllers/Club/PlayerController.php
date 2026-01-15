<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Services\KtaGenerator;

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
        'photo' => 'nullable|image|max:1024', // 1MB
        'document_pdf' => 'nullable|mimes:pdf|max:2048',
        'nik' => 'nullable|string|max:50',
    ]);

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = uniqid().'.jpg';

        $img = Image::read($file->getRealPath())
            ->cover(400, 400)
            ->toJpeg(70);

        Storage::disk('public')->put('players/photos/'.$filename, $img);
        $data['photo'] = 'players/photos/'.$filename;
    }

    if ($request->hasFile('document_pdf')) {
        $data['document_pdf'] = $request->file('document_pdf')->store('players/docs', 'public');
    }

    $data['club_id'] = auth()->user()->club_id;

    $player = Player::create($data);

    logActivity('create', $player, 'Menambah pemain '.$player->name);

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
            'photo' => 'nullable|image|max:1024', // 1MB
            'document_pdf' => 'nullable|mimes:pdf|max:2048',
            'nik' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid().'.jpg';

            $img = Image::read($file->getRealPath())
                ->scale(400, 400)
                ->toJpeg(70);

            Storage::disk('public')->put('players/photos/'.$filename, $img);
            $data['photo'] = 'players/photos/'.$filename;
        }

        if ($request->hasFile('document_pdf')) {
            $data['document_pdf'] = $request->file('document_pdf')->store('players/docs', 'public');
        }

        $player->update($data);

        // 🧾 LOG
        logActivity(
            'update',
            $player,
            'Memperbarui data pemain '.$player->name
        );

        return back()->with('success', 'Pemain diperbarui');
    }

    public function destroy(Player $player)
    {
        $this->authorizeClub($player);

        // 🧾 LOG dulu sebelum dihapus
        logActivity(
            'delete',
            $player,
            'Menghapus pemain '.$player->name
        );

        if ($player->photo && Storage::disk('public')->exists($player->photo)) {
            Storage::disk('public')->delete($player->photo);
        }

        if ($player->document_pdf && Storage::disk('public')->exists($player->document_pdf)) {
            Storage::disk('public')->delete($player->document_pdf);
        }

        $player->delete();

        return back()->with('success', 'Pemain dihapus');
    }

    public function generateKta(Player $player)
    {
        $this->authorizeClub($player);

        try {
            \App\Services\KtaGenerator::generate($player);
        } catch (\Throwable $e) {
            return back()->withErrors('Gagal generate KTA: '.$e->getMessage());
        }

        return back()->with('success','KTA berhasil digenerate');
    }

    private function authorizeClub(Player $player)
    {
        abort_if($player->club_id !== auth()->user()->club_id, 403);
    }
}
