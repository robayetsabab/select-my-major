<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Major;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        // NOTE: prices are approximate. Re-check the official source before final submission.
        // Order: name, provider, type, level, price_usd, price_note, has_free_option, url, description
        $data = [
            'cyber-security' => [
                ['CompTIA Security+', 'CompTIA', 'certification', 'Beginner-Intermediate', 404, 'Approx. exam voucher price', false, 'https://www.comptia.org/certifications/security', 'Popular entry-level security certification covering core security concepts.'],
                ['Certified in Cybersecurity (CC)', 'ISC2', 'certification', 'Beginner', 0, 'Free training and exam through ISC2 programme (check availability)', true, 'https://www.isc2.org/certifications/cc', 'Entry-level certification from ISC2 for students and career starters.'],
                ['Google Cybersecurity Certificate', 'Coursera / Google', 'certification', 'Beginner', null, 'Coursera subscription; financial aid available', true, 'https://www.coursera.org/professional-certificates/google-cybersecurity', 'Beginner-friendly course series with hands-on labs.'],
                ['Certified Ethical Hacker (CEH)', 'EC-Council', 'certification', 'Intermediate', 1199, 'Approx. exam fee; training cost extra', false, 'https://www.eccouncil.org', 'Well-known ethical hacking certification.'],
                ['TryHackMe Labs', 'TryHackMe', 'resource', 'Beginner', 0, 'Free rooms available; premium optional', true, 'https://tryhackme.com', 'Practice security skills in guided labs.'],
            ],
            'robotics' => [
                ['ROS Documentation & Tutorials', 'Open Robotics', 'resource', 'Beginner-Intermediate', 0, 'Free', true, 'https://docs.ros.org', 'Official docs for Robot Operating System.'],
                ['Modern Robotics Specialization', 'Coursera / Northwestern', 'certification', 'Intermediate', null, 'Coursera subscription; audit option available', true, 'https://www.coursera.org/specializations/modernrobotics', 'Covers kinematics, dynamics, planning and control.'],
                ['Arduino Education Resources', 'Arduino', 'resource', 'Beginner', 0, 'Free', true, 'https://www.arduino.cc/education', 'Beginner embedded and electronics learning material.'],
            ],
            'software-testing' => [
                ['ISTQB Certified Tester Foundation Level (CTFL)', 'ISTQB', 'certification', 'Beginner', 229, 'Approx. exam fee; varies by country/board', false, 'https://www.istqb.org', 'Globally recognised foundation-level testing certification.'],
                ['Test Automation University', 'Applitools', 'resource', 'Beginner-Intermediate', 0, 'Free', true, 'https://testautomationu.applitools.com', 'Free courses on Selenium, Cypress, API testing and more.'],
                ['Postman API Fundamentals Student Expert', 'Postman', 'certification', 'Beginner', 0, 'Free', true, 'https://academy.postman.com', 'Free API testing training and badge.'],
            ],
            'data-science' => [
                ['Google Data Analytics Certificate', 'Coursera / Google', 'certification', 'Beginner', null, 'Coursera subscription; financial aid available', true, 'https://www.coursera.org/professional-certificates/google-data-analytics', 'Beginner course series on data analysis, SQL, R and Tableau.'],
                ['IBM Data Science Professional Certificate', 'Coursera / IBM', 'certification', 'Beginner-Intermediate', null, 'Coursera subscription; financial aid available', true, 'https://www.coursera.org/professional-certificates/ibm-data-science', 'Python, SQL, data visualization and machine learning basics.'],
                ['Azure Data Scientist Associate (DP-100)', 'Microsoft', 'certification', 'Intermediate', 165, 'Approx. exam fee; varies by country', false, 'https://learn.microsoft.com/credentials/certifications/azure-data-scientist/', 'Role-based certification for ML on Azure.'],
                ['Kaggle Learn', 'Kaggle', 'resource', 'Beginner', 0, 'Free', true, 'https://www.kaggle.com/learn', 'Short free courses on Python, pandas, ML and more.'],
            ],
        ];

        foreach ($data as $slug => $items) {
            $major = Major::where('slug', $slug)->firstOrFail();
            foreach ($items as [$name, $provider, $type, $level, $price, $note, $free, $url, $desc]) {
                Certification::updateOrCreate(
                    ['major_id' => $major->id, 'name' => $name],
                    [
                        'provider' => $provider, 'type' => $type, 'level' => $level,
                        'price_usd' => $price, 'price_note' => $note, 'has_free_option' => $free,
                        'source_url' => $url, 'description' => $desc,
                    ]
                );
            }
        }
    }
}
