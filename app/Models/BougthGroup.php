<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BougthGroup extends Model
{
    use HasFactory, HasUlids;

    public function gamer() : BelongsToMany {
       return $this->BelongsToMany(Gamer::class);
    }
}
