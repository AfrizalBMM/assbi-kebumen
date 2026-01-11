<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MatchGame;
use App\Models\TournamentGroup;

class Tournament extends Model
{
    protected $fillable = [
        'event_organizer_id',
        'name',
        'slug',
        'category',
        'start_date',
        'end_date',
        'location',
        'max_participants',
        'registration_fee',
        'status',
        'description',
        'regulation_pdf',
        'admin_note',
    ];

    // EO utama
    public function eventOrganizer()
    {
        return $this->belongsTo(EventOrganizer::class);
    }

    // EO kolaborator
    public function collaborators()
    {
        return $this->belongsToMany(
            EventOrganizer::class,
            'tournament_event_organizer'
        );
    }

    // Club pendaftar
    public function registrations()
    {
        return $this->hasMany(TournamentRegistration::class);
    }

    public function groups()
    {
        return $this->hasMany(TournamentGroup::class);
    }

    public function matches()
    {
        return $this->hasMany(MatchGame::class);
    }

    public function banners()
    {
        return $this->hasMany(TournamentBanner::class);
    }

}

