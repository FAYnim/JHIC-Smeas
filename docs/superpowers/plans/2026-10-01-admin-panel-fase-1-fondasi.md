# Admin Panel Multi-Role — Fase 1 (Fondasi) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Roles pada `users`, staff login/logout, middleware `role`, layout admin sidebar navy + topbar, dan dashboard dengan stat card yang difilter per role.

**Architecture:** Satu kolom `role` enum pada `users` (tanpa package permission tambahan). Route group `prefix('admin')` + `name('admin.')` + middleware `auth`. Middleware alias `role`讀 daftar role dari route parameter dan selalu mengizinkan `admin`. Layout Blade tunggal `admin/layout.blade.php` menampilkan menu sidebar yang difilter berdasarkan role user. Dashboard menghitung statistik per-domain hanya untuk domain yang diizinkan role user.

**Tech Stack:** Laravel 13, PHP 8.3+, Blade, Tailwind CSS v4 (@tailwindcss/vite), `mallardduck/blade-lucide-icons`, PHPUnit 12, Laravel Pint.

---

## File Structure

| File | Responsibility |
|---|---|
| `database/migrations/2026_10_01_140000_add_role_to_users_table.php` | Tambah kolom `role` enum nullable ke `users` |
| `app/Models/User.php` | Tambah `role` ke fillable, konstanta role, helper `hasRole()`, `isAdmin()` |
| `app/Http/Middleware/EnsureRole.php` | 403 bila role user tidak diizinkan (admin selalu lolos) |
| `bootstrap/app.php` | Registrasi alias middleware `role` |
| `app/Http/Controllers/Auth/LoginController.php` | `create()` render form login, `store()` autentikasi, `destroy()` logout |
| `app/Http/Requests/Admin/LoginRequest.php` | Validasi kredensial + aturan role-null |
| `routes/web.php` | Route login/logout + group `/admin` |
| `routes/admin.php` | Semua route admin (di-`require` dari `web.php`) |
| `app/Http/Controllers/Admin/DashboardController.php` | Hitung + kirim statistik per role ke view |
| `app/Support/AdminMenu.php` | Definisi menu sidebar (label, route, ikon, daftar role) |
| `resources/views/auth/login.blade.php` | Halaman login staff (Tailwind, navy) |
| `resources/views/admin/layout.blade.php` | Shell admin: sidebar + topbar + flash |
| `resources/views/admin/dashboard.blade.php` | Stat card + daftar item terbaru |
| `database/seeders/AdminUserSeeder.php` | 4 akun staff, satu per role |
| `database/seeders/DatabaseSeeder.php` | Panggil `AdminUserSeeder` |
| `database/factories/UserFactory.php` | Tambah state `admin()`/`bkk()`/`humas()`/`spmb()`/`withoutRole()` |
| `tests/Feature/Admin/LoginTest.php` | Login sukses/gagal/role-null/logout |
| `tests/Feature/Admin/RoleMiddlewareTest.php` | 403 role salah, admin selalu lolos, guest redirect |
| `tests/Feature/Admin/DashboardTest.php` | Dashboard per role hanya menampilkan domainnya |

Existing files modified: `app/Models/User.php`, `bootstrap/app.php`, `routes/web.php`, `database/seeders/DatabaseSeeder.php`, `database/factories/UserFactory.php`.

---

## Task 1: Kolom role pada users

**Files:**
- Create: `database/migrations/2026_10_01_140000_add_role_to_users_table.php`
- Modify: `app/Models/User.php`
- Test: `tests/Feature/Admin/RoleColumnTest.php`

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/RoleColumnTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleColumnTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_a_role(): void
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
            'role' => 'bkk',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'budi@smkn1.surabaya.sch.id',
            'role' => 'bkk',
        ]);
    }

    public function test_role_may_be_null_for_unassigned_account(): void
    {
        User::create([
            'name' => 'Belum Ditugaskan',
            'email' => 'baru@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $user = User::where('email', 'baru@smkn1.surabaya.sch.id')->firstOrFail();

        $this->assertNull($user->role);
    }

    public function test_invalid_role_is_rejected_by_database(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        DB::table('users')->insert([
            'name' => 'Salah Peran',
            'email' => 'salah@smkn1.surabaya.sch.id',
            'password' => bcrypt('rahasia123'),
            'role' => 'superuser',
        ]);
    }
}
```

Add the missing import to the same file — put `use Illuminate\Support\Facades\DB;` after `use App\Models\User;`:

```php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/RoleColumnTest.php`

Expected: FAIL — SQLSTATE error, column `role` does not exist.

- [ ] **Step 3: Create the migration**

Create `database/migrations/2026_10_01_140000_add_role_to_users_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'bkk', 'humas', 'spmb'])
                ->nullable()
                ->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
```

- [ ] **Step 4: Add role to the User model**

Replace `app/Models/User.php` entirely with:

```php
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_BKK = 'bkk';

    public const ROLE_HUMAS = 'humas';

    public const ROLE_SPMB = 'spmb';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * @param  list<string>  $roles
     */
    public function hasRole(array $roles): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->role !== null && in_array($this->role, $roles, true);
    }

    /**
     * Label peran untuk ditampilkan di UI.
     */
    public function roleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Super Admin',
            self::ROLE_BKK => 'BKK (Pusat Karir)',
            self::ROLE_HUMAS => 'Humas',
            self::ROLE_SPMB => 'Panitia SPMB',
            default => 'Belum Ditugaskan',
        };
    }
}
```

- [ ] **Step 5: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/RoleColumnTest.php`

Expected: PASS — 3 tests OK.

- [ ] **Step 6: Commit**

```bash
git add database/migrations/2026_10_01_140000_add_role_to_users_table.php app/Models/User.php tests/Feature/Admin/RoleColumnTest.php
git commit -m "feat: add role enum to users table with model helpers"
```

---

## Task 2: Factory states per role

