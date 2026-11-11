<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Certification;
use App\Models\Major;
use App\Models\Subfield;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class Module1Seeder extends Seeder
{
    public function run(): void
    {
        // Clear old Module 1 data first, so running the seeder many times never creates duplicates.
        Schema::disableForeignKeyConstraints();
        Career::truncate();
        Certification::truncate();
        Subfield::truncate();
        Major::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            [
                'name' => 'Cyber Security',
                'slug' => 'cyber-security',
                'tagline' => 'Protect systems, data and people from digital threats.',
                'overview' => 'Cyber Security is about keeping software, networks and data safe from attackers. You learn how systems break, how to find weak spots before someone else does, and how to respond when something goes wrong. It mixes networking, operating systems, programming and a good amount of investigative thinking.',
                'reasons' => [
                    'Banks, telecom operators, government bodies and software firms in Bangladesh are hiring security staff as more services move online.',
                    'Demand is global, so remote and overseas roles are realistic once you have solid skills.',
                    'The work is varied: one week you might test a web application, the next you might investigate an incident.',
                    'You can begin with free labs and practice platforms and build a portfolio without expensive equipment.',
                ],
                'best_for' => 'Curious problem solvers who enjoy networks, puzzles and thinking like an attacker.',
                'accent' => '#0f766e',
                'subfields' => [
                    ['name' => 'Network Security', 'slug' => 'network-security',
                     'summary' => 'Defending the traffic and devices that connect an organization.',
                     'details' => 'You work with firewalls, intrusion detection systems, VPNs and network segmentation. The goal is to control who can talk to what, and to spot unusual traffic early. A strong grasp of TCP/IP, routing and common protocols is the base of this area.',
                     'tools' => 'Wireshark, pfSense, Snort, Nmap'],
                    ['name' => 'Ethical Hacking and Penetration Testing', 'slug' => 'penetration-testing',
                     'summary' => 'Legally breaking into systems to find weaknesses first.',
                     'details' => 'Penetration testers simulate real attacks against web applications, networks and servers, then write clear reports on what they found and how to fix it. The work needs patience, scripting skills and strong documentation habits.',
                     'tools' => 'Kali Linux, Burp Suite, Metasploit, OWASP ZAP'],
                    ['name' => 'Digital Forensics and Incident Response', 'slug' => 'digital-forensics',
                     'summary' => 'Investigating what happened after a breach.',
                     'details' => 'Forensic analysts collect and preserve evidence from disks, memory and logs, then rebuild a timeline of the attack. Incident responders contain the damage and help systems recover. Careful, repeatable procedure matters here because evidence may be used in court.',
                     'tools' => 'Autopsy, Volatility, FTK Imager, Splunk'],
                    ['name' => 'Cryptography and Application Security', 'slug' => 'cryptography-appsec',
                     'summary' => 'Protecting data with encryption and building software that resists attacks.',
                     'details' => 'This area covers encryption, hashing, digital signatures and secure coding practice. Application security engineers review code, fix common flaws such as injection and broken authentication, and help teams build security into development from the start.',
                     'tools' => 'OpenSSL, SonarQube, OWASP guides, Git'],
                ],
                'certifications' => [
                    ['name' => 'CompTIA Security+', 'provider' => 'CompTIA', 'level' => 'Beginner to Intermediate',
                     'price' => 'About USD 400 for the exam voucher', 'is_free' => true,
                     'free_option' => 'Free video training and practice material are available from community educators such as Professor Messer.',
                     'official_url' => 'https://www.comptia.org/certifications/security'],
                    ['name' => 'ISC2 Certified in Cybersecurity (CC)', 'provider' => 'ISC2', 'level' => 'Entry',
                     'price' => 'Free training; check the official page for the current exam fee', 'is_free' => true,
                     'free_option' => 'ISC2 offers free online self-paced training for candidates of this entry-level certification.',
                     'official_url' => 'https://www.isc2.org/certifications/cc'],
                    ['name' => 'Google Cybersecurity Certificate', 'provider' => 'Google on Coursera', 'level' => 'Beginner',
                     'price' => 'Coursera subscription, about USD 49 per month', 'is_free' => true,
                     'free_option' => 'You can audit the courses for free or apply for Coursera financial aid.',
                     'official_url' => 'https://www.coursera.org/professional-certificates/google-cybersecurity'],
                    ['name' => 'Certified Ethical Hacker (CEH)', 'provider' => 'EC-Council', 'level' => 'Intermediate',
                     'price' => 'Roughly USD 1,000 or more including training', 'is_free' => false,
                     'free_option' => null,
                     'official_url' => 'https://www.eccouncil.org/train-certify/certified-ethical-hacker-ceh/'],
                ],
                'careers' => [
                    ['title' => 'SOC Analyst', 'level' => 'Entry',
                     'description' => 'Watches security alerts, investigates suspicious activity and escalates real incidents to senior staff.',
                     'opportunities' => 'Banks and fintech firms, telecom operators, managed security service providers, large IT companies.'],
                    ['title' => 'Junior Security Tester', 'level' => 'Entry',
                     'description' => 'Assists with vulnerability scans and basic web application testing under a senior tester.',
                     'opportunities' => 'Software companies, cyber security consultancies, bug bounty programs.'],
                    ['title' => 'Penetration Tester', 'level' => 'Mid',
                     'description' => 'Plans and carries out authorized attacks on applications and networks, then reports findings with fixes.',
                     'opportunities' => 'Security consultancies, banks, government agencies, remote contracts with international firms.'],
                    ['title' => 'Security Engineer', 'level' => 'Mid',
                     'description' => 'Designs and maintains firewalls, monitoring and access controls, and automates security checks.',
                     'opportunities' => 'Cloud and hosting companies, enterprise IT teams, product companies.'],
                    ['title' => 'Security Architect or Incident Response Lead', 'level' => 'Senior',
                     'description' => 'Sets the security design for whole systems, or leads the team during serious breaches.',
                     'opportunities' => 'Large enterprises, financial institutions, government bodies.'],
                ],
            ],
            [
                'name' => 'Robotics',
                'slug' => 'robotics',
                'tagline' => 'Build machines that sense, think and move.',
                'overview' => 'Robotics brings together mechanical design, electronics and software so machines can sense their surroundings and act on them. You learn how sensors, motors and controllers work together, and how to program robots that do useful jobs, from factory arms to drones and warehouse vehicles.',
                'reasons' => [
                    'It is one of the most hands-on majors, so you see your code move something in the real world.',
                    'Automation is growing in manufacturing, agriculture, logistics and healthcare, which creates steady demand for people who understand both hardware and software.',
                    'The skills carry over to embedded systems, IoT and artificial intelligence.',
                    'Student competitions and open source projects give you plenty of practice even without a big budget.',
                ],
                'best_for' => 'Builders who like electronics, mechanics and turning ideas into working prototypes.',
                'accent' => '#7c3aed',
                'subfields' => [
                    ['name' => 'Embedded Systems and Control', 'slug' => 'embedded-systems',
                     'summary' => 'Programming the small computers that run motors and sensors.',
                     'details' => 'You write firmware for microcontrollers, read sensor data, drive motors and design feedback loops such as PID control. Understanding timing, power limits and basic circuits is key.',
                     'tools' => 'Arduino, ESP32, STM32, C and C++'],
                    ['name' => 'Computer Vision and Perception', 'slug' => 'computer-vision',
                     'summary' => 'Helping robots understand what they see.',
                     'details' => 'Cameras and depth sensors give a robot its view of the world. This area covers image processing, object detection and sensor fusion so a robot can recognize objects and avoid obstacles.',
                     'tools' => 'OpenCV, Python, YOLO models, LiDAR basics'],
                    ['name' => 'Robot Navigation and ROS', 'slug' => 'ros-navigation',
                     'summary' => 'Planning paths and coordinating robot software.',
                     'details' => 'Navigation covers mapping, localization and path planning. Most research and industry teams use ROS to connect sensors, planners and controllers, so learning it early is a big advantage.',
                     'tools' => 'ROS 2, Gazebo, RViz, Python and C++'],
                    ['name' => 'Mechanical Design and Automation', 'slug' => 'mechanical-design',
                     'summary' => 'Designing the body of the robot and the systems around it.',
                     'details' => 'Here you choose actuators, build frames and joints, and think about how a robot fits into a production line. Basic CAD skills and an understanding of kinematics help you build machines that are accurate and reliable.',
                     'tools' => 'SolidWorks, Fusion 360, 3D printing, PLC basics'],
                ],
                'certifications' => [
                    ['name' => 'Modern Robotics Specialization', 'provider' => 'Northwestern University on Coursera', 'level' => 'Intermediate',
                     'price' => 'Coursera subscription, about USD 49 per month', 'is_free' => true,
                     'free_option' => 'You can audit the courses for free or apply for Coursera financial aid.',
                     'official_url' => 'https://www.coursera.org/specializations/modernrobotics'],
                    ['name' => 'ROS 2 Documentation and Tutorials', 'provider' => 'Open Robotics', 'level' => 'Beginner',
                     'price' => 'Free', 'is_free' => true,
                     'free_option' => 'All official tutorials can be followed at no cost.',
                     'official_url' => 'https://docs.ros.org/'],
                    ['name' => 'Arduino Education Resources', 'provider' => 'Arduino', 'level' => 'Beginner',
                     'price' => 'Learning material is free; hardware kits cost extra', 'is_free' => true,
                     'free_option' => 'Free project guides and lessons are published on the official site.',
                     'official_url' => 'https://www.arduino.cc/education/'],
                    ['name' => 'NVIDIA Deep Learning Institute Courses', 'provider' => 'NVIDIA', 'level' => 'Intermediate',
                     'price' => 'Some self-paced courses are free; instructor-led workshops are paid', 'is_free' => true,
                     'free_option' => 'Look for the self-paced courses marked as free on the official catalog.',
                     'official_url' => 'https://www.nvidia.com/en-us/training/'],
                ],
                'careers' => [
                    ['title' => 'Robotics Technician', 'level' => 'Entry',
                     'description' => 'Assembles, tests and maintains robots and automation equipment on the factory floor.',
                     'opportunities' => 'Manufacturing plants, garment factories adopting automation, electronics assembly firms.'],
                    ['title' => 'Embedded Systems Developer', 'level' => 'Entry',
                     'description' => 'Writes firmware and tests circuits for robots, drones and smart devices.',
                     'opportunities' => 'IoT startups, electronics companies, research labs, hardware product firms.'],
                    ['title' => 'Robotics Software Engineer', 'level' => 'Mid',
                     'description' => 'Builds navigation, control and perception software, often using ROS.',
                     'opportunities' => 'Robotics startups, warehouse automation companies, research institutes, remote work for international teams.'],
                    ['title' => 'Automation Engineer', 'level' => 'Mid',
                     'description' => 'Designs automated production lines using PLCs, sensors and robot arms.',
                     'opportunities' => 'Factories, pharmaceutical plants, food processing and packaging companies.'],
                    ['title' => 'Robotics Systems Architect or Research Lead', 'level' => 'Senior',
                     'description' => 'Defines the overall design of robotic products or leads research teams working on new capabilities.',
                     'opportunities' => 'Universities, advanced manufacturing companies, aerospace-related organizations, international R&D teams.'],
                ],
            ],
            [
                'name' => 'Software Testing',
                'slug' => 'software-testing',
                'tagline' => 'Make sure software works before real users depend on it.',
                'overview' => 'Software Testing is about checking that applications do what they promise and finding problems early, when they are cheap to fix. You learn to plan tests, write test cases, automate repetitive checks and report bugs clearly so developers can act on them.',
                'reasons' => [
                    'Every software company needs testers, and it is a practical way to enter the IT industry.',
                    'You see the whole product, so you learn how requirements, design and code fit together.',
                    'Automation skills open doors to higher paying roles such as SDET and quality engineer.',
                    'You can start right away with free tools and sample applications.',
                ],
                'best_for' => 'Detail-oriented people who enjoy finding what others miss and care about quality.',
                'accent' => '#b45309',
                'subfields' => [
                    ['name' => 'Manual Testing', 'slug' => 'manual-testing',
                     'summary' => 'Checking software by hand, the way a real user would.',
                     'details' => 'You read requirements, write test cases, run them and log defects with clear steps to reproduce. Manual testing also covers exploratory testing, where you use judgement and curiosity to find problems no script would catch.',
                     'tools' => 'Jira, TestRail, Excel, browser developer tools'],
                    ['name' => 'Test Automation', 'slug' => 'test-automation',
                     'summary' => 'Writing scripts that run checks automatically.',
                     'details' => 'Automation engineers turn stable test cases into scripts that run after every code change. You need solid programming basics and an understanding of frameworks, locators and reporting.',
                     'tools' => 'Selenium, Cypress, Playwright, Java or Python'],
                    ['name' => 'API and Performance Testing', 'slug' => 'api-performance-testing',
                     'summary' => 'Testing what happens behind the screen and under heavy load.',
                     'details' => 'API testing checks requests and responses between services, while performance testing measures speed and stability when many users arrive at once. Both help catch problems that normal screen testing misses.',
                     'tools' => 'Postman, JMeter, k6, REST Assured'],
                    ['name' => 'QA Process and Test Management', 'slug' => 'qa-management',
                     'summary' => 'Planning quality across a whole project.',
                     'details' => 'This area covers test strategy, risk analysis, release criteria and working with agile teams. Test leads and QA managers decide what to test, how much is enough and how to report quality to stakeholders.',
                     'tools' => 'Jira, Confluence, Azure DevOps, ISTQB syllabus'],
                ],
                'certifications' => [
                    ['name' => 'ISTQB Certified Tester Foundation Level (CTFL)', 'provider' => 'ISTQB', 'level' => 'Beginner',
                     'price' => 'Exam fee varies by country, often around USD 200 to 250', 'is_free' => true,
                     'free_option' => 'The official syllabus, glossary and sample papers can be downloaded for free.',
                     'official_url' => 'https://www.istqb.org/certifications/certified-tester-foundation-level'],
                    ['name' => 'Selenium Documentation', 'provider' => 'Selenium Project', 'level' => 'Beginner',
                     'price' => 'Free', 'is_free' => true,
                     'free_option' => 'The full official guide is open to everyone.',
                     'official_url' => 'https://www.selenium.dev/documentation/'],
                    ['name' => 'Test Automation University', 'provider' => 'Applitools', 'level' => 'Beginner to Intermediate',
                     'price' => 'Free', 'is_free' => true,
                     'free_option' => 'Courses on many tools and languages are free to take.',
                     'official_url' => 'https://testautomationuniversity.com/'],
                    ['name' => 'Postman Learning Center', 'provider' => 'Postman', 'level' => 'Beginner',
                     'price' => 'Free learning content', 'is_free' => true,
                     'free_option' => 'Guides and tutorials for API testing are free on the official site.',
                     'official_url' => 'https://learning.postman.com/'],
                ],
                'careers' => [
                    ['title' => 'QA Tester (Manual)', 'level' => 'Entry',
                     'description' => 'Executes test cases, reports defects and verifies fixes.',
                     'opportunities' => 'Software houses, outsourcing companies, e-commerce and fintech firms.'],
                    ['title' => 'Junior Automation Tester', 'level' => 'Entry',
                     'description' => 'Maintains existing scripts and automates simple regression checks.',
                     'opportunities' => 'Software companies, mobile app teams, startups.'],
                    ['title' => 'QA Automation Engineer', 'level' => 'Mid',
                     'description' => 'Builds and maintains automation frameworks that run in the delivery pipeline.',
                     'opportunities' => 'Product companies, international outsourcing clients, remote contract roles.'],
                    ['title' => 'Performance Test Engineer', 'level' => 'Mid',
                     'description' => 'Designs load tests and analyzes system behavior under stress.',
                     'opportunities' => 'Banking and mobile finance platforms, telecom operators, large e-commerce sites.'],
                    ['title' => 'QA Lead or Test Manager', 'level' => 'Senior',
                     'description' => 'Owns the test strategy, leads the QA team and reports quality status to management.',
                     'opportunities' => 'Software companies of all sizes, multinational IT firms, consultancies.'],
                ],
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'tagline' => 'Turn raw data into decisions and predictions.',
                'overview' => 'Data Science combines statistics, programming and domain knowledge to find patterns in data and use them to make predictions. You learn to collect and clean data, explore it, build models and explain the results in a way that non-technical people can act on.',
                'reasons' => [
                    'Almost every industry now collects data, so analysts and data scientists are needed in banking, health, retail and telecom.',
                    'It pairs well with artificial intelligence and machine learning, which are growing quickly.',
                    'You can build a strong portfolio with public datasets and free tools such as Python and Jupyter.',
                    'Remote and freelance work is common, which helps if you want international experience.',
                ],
                'best_for' => 'Students who like maths, patterns and telling a clear story with numbers.',
                'accent' => '#2563eb',
                'subfields' => [
                    ['name' => 'Data Analysis and Visualization', 'slug' => 'data-analysis',
                     'summary' => 'Exploring data and presenting what it says.',
                     'details' => 'Analysts clean data, calculate summaries and build charts and dashboards that help managers decide. SQL, spreadsheets and a visualization tool are the everyday toolkit.',
                     'tools' => 'SQL, Excel, Power BI, Tableau, Python'],
                    ['name' => 'Machine Learning', 'slug' => 'machine-learning',
                     'summary' => 'Teaching computers to learn patterns from data.',
                     'details' => 'You train models for tasks such as predicting customer churn or classifying images, and then measure how well they work. A good grip on statistics, linear algebra and Python libraries is needed.',
                     'tools' => 'scikit-learn, TensorFlow, PyTorch, Jupyter'],
                    ['name' => 'Data Engineering', 'slug' => 'data-engineering',
                     'summary' => 'Building the pipelines that deliver clean data.',
                     'details' => 'Data engineers move data from many sources into databases and warehouses, keep it reliable and make it easy to query. It is closer to software engineering and suits students who enjoy building systems.',
                     'tools' => 'SQL, Apache Spark, Airflow, cloud storage'],
                    ['name' => 'Natural Language Processing and AI Applications', 'slug' => 'nlp-ai',
                     'summary' => 'Working with text, speech and language models.',
                     'details' => 'NLP covers tasks such as sentiment analysis, chatbots and document search. Bangla still has fewer ready-made resources than English, so there is real room for original work in this area.',
                     'tools' => 'Python, Hugging Face, spaCy, NLTK'],
                ],
                'certifications' => [
                    ['name' => 'Google Data Analytics Professional Certificate', 'provider' => 'Google on Coursera', 'level' => 'Beginner',
                     'price' => 'Coursera subscription, about USD 49 per month', 'is_free' => true,
                     'free_option' => 'You can audit the courses for free or apply for Coursera financial aid.',
                     'official_url' => 'https://www.coursera.org/professional-certificates/google-data-analytics'],
                    ['name' => 'IBM Data Science Professional Certificate', 'provider' => 'IBM on Coursera', 'level' => 'Beginner to Intermediate',
                     'price' => 'Coursera subscription, about USD 49 per month', 'is_free' => true,
                     'free_option' => 'You can audit the courses for free or apply for Coursera financial aid.',
                     'official_url' => 'https://www.coursera.org/professional-certificates/ibm-data-science'],
                    ['name' => 'Microsoft Certified: Power BI Data Analyst Associate (PL-300)', 'provider' => 'Microsoft', 'level' => 'Intermediate',
                     'price' => 'About USD 165, varies by country', 'is_free' => true,
                     'free_option' => 'Microsoft Learn offers free learning paths to prepare for the exam.',
                     'official_url' => 'https://learn.microsoft.com/en-us/credentials/certifications/data-analyst-associate/'],
                    ['name' => 'Kaggle Learn', 'provider' => 'Kaggle', 'level' => 'Beginner',
                     'price' => 'Free', 'is_free' => true,
                     'free_option' => 'Short hands-on courses on Python, pandas, SQL and machine learning are free.',
                     'official_url' => 'https://www.kaggle.com/learn'],
                ],
                'careers' => [
                    ['title' => 'Data Analyst', 'level' => 'Entry',
                     'description' => 'Cleans data, builds reports and dashboards and answers business questions with numbers.',
                     'opportunities' => 'Banks, telecom operators, e-commerce, garment and retail companies, NGOs.'],
                    ['title' => 'Junior Data Scientist', 'level' => 'Entry',
                     'description' => 'Supports modeling projects, prepares datasets and tests simple models under guidance.',
                     'opportunities' => 'Software and AI startups, research groups, analytics consultancies.'],
                    ['title' => 'Data Scientist', 'level' => 'Mid',
                     'description' => 'Builds predictive models and communicates the results to decision makers.',
                     'opportunities' => 'Fintech, health technology, telecom, international remote teams.'],
                    ['title' => 'Data Engineer', 'level' => 'Mid',
                     'description' => 'Designs and runs the pipelines and warehouses that keep data flowing reliably.',
                     'opportunities' => 'E-commerce platforms, mobile finance services, cloud and data consultancies.'],
                    ['title' => 'Machine Learning Lead or Head of Analytics', 'level' => 'Senior',
                     'description' => 'Guides the data strategy, leads the team and decides which problems are worth solving with models.',
                     'opportunities' => 'Large enterprises, financial institutions, technology companies, research organizations.'],
                ],
            ],
        ];

        foreach ($data as $i => $row) {
            $major = Major::create([
                'name' => $row['name'],
                'slug' => $row['slug'],
                'tagline' => $row['tagline'],
                'overview' => $row['overview'],
                'reasons' => $row['reasons'],
                'best_for' => $row['best_for'],
                'accent' => $row['accent'],
                'sort_order' => $i + 1,
            ]);

            foreach ($row['subfields'] as $j => $item) {
                $major->subfields()->create($item + ['sort_order' => $j + 1]);
            }

            foreach ($row['certifications'] as $j => $item) {
                $major->certifications()->create($item + ['sort_order' => $j + 1]);
            }

            foreach ($row['careers'] as $j => $item) {
                $major->careers()->create($item + ['sort_order' => $j + 1]);
            }
        }
    }
}
