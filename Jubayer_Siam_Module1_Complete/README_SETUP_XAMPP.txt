SELECT MY MAJOR — JUBAYER SIAM'S MODULE 1 FEATURES
SE331 · Lab Section B2 · Group 05 · Fall 2026

SCOPE
This package extends the existing group Module 1 code for the two features assigned to
Jubayer Hasan Siam in the project proposal:
  1. Subfields & Details
  2. Career Opportunities & Career Path

The four majors are Cyber Security, Robotics, Software Testing and Data Science.
The package contains 16 detailed subfields (4 per major) and 20 career profiles (5 per major).
It preserves the existing Major and Certification pages/data from the supplied source project.

============================================================
1. SOFTWARE REQUIREMENTS
============================================================
- Windows 10/11
- XAMPP with PHP 8.3 or newer (PHP 8.4 recommended for Laravel 13)
- Composer 2.x
- Visual Studio Code
- MySQL / MariaDB from XAMPP
- Postman (for API testing)
- Internet connection for Bootstrap, Bootstrap Icons, remote images and YouTube embeds

Check versions in Command Prompt or VS Code terminal:
  php -v
  composer --version
  mysql --version

Laravel 13 requires PHP 8.3+. If your installed PHP is older, update XAMPP/PHP before
creating the Laravel 13 project. The application files use standard Laravel Eloquent,
Blade and routing features.

============================================================
2. CREATE A FRESH LARAVEL PROJECT
============================================================
A. Open XAMPP Control Panel and start MySQL. Apache is optional when you use `php artisan serve`.
   Apache is only needed if you plan to serve the project through XAMPP's Apache server.

B. Open Command Prompt / PowerShell:
  cd C:\xampp\htdocs
  composer create-project laravel/laravel select-my-major "^13.0"
  cd select-my-major

C. Enable the API route file and install Laravel Sanctum scaffolding:
  php artisan install:api

This creates routes/api.php and configures API routing in the Laravel application.
The feature's public GET endpoints do not require login. Sanctum is not used to protect
these read-only exploration endpoints.

D. Open the project folder in VS Code:
  code .

============================================================
3. CREATE THE MYSQL DATABASE
============================================================
A. Open http://localhost/phpmyadmin
B. Choose New and create:
     Database name: select_my_major
     Collation:     utf8mb4_unicode_ci
C. In the Laravel project's .env file, set:

  APP_NAME="Select My Major"
  APP_ENV=local
  APP_DEBUG=true
  APP_URL=http://127.0.0.1:8000

  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=select_my_major
  DB_USERNAME=root
  DB_PASSWORD=

The default XAMPP MySQL root account often has an empty password on a local installation.
If you configured a password, put that password in DB_PASSWORD.

============================================================
4. COPY THIS PACKAGE INTO THE LARAVEL PROJECT
============================================================
Extract this ZIP. Copy these folders/files from the extracted package into:
  C:\xampp\htdocs\select-my-major\

Copy/merge:
  app\
  database\
  resources\
  routes\
  public\

When Windows asks, merge folders and replace files. This package includes the original
Module 1 files plus Jubayer's extended code. Keep the fresh Laravel project files that are
not included here, especially:
  .env, artisan, bootstrap\app.php, composer.json, composer.lock, config\, storage\, vendor\

IMPORTANT: `routes/api.php` is included in this package. If you copied it before running
`php artisan install:api`, make sure the API routing setup exists in bootstrap/app.php.
Running `php artisan install:api` before copying this package is recommended.

============================================================
5. RUN MIGRATIONS AND SEED THE DATABASE
============================================================
In VS Code terminal:
  cd C:\xampp\htdocs\select-my-major
  php artisan key:generate
  php artisan optimize:clear
  php artisan migrate:fresh --seed

WARNING: `migrate:fresh` DROPS ALL TABLES in the configured database before rebuilding them.
Use it only with the new/empty `select_my_major` database. Do not run it on a database that
contains your other group members' work or real student data. Back up a shared database first.

The DatabaseSeeder runs:
  - Module1Seeder: seeds the four majors and the existing group certification content.
  - JubayerFeatureSeeder: adds detailed subfield and career-path information while preserving
    the major and certification records seeded immediately before it.

============================================================
6. START THE WEBSITE
============================================================
  php artisan serve

Open:
  Home:       http://127.0.0.1:8000
  Subfields:  http://127.0.0.1:8000/subfields
  Careers:    http://127.0.0.1:8000/careers

The dark-mode control is in the top navigation. Search and filters update results through
the Laravel API. Subfield cards include a quick-preview modal and a separate full-details page.
Career pages include level-based career paths, expandable duties, role comparison (maximum
three roles), path highlighting and related YouTube videos.