**Files:**
- Modify: `database/factories/UserFactory.php`
- Test: `tests/Feature/Admin/UserFactoryRoleStateTest.php`

Factory states dipakai seluruh test admin berikutnya, jadi dibuat sebelum middleware/login.

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/UserFactoryRoleStateTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFactoryRoleStateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_state_assigns_admin_role(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertSame(User::ROLE_ADMIN, $user->role);
        $this->assertTrue($user->isAdmin());
    }

    public function test_bkk_state_assigns_bkk_role(): void
    {
        $this->assertSame(User::ROLE_BKK, User::factory()->bkk()->create()->role);
    }

    public function test_humas_state_assigns_humas_role(): void
    {
        $this->assertSame(User::ROLE_HUMAS, User::factory()->humas()->create()->role);
    }

    public function test_spmb_state_assigns_spmb_role(): void
    {
        $this->assertSame(User::ROLE_SPMB, User::factory()->spmb()->create()->role);
    }

    public function test_without_role_state_leaves_role_null(): void
    {
        $this->assertNull(User::factory()->withoutRole()->create()->role);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/UserFactoryRoleStateTest.php`

Expected: FAIL — `Call to undefined method ...::admin()`.

- [ ] **Step 3: Add the states**

Replace `database/factories/UserFactory.php` with:

```php
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withoutRole(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => User::ROLE_ADMIN,
        ]);
    }

    public function bkk(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => User::ROLE_BKK,
        ]);
    }

    public function humas(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => User::ROLE_HUMAS,
        ]);
    }

    public function spmb(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => User::ROLE_SPMB,
        ]);
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/UserFactoryRoleStateTest.php`

Expected: PASS — 5 tests OK.

- [ ] **Step 5: Commit**

```bash
git add database/factories/UserFactory.php tests/Feature/Admin/UserFactoryRoleStateTest.php
git commit -m "feat: add role states to UserFactory"
```

---

## Task 3: Middleware EnsureRole

**Files:**
- Create: `app/Http/Middleware/EnsureRole.php`
- Modify: `bootstrap/app.php:14-16`
- Test: `tests/Feature/Admin/RoleMiddlewareTest.php`

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/RoleMiddlewareTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_user_with_wrong_role_gets_403(): void
    {
        $bkk = User::factory()->bkk()->create();

        $this->actingAs($bkk)
            ->get('/admin-humas-only')
            ->assertForbidden();
    }

    public function test_user_with_matching_role_is_allowed(): void
    {
        $humas = User::factory()->humas()->create();

        $this->actingAs($humas)
            ->get('/admin-humas-only')
            ->assertOk();
    }

    public function test_admin_passes_every_role_check(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/admin-humas-only')
            ->assertOk();
    }

    public function test_user_without_role_gets_403(): void
    {
        $staff = User::factory()->withoutRole()->create();

        $this->actingAs($staff)
            ->get('/admin-humas-only')
            ->assertForbidden();
    }

    public function test_multiple_allowed_roles_are_supported(): void
    {
        $bkk = User::factory()->bkk()->create();

        $this->actingAs($bkk)
            ->get('/admin-bkk-or-humas')
            ->assertOk();
    }
}
```

- [ ] **Step 2: Register test-only routes**

Create `routes/testing.php` (loaded only when `app()->runningUnitTests()`):

```php
<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/admin-humas-only', [DashboardController::class, 'index'])
        ->middleware('role:humas')
        ->name('testing.humas-only');

    Route::get('/admin-bkk-or-humas', [DashboardController::class, 'index'])
        ->middleware('role:bkk,humas')
        ->name('testing.bkk-or-humas');
});
```

Wire it into `routes/web.php` — add at the very bottom:

```php
if (app()->runningUnitTests()) {
    require __DIR__.'/testing.php';
}
```

- [ ] **Step 3: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/RoleMiddlewareTest.php`

Expected: FAIL — middleware `role` not defined (Laravel throws "Target class [role] does not exist").

- [ ] **Step 4: Create the middleware**

Create `app/Http/Middleware/EnsureRole.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * @param  Closure(Request): Response  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        abort_unless($user !== null && $user->hasRole($roles), 403, 'Anda tidak memiliki akses ke halaman ini.');

        return $next($request);
    }
}
```

- [ ] **Step 5: Register the alias in bootstrap/app.php**

Replace `bootstrap/app.php` with:

```php
<?php

use App\Http\Middleware\EnsureRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => EnsureRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
```

- [ ] **Step 6: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/RoleMiddlewareTest.php`

Expected: FAIL — `App\Http\Controllers\Admin\DashboardController` belum ada (route `/admin` juga belum ada untuk guest test).

- [ ] **Step 7: Create a placeholder DashboardController so routes resolve**

Create `app/Http/Controllers/Admin/DashboardController.php`:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard');
    }
}
```

Create `resources/views/admin/dashboard.blade.php`:

```blade
<h1>Dashboard</h1>
```

- [ ] **Step 8: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/RoleMiddlewareTest.php`

Expected: FAIL — route `login` belum ada (guest redirect assertion).

- [ ] **Step 9: Add a temporary login route name so the guest assertion resolves**

Tambahkan di `routes/testing.php`:

```php
Route::get('/__login-stub', fn () => 'ok')->name('login');
```

