<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable'
        ]);

        $data['image'] = $request->file('image')->store('banners', 'public');
        $data['is_active'] = $request->has('is_active');

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success','Banner ditambahkan');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success','Banner diperbarui');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();

        return back()->with('success','Banner dihapus');
    }

    // approve & disable sesuai route kamu
    public function approve(Banner $banner)
    {
        $banner->update(['is_active'=>1]);
        return back();
    }

    public function disable(Banner $banner)
    {
        $banner->update(['is_active'=>0]);
        return back();
    }
}
