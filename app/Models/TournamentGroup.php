<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MatchGame;

class TournamentGroup extends Model
{
    protected $fillable = ['tournament_id','name'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function clubs()
    {
        return $this->belongsToMany(Club::class,'tournament_group_club');
    }

    public function matches()
    {
        return $this->hasMany(MatchGame::class);
    }

}

