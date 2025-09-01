<?php

namespace App\Http\Controllers;

use App\Models\MoodJournal;
use App\Http\Requests\StoreMoodJournalRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;


class MoodJournalController extends Controller
{
    /**
     * Require user authentication for all journal routes.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all mood journal entries for the logged-in user.
     */
    public function index()
    {

        $journals = MoodJournal::where('user_id', Auth::id())
            ->latest('entry_date')
            ->paginate(10);

        // Retrieve moods data (or emotion scores) for the chart
        $moods = MoodJournal::where('user_id', Auth::id())
            ->get(['entry_date', 'emotion_score'])
            ->map(function ($journal) {
                return [
                    'entry_date'    => \Carbon\Carbon::parse($journal->entry_date)->format('Y-m-d'),
                    'emotion_score' => $journal->emotion_score
                        ? round($journal->emotion_score)   // ensure 0–100
                        : 0,
                ];
            });




        // dd($moods->toArray());


        return view('mood_journals.index', compact('journals', 'moods'));
    }



    /**
     * Show form to create a new mood journal entry.
     */
    public function create()
    {
        return view('mood_journals.create');
    }

    /**
     * Store a new mood journal entry in DB.
     */

    public function store(StoreMoodJournalRequest $request)
    {
        // 1. Store the journal entry first in DB
        $journal = MoodJournal::create([
            'user_id'    => Auth::id(),
            'mood'       => $request->mood,
            'entry'      => $request->entry,
            'tags'       => $request->tags,
            'entry_date' => $request->entry_date,
        ]);

        // 2. Call Hugging Face API to analyze the emotion from the journal entry
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
        ])->post(
            'https://api-inference.huggingface.co/models/j-hartmann/emotion-english-distilroberta-base',
            [
                'inputs' => $request->entry,  // send the journal text for analysis
            ]
        );

        // 3. Handle Hugging Face response
        if ($response->successful()) {
            \Log::info('✅ HuggingFace raw response', $response->json());

            $result = $response->json();
            $topEmotion = collect($result[0] ?? [])->sortByDesc('score')->first();

            if ($topEmotion) {
                // Save the top emotion (label + score) back to journal
                $journal->emotion_label = $topEmotion['label'];
                $journal->emotion_score = intval($topEmotion['score'] * 100);
                $journal->save();

                \Log::info('✅ Stored Emotion:', [
                    'label' => $journal->emotion_label,
                    'score' => $journal->emotion_score,
                ]);

                // 4. Dispatch a background job to Claude API
                // This will generate an encouragement message and Bible verse
                \App\Jobs\GenerateJournalResponseJob::dispatch($journal);
            } else {
                \Log::warning('⚠️ No topEmotion found', ['result' => $result]);
            }
        } else {
            // Log Hugging Face error if it fails
            \Log::error('❌ HuggingFace API failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        }

        // 5. Redirect back to journal list with success message
        return redirect()->route('mood-journals.index')
            ->with('success', 'Mood journal entry added, emotion analyzed, and encouragement requested!');
    }





    /**
     * Show form to edit an existing entry.
     */
    public function edit(MoodJournal $moodJournal)
    {
        $this->authorizeAccess($moodJournal);

        return view('mood_journals.edit', compact('moodJournal'));
    }

    /**
     * Update an existing mood journal entry.
     */
    public function update(StoreMoodJournalRequest $request, MoodJournal $moodJournal)
    {
        // 1. Ensure only owner can update the journal
        $this->authorizeAccess($moodJournal);

        // 2. Update journal fields
        $moodJournal->update($request->validated());

        // 3. Re-analyze the updated entry with Hugging Face API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
        ])->post('https://api-inference.huggingface.co/models/j-hartmann/emotion-english-distilroberta-base', [
            'inputs' => $moodJournal->entry,
        ]);

        if ($response->successful()) {
            $emotionData = $response->json();

            if (isset($emotionData[0])) {
                // Get top emotion
                $topEmotion = collect($emotionData[0])->sortByDesc('score')->first();

                // Save updated emotion to journal
                $moodJournal->emotion_label = $topEmotion['label'] ?? 'neutral';
                $moodJournal->emotion_score = isset($topEmotion['score'])
                    ? round($topEmotion['score'] * 100)
                    : 0;

                $moodJournal->save();

                // 4. Dispatch Claude job again
                // So updated entries get fresh encouragement + verse
                \App\Jobs\GenerateJournalResponseJob::dispatch($moodJournal);
            }
        }

        // 5. Redirect back with success message
        return redirect()->route('mood-journals.index')
            ->with('success', 'Mood journal updated, re-analyzed, and new encouragement requested!');
    }




    /**
     * Delete an entry (soft delete).
     */
    public function destroy(MoodJournal $moodJournal)
    {
        $this->authorizeAccess($moodJournal);

        $moodJournal->delete();

        return redirect()->route('mood-journals.index')
            ->with('success', 'Mood journal deleted successfully!');
    }

    
    /**
     * Show a single mood journal entry with its AI-generated response.
     */
    public function show(MoodJournal $moodJournal)
    {
        // 1. Ensure the logged-in user owns this journal
        $this->authorizeAccess($moodJournal);

        // 2. Eager-load the Claude response (encouragement + verse)
        $moodJournal->load('response');

        // 3. Pass both the journal and its response to the view
        return view('mood_journals.show', compact('moodJournal'));
    }

    /**
     * Helper to ensure users only access their own entries.
     */
    private function authorizeAccess(MoodJournal $journal)
    {
        if ($journal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this journal entry.');
        }
    }
}
