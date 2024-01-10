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
        Schema::create('transaction', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('gamer_name');
            $table->string('group_name');
            $table->string('token');
            $table->enum('status',[
                'pending','capture','settlement','success',
                'deny','cancel','expire','failure','refund',
                'chargeback', 'partial refund', 
                'partial charge back']);
            $table->foreignUuid('group_id')
                ->constrained('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('gamer_id')
                ->constrained('users')
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
        Schema::dropIfExists('transactions');
    }
};
