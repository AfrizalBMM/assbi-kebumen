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
        Schema::create('tournament_registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('club_id')->constrained()->cascadeOnDelete();

            $table->enum('status', [
                'pending',   // daftar → tunggu EO
                'approved',  // lolos
                'rejected'   // ditolak
            ])->default('pending');

            $table->text('eo_note')->nullable();

            $table->timestamps();

            $table->unique(['tournament_id','club_id']); // satu club 1x daftar
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_registrations');
    }
};
