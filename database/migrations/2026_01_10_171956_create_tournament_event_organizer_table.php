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
        Schema::create('tournament_event_organizer', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tournament_id')
                ->constrained('tournaments')
                ->cascadeOnDelete();

            $table->foreignId('event_organizer_id')
                ->constrained('event_organizers')
                ->cascadeOnDelete();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_event_organizer');
    }
};
