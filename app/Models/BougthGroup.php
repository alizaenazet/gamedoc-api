<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BougthGroup extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "gamer_id",
        "group_id"
    ];

    // public function gamer() : BelongsToMany {
    //    return $this->BelongsToMany(Gamer::class);
    // }
    // tambahkan relasi ke model Gamer dan Group jika diperlukan
    public function gamer()
    {
        return $this->belongsTo(Gamer::class, 'gamer_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
