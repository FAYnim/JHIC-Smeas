# Panel Manajemen BLUD Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Staf BLUD (role baru) bisa mengelola pesanan dan moderasi dengan alur status, catatan internal, dan dashboard sendiri.

**Architecture:** Tambah `ROLE_BLUD`, pindahkan route BLUD dari grup `role:admin` ke `role:blud` (admin tetap lolos karena `User::hasRole()` meloloskan admin). Tambah kolom status pada tabel penawaran, laporan, dan komentar. `PesananController` baru menangani penawaran. `ModerasiController` mendapat aksi tindak lanjut. Statistik BLUD masuk ke `DashboardController` yang ada.

**Tech Stack:** Laravel 13, Blade, Tailwind v4, lucide icons (`x-lucide-*`), PHPUnit, Pint.

**Catatan keputusan:** Menu "Dashboard BLUD" terpisah tidak dibuat. Role BLUD memakai Dashboard umum yang berisi statistik BLUD (diizinkan oleh spec: "atau memakai DashboardController yang diperluas").

Spec: `docs/superpowers/specs/2026-10-04-panel-blud-design.md`

---

## File Structure

| File | Aksi | Tanggung jawab |
|---|---|---|
| `database/migrations/2026_10_04_100000_add_blud_role_to_users_table.php` | Create | Ubah kolom `role` dari enum menjadi string |
| `database/migrations/2026_10_04_100100_add_status_to_blud_interaksi_tables.php` | Create | Kolom status, catatan, penanganan |
| `app/Models/User.php` | Modify | `ROLE_BLUD` dan label |
| `database/factories/UserFactory.php` | Modify | State `blud()` |
| `app/Http/Requests/Admin/StoreUserRequest.php`, `UpdateUserRequest.php` | Modify | Izinkan role `blud` |
| `app/Http/Controllers/Admin/UserController.php` | Modify | Daftar role (3 tempat) |
| `resources/views/admin/users/index.blade.php` | Modify | Warna badge role |
| `app/Models/ProdukBludPenawaran.php`, `ProdukBludLaporkan.php`, `ProdukBludKomentar.php` | Modify | Fillable, konstanta status, relasi `penangan` |
| `app/Support/AdminMenu.php` | Modify | Menu BLUD untuk role BLUD, tambah "Pesanan BLUD" |
| `routes/admin.php` | Modify | Grup `role:blud` |
| `app/Http/Requests/Admin/UpdatePesananBludRequest.php` | Create | Validasi status dan catatan |
| `app/Http/Requests/Admin/TindakLanjutBludRequest.php` | Create | Validasi catatan tindak lanjut |
| `app/Http/Controllers/Admin/Blud/PesananController.php` | Create | index, show, update, destroy |
| `resources/views/admin/blud/pesanan/index.blade.php`, `show.blade.php` | Create | Tampilan pesanan |
| `app/Http/Controllers/Admin/Blud/ModerasiController.php` | Modify | Aksi tindak lanjut, urutan, tautan penawaran |
| `resources/views/admin/blud/moderasi/index.blade.php` | Modify | Badge status dan tombol tindak lanjut |
| `app/Http/Controllers/Admin/DashboardController.php` | Modify | Statistik BLUD |
| `resources/views/admin/dashboard.blade.php` | Modify | Ikon `flag`, daftar BLUD |
| `tests/Feature/Admin/Blud/*` | Create/Modify | Test per task |

---

### Task 1: Role BLUD

**Files:**
- Create: `database/migrations/2026_10_04_100000_add_blud_role_to_users_table.php`
- Modify: `app/Models/User.php:26`, `app/Models/User.php:67`
- Modify: `database/factories/UserFactory.php` (setelah method `spmb()`)
- Modify: `app/Http/Requests/Admin/StoreUserRequest.php:21`, `UpdateUserRequest.php:23`
- Modify: `app/Http/Controllers/Admin/UserController.php:34-39`, `:46-51`, `:69-74`
- Modify: `resources/views/admin/users/index.blade.php:57`
- Test: `tests/Feature/Admin/Blud/BludRoleTest.php`

- [ ] **Step 1: Tulis test yang gagal**

```php
<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_blud_role_can_be_stored_and_has_label(): void
    {
        $user = User::factory()->blud()->create();

        $this->assertSame(User::ROLE_BLUD, $user->fresh()->role);
        $this->assertSame('Staf BLUD', $user->roleLabel());
    }

    public function test_admin_can_create_blud_user(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Staf BLUD',
            'email' => 'blud@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => User::ROLE_BLUD,
        ])->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['email' => 'blud@example.test', 'role' => 'blud']);
    }
}
```

- [ ] **Step 2: Jalankan, pastikan gagal**

Run: `php artisan test tests/Feature/Admin/Blud/BludRoleTest.php`
Expected: FAIL (`Undefined constant User::ROLE_BLUD` atau `blud()` tidak ada).

- [ ] **Step 3: Implementasi**

