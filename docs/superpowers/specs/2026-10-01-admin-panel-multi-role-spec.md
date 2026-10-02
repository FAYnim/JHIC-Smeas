# Admin Panel Multi-Role — Spec

**Date**: 2026-10-01
**Status**: Approved
**Stack decision**: Custom Blade + Tailwind (no Filament, no spatie/permission). Role via enum column + role middleware.

## 0. UI Design Decisions (brainstormed & approved)

- **Layout**: Sidebar klasik — sidebar navy permanen kiri (menu difilter per role, dikelompokkan per domain), topbar putih (breadcrumb, nama user, logout), konten di kanan. Mobile = sidebar drawer.
- **Tema**: Light + Slate. Konten putih/`slate-50`, sidebar `#1e3a5f` (navy selaras situs sekolah), aksen biru `#2563eb`, card stat dengan angka besar biru. Full-light & dark mode ditolak.
- **Pola CRUD**: Halaman terpisah — create/edit full page (`/admin/lowongan/create`, dst), list paginated + search. Tidak pakai modal form.
- **Confirm hapus**: `confirm()` bawaan browser via `onclick`, satu baris, tanpa modal custom.

## Overview

Build a full back-office admin panel for JHIC-Smeas-v2. Currently zero auth routes, zero CRUD UI, all content mutated via seeders. This spec covers roles & auth, all admin modules grouped by role, and new tables needed to replace hardcoded view data.

## 1. Roles

Single `role` enum column on `users`. No permission granularity (YAGNI for 4 roles).

| Role | Slug | Scope |
|---|---|---|
| Super Admin | `admin` | Everything + user/role management + settings |
| BKK | `bkk` | Pusat karir: lowongan, lamaran, mitra DUDI, bimbingan karir, tracer/alumni |
| Humas | `humas` | Profil sekolah: guru & tendik, struktur organisasi, sarana prasarana, artikel, webinar, informasi |
| Panitia SPMB | `spmb` | Pendaftar calon siswa, verifikasi, pengumuman, FAQ |

Roles: `admin, bkk, humas, spmb` (values lowercase).

## 2. Foundation (Fase 1)

### 2.1 Migrations
- `add_role_to_users_table`: `role` enum('admin','bkk','humas','spmb') nullable after `password`. Default null = belum aktif.
- New tables (see per-module sections): `gurus`, `struktur_organisasis`, `fasilitas`, `settings`.
- `settings`: `key` (string, unique), `value` (text, nullable). Generic key-value.

### 2.2 Auth
- `GET /login` → view `auth.login` (single Blade, Tailwind, style konsisten dgn site).
- `POST /login` → standard session auth via `Auth::attempt`, redirect `/admin`. Failed → error inline.
- `POST /logout` → `Auth::logout()`, redirect `/`.
- Staff without role (role null) → login rejected: "Akun belum memiliki peran."
- Test users seeded: `admin@smkn1sby.sch.id` (admin), `bkk@smkn1sby.sch.id` (bkk), `humas@smkn1sby.sch.id` (humas), `spmb@smkn1sby.sch.id` (spmb) — password `password`.

### 2.3 Middleware
- Alias `role` in `bootstrap/app.php` → `app/Http/Middleware/EnsureRole.php`.
- Usage: `->middleware(['auth', 'role:admin,bkk'])` — passes if user role in args (admin passes everything implicit? No: admin must be listed explicitly or middleware auto-allows `admin`). **Decision: middleware auto-allows `admin` always.**

### 2.4 Admin layout
- `resources/views/admin/layout.blade.php`: sidebar (menu filtered by role), topbar (user name + logout), `@yield('content')`.
- Route group: `prefix('admin')`, name `admin.`, middleware `auth`.

### 2.5 Dashboard
- `GET /admin` → `DashboardController@index`. Cards: total per domain visible to user's role (lowongan count, lamaran pending count, mitra count, artikel count, calon siswa count, etc.) filtered by role scope. Recent items list (5 terbaru per domain utama role).

## 3. Modules (Fase 2–4)

All controllers in `app/Http/Controllers/Admin/`, views in `resources/views/admin/<module>/`. Standard pattern per module: `index` (paginated list + search), `create`/`store`, `edit`/`update`, `destroy`. FormRequest validation. Flash `session('success')`.

