<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gamer extends Model
{
    use HasFactory, HasUlids;

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function bougthGroups() : HasMany {
        return $this->hasMany(BougthGroup::class);
    }

    public function healtReport() : HasOne {
        return $this->hasOne(HealthReport::class);
    }
    
}
