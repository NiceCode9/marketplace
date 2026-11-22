# Juragan Material Clone — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a Laravel 13 + Inertia + React B2B construction-materials marketplace (single seller) with RFQ, UPO, simulation, and WA-based checkout.

**Architecture:** Monolith Laravel. Public pages via Inertia (React). Admin panel for CRUD + RFQ/quotation/UPO. Guest checkout (no buyer login). Simulation hybrid params (category default, product override).

**Tech Stack:** Laravel 13, PHP 8.3+, MySQL 8, Inertia 3, React 19, TypeScript, Tailwind 4, shadcn/ui (Laravel React starter kit), Laravel Fortify (auth), Redis (cache/session/queue), MySQL FULLTEXT.

**Spec:** `C:\Users\hayde\develop\marketplace-design.md`
**Schema:** `C:\Users\hayde\develop\marketplace-schema.sql`

## Global Constraints

- PHP >= 8.3, Laravel 13, MySQL 8, Node >= 20.
- Single seller (client). No multi-role (only admin).
- No payment gateway; checkout → WA link.
- Guest checkout allowed.
- Currency IDR, locale `id`, tz `Asia/Jakarta`.
- Pagination 24, default sort newest.
- Cart expires 30 days + cleanup job.
- Stock decrements on order `confirmed`; no oversell by default; backorder toggle per product.
- Variant price overrides product price; price snapshot at add-to-cart.
- Reviews: guest submit, admin moderation, rating 1–5, show approved only.
- Blog/FAQ: Markdown, draft/published.
- Settings typed accessor with seeded defaults.
- Admin email & WA number from `settings`.
- Delivery: fixed list (pickup/courier), shipping cost default 0, admin adjusts on confirm.
- `sim_units_per_pack` default 1 (avoid division by zero).
- `carts.session_id` unique.

## Review Focus

- Simulasi dengan input 0 atau negatif.
- Produk tanpa parameter simulasi (fallback kategori / none).
- Cart dengan varian stok habis.
- RFQ dengan produk campuran (simulatable + non-simulatable).
- Order number collision.
- Upload UPO (tipe/size validation).
- Guest checkout dengan data tidak lengkap.
- Quotation expired tidak bisa dikonversi.
- Partial accept quotation.
- Backorder toggle behavior.

---

## Phase 0: Environment Setup (user installs)

- [x] Install PHP 8.3+, Composer, Node 20+, MySQL 8, Redis (optional).
- [x] Create Laravel 13 project with React starter kit: `laravel new marketplace` (pilih React saat prompt) — sudah include auth (Fortify) + dashboard.
- [x] Atau: `laravel new marketplace --using=laravel/react-starter-kit` jika tersedia.
- [x] Configure `.env` (DB, mailtrap, app URL).
- [x] Run `php artisan migrate` (empty first) to verify.

## Phase 1: Database & Models

### Task 1: Migrations
- [x] Create migration files for all tables in `marketplace-schema.sql` (in dependency order).
- [x] Add `unit`, `allow_backorder` to products.
- [x] Add `quotation_items` table.
- [x] Add unique `carts.session_id`, CHECK rating 1–5, status indexes.
- [x] Run `php artisan migrate` and verify.

### Task 2: Eloquent Models
- [x] Create models: Category, Brand, Product, ProductVariant, ProductImage, ProductSpec, Cart, CartItem, Address, Order, OrderItem, Rfq, RfqItem, Quotation, QuotationItem, UpoUpload, Review, BlogPost, Faq, SimulationLog, Page, Setting.
- [x] Define relationships (hasMany, belongsTo, etc.).
- [x] Add scopes: `active`, `published`.
- [x] Add accessors for settings (typed).

### Task 3: Seeders
- [x] CategorySeeder (kategori bahan bangunan + sim defaults).
- [x] BrandSeeder.
- [x] ProductSeeder (contoh produk dengan sim params).
- [x] SettingSeeder (wa_number, admin_email, company_name, address, logo_url).
- [x] FaqSeeder.
- [x] Run `php artisan db:seed`.

## Phase 2: Auth & Admin Shell (starter kit sudah sediakan auth)

### Task 4: Customize Auth
- [x] Nonaktifkan `Features::registration()` di `config/fortify.php` (hanya admin).
- [x] Hapus referensi route registration di frontend (Wayfinder).
- [x] Tambah kolom `role` di users (migration) + middleware `admin`.
- [x] Seed admin user.

### Task 5: Admin Layout
- [x] Gunakan layout sidebar starter kit; sesuaikan navigasi admin: Dashboard, Produk, Kategori, Brand, Pesanan, RFQ, Quotation, UPO, Reviews, Blog, FAQ, Halaman, Simulasi, Settings.
- [x] Route `/admin` dashboard + stats (total produk, order baru, RFQ baru).

## Phase 3: Catalog (Public)

