<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Quiz page (Feature 10 belongs to Robayet; this minimal version feeds the recommendation engine).
 * Quiz and results are for registered students only (Feature 13).
 */
class QuizController extends Controller
{
    public function show()
    {
        $questions = QuizQuestion::where('is_active', true)->with('options')->orderBy('sort_order')->get();
        $last = auth()->user()->quizAttempts()->latest()->first();
        return view('quiz.show', compact('questions', 'last'));
    }

    public function submit(Request $request, RecommendationService $service)
    {
        $questions = QuizQuestion::where('is_active', true)->with('options')->get();
        $answers = (array) $request->input('answers', []);

        $clean = [];
        foreach ($questions as $question) {
            $optionId = (int) ($answers[$question->id] ?? 0);
            if (!$question->options->contains('id', $optionId)) {
                throw ValidationException::withMessages([
                    'answers' => 'Please answer every question before you see your result.',
                ]);
            }
            $clean[$question->id] = $optionId;
        }

        $result = $service->analyse($clean);
        $attempt = QuizAttempt::create([
            'user_id' => $request->user()->id,
            'answers' => $clean,
            'scores' => $result['scores'],
            'percentages' => $result['percentages'],
            'top_major_id' => $result['top']->id,
            'runner_up_major_id' => $result['runner_up']?->id,
            'confidence' => $result['confidence'],
            'is_tie' => $result['is_tie'],
        ]);

        return redirect()->route('recommendation.show', $attempt);
    }
}