- [ ] **Step 10: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/RoleMiddlewareTest.php`

Expected: PASS — 6 tests OK.

- [ ] **Step 11: Commit**

```bash
git add app/Http/Middleware/EnsureRole.php bootstrap/app.php routes/testing.php routes/web.php app/Http/Controllers/Admin/DashboardController.php resources/views/admin/dashboard.blade.php tests/Feature/Admin/RoleMiddlewareTest.php
git commit -m "feat: add role middleware with admin bypass"
```

---

## Task 4: Staff login & logout

**Files:**
- Create: `app/Http/Requests/Admin/LoginRequest.php`
- Create: `app/Http/Controllers/Auth/LoginController.php`
- Create: `resources/views/auth/login.blade.php`
- Modify: `routes/web.php:1-9` (tambah route login/logout di atas route `beranda`)
- Modify: `routes/testing.php` (hapus stub `login`, pakai route asli)
- Test: `tests/Feature/Admin/LoginTest.php`

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/LoginTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $bkk = User::factory()->bkk()->create([
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($bkk);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->bkk()->create([
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'salah-total',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_fails_for_unknown_email(): void
    {
        $this->post(route('login.store'), [
            'email' => 'tidak-ada@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_account_without_role_is_rejected(): void
    {
        User::factory()->withoutRole()->create([
            'email' => 'baru@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'baru@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_requires_email_and_password(): void
    {
        $this->post(route('login.store'), [])
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_user_can_logout(): void
    {
        $bkk = User::factory()->bkk()->create();

        $this->actingAs($bkk)
            ->post(route('logout'))
            ->assertRedirect(route('beranda'));

        $this->assertGuest();
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/LoginTest.php`

Expected: FAIL — route `login` belum ada (masih stub dari Task 3).

- [ ] **Step 3: Create the FormRequest**

Create `app/Http/Requests/Admin/LoginRequest.php`:

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ];
    }
}
```

- [ ] **Step 4: Create the controller**

Create `app/Http/Controllers/Auth/LoginController.php`:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $request->session()->regenerate();

        if ($request->user()->role === null) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Akun belum memiliki peran. Hubungi administrator.',
            ]);
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}
```

- [ ] **Step 5: Create the login view**

Create `resources/views/auth/login.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — SMKN 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen flex items-center justify-center bg-slate-100 antialiased">
    <div class="w-full max-w-md px-4">
        <div class="text-center mb-8">
            <img src="{{ asset('images/smkn1-logo-white-transparent.png') }}" alt="Logo SMKN 1 Surabaya"
                class="h-20 mx-auto object-contain">
            <h1 class="mt-4 text-2xl font-extrabold text-slate-900">Panel Admin</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">SMKN 1 Surabaya — Pusat Karir</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-600 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        autocomplete="username" autofocus
                        class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/15 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="block text-xs font-bold text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-600 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/15 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="block text-xs font-bold text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold text-sm py-3 rounded-lg hover:bg-blue-700 transition">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs font-medium text-slate-500 mt-6">
            <a href="{{ route('beranda') }}" class="text-blue-700 hover:underline">← Kembali ke situs</a>
        </p>
    </div>
</body>

</html>
```

- [ ] **Step 6: Register the routes**

Replace the stub in `routes/testing.php` — hapus baris `Route::get('/__login-stub', ...)->name('login');`

Tambahkan di `routes/web.php`, tepat setelah `use` statements dan sebelum `Route::get('/', ...)`:

```php
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest')->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');
```

Dan tambahkan import di bagian atas `routes/web.php`:

```php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BludController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\SpmbController;
use Illuminate\Support\Facades\Route;
```

- [ ] **Step 7: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/LoginTest.php`

Expected: PASS — 7 tests OK.

- [ ] **Step 8: Re-run the middleware test to confirm nothing regressed**

Run: `php artisan test tests/Feature/Admin/RoleMiddlewareTest.php`

Expected: PASS — 6 tests OK.

- [ ] **Step 9: Commit**

```bash
git add app/Http/Requests/Admin/LoginRequest.php app/Http/Controllers/Auth/LoginController.php resources/views/auth/login.blade.php routes/web.php routes/testing.php tests/Feature/Admin/LoginTest.php
git commit -m "feat: add staff login and logout"
```

---

## Task 5: Definisi menu per role

**Files:**
- Create: `app/Support/AdminMenu.php`
- Test: `tests/Feature/Admin/AdminMenuTest.php`

Menu sidebar adalah sumber tunggal kebenaran navigasi; Task 6SJ dan modul Fase berikutnya memakainya.

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/AdminMenuTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Support\AdminMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_role_sees_the_dashboard_item(): void
    {
        foreach ([User::ROLE_ADMIN, User::ROLE_BKK, User::ROLE_HUMAS, User::ROLE_SPMB] as $role) {
            $items = AdminMenu::itemsFor(User::factory()->create(['role' => $role]));

            $this->assertSame('admin.dashboard', $items[0]['route'], "Role {$role} harus punya dashboard.");
        }
    }

    public function test_bkk_sees_lowongan_but_not_artikel(): void
    {
        $items = AdminMenu::itemsFor(User::factory()->bkk()->create());

        $routes = array_column($items, 'route');

        $this->assertContains('admin.lowongan.index', $routes);
        $this->assertNotContains('admin.guru.index', $routes);
    }

    public function test_humas_sees_artikel_but_not_lowongan(): void
    {
        $items = AdminMenu::itemsFor(User::factory()->humas()->create());

        $routes = array_column($items, 'route');

        $this->assertContains('admin.artikel.index', $routes);
        $this->assertNotContains('admin.lowongan.index', $routes);
    }

    public function test_spmb_sees_calon_siswa_but_not_mitra(): void
    {
        $items = AdminMenu::itemsFor(User::factory()->spmb()->create());

        $routes = array_column($items, 'route');

        $this->assertContains('admin.calon-siswa.index', $routes);
        $this->assertNotContains('admin.mitra.index', $routes);
    }

    public function test_admin_sees_every_menu_item(): void
    {
        $items = AdminMenu::itemsFor(User::factory()->admin()->create());

        $routes = array_column($items, 'route');

        $this->assertContains('admin.lowongan.index', $routes);
        $this->assertContains('admin.users.index', $routes);
        $this->assertContains('admin.settings.edit', $routes);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/AdminMenuTest.php`

Expected: FAIL — class `App\Support\AdminMenu` not found.

- [ ] **Step 3: Create the menu definition**

Create `app/Support/AdminMenu.php`:

