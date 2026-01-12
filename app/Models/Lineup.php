<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    protected $fillable = [
        'club_id',
        'tournament_id',
        'match_name',
        'formation',
        'match_date',
        'lock_time',
        'status'
    ];

    public function players()
    {
        return $this->hasMany(LineupPlayer::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
