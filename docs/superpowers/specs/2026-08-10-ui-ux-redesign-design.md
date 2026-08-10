# SPMS Peternakan — UI/UX Redesign & Mobile Views

**Date:** 2026-08-10
**Approach:** CSS Override Layer on AdminLTE 3
**Style:** Clean Modern
**Mobile Strategy:** All roles, card-based tables on mobile

---

## 1. Architecture Decision

Keep AdminLTE 3 as the base framework. Override via custom SCSS variables and a theme layer. No template rewrite — extend existing markup with responsive Blade components.

**Rationale:** 256 blade templates and AdminLTE component usage (x-adminlte-input, x-adminlte-select, etc.) make a full rewrite high-risk for no functional gain. CSS overrides give global visual refresh with minimal breakage.

## 2. Design System

### Color Palette

| Token              | Value     | Usage                        |
|---------------------|-----------|------------------------------|
| `--primary`         | `#4F6AF6` | Buttons, links, active state |
| `--primary-dark`    | `#3B50D4` | Hover, focus                 |
| `--secondary`       | `#6B7280` | Muted text, borders          |
| `--success`         | `#22C55E` | Positive indicators          |
| `--warning`         | `#F59E0B` | Alerts, attention            |
| `--danger`          | `#EF4444` | Errors, destructive actions  |
| `--info`            | `#3B82F6` | Informational                |
| `--bg-body`         | `#F1F5F9` | Page background              |
| `--bg-card`         | `#FFFFFF` | Card background              |
| `--sidebar-bg`      | `#1E293B` | Sidebar background           |
| `--sidebar-active`  | `#4F6AF6` | Active menu item             |
| `--text-primary`    | `#1E293B` | Headings, important text     |
| `--text-body`       | `#475569` | Body text                    |
| `--text-muted`      | `#94A3B8` | Secondary text               |
| `--border`          | `#E2E8F0` | Borders, dividers            |

### Typography

- Font: `'Inter', 'Nunito', system-ui, sans-serif`
- Body: 14px / 1.6 line-height
- Headings: 600 weight, `--text-primary` color
- Mobile body: 15px (slightly larger for touch readability)

### Spacing & Radius

- Card padding: 1.25rem (desktop), 1rem (mobile)
- Card border-radius: 12px
- Input border-radius: 8px
- Button border-radius: 8px
- Button min-height: 44px (touch-friendly)
- Section gap: 1.5rem

### Shadows

- Card: `0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06)`
- Card hover: `0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.06)`
- Dropdown: `0 10px 15px rgba(0,0,0,0.1)`

## 3. Mobile Strategy

### Layout

- Sidebar: collapse to hamburger menu on < 768px (AdminLTE default, enhanced)
- Navbar: sticky top, simplified on mobile
- Content: full-width, no horizontal scroll on body
- Touch targets: minimum 44x44px

### Table → Card Transformation

All list/index views with data tables get a dual-view approach:
- **Desktop (≥768px):** Standard table with sorting, same as current
- **Mobile (<768px):** Card-based list with key data visible, expandable details

Implementation: A `<x-responsive-table>` Blade component wraps each table. On mobile, CSS hides the table and shows the card layout. Template authors provide both views — the component handles the breakpoint switching.

### Forms on Mobile

- Inputs stack vertically (full width)
- Labels above inputs (not inline)
- Action buttons: full-width sticky at bottom
- Date pickers and selects: native mobile controls where possible

## 4. Component Inventory

### New Components

| Component            | Purpose                                      |
|----------------------|----------------------------------------------|
| `responsive-table`   | Wraps table + mobile card, handles breakpoint |
| `mobile-card`        | Single data card for mobile list item         |
| `stat-card`          | Dashboard stat tile                           |
| `action-bar`         | Sticky bottom bar for form actions (mobile)   |
| `filter-panel`       | Collapsible filter section for mobile         |
| `page-header`        | Unified page header with breadcrumb           |

### Modified Components

| Component    | Change                                  |
|--------------|-----------------------------------------|
| `sort-th`    | Add data attributes for mobile card     |
| `pagination` | Simplified mobile pagination            |

## 5. Module Scope

### Kandang (highest priority — most views, most users)
- recording-telur (index, create, edit, show)
- pengadaan-ayam (index, create, edit, show)
- sampling-ayam (index, create, edit, show)
- ayam-karantina (index, create, edit, overview)
- perhitungan-pakan (index, create, edit, show)
- pemberian-pakan (index, edit, show)
- afkir-ayam (index, create, edit)
- populasi-ayam (index)
- strain (index, show)
- treatment (penjadwalan, pelaksanaan)
- monitoring-kesehatan (index, create, edit, show)
- pindah-ayam (index, create, edit)
- rekapan views

### GudangPakan
- bahan-pakan-inventory, bahan-pakan-keluar, bahan-pakan-formulasi
- pakan-mixing, pakan-pre-mixing, pakan-pre-mixing-opname
- supplier-bahan-pakan
- bahan-pakan-pembelian, bahan-pakan-masuk, bahan-pakan-opname
- pakan-finished-good (inventory, distribusi, opname)

### GudangTelur
- grading-telur, telur-masuk, telur-keluar, telur-opname
- inventory-telur, inventory-kemasan
- input-kemasan, output-kemasan, opname-kemasan
- supplier-kemasan

### Shared / Core
- Home dashboard
- Login page
- User management, role-permission settings
- Master data views

## 6. Out of Scope

- Backend logic changes (controllers, models, routes)
- Database schema changes
- New features or business logic
- Authentication flow changes
- API changes

## 7. Success Criteria

- All pages render without PHP/Blade errors
- All pages are usable on 375px mobile viewport
- Design system is consistent across all modules
- Touch targets meet 44px minimum
- Tables have card-based mobile alternative
- Forms are comfortably fillable on mobile
- No horizontal scroll on any page at any viewport
