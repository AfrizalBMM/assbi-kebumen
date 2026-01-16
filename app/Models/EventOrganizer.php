<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventOrganizer extends Model
{
    protected $fillable = [
        'user_id','name','short_name','logo',
        'contact_person','phone','email',
        'address','status','admin_note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo
            ? asset('storage/eos/'.$this->logo)
            : asset('images/default-eo.png');
    }
}
