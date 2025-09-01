<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('journal_responses', function (Blueprint $table) {
            $table->id(); // auto-increment PK
            $table->foreignId('mood_journal_id') // FK column
                  ->constrained('mood_journals') // references id on mood_journals
                  ->cascadeOnDelete();

            $table->text('encouragement')->nullable();
            $table->string('bible_verse')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('journal_responses');
    }
};
