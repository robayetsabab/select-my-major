<?php

namespace App\Services;

use App\Models\Major;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use Illuminate\Support\Collection;

/**
 * Feature 11 - Recommendation System.
 *
 * Rule-based weighted scoring (no AI model):
 *  1. every quiz option carries a weight (0-3) for each major;
 *  2. the chosen option of each question adds its weights to the major totals;
 *  3. each total is divided by the best score that major could possibly reach, giving a 0-100 match;
 *  4. ties are broken by the number of "strong" (weight 3) answers, then by the major's sort order.
 */
class RecommendationService
{
    public const STRONG_WEIGHT = 3;

    /**
     * @param  array<int|string,int|string>  $answers  question_id => option_id
     * @return array{
     *   scores: array<string,int>, percentages: array<string,int>, ranking: Collection,
     *   top: Major, runner_up: ?Major, confidence: string, is_tie: bool, reasons: array<int,array>
     * }
     */
    public function analyse(array $answers): array
    {
        $majors = Major::orderBy('sort_order')->get();
        $questions = QuizQuestion::where('is_active', true)->with('options')->get();

        $scores = $strong = $maxPossible = [];
        foreach ($majors as $major) {
            $scores[$major->slug] = 0;
            $strong[$major->slug] = 0;
            $maxPossible[$major->slug] = 0;
        }

        $chosen = [];
        foreach ($questions as $question) {
            foreach ($majors as $major) {
                $maxPossible[$major->slug] += (int) $question->options->max(fn (QuizOption $o) => $o->scores[$major->slug] ?? 0);
            }
            $option = $question->options->firstWhere('id', (int) ($answers[$question->id] ?? 0));
            if (!$option) {
                continue; // unanswered or invalid option: contributes nothing
            }
            $chosen[] = [$question, $option];
            foreach ($majors as $major) {
                $weight = (int) ($option->scores[$major->slug] ?? 0);
                $scores[$major->slug] += $weight;
                if ($weight >= self::STRONG_WEIGHT) {
                    $strong[$major->slug]++;
                }
            }
        }

        $percentages = [];
        foreach ($majors as $major) {
            $max = $maxPossible[$major->slug];
            $percentages[$major->slug] = $max > 0 ? (int) round($scores[$major->slug] / $max * 100) : 0;
        }

        $ranking = $majors->map(fn (Major $m) => [
            'major' => $m,
            'score' => $scores[$m->slug],
            'percent' => $percentages[$m->slug],
            'strong' => $strong[$m->slug],
        ])->sort(function ($a, $b) {
            return [$b['score'], $b['strong'], $a['major']->sort_order] <=> [$a['score'], $a['strong'], $b['major']->sort_order];
        })->values();

        $first = $ranking[0];
        $second = $ranking[1] ?? null;
        $isTie = $second && $first['score'] === $second['score'] && $first['strong'] === $second['strong'];
        $gap = $second ? $first['percent'] - $second['percent'] : 100;
        $confidence = $isTie ? 'Close call' : ($gap >= 15 ? 'Strong match' : ($gap >= 7 ? 'Good match' : 'Close call'));

        return [
            'scores' => $scores,
            'percentages' => $percentages,
            'ranking' => $ranking,
            'top' => $first['major'],
            'runner_up' => $second['major'] ?? null,
            'confidence' => $confidence,
            'is_tie' => $isTie,
            'reasons' => $this->reasons($chosen, $first['major']->slug),
        ];
    }

    /** The answers that pushed the winning major up the most, shown as "why this result". */
    public function reasons(array $chosen, string $slug, int $limit = 4): array
    {
        return collect($chosen)
            ->map(fn ($pair) => [
                'question' => $pair[0]->question,
                'answer' => $pair[1]->label,
                'weight' => (int) ($pair[1]->scores[$slug] ?? 0),
            ])
            ->filter(fn ($row) => $row['weight'] >= 2)
            ->sortByDesc('weight')
            ->take($limit)
            ->values()
            ->all();
    }

    /** Re-build the "why" list for a stored attempt. */
    public function reasonsForAttempt(array $answers, string $slug): array
    {
        $options = QuizOption::with('question')->whereIn('id', array_values($answers))->get();
        $chosen = $options->map(fn ($o) => [$o->question, $o])->all();
        return $this->reasons($chosen, $slug);
    }
}
