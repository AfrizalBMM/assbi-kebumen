<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('kta_number')->nullable()->after('status');
            $table->string('kta_path')->nullable()->after('kta_number');
        });
    }

    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn(['kta_number','kta_path']);
        });
    }
};

