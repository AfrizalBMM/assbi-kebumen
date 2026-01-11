<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentRegistration extends Model
{
    protected $fillable = [
        'tournament_id',
        'club_id',
        'status',
        'eo_note',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
