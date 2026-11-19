<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\QuizAttempt;
use App\Models\SeniorExperience;
use App\Services\RecommendationService;

class RecommendationController extends Controller
{
    public function history()
    {
        $attempts = auth()->user()->quizAttempts()->with('topMajor')->latest()->paginate(10);
        return view('recommendation.history', compact('attempts'));
    }

    public function show(QuizAttempt $attempt, RecommendationService $service)
    {
        abort_unless($attempt->user_id === auth()->id(), 403);

        $majors = Major::orderBy('sort_order')->get()->keyBy('slug');
        $ranking = $majors->map(fn (Major $m) => [
            'major' => $m,
            'score' => $attempt->scores[$m->slug] ?? 0,
            'percent' => $attempt->percentages[$m->slug] ?? 0,
        ])->sort(function ($a, $b) use ($attempt) {
            // Highest match first; if two majors tie, the stored winner stays on top.
            return [$b['percent'], $b['major']->id === $attempt->top_major_id ? 1 : 0, $a['major']->sort_order]
                <=> [$a['percent'], $a['major']->id === $attempt->top_major_id ? 1 : 0, $b['major']->sort_order];
        })->values();

        $top = $attempt->topMajor ?? $ranking->first()['major'];
        $runnerUp = $attempt->runnerUp;
        $reasons = $service->reasonsForAttempt($attempt->answers, $top->slug);

        $subfields = $top->subfields()->orderBy('sort_order')->get();
        $careers = $top->careers()->orderBy('sort_order')->get();
        $certifications = $top->certifications()->orderBy('sort_order')->take(3)->get();
        $experiences = SeniorExperience::published()->where('major_id', $top->id)
            ->orderByDesc('helpful_count')->take(3)->get();

        $previous = auth()->user()->quizAttempts()->where('id', '<', $attempt->id)->latest('id')->first();

        return view('recommendation.show', compact(
            'attempt', 'ranking', 'top', 'runnerUp', 'reasons', 'subfields', 'careers',
            'certifications', 'experiences', 'previous'
        ));
    }
}
