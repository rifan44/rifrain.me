# rifrain.me

Interactive Laravel portfolio presented as a small 2D platformer. The CMS stores skills, projects, experiences, and `about`/`contact` content in SQLite or another Laravel-supported database. The public page sends eager-loaded data to Blade with `@json`, while Kaboom.js only handles the canvas game; Bootstrap modals remain outside the canvas for accessibility and responsive content.

## Setup (Laragon)

1. Install PHP 8.2+, Composer, and a database supported by Laravel.
2. Put the repository under Laragon's `www` directory and set the site's document root to this repository's `public` directory. The local URL can then be `http://rifrain-me.test` (or use `http://localhost` with Laragon's document root configured accordingly).
3. Copy `.env.example` to `.env`, run `php artisan key:generate`, and keep the default SQLite configuration or replace `DB_*` with your MySQL settings. For Laragon MySQL, first create an empty database named `rifrain` in HeidiSQL/phpMyAdmin, then set `DB_CONNECTION=mysql` and `DB_DATABASE=rifrain` (the default Laragon username is usually `root` with an empty password).
4. Run `composer install`, `php artisan migrate --seed` (note the `--seed` option; `php artisan migrate seed` is not a valid command), and `php artisan storage:link`. For a quick standalone smoke test, `php artisan serve --host=127.0.0.1 --port=8000` serves the same `public` entry point at `http://127.0.0.1:8000`.
5. CMS write endpoints are under `/admin/skills`, `/admin/projects`, and `/admin/experiences`. Add the application's authentication middleware before exposing these routes publicly.

Sprite URLs are deliberately remote and minimal for the scaffold. For production, download approved sprite assets into `public/assets` and update the `loadSprite` URLs to avoid third-party availability and privacy concerns.
