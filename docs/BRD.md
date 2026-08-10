# BRD — SPMS Peternakan UI/UX Redesign & Mobile

**Project**: SPMS Peternakan (Smart Poultry Management System)
**Class**: A — Production (Full governance, semua gate wajib, PR required, audit wajib)
**Repo Origin**: https://github.com/nazala-mafa/peternakan
**Repo Target**: https://github.com/gemimakruva/peternakan-new
**Date**: 2026-08-10
**Status**: Approved via Grilling (31 keputusan settled)

---

## 1. Business Context

SPMS Peternakan adalah sistem pengelolaan manajemen dan statistik peternakan ayam petelur. Aplikasi existing sudah functional tetapi memiliki masalah:
- Design system generik (AdminLTE default), tidak mencerminkan brand identity
- Tidak ada tampilan mobile — user peternakan di lapangan tidak bisa akses via HP
- Beberapa halaman error / data tampil salah
- Code quality issues (N+1 queries, missing validation, deprecated code)
- Tidak ada onboarding untuk user baru

## 2. Goals

| # | Goal | Metric |
|---|------|--------|
| G1 | Audit UI/UX (visual + fungsional) | Semua temuan audit ter-identifikasi dan ter-fix |
| G2 | Update design system ke brand identity | Orange/charcoal palette konsisten di seluruh app |
| G3 | Tampilan mobile responsive (gaptek-friendly) | Semua halaman usable di Android Chrome 360px width |
| G4 | Fix semua error (runtime + logic + code quality) | Zero crash, zero data salah, zero deprecation warning |
| G5 | Push ke GitHub untuk developer team full UAT | Developer bisa login semua role, test semua flow, test edge cases + security + performance |

## 3. Scope

### 3.1 In Scope

