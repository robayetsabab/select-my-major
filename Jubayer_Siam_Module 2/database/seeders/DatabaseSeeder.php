<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            Module1Seeder::class,            // majors + certifications (shared group data)
            JubayerFeatureSeeder::class,     // Feature 2 subfields, Feature 5 careers
            SeniorExperienceSeeder::class,   // Feature 8 senior stories
            QuizSeeder::class,               // quiz questions + weights for Feature 11
            DemoUserSeeder::class,           // demo login + sample recommendations
        ]);
    }
}
