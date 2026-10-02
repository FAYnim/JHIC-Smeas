# BLUD Detail: Modal Minta Penawaran & Laporkan

**Date**: 2026-10-01
**Status**: Approved

## Overview

Add two modal-based forms to BLUD detail pages (showcase + kustom): "Minta Penawaran" (request offer) and "Laporkan" (report). Both currently exist as stub `alert()` buttons with no backend.

## Architecture

### Routes
- `POST /blud/{slug}/penawaran` → `BludController@storePenawaran` → name: `blud.penawaran.store`
- `POST /blud/{slug}/laporkan` → `BludController@storeLaporkan` → name: `blud.laporkan.store`
- Both with `throttle:10,1` middleware and `where('slug', '[a-z0-9\-]+')`

### Controller Methods
- `storePenawaran(Request $request, string $slug)` — validates input, creates record, redirects back with success message
- `storeLaporkan(Request $request, string $slug)` — validates input, creates record, redirects back with success message

### Models
- `ProdukBludPenawaran` — table `produk_blud_penawarans`
  - Columns: `id`, `produk_blud_id` (FK), `nama`, `kontak`, `pesan`, `created_at`, `updated_at`
  - Fillable: `produk_blud_id`, `nama`, `kontak`, `pesan`
- `ProdukBludLaporkan` — table `produk_blud_laporans`
  - Columns: `id`, `produk_blud_id` (FK), `kategori`, `deskripsi`, `created_at`, `updated_at`
  - Fillable: `produk_blud_id`, `kategori`, `deskripsi`

### Migrations
- `2026_10_01_130000_create_produk_blud_penawarans_table.php`
- `2026_10_01_130100_create_produk_blud_laporans_table.php`

## UI Design

### Modal Pattern (both modals)
- **Overlay**: `fixed inset-0`, `rgba(15,23,42,0.4)`, `backdrop-filter: blur(4px)`, `z-index: 100`, flex-centered
- **Card**: `max-w-md`, `width: 100%`, rounded-16px, padding 24px, white background
- **Animation**: fade-in + scale-up 200ms ease-out
- **Close**: X button (top-right), click outside overlay, Escape key
- **Form**: POST with `@csrf`, inline `@error` messages, submit button

### Modal Minta Penawaran
- **Trigger**: Existing "Minta Penawaran" button (replace `onclick="alert(...)"`)
- **Fields**:
  - `nama` — text input, required, max 80
  - `kontak` — text input (WA/email), required, max 100
  - `pesan` — textarea, required, max 2000, rows 4
- **Success**: `session('success', 'Permintaan penawaran Anda telah terkirim.')`

### Modal Laporkan
- **Trigger**: Existing "Laporkan" button (replace `onclick="alert(...)"`)
- **Fields**:
  - `kategori` — select, required, options: `Spam`, `Konten Tidak Pantas`, `Hak Cipta`, `Lainnya`
  - `deskripsi` — textarea, required, max 2000, rows 4
- **Success**: `session('success', 'Laporan Anda telah terkirim. Kami akan segera meninjau.')`

## Files to Create/Modify

### New Files
1. `resources/views/blud/partials/modal-penawaran.blade.php`
2. `resources/views/blud/partials/modal-laporkan.blade.php`
3. `app/Models/ProdukBludPenawaran.php`
4. `app/Models/ProdukBludLaporkan.php`
5. `database/migrations/2026_10_01_130000_create_produk_blud_penawarans_table.php`
6. `database/migrations/2026_10_01_130100_create_produk_blud_laporans_table.php`

### Modified Files
7. `resources/views/blud/partials/detail-css.blade.php` — add modal CSS
8. `resources/views/blud/detail-showcase.blade.php` — wire modals, include partials
9. `resources/views/blud/detail-kustom.blade.php` — wire modals, include partials
10. `app/Http/Controllers/BludController.php` — add `storePenawaran()` and `storeLaporkan()`
11. `routes/web.php` — add 2 routes

## Validation Rules

### Penawaran
- `nama`: `required|string|max:80`
- `kontak`: `required|string|max:100`
- `pesan`: `required|string|max:2000`

### Laporkan
- `kategori`: `required|in:Spam,Konten Tidak Pantas,Hak Cipta,Lainnya`
- `deskripsi`: `required|string|max:2000`

## Error Handling
- Validation errors shown inline via `@error` directive
- Success message shown via `session('success')` banner (existing pattern)
- 404 if produk slug not found (use `firstOrFail()`)

## Testing
- Feature test: submit penawaran form, assert database has record
- Feature test: submit laporkan form, assert database has record
- Feature test: validation errors on empty submit
- Feature test: modal appears on button click (if JS tested)

## Conventions
- Follow existing patterns: komentar form for inline validation, success-overlay for modal structure
- Use existing CSS classes where possible: `detail-btn-primary`, `detail-form-input`
- PSR-12, 4 spaces, short array syntax
- Indonesian language for UI text
