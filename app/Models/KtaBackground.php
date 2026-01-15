<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KtaBackground extends Model
{
    protected $fillable = [
        'owner_type',
        'owner_id',
        'name',
        'image_path',
        'is_active'
    ];
}
