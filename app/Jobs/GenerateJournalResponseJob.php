<?php

namespace App\Jobs;

use App\Models\MoodJournal;
use App\Models\JournalResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;

class GenerateJournalResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $journal;

    public function __construct(MoodJournal $journal)
    {
        $this->journal = $journal;
    }

    public function handle(): void
    {
        if (!$this->journal->emotion_label) {
            \Log::warning("⚠️ Journal {$this->journal->id} has no emotion_label yet. Skipping.");
            return;
        }

        try {
            $prompt = "Write an encouraging message and share a short Bible verse for someone feeling {$this->journal->emotion_label}.";

            \Log::info("📤 Sending prompt to OpenAI:", [$prompt]);

            $response = Http::withToken(env('OPENAI_API_KEY'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini', // or 'gpt-3.5-turbo'
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a kind Christian encourager.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 200,
                ]);

            \Log::info("📥 OpenAI raw response:", $response->json());

            if ($response->failed()) {
                \Log::error('❌ OpenAI API request failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return;
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                \Log::warning('⚠️ OpenAI API returned empty content', $data);
                return;
            }

            JournalResponse::create([
                'mood_journal_id' => $this->journal->id,
                'encouragement'   => $content,
                'bible_verse'     => null, // optional: extract later
            ]);

            \Log::info("✅ JournalResponse saved for Journal ID {$this->journal->id}");
        } catch (\Throwable $e) {
            \Log::error('❌ Error in GenerateJournalResponseJob', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
