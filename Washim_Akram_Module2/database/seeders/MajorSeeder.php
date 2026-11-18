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
                'short_description' => 'Protect computer systems, networks and data from cyber threats.',
                'required_skills' => ['Networking', 'Linux', 'Programming', 'Problem Solving'],
                'prerequisites' => ['Basic Computer Knowledge', 'Basic Programming'],
                'difficulty' => 'Advanced',
                'roadmap' => ['Learn Networking', 'Learn Linux', 'Study Security Fundamentals', 'Practice Ethical Security', 'Build Projects'],
                'certifications' => ['CompTIA Security+', 'CEH'],
                'career_opportunities' => ['Security Analyst', 'Penetration Tester', 'Security Engineer'],
                'job_market_bd' => 'Opportunities in IT companies, banks, telecom and financial organizations in Bangladesh.',
                'job_market_international' => 'Opportunities in cybersecurity firms, technology companies and government organizations worldwide.',
            ],
            [
                'name' => 'Robotics',
                'slug' => 'robotics',
                'short_description' => 'Design and develop intelligent robots and automated systems.',
                'required_skills' => ['C++', 'Python', 'Electronics', 'Mathematics'],
                'prerequisites' => ['Basic Programming', 'Basic Mathematics', 'Physics'],
                'difficulty' => 'Advanced',
                'roadmap' => ['Learn Programming', 'Study Electronics', 'Learn Robotics Fundamentals', 'Practice Sensors and Controllers', 'Build Robots'],
                'certifications' => ['ROS Training', 'Robotics Specialization'],
                'career_opportunities' => ['Robotics Engineer', 'Automation Engineer', 'Control Systems Engineer'],
                'job_market_bd' => 'Opportunities in automation, manufacturing, research and educational institutions.',
                'job_market_international' => 'Opportunities in robotics, automotive, healthcare, manufacturing and research industries.',
            ],
            [
                'name' => 'Software Testing',
                'slug' => 'software-testing',
                'short_description' => 'Ensure software quality through testing and quality assurance.',
                'required_skills' => ['Programming', 'Testing Fundamentals', 'Attention to Detail', 'Problem Solving'],
                'prerequisites' => ['Basic Computer Knowledge', 'Basic Programming'],
                'difficulty' => 'Intermediate',
                'roadmap' => ['Learn Testing Fundamentals', 'Study Manual Testing', 'Learn SQL', 'Practice Automation Testing', 'Build Testing Projects'],
                'certifications' => ['ISTQB Foundation Level', 'Certified Software Tester'],
                'career_opportunities' => ['QA Engineer', 'Software Tester', 'Automation Test Engineer'],
                'job_market_bd' => 'Opportunities in software companies, IT firms and quality assurance teams in Bangladesh.',
                'job_market_international' => 'Opportunities in software development companies, technology firms and international QA teams.',
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'short_description' => 'Extract useful insights from data using statistics and computing.',
                'required_skills' => ['Python', 'Statistics', 'SQL', 'Data Analysis', 'Mathematics'],
                'prerequisites' => ['Basic Mathematics', 'Basic Programming', 'Statistics Fundamentals'],
                'difficulty' => 'Advanced',
                'roadmap' => ['Learn Python', 'Study Statistics', 'Learn SQL', 'Practice Data Analysis', 'Study Machine Learning', 'Build Projects'],
                'certifications' => ['IBM Data Science Professional Certificate', 'Google Data Analytics Certificate'],
                'career_opportunities' => ['Data Analyst', 'Data Scientist', 'Machine Learning Engineer'],
                'job_market_bd' => 'Opportunities in technology companies, banks, telecom, research and business analytics.',
                'job_market_international' => 'Opportunities in technology, healthcare, finance, research and AI industries worldwide.',
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
