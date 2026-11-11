<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            [
                'name' => 'Cyber Security',
                'slug' => 'cyber-security',
                'description' => 'Learn about network security, ethical hacking, and digital protection.',
            ],
            [
                'name' => 'Robotics',
                'slug' => 'robotics',
                'description' => 'Learn about robots, automation, and intelligent machines.',
            ],
            [
                'name' => 'Software Testing',
                'slug' => 'software-testing',
                'description' => 'Learn how to test software and find errors or bugs.',
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Learn how to analyze data and discover useful insights.',
            ],
        ];

        foreach ($majors as $major) {
            Major::updateOrCreate(
                ['slug' => $major['slug']],
                $major
            );
        }
    }
}