- **Design System Update** (Q2:B): Color + typography + component styling di atas AdminLTE
  - Brand palette: Orange (#F28B1E) / Charcoal (#2D3436) dari chicken-egg logo
  - Font: Inter (primary), system fallback
  - Component restyling: cards, buttons, tables, forms, badges, alerts, pagination
  - AdminLTE tetap sebagai fondasi structural

- **Mobile Responsive** (Q3:C): Large touch targets (48px min) + simplified views + onboarding
  - Table → card list conversion untuk mobile
  - Hide kolom non-essential di mobile
  - Bottom navigation bar, role-aware (Q12:B, Q17:B)
  - Progressive enhancement untuk browser lama (Q18:A)

- **Bottom Navigation Mapping** (Q23:A):

  | Role | Item 1 | Item 2 | Item 3 | Item 4 | Item 5 |
  |------|--------|--------|--------|--------|--------|
  | Superadmin | Dashboard | Kandang | Gudang Pakan | Gudang Telur | Menu |
  | Admin User | Dashboard | Users | Roles | Settings | Menu |
  | Manager Produksi | Dashboard | Rekapan | Populasi | Produksi Telur | Menu |
  | SPV Kandang | Dashboard | Populasi | Pakan | Produksi Telur | Menu |
  | Petugas Kandang | Dashboard | Populasi | Pakan | Sampling | Menu |
  | Dokter Hewan | Dashboard | Treatment | Monitoring | — | Menu |
  | Petugas Gudang Telur | Dashboard | Grading | Kemasan | Telur Inventory | Menu |
  | Petugas Gudang Pakan | Dashboard | Bahan Pakan | Mixing | Finished Good | Menu |

- **Onboarding & Guidance** (Q7:C):
  - Empty-state messages dengan SVG illustrations (unDraw/Storyset, Q21:A)
  - Contextual tooltips pada field/fitur complex
  - First-time walkthrough via Shepherd.js (Q14:A)
    - Scope: Dashboard + sidebar navigation saja (Q16:A)
    - Trigger: First login + tombol "Panduan" manual (Q15:B)

- **Error Fixing** (Q4:C): Runtime errors + logic bugs + code quality
  - Fix semua halaman crash/500
  - Fix data tampil salah (ambiguous column, kalkulasi keliru)
  - Fix N+1 queries, missing validation, deprecation warnings
  - Security: OWASP Top 10 basic check (Q8:A)

- **Performance** (Q9:B):
  - Page load target < 3 detik
  - Fix N+1 queries
  - Proper eager loading
  - Index database columns yang di-query

- **Branding** (Q20:C): Full brand kit
  - Logo chicken-egg pada sidebar/navbar
  - Favicon dari logo
  - Loading spinner branded
  - Custom SVG illustrations untuk empty states (unDraw)
  - Branded error pages: 404, 500, 403, 419, 503 (Q22:C)

- **Print Views** (Q28:B): Update print styling match brand baru

- **Code Cleanup** (Q29:B): Konsolidasi duplicate PopulasiAyam v1/v2

- **Bahasa** (Q27:A): Full Bahasa Indonesia — semua UI text, error messages, validation messages

- **Testing** (Q10:C, Q19:B): Comprehensive, delivery critical-first
  - Phase 1: Auth + permissions (semua role × semua route) + core business logic
  - Backlog: View/integration tests, edge cases

### 3.2 Out of Scope

- Fitur baru (hanya fix + improve existing)
- Database schema changes (kecuali index optimization)
- API development
- Arsitektur refactor (module structure tetap)
- Multi-tenancy
- Bilingual support (Indonesian only)

## 4. Users & Roles

8 roles dengan permission granular via Spatie:

| # | Role | Primary Workflow | Device |
|---|------|-----------------|--------|
| 1 | Superadmin | Full system access | Desktop + Mobile |
| 2 | Admin User | User & role management | Desktop |
| 3 | Manager Produksi | Rekapan, monitoring overview | Desktop + Mobile |
| 4 | SPV Kandang | Daily operations oversight | Desktop + Mobile |
| 5 | Petugas Kandang | Input populasi, pakan, sampling | **Mobile primary** |
| 6 | Dokter Hewan | Treatment, monitoring kesehatan | Mobile + Desktop |
| 7 | Petugas Gudang Telur | Grading, kemasan, inventory telur | Desktop + Mobile |
| 8 | Petugas Gudang Pakan | Bahan pakan, mixing, finished good | Desktop + Mobile |

## 5. Tech Stack

| Layer | Technology | Note |
|-------|-----------|------|
| Backend | Laravel 12 | PHP 8.2+ |
| Frontend | AdminLTE 3 (Bootstrap 5) | jeroennoten/laravel-adminlte v3.15 |
| Modules | nwidart/laravel-modules v12 | Kandang, GudangPakan, GudangTelur |
| Auth/RBAC | Spatie laravel-permission v6 | 8 roles, 74+ permissions |
| Build | Vite 7 + SCSS | dashboard.scss entry point |
| Testing | Pest 4 | pestphp/pest-plugin-laravel |
| Export | Maatwebsite Excel 3 | Report export |
| Walkthrough | Shepherd.js | To be added |

## 6. Browser Support (Q13:C + Q18:A — Progressive Enhancement)

| Tier | Browsers | Support Level |
|------|----------|---------------|
| Full | Chrome (Android + Desktop), Edge, Firefox, Safari | Semua fitur |
| Enhanced degradation | UC Browser, Android WebView | Core functional, no walkthrough/charts |
| Basic | Opera Mini | HTML + CSS only, no JS features |

## 7. Quality Standards

- **Security**: OWASP Top 10 basic (XSS, SQLi, CSRF, auth bypass, hardcoded secrets)
- **Performance**: Page load < 3s, no N+1, proper indexes
- **Tests**: Comprehensive (critical-first delivery)
- **Code Review**: Makruva standards (file < 300 lines, SoC, naming, security checklist)
- **Git**: GitHub Flow — main + feature/* branches, PR required (Q24:B)

## 8. UAT Requirements (Q5:C)

Developer team melakukan full UAT:
- Visual + functional + edge cases + security + performance
- Login semua 8 roles, test semua CRUD flows
- Local setup: clone → composer install → php artisan serve (Q11:A)
- Existing seed data dipakai (Q26:A)

## 9. Existing Code Decision (Q6:B)

Kode yang sudah ditulis sebelumnya (SCSS theme, blade components, mobile views) di-audit:
- Yang comply dengan Makruva standards → pertahankan
- Yang tidak comply → rework
- Full review di Phase 7 (Quality Gates)

## 10. Infrastructure

- **GitHub Repo**: gemimakruva/peternakan-new
- **GitHub Project Board**: https://github.com/users/gemimakruva/projects/3
- **Milestone**: v1.0 — UI/UX Redesign + Mobile
- **Slack Channel**: #proj-peternakan (to be created)
- **Git Workflow**: GitHub Flow (Q24:B)
- **Timeline**: Quality > speed, no fixed deadline (Q25:C)

## 11. Delivery Strategy

No fixed deadline. Quality-first approach:
1. Setiap phase di-complete secara thorough
2. Setiap gate di-pass sebelum lanjut
3. Semua update di-notify ke Slack + documented di GitHub
4. Developer UAT dimulai setelah Phase 8 (Deployment) complete

---

**Approved by**: Gemi (via Grilling session, 31 decisions settled)
**Date**: 2026-08-10