Catatan: halaman publik pakai React + Tailwind custom (tanpa shadcn) agar fleksibel.
Design acuan WAJIB: Stitch template di `docs/marketplace-public-page-design-template/`
(file code.html + screen.png per halaman) + design system di
`docs/marketplace-public-page-design-template/industrial_precision/DESIGN.md`
— konversi ke React + Tailwind.

### Task 6a: Tailwind Theme (Public Design Tokens)
- [ ] Baca semua `code.html` + `screen.png` di `docs/marketplace-public-page-design-template/` untuk memetakan struktur.
- [ ] Extend Tailwind config dengan token dari DESIGN.md (colors, fontFamily, borderRadius, spacing, boxShadow).
- [ ] Tambah Plus Jakarta Sans (Google Fonts) ke layout publik.
- [ ] Buat komponen base: Button, Card, Badge, Input, QuantitySelector, Calculator (inset) di `resources/js/components/public/`.

### Task 6: Categories & Brands
- [ ] Public routes: `/`, `/kategori`, `/kategori/{slug}`, `/brand`, `/brand/{slug}`.
- [ ] Controllers + Inertia pages.
- [ ] Category tree (parent/child).

### Task 7: Products
- [ ] Product list with filter/sort/pagination (MySQL FULLTEXT).
- [ ] Product detail page (varian, gambar, specs, reviews).
- [ ] Admin CRUD produk (form + validasi).

### Task 8: Search
- [ ] Search endpoint (FULLTEXT) with debounce on frontend.

## Phase 4: Cart & Checkout

### Task 9: Cart
- [ ] Cart service (session-based, guest).
- [ ] Add/update/remove items (Inertia partial reload).
- [ ] Cart page.

### Task 10: Checkout
- [ ] Checkout form (alamat, delivery method, notes).
- [ ] Generate order + order_items, status `sent_to_wa`.
- [ ] Generate WA link with order summary.
- [ ] Redirect to WA + show order confirmation page.

## Phase 5: RFQ & Quotation

### Task 11: RFQ
- [ ] RFQ form (public) + RFQ items (catalog + free-text).
- [ ] Admin RFQ list + detail.
- [ ] Email notification to admin (queue).

### Task 12: Quotation
- [ ] Admin create quotation from RFQ (itemized).
- [ ] Quotation status (draft/sent/accepted/rejected/expired).
- [ ] Generate PDF quotation (Laravel PDF).
- [ ] Convert accepted quotation → order.

### Task 13: UPO Upload
- [ ] Upload form (PDF/JPG/PNG, max 5MB).
- [ ] Admin verify/reject + note.

## Phase 6: Simulation

### Task 14: Simulation Backend
- [ ] SimulationService: calculate by sim_type (area/volume/weight/count).
- [ ] Hybrid params (product override → category fallback).
- [ ] Save to simulation_logs.
- [ ] Endpoint (Inertia or JSON) for live calc.

### Task 15: Simulation Frontend
- [ ] Simulator component on product detail & category.
- [ ] Input: luas total atau panjang × lebar.
- [ ] Output: jumlah unit, pack, estimasi biaya.
- [ ] Tombol "Gunakan jumlah ini" (prefill cart/RFQ).

### Task 16: Admin Simulation Params
- [ ] Form input sim_type, coverage, units_per_pack, waste, rounding per produk/kategori.

## Phase 7: Content & Admin

### Task 17: Reviews
- [ ] Guest submit review, admin moderation.

### Task 18: Blog & FAQ
- [ ] CRUD blog posts (Markdown), FAQ.

### Task 19: Settings
- [ ] Admin settings page (WA number, email, company info, logo).

### Task 19b: CMS Pages
- [ ] CRUD halaman statis (Tentang Kami, Hubungi Kami, Kebijakan Privasi, Syarat & Ketentuan).
- [ ] Route publik `/pages/{slug}`.

### Task 19d: Simulation Logs
- [ ] Halaman admin "Simulation Logs" (list + filter by produk/tanggal).

### Task 20: Dashboard
- [ ] Admin dashboard stats.

### Task 20b: Analytics (Fase 2)
- [ ] Laporan penjualan, RFQ, produk terlaris (deferred).

## Phase 8: Polish

### Task 21: SEO
- [ ] Meta tags, sitemap, schema.org product.

### Task 22: Image Optimization
- [ ] Thumb generation, webp.

### Task 23: Backup & Monitoring
- [ ] DB backup script, log monitoring.

## Execution Handoff

Plan saved to `C:\Users\hayde\develop\marketplace-plan.md`. Please review. Tech stack locked: Laravel 13 + Inertia + React + MySQL. VPS nanti.

Apakah plan ini sudah mencakup yang Anda inginkan? Jika ya, Anda bisa mulai Phase 0 (install Laravel) dan saya bantu task-by-task.