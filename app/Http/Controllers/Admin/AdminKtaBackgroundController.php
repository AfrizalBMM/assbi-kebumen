<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminKtaBackgroundController extends Controller
{
    public function index()
    {
        $items = KtaBackground::where('owner_type','assbi')->get();
        return view('admin.kta.index', compact('items'));
    }

    public function create()
    {
        return view('admin.kta.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|max:1024'
        ]);

        $path = $request->file('image')->store('kta/bg','public');

        KtaBackground::create([
            'owner_type' => 'assbi',
            'name' => $request->name,
            'image_path' => $path
        ]);

        return redirect()->route('kta-backgrounds.index');
    }

    public function destroy(KtaBackground $ktaBackground)
    {
        Storage::disk('public')->delete($ktaBackground->image_path);
        $ktaBackground->delete();
        return back();
    }

}
