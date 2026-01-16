<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;
use Illuminate\Http\Request;

class AdminEventOrganizerController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $eos = EventOrganizer::when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.event-organizers.index', compact('eos', 'status'));
    }

    public function show(EventOrganizer $eventOrganizer)
    {
        $eventOrganizer->load(['tournaments', 'user']);
        return view('admin.event-organizers.show', compact('eventOrganizer'));
    }

    public function edit(EventOrganizer $eventOrganizer)
    {
        return view('admin.event-organizers.edit', compact('eventOrganizer'));
    }

    public function update(Request $request, EventOrganizer $eventOrganizer)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $eventOrganizer->update($data);

        // Sinkron email EO ke akun user (login)
        if ($request->filled('email') && $eventOrganizer->user) {
            $eventOrganizer->user->update([
                'email' => $request->email
            ]);
        }

        return redirect()
            ->route('admin.event-organizers.show', $eventOrganizer)
            ->with('success', 'Data EO diperbarui');
    }

    /**
     * APPROVE EO (pending → active)
     */
    public function approve(EventOrganizer $eventOrganizer)
    {
        if ($eventOrganizer->status !== 'pending') {
            return back()->with('error', 'EO tidak dalam status pending');
        }

        $eventOrganizer->update([
            'status'     => 'active',
            'admin_note'=> null
        ]);

        if ($eventOrganizer->user) {
            $eventOrganizer->user->update([
                'status' => 'active'
            ]);
        }

        logActivity(
            'approve',
            $eventOrganizer,
            'EO '.$eventOrganizer->name.' disetujui admin'
        );

        return back()->with('success', 'EO berhasil di-approve');
    }

    /**
     * SUSPEND EO (active → suspended)
     */
    public function suspend(EventOrganizer $eventOrganizer)
    {
        $eventOrganizer->update(['status' => 'suspended']);

        if ($eventOrganizer->user) {
            $eventOrganizer->user->update([
                'status' => 'suspended'
            ]);
        }

        // Suspend semua turnamen milik EO
        $eventOrganizer->tournaments()->update([
            'status' => 'suspended'
        ]);

        logActivity(
            'suspend',
            $eventOrganizer,
            'EO '.$eventOrganizer->name.' disuspend admin'
        );

        return back()->with('success', 'EO & seluruh turnamennya disuspend');
    }

    /**
     * AKTIFKAN EO (suspended → active)
     */
    public function activate(EventOrganizer $eventOrganizer)
    {
        if ($eventOrganizer->status !== 'suspended') {
            return back()->with('error', 'EO tidak dalam status suspended');
        }

        $eventOrganizer->update(['status' => 'active']);

        if ($eventOrganizer->user) {
            $eventOrganizer->user->update([
                'status' => 'active'
            ]);
        }

        logActivity(
            'activate',
            $eventOrganizer,
            'EO '.$eventOrganizer->name.' diaktifkan kembali'
        );

        return back()->with('success', 'EO diaktifkan');
    }

    /**
     * REJECT EO (pending → rejected)
     */
    public function reject(Request $request, EventOrganizer $eventOrganizer)
    {
        if ($eventOrganizer->status !== 'pending') {
            return back()->with('error', 'EO tidak dalam status pending');
        }

        $request->validate([
            'admin_note' => 'required|string'
        ]);

        $eventOrganizer->update([
            'status'     => 'rejected',
            'admin_note'=> $request->admin_note
        ]);

        if ($eventOrganizer->user) {
            $eventOrganizer->user->update([
                'status' => 'inactive'
            ]);
        }

        logActivity(
            'reject',
            $eventOrganizer,
            'EO '.$eventOrganizer->name.' ditolak admin'
        );

        return back()->with('success', 'EO ditolak');
    }
}
