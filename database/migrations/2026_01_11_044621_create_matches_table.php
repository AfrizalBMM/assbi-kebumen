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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tournament_group_id')->nullable(); // null = knockout
            $table->foreignId('home_club_id')->constrained('clubs');
            $table->foreignId('away_club_id')->constrained('clubs');

            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();

            $table->date('match_date')->nullable();
            $table->time('match_time')->nullable();
            $table->string('venue')->nullable();

            $table->enum('stage', [
                'group',
                'round_of_16',
                'quarter_final',
                'semi_final',
                'final'
            ])->default('group');

            $table->enum('status', [
                'scheduled',
                'playing',
                'finished'
            ])->default('scheduled');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
