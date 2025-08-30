<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('mood_journals', function (Blueprint $table) {
            $table->text('encouragement')->nullable()->after('emotion_label');
            $table->string('verse')->nullable()->after('encouragement');
        });
    }

    public function down(): void
    {
        Schema::table('mood_journals', function (Blueprint $table) {
            $table->dropColumn(['encouragement', 'verse']);
        });
    }
};

