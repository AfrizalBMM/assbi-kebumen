<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();

            // EO utama penyelenggara
            $table->foreignId('event_organizer_id')
                ->constrained('event_organizers')
                ->cascadeOnDelete();

            // Identitas turnamen
            $table->string('name');
            $table->string('slug')->unique();

            // Kategori usia (bebas EO: U9, U10, U12, Open, dll)
            $table->string('category');

            // Waktu pelaksanaan
            $table->date('start_date');
            $table->date('end_date');

            // Lokasi
            $table->string('location')->nullable();

            // Teknis turnamen
            $table->integer('max_participants')->nullable();
            $table->decimal('registration_fee', 12, 2)->default(0);

            /**
             * STATUS TURNAMEN
             * draft      : dibuat EO, belum dibuka
             * open       : pendaftaran dibuka
             * ongoing    : sedang berlangsung
             * finished   : selesai
             * suspended  : dihentikan admin
             */
            $table->enum('status', [
                'draft',
                'open',
                'ongoing',
                'finished',
                'suspended'
            ])->default('draft');

            // Konten & kontrol admin
            $table->text('description')->nullable();
            $table->string('regulation_pdf')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
