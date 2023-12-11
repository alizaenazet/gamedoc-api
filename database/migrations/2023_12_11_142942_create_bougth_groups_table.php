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
        Schema::create('bougth_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('gamer_id')
            ->constrained('gamers')
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
        Schema::dropIfExists('bougth_groups');
    }
};