Migrasi `2026_10_04_100000_add_blud_role_to_users_table.php`:

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
            $table->string('role')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'bkk', 'humas', 'spmb'])->nullable()->change();
        });
    }
};
```

Cek dulu apakah kolom `role` di migrasi `2026_10_01_140000` nullable (lihat baris 12-13). Samakan nullability di `up()` dan `down()` dengan migrasi itu.

`User.php`: tambah setelah `ROLE_SPMB`:

```php
    public const ROLE_BLUD = 'blud';
```

dan di `roleLabel()` setelah baris SPMB:

```php
            self::ROLE_BLUD => 'Staf BLUD',
```

`UserFactory.php`: tambah method:

```php
    public function blud(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => User::ROLE_BLUD,
        ]);
    }
```

`StoreUserRequest.php:21` dan `UpdateUserRequest.php:23`: ganti array menjadi
`[User::ROLE_ADMIN, User::ROLE_BKK, User::ROLE_HUMAS, User::ROLE_SPMB, User::ROLE_BLUD]`.

`UserController.php`: pada ketiga array `$roles` tambahkan baris
`User::ROLE_BLUD => 'Staf BLUD',` setelah baris SPMB.

`users/index.blade.php:57`: tambahkan setelah baris SPMB:

```php
                            \App\Models\User::ROLE_BLUD => 'bg-amber-50 text-amber-700 border-amber-200',
```

- [ ] **Step 4: Jalankan test**

Run: `php artisan test tests/Feature/Admin/Blud/BludRoleTest.php tests/Feature/Admin/UserCrudTest.php`
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add database app resources tests
git commit -m "feat(blud): tambah role BLUD"
```

---

### Task 2: Kolom status, catatan, dan penanganan

**Files:**
- Create: `database/migrations/2026_10_04_100100_add_status_to_blud_interaksi_tables.php`
- Modify: `app/Models/ProdukBludPenawaran.php`, `ProdukBludLaporkan.php`, `ProdukBludKomentar.php`
- Test: `tests/Feature/Admin/Blud/BludStatusSchemaTest.php`

- [ ] **Step 1: Tulis test yang gagal**

```php
<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\ProdukBlud;
use App\Models\ProdukBludKomentar;
use App\Models\ProdukBludLaporkan;
use App\Models\ProdukBludPenawaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludStatusSchemaTest extends TestCase
{
    use RefreshDatabase;

    private function produk(): ProdukBlud
    {
        return ProdukBlud::create([
            'slug' => 'produk-status',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Produk Status',
            'jurusan_nama' => 'RPL',
            'jurusan_slug' => 'rpl',
            'deskripsi' => 'Deskripsi',
        ]);
    }

    public function test_new_records_default_to_baru(): void
    {
        $produk = $this->produk();

        $penawaran = ProdukBludPenawaran::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'A',
            'kontak' => '0812',
            'pesan' => 'Pesan',
        ]);
        $laporan = ProdukBludLaporkan::create([
            'produk_blud_id' => $produk->id,
            'kategori' => 'Spam',
            'deskripsi' => 'x',
        ]);
        $komentar = ProdukBludKomentar::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'B',
            'komentar' => 'Halo',
        ]);

        $this->assertSame('baru', $penawaran->fresh()->status);
        $this->assertSame('baru', $laporan->fresh()->status);
        $this->assertSame('baru', $komentar->fresh()->status);
    }
}
```

- [ ] **Step 2: Jalankan, pastikan gagal**

Run: `php artisan test tests/Feature/Admin/Blud/BludStatusSchemaTest.php`
Expected: FAIL (kolom `status` tidak ada).

- [ ] **Step 3: Implementasi**

Migrasi:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk_blud_penawarans', function (Blueprint $table) {
            $table->string('status')->default('baru')->after('pesan');
            $table->text('catatan_internal')->nullable()->after('status');
            $table->foreignId('ditangani_oleh')->nullable()->after('catatan_internal')
                ->constrained('users')->nullOnDelete();
        });

        foreach (['produk_blud_laporans', 'produk_blud_komentars'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('status')->default('baru');
                $table->text('catatan_internal')->nullable();
                $table->foreignId('ditangani_oleh')->nullable()
                    ->constrained('users')->nullOnDelete();
                $table->timestamp('ditangani_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['produk_blud_komentars', 'produk_blud_laporans'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('ditangani_oleh');
                $table->dropColumn(['status', 'catatan_internal', 'ditangani_at']);
            });
        }

        Schema::table('produk_blud_penawarans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ditangani_oleh');
            $table->dropColumn(['status', 'catatan_internal']);
        });
    }
};
```

`ProdukBludPenawaran.php`: tambah import `use App\Models\User;` tidak perlu (namespace sama). Ganti `$fillable` dan tambahkan konstanta dan relasi:

```php
    public const STATUS_BARU = 'baru';

    public const STATUS_DIHUBUNGI = 'dihubungi';

    public const STATUS_DIPROSES = 'diproses';

    public const STATUS_SELESAI = 'selesai';

    public const STATUS_BATAL = 'batal';

    public const STATUSES = [
        self::STATUS_BARU => 'Baru',
        self::STATUS_DIHUBUNGI => 'Dihubungi',
        self::STATUS_DIPROSES => 'Diproses',
        self::STATUS_SELESAI => 'Selesai',
        self::STATUS_BATAL => 'Batal',
    ];

    protected $fillable = [
        'produk_blud_id',
        'nama',
        'kontak',
        'pesan',
        'status',
        'catatan_internal',
        'ditangani_oleh',
    ];

    public function penangan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
