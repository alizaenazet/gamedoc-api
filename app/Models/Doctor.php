<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Doctor extends Model
{
    use HasFactory,HasUlids;

    protected $fillable = [
        'profession',
        'service',
        'degree',
        'rating'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    
}
