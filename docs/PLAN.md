# PLAN.md — Implementation Plan

**Project**: SPMS Peternakan UI/UX Redesign & Mobile
**Phase**: 5 — Planning
**Date**: 2026-08-10
**References**: BRD.md, PRD.md, DESIGN.md, ERD.md

---

## Execution Strategy

32 tasks across 8 epics. Execution order follows dependency chain:
P0 bug fixes first → foundational components → template rollout → quality → docs.

Tasks within the same sprint group can be parallelized.

---

## Sprint 1: Critical Fixes (P0)

| # | Task | Size | Labels | Dependencies |
|---|------|------|--------|-------------|
| 1 | Fix ambiguous `tanggal` column in RekapanMingguanProduksiRepository | S | bug, critical | None |
| 2 | Fix permission typo `psroduksi` → `produksi` in adminlte.php | S | bug, critical | None |

**Parallelizable**: Yes — independent fixes.

---

## Sprint 2: Foundation — Design System & Localization (P1)

| # | Task | Size | Labels | Dependencies |
|---|------|------|--------|-------------|
| 3 | Split _theme.scss (884 lines) into modular partials | M | refactor | None |
| 5 | Create branded favicon from chicken-egg logo | S | feature | None |
| 6 | Create branded loading spinner component | S | feature | None |
| 17 | Create lang/id.json — Laravel validation messages in Indonesian | M | feature | None |
| 18 | Create lang/id/ directory (auth, pagination, passwords) | S | feature | None |
| 19 | Set app locale to 'id' + update hardcoded English strings | M | feature | 17, 18 |
| 21 | Add database indexes per ERD.md recommendations | S | refactor | None |
| 12 | Add has_seen_tour migration + "Panduan" button in navbar | S | feature | None |

**Parallelizable**: 3, 5, 6, 17, 18, 21, 12 can run in parallel. Task 19 waits for 17+18.

---

## Sprint 3: New Components (P1)

| # | Task | Size | Labels | Dependencies |
|---|------|------|--------|-------------|
| 4 | Create branded error pages (404, 500, 403, 419, 503) | M | feature | 3 (brand partials) |
| 7 | Update print styles (_print.scss) to match brand | S | feature | 3 |
| 8 | Build x-bottom-nav component (role-aware, 8 roles) | L | feature | 3 |
| 9 | Build x-empty-state component with unDraw SVG illustrations | M | feature | None |
| 10 | Build x-tooltip-help component (Alpine.js) | S | feature | None |
| 11 | Install Shepherd.js + build walkthrough system | L | feature | 12 (migration) |

**Parallelizable**: 4, 7, 8, 9, 10 can run in parallel. Task 11 waits for 12.

---

## Sprint 4: Template Rollout (P2)

| # | Task | Size | Labels | Dependencies |
|---|------|------|--------|-------------|
| 13 | Add x-page-header to 44 missing Kandang views | L | feature | None |
| 14 | Add mobile card views to 11 missing show views | M | feature | None |
| 15 | Add x-filter-panel to ~9 missing index views | S | feature | None |
| 16 | Apply x-empty-state to all ~55 index views | L | feature | 9 (component) |

**Parallelizable**: 13, 14, 15 can run in parallel. Task 16 waits for 9.

---

## Sprint 5: Code Quality & Performance (P2)

| # | Task | Size | Labels | Dependencies |
|---|------|------|--------|-------------|
| 20 | Fix N+1 queries across ~30 controller methods | L | refactor | None |
| 22 | Consolidate PopulasiAyam v1/v2 | M | refactor | None |
| 23 | Fix misspelled files (Repository, Seeder) | S | chore | None |
| 24 | Remove orphaned vitamin-obat-minum views | S | chore | None |
| 25 | Fix all unqualified column references in repositories | M | bug | 1 |

**Parallelizable**: 20, 22, 23, 24 can run in parallel. Task 25 extends task 1.

---

## Sprint 6: Testing (P2, critical-first)

| # | Task | Size | Labels | Dependencies |
|---|------|------|--------|-------------|
| 26 | Write permission matrix tests (8 roles × all routes) | XL | feature, quality | Sprints 1-5 |
| 27 | Write auth tests (login, logout, password reset) | M | feature, quality | None |
| 28 | Write business logic tests (populasi, pakan, telur, rekapan) | L | feature, quality | 1, 25 |
| 29 | Write CRUD feature tests for critical modules | L | feature, quality | None |

**Parallelizable**: 27, 29 can start early. 26, 28 wait for bug fixes.

---

## Sprint 7: Documentation & Handover (P3)

| # | Task | Size | Labels | Dependencies |
|---|------|------|--------|-------------|
| 30 | Update README.md with UAT setup instructions | M | docs | All dev done |
| 31 | Generate ARCHITECTURE.md | M | docs | All dev done |
| 32 | Generate CHANGELOG.md | S | docs | All dev done |

**Parallelizable**: All three can run in parallel after development completes.

---

## Dependency Graph

```
Sprint 1 (P0 bugs)
  ├── #1 Fix ambiguous column ──► #25 Fix all unqualified columns ──► #28 Business logic tests
  └── #2 Fix permission typo
  
Sprint 2 (Foundation)
  ├── #3 Split theme.scss ──► #4 Error pages
  │                       ──► #7 Print styles
  │                       ──► #8 Bottom nav
  ├── #5 Favicon
  ├── #6 Loading spinner
  ├── #12 Tour migration ──► #11 Shepherd.js walkthrough
  ├── #17 lang/id.json ──┐
  ├── #18 lang/id/ ──────┴► #19 Set locale + update strings
  └── #21 DB indexes

Sprint 3 (Components)
  ├── #9 Empty state component ──► #16 Apply to 55 views
  ├── #10 Tooltip component
  └── #11 Walkthrough system

Sprint 4 (Templates)
  ├── #13 Page headers (44 views)
  ├── #14 Mobile cards (11 views)
  ├── #15 Filter panels (9 views)
  └── #16 Empty states (55 views)

Sprint 5 (Quality)
  ├── #20 N+1 fixes
  ├── #22 PopulasiAyam consolidation
  ├── #23 Fix misspellings
  ├── #24 Remove orphaned views
  └── #25 Unqualified columns

Sprint 6 (Tests)
  ├── #26 Permission matrix
  ├── #27 Auth tests
  ├── #28 Business logic tests
  └── #29 CRUD tests

Sprint 7 (Docs)
  ├── #30 README
  ├── #31 ARCHITECTURE
  └── #32 CHANGELOG
```

---

## Size Legend

| Size | Estimated Effort | Example |
|------|-----------------|---------|
| S | < 1 hour | Single file fix, config change |
| M | 1-3 hours | New component, language files |
| L | 3-8 hours | Multi-file rollout, complex component |
| XL | 8+ hours | Full permission matrix tests |

---

## Risk Assessment

| Risk | Mitigation |
|------|-----------|
| PopulasiAyam v1/v2 consolidation breaks existing flows | Test v2 thoroughly before removing v1; keep v1 routes as redirects initially |
| N+1 fixes change query behavior | Run before/after comparison on key pages |
| Template rollout introduces inconsistencies | Use reusable Blade components; review in batches |
| Shepherd.js bundle size impacts mobile | Lazy-load walkthrough script; only load on first visit |
| Old browser (Opera Mini) breaks with new components | Progressive enhancement — all new JS features behind feature detection |

---

**Status**: Plan approved (autopilot mode)
**Next**: Phase 6 — Development (starting Sprint 1: P0 bug fixes)
