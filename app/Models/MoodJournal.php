<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoodJournal extends Model
{
    use HasFactory, SoftDeletes;

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'mood',
        'entry',
        'tags',
        'entry_date',
        'emotion_score',
        'emotion_label',
        'encouragement',
        'verse',
    ];

    // Cast tags as array and entry_date as datetime automatically
    protected $casts = [
        'tags' => 'array',
        'entry_date' => 'datetime',
    ];

    /**
     * The user who owns this mood journal entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function response()
    {
        return $this->hasOne(\App\Models\JournalResponse::class, 'mood_journal_id');
    }
}
