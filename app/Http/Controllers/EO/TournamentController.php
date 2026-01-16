<?php

namespace App\Http\Controllers\EO;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\TournamentStatus;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::where(
                'event_organizer_id',
                auth()->user()->eventOrganizer->id
            )
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
            'name'               => 'required|string|max:255',
            'category'           => 'required|string',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'location'           => 'nullable|string|max:255',
            'max_participants'   => 'nullable|integer|min:1',
            'registration_fee'   => 'nullable|numeric|min:0',
            'description'        => 'nullable|string',
            'regulation_pdf'     => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Upload PDF jika ada
        if ($request->hasFile('regulation_pdf')) {
            $data['regulation_pdf'] = $request
                ->file('regulation_pdf')
                ->store('tournaments/regulations', 'public');
        }

        $data['event_organizer_id'] = auth()->user()->eventOrganizer->id;
        $data['slug']   = Str::slug($data['name']) . '-' . uniqid();
        $data['status'] = TournamentStatus::DRAFT;

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

        if ($tournament->status !== TournamentStatus::DRAFT) {
            abort(403, 'Turnamen hanya bisa diedit saat status Draft');
        }

        return view('eo.tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        if ($tournament->status !== TournamentStatus::DRAFT) {
            abort(403, 'Turnamen tidak bisa diubah');
        }

        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'category'           => 'required|string',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'location'           => 'nullable|string|max:255',
            'max_participants'   => 'nullable|integer|min:1',
            'registration_fee'   => 'nullable|numeric|min:0',
            'description'        => 'nullable|string',
            'regulation_pdf'     => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('regulation_pdf')) {
            $data['regulation_pdf'] = $request
                ->file('regulation_pdf')
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

        if ($tournament->status !== TournamentStatus::DRAFT) {
            return back()->withErrors([
                'status' => 'Turnamen sudah dipublish'
            ]);
        }

        $tournament->update([
            'status' => TournamentStatus::OPEN
        ]);

        return back()->with('success', 'Turnamen berhasil dipublish');
    }

    public function close(Tournament $tournament)
    {
        $this->authorizeEO($tournament);

        $tournament->update([
            'status' => TournamentStatus::FINISHED
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
