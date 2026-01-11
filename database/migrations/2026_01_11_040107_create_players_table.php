<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();

            // Relasi ke Club
            $table->foreignId('club_id')
                ->constrained()
                ->cascadeOnDelete();

            // Data utama (WAJIB)
            $table->string('name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('position', ['GK','DF','MF','FW']);

            // Data opsional
            $table->string('photo')->nullable();
            $table->string('document_pdf')->nullable();
            $table->string('nik')->nullable();

            // Status
            $table->enum('status', ['active','inactive','suspended'])
                ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
