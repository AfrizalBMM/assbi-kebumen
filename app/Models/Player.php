<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'club_id',
        'name',
        'birth_date',
        'birth_place',
        'position',
        'photo',
        'document_pdf',
        'nik',
        'status',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function matchStats()
    {
        return $this->hasMany(MatchPlayerStat::class);
    }

    public function stats()
    {
        return $this->hasMany(\App\Models\MatchPlayerStat::class);
    }


}
