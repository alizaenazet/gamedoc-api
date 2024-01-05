<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FavoriteDoctor extends Pivot
{
    protected $fillable = [
        'gamer_id',
        'doctor_id'
    ];
}
