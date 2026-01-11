<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::where('event_organizer_id', auth()->user()->eventOrganizer->id)
            ->latest()
            ->paginate(10);

        return view('eo.tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        return view('eo.tournaments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string',
            'max_participants' => 'nullable|integer',
            'registration_fee' => 'nullable|numeric',
            'description' => 'nullable|string',
            'regulation_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        // ✅ SIMPAN FILE PDF (DI SINI)
        $data['regulation_pdf'] = $request->file('regulation_pdf')
            ->store('tournaments/regulations', 'public');

        $data['event_organizer_id'] = auth()->user()->eventOrganizer->id;
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $data['status'] = 'draft';

        Tournament::create($data);

        return redirect()
            ->route('eo.tournaments.index')
            ->with('success', 'Turnamen berhasil dibuat (Draft)');
    }


    public function show(Tournament $tournament)
    {
        $this->authorizeEO($tournament);
        return view('eo.tournaments.show', compact('tournament'));
    }

    public function edit(Tournament $tournament)
    {
        $this->authorizeEO($tournament);
        return view('eo.tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        if ($tournament->status !== 'draft') {
            abort(403, 'Turnamen tidak bisa diubah');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string',
            'max_participants' => 'nullable|integer',
            'registration_fee' => 'nullable|numeric',
            'description' => 'nullable|string',
            'regulation_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        // ✅ JIKA UPLOAD PDF BARU
        if ($request->hasFile('regulation_pdf')) {
            $data['regulation_pdf'] = $request->file('regulation_pdf')
                ->store('tournaments/regulations', 'public');
        }

        $tournament->update($data);

        return back()->with('success', 'Turnamen diperbarui');
    }


    public function publish(Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        if (!$tournament->regulation_pdf) {
            return back()->withErrors([
                'regulation_pdf' => 'Upload PDF regulasi sebelum publish.'
            ]);
        }

        $tournament->update(['status' => 'published']);

        return back()->with('success', 'Turnamen dipublish');
    }


    public function close(Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        $tournament->update([
            'status' => 'closed'
        ]);

        return back()->with('success', 'Turnamen ditutup');
    }

    protected function authorizeEO(Tournament $tournament)
    {
        abort_if(
            $tournament->event_organizer_id !== auth()->user()->eventOrganizer->id,
            403
        );
    }
}

