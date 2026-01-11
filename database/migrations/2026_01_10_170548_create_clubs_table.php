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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('logo')->nullable();

            $table->string('coach_name');
            $table->string('coach_phone')->nullable();
            $table->text('address')->nullable();

            $table->enum('status', [
                'pending',
                'active',
                'rejected',
                'suspended'
            ])->default('pending');

            $table->text('admin_note')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
