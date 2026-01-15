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
        Schema::create('kta_backgrounds', function (Blueprint $table) {
            $table->id();

            $table->string('owner_type'); // assbi | club
            $table->unsignedBigInteger('owner_id')->nullable();

            $table->string('name');
            $table->string('image_path');
            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kta_backgrounds');
    }
};
