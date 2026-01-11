<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchPlayerStat extends Model
{
    protected $fillable = [
        'match_game_id',
        'player_id',
        'goals',
        'yellow_cards',
        'red_cards',
        'minutes_played'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function match()
    {
        return $this->belongsTo(\App\Models\Match::class, 'match_id');
    }

    public function matchGame()
    {
        return $this->belongsTo(\App\Models\MatchGame::class);
    }

}

