<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Transaction extends Pivot
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'gamer_name',
        'group_name',
        'status',
        'gamer_id',
        'group_id',
        'token'
    ];

    public function group() : BelongsToMany {
        return $this->belongsToMany(Group::class);
    }
    public function gamer() : BelongsToMany {
        return $this->belongsToMany(User::class);
    }
}
