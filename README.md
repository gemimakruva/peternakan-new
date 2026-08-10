# SPMS — Smart Poultry Management System

Sistem manajemen peternakan ayam petelur terintegrasi. Mengelola seluruh alur operasional mulai dari pengadaan ayam, monitoring populasi, perhitungan pakan, produksi telur, hingga inventori gudang.

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | AdminLTE 3.15 (Bootstrap 5) + Vite 7 |
| Modules | nwidart/laravel-modules v12 |
| RBAC | spatie/laravel-permission v6 |
| Database | SQLite (dev) / MySQL (prod) |
| Walkthrough | Shepherd.js |

## Modul

| Modul | Deskripsi |
|-------|-----------|
| **Kandang** | Populasi ayam, pengadaan, afkir, karantina, sampling, treatment, perhitungan pakan, produksi telur, rekapan |
| **GudangPakan** | Bahan pakan, formulasi, pre-mixing, mixing, finished good, inventori, opname |
| **GudangTelur** | Telur masuk/keluar, grading, kemasan, inventori, opname, supplier |

## User Roles (8 Roles)

| Role | Email | Password |
|------|-------|----------|
| Superadmin | superadmin@peternakan.com | password |
| Admin User | admin-user@peternakan.com | password |
| Manager Produksi | manager-produksi@peternakan.com | password |
| SPV Kandang | spv-kandang@peternakan.com | password |
| Petugas Kandang | petugas-kandang@peternakan.com | password |
| Dokter Hewan | dokter-hewan@peternakan.com | password |
| Petugas Gudang Telur | petugas-gudang-telur@peternakan.com | password |
| Petugas Gudang Pakan | petugas-gudang-pakan@peternakan.com | password |

## Prerequisites

- PHP 8.2+
- Composer 2
- Node.js 20+ & npm
- SQLite 3 (dev) atau MySQL 8 (prod)

## Instalasi

```bash
# Clone
git clone https://github.com/gemimakruva/peternakan-new.git
cd peternakan-new

# Dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database
touch database/database.sqlite
php artisan migrate --seed

# Build assets
npm run build

# Jalankan
php artisan serve
```

Akses di `http://localhost:8000`. Login dengan salah satu akun di atas.

## Struktur Proyek

```
├── app/                    # Core Laravel (Controllers, Models)
├── Modules/
│   ├── Kandang/            # Modul kandang & produksi
│   ├── GudangPakan/        # Modul gudang pakan
│   └── GudangTelur/        # Modul gudang telur
├── resources/
│   ├── views/
│   │   ├── components/     # Blade components (bottom-nav, empty-state, dll)
│   │   ├── layouts/        # Layout templates
│   │   └── errors/         # Halaman error kustom
│   ├── sass/
│   │   ├── theme/          # 9 SCSS partials (tokens, base, sidebar, dll)
│   │   └── _theme.scss     # Import hub
│   └── js/
│       └── tour.js         # Shepherd.js walkthrough
├── database/
│   ├── migrations/         # Schema migrations
│   └── seeders/            # Data seeder (users, permissions, master data)
├── docs/                   # SDLC documentation (BRD, PRD, DESIGN, ERD, PLAN)
└── lang/id/                # Lokalisasi Bahasa Indonesia
```

## Blade Components

| Component | Kegunaan |
|-----------|----------|
| `x-bottom-nav` | Navigasi bawah mobile (role-aware, 8 mapping) |
| `x-empty-state` | Placeholder untuk tabel kosong (6 variasi SVG) |
| `x-tooltip-help` | Tooltip bantuan dengan click toggle |
| `x-panduan-button` | Tombol panduan/walkthrough (Shepherd.js) |
| `x-loading-spinner` | Spinner loading overlay |
| `x-page-header` | Header halaman dengan breadcrumb |
| `x-mobile-card` | Card view untuk tampilan mobile |
| `x-filter-panel` | Panel filter collapsible |
| `x-form-alert` | Alert hasil aksi mutasi data |
| `x-pagination` | Link paginasi tabel |
| `x-sort-th` | Header kolom sortable |
| `x-stat-card` | Card statistik dashboard |

## Repository Pattern

```php
// Repository mengextend EloquentRepository
// Override: getQuery(), searchQuery(), customWhereQuery(), defaultOrder()
// Panggil: $repository->paginate() di controller
```

## Contributing

1. Buat branch dari `main`: `git checkout -b feature/nama-fitur`
2. Commit dengan conventional commits: `feat:`, `fix:`, `chore:`, `refactor:`
3. Push dan buat Pull Request ke `main`
4. Review wajib sebelum merge

## License

Proprietary — PT Makruva Technology. All rights reserved.