```

`ProdukBludLaporkan.php` dan `ProdukBludKomentar.php`: tambahkan field `'status', 'catatan_internal', 'ditangani_oleh', 'ditangani_at'` ke `$fillable`, plus:

```php
    public const STATUS_BARU = 'baru';

    public const STATUS_DITINDAKLANJUTI = 'ditindaklanjuti';

    protected function casts(): array
    {
        return [
            'ditangani_at' => 'datetime',
        ];
    }

    public function penangan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
```

- [ ] **Step 4: Jalankan test**

Run: `php artisan test tests/Feature/Admin/Blud`
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add database app tests
git commit -m "feat(blud): status dan catatan pada pesanan, laporan, komentar"
```

---

### Task 3: Route, menu, dan akses role BLUD

**Files:**
- Modify: `routes/admin.php:77-84`
- Modify: `app/Support/AdminMenu.php:125-138`, `:25`
- Modify: `tests/Feature/Admin/Blud/ModerasiAdminTest.php:29-39`
- Modify: `tests/Feature/Admin/AdminMenuTest.php:16`
- Test: `tests/Feature/Admin/Blud/BludAccessTest.php`

- [ ] **Step 1: Tulis test yang gagal**

```php
<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\User;
use App\Support\AdminMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_blud_user_can_access_blud_pages_but_not_users(): void
    {
        $blud = User::factory()->blud()->create();

        $this->actingAs($blud)->get(route('admin.produk-blud.index'))->assertOk();
        $this->actingAs($blud)->get(route('admin.moderasi-blud.index'))->assertOk();
        $this->actingAs($blud)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($blud)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_blud_menu_contains_only_blud_and_dashboard(): void
    {
        $routes = array_column(AdminMenu::itemsFor(User::factory()->blud()->create()), 'route');

        $this->assertContains('admin.dashboard', $routes);
        $this->assertContains('admin.pesanan-blud.index', $routes);
        $this->assertContains('admin.produk-blud.index', $routes);
        $this->assertContains('admin.moderasi-blud.index', $routes);
        $this->assertNotContains('admin.users.index', $routes);
        $this->assertNotContains('admin.lowongan.index', $routes);
    }
}
```

Di `ModerasiAdminTest::test_only_admin_can_access_moderasi_blud` ubah nama menjadi `test_only_blud_staff_and_admin_can_access_moderasi_blud`. Assertion `spmbUser` forbidden tetap benar.

Di `AdminMenuTest.php:16` tambahkan `User::ROLE_BLUD` ke array role.

- [ ] **Step 2: Jalankan, pastikan gagal**

Run: `php artisan test tests/Feature/Admin/Blud/BludAccessTest.php`
Expected: FAIL (403 untuk blud, route `pesanan-blud.index` belum ada).

- [ ] **Step 3: Implementasi**

`AdminMenu.php:25`: tambahkan `User::ROLE_BLUD` ke roles item Dashboard.

Ganti dua item BLUD (baris 125-138) menjadi tiga item:

```php
        [
            'group' => 'BLUD',
            'label' => 'Pesanan BLUD',
            'route' => 'admin.pesanan-blud.index',
            'icon' => 'shopping-cart',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BLUD],
        ],
        [
            'group' => 'BLUD',
            'label' => 'Produk BLUD',
            'route' => 'admin.produk-blud.index',
            'icon' => 'shopping-bag',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BLUD],
        ],
        [
            'group' => 'BLUD',
            'label' => 'Moderasi BLUD',
            'route' => 'admin.moderasi-blud.index',
            'icon' => 'flag',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BLUD],
        ],
```

Cek apakah sidebar (`resources/views/admin/layout.blade.php` atau partial) memetakan nama ikon ke komponen. Jalankan `grep -rn "shopping-bag" resources/views/admin` dan tambahkan `shopping-cart` jika ada mapping.

`routes/admin.php`: tambahkan import `use App\Http\Controllers\Admin\Blud\PesananController;` (urut alfabet setelah `ModerasiController`). Ganti blok BLUD di grup admin (baris 78-84) menjadi grup terpisah sebelum `role:admin`:

```php
Route::middleware('role:blud')->group(function () {
    Route::get('produk-blud', [ProdukBludController::class, 'index'])->name('produk-blud.index');
    Route::patch('produk-blud/{produkBlud}/toggle-publish', [ProdukBludController::class, 'togglePublish'])->name('produk-blud.toggle-publish');

    Route::get('pesanan-blud', [PesananController::class, 'index'])->name('pesanan-blud.index');
    Route::get('pesanan-blud/{pesanan}', [PesananController::class, 'show'])->name('pesanan-blud.show');
    Route::patch('pesanan-blud/{pesanan}', [PesananController::class, 'update'])->name('pesanan-blud.update');
    Route::delete('pesanan-blud/{pesanan}', [PesananController::class, 'destroy'])->name('pesanan-blud.destroy');

    Route::get('moderasi-blud', [ModerasiController::class, 'index'])->name('moderasi-blud.index');
    Route::patch('moderasi-blud/komentar/{komentar}/tindak-lanjut', [ModerasiController::class, 'tindakLanjutKomentar'])->name('moderasi-blud.tindak-lanjut-komentar');
    Route::patch('moderasi-blud/laporan/{laporan}/tindak-lanjut', [ModerasiController::class, 'tindakLanjutLaporan'])->name('moderasi-blud.tindak-lanjut-laporan');
    Route::delete('moderasi-blud/komentar/{komentar}', [ModerasiController::class, 'destroyKomentar'])->name('moderasi-blud.destroy-komentar');
    Route::delete('moderasi-blud/laporan/{laporan}', [ModerasiController::class, 'destroyLaporan'])->name('moderasi-blud.destroy-laporan');
});
```

