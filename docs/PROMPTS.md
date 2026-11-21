# Juragan Material Clone — Prompt Templates

Stack: Laravel 13 React starter kit (Inertia 3, React 19, TS, Tailwind 4,
shadcn/ui, Fortify auth), MySQL 8, single seller, B2B ringan, tanpa
payment gateway (checkout via WA), fitur simulasi material.

Dokumen acuan (di `docs/`):
- `docs/marketplace-design.md` — design & keputusan.
- `docs/marketplace-schema.sql` — schema DB.
- `docs/marketplace-plan.md` — plan task-by-task.
- `docs/marketplace-public-page-design-template/industrial_precision/DESIGN.md` — design system publik.
- `docs/marketplace-public-page-design-template/*/code.html` + `screen.png` — acuan halaman publik.

## Resume prompt (session baru)

Saya melanjutkan proyek marketplace B2B (Juragan Material clone) di folder
D:\Ilham\develop\marketplace. Baca docs/marketplace-design.md,
docs/marketplace-schema.sql, docs/marketplace-plan.md. Stack: Laravel 13
React starter kit (Inertia 3, React 19, TS, Tailwind 4, shadcn/ui, Fortify
auth), MySQL 8, single seller, B2B ringan, tanpa payment gateway (checkout
via WA), fitur simulasi material. Design publik mengacu ke
docs/marketplace-public-page-design-template/ (code.html + screen.png +
industrial_precision/DESIGN.md). Sudah install Laravel fresh. Mulai dari
Phase 0/1 yang belum selesai. Jangan coding di luar plan; ikuti task
checklist.

## Prompt per fase

- Phase 0 (env): "Setup .env, verifikasi migrate. Ikuti Phase 0 di plan."
- Phase 1 (DB): "Buat migration + model + seeder sesuai schema.sql. Task 1-3."
- Phase 2 (auth/admin): "Customize Fortify (nonaktifkan register publik) + admin layout + menu. Task 4-5."
- Phase 3 (katalog): "Tailwind theme publik + komponen base + kategori/brand/produk/search. Task 6a-8."
- Phase 4 (cart/checkout): "Cart session + checkout + WA link. Task 9-10."
- Phase 5 (RFQ): "RFQ form, quotation itemized + PDF, UPO upload. Task 11-13."
- Phase 6 (simulasi): "SimulationService + komponen React + admin params. Task 14-16."
- Phase 7 (konten): "Reviews, blog, FAQ, CMS pages, settings, dashboard. Task 17-20."
- Phase 8 (polish): "SEO, image optimization, backup. Task 21-23."

## Tips

- Sebutkan file plan/design agar agent baca dulu.
- Minta "jangan coding di luar plan" untuk menjaga scope.
- Jika ada perubahan keputusan, update design doc dulu (sumber kebenaran).
- Untuk UI publik, acuan wajib: docs/marketplace-public-page-design-template/.
