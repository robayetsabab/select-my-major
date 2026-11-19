<?php

namespace Tests\Feature;

use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Smoke tests for Jubayer's features. Run: php artisan test --filter=JubayerFeaturesTest */
class JubayerFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_public_pages_load(): void
    {
        foreach (['/', '/majors', '/subfields', '/careers', '/certifications', '/experiences', '/login'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_api_returns_seeded_data(): void
    {
        $this->getJson('/api/v1/majors')->assertOk()->assertJsonCount(4, 'data');
        $this->getJson('/api/v1/subfields?per_page=100')->assertOk()->assertJsonPath('total', 16);
        $this->getJson('/api/v1/careers?per_page=100')->assertOk()->assertJsonPath('total', 20);
        $this->getJson('/api/v1/experiences?per_page=100')->assertOk()->assertJsonPath('total', 28);
    }

    public function test_quiz_requires_login(): void
    {
        $this->get('/quiz')->assertRedirect('/login');
    }

    public function test_recommendation_matches_the_strongest_major(): void
    {
        $user = User::factory()->create();
        $answers = [];
        foreach (QuizQuestion::with('options')->get() as $question) {
            $answers[$question->id] = $question->options
                ->sortByDesc(fn (QuizOption $o) => $o->scores['robotics'])->first()->id;
        }

        $this->actingAs($user)->post('/quiz', ['answers' => $answers])->assertRedirect();
        $attempt = $user->quizAttempts()->first();

        $this->assertSame('robotics', $attempt->topMajor->slug);
        $this->assertSame(100, $attempt->percentages['robotics']);
        $this->actingAs($user)->get('/recommendation/' . $attempt->id)->assertOk()->assertSee('Robotics');
    }

    public function test_incomplete_quiz_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())->post('/quiz', ['answers' => []])->assertSessionHasErrors('answers');
    }

    public function test_one_student_cannot_open_anothers_result(): void
    {
        $this->seed(\Database\Seeders\DemoUserSeeder::class);
        $attempt = User::where('email', 'student@example.com')->first()->quizAttempts()->first();
        $this->actingAs(User::factory()->create())->get('/recommendation/' . $attempt->id)->assertForbidden();
    }
}