Hapus route `moderasi-blud/penawaran/{penawaran}` (dipindah ke Pesanan) dan hapus metode `destroyPenawaran` di Task 5. Route binding parameter `{pesanan}` harus memetakan ke `ProdukBludPenawaran`: di controller (Task 4) type-hint parameter bernama `$pesanan` dengan `ProdukBludPenawaran` sudah cukup untuk implicit binding.

Hapus test `test_admin_can_view_and_delete_penawaran` dari `ModerasiAdminTest` (dipindah ke Task 4).

- [ ] **Step 4: Tahan test Pesanan sampai Task 4**

Route Pesanan menunjuk ke controller yang belum ada, jadi buat dulu stub controller kosong di Task 4 Step 3 sebelum menjalankan test. Urutkan: kerjakan Task 3 dan Task 4 Step 1-3 berurutan, lalu jalankan:

Run: `php artisan test tests/Feature/Admin/Blud tests/Feature/Admin/AdminMenuTest.php`
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add routes app tests
git commit -m "feat(blud): akses role BLUD, menu, dan route pesanan"
```

---

### Task 4: Pesanan BLUD

**Files:**
- Create: `app/Http/Requests/Admin/UpdatePesananBludRequest.php`
- Create: `app/Http/Controllers/Admin/Blud/PesananController.php`
- Create: `resources/views/admin/blud/pesanan/index.blade.php`, `show.blade.php`
- Test: `tests/Feature/Admin/Blud/PesananAdminTest.php`

- [ ] **Step 1: Tulis test yang gagal**

```php
<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\ProdukBlud;
use App\Models\ProdukBludPenawaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PesananAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $blud;

    private ProdukBludPenawaran $pesanan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blud = User::factory()->blud()->create();

        $produk = ProdukBlud::create([
            'slug' => 'produk-pesanan',
            'tipe' => ProdukBlud::TIPE_KUSTOM,
            'title' => 'Kaos Kustom',
            'jurusan_nama' => 'DKV',
            'jurusan_slug' => 'dkv',
            'deskripsi' => 'Deskripsi',
        ]);

        $this->pesanan = ProdukBludPenawaran::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'Budi Client',
            'kontak' => '0812345678',
            'pesan' => 'Saya ingin pesan 50 kaos',
        ]);
    }

    public function test_guest_and_other_roles_cannot_access(): void
    {
        $this->get(route('admin.pesanan-blud.index'))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->spmb()->create())
            ->get(route('admin.pesanan-blud.index'))
            ->assertForbidden();
    }

    public function test_index_lists_and_filters_by_status(): void
    {
        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.index'))
            ->assertOk()
            ->assertSee('Budi Client');

        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.index', ['status' => 'selesai']))
            ->assertOk()
            ->assertDontSee('Budi Client');
    }

    public function test_index_can_search_by_name(): void
    {
        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.index', ['q' => 'Budi']))
            ->assertOk()
            ->assertSee('Budi Client');

        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.index', ['q' => 'tidak-ada']))
            ->assertDontSee('Budi Client');
    }

    public function test_show_displays_whatsapp_link(): void
    {
        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.show', $this->pesanan))
            ->assertOk()
            ->assertSee('https://wa.me/62812345678', false);
    }

    public function test_update_changes_status_note_and_handler(): void
    {
        $this->actingAs($this->blud)
            ->patch(route('admin.pesanan-blud.update', $this->pesanan), [
                'status' => 'dihubungi',
                'catatan_internal' => 'Sudah dihubungi via WA',
            ])
            ->assertRedirect(route('admin.pesanan-blud.show', $this->pesanan));

        $this->assertDatabaseHas('produk_blud_penawarans', [
            'id' => $this->pesanan->id,
            'status' => 'dihubungi',
            'catatan_internal' => 'Sudah dihubungi via WA',
            'ditangani_oleh' => $this->blud->id,
        ]);
    }

    public function test_update_rejects_invalid_status(): void
    {
        $this->actingAs($this->blud)
            ->patch(route('admin.pesanan-blud.update', $this->pesanan), ['status' => 'ngawur'])
            ->assertSessionHasErrors('status');
    }

    public function test_destroy_removes_pesanan(): void
    {
        $this->actingAs($this->blud)
            ->delete(route('admin.pesanan-blud.destroy', $this->pesanan))
            ->assertRedirect(route('admin.pesanan-blud.index'));

        $this->assertDatabaseMissing('produk_blud_penawarans', ['id' => $this->pesanan->id]);
    }
}
```

- [ ] **Step 2: Jalankan, pastikan gagal**

Run: `php artisan test tests/Feature/Admin/Blud/PesananAdminTest.php`
Expected: FAIL (controller belum ada).

- [ ] **Step 3: Implementasi**

`UpdatePesananBludRequest.php`:

```php
<?php

