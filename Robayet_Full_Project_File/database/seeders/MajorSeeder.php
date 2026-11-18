<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            [
                'slug' => 'cyber-security',
                'name' => 'Cyber Security',
                'icon' => 'bi-shield-lock',
                'tagline' => 'Protect systems, networks and data from attacks.',
                'overview' => 'Cyber Security focuses on defending computers, networks, applications and data from unauthorized access and attacks. You learn networking, operating systems, cryptography, ethical hacking, secure coding and incident response.',
                'why_choose' => "High global demand for security professionals\nGood salary growth and many specialisations (pentesting, SOC, forensics)\nHands-on and challenge-based learning (CTFs, labs)\nUseful in every industry: banking, telecom, government, startups",
                'difficulty' => 'Hard',
            ],
            [
                'slug' => 'robotics',
                'name' => 'Robotics',
                'icon' => 'bi-robot',
                'tagline' => 'Build intelligent machines that sense, think and act.',
                'overview' => 'Robotics combines software, electronics and mechanical ideas to build machines that can sense the environment and act on it. You learn embedded systems, control, sensors, computer vision and robot programming (ROS).',
                'why_choose' => "Exciting field that mixes hardware and software\nGrowing use in industry, agriculture, healthcare and automation\nGreat for students who enjoy building real projects\nStrong research and higher-study opportunities abroad",
                'difficulty' => 'Hard',
            ],
            [
                'slug' => 'software-testing',
                'name' => 'Software Testing',
                'icon' => 'bi-bug',
                'tagline' => 'Make sure software is correct, reliable and ready to ship.',
                'overview' => 'Software Testing (QA) ensures that software works correctly and meets requirements. You learn test design, manual and automation testing, API testing, performance testing and CI/CD quality practices.',
                'why_choose' => "Many entry-level jobs in Bangladesh software companies\nClear and beginner-friendly learning path\nAutomation skills (Selenium, Postman) are in demand\nCan grow into SDET, QA Lead or Test Architect roles",
                'difficulty' => 'Medium',
            ],
            [
                'slug' => 'data-science',
                'name' => 'Data Science',
                'icon' => 'bi-graph-up-arrow',
                'tagline' => 'Turn data into insight, predictions and decisions.',
                'overview' => 'Data Science uses statistics, programming and machine learning to extract insight from data. You learn Python, SQL, data analysis, visualization, machine learning and basics of deep learning.',
                'why_choose' => "Very high demand worldwide, including remote jobs\nWide choice of roles: Data Analyst, ML Engineer, Data Engineer\nMany free learning resources and datasets\nApplies to business, health, finance, agriculture and more",
                'difficulty' => 'Medium-Hard',
            ],
        ];

        foreach ($majors as $m) {
            Major::updateOrCreate(['slug' => $m['slug']], $m);
        }
    }
}
