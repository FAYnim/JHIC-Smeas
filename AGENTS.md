# Agent Guidelines for JHIC-Smeas-v2

Welcome agent. This repository is **JHIC-Smeas-v2**, a Laravel 13 web application powering the SMKN 1 Surabaya Career Center (Pusat Karir).

## 1. Tech Stack Overview

- **Framework**: Laravel 13.x (PHP ^8.3, currently running PHP 8.5)
- **Frontend / Bundler**: Vite 8, Tailwind CSS v4 (@tailwindcss/vite), Blade templates
- **Testing**: PHPUnit 12.x via `artisan test`
- **Code Style & Linter**: Laravel Pint 1.27
- **Database**: SQLite (default testing/local) / MySQL

---

## 2. Build, Dev & Environment Commands

```bash
# Install PHP dependencies
composer install

# Install frontend dependencies
npm install

# Run database migrations
php artisan migrate

# Seed database with initial data (users & sample job vacancies)
php artisan db:seed

# Start development servers concurrently
php artisan dev

# Or start services individually:
php artisan serve            # Laravel HTTP server on http://localhost:8000
npm run dev                  # Vite development HMR server
npm run build                # Production frontend asset build

# Clear all cached configuration, routes, and views
php artisan optimize:clear
```

---

## 3. Testing Commands

All test files reside in `tests/Unit` and `tests/Feature`. Use PHPUnit or `php artisan test`.

```bash
# Run entire test suite
php artisan test
# Alternative via direct PHPUnit binary:
php vendor/bin/phpunit

# Run a single test file
php artisan test tests/Feature/ExampleTest.php
php vendor/bin/phpunit tests/Feature/ExampleTest.php

# Run a specific test method by name / filter
php artisan test --filter=test_the_application_returns_a_successful_response
php vendor/bin/phpunit --filter=test_the_application_returns_a_successful_response

# Run a specific test inside a specific file
php artisan test tests/Feature/ExampleTest.php --filter=test_the_application_returns_a_successful_response

# Run only a specific test suite (Unit or Feature)
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Halt execution immediately on first failure
php artisan test --stop-on-failure
```

---

## 4. Linting & Formatting Commands

Laravel Pint is configured for code style enforcement. Always run Pint before finalizing changes:

```bash
# Inspect code formatting without modifying files (CI check mode)
php vendor/bin/pint --test

# Automatically fix code formatting across the entire codebase
php vendor/bin/pint

# Fix only modified/uncommitted Git files
php vendor/bin/pint --dirty
```

---

## 5. Code Style Guidelines

Follow PSR-12 and official Laravel standards maintained by Pint:

### Imports
- Place namespace at the top, followed by `use` statements alphabetically sorted.
- Group imports logically: framework/third-party classes first, application classes second.
- Never use inline fully qualified class names in code signatures or method bodies.
- Remove all unused imports.

### Formatting & Indentation
- Use **4 spaces** for indentation in PHP files. No tabs.
- Use **2 spaces** for JSON, YAML, JavaScript, and CSS.
- Line endings must be LF (`\n`) with UTF-8 encoding (enforced via `.editorconfig`).
- Always use short array syntax `[]` instead of `array()`.
- Place opening braces for classes and methods on their own newline.
- Place opening braces for control structures (`if`, `for`, `foreach`) on the same line.

### Types & Declarations
- Declare parameter types and return types explicitly for all methods and functions.
- Use native PHP 8 union types and nullable types (`?string`, `string|int`).
- In Eloquent models, use the `casts()` method returning an array rather than the legacy `$casts` property:
  ```php
  protected function casts(): array
  {
      return [
          'is_mitra_dudi'     => 'boolean',
          'tanggung_jawab'    => 'array',
          'batas_pendaftaran' => 'date',
      ];
  }
  ```

---

## 6. Naming Conventions

Maintain strict naming consistency across domain layers:

- **Controllers**: PascalCase with `Controller` suffix (`LowonganController`).
- **Models**: PascalCase singular (`Lowongan`, `User`).
- **Migrations**: snake_case prefixed by timestamp (`create_lowongans_table.php`).
- **Database Tables**: snake_case plural (`lowongans`, `users`).
- **Database Columns**: snake_case (`company_name`, `metode_kerja`, `is_mitra_dudi`).
- **Routes & Names**: kebab-case URLs and dot-notation route names (`/pusat-karir/{slug}`, `name('pusat-karir.detail')`).
- **Blade Views**: kebab-case files inside feature directories (`resources/views/pusat-karir/detail-lowongan.blade.php`).
- **Variables & Methods**: camelCase (`$lowongan`, `$request`, `show()`, `index()`).
- **Tests**: PascalCase ending in `Test` (`LowonganTest`), methods named snake_case with `test_` prefix or `#[Test]` attribute.

---

## 7. Error Handling & Validation

- Use `firstOrFail()` or `findOrFail()` when retrieving models to automatically dispatch 404 responses on missing records:
  ```php
  $lowongan = Lowongan::where('slug', $slug)->firstOrFail();
  ```
- Validate all incoming user inputs via dedicated FormRequest classes (`php artisan make:request`) or `$request->validate()`.
- Avoid broad `catch (\Exception $e)` blocks; catch specific domain exceptions whenever possible.
- Never output unhandled raw error details or database credentials to end-user views.
- Ensure route-model binding or slug lookups are sanitised against SQL injection and parameter manipulation.

---

## 8. Frontend & UI Conventions

- Assets are compiled using **Tailwind CSS v4** and **Vite**.
- Use Tailwind utility classes directly in Blade templates.
- Maintain responsive, mobile-first layouts with accessibility standards.
- Vector icons: prefer SVG or FontAwesome Solid icons. Avoid decorative emojis in production UI.

---

## 9. Cursor & Copilot Rule Ingestion

No existing `.cursorrules`, `.cursor/rules/`, or `.github/copilot-instructions.md` configuration files were detected in this repository. All agentic tools must treat the instructions and conventions in this `AGENTS.md` file as the single source of truth.
