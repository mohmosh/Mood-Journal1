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
        Schema::create('mood_journals', function (Blueprint $table) {
            $table->id(); // Primary key (auto-increment)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Foreign key to users
            $table->string('mood'); // Mood text (e.g., Happy, Sad)
            $table->text('entry'); // The journal entry content
            $table->json('tags')->nullable(); // Optional tags as JSON array
            $table->dateTime('entry_date'); // Date & time of the entry
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // soft delete column (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mood_journals');
    }
};

