<?php

namespace App\Http\Controllers;

use App\Models\Major;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::all();

        return view('majors.index', compact('majors'));
    }

    public function show($slug)
    {
        $major = Major::where('slug', $slug)->firstOrFail();

        $data = [

            // Cyber Security
            'cyber-security' => [
                'skills' => [
                    'Computer Networking',
                    'Linux Fundamentals',
                    'Basic Programming',
                    'Network Security',
                    'Problem Solving',
                ],

                'prerequisites' => [
                    'Basic Computer Knowledge',
                    'Basic Networking Knowledge',
                    'Interest in Cyber Security',
                ],

                'courses' => [
                    'Introduction to Cyber Security',
                    'Computer Networking',
                    'Linux Fundamentals',
                    'Ethical Hacking Fundamentals',
                ],

                'roadmap' => [
                    'Learn computer fundamentals.',
                    'Study networking basics.',
                    'Learn Linux operating system.',
                    'Understand security fundamentals.',
                    'Practice in legal cybersecurity labs.',
                ],

                'job_market' => 'Cyber Security professionals work in security teams, IT companies, banks, and technology organizations in Bangladesh and internationally.',

                'salary_bd' => 'Indicative entry-level salary: BDT 25,000–50,000 per month. Salary varies by skills, experience and organization.',

                'salary_international' => 'International salary varies widely by country and experience. In the United States, Information Security Analysts had a median annual wage of about $124,910 in May 2024.',

                'industries' => [
                    'Banking and Financial Services',
                    'IT and Software Companies',
                    'Telecommunication',
                    'Government and Technology Organizations',
                ],

                'career_roles' => [
                    'Cyber Security Analyst',
                    'Security Engineer',
                    'SOC Analyst',
                    'Information Security Specialist',
                ],
            ],

            // Robotics
            'robotics' => [
                'skills' => [
                    'Basic Programming',
                    'Mathematics',
                    'Electronics',
                    'Problem Solving',
                ],

                'prerequisites' => [
                    'Basic Mathematics',
                    'Basic Physics',
                    'Interest in Technology',
                ],

                'courses' => [
                    'Introduction to Robotics',
                    'Programming Fundamentals',
                    'Electronics',
                    'Control Systems',
                ],

                'roadmap' => [
                    'Learn mathematics and physics basics.',
                    'Study programming fundamentals.',
                    'Learn basic electronics.',
                    'Understand sensors and motors.',
                    'Build beginner robotics projects.',
                ],

                'job_market' => 'Robotics opportunities are available in automation, manufacturing, research, and technology industries internationally. Opportunities in Bangladesh are developing.',

                'salary_bd' => 'Indicative entry-level salary: BDT 25,000–50,000 per month. Actual salary depends on the employer and technical skills.',

                'salary_international' => 'International salary varies by country and specialization. Robotics engineering roles in the United States can offer roughly $70,000–120,000 per year.',

                'industries' => [
                    'Manufacturing',
                    'Automation',
                    'Research and Development',
                    'Healthcare Technology',
                ],

                'career_roles' => [
                    'Robotics Engineer',
                    'Automation Engineer',
                    'Robotics Researcher',
                    'Embedded Systems Engineer',
                ],
            ],

            // Software Testing
            'software-testing' => [
                'skills' => [
                    'Attention to Detail',
                    'Analytical Thinking',
                    'Problem Solving',
                    'Basic Programming',
                    'Communication',
                ],

                'prerequisites' => [
                    'Basic Computer Knowledge',
                    'Understanding of Software',
                    'Logical Thinking',
                ],

                'courses' => [
                    'Software Testing Fundamentals',
                    'Manual Testing',
                    'Automation Testing',
                    'Software Quality Assurance',
                ],

                'roadmap' => [
                    'Understand software development basics.',
                    'Learn manual testing.',
                    'Practice writing test cases.',
                    'Learn bug reporting.',
                    'Explore automation testing tools.',
                ],

                'job_market' => 'Software testing professionals work in software companies, IT services, banking, and technology organizations in Bangladesh and internationally.',

                'salary_bd' => 'Indicative entry-level salary: BDT 25,000–45,000 per month. Automation testing skills may improve earning opportunities.',

                'salary_international' => 'International salary varies by country and experience. In the United States, software QA analysts and testers had a median annual wage of about $102,610 in May 2024.',

                'industries' => [
                    'Software Development',
                    'IT Services',
                    'Banking',
                    'E-commerce',
                ],

                'career_roles' => [
                    'Software Tester',
                    'QA Engineer',
                    'Automation Test Engineer',
                    'Software Quality Analyst',
                ],
            ],

            // Data Science
            'data-science' => [
                'skills' => [
                    'Statistics',
                    'Mathematics',
                    'Python Programming',
                    'Data Analysis',
                    'Problem Solving',
                ],

                'prerequisites' => [
                    'Basic Mathematics',
                    'Basic Statistics',
                    'Interest in Data Analysis',
                ],

                'courses' => [
                    'Python Programming',
                    'Statistics',
                    'Data Analysis',
                    'Machine Learning Fundamentals',
                ],

                'roadmap' => [
                    'Learn mathematics and statistics.',
                    'Learn Python programming.',
                    'Study data analysis.',
                    'Practice data visualization.',
                    'Learn machine learning fundamentals.',
                ],

                'job_market' => 'Data Science professionals work in technology, finance, healthcare, research, and business analytics in Bangladesh and internationally.',

                'salary_bd' => 'Indicative entry-level salary: BDT 30,000–60,000 per month. Salary depends on analytical skills, experience and employer.',

                'salary_international' => 'International salary varies by country and experience. In the United States, Data Scientists had a median annual wage of about $112,590 in May 2024.',

                'industries' => [
                    'Banking and Finance',
                    'Healthcare',
                    'E-commerce',
                    'Technology and Research',
                ],

                'career_roles' => [
                    'Data Scientist',
                    'Data Analyst',
                    'Machine Learning Engineer',
                    'Business Intelligence Analyst',
                ],
            ],
        ];

        $details = $data[$slug];

        return view('majors.show', compact('major', 'details'));
    }
}