```php
<?php

namespace App\Support;

use App\Models\User;

class AdminMenu
{
    /**
     * Definisi menu sidebar admin.
     *
     * Route modul Fase 2–4 belum ada; View composer installed pada Task 6
     * menyaring item yang route-nya belum terdaftar agar `route()` tidak
     * melempar exception.
     *
     * @var list<array{group: string, label: string, route: string, icon: string, roles: list<string>}>
     */
    private const ITEMS = [
        [
            'group' => 'Umum',
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'layout-grid',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK, User::ROLE_HUMAS, User::ROLE_SPMB],
        ],
        [
            'group' => 'Umum',
            'label' => 'Artikel',
            'route' => 'admin.artikel.index',
            'icon' => 'newspaper',
            'roles' => [User::ROLE_ADMIN, User::ROLE_HUMAS],
        ],
        [
            'group' => 'Pusat Karir',
            'label' => 'Lowongan',
            'route' => 'admin.lowongan.index',
            'icon' => 'briefcase',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
        [
            'group' => 'Pusat Karir',
            'label' => 'Lamaran Magang',
            'route' => 'admin.lamaran.index',
            'icon' => 'inbox',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
        [
            'group' => 'Pusat Karir',
            'label' => 'Mitra DUDI',
            'route' => 'admin.mitra.index',
            'icon' => 'building-2',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
        [
            'group' => 'Profil Sekolah',
            'label' => 'Guru & Tendik',
            'route' => 'admin.guru.index',
            'icon' => 'users',
            'roles' => [User::ROLE_ADMIN, User::ROLE_HUMAS],
        ],
        [
            'group' => 'SPMB',
            'label' => 'Calon Siswa',
            'route' => 'admin.calon-siswa.index',
            'icon' => 'graduation-cap',
            'roles' => [User::ROLE_ADMIN, User::ROLE_SPMB],
        ],
        [
            'group' => 'Sistem',
            'label' => 'Pengguna',
            'route' => 'admin.users.index',
            'icon' => 'shield',
            'roles' => [User::ROLE_ADMIN],
        ],
        [
            'group' => 'Sistem',
            'label' => 'Pengaturan',
            'route' => 'admin.settings.edit',
            'icon' => 'settings',
            'roles' => [User::ROLE_ADMIN],
        ],
    ];

    /**
     * @return list<array{group: string, label: string, route: string, icon: string, roles: list<string>}>
     */
    public static function itemsFor(?User $user): array
    {
        if ($user === null) {
            return [];
        }

        if ($user->isAdmin()) {
            return array_map(
                fn (array $item): array => array_merge($item, ['roles' => [$user->role]]),
                self::ITEMS,
            );
        }

        return array_values(array_filter(
            self::ITEMS,
            fn (array $item): bool => $user->hasRole($item['roles']),
        ));
    }

    /**
     * Hanya route yang benar-benar terdaftar, agar `route()` tidak gagal
     * untuk modul yang belum diimplementasikan.
     *
     * @return list<array{group: string, label: string, route: string, icon: string, roles: list<string>}>
     */
    public static function availableItemsFor(?User $user): array
    {
        $router = app('router')->getRoutes();

        return array_values(array_filter(
            self::itemsFor($user),
            fn (array $item): bool => $router->has($item['route']),
        ));
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/AdminMenuTest.php`

Expected: PASS — 5 tests OK.

- [ ] **Step 5: Commit**

```bash
git add app/Support/AdminMenu.php tests/Feature/Admin/AdminMenuTest.php
git commit -m "feat: add role-filtered admin menu definition"
```

---

## Task 6: Layout admin (sidebar navy + topbar)

**Files:**
- Create: `resources/views/admin/layout.blade.php`
- Modify: `app/Http/Controllers/Admin/DashboardController.php`
- Modify: `resources/views/admin/dashboard.blade.php`
- Test: `tests/Feature/Admin/AdminLayoutTest.php`

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/AdminLayoutTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_layout_renders_sidebar_and_topbar(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Panel Admin', false);
        $response->assertSee($admin->name);
        $response->assertSee('Super Admin');
    }

    public function test_logout_form_is_present(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertSee(route('logout'), false);
    }

    public function test_menu_only_shows_items_available_for_role(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->get(route('admin.dashboard'));

        $response->assertSee('Pusat Karir', false);
        $response->assertDontSee('Pengguna', false);
    }

    public function test_admin_menu_hides_modules_not_yet_implemented(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        // Modul Lowongan belum punya route di Fase 1, jadi tidak boleh tampil.
        $response->assertDontSee('Lowongan', false);
        $response->assertSee('Dashboard', false);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/AdminLayoutTest.php`

Expected: FAIL — route `admin.dashboard` belum terdaftar.

- [ ] **Step 3: Create the admin route file**

Create `routes/admin.php`:

```php
<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
```

- [ ] **Step 4: Wire it into web.php**

Tambahkan di `routes/web.php`, tepat sebelum blok `if (app()->runningUnitTests())`:

```php
Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        require __DIR__.'/admin.php';
    });
```

- [ ] **Step 5: Create the layout**

Create `resources/views/admin/layout.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin') — SMKN 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        /* ponytail: token warna inline. Pindahkan ke resources/css/app.css
           @theme bila panel admin tumbuh modul baru yang butuh warna sama. */
        .adm-body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .adm-sidebar {
            width: 264px;
            background: #1e3a5f;
            position: fixed;
            inset-block: 0;
            inset-inline-start: 0;
            z-index: 40;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .adm-nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .625rem .875rem;
            border-radius: .5rem;
            color: #cbd5e1;
            font-size: .875rem;
            font-weight: 600;
            transition: background .15s ease, color .15s ease;
        }

        .adm-nav-item svg {
            width: 1.125rem;
            height: 1.125rem;
            flex-shrink: 0;
        }

        .adm-nav-item:hover {
            color: #fff;
            background: rgba(255, 255, 255, .08);
        }

        .adm-nav-item--active {
            color: #fff;
            background: #2563eb;
        }

        .adm-main {
            margin-inline-start: 264px;
            min-height: 100vh;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
        }

        .adm-topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: .875rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .adm-content {
            padding: 1.5rem;
            flex: 1;
        }

        .adm-userchip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: #1e3a5f;
            color: #fff;
            font-size: .8rem;
            font-weight: 700;
            padding: .4rem .875rem;
            border-radius: .5rem;
        }

        .adm-menu-toggle {
            display: none;
        }

        @media (max-width: 1023px) {
            .adm-sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }

            .adm-sidebar--open {
                transform: translateX(0);
            }

            .adm-main {
                margin-inline-start: 0;
            }

            .adm-menu-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.5rem;
                height: 2.5rem;
                background: #1e3a5f;
                color: #fff;
                border-radius: .5rem;
                cursor: pointer;
            }
        }
    </style>
