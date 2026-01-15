<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KtaBackground;
use Illuminate\Support\Facades\Storage;

class ClubKtaBackgroundController extends Controller
{
    public function index()
    {
        $club = auth()->user()->club;

        $items = KtaBackground::where('owner_type','club')
            ->where('owner_id',$club->id)
            ->get();

        return view('club.kta.index', compact('items'));
    }

    public function store(Request $request)
{
    dd([
        'auth'  => auth()->check(),
        'user'  => auth()->user(),
        'club'  => auth()->user()?->club,
        'all'   => $request->all(),
        'file'  => $request->file('image'),
    ]);

    // kode di bawah ini tidak akan jalan dulu
}


    public function update(KtaBackground $ktaBackground)
    {
        $club = auth()->user()->club;

        // Security: pastikan ini milik club ini
        if (
            $ktaBackground->owner_type !== 'club' ||
            $ktaBackground->owner_id !== $club->id
        ) {
            abort(403);
        }

        // Matikan semua BG club ini
        KtaBackground::where('owner_type','club')
            ->where('owner_id',$club->id)
            ->update(['is_active' => false]);

        // Aktifkan yang dipilih
        $ktaBackground->update(['is_active' => true]);

        return back()->with('success','Background KTA diaktifkan');
    }

    public function destroy(KtaBackground $ktaBackground)
    {
        $club = auth()->user()->club;

        // Pastikan milik club ini
        if (
            $ktaBackground->owner_type !== 'club' ||
            $ktaBackground->owner_id !== $club->id
        ) {
            abort(403);
        }

        // Tidak boleh hapus yang aktif
        if ($ktaBackground->is_active) {
            return back()->withErrors('Background yang sedang aktif tidak bisa dihapus');
        }

        // Hapus file
        if (Storage::disk('public')->exists($ktaBackground->image_path)) {
            Storage::disk('public')->delete($ktaBackground->image_path);
        }

        // Hapus DB
        $ktaBackground->delete();

        return back()->with('success','Background berhasil dihapus');
    }

}
