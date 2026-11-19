<?php

namespace Database\Seeders;

use App\Models\QuizOption;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Quiz questions and the weights used by the recommendation engine (Feature 11).
 * Each option has four weights (0-3) in this order:
 * Cyber Security, Robotics, Software Testing, Data Science.
 */
class QuizSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        QuizOption::truncate();
        QuizQuestion::truncate();
        Schema::enableForeignKeyConstraints();

        $slugs = ['cyber-security', 'robotics', 'software-testing', 'data-science'];

        $questions = [
            ['interest', 'Which activity sounds most enjoyable on a free afternoon?', [
                ['Solving a tricky puzzle or capture-the-flag challenge', [3, 1, 1, 1]],
                ['Building or wiring a small gadget that moves or senses things', [0, 3, 0, 1]],
                ['Using an app and hunting for the one odd case where it breaks', [1, 0, 3, 0]],
                ['Looking through numbers or charts to find a hidden pattern', [0, 0, 1, 3]],
            ]],
            ['interest', 'Which kind of problem would you most like to solve at work?', [
                ['Stopping an attacker from stealing customers’ data', [3, 0, 1, 1]],
                ['Making a machine do a task accurately in the real world', [1, 3, 0, 0]],
                ['Making sure a new release works before users see it', [0, 0, 3, 1]],
                ['Predicting what customers will do next', [0, 1, 0, 3]],
            ]],
            ['skill', 'Which subject do you feel strongest in?', [
                ['Computer networks and operating systems', [3, 1, 1, 0]],
                ['Physics and electronics', [1, 3, 0, 0]],
                ['Logical thinking and careful checking', [1, 0, 3, 1]],
                ['Mathematics and statistics', [0, 1, 0, 3]],
            ]],
            ['preference', 'How do you feel about working with hardware?', [
                ['I like servers, routers and network devices', [3, 1, 1, 1]],
                ['I enjoy sensors, motors and circuits', [0, 3, 0, 0]],
                ['I would use hardware only if a project needs it', [2, 1, 2, 1]],
                ['I prefer working only with software on my laptop', [1, 0, 2, 3]],
            ]],
            ['work_style', 'Which working style fits you best?', [
                ['Investigating clues like a detective', [3, 0, 1, 2]],
                ['Experimenting and tuning in a lab', [0, 3, 1, 1]],
                ['Following a careful, structured process', [1, 0, 3, 1]],
                ['Exploring data and testing ideas', [0, 1, 1, 3]],
            ]],
            ['skill', 'Which programming work attracts you most?', [
                ['Scripting and automating security tasks', [3, 1, 1, 0]],
                ['C/C++ or Python that controls real devices', [0, 3, 0, 1]],
                ['Writing automated checks for web or mobile apps', [1, 0, 3, 0]],
                ['Python with data libraries and notebooks', [0, 1, 0, 3]],
            ]],
            ['preference', 'Which employer sounds most exciting?', [
                ['A bank or telecom company protecting millions of users', [3, 0, 1, 1]],
                ['A factory, warehouse or robotics start-up', [0, 3, 0, 1]],
                ['A software company that ships new releases often', [1, 0, 3, 1]],
                ['A fintech or analytics firm that decides with data', [0, 0, 1, 3]],
            ]],
            ['work_style', 'How do you feel about detail-heavy, repetitive checking?', [
                ['I enjoy it; catching small mistakes is satisfying', [1, 0, 3, 0]],
                ['I can do it, but I prefer building new things', [0, 3, 0, 1]],
                ['I prefer investigating unusual events instead', [3, 1, 0, 1]],
                ['I prefer finding trends in large amounts of information', [0, 0, 1, 3]],
            ]],
            ['skill', 'Which statement best describes you and mathematics?', [
                ['I like practical reasoning more than formulas', [2, 0, 3, 0]],
                ['I enjoy applied maths such as geometry, motion and control', [0, 3, 0, 1]],
                ['I enjoy statistics, probability and modelling', [0, 1, 0, 3]],
                ['I like logic and puzzles but not heavy maths', [3, 1, 2, 0]],
            ]],
            ['interest', 'Which portfolio project would you be proudest of?', [
                ['A vulnerable demo app that I found flaws in and secured', [3, 0, 2, 0]],
                ['A small robot or smart device that I built myself', [0, 3, 0, 1]],
                ['An automated test suite with reports for a web app', [1, 0, 3, 0]],
                ['A dashboard or prediction model built on a real dataset', [0, 1, 1, 3]],
            ]],
            ['work_style', 'Which kind of pressure do you handle best?', [
                ['Urgent incidents where quick decisions matter', [3, 1, 1, 0]],
                ['Long build-and-test cycles that need patience', [0, 3, 1, 1]],
                ['Regular release deadlines with clear checklists', [0, 0, 3, 1]],
                ['Open-ended questions without one right answer', [1, 0, 0, 3]],
            ]],
            ['preference', 'What do you want to learn most in the next year?', [
                ['Ethical hacking and network defence', [3, 0, 1, 0]],
                ['ROS, embedded systems and control', [0, 3, 0, 1]],
                ['Playwright/Selenium and the QA process', [0, 0, 3, 0]],
                ['Machine learning and SQL', [0, 1, 0, 3]],
            ]],
        ];

        foreach ($questions as $i => [$category, $text, $options]) {
            $question = QuizQuestion::create([
                'category' => $category,
                'question' => $text,
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
            foreach ($options as $j => [$label, $weights]) {
                QuizOption::create([
                    'quiz_question_id' => $question->id,
                    'label' => $label,
                    'scores' => array_combine($slugs, $weights),
                    'sort_order' => $j + 1,
                ]);
            }
        }
    }
}
