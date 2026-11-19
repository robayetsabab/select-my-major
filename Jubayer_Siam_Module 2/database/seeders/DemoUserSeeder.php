<?php

namespace Database\Seeders;

use App\Models\QuizAttempt;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Services\RecommendationService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/** Demo student with two saved recommendations so the results page and history are never empty. */
class DemoUserSeeder extends Seeder
{
    public function run(RecommendationService $service): void
    {
        $user = User::updateOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'Demo Student', 'password' => 'password'] // hashed by the model cast
        );
        $user->quizAttempts()->delete();

        // Attempt 1 leans toward Software Testing, attempt 2 toward Data Science.
        foreach (['software-testing' => 5, 'data-science' => 1] as $slug => $daysAgo) {
            $answers = [];
            foreach (QuizQuestion::with('options')->orderBy('sort_order')->get() as $question) {
                $best = $question->options->sortByDesc(fn (QuizOption $o) => $o->scores[$slug] ?? 0)->first();
                $answers[$question->id] = $best->id;
            }
            $result = $service->analyse($answers);
            $attempt = QuizAttempt::create([
                'user_id' => $user->id,
                'answers' => $answers,
                'scores' => $result['scores'],
                'percentages' => $result['percentages'],
                'top_major_id' => $result['top']->id,
                'runner_up_major_id' => $result['runner_up']?->id,
                'confidence' => $result['confidence'],
                'is_tie' => $result['is_tie'],
            ]);
            $attempt->forceFill(['created_at' => now()->subDays($daysAgo), 'updated_at' => now()->subDays($daysAgo)])->saveQuietly();
        }
    }
}
