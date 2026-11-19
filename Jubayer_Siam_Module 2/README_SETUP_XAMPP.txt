SELECT MY MAJOR — JUBAYER SIAM (Module 1 fixes + Module 2 features)
SE331 · Lab B2 · Group 05 · Fall 2026

YOUR FEATURES IN THIS PACKAGE
  Module 1  #2  Subfields & Details                 (fixed)
  Module 1  #5  Career Opportunities & Career Path  (fixed)
  Module 2  #8  Senior Students' Experiences        (new)
  Module 2  #11 Recommendation System               (new)
Also included so the site runs on its own (teammates' features, simple versions):
  majors pages, certifications page, login/register/logout, 12-question quiz page.
  Replace these with the group versions when you merge.

NOT INCLUDED: Module 2 #9, #10 (full), #12 and Module 3 #13-#15 belong to Robayet / Washim.
  Your Module 3 #14 (Student Profile & Dashboard) is not built here; "My results" (/my/recommendations)
  is the only part of it that exists so far.

IMPORTANT: this package was written without being able to run PHP in the build environment.
It has not been executed. Run the checks in section 6 and tell me about any error message.

==============================================================
1. REQUIREMENTS
==============================================================
Windows + XAMPP (PHP 8.3+; 8.4 recommended for Laravel 13), Composer 2, MySQL from XAMPP, VS Code, Postman.
Internet is needed for Bootstrap, Chart.js, images and YouTube embeds (CDN / external).

==============================================================
2. CREATE A FRESH LARAVEL PROJECT
==============================================================
  cd C:\xampp\htdocs
  composer create-project laravel/laravel select-my-major "^13.0"
  cd select-my-major
(You no longer need `php artisan install:api`: this package ships its own bootstrap\app.php with API routing.)

==============================================================
3. DATABASE
==============================================================
phpMyAdmin -> create database  select_my_major  (utf8mb4_unicode_ci). In .env:
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=select_my_major
  DB_USERNAME=root
  DB_PASSWORD=
(also fine to keep SESSION_DRIVER=database, the default migration creates the sessions table)

==============================================================
4. COPY THIS PACKAGE
==============================================================
Copy / merge these into the Laravel project, replacing files when asked:
  app\  bootstrap\  database\  public\  resources\  routes\  tests\
Keep your own: .env, artisan, composer.json, config\, storage\, vendor\.
(This replaces app\Models\User.php with a version that has the quiz and vote relations.)

==============================================================
5. BUILD THE DATABASE AND RUN
==============================================================
  php artisan key:generate
  php artisan optimize:clear
  php artisan migrate:fresh --seed
  php artisan serve
WARNING: migrate:fresh drops ALL tables of the configured database. Use only the empty select_my_major database.

Open http://127.0.0.1:8000
Demo login: student@example.com / password  (has two saved recommendations)

Seeded data: 4 majors · 16 subfields · 20 career roles · 15+ certifications · 28 senior stories ·
12 quiz questions (48 weighted options) · 1 demo student with 2 results.
(The 28 senior stories are SAMPLE content for the project, not real people.)

==============================================================
6. CHECKS TO RUN
==============================================================
  php artisan route:list            -> look for experiences.*, quiz.*, recommendation.*, api.v1.*
  php artisan test --filter=JubayerFeaturesTest
  Postman: import postman\Select_My_Major_Module1_Jubayer.postman_collection.json and run it.

Manual click-through:
  /subfields  (search, filter, preview eye icon, details page)
  /careers    (filters, path board, compare up to 3 roles, role detail page)
  /experiences (search, major/status/sort filters, open a story, "helpful" needs login)
  /quiz -> log in -> answer 12 questions -> result page -> /my/recommendations

==============================================================
7. PAGES AND API
==============================================================
Web:  /  /majors  /majors/{slug}  /certifications  /subfields  /subfields/{slug}  /careers  /careers/{slug}
      /experiences  /experiences/{id}  POST /experiences/{id}/helpful (login)
      /quiz (login)  /recommendation/{id} (login, owner only)  /my/recommendations (login)
      /register  /login  POST /logout
API (GET, JSON), base http://127.0.0.1:8000/api/v1
      /majors  /subfields[?q&major&difficulty&tool&per_page]  /subfields/{slug}
      /careers[?q&major&level&industry&per_page]  /careers/{slug}  /search?q=
      /experiences[?q&major&status=current|completed&sort=latest|helpful|rating&per_page]  /experiences/{id}

==============================================================
8. HOW THE RECOMMENDATION WORKS (Feature 11)
==============================================================
Rule-based weighted scoring, not machine learning.
 1. Every quiz option has a weight 0-3 for each of the four majors (table quiz_options.scores).
 2. The chosen option of each question adds its weights to the four totals.
 3. Each total is divided by the highest total that major could reach -> match percentage.
 4. Ranking = raw score, then number of "strong" (weight 3) answers, then major order.
 5. If the top two are equal on both, the result is shown as a tie.
 6. Confidence: gap to runner-up >= 15 points "Strong match", >= 7 "Good match", else "Close call".
 7. The "Why this result?" box lists the answers that gave the winning major the most points.
Code: app\Services\RecommendationService.php   Weights: database\seeders\QuizSeeder.php
Percentages are not meant to add up to 100.

==============================================================
9. WHAT WAS FIXED IN MODULE 1
==============================================================
 - Career detail page crashed (404/500) when a linked role slug was missing; it now loads linked roles once and skips missing ones.
 - Navigation and home page linked to Majors/Certifications routes that did not exist, so links were hidden or broken: pages added.
 - Home/major card styles (hero, major-card, btn-accent) were missing from smm.css: added. Dark-mode stat box fixed.
 - API needed `php artisan install:api` before copying files (easy to get wrong): bootstrap\app.php now included.
 - Search/filter logic was duplicated in controller and API with small differences (web search ignored tools): now one scopeFilter() per model.
 - LIKE wildcards (% and _) typed by users are escaped.
 - "16 subfields" was hard-coded; now counted from the database.
 - Career comparison table showed raw slugs in "Progression"; now shows role titles.
 - Subfield and career pages now link to senior stories; footer no longer says "Module 1" only.

KNOWN LIMITS
 - YouTube video IDs and Unsplash photo URLs in JubayerFeatureSeeder could not be checked from here. If a video or image is
   blank, replace the URL in that seeder (the video IDs are the first thing to verify before the demo).
 - Salary, job market data and certification prices are not part of your features; certification prices in Module1Seeder
   are approximate and should be re-checked.
 - Migrate fresh before presenting; running only `db:seed` on an existing database can leave old quiz results pointing to old ids.
