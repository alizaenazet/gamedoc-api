<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


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

    public function socialMedias() : MorphMany {
        return $this->morphMany(SocialMedia::class,'socialMediaable');
    }

    public function groups() : BelongsToMany {
        return $this->belongsToMany(Group::class);
    }

    public function gamerFavorites() : BelongsToMany {
        return $this->belongsToMany(Gamer::class)->using(FavoriteDoctor::class);
    }

    
}
