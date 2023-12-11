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
        Schema::create('doctor_group_tabel', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('doctor_id')
                ->constrained('doctors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('group_id')
                ->constrained('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_group_tabel');
    }
};
