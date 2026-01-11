<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentBanner extends Model
{
    protected $fillable = [
        'tournament_id',
        'event_organizer_id',
        'title',
        'image',
        'link',
        'is_active',
        'is_approved',
        'order'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function eo()
    {
        return $this->belongsTo(EventOrganizer::class, 'event_organizer_id');
    }
}
