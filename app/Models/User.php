<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'dob',
        'image_url',
        'role'
    ];

    

    public function doctor() : HasOne {
        return $this->hasOne(Doctor::class);
    }
    public function gamer() : HasOne {
        return $this->hasOne(Gamer::class);
    }

    public function transactions() : HasMany {
        return $this->hasMany(Transaction::class,'gamer_id','id');
    }
    public function bougthGroups() : BelongsToMany {
        return $this->belongsToMany(Group::class,'bougth_groups','gamer_id','group_id')->using(BougthGroup::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
