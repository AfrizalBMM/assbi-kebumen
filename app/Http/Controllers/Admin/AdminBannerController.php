<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::with(['tournament','eventOrganizer'])->latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function disable(Banner $banner)
    {
        $banner->update(['is_active'=>false]);
        return back();
    }

    public function enable(Banner $banner)
    {
        $banner->update(['is_active'=>true]);
        return back();
    }
}

