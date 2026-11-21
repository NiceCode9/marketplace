# Juragan Material Clone — Design Document

**Date:** 2026-11-22
**Status:** Draft for review
**Owner:** Client (B2B construction materials, single seller)

## 1. Intent & Why

Meniru model bisnis & alur website juraganmaterial.id (marketplace bahan bangunan)
untuk single seller (client sendiri), dengan ciri khas fitur **simulasi kebutuhan
material**. Tujuan: alat bantu jual beli B2B (kontraktor/proyek konstruksi)
dengan RFQ (request for quotation) dan tanpa payment gateway (konfirmasi via WA).

## 2. Goals

- Katalog produk bahan bangunan dengan kategori, brand, varian, stok.
- Pencarian & filter (kategori, brand, harga, sort).
- Keranjang + checkout → pesan WA (tanpa payment gateway).
- RFQ (request for quotation) untuk pembelian bulk/proyek.
- Upload PO (UPO) oleh buyer.
- Simulasi kebutuhan material (input luas/volume → jumlah unit + estimasi biaya).
- Admin panel (CRUD produk, order, RFQ, quotation, UPO, konten).

## 3. Non-Goals

- Multi-seller / marketplace dengan banyak toko.
- Payment gateway (Midtrans/Xendit) — tidak diminta client.
- Multi-role user (buyer login tidak wajib; guest checkout).
- Aplikasi mobile native (web responsive cukup).

## 4. Anti-Goals (yang akan membuat gagal walau teknis jalan)

- Simulasi yang tidak akurat (kurang unit → proyek kekurangan material).
- Checkout yang memaksa login (menghambat buyer B2B yang buru-buru).
- Admin panel yang tidak bisa mengatur parameter simulasi per produk/kategori.
- Halaman publik lambat (bundle besar, gambar tidak dioptimasi).

## 5. Constraints

- VPS berbayar (client setuju), domain satu-satunya biaya tambahan.
- Stack: Laravel 13 + Inertia.js + React, DB MySQL 8.
- Bahasa: PHP 8.3+, Node untuk build asset.
- Tanpa payment gateway; konfirmasi via WhatsApp.
- Single seller (client).

## 6. Tech Stack Decisions

- Backend: Laravel 13 (monolith), MySQL 8, Redis (cache/session/queue).
- Frontend: Laravel React starter kit (Inertia 3, React 19, TypeScript, Tailwind 4, shadcn/ui).
- Auth: Laravel Fortify (bawaan starter kit) — login, register, 2FA, email verification, password reset. Disesuaikan: nonaktifkan registration publik (hanya admin), tambah role admin via middleware.
- Queue: database driver (gratis, cukup untuk email notif).
- Storage: local (VPS) + symlink; opsional S3 nanti.
- Search: MySQL FULLTEXT (awal); Meilisearch jika perlu.
- Email: SMTP (Gmail/Mailtrap dev).
- WA: generate link `https://wa.me/<nomor>?text=<ringkasan>`.

## 7. Architecture Overview

Monolith Laravel (starter kit React). Routing via Laravel. Halaman render via Inertia (React).

### Frontend strategy
- **Admin panel**: gunakan shadcn/ui + Tailwind 4 (starter kit default) — cepat, konsisten.
- **Halaman publik**: React + Tailwind 4, **tanpa shadcn** — komponen custom agar lebih dinamis dan mudah dikustomisasi. Boleh pakai shadcn primitives bila perlu, tapi styling custom.
- Design publik **wajib** diimplementasikan berdasarkan template Stitch di
  `docs/marketplace-public-page-design-template/` (file `code.html` + `screen.png`
  per halaman) **dan** design system di
  `docs/marketplace-public-page-design-template/industrial_precision/DESIGN.md`.
  Template + DESIGN.md adalah acuan visual, struktur, dan token final, bukan
  sekadar inspirasi. Konversi ke komponen React + Tailwind.

### Design system publik: "Industrial Precision"
Sumber: `docs/marketplace-public-page-design-template/industrial_precision/DESIGN.md`.
- Font: Plus Jakarta Sans (semua role).
- Warna utama: primary safety orange `#EA580C`, secondary slate `#0F172A`, tertiary emerald `#10B981`, canvas `#F8FAFC`, surface `#FFFFFF`, border `#E2E8F0`, muted `#64748B`, amber warning `#F59E0B`.
- Rounded: 4px (0.25rem) default; badge 2px/pill.
- Shadow: sharp industrial (layered slate).
- Spacing: 4/8px scale; gutter 1.5rem (desktop), 0.75rem (mobile); margin 2rem/1rem.
- Grid: 12 kolom desktop, 4 kolom mobile; max container 1440px.
- Komponen: Material Card, Technical Badge, Material Volume Calculator (inset), Inputs 44px height, Buttons (primary/secondary/outline/destructive).

