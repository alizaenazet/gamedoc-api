<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthReport extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'gamer_id',
        'fisik',
        'mental',
        'sosial',
        'berhenti_bermain',
        'nyeri_tulang_sendi',
        'keluhan_menggangu_aktivitas',
        'nyaman_menghabiskan_waktu_untuk_game',
        'kesulitan_bersosialiasi',
        'keluhan_gamer',
        'isgangguan_tidur',
        'isbersalah_berlebihan_bermain',
        'durasi_bermain',
        "motivasi_beraktivitas"
    ];

    public function gamer() : BelongsTo {
        return $this->belongsTo(Gamer::class);
    }
}
