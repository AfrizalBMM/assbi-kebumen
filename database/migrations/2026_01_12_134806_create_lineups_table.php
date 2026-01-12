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
        Schema::create('lineups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tournament_id')->nullable()->constrained()->nullOnDelete();
            $table->string('match_name')->nullable(); // vs SSB Maju Jaya
            $table->string('formation')->default('4-4-2');
            $table->dateTime('match_date')->nullable();
            $table->dateTime('lock_time')->nullable();
            $table->enum('status',['draft','submitted','locked'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineups');
    }
};
