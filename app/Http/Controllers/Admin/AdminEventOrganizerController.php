<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;
use Illuminate\Http\Request;

class AdminEventOrganizerController extends Controller
{
    public function index()
    {
        $eventOrganizers = EventOrganizer::latest()->paginate(10);
        return view('admin.event-organizers.index', compact('eventOrganizers'));
    }

    public function show(EventOrganizer $eventOrganizer)
    {
        $eventOrganizer->load('tournaments');
        return view('admin.event-organizers.show', compact('eventOrganizer'));
    }

    public function edit(EventOrganizer $eventOrganizer)
    {
        return view('admin.event-organizers.edit', compact('eventOrganizer'));
    }

    public function update(Request $request, EventOrganizer $eventOrganizer)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'nullable|email',
            'phone'=>'nullable',
            'address'=>'nullable',
        ]);

        $eventOrganizer->update($data);

        return redirect()
            ->route('admin.event-organizers.show',$eventOrganizer)
            ->with('success','Data EO diperbarui');
    }

    public function suspend(EventOrganizer $eventOrganizer)
    {
        $eventOrganizer->update(['status'=>'suspended']);

        // suspend semua turnamen milik EO
        $eventOrganizer->tournaments()->update(['status'=>'suspended']);

        return back()->with('success','EO & turnamennya disuspend');
    }

    public function activate(EventOrganizer $eventOrganizer)
    {
        $eventOrganizer->update(['status'=>'active']);
        return back()->with('success','EO diaktifkan');
    }
}
