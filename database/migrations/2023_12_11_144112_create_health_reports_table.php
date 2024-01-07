<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('health_reports', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));;
            $table->foreignUuid('gamer_id')
                ->constrained('gamers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('fisik',1506)->nullable()->default('');
            $table->string('mental',1506)->nullable()->default('');
            $table->string('sosial',1506)->nullable()->default('');
            $table->string('berhenti_bermain',1506)->nullable()->default('');
            $table->string('motivasi_beraktivitas',1506)->nullable()->default('');
            $table->string('nyeri_tulang_sendi',1506)->nullable()->default('');
            $table->string('keluhan_menggangu_aktivitas',1506)->nullable()->default('');
            $table->string('nyaman_menghabiskan_waktu_untuk_game',1506)->nullable()->default('');
            $table->string('kesulitan_bersosialiasi',1506)->nullable()->default('');
            $table->set('keluhan_gamer',['mental','fisik','sosial']);
            $table->boolean('isgangguan_tidur')->default(false);
            $table->boolean('isbersalah_berlebihan_bermain')->default(false);;;
            $table->integer('durasi_bermain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_reports');
    }
};
