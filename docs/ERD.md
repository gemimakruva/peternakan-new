# ERD Assessment — SPMS Peternakan UI/UX Redesign

**Phase**: 4 — Data Design
**Date**: 2026-08-10
**Status**: No major schema changes needed

---

## 1. Current State

- **Database**: SQLite 3.45.1
- **Tables**: 87
- **Size**: 520 KB
- **Modules**: Kandang (32 migrations), GudangPakan (8 migrations), GudangTelur (5 migrations), Core (7 migrations)

## 2. Schema Changes Required

### 2.1 New Column: `has_seen_tour` (for Shepherd.js walkthrough)

```sql
ALTER TABLE users ADD COLUMN has_seen_tour BOOLEAN DEFAULT 0;
```

**Rationale**: BRD Q15:B — walkthrough muncul saat first login, flag di database. User bisa trigger ulang via tombol "Panduan".

### 2.2 No Other Schema Changes

Proyek ini adalah UI/UX redesign — tidak ada fitur baru yang memerlukan tabel atau kolom baru. Semua data yang dibutuhkan sudah tersedia di schema existing.

## 3. Index Optimization Recommendations

Berdasarkan analisis query patterns di repositories (Q9:B — performance targets):

| Table | Column(s) | Query Frequency | Recommendation |
|-------|----------|-----------------|----------------|
| `populasi_ayam` | `tanggal` | 10 refs | ADD INDEX |
| `populasi_ayam` | `kandang_id` | 5 refs | ADD INDEX |
| `populasi_ayam` | `kandang_id, tanggal` | Composite | ADD COMPOSITE INDEX |
| `produksi_telur` | `kandang_id, tanggal` | 6 refs | ADD COMPOSITE INDEX |
| `perhitungan_pakan_item` | `perhitungan_pakan_id` | 6 refs | ADD INDEX (likely FK, verify) |
| `pemberian_pakan_sisa_pakan` | `perhitungan_pakan_id` | 4 refs | ADD INDEX |
| `bahan_pakan_inventory` | `tanggal` | 3 refs | ADD INDEX |
| `telur_masuk` | `tanggal` | 3 refs | ADD INDEX |
| `telur_keluar` | `tanggal` | 3 refs | ADD INDEX |
| `karantina_populasi_pipe` | `tanggal, kandang_asal_id` | 3 refs | ADD COMPOSITE INDEX |

**Note**: SQLite handles indexes differently from MySQL/PostgreSQL. Indexes tetap beneficial untuk query performance tapi impact-nya lebih kecil di SQLite dengan dataset kecil. Implementasi indexes penting untuk production readiness jika migrate ke MySQL/PostgreSQL nanti.

## 4. Known SQL Issues to Fix

| Issue | Location | Fix |
|-------|----------|-----|
| Ambiguous `tanggal` column | `RekapanMingguanProduksiRepository.php:27` | Qualify as `xpaq.tanggal` |
| Ambiguous `umur` column | `RekapanMingguanProduksiRepository.php:85` | Qualify as `xpaq.umur` |
| Unqualified ORDER BY | Multiple repository files | Audit all `orderBy()` calls |

## 5. Data Integrity Notes

- Foreign keys: SQLite foreign key enforcement depends on `PRAGMA foreign_keys = ON`. Verify this is set in Laravel config.
- Soft deletes: Not used in most models — deletion is permanent.
- Timestamps: All tables use `created_at`/`updated_at` via Laravel timestamps.

## 6. Migration Plan

Single migration file needed:

```php
// database/migrations/2026_08_10_add_walkthrough_and_indexes.php

Schema::table('users', function (Blueprint $table) {
    $table->boolean('has_seen_tour')->default(false);
});

// Performance indexes
Schema::table('populasi_ayam', function (Blueprint $table) {
    $table->index(['kandang_id', 'tanggal']);
    $table->index('tanggal');
});

Schema::table('produksi_telur', function (Blueprint $table) {
    $table->index(['kandang_id', 'tanggal']);
});

// Additional indexes per analysis...
```

## 7. Decision

**No ERD diagram needed** — schema is unchanged (except 1 boolean column + performance indexes). This document serves as the Phase 4 gate deliverable for the UI/UX redesign scope.

---

**Approved**: Auto-approved per autopilot mode (best judgment)
**Next**: Phase 5 (Planning)
