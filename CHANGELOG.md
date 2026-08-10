# Changelog

Format: [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)

## [1.0.0] — 2026-08-11 (In Development)

### Added
- **Design System**: Clean modern theme dengan brand identity (orange #F28B1E + charcoal #2D3436)
- **SCSS Modular**: 9 theme partials (tokens, base, sidebar, navbar, components, overlays, responsive, print, utilities)
- **Mobile-Responsive**: Card views untuk layar kecil, table views untuk desktop, sticky form actions
- **Bottom Navigation**: Role-aware bottom nav untuk mobile (8 role mappings)
- **Blade Components**: 13 reusable components (bottom-nav, empty-state, tooltip-help, panduan-button, loading-spinner, page-header, mobile-card, filter-panel, form-alert, pagination, sort-th, stat-card, snackbar)
- **Empty State**: 6 variasi SVG illustration (clipboard, search, egg, chicken, box, chart)
- **Walkthrough**: Shepherd.js guided tour untuk user baru dengan 4 steps
- **Panduan Button**: Trigger walkthrough dengan FAB positioning di mobile
- **has_seen_tour**: Migration untuk tracking tour completion per user
- **Print Styles**: Brand-consistent print stylesheet (A4, hide nav, proper tables)
- **Tooltip Help**: Pure JS tooltip component (4 positions, click-outside dismiss)
- **Error Pages**: Branded 403, 404, 419, 500, 503 pages dengan inline SVG dan pesan Indonesia
- **Favicon**: Chicken-on-egg SVG favicon sesuai brand colors
- **Indonesian Localization**: 155 validation messages + 50 UI strings + 4 lang files (auth, pagination, passwords, validation)
- **Database Indexes**: Performance indexes untuk 8 tabel (populasi_ayam, produksi_telur, pakan, telur, karantina)
- **SDLC Documentation**: BRD, PRD, DESIGN.md, ERD, PLAN.md (5 phase documents)
- **Project Infrastructure**: GitHub Project Board, Milestone, Labels, Slack channel (#proj-peternakan)

### Changed
- **Dashboard Layout**: Diintegrasikan dengan bottom-nav dan Shepherd.js tour
- **App Locale**: Diubah ke `id` (Indonesia) dengan faker locale `id_ID`
- **Vite Config**: Ditambahkan tour.js entry point

### Fixed
- **P0 Ambiguous Column**: Qualified column references di RekapanMingguanProduksiRepository (`xpa.tanggal`, `xpaq.umur`)
- **P0 Permission Typo**: `menu-rekapan-psroduksi` → `menu-rekapan-produksi` di config/adminlte.php
- **Misspelled Files**: `KemasanInventoryShowReposotory` → `Repository`, `PengadaanAyamSedeer` → `Seeder`
- **Broken Module Pages**: Placeholder pages diganti dengan dashboard layout

### Removed
- **Orphaned Views**: `vitamin-obat-minum/` (4 blade templates tanpa route/controller)

## [0.x] — 2025-01 to 2026-07 (Pre-Redesign)

### Added
- Initial Laravel 12 project setup
- AdminLTE integration via jeroennoten/laravel-adminlte
- nwidart/laravel-modules with 3 modules (Kandang, GudangPakan, GudangTelur)
- Spatie RBAC with 8 roles and 74+ permissions
- Full CRUD untuk: Kandang, Flock, Pipe, Strain
- Pengadaan Ayam (procurement) dengan distribusi per pipe
- Populasi Ayam v1 dan v2 (daily recording)
- Ayam Afkir (culling) management
- Karantina (quarantine) system
- Sampling Bobot Ayam (weight sampling)
- Treatment & monitoring kesehatan
- Perhitungan Pakan (feed calculation) & pemberian pakan
- Produksi Telur (egg production) recording
- Rekapan mingguan & harian (production reports)
- Bahan Pakan CRUD, formulasi, pembelian, inventory
- Pakan Pre-Mixing & Mixing
- Pakan Finished Good inventory & distribusi
- Opname untuk bahan pakan, pre-mixing, finished good
- Telur Masuk/Keluar management
- Telur Grading system
- Kemasan (packaging) input, output, inventory, opname
- Supplier management (GudangPakan & GudangTelur)
- Notification system
- User profile management
- Settings page
- Data import migration tools
- Staging deployment workflow (GitHub Actions)