namespace App\Http\Requests\Admin;

use App\Models\ProdukBludPenawaran;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePesananBludRequest extends FormRequest
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
            'status' => ['required', Rule::in(array_keys(ProdukBludPenawaran::STATUSES))],
            'catatan_internal' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
```

`PesananController.php`:

```php
<?php

namespace App\Http\Controllers\Admin\Blud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePesananBludRequest;
use App\Models\ProdukBludPenawaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q', ''));

        $pesanans = ProdukBludPenawaran::with('produk')
            ->when(
                array_key_exists((string) $status, ProdukBludPenawaran::STATUSES),
                fn ($query) => $query->where('status', $status),
            )
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('nama', 'like', "%{$search}%")
                        ->orWhere('kontak', 'like', "%{$search}%")
                        ->orWhere('pesan', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = ProdukBludPenawaran::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.blud.pesanan.index', [
            'pesanans' => $pesanans,
            'statuses' => ProdukBludPenawaran::STATUSES,
            'counts' => $counts,
            'status' => $status,
            'search' => $search,
        ]);
    }

    public function show(ProdukBludPenawaran $pesanan): View
    {
        $pesanan->load(['produk', 'penangan']);

        return view('admin.blud.pesanan.show', [
            'pesanan' => $pesanan,
            'statuses' => ProdukBludPenawaran::STATUSES,
            'waUrl' => $this->whatsappUrl($pesanan->kontak, $pesanan->nama),
        ]);
    }

    public function update(UpdatePesananBludRequest $request, ProdukBludPenawaran $pesanan): RedirectResponse
    {
        $pesanan->update([
            ...$request->validated(),
            'ditangani_oleh' => $request->user()->id,
        ]);

        return redirect()->route('admin.pesanan-blud.show', $pesanan)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(ProdukBludPenawaran $pesanan): RedirectResponse
    {
        $pesanan->delete();

        return redirect()->route('admin.pesanan-blud.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Bangun tautan wa.me dari kontak; null bila kontak bukan nomor telepon.
     */
    protected function whatsappUrl(string $kontak, string $nama): ?string
    {
        $digits = preg_replace('/\D+/', '', $kontak);

        if ($digits === '' || strlen($digits) < 8) {
            return null;
        }

        if (Str::startsWith($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        $text = rawurlencode("Halo {$nama}, kami dari BLUD SMKN 1 Surabaya menindaklanjuti pesanan Anda.");

        return "https://wa.me/{$digits}?text={$text}";
    }
}
```

Catatan: test `assertSee('https://wa.me/62812345678', false)` cocok karena URL diawali prefix itu diikuti `?text=`.

`index.blade.php` (ikuti gaya `moderasi/index.blade.php`): `@extends('admin.layout')`, title "Pesanan BLUD", form GET dengan input `q` dan `select status` (opsi "Semua" ditambah `$statuses`), baris chip hitungan per status dari `$counts`, tabel kolom Produk, Klien, Kontak, Pesan (`Str::limit($item->pesan, 80)`), Status (badge), Waktu, Aksi (tautan "Detail" ke `admin.pesanan-blud.show`), pesan flash `session('success')`, empty state "Belum ada pesanan.", dan `{{ $pesanans->links() }}`. Peta warna badge:

```blade
@php
    $badge = [
        'baru' => 'bg-blue-50 text-blue-700 border-blue-200',
        'dihubungi' => 'bg-amber-50 text-amber-700 border-amber-200',
        'diproses' => 'bg-violet-50 text-violet-700 border-violet-200',
        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'batal' => 'bg-slate-100 text-slate-600 border-slate-200',
    ];
@endphp
```

`show.blade.php`: kartu info (produk, klien, kontak, pesan, waktu, penangan terakhir `$pesanan->penangan?->name`), tombol WA `@if ($waUrl) <a href="{{ $waUrl }}" target="_blank" rel="noopener">…</a> @endif`, form `PATCH` ke `admin.pesanan-blud.update` berisi `select name="status"` (selected = `old('status', $pesanan->status)`) dan `textarea name="catatan_internal"`, tampilkan `@error`, tombol hapus dengan `confirm()`, dan tautan kembali ke index.

- [ ] **Step 4: Jalankan test**

Run: `php artisan test tests/Feature/Admin/Blud`
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add app resources tests
git commit -m "feat(blud): halaman pesanan dengan status dan catatan"
```

---

### Task 5: Tindak lanjut moderasi (laporan dan komentar)

**Files:**
- Create: `app/Http/Requests/Admin/TindakLanjutBludRequest.php`
- Modify: `app/Http/Controllers/Admin/Blud/ModerasiController.php`
- Modify: `resources/views/admin/blud/moderasi/index.blade.php`
- Modify: `tests/Feature/Admin/Blud/ModerasiAdminTest.php`

- [ ] **Step 1: Tulis test yang gagal**

Tambahkan ke `ModerasiAdminTest`:

```php
    public function test_blud_user_can_mark_laporan_as_handled_with_note(): void
    {
        $blud = User::factory()->blud()->create();
        $produk = ProdukBlud::create([
            'slug' => 'produk-sample-4',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Sample Produk 4',
            'jurusan_nama' => 'AK',
            'jurusan_slug' => 'ak',
            'deskripsi' => 'Deskripsi',
        ]);
        $laporan = ProdukBludLaporkan::create([
            'produk_blud_id' => $produk->id,
            'kategori' => 'Spam',
            'deskripsi' => 'x',
        ]);

        $this->actingAs($blud)
            ->patch(route('admin.moderasi-blud.tindak-lanjut-laporan', $laporan), [
                'catatan_internal' => 'Sudah diperiksa, produk aman.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('produk_blud_laporans', [
            'id' => $laporan->id,
            'status' => 'ditindaklanjuti',
            'catatan_internal' => 'Sudah diperiksa, produk aman.',
            'ditangani_oleh' => $blud->id,
        ]);
        $this->assertNotNull($laporan->fresh()->ditangani_at);
    }

    public function test_blud_user_can_mark_komentar_as_handled(): void
    {
        $blud = User::factory()->blud()->create();
        $produk = ProdukBlud::create([
            'slug' => 'produk-sample-5',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Sample Produk 5',
            'jurusan_nama' => 'AK',
            'jurusan_slug' => 'ak',
            'deskripsi' => 'Deskripsi',
        ]);
        $komentar = ProdukBludKomentar::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'Pengunjung',
            'komentar' => 'Bagus',
        ]);

        $this->actingAs($blud)
            ->patch(route('admin.moderasi-blud.tindak-lanjut-komentar', $komentar))
            ->assertRedirect();

        $this->assertSame('ditindaklanjuti', $komentar->fresh()->status);
    }

    public function test_unhandled_laporan_is_listed_first(): void
    {
        $produk = ProdukBlud::create([
            'slug' => 'produk-sample-6',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Sample Produk 6',
            'jurusan_nama' => 'AK',
            'jurusan_slug' => 'ak',
            'deskripsi' => 'Deskripsi',
        ]);
        ProdukBludLaporkan::create([
            'produk_blud_id' => $produk->id,
            'kategori' => 'Laporan Lama Selesai',
            'deskripsi' => 'x',
            'status' => 'ditindaklanjuti',
        ]);
        ProdukBludLaporkan::create([
            'produk_blud_id' => $produk->id,
            'kategori' => 'Laporan Baru Belum',
            'deskripsi' => 'x',
        ]);

        $this->actingAs($this->adminUser)
            ->get(route('admin.moderasi-blud.index', ['tab' => 'laporan']))
            ->assertSeeInOrder(['Laporan Baru Belum', 'Laporan Lama Selesai']);
    }
```

- [ ] **Step 2: Jalankan, pastikan gagal**

Run: `php artisan test tests/Feature/Admin/Blud/ModerasiAdminTest.php`
Expected: FAIL (route tindak lanjut belum ada controllernya).

- [ ] **Step 3: Implementasi**

`TindakLanjutBludRequest.php`:

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TindakLanjutBludRequest extends FormRequest
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
            'catatan_internal' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
```

`ModerasiController.php`: hapus metode `destroyPenawaran` dan import `ProdukBludPenawaran`. Tab `penawaran` dan hitungan penawaran dihapus, sisakan tab komentar dan laporan; `$counts` berisi `komentar` dan `laporan` (jumlah yang belum ditangani lebih berguna):

```php
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'komentar');

        $komentars = collect();
        $laporans = collect();

        if ($tab === 'laporan') {
            $laporans = ProdukBludLaporkan::with(['produk', 'penangan'])
                ->orderByRaw("status = 'baru' desc")
                ->latest()
                ->paginate(15)
                ->withQueryString();
        } else {
            $tab = 'komentar';
            $komentars = ProdukBludKomentar::with(['produk', 'penangan'])
                ->orderByRaw("status = 'baru' desc")
                ->latest()
                ->paginate(15)
                ->withQueryString();
        }

        $counts = [
            'komentar' => ProdukBludKomentar::where('status', ProdukBludKomentar::STATUS_BARU)->count(),
            'laporan' => ProdukBludLaporkan::where('status', ProdukBludLaporkan::STATUS_BARU)->count(),
        ];

        return view('admin.blud.moderasi.index', compact('tab', 'komentars', 'laporans', 'counts'));
    }

    public function tindakLanjutKomentar(TindakLanjutBludRequest $request, ProdukBludKomentar $komentar): RedirectResponse
    {
        $komentar->update([
            'status' => ProdukBludKomentar::STATUS_DITINDAKLANJUTI,
            'catatan_internal' => $request->validated('catatan_internal'),
            'ditangani_oleh' => $request->user()->id,
            'ditangani_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Komentar ditandai ditindaklanjuti.');
    }

    public function tindakLanjutLaporan(TindakLanjutBludRequest $request, ProdukBludLaporkan $laporan): RedirectResponse
    {
        $laporan->update([
            'status' => ProdukBludLaporkan::STATUS_DITINDAKLANJUTI,
            'catatan_internal' => $request->validated('catatan_internal'),
            'ditangani_oleh' => $request->user()->id,
            'ditangani_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan ditandai ditindaklanjuti.');
    }
```

Tambah `use App\Http\Requests\Admin\TindakLanjutBludRequest;` (urut alfabet). Pesan sukses destroy laporan diubah menjadi `'Laporan berhasil dihapus.'`.

Catatan SQLite/MySQL: `orderByRaw("status = 'baru' desc")` valid di keduanya.

`moderasi/index.blade.php`:
- Ganti tab "Penawaran & Pesanan" (baris 15-20) menjadi tautan ke `route('admin.pesanan-blud.index')` dengan teks "Pesanan BLUD" tanpa kondisi aktif.
- Badge hitungan: `$counts['komentar']` dan `$counts['laporan']` sekarang berarti "belum ditangani".
- Hapus seluruh blok `@elseif ($tab === 'penawaran') … ` (baris 96-148).
- Di tabel komentar dan laporan tambahkan kolom "Status" (badge: `baru` biru, `ditindaklanjuti` hijau, plus nama `$item->penangan?->name` dan catatan bila ada).
- Kolom aksi: bila `$item->status === 'baru'` tampilkan form kecil `PATCH` ke `admin.moderasi-blud.tindak-lanjut-komentar` (atau `-laporan`) dengan input `catatan_internal` opsional dan tombol "Tandai ditindaklanjuti"; tombol hapus lama tetap ada sebagai aksi sekunder. Perbarui `colspan` empty state (komentar 7, laporan 6).

- [ ] **Step 4: Jalankan test**

Run: `php artisan test tests/Feature/Admin/Blud`
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add app resources tests
git commit -m "feat(blud): tindak lanjut laporan dan komentar"
```

---

### Task 6: Statistik BLUD di dashboard

**Files:**
- Modify: `app/Http/Controllers/Admin/DashboardController.php`
- Modify: `resources/views/admin/dashboard.blade.php`
- Test: `tests/Feature/Admin/Blud/BludDashboardTest.php`

- [ ] **Step 1: Tulis test yang gagal**

```php
<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\ProdukBlud;
use App\Models\ProdukBludLaporkan;
use App\Models\ProdukBludPenawaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_blud_dashboard_shows_only_blud_stats(): void
    {
        $produk = ProdukBlud::create([
            'slug' => 'produk-dash',
            'tipe' => ProdukBlud::TIPE_KUSTOM,
            'title' => 'Produk Dash',
            'jurusan_nama' => 'DKV',
            'jurusan_slug' => 'dkv',
            'deskripsi' => 'Deskripsi',
        ]);
        ProdukBludPenawaran::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'Klien Dash',
            'kontak' => '0812',
            'pesan' => 'Pesan',
        ]);
        ProdukBludLaporkan::create([
            'produk_blud_id' => $produk->id,
            'kategori' => 'Spam Dash',
            'deskripsi' => 'x',
        ]);

        $this->actingAs(User::factory()->blud()->create())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Pesanan Baru')
            ->assertSee('Laporan Belum Ditangani')
            ->assertSee('Klien Dash')
            ->assertSee('Spam Dash')
            ->assertDontSee('Total Lowongan');
    }
}
```

Catatan: teks "Total Lowongan" harus tidak muncul untuk role BLUD. Tapi dashboard punya kartu statis "Lowongan/Mitra/Lamaran" (baris 12-25 view) yang memanggil `route('admin.lowongan.index')`; teksnya "Lowongan" bukan "Total Lowongan", jadi test lolos. Kartu statis tersebut tetap tampil untuk semua role, itu perilaku yang sudah ada dan di luar cakupan.

- [ ] **Step 2: Jalankan, pastikan gagal**

Run: `php artisan test tests/Feature/Admin/Blud/BludDashboardTest.php`
Expected: FAIL (tidak ada teks "Pesanan Baru").

- [ ] **Step 3: Implementasi**

`DashboardController.php`: tambah import `ProdukBludKomentar`, `ProdukBludLaporkan`, `ProdukBludPenawaran` (urut alfabet). Pada array view `index()` tambahkan:

```php
            'recentPesanans' => $this->canSeeBlud($user)
                ? ProdukBludPenawaran::with('produk')->where('status', ProdukBludPenawaran::STATUS_BARU)->latest()->limit(5)->get()
                : collect(),
            'pendingLaporans' => $this->canSeeBlud($user)
                ? ProdukBludLaporkan::with('produk')->where('status', ProdukBludLaporkan::STATUS_BARU)->latest()->limit(5)->get()
                : collect(),
```

Di `statsFor()`: hapus kartu "Produk BLUD" dari blok `isAdmin()` dan tambahkan blok sebelum `isAdmin()`:

```php
        if ($this->canSeeBlud($user)) {
            $stats[] = [
                'label' => 'Pesanan Baru',
                'value' => ProdukBludPenawaran::query()->where('status', ProdukBludPenawaran::STATUS_BARU)->count(),
                'icon' => 'shopping-cart',
                'tone' => 'amber',
            ];
            $stats[] = [
                'label' => 'Laporan Belum Ditangani',
                'value' => ProdukBludLaporkan::query()->where('status', ProdukBludLaporkan::STATUS_BARU)->count(),
                'icon' => 'flag',
                'tone' => 'violet',
            ];
            $stats[] = [
                'label' => 'Komentar Baru',
                'value' => ProdukBludKomentar::query()->where('status', ProdukBludKomentar::STATUS_BARU)->count(),
                'icon' => 'message-square',
                'tone' => 'emerald',
            ];
            $stats[] = [
                'label' => 'Total Produk',
                'value' => ProdukBlud::query()->count(),
                'icon' => 'shopping-bag',
                'tone' => 'blue',
            ];
        }
```

Tambah helper:

```php
    protected function canSeeBlud(User $user): bool
    {
        return $user->hasRole([User::ROLE_BLUD]);
    }
```

Karena `hasRole()` meloloskan admin, admin juga melihat statistik BLUD (perilaku sama dengan kartu BKK/Humas/SPMB di kode yang ada).

`dashboard.blade.php`: tambahkan di `@switch($stat['icon'])` sebelum `@default`:

```blade
                            @case('shopping-cart')
                                <x-lucide-shopping-cart class="w-4 h-4" />
                            @break
                            @case('flag')
                                <x-lucide-flag class="w-4 h-4" />
                            @break
                            @case('message-square')
                                <x-lucide-message-square class="w-4 h-4" />
                            @break
```

Tambahkan dua panel sebelum `</div>` penutup grid di baris 132, mengikuti gaya panel yang ada:

```blade
        @if ($recentPesanans->isNotEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-4">Pesanan Baru</p>
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentPesanans as $pesanan)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <a href="{{ route('admin.pesanan-blud.show', $pesanan) }}" class="block hover:text-blue-700">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $pesanan->nama }}</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">
                                    {{ $pesanan->produk?->title ?? '—' }} · {{ $pesanan->created_at?->format('d M Y') }}
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($pendingLaporans->isNotEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-4">Laporan Belum Ditangani</p>
                <ul class="divide-y divide-slate-100">
                    @foreach ($pendingLaporans as $laporan)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <a href="{{ route('admin.moderasi-blud.index', ['tab' => 'laporan']) }}" class="block hover:text-blue-700">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $laporan->kategori }}</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">
                                    {{ $laporan->produk?->title ?? '—' }} · {{ $laporan->created_at?->format('d M Y') }}
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
```

- [ ] **Step 4: Jalankan test**

Run: `php artisan test tests/Feature/Admin`
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add app resources tests
git commit -m "feat(blud): statistik dan daftar BLUD di dashboard"
```

---

### Task 7: Seeder, Pint, dan verifikasi akhir

**Files:**
- Modify: `database/seeders/AdminUserSeeder.php:17`

- [ ] **Step 1: Tambah akun seed**

Setelah baris SPMB tambahkan:

```php
            ['name' => 'Staf BLUD', 'email' => 'blud@smkn1.surabaya.sch.id', 'role' => User::ROLE_BLUD],
```

- [ ] **Step 2: Format kode**

Run: `php vendor/bin/pint --dirty`
Expected: file terformat, tanpa error.

- [ ] **Step 3: Jalankan seluruh test**

Run: `php artisan test`
Expected: semua PASS.

- [ ] **Step 4: Migrasi lokal (MySQL)**

Run: `php artisan migrate`
Expected: dua migrasi baru berjalan tanpa error. Perubahan enum ke string memakai `change()` bawaan Laravel 13, tanpa paket tambahan.

- [ ] **Step 5: Commit**

```bash
git add database
git commit -m "chore(blud): seed akun staf BLUD"
```

---

## Self-Review

**Spec coverage:**
- Role dan akses (spec 1): Task 1, 3, dan 6. Dashboard BLUD terpisah diganti statistik di dashboard umum (dicatat di header plan).
- Data (spec 2): Task 2. Tidak ada kolom JSON, jadi tidak ada default JSON.
- Tampilan: dashboard di Task 6, pesanan (filter, pencarian, WA, status, catatan) di Task 4, moderasi (badge, tombol, urutan, tautan pesanan) di Task 5.
- Kode (spec 4): `PesananController`, FormRequest, route, menu, dan Pint tercakup. `ModerasiController` kehilangan logika penawaran.
- Di luar cakupan (harga, pembayaran) tidak disentuh.

**Placeholder scan:** Tampilan `index.blade.php` dan `show.blade.php` Pesanan dijelaskan sebagai daftar komponen mengikuti pola `moderasi/index.blade.php`, bukan markup penuh. Implementer harus membuatnya mengikuti pola itu.

**Type consistency:** `ProdukBludPenawaran::STATUSES`, `STATUS_BARU`, dan relasi `penangan()` dipakai konsisten di Task 4 dan 6. Route name `pesanan-blud.*` dan `moderasi-blud.tindak-lanjut-{komentar,laporan}` dipakai konsisten di Task 3, 4, dan 5. Parameter route `{pesanan}`, `{komentar}`, `{laporan}` cocok dengan nama parameter controller.
