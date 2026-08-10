# ARCHITECTURE — SPMS Peternakan

## System Overview

```
┌─────────────────────────────────────────────────────────┐
│                      Browser                            │
│  AdminLTE 3 + Bootstrap 5 + Vite 7 + Shepherd.js       │
└──────────────────────┬──────────────────────────────────┘
                       │ HTTP
┌──────────────────────▼──────────────────────────────────┐
│                   Laravel 12                            │
│  ┌─────────┐  ┌──────────┐  ┌───────────────┐          │
│  │ Routes  │→│Controllers│→│ Repositories   │          │
│  │ (web)   │  │          │  │ (EloquentRepo) │          │
│  └─────────┘  └──────────┘  └───────┬───────┘          │
│       │            │                │                   │
│  ┌────▼────┐  ┌────▼────┐   ┌──────▼──────┐           │
│  │Middleware│  │Services │   │   Models    │           │
│  │(Spatie) │  │         │   │ (Eloquent)  │           │
│  └─────────┘  └─────────┘   └──────┬──────┘           │
└─────────────────────────────────────┼───────────────────┘
                                      │
                              ┌───────▼───────┐
                              │  SQLite/MySQL  │
                              │   87 tables    │
                              └───────────────┘
```

## Module Structure

Menggunakan `nwidart/laravel-modules v12`. Setiap modul adalah Laravel app mandiri.

```
Modules/
├── Kandang/                    # Modul utama — produksi
│   ├── app/
│   │   ├── Http/Controllers/   # 25 controllers
│   │   ├── Models/             # Eloquent models
│   │   ├── Repositories/       # 40+ repositories
│   │   └── Services/           # Business logic
│   ├── resources/views/        # 120+ blade templates
│   ├── routes/web.php          # Module routes
│   └── config/config.php       # Module config + sidebar menu
│
├── GudangPakan/                # Gudang pakan
│   ├── app/
│   │   ├── Http/Controllers/   # 18 controllers
│   │   ├── Models/
│   │   └── Repositories/       # 18 repositories
│   ├── resources/views/        # 60+ blade templates
│   └── routes/web.php
│
└── GudangTelur/                # Gudang telur
    ├── app/
    │   ├── Http/Controllers/   # 14 controllers
    │   ├── Models/
    │   └── Repositories/       # 16 repositories
    ├── resources/views/        # 50+ blade templates
    └── routes/web.php
```

## Repository Pattern

Base class: `Modules\Kandang\Repositories\EloquentRepository`

```
EloquentRepository (abstract)
├── getQuery(): Builder          # Override untuk custom query + joins
├── searchQuery(q, search)       # Override untuk search behavior
├── customWhereQuery(): array    # Override untuk custom filters
├── defaultOrder(q)              # Override untuk default sorting
├── paginate(search, wheres, orders, perPage)  # Standard pagination
├── all(), find(), findBy()      # Standard CRUD reads
└── create(), update(), delete() # Standard CRUD writes
```

Domain repos extend base dan override `getQuery()` untuk complex joins:
- `RekapanProduksiRepository` — joins populasi_ayam, produksi_telur, pakan
- `BahanPakanInventoryRepository` — window functions untuk saldo running
- `TelurInventoryRepository` — subquery + window functions

## Permission System

Menggunakan `spatie/laravel-permission v6`.

**8 Roles** dengan 74+ permissions:

| Role | Scope | Jumlah Permission |
|------|-------|-------------------|
| Superadmin | Full access (semua modul) | All |
| Admin User | User & role management | 2 |
| Manager Produksi | Semua data kandang (read + write) | 20+ |
| SPV Kandang | Kandang operations | 15+ |
| Petugas Kandang | Input data harian | 10+ |
| Dokter Hewan | Treatment & monitoring | 5+ |
| Petugas Gudang Telur | Telur operations | 8+ |
| Petugas Gudang Pakan | Pakan operations | 10+ |

Permission naming: `module.feature.action`
Contoh: `kandang.populasi-ayam.menu-populasi-ayam`, `gudang-telur.telur-masuk.menu-telur-masuk`

