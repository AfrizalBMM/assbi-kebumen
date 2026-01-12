<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineupPlayer extends Model
{
    protected $fillable = [
        'lineup_id',
        'player_id',
        'role',
        'position',
        'x',
        'y'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