</head>

<body class="adm-body antialiased">
    @php
        $menuItems = \App\Support\AdminMenu::availableItemsFor(auth()->user());
        $menuGroups = [];
        foreach ($menuItems as $item) {
            $menuGroups[$item['group']][] = $item;
        }
    @endphp

    <aside id="adm-sidebar" class="adm-sidebar">
        <div class="flex items-center gap-3 px-5 pt-5 pb-4">
            <img src="{{ asset('images/smkn1-logo-white-transparent.png') }}" alt="Logo SMKN 1 Surabaya"
                class="h-11 w-auto object-contain">
            <span class="text-white font-extrabold text-lg leading-tight">Panel Admin</span>
        </div>

        <nav class="flex flex-col gap-4 px-5 pb-6">
            @foreach ($menuGroups as $group => $items)
                <div>
                    @if ($group !== 'Umum')
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-2.5 mb-1.5">
                            {{ $group }}
                        </p>
                    @endif

                    @foreach ($items as $item)
                        <a href="{{ route($item['route']) }}"
                            class="adm-nav-item {{ request()->routeIs($item['route']) ? 'adm-nav-item--active' : '' }}">
                            @switch($item['icon'])
                                @case('layout-grid')
                                    <x-lucide-layout-grid />
                                @break
                                @case('newspaper')
                                    <x-lucide-newspaper />
                                @break
                                @case('briefcase')
                                    <x-lucide-briefcase />
                                @break
                                @case('inbox')
                                    <x-lucide-inbox />
                                @break
                                @case('building-2')
                                    <x-lucide-building-2 />
                                @break
                                @case('users')
                                    <x-lucide-users />
                                @break
                                @case('graduation-cap')
                                    <x-lucide-graduation-cap />
                                @break
                                @case('shield')
                                    <x-lucide-shield />
                                @break
                                @case('settings')
                                    <x-lucide-settings />
                                @break
                                @default
                                    <x-lucide-circle />
                            @endswitch
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>
    </aside>

    <div class="adm-main">
        <header class="adm-topbar">
            <div class="flex items-center gap-3">
                <button type="button" class="adm-menu-toggle" id="adm-menu-toggle" aria-label="Toggle menu">
                    <x-lucide-menu class="w-6 h-6" />
                </button>
                <h1 class="text-xl font-extrabold text-slate-900">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="adm-userchip">
                    <span>{{ auth()->user()->name }}</span>
                    <span class="text-[10px] font-semibold text-blue-200">
                        ({{ auth()->user()->roleLabel() }})
                    </span>
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-red-600 transition">
                        <x-lucide-log-out class="w-4 h-4" />
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        <main class="adm-content">
            @if (session('success'))
                <div
                    class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        const admMenuToggle = document.getElementById('adm-menu-toggle');
        const admSidebar = document.getElementById('adm-sidebar');
        if (admMenuToggle && admSidebar) {
            admMenuToggle.addEventListener('click', () => {
                admSidebar.classList.toggle('adm-sidebar--open');
            });
        }
    </script>
    @yield('scripts')
</body>

</html>
```

- [ ] **Step 6: Update the dashboard view to extend the layout**

Replace `resources/views/admin/dashboard.blade.php` with:

```blade
@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <p class="text-sm font-medium text-slate-500">Ringkasan data sesuai cakupan akses Anda.</p>
@endsection
```

- [ ] **Step 7: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/AdminLayoutTest.php`

Expected: PASS — 4 tests OK.

- [ ] **Step 8: Commit**

```bash
git add routes/admin.php routes/web.php resources/views/admin/layout.blade.php resources/views/admin/dashboard.blade.php tests/Feature/Admin/AdminLayoutTest.php
git commit -m "feat: add admin layout with navy sidebar and role-filtered menu"
```

---

## Task 7: Dashboard dengan stat card per role

