<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'logo',
        'coach_name',
        'coach_phone',
        'address',
        'status',
        'admin_note',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(TournamentRegistration::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function tournaments()
    {
        return $this->belongsToMany(
            Tournament::class,
            'tournament_registrations',   // pivot table
            'club_id',
            'tournament_id'
        )->withPivot('status')->withTimestamps();
    }


}