Middleware: `can:permission.name` di setiap controller constructor.

## Frontend Architecture

### Layout

```
AdminLTE page (master.blade.php)
├── Navbar (top)
├── Sidebar (left, collapsible)
├── Content Wrapper
│   ├── Content Header (breadcrumb)
│   └── Content (yield)
├── Footer
└── Bottom Nav (mobile only, role-aware)
```

### SCSS Theme System

```
resources/sass/_theme.scss (import hub)
├── theme/_tokens.scss      # Design tokens: colors, surfaces, typography
├── theme/_base.scss         # Body, content-wrapper, content-header
├── theme/_sidebar.scss      # Sidebar navigation styles
├── theme/_navbar.scss       # Top navbar styles
├── theme/_components.scss   # Cards, tables, buttons, forms
├── theme/_overlays.scss     # Badges, alerts, pagination, select2, modals
├── theme/_responsive.scss   # Mobile/tablet/desktop breakpoints
├── theme/_print.scss        # Print-optimized styles
└── theme/_utilities.scss    # Helper classes, scrollbar
```

Brand colors:
- Primary: `#F28B1E` (orange)
- Primary Dark: `#D97706`
- Sidebar BG: `#2D3436` (charcoal)
- Body BG: `#FAF8F5` (warm white)

### Blade Components

13 reusable components di `resources/views/components/`:
- Navigation: `bottom-nav` (role-aware, 8 mappings)
- Data display: `empty-state`, `stat-card`, `mobile-card`
- Forms: `form-alert`, `filter-panel`, `sort-th`
- UX: `tooltip-help`, `panduan-button`, `loading-spinner`
- Layout: `page-header`, `pagination`, `snackbar`

### Build System

Vite 7 dengan entry points:
- `resources/sass/app.scss` — Full app styles
- `resources/sass/dashboard.scss` — Dashboard-specific
- `resources/js/app.js` — Core JS
- `resources/js/tour.js` — Shepherd.js walkthrough
- `resources/js/print-charts.js` — Print chart utilities

## Database

87 tables di SQLite (development). Tabel utama:

| Grup | Tabel | Keterangan |
|------|-------|------------|
| Core | users, roles, permissions, model_has_roles | Auth & RBAC |
| Kandang | kandang, flock, pipe, strain, strain_standart_mingguan | Master data kandang |
| Populasi | populasi_ayam, pengadaan_ayam, ayam_afkir, karantina_* | Lifecycle ayam |
| Pakan | perhitungan_pakan, pemberian_pakan_sisa_pakan | Kalkulasi pakan |
| Telur | produksi_telur, produksi_telur_item | Produksi harian |
| Gudang Pakan | bahan_pakan, bahan_pakan_inventory, pakan_mixing, pakan_* | Inventori pakan |
| Gudang Telur | telur_masuk, telur_keluar, telur_inventory, kemasan_* | Inventori telur |

Key indexes (performance-optimized):
- `populasi_ayam(kandang_id, tanggal)` — Rekapan queries
- `produksi_telur(kandang_id, tanggal)` — Production reports
- `bahan_pakan_inventory(tanggal)` — Inventory lookups

## Key Design Decisions

1. **Repository Pattern over direct Eloquent** — Encapsulates complex queries (window functions, multi-joins) dan memungkinkan standard pagination/search/filter via base class.

2. **Module-per-domain** — Setiap domain bisnis (Kandang, GudangPakan, GudangTelur) adalah Laravel module independen dengan routes, controllers, views, dan models sendiri.

3. **Role-aware UI** — Bottom nav, sidebar menu, dan akses halaman dikontrol per role. UI mobile-first dengan card views di layar kecil, table views di desktop.

4. **SCSS modular partials** — Theme dipecah jadi 9 partial files (max 200 baris per file) untuk maintainability. Semua warna via design tokens.

5. **Indonesian-first** — Semua UI text, validation messages, dan error pages dalam Bahasa Indonesia. Framework validation di-override via `lang/id/`.

6. **Guided onboarding** — Shepherd.js walkthrough untuk user baru dengan `has_seen_tour` flag di database.
