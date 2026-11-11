# Module 1 - Robayet Sabab (Features #1 and #4)

Feature 1: Major Overview & Selection  (/majors, /majors/{slug})
Feature 4: Certifications & Learning Resources  (/certifications and a section on each major page)

## Setup (Laravel 10/11 project)
1. composer create-project laravel/laravel select-my-major
2. Copy app/, database/, resources/, routes/ from this folder into the project
   (merge; overwrite routes/web.php and database/seeders/DatabaseSeeder.php)
3. Set MySQL details in .env, then run:
   php artisan migrate --seed
   php artisan serve
4. Open http://127.0.0.1:8000


