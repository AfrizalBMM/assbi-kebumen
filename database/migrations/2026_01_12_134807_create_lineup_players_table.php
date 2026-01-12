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
        Schema::create('lineup_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lineup_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->enum('role',['starter','bench'])->default('starter');
            $table->string('position')->nullable();
            $table->integer('x')->default(0); // posisi di lapangan
            $table->integer('y')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineup_players');
    }
};