============================================================
7. REST API ENDPOINTS
============================================================
All endpoints use GET and return JSON. Base URL for local development:
  http://127.0.0.1:8000/api/v1

  GET /majors
      Returns the four major records and counts of subfields/careers.

  GET /subfields
      Returns all subfields (paginated; per_page defaults to 100).

  GET /subfields?q=network
      Keyword search across subfield names, summaries, details, focus and example text.

  GET /subfields?major=cyber-security
      Filters by major slug.

  GET /subfields?difficulty=Intermediate
      Filters by difficulty label.

  GET /subfields?tool=Wireshark
      Filters by tool name.

  GET /subfields/network-security
      Returns one subfield with its related major.

  GET /careers
      Returns career roles (paginated; per_page defaults to 100).

  GET /careers?major=data-science&level=Mid
      Filters careers by major and level.

  GET /careers?industry=Banking%20and%20fintech
      Filters by industry.

  GET /careers/data-scientist
      Returns one career profile.

  GET /search?q=robot
      Returns combined subfield and career search results.

Examples to paste into a browser:
  http://127.0.0.1:8000/api/v1/majors
  http://127.0.0.1:8000/api/v1/subfields?major=robotics
  http://127.0.0.1:8000/api/v1/careers?level=Entry
  http://127.0.0.1:8000/api/v1/search?q=automation

============================================================
8. TEST THE API WITH POSTMAN
============================================================
A. Open Postman.
B. Select Import > Files.
C. Import:
  postman\Select_My_Major_Module1_Jubayer.postman_collection.json
D. Open the collection variable `base_url`. It is already set to:
  http://127.0.0.1:8000
E. Run individual requests or run the collection after `php artisan serve` is running.

Expected status: HTTP 200 for all GET requests when the database has been seeded.
The collection includes major list, subfield filters/detail, career filters/detail and
combined search requests.

============================================================
9. DATABASE STRUCTURE / WHAT EACH FEATURE STORES
============================================================
majors (existing table + image_url, video_url)
  - Major title, slug, summary and visual learning resources.

subfields (existing table + new columns)
  - major_id, name, slug, summary, details, tools, sort_order
  - main_focus, typical_tasks (JSON), applications (JSON), technologies (JSON)
  - real_world_example, difficulty, image_url, youtube_url, related_slugs (JSON)

careers (existing table + new columns)
  - major_id, title, slug, level, description, opportunities, sort_order
  - summary, responsibilities (JSON), skills (JSON), industries (JSON)
  - previous_roles (JSON), next_roles (JSON), related_roles (JSON)
  - experience_range, image_url, youtube_url

Laravel classes:
  Models:      Major, Subfield, Career
  Controllers: SubfieldController, CareerController, Api\ExploreApiController
  Migrations:  000005, 000006, 000007 add the extra feature fields
  Seeders:     Module1Seeder, JubayerFeatureSeeder
  Web routes:  routes/module1/jubayer.php (loaded automatically by routes/web.php)
  API routes:  routes/api.php
  Views:       resources/views/subfields/*, resources/views/careers/*
  JavaScript:  public/js/subfields.js, public/js/careers.js
  Styles:      public/css/smm.css

============================================================
10. TROUBLESHOOTING
============================================================
Problem: `php` is not recognized
Fix: Add `C:\xampp\php` to the Windows PATH, close and reopen the terminal, then run php -v.

Problem: Composer reports a PHP version/platform error
Fix: Make sure Command Prompt is using XAMPP's PHP (where php; php -v). Laravel 13 requires
PHP 8.3 or newer. Do not rely on another older PHP installation earlier in PATH.

Problem: `could not find driver` / PDO MySQL missing
Fix: Open `C:\xampp\php\php.ini`, enable `extension=pdo_mysql` and `extension=mysqli`
(remove the leading semicolon if present), save and restart the terminal / Apache.

Problem: MySQL connection refused
Fix: Start MySQL in XAMPP; confirm port 3306; verify DB_DATABASE, DB_USERNAME and DB_PASSWORD.

Problem: `Route [api...]` is missing or API returns 404
Fix: Run `php artisan install:api`, verify `routes/api.php` exists, then run
`php artisan optimize:clear` and `php artisan route:list --path=api`.

Problem: no content / empty pages
Fix: Check that the database is `select_my_major`, then run `php artisan migrate:status`.
For a brand-new project database, run `php artisan migrate:fresh --seed`.

Problem: remote images, Bootstrap or video do not load
Fix: Check your internet connection. The image/video URLs are external resources, not bundled
files. You can replace the image_url and video_url values in JubayerFeatureSeeder.

============================================================
11. BEFORE MERGING WITH THE GROUP PROJECT
============================================================
- Keep the group's shared Major, Certification and existing feature routes/controllers.
- Merge migrations and model fields carefully; do not overwrite another member's work blindly.
- Keep JubayerFeatureSeeder after Module1Seeder in DatabaseSeeder for local demo data.
- Coordinate one final DatabaseSeeder and route file with the group before submission.
- Do not use `migrate:fresh` on a shared database.
- Update seed data and videos with verified sources before public deployment.

END OF GUIDE
