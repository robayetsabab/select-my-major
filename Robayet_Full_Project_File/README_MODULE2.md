# Module 2 — Robayet

Features delivered in this branch:
- Feature 7: Career Stories catalogue, keyword search, major/country/skill filters, pagination, professional profile, career journey timeline, skills, achievements and reference links.
- Feature 10: eight-question Major Recommendation Quiz, previous/next navigation, required answers, server-side scoring, result display and database persistence.
- JSON endpoints: GET /api/module2/career-stories and GET /api/module2/majors.
- Quiz endpoints: POST /major-quiz/submit and GET /major-quiz/history.

## Setup
Run from temp-laravel:
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    php artisan db:seed --class=Module2CareerStorySeeder
    php artisan serve

Open /career-stories and /major-quiz.
Quiz results are stored in quiz_attempts and associated with a logged-in user when available, otherwise with the Laravel session. The starter career catalogue has eight profiles with reference links; profile photo URLs are optional and initials appear when no verified portrait is configured. Expand biographies and profile images only after checking reliable references.