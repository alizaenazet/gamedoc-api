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
            $table->string('fisik')->nullable();
            $table->string('mental')->nullable();
            $table->string('sosial')->nullable();
            $table->string('berhenti_bermain')->nullable();
            $table->string('motivasi_beraktivitas')->nullable();
            $table->string('nyeri_tulang_sendi')->nullable();
            $table->string('keluhan_menggangu_aktivitas')->nullable();
            $table->string('nyaman_menghabiskan_waktu_untuk_game')->nullable();
            $table->string('kesulitan_bersosialiasi')->nullable();
            $table->set('keluhan_gamer',['mental','fisik','sosial']);
            $table->boolean('isgangguan_tidur');
            $table->boolean('isbersalah_berlebihan_bermain');
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