**Files:**
- Create: `app/Http/Controllers/Admin/DashboardController.php` (ubah dari placeholder Task 3)
- Modify: `resources/views/admin/dashboard.blade.php`
- Test: `tests/Feature/Admin/DashboardTest.php`

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/DashboardTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\Artikel;
use App\Models\CalonSiswa;
use App\Models\Lowongan;
use App\Models\MagangApplication;
use App\Models\MitraPerusahaan;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_sees_pusat_karir_statistics(): void
    {
        Lowongan::factory()->create();
        MitraPerusahaan::create($this->mitraPayload());

        $response = $this->actingAs(User::factory()->bkk()->create())
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Total Lowongan');
        $response->assertSee('Mitra DUDI');
        $response->assertSee('Lamaran Menunggu');
        $response->assertDontSee('Total Artikel');
        $response->assertDontSee('Total Calon Siswa');
    }

    public function test_bkk_pending_application_count_is_shown(): void
    {
        $lowongan = Lowongan::factory()->create();

        MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => '1234567890',
            'registration_code' => 'PKL-TEST-1',
            'status' => 'pending',
        ]);

        $response = $this->actingAs(User::factory()->bkk()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Lamaran Menunggu');
        $response->assertSee('1', false);
    }

    public function test_humas_sees_content_statistics_only(): void
    {
        Artikel::create([
            'title' => 'Judul Artikel Uji',
            'slug' => 'judul-artikel-uji',
            'excerpt' => 'Ringkasan.',
            'content' => 'Isi artikel.',
            'kategori' => 'Berita',
            'reading_time' => 3,
        ]);

        Webinar::create([
            'title' => 'Webinar Uji',
            'slug' => 'webinar-uji',
            'description' => 'Deskripsi.',
            'speaker' => 'Narasumber',
            'platform' => 'Zoom',
            'location' => 'Online',
            'start_date' => '2026-11-01',
            'start_time' => '09:00',
            'registration_url' => 'https://example.com',
            'is_published' => true,
        ]);

        $response = $this->actingAs(User::factory()->humas()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Total Artikel');
        $response->assertSee('Total Webinar');
        $response->assertDontSee('Total Lowongan');
        $response->assertDontSee('Mitra DUDI');
    }

    public function test_spmb_sees_calon_siswa_statistics_only(): void
    {
        CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Siswa Uji',
            'jurusan_pilihan' => 'RPL',
        ]);

        $response = $this->actingAs(User::factory()->spmb()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Total Calon Siswa');
        $response->assertDontSee('Total Lowongan');
        $response->assertDontSee('Total Artikel');
    }

    public function test_admin_sees_all_domains(): void
    {
        Lowongan::factory()->create();

        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Total Lowongan');
        $response->assertSee('Mitra DUDI');
        $response->assertSee('Total Artikel');
        $response->assertSee('Total Calon Siswa');
    }

    public function test_dashboard_lists_recent_items_for_role_domain(): void
    {
        Lowongan::factory()->create([
            'title' => 'Lowongan Terbaru Uji',
            'company_name' => 'PT Uji Sentosa',
        ]);

        $response = $this->actingAs(User::factory()->bkk()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Lowongan Terbaru Uji');
    }

    /**
     * @return array<string, mixed>
     */
    protected function mitraPayload(): array
    {
        return [
            'name' => 'PT Contoh Mitra',
            'slug' => 'pt-contoh-mitra',
            'short_name' => 'Contoh Mitra',
            'sector' => 'Teknologi',
            'city' => 'Surabaya',
            'description' => 'Deskripsi mitra.',
            'logo_color' => '#123456',
            'logo_text' => 'CM',
            'is_mou_active' => true,
        ];
    }
}
```

Note: Task ini butuh factory `LowonganFactory` yang belum ada.Buat sekarang juga — buat file persis seperti di bawah ini, lalu ulangi Step 2:

Create `database/factories/LowonganFactory.php`:

```php
<?php

namespace Database\Factories;

use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Lowongan>
 */
class LowonganFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = fake()->company();

        return [
            'company_name' => $company,
            'company_short' => fake()->companySuffix(),
            'is_mitra_dudi' => true,
            'title' => fake()->jobTitle(),
            'slug' => Str::slug($company.'-'.fake()->unique()->numberBetween(1, 999999)),
            'location' => 'Surabaya, Jatim',
            'duration' => '6 Bulan',
            'jurusan' => 'RPL',
            'kuota' => fake()->numberBetween(1, 5),
            'metode_kerja' => 'On-site (Surabaya)',
            'jenis' => 'lowongan',
            'deskripsi' => fake()->paragraph(),
            'tanggung_jawab' => ['Mengerjakan tugas harian'],
            'kualifikasi' => ['Siswa aktif'],
            'dokumen' => [['name' => 'CV.pdf', 'desc' => 'Dokumen', 'type' => 'pdf']],
            'benefits' => ['Uang saku'],
            'batas_pendaftaran' => now()->addMonths(2)->toDateString(),
            'durasi_pelaksanaan' => '6 Bulan',
            'status_kuota' => 'Tersedia',
            'pokja_nama' => 'Pokja PKL',
            'pokja_koordinator' => 'Bpk. Uji',
            'pokja_wa' => '6281234567890',
            'logo_color' => '#1e3a5f',
        ];
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/DashboardTest.php`

Expected: FAIL — placeholder dashboard belum mengirim statistik, `assertSee('Total Lowongan')` gagal.

- [ ] **Step 3: Implement the dashboard controller**

Replace `app/Http/Controllers/Admin/DashboardController.php` with:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Artikel;
use App\Models\CalonSiswa;
use App\Models\Lowongan;
use App\Models\MagangApplication;
use App\Models\MitraPerusahaan;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('admin.dashboard', [
            'stats' => $this->statsFor($user),
            'recentLowongans' => $this->canSeePusatKarir($user)
                ? Lowongan::query()->latest()->limit(5)->get()
                : collect(),
            'recentArticles' => $this->canSeeContent($user)
                ? Artikel::query()->latest('published_at')->limit(5)->get()
                : collect(),
            'recentCalonSiswa' => $this->canSeeSpmb($user)
                ? CalonSiswa::query()->latest()->limit(5)->get()
                : collect(),
        ]);
    }

    /**
     * @return list<array{label: string, value: int, icon: string, tone: string}>
     */
    protected function statsFor(User $user): array
    {
        $stats = [];

        if ($this->canSeePusatKarir($user)) {
            $stats[] = [
                'label' => 'Total Lowongan',
                'value' => Lowongan::query()->count(),
                'icon' => 'briefcase',
                'tone' => 'blue',
            ];
            $stats[] = [
                'label' => 'Lamaran Menunggu',
                'value' => MagangApplication::query()->where('status', 'pending')->count(),
                'icon' => 'inbox',
                'tone' => 'amber',
            ];
            $stats[] = [
                'label' => 'Mitra DUDI',
                'value' => MitraPerusahaan::query()->count(),
                'icon' => 'building-2',
                'tone' => 'emerald',
            ];
            $stats[] = [
                'label' => 'Total Alumni',
                'value' => Alumni::query()->count(),
                'icon' => 'graduation-cap',
                'tone' => 'violet',
            ];
        }

        if ($this->canSeeContent($user)) {
            $stats[] = [
                'label' => 'Total Artikel',
                'value' => Artikel::query()->count(),
                'icon' => 'newspaper',
                'tone' => 'blue',
            ];
            $stats[] = [
                'label' => 'Total Webinar',
                'value' => Webinar::query()->count(),
                'icon' => 'video',
                'tone' => 'amber',
            ];
        }

        if ($this->canSeeSpmb($user)) {
            $stats[] = [
                'label' => 'Total Calon Siswa',
                'value' => CalonSiswa::query()->count(),
                'icon' => 'graduation-cap',
                'tone' => 'emerald',
            ];
        }

        return $stats;
    }

    protected function canSeePusatKarir(User $user): bool
    {
        return $user->hasRole([User::ROLE_BKK]);
    }

    protected function canSeeContent(User $user): bool
    {
        return $user->hasRole([User::ROLE_HUMAS]);
    }

    protected function canSeeSpmb(User $user): bool
    {
        return $user->hasRole([User::ROLE_SPMB]);
    }
}
```

