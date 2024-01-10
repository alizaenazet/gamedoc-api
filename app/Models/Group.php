<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Group extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name",
        "description",
        "image_url",
        "price",
    ];

    public function socialMedias() : MorphMany {
        return $this->morphMany(SocialMedia::class,'socialMediaable');
    }

    public function doctors() : BelongsToMany {
        return $this->belongsToMany(Doctor::class);
    }

    public function usersBougthGroup() : BelongsToMany {
        return $this->belongsToMany(User::class,'bougth_groups','group_id','gamer_id');
    }
}
