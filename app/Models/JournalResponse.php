<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JournalResponse extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'mood_journal_id',
        'encouragement',
        'bible_verse',
    ];

    public function journal()
    {
        return $this->belongsTo(MoodJournal::class, 'mood_journal_id');
    }
}
