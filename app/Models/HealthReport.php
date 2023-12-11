<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthReport extends Model
{
    use HasFactory,HasUuids;

    public function gamer() : BelongsTo {
        return $this->belongsTo(Gamer::class);
    }
}
