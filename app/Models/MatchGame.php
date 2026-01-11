<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchGame extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'tournament_id',
        'tournament_group_id',
        'home_club_id',
        'away_club_id',
        'home_score',
        'away_score',
        'match_date',
        'match_time',
        'venue',
        'stage',
        'status',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function group()
    {
        return $this->belongsTo(TournamentGroup::class,'tournament_group_id');
    }

    public function homeClub()
    {
        return $this->belongsTo(Club::class,'home_club_id');
    }

    public function awayClub()
    {
        return $this->belongsTo(Club::class,'away_club_id');
    }

    public function playerStats()
    {
        return $this->hasMany(MatchPlayerStat::class, 'match_game_id');
    }


}
