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
        Schema::table('users', function (Blueprint $table) {

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs')
                ->nullOnDelete();

            $table->foreign('event_organizer_id')
                ->references('id')
                ->on('event_organizers')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropForeign(['event_organizer_id']);
        });
    }

};
