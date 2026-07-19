# AGENTS.md — sykmmsite

## Project Overview

CodeIgniter 4 MVC web application for **SYK Services** (`https://sykmm.site`). A real estate listing and blog platform serving both a web frontend and a REST API consumed by a separate React Native Expo mobile app (`~/projects/sykmmsite-app/`).

## Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.2+ |
| Framework | CodeIgniter 4 (v4.7.4) |
| Database | MySQL (MySQLi driver) |
| Frontend | Plain HTML/CSS (inline styles, no JS framework) |
| Dependency Manager | Composer |
| Testing | PHPUnit 10.5+ |
| Hosting | cPanel shared hosting |

## Commands

```bash
# Install dependencies
composer install

# Run tests
composer test

# Generate CI4 scaffolding
php spark make:controller <Name>
php spark make:model <Name>
php spark make:migration <Name>
php spark make:filter <Name>

# Run database migrations
php spark migrate

# Run code style checks / fixes
composer cs-check
composer cs-fix

# Start local dev server
php spark serve
# → http://localhost:8080
```

## Directory Structure

```
app/
  Config/          # Routes, Database, Filters, App config
  Controllers/     # Web controllers
    Api/           # REST API controllers (for mobile app)
  Models/          # Eloquent-style models (PropertyModel, PostModel, AdminModel)
  Views/           # PHP view templates
    layouts/       # Layout templates (main.php)
    partials/      # Shared partials (header.php)
    admin/         # Admin views
    auth/          # Login views
    properties/    # Property CRUD views
    posts/         # Blog post CRUD views
public/            # Document root (web-accessible)
  uploads/         # Uploaded images
tests/             # PHPUnit tests
  unit/            # Unit tests
  database/        # Database tests
writable/          # Cache, logs, sessions, temp uploads
```

## Code Conventions

### Controllers
- Web controllers extend `App\Controllers\BaseController`
- API controllers extend `App\Controllers\Api\BaseApiController` (uses `ResponseTrait`)
- Use `esc()` for output escaping in views
- Include `csrf_field()` in all HTML forms

### Models
- Extend `CodeIgniter\Model`
- Define `$table`, `$primaryKey`, `$allowedFields`, `$validationRules`
- Use Query Builder — never raw SQL

### Views
- Layout inheritance: `<?= view('partials/header') ?>` + `$this->renderSection('content')`
- All dynamic output wrapped in `esc()`
- Inline CSS only (no external stylesheets)

### Routing
- All routes defined explicitly in `app/Config/Routes.php`
- Web routes: GET/POST pairs for CRUD
- API routes: `$routes->resource()` under `api/` group
- Auto-routing is disabled

### Authentication
- Web: Session-based (`session()->set(['isAdminLoggedIn' => true])`)
- API: Bearer token auth (`ApiAuth` filter validates `Authorization: Bearer <token>`)
- Token generated on login, stored in `admins.api_token` column

## API Endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| POST | `/api/adminauth/login` | Admin login (returns token) |
| GET | `/api/admin-dashboard` | Dashboard data |
| GET/POST | `/api/properties` | Properties CRUD |
| GET/POST | `/api/posts` | Blog posts CRUD |

## Important Files

- `app/Config/Routes.php` — All route definitions
- `app/Config/Database.php` — DB connections (prod: MySQL, test: SQLite3)
- `app/Config/Filters.php` — CORS, CSRF, DebugToolbar filters
- `.env` — Environment config (DB creds, base URL)
- `phpunit.dist.xml` — Test configuration

## Testing

- Tests use SQLite3 in-memory database (`Config\Database::$tests`)
- Run: `composer test`
- Test base class: `CodeIgniter\Test\CIUnitTestCase`
- Coverage output: `build/logs/`

## Known Issues / Technical Debt

- Schema changes should be done via migrations (`php spark migrate`), not manual SQL
- File upload paths are inconsistent (`/uploads/`, `/uploads/blog/`, `/uploads/properties/`)