- [ ] **Step 4: Render the stats**

Replace `resources/views/admin/dashboard.blade.php` with:

```blade
@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <p class="text-sm font-medium text-slate-500 mb-6">
        Ringkasan data sesuai cakupan akses Anda
        ({{ auth()->user()->roleLabel() }}).
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        @foreach ($stats as $stat)
            @php
                $tones = [
                    'blue' => 'bg-blue-50 text-blue-700',
                    'amber' => 'bg-amber-50 text-amber-700',
                    'emerald' => 'bg-emerald-50 text-emerald-700',
                    'violet' => 'bg-violet-50 text-violet-700',
                ];
                $tone = $tones[$stat['tone']] ?? $tones['blue'];
            @endphp

            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $stat['label'] }}</p>
                    <span class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 {{ $tone }}">
                        @switch($stat['icon'])
                            @case('briefcase')
                                <x-lucide-briefcase class="w-4 h-4" />
                            @break
                            @case('inbox')
                                <x-lucide-inbox class="w-4 h-4" />
                            @break
                            @case('building-2')
                                <x-lucide-building-2 class="w-4 h-4" />
                            @break
                            @case('graduation-cap')
                                <x-lucide-graduation-cap class="w-4 h-4" />
                            @break
                            @case('newspaper')
                                <x-lucide-newspaper class="w-4 h-4" />
                            @break
                            @case('video')
                                <x-lucide-video class="w-4 h-4" />
                            @break
                            @default
                                <x-lucide-circle class="w-4 h-4" />
                        @endswitch
                    </span>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-blue-700">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if ($recentLowongans->isNotEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-4">
                    Lowongan Terbaru
                </p>
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentLowongans as $lowongan)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <p class="text-sm font-bold text-slate-900">{{ $lowongan->title }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ $lowongan->company_name }} · {{ $lowongan->created_at?->format('d M Y') }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($recentArticles->isNotEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-4">
                    Artikel Terbaru
                </p>
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentArticles as $artikel)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <p class="text-sm font-bold text-slate-900">{{ $artikel->title }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ $artikel->kategori }} · {{ $artikel->published_at?->format('d M Y') }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($recentCalonSiswa->isNotEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-4">
                    Calon Siswa Terbaru
                </p>
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentCalonSiswa as $calonSiswa)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <p class="text-sm font-bold text-slate-900">{{ $calonSiswa->nama_lengkap }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ $calonSiswa->jurusan_pilihan }} · {{ $calonSiswa->created_at?->format('d M Y') }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
```

- [ ] **Step 5: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/DashboardTest.php`

Expected: PASS — 6 tests OK.

- [ ] **Step 6: Run the whole test suite to check for regressions**

Run: `php artisan test`

Expected: PASS — all tests OK, including the 5 pre-existing Feature tests.

- [ ] **Step 7: Commit**

```bash
git add app/Http/Controllers/Admin/DashboardController.php resources/views/admin/dashboard.blade.php database/factories/LowonganFactory.php tests/Feature/Admin/DashboardTest.php
git commit -m "feat: add role-scoped admin dashboard"
```

---

## Task 8: Seeder akun staff

**Files:**
- Create: `database/seeders/AdminUserSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php:16-31`
- Test: `tests/Feature/Admin/AdminUserSeederTest.php`

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/AdminUserSeederTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_one_account_per_role(): void
    {
        $this->seed(AdminUserSeeder::class);

        $this->assertDatabaseHas('users', ['email' => 'admin@smkn1.surabaya.sch.id', 'role' => 'admin']);
        $this->assertDatabaseHas('users', ['email' => 'bkk@smkn1.surabaya.sch.id', 'role' => 'bkk']);
        $this->assertDatabaseHas('users', ['email' => 'humas@smkn1.surabaya.sch.id', 'role' => 'humas']);
        $this->assertDatabaseHas('users', ['email' => 'spmb@smkn1.surabaya.sch.id', 'role' => 'spmb']);
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(AdminUserSeeder::class);
        $this->seed(AdminUserSeeder::class);

        $this->assertSame(4, User::query()->count());
    }

    public function test_seeded_account_can_authenticate(): void
    {
        $this->seed(AdminUserSeeder::class);

        $this->post(route('login.store'), [
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/AdminUserSeederTest.php`

Expected: FAIL — seeder belum ada.

- [ ] **Step 3: Create the seeder**

Create `database/seeders/AdminUserSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Administrator', 'email' => 'admin@smkn1.surabaya.sch.id', 'role' => User::ROLE_ADMIN],
            ['name' => 'BKK Pusat Karir', 'email' => 'bkk@smkn1.surabaya.sch.id', 'role' => User::ROLE_BKK],
            ['name' => 'Humas Sekolah', 'email' => 'humas@smkn1.surabaya.sch.id', 'role' => User::ROLE_HUMAS],
            ['name' => 'Panitia SPMB', 'email' => 'spmb@smkn1.surabaya.sch.id', 'role' => User::ROLE_SPMB],
        ];

        foreach ($accounts as $account) {
            User::query()->updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'role' => $account['role'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                ],
            );
        }
    }
}
```