Token ini harus dimasukkan ke Tailwind config (theme extend) untuk halaman publik.

### Admin menu (sidebar)
Dashboard, Produk, Kategori, Brand, Pesanan, RFQ, Quotation, UPO, Reviews,
Blog, FAQ, Halaman (CMS), Simulasi (param + logs), Settings.
Analytics (fase 2).
- `routes/web.php` → Inertia pages (public + admin).
- `app/Models` → Eloquent.
- `app/Http/Controllers` → admin + public.
- `resources/js/pages` → React pages (starter kit lowercase).
- `resources/js/components` → komponen reusable (shadcn/ui di `components/ui`).
- `resources/js/layouts` → app + auth layouts (sidebar/header variants).
- `resources/js/hooks`, `lib`, `types` → starter kit conventions.
- `storage/app/public` → gambar produk (symlink ke public).
- Auth: Fortify (login, 2FA, email verification, password reset) — disesuaikan.

## 8. Flows

### 8.1 Buyer journey (B2C ringan)
Home → kategori/brand/search → detail produk → (simulasi) → tambah ke keranjang
→ cart → checkout (alamat, delivery, catatan) → kirim ringkasan ke WA → order tersimpan (status: sent_to_wa).

### 8.2 RFQ (B2B)
Form RFQ (nama, phone, email, perusahaan, catatan proyek, daftar produk+qty)
→ notifikasi admin (email) → admin balas quotation (manual via WA/email)
→ admin input quotation di panel → status quotation (draft/sent/accepted/rejected/expired)
→ jika accepted → konversi ke order.

### 8.3 UPO
Buyer upload PDF PO → admin verifikasi → order diproses.

### 8.4 Simulasi material
Input: luas total (m²) atau panjang × lebar.
Parameter produk: sim_type, coverage_per_unit, units_per_pack, waste_percent, rounding.
Rumus area: unit = ceil((luas × (1 + waste%)) / coverage_per_unit); pack = ceil(unit / units_per_pack).
Output: jumlah unit, jumlah pack, estimasi biaya. Tombol "Gunakan jumlah ini".

## 9. Simulation Feature Design

- Parameter simulasi disimpan di `products` (nullable) dengan fallback ke `categories`.
- Admin mengatur parameter per produk/kategori (hybrid).
- Produk non-simulatable: `sim_type = none`.
- Hasil simulasi disimpan ke `simulation_logs` (analitik).
- User bisa menyimpan "simulasi favorit" (opsional, fase 2).

## 10. Database Schema (ringkas)

Lihat file terpisah: `marketplace-schema.sql`.

Tabel utama: users (admin), categories, brands, products, product_variants,
product_images, product_specs, carts, cart_items, orders, order_items, rfqs,
rfq_items, quotations, quotation_items, upo_uploads, reviews, blog_posts, faqs,
simulation_logs, pages, settings.

## 11. Approved Decisions (dari diskusi)

1. Quotation: itemized (per produk + diskon volume), PDF di-generate sistem (Laravel PDF).
2. Simulasi: 4 tipe — `area`, `volume`, `weight`, `count` dengan rumus masing-masing; parameter hybrid (kategori default, override produk).
3. Ongkir: manual quote oleh admin.
4. Stok: per varian; total produk = sum varian; no oversell default, backorder toggle per produk.
5. RFQ entry: katalog + free-text (item custom).
6. Quotation→order: harga quotation menang; partial accept; expired tidak bisa dikonversi.
7. UPO: opsional, PDF/JPG/PNG max 5MB, admin verifikasi.
8. Status order: admin drive transisi; buyer cancel hanya draft/sent_to_wa.
9. Satuan: field `unit` (string) di products.
10. Data bisnis: seed di `settings`.

### Formula simulasi
- `area`: `ceil((luas × (1 + waste%)) / coverage_per_unit)`
- `volume`: `ceil((volume × (1 + waste%)) / volume_per_unit)`
- `weight`: `ceil((berat × (1 + waste%)) / weight_per_unit)`
- `count`: input langsung

Input: luas total (m²) ATAU panjang × lebar. Output: jumlah unit, jumlah pack, estimasi biaya.
Parameter: hybrid (kategori default → produk override); `sim_units_per_pack` default 1.

## 12. What's Left to the Builder

- Struktur folder detail & naming convention.
- Validasi form (Form Request).
- Komponen React reusable.
- Optimasi gambar (thumb, webp).
- SEO (meta, sitemap, schema.org).
- Backup & monitoring VPS.

## 13. Review Focus (input yang berpotensi memecah)

- Simulasi dengan input 0 atau negatif.
- Produk tanpa parameter simulasi (fallback ke kategori / none).
- Cart dengan varian stok habis.
- RFQ dengan produk campuran (simulatable + non-simulatable).
- Order number collision.
- Upload file UPO (tipe/size validation).
- Guest checkout dengan data tidak lengkap.
