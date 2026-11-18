# Robayet Sabab — Module 2
## SELECT MY MAJOR — Know Before You Choose

This folder contains the Module 2 source files developed by Robayet Sabab.

### Features
- Career Stories catalogue and individual career profiles
- Career story search/filter and API endpoints
- Major Recommendation Quiz (8 questions)
- Quiz attempt storage
- Module 2 migration and career story seeder

### File map
- `app/Http/Controllers/Module2/` — Module 2 controllers
- `app/Models/` — CareerStory and QuizAttempt models
- `database/migrations/` — Module 2 database tables
- `database/seeders/` — Career story sample data
- `public/css/module2.css` — Module 2 styling
- `public/js/module2-quiz.js` — Quiz interaction
- `resources/views/module2/` — Career Stories and Quiz pages
- `routes/module2/robayet.php` — Module 2 routes

### Integrated Laravel application
The runnable integrated Laravel project remains in `temp-laravel/`. This folder is a clearly separated, review-friendly copy of Robayet's Module 2-specific source files. Module 1 and other members' folders are not moved or deleted.

### Local setup
Open `temp-laravel/` as the Laravel application, then run:
```bash
php artisan migrate
php artisan db:seed
php artisan serve
```
