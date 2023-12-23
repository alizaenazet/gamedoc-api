<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SocialMedia extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'name',
        'url',
    ];

    public function socialMediaable() : MorphTo {
        return $this->morphTo();
    }

}