- [ ] **Step 4: Wire it into DatabaseSeeder**

Replace the body of `DatabaseSeeder::run()` in `database/seeders/DatabaseSeeder.php` so it reads:

```php
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(MitraPerusahaanSeeder::class);
        $this->call(LowonganSeeder::class);
        $this->call(ArtikelSeeder::class);
        $this->call(WebinarSeeder::class);
        $this->call(BimbinganKarirSeeder::class);
        $this->call(CalonSiswaSeeder::class);
        $this->call(AlumniSeeder::class);
        $this->call(TracerSeeder::class);
        $this->call(ProdukBludSeeder::class);
    }
```

- [ ] **Step 5: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/AdminUserSeederTest.php`

Expected: PASS — 3 tests OK.

- [ ] **Step 6: Commit**

```bash
git add database/seeders/AdminUserSeeder.php database/seeders/DatabaseSeeder.php tests/Feature/Admin/AdminUserSeederTest.php
git commit -m "feat: seed one staff account per admin role"
```

---

## Task 9: Verifikasi manual & lint

**Files:**
- No new files. Verifikasi `php artisan test`, `php vendor/bin/pint --test`, dan login manual di browser.

- [ ] **Step 1: Run the full test suite**

Run: `php artisan test`

Expected: PASS — tidak ada kegagalan.

- [ ] **Step 2: Run Pint in check mode**

Run: `php vendor/bin/pint --test`

Expected: PASS — "All files pass the Pint code style check". Bila ada violation, jalankan `php vendor/bin/pint` lalu ulangi langkah ini.

- [ ] **Step 3: Run migrations on the development database**

Run: `php artisan migrate`

Expected: `INFO Running migrations.` termasuk `2026_10_01_140000_add_role_to_users_table ... DONE`.

- [ ] **Step 4: Seed staff accounts**

Run: `php artisan db:seed --class=AdminUserSeeder`

Expected: `INFO Seeding: Database\Seeders\AdminUserSeeder.` dan `INFO Seeding database completed successfully.`

- [ ] **Step 5: Build frontend assets**

Run: `npm run build`

Expected: `vite v8.x.x building for production...` selesai tanpa error.

- [ ] **Step 6: Verify the login page in a browser**

Jalankan `php artisan serve`, lalu buka `http://localhost:8000/login`.

Harus terlihat: logo, judul "Panel Admin", dua field (Email, Password), tombol "Masuk", link "← Kembali ke situs".

- [ ] **Step 7: Verify each role login and dashboard**

Login dengan password `password` dan cek tiap akun:

| Email | Yang harus terlihat di dashboard |
|---|---|
| `admin@smkn1.surabaya.sch.id` | Semua card: Total Lowongan, Lamaran Menunggu, Mitra DUDI, Total Alumni, Total Artikel, Total Webinar, Total Calon Siswa |
| `bkk@smkn1.surabaya.sch.id` | Hanya card Pusat Karir; tidak ada Total Artikel / Total Calon Siswa |
| `humas@smkn1.surabaya.sch.id` | Hanya Total Artikel + Total Webinar |
| `spmb@smkn1.surabaya.sch.id` | Hanya Total Calon Siswa |

Sidebar untuk BKK tidak boleh memuat "Pengguna"; untuk admin memuat "Dashboard" saja sampai modul Fase 2 ada.

- [ ] **Step 8: Verify guest is blocked**

Tanpa login, buka `http://localhost:8000/admin`.

Expected: redirect ke `/login`.

- [ ] **Step 9: Commit**

```bash
git add -A
git commit -m "chore: verify fase 1 admin foundation"
```

---

## Self-Review

**Spec coverage (Fase 1 sections only):**
- §2.1 kolom role enum → Task 1 ✓
- §2.2 auth login/logout + seeder akun → Task 4, Task 8 ✓
- §2.3 middleware `role` dengan admin bypass → Task 3 ✓
- §2.4 layout admin sidebar navy + topbar, route group `/admin` → Task 6 ✓
- §2.5 dashboard stat per role → Task 7 ✓
- §0 UI decisions (sidebar navy, light theme, halaman terpisah, `confirm()` native) → Task 6 ✓
- §2.1 tabel baru `gurus`/`struktur_organisasis`/`fasilitas`/`settings` → **ditunda ke Fase 3/4**; tidak ada modul yang memakainya di Fase 1.刻意 tidak dibuat sekarang (YAGNI).
- §5 security fixes → **ditunda** ke Fase 5 (spec menandainya sebagai task hardening tersendiri, bukan fondasi).

**Type consistency:** `hasRole(array)` dan `isAdmin()` didefinisikan sekali di Task 1, dipakai konsisten di Task 3 (`EnsureRole`), Task 5 (`AdminMenu`), Task 7 (`DashboardController`). `availableItemsFor()` (Task 5) dipakai di layout Task 6. `roleLabel()` didefinisisi di Task 1, dipakai di layout Task 6 dan dashboard Task 7. Semua konsisten.

**Placeholder scan:** Tidak ada TBD/TODO. Catatan `ponytail:` hanya muncul pada keputusan yang memang sengaja disederhanakan (inline color token di layout, test-only routes di `routes/testing.php`).

**Known scope note:** `routes/testing.php` sengaja dibuat terisolasi (hanya dimuat saat `runningUnitTests()`) agar route uji middleware tidak bocor ke produksi. Modul Fase 2–4 akan menambahkan route nyata dengan nama yang sama (`admin.lowongan.index` dst.), sehingga `AdminMenu` otomatis menampilkannya tanpa perubahan.