### Fase 2 — BKK
| Module | Model | Notes |
|---|---|---|
| Lowongan CRUD | `Lowongan` | Toggle publish (add `is_published` bool migration), upload logo file, slug auto. |
| Lamaran review | `MagangApplication` | Index + filter by status, update `status` (pending/accepted/rejected). |
| Mitra CRUD | `MitraPerusahaan` | Full CRUD, MoU fields, logo upload. |
| Bimbingan CRUD | `BimbinganKategori`, `BimbinganKarir` | CRUD both. **Wire** `pusat-karir.blade.php:853` `$bimbinganKatalog` to DB. |
| Tracer | `Alumni`, `KuesionerTracer`, `TracerSetting`, `TracerStatusLulusan`, `TracerMitraAlumnus` | Alumni CRUD, kuesioner list + konfirmasi toggle, settings single-form edit. |

### Fase 3 — Humas
| Module | Model | Notes |
|---|---|---|
| Guru & Tendik | NEW `Guru` (`nama, jabatan, kategori[guru|tendik], foto, urutan, is_active`) | Replace inline arrays in `guru-dan-tenaga-kependidikan.blade.php:116,159` with DB query. |
| Struktur Organisasi | NEW `StrukturOrganisasi` (`nama, jabatan, kategori[wakil|bagian], foto, urutan`) | Replace inline arrays `struktur-organisasi.blade.php:166,205`. |
| Sarana Prasarana | NEW `Fasilitas` (`nama, kategori[pembelajaran|pendukung], deskripsi, image_url, urutan`) | Replace inline arrays `sarana-dan-prasarana.blade.php:119,174`. |
| Artikel | `Artikel` | CRUD + image upload (replace `image_url` string input). |
| Webinar | `Webinar` | CRUD + `is_published` toggle. |

### Fase 4 — SPMB, BLUD, Admin
| Module | Model | Notes |
|---|---|---|
| Pendaftar SPMB | `CalonSiswa` | Index + filter jalur/jurusan/status, detail view, verifikasi status, list file dokumen dari `storage/app/public/spmb/{nisn}/`. |
| Pengumuman & FAQ SPMB | NEW `Pengumuman` (`judul, slug, konten, is_published`), NEW `Faq` (`pertanyaan, jawaban, urutan`) | Wire ke `spmb/dashboard/bantuan.blade.php` & `/spmb/pengumuman`. |
| Produk BLUD | `ProdukBlud` | Index + toggle `is_published`. |
| Moderasi BLUD | `ProdukBludKomentar`, `ProdukBludPenawaran`, `ProdukBludLaporkan` | List per produk, delete. |
| Users | `User` | CRUD + role select. Admin only. Tidak bisa hapus diri sendiri. |
| Settings | `Settings` | Single form: site name, kontak, alamat, sosmed. Admin only. Helper `Setting::get('key')`. |

## 4. File Upload

- Shared trait/concern `app/Http/Controllers/Admin/Concerns/HandlesUploads.php`: `upload(UploadedFile $file, string $dir): string` → store to `public` disk, return path. Validate mimes + max 2MB.
- Affected fields: `lowongans.logo_color`→ keep, add `logo_path`; `mitra_perusahaans.logo` (new); `artikels.image_path` (new alongside `image_url`); `gurus.foto`; `struktur_organisasis.foto`.
- Fallback: view renders `logo_path ?? image_url ?? initial-letter block` (existing `logo_color`/`logo_text` pattern).

## 5. Security Fixes (bundled)

1. `/jurusan/{slug}` — whitelist: `abort_unless(view()->exists("jurusan.{$slug}"), 404)`.
2. `/spmb/*` dashboard routes — add `EnsureSpmbSession` middleware checking `session('spmb_nisn')`, redirect to `/spmb/login`.
3. All admin routes behind `auth` + `role`.
4. CSRF + validation on every store/update (FormRequest).

## 6. Explicitly Out of Scope

- Activity log / audit trail (ponytail: add `spatie/laravel-activitylog` when needed).
- Soft deletes (data low-risk, seeders rebuildable).
- Media library, WYSIWYG editor (textarea plain for now).
- spatie/laravel-permission.

## 7. Testing

Per module feature tests (`tests/Feature/Admin/`): guest redirect to login, role blocked (403), role allowed, CRUD happy path, validation errors. Foundation tests: login success/fail/no-role, middleware role check, jurusan whitelist, SPMB session guard.

## 8. Conventions

PSR-12, Pint clean, 4 spaces, kebab-case views, dot route names (`admin.lowongan.index`), Indonesian UI text, lucide icons.
