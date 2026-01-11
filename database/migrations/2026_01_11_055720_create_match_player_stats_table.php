<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_player_stats', function (Blueprint $table) {
            $table->id();

            // INI YANG HILANG TADI
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('player_id');

            $table->integer('goals')->default(0);
            $table->integer('yellow_cards')->default(0);
            $table->integer('red_cards')->default(0);
            $table->integer('minutes_played')->default(0);

            $table->timestamps();

            // FK ke tabel matches (bukan match_games)
            $table->foreign('match_id')
                ->references('id')
                ->on('matches')
                ->cascadeOnDelete();

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_player_stats');
    }
};
