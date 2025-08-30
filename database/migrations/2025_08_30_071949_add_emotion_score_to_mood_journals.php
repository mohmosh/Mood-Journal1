<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mood_journals', function (Blueprint $table) {
            $table->float('emotion_score')->nullable();  // or change to string if using labels
        });
    }

    public function down()
    {
        Schema::table('mood_journals', function (Blueprint $table) {
            $table->dropColumn('emotion_score');
        });
    }
};
