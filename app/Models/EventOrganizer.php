<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventOrganizer extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'logo',
        'contact_person',
        'phone',
        'email',
        'address',
        'status',
        'admin_note',
    ];
}
