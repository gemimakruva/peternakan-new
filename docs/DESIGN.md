# DESIGN.md — SPMS Peternakan Design System

**Project**: SPMS Peternakan (Smart Poultry Management System)
**BRD Reference**: docs/BRD.md
**PRD Reference**: docs/PRD.md
**Date**: 2026-08-10
**Version**: 1.0

---

## 1. Brand Identity

### 1.1 Logo

Chicken-egg logo in orange/charcoal. Used in:
- Sidebar brand area (32×32px `brand-image`)
- Login/register page header
- Print report headers
- Favicon (derived from logo, 16×16 and 32×32 ICO)
- Loading spinner overlay (centered, 48×48px)

### 1.2 Color Palette

#### Primary Brand Colors

| Token | Hex | Usage |
|-------|-----|-------|
| `$theme-primary` | `#F28B1E` | Buttons, active states, links, brand accents |
| `$theme-primary-dark` | `#D97706` | Button hover/active, gradient endpoints |
| `$theme-primary-light` | `#FFF7ED` | Hover backgrounds, selected rows, treeview active |

#### Semantic Colors

| Token | Hex | Light Variant | Usage |
|-------|-----|--------------|-------|
| `$theme-success` | `#4CAF50` | `#F1F8E9` | Success alerts, positive metrics |
| `$theme-warning` | `#FFB300` | `#FFFDE7` | Warning alerts, attention items |
| `$theme-danger` | `#E64A19` | `#FBE9E7` | Error alerts, destructive actions, mortality data |
| `$theme-info` | `#42A5F5` | `#E3F2FD` | Info alerts, neutral supplementary data |
| `$theme-secondary` | `#6B7280` | — | Secondary buttons, muted actions |

#### Surface Colors

| Token | Hex | Usage |
|-------|-----|-------|
| `$bg-body` | `#FAF8F5` | Page background (warm off-white) |
| `$bg-card` | `#FFFFFF` | Card, modal, dropdown backgrounds |
| `$border-color` | `#E8E4DF` | Card borders, table row borders, input borders |

#### Sidebar Colors

| Token | Hex | Usage |
|-------|-----|-------|
| `$sidebar-bg` | `#2D3436` | Sidebar background (charcoal) |
| `$sidebar-hover` | `#3D4043` | Sidebar item hover |
| `$sidebar-active-bg` | `#F28B1E` | Active sidebar item (matches primary) |
| `$sidebar-text` | `#B0ADA8` | Default sidebar link text |
| `$sidebar-text-active` | `#FFFFFF` | Active sidebar link text |

#### Text Colors

| Token | Hex | Usage |
|-------|-----|-------|
| `$text-primary` | `#2D3436` | Headings, high-emphasis text |
| `$text-body` | `#4A4A4A` | Body text, table cells |
| `$text-muted` | `#9E9E9E` | Captions, placeholders, secondary info |

### 1.3 Color Usage Rules

- Brand orange (`#F28B1E`) is reserved for interactive elements and brand accents — never for backgrounds covering large areas.
- Charcoal (`#2D3436`) is sidebar-only. Do not use it as text color on cards (use `$text-primary` which happens to match, but the semantic intent differs).
- Error/danger red (`#E64A19`) is never used purely for decoration. Every red element must convey a negative state.
- Light variant colors (e.g. `#FFF7ED`) are for background tints only. Never use them as foreground/text colors.

---

## 2. Typography

### 2.1 Font Stack

```scss
$font-family-sans-serif: 'Inter', 'Nunito', system-ui, -apple-system, sans-serif;
```

**Inter** is loaded via Bunny Fonts CDN (configured in `adminlte.php` `google_fonts`). Nunito is the AdminLTE default fallback.

### 2.2 Type Scale

| Element | Size | Weight | Color | Line Height |
|---------|------|--------|-------|-------------|
| Page title (`h1`) | 1.4rem (desktop), 1.15rem (mobile) | 700 | `$text-primary` | 1.3 |
| Card title | 0.9rem | 600 | `$text-primary` | 1.4 |
| Body text | 0.875rem (base) | 400 | `$text-body` | 1.6 |
| Table header `th` | 0.78rem | 600 | `$text-primary` | 1.4 |
| Table cell `td` | 0.85rem | 400 | `$text-body` | 1.4 |
| Label / form label | 0.82rem | 500 | `$text-primary` | 1.4 |
| Badge | 0.72rem | 500 | (per semantic color) | 1 |
| Caption / muted | 0.78rem | 400 | `$text-muted` | 1.4 |
| Sidebar nav item | 0.85rem | 400 (normal), 600 (active) | `$sidebar-text` / white | 1.4 |
| Sidebar nav header | 0.7rem | 700 | `$text-muted` | 1.2 |
| Mobile card title | 0.9rem | 600 | `$text-primary` | 1.3 |
| Mobile card subtitle | 0.78rem | 400 | `$text-muted` | 1.3 |
| Mobile card data label | 0.82rem | 400 | `#64748B` | 1.3 |
| Mobile card data value | 0.82rem | 500 | `$text-primary` | 1.3 |

### 2.3 Type Rules

- Table headers are UPPERCASE with `letter-spacing: 0.03em`.
- Sidebar nav headers are UPPERCASE with `letter-spacing: 0.08em`.
- Numeric data (counts, percentages, amounts) use tabular-nums where available.
- Mobile form inputs use `font-size: 16px` minimum to prevent iOS Safari auto-zoom.

---

## 3. Spacing & Layout

### 3.1 Spacing Scale

Based on `0.25rem` increments (4px at base font 16px):

| Token | Value | Usage |
|-------|-------|-------|
| `xs` | 0.25rem (4px) | Badge padding, tight gaps |
| `sm` | 0.5rem (8px) | Button padding, small gaps |
| `md` | 0.75rem–1rem (12–16px) | Card body padding (mobile), content gaps |
| `lg` | 1.25rem (20px) | Card body padding (desktop), section spacing |
| `xl` | 1.5rem–2rem (24–32px) | Auth card body padding, section headers |

### 3.2 Layout Structure

```
┌─────────────────────────────────────────────────┐
│ Navbar (56px height, fixed)                      │
├──────────┬──────────────────────────────────────┤
│ Sidebar  │ Content Wrapper                       │
│ 250px    │  ┌─ content-header (page-header)      │
│ (fixed)  │  │  padding: 1rem 0.5rem              │
│          │  ├─ content                           │
│          │  │  padding: 0 0.5rem (mobile)        │
│          │  │  ┌─ cards / tables / forms         │
│          │  │  └─                                │
│          │  └─                                   │
│          │                                       │
│          │  ┌─ bottom-nav (mobile only, fixed)   │
├──────────┴──┴────────────────────────────────────┤
```

- Sidebar collapses to mini (icon-only) at `lg` breakpoint.
- On mobile (< 768px), sidebar is hidden by default, toggled via hamburger.
- Bottom nav appears only on mobile (< 768px), fixed at viewport bottom.

### 3.3 Border Radius Scale

| Element | Radius | Note |
|---------|--------|------|
| Buttons, inputs, select | 8px | Default interactive element radius |
| Button small | 6px | Compact action buttons |
| Badges | 6px | Pill-like but not fully rounded |
| Cards (desktop) | 12px | Generous rounding |
| Cards (mobile) | 10px | Slightly tighter |
| Dropdowns | 10px | Matches card feel |
| Modals | 14px | Prominent overlay |
| Auth cards | 16px | Most rounded — premium feel |
| Sidebar nav items | 8px | Match buttons |
| Treeview nav items | 6px | Slightly tighter than parent |

### 3.4 Grid System

Bootstrap 5 grid. Standard patterns:

- **Filter fields**: `col-12 col-md-4` (full width on mobile, 3 per row desktop)
- **Stat cards**: `col-6 col-lg-3` (2 per row mobile, 4 per row desktop)
- **Form fields**: `col-12 col-md-6` (full mobile, 2 per row desktop)
- **Single-column forms**: `col-12 col-md-8 col-lg-6` (centered on desktop)

---

## 4. Existing Component Specifications

### 4.1 `<x-page-header>`

**File**: `resources/views/components/page-header.blade.php`

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | required | Page title shown as `h1` |
| `breadcrumbs` | array | `[]` | Associative `['Label' => 'url']`, last item is active |
| `actions` | slot | `null` | Action buttons (e.g. "Tambah", "Export") |

**Behavior**:
- Desktop: title left, breadcrumbs right, actions inline with title
- Mobile (< 576px): breadcrumbs hidden, actions rendered below title in full-width row

**Usage**:
```blade
<x-page-header title="Populasi Ayam" :breadcrumbs="['Kandang' => '#', 'Populasi Ayam' => '']">
    <x-slot name="actions">
        <a href="{{ route('populasi-ayam-2.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </x-slot>
</x-page-header>
```

### 4.2 `<x-mobile-card>`

**File**: `resources/views/components/mobile-card.blade.php`

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | `''` | Card header title |
| `subtitle` | string | `''` | Secondary text below title |
| `badge` | string | `''` | Status badge text |
| `badgeClass` | string | `'badge-primary'` | Bootstrap badge class |

**Slots**:
- Default slot: data rows (`<div class="data-row"><span class="data-label">...</span><span class="data-value">...</span></div>`)
- `actions`: bottom action bar with buttons

**Visual Spec**:
- White background, `#E8E4DF` border, 10px radius
- Header: flex row, title group left, badge right
- Body: label-value rows with `#F5F2EE` dividers
- Actions: `#FAFBFC` background footer with flex buttons

**Usage**:
```blade
<x-mobile-card title="Kandang A1" subtitle="Flock #12" badge="Aktif" badgeClass="badge-success">
    <div class="data-row">
        <span class="data-label">Populasi</span>
        <span class="data-value">12,500</span>
    </div>
    <x-slot name="actions">
        <a href="#" class="btn btn-sm btn-primary">Detail</a>
        <a href="#" class="btn btn-sm btn-warning">Edit</a>
    </x-slot>
</x-mobile-card>
```

### 4.3 `<x-filter-panel>`

**File**: `resources/views/components/filter-panel.blade.php`

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `action` | string | `''` | Form action URL |
| `method` | string | `'GET'` | HTTP method |
| `title` | string | `'Filter'` | Panel title with filter icon |
| `resetUrl` | string | `''` | URL for reset button (hidden if empty) |

**Behavior**:
- Desktop: always expanded, fields in `row align-items-end` grid
- Mobile (< 576px): collapsible via card header tap, fields stack full-width, filter/reset buttons full-width

**Usage**:
```blade
<x-filter-panel :action="route('populasi-ayam-2.index')" :resetUrl="route('populasi-ayam-2.index')">
    <div class="col-12 col-md-4">
        <label>Kandang</label>
        <select name="kandang_id" class="form-control">...</select>
    </div>
</x-filter-panel>
```

### 4.4 `<x-stat-card>`

**File**: `resources/views/components/stat-card.blade.php`

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | string | required | Metric label |
| `value` | string | required | Metric value |
| `icon` | string | `'fas fa-chart-bar'` | FontAwesome icon class |
| `color` | string | `'primary'` | One of: primary, success, warning, danger, info |
| `subtitle` | string | `''` | Optional subtitle below value |

**Color Map**:

| Color | Background | Text | Icon |
|-------|-----------|------|------|
| primary | `#FFF7ED` | `#D97706` | `#F28B1E` |
| success | `#F1F8E9` | `#388E3C` | `#4CAF50` |
| warning | `#FFFDE7` | `#F57F17` | `#FFB300` |
| danger | `#FBE9E7` | `#D84315` | `#E64A19` |
| info | `#E3F2FD` | `#1976D2` | `#42A5F5` |

**Visual**: 48×48px rounded circle icon container, value at 1.35rem/700 weight.

### 4.5 `<x-pagination>`

**File**: `resources/views/components/pagination.blade.php`

Wraps Laravel's `$paginator->links()` with responsive layout:
- Desktop: info text left ("Menampilkan X-Y dari Z"), links right
- Mobile: centered links, 40×40px touch targets, flex-wrap

### 4.6 `<x-sort-th>`

**File**: `resources/views/components/sort-th.blade.php`

| Prop | Type | Description |
|------|------|-------------|
| `label` | string | Column header text |
| `name` | string | Query parameter name for sorting |

Renders a `<th>` with clickable sort link. Cycles: none → asc → desc → none. Shows sort direction icon (fa-sort / fa-sort-up / fa-sort-down). Supports multi-column sorting via `orders[]` query param.

### 4.7 `<x-form-alert>`

**File**: `resources/views/components/form-alert.blade.php`

No props — reads from `session('success')`, `session('warning')`, `session('danger')` and `$errors` bag. Uses AdminLTE's `<x-adminlte-alert>` internally. Renders dismissable alert with validation error list.

### 4.8 `<x-snackbar>`

**File**: `resources/views/components/snackbar.blade.php`

No props — reads `session('error')`. Fixed-position toast at bottom-right, auto-hides after 4 seconds. Colors: green for success, red for error.

**Note**: Snackbar uses hardcoded colors (`#28a745`, `#dc3545`). Needs update to use brand semantic tokens.

---

## 5. New Components (To Be Built)

### 5.1 `<x-bottom-nav>`

**Purpose**: Fixed bottom navigation bar for mobile, role-aware.

**Props**: None — reads `Auth::user()->roles` to determine items.

**Behavior**:
- Visible only on mobile (< 768px) via CSS `d-md-none`
- Fixed to viewport bottom, `z-index: 1040` (above content, below modals)
- 4-5 items per role (see BRD Section 3.1 mapping table)
- Active item highlighted with `$theme-primary` color
- Last item is always "Menu" (hamburger) — opens sidebar overlay
- Height: 56px; icon 20px + label 10px with 4px gap

**Visual Spec**:
```
┌──────────┬──────────┬──────────┬──────────┬──────────┐
│  ⌂       │  📋      │  🥚      │  📦      │  ☰       │
│Dashboard │ Rekapan  │ Produksi │ Gudang   │  Menu    │
└──────────┴──────────┴──────────┴──────────┴──────────┘
```
- Background: `$bg-card` with top border `$border-color`
- Shadow: `0 -2px 8px rgba(0,0,0,0.06)`
- Active: icon + label in `$theme-primary`, inactive in `$text-muted`
- Labels: 0.65rem, 500 weight
- Icons: FontAwesome, 1.1rem
- Items: flex-column, centered

**Content area padding**: When bottom-nav is visible, `content-wrapper` gets `padding-bottom: 64px` to prevent content being hidden behind the nav.

**Role → Items Mapping** (from BRD):

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

**Implementation**: Blade component with role-to-items PHP array. Rendered in `layouts/dashboard.blade.php` at end of body.

### 5.2 `<x-empty-state>`

**Purpose**: Friendly placeholder when a list/table has zero records.

**Props**:

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | `'Belum ada data'` | Heading text |
| `description` | string | `''` | Explanatory text |
| `illustration` | string | `'default'` | SVG illustration key (maps to file) |
| `actionUrl` | string | `''` | URL for CTA button |
| `actionLabel` | string | `''` | CTA button text |
| `actionIcon` | string | `'fas fa-plus'` | CTA button icon |

**Visual Spec**:
- Centered container, `padding: 3rem 1.5rem`
- SVG illustration: max-width 200px, recolored to brand palette
- Title: 1.1rem, 600 weight, `$text-primary`
- Description: 0.85rem, 400 weight, `$text-muted`, max-width 360px
- Action button: standard `btn btn-primary`
- Spacing: illustration → 1.5rem → title → 0.5rem → description → 1.5rem → button

**SVG Illustrations** (source: unDraw, recolored to orange/charcoal):

| Key | Illustration | Used For |
|-----|-------------|----------|
| `default` | Empty box / clipboard | General empty lists |
| `no-data` | Chart with no bars | Rekapan / reports with no data |
| `no-results` | Search with magnifier | Filter returned zero results |
| `chicken` | Farm / agriculture | Kandang-related empty states |
| `warehouse` | Boxes / storage | Gudang Pakan / Telur empty states |
| `medical` | Medical / health | Treatment / monitoring empty states |

SVG files stored in `public/illustrations/empty-state/`.

### 5.3 `<x-tooltip-help>`

**Purpose**: Contextual help tooltip on form fields and data labels.

**Props**:

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `text` | string | required | Tooltip content |
| `position` | string | `'top'` | Tooltip position: top, bottom, left, right |

**Implementation**: Uses Alpine.js (`x-data`, `x-show`, `@mouseenter`, `@mouseleave`, `@focus`, `@blur`) — no additional library needed.

**Visual Spec**:
- Trigger: `?` icon (circle, 16px, `$text-muted` color) inline next to label
- Tooltip: `$sidebar-bg` background, white text, 0.8rem, 8px radius, max-width 250px
- Arrow: 6px CSS triangle pointing toward trigger
- Mobile: tap to toggle (instead of hover)

**Usage**:
```blade
<label>
    Feed Intake <x-tooltip-help text="Total pakan dikonsumsi per ekor per hari (gram)" />
</label>
```

### 5.4 `<x-walkthrough>`

**Purpose**: First-time user guided tour via Shepherd.js.

**Props**: None — reads `Auth::user()->has_seen_tour` flag and role.

**Behavior**:
- On first login (`has_seen_tour = false`): auto-start tour after 1 second delay
- Manual trigger: "Panduan" button in navbar (always visible)
- On tour complete: AJAX call to set `has_seen_tour = true` in user record
- Tour scope: Dashboard + sidebar navigation only (BRD Q16:A)

**Tour Steps** (common to all roles):

| # | Target | Title | Text |
|---|--------|-------|------|
| 1 | `.brand-link` | Selamat datang | Ini adalah SPMS Peternakan. Mari kita kenalan dengan fitur-fiturnya. |
| 2 | `.main-sidebar .nav-sidebar` | Menu Navigasi | Semua fitur tersedia di menu ini. Klik untuk membuka. |
| 3 | `.content-header h1` | Judul Halaman | Setiap halaman menampilkan judul dan breadcrumb di sini. |
| 4 | `[data-widget="pushmenu"]` | Buka/Tutup Menu | Klik tombol ini untuk menyembunyikan atau menampilkan menu. |
| 5 | `.bottom-nav` (mobile) | Navigasi Cepat | Di HP, gunakan menu di bawah layar untuk akses cepat. |
| 6 | `.walkthrough-trigger` | Panduan | Klik tombol ini kapan saja untuk melihat panduan lagi. |

**Shepherd.js Configuration**:
- Theme: custom CSS matching brand (orange primary, white text, 12px radius)
- Overlay: dark with 0.5 opacity
- Scroll-to: enabled
- Cancel on outside click: disabled (prevent accidental dismiss)
- Progress indicator: "Langkah X dari Y"

**DB Migration**: Add `has_seen_tour` (boolean, default false) column to `users` table.

---

## 6. Page Patterns

### 6.1 Index (List) Page

Standard layout for all list/table views (~55 pages).

```
┌─────────────────────────────────────────┐
│ <x-page-header>                         │
│   Title + [Tambah] button               │
├─────────────────────────────────────────┤
│ <x-filter-panel> (if filterable)        │
│   [Kandang ▾] [Tanggal ▾] [Cari] [Reset]│
├─────────────────────────────────────────┤
│ Desktop (d-none d-md-block):            │
│ ┌─ Card ─────────────────────────────┐  │
│ │ <table>                            │  │
│ │  <thead> <x-sort-th> headers       │  │
│ │  <tbody> data rows                 │  │
│ │ </table>                           │  │
│ └────────────────────────────────────┘  │
│                                         │
│ Mobile (d-md-none):                     │
│ <x-mobile-card> ×N                      │
│  title = primary identifier             │
│  subtitle = secondary info              │
│  badge = status                         │
│  data-rows = key metrics                │
│  actions = [Detail] [Edit] [Hapus]      │
│                                         │
│ <x-pagination>                          │
│                                         │
│ (if zero records):                      │
│ <x-empty-state>                         │
└─────────────────────────────────────────┘
```

### 6.2 Create / Edit Page

Standard layout for all form views.

```
┌─────────────────────────────────────────┐
│ <x-page-header>                         │
│   "Tambah [Entity]" / "Edit [Entity]"   │
├─────────────────────────────────────────┤
│ <x-form-alert>                          │
├─────────────────────────────────────────┤
│ ┌─ Card ─────────────────────────────┐  │
│ │ <form>                             │  │
│ │   .row > .col-12.col-md-6          │  │
│ │   [Label + <x-tooltip-help>]       │  │
│ │   [Input]                          │  │
│ │   ...                              │  │
│ │   Desktop: [Simpan] [Batal] inline │  │
│ │ </form>                            │  │
│ └────────────────────────────────────┘  │
│                                         │
│ Mobile: sticky-form-actions bar         │
│ ┌─ fixed bottom ─────────────────────┐  │
│ │ [Batal] [Simpan]  (flex, equal)    │  │
│ └────────────────────────────────────┘  │
└─────────────────────────────────────────┘
```

**Sticky form actions** (mobile only):
- Fixed bottom, white background, shadow upward
- `z-index: 1000`, padding 0.75rem 1rem
- Buttons flex: 1 for equal width
- Form card gets `padding-bottom: 80px` to prevent overlap

### 6.3 Show (Detail) Page

```
┌─────────────────────────────────────────┐
│ <x-page-header>                         │
│   "Detail [Entity]" + [Edit] [Hapus]    │
├─────────────────────────────────────────┤
│ ┌─ Card: Informasi Umum ─────────────┐  │
│ │ Desktop: 2-col key-value grid      │  │
│ │ Mobile: stacked key-value list     │  │
│ └────────────────────────────────────┘  │
│ ┌─ Card: Data Terkait ───────────────┐  │
│ │ Desktop: table                     │  │
│ │ Mobile: <x-mobile-card> list       │  │
│ └────────────────────────────────────┘  │
└─────────────────────────────────────────┘
```

### 6.4 Dashboard

```
┌─────────────────────────────────────────┐
│ <x-page-header> "Dashboard"             │
│   Selamat datang, [User Name]           │
├─────────────────────────────────────────┤
│ <x-stat-card> grid (col-6 col-lg-3)    │
│ [Populasi] [Produksi] [Pakan] [Mortal] │
├─────────────────────────────────────────┤
│ Chart cards (Chart.js)                  │
│ Desktop: 2-col grid                     │
│ Mobile: full-width stacked              │
├─────────────────────────────────────────┤
│ Quick links / recent activity           │
└─────────────────────────────────────────┘
```

### 6.5 Error Pages (404 / 500 / 403 / 419 / 503)

```
┌─────────────────────────────────────────┐
│ (full-page, no sidebar)                 │
│                                         │
│        [SVG Illustration]               │
│        200px max-width                  │
│                                         │
│        Error Code (3rem, 700)           │
│        "Halaman Tidak Ditemukan"        │
│        (1.2rem, 600)                    │
│                                         │
│        Penjelasan singkat               │
│        (0.9rem, $text-muted)            │
│                                         │
│        [Kembali ke Dashboard]           │
│        btn-primary                      │
│                                         │
│        Footer: SPMS Peternakan          │
└─────────────────────────────────────────┘
```

Background: `$bg-body`. Centered vertically and horizontally. Each error code has its own illustration and message:

| Code | Title | Message | Illustration |
|------|-------|---------|-------------|
| 403 | Akses Ditolak | Anda tidak memiliki izin untuk mengakses halaman ini. | Lock / shield |
| 404 | Halaman Tidak Ditemukan | Halaman yang Anda cari tidak ada atau telah dipindahkan. | Lost / search |
| 419 | Sesi Berakhir | Sesi Anda telah berakhir. Silakan muat ulang halaman. | Clock / timeout |
| 500 | Terjadi Kesalahan | Terjadi kesalahan pada server. Silakan coba lagi nanti. | Bug / error |
| 503 | Sedang Dalam Perbaikan | Sistem sedang dalam pemeliharaan. Silakan kembali beberapa saat lagi. | Maintenance |

---

## 7. Responsive Breakpoints

| Breakpoint | Width | Sidebar | Tables | Cards | Bottom Nav | Behavior |
|------------|-------|---------|--------|-------|------------|----------|
| Mobile | < 768px | Hidden (hamburger toggle) | Hidden (d-none) | Visible (d-md-none) | Visible | Simplified views, card lists, sticky form actions |
| Tablet | 768–991px | Mini (icon-only) | Visible | Hidden | Hidden | Full table views, compact sidebar |
| Desktop | >= 992px | Full (250px) | Visible | Hidden | Hidden | Full experience |

**CSS Class Pattern**:
```html
<!-- Desktop table -->
<div class="desktop-table d-none d-md-block">
    <table>...</table>
</div>

<!-- Mobile card list -->
<div class="mobile-card-list d-md-none">
    <x-mobile-card>...</x-mobile-card>
</div>
```

---

## 8. Progressive Enhancement

### Tier 1: Full Support
**Browsers**: Chrome (Android + Desktop), Edge, Firefox, Safari

All features enabled: SCSS theme, JavaScript interactions, Chart.js, Shepherd.js walkthrough, Alpine.js tooltips, bottom navigation.

### Tier 2: Enhanced Degradation
**Browsers**: UC Browser, Android WebView (older versions)

- Core CRUD: fully functional (forms, tables, navigation)
- Charts: hidden with `<noscript>` fallback message or degraded to static data table
- Walkthrough: not loaded (Shepherd.js checks `window.Shepherd` before init)
- Tooltips: fall back to `title` attribute (native browser tooltip)
- Bottom nav: functional (relies on flexbox, which UC Browser supports)
- CSS Grid: replaced with flexbox fallbacks

### Tier 3: Basic
**Browsers**: Opera Mini (Extreme mode)

- No JavaScript execution: walkthrough, charts, Alpine.js all inactive
- CSS only: layout via floats and flexbox (no Grid)
- Forms: standard HTML inputs, server-side validation only
- Navigation: sidebar links as standard `<a>` tags
- Bottom nav: visible as fixed positioned `<div>` with basic flexbox

**Implementation strategy**: Feature detection via `@supports` and `if (typeof window.Alpine !== 'undefined')` guards. No user-agent sniffing.

---

## 9. Animation & Transitions

| Element | Property | Duration | Easing | Trigger |
|---------|----------|----------|--------|---------|
| Buttons | background-color, border-color | 0.15s | ease | hover, focus |
| Nav links | background-color, color | 0.15s | ease | hover |
| Cards | box-shadow | 0.2s | ease | hover (optional) |
| Form inputs | border-color, box-shadow | 0.15s | ease | focus |
| Sidebar treeview arrow | transform (rotate) | 0.2s | ease | menu open/close |
| Snackbar | opacity, transform | 0.4s | ease | show/hide |
| Filter panel collapse | height | Bootstrap default | — | toggle |
| Dropdown menus | — | Bootstrap default | — | toggle |

**Rules**:
- No animations that block interaction (no animated page transitions)
- `prefers-reduced-motion: reduce` disables all custom transitions
- No infinite animations (spinners use CSS animation but only during loading)

---

## 10. Accessibility

### 10.1 Touch Targets

| Context | Minimum Size | Recommended | Implementation |
|---------|-------------|-------------|---------------|
| Mobile buttons | 44×44px | 48×48px | `min-height: 44px` in mobile breakpoint |
| Mobile table action buttons | 36×36px | 40×40px | `min-width: 36px; min-height: 36px` |
| Pagination links (mobile) | 40×40px | 44×44px | `min-width: 40px; min-height: 40px` |
| Bottom nav items | 48×48px | 56×56px | Full height of bottom nav bar |
| Desktop buttons | 38px | — | `min-height: 38px` default |

### 10.2 Color Contrast

All text/background combinations meet WCAG 2.1 AA (4.5:1 for normal text, 3:1 for large text):

| Combination | Ratio | Pass |
|-------------|-------|------|
| `$text-primary` (#2D3436) on `$bg-body` (#FAF8F5) | 11.2:1 | AA |
| `$text-body` (#4A4A4A) on `$bg-card` (#FFFFFF) | 9.7:1 | AA |
| `$text-muted` (#9E9E9E) on `$bg-card` (#FFFFFF) | 2.8:1 | Fail — use for decorative only, not essential info |
| `$theme-primary` (#F28B1E) on `$bg-card` (#FFFFFF) | 2.9:1 | Fail — not for body text; OK for large text / icons |
| White (#FFFFFF) on `$theme-primary` (#F28B1E) | 2.9:1 | OK for large bold button text |
| White (#FFFFFF) on `$sidebar-bg` (#2D3436) | 11.2:1 | AA |

**Rules**:
- `$text-muted` is never the sole carrier of meaning. Always pair with icon, badge, or layout context.
- `$theme-primary` on white is acceptable for large bold text (buttons, headings) and icons, not for body text.
- All form inputs have visible labels (no placeholder-only inputs).

### 10.3 Focus States

```scss
&:focus {
    box-shadow: 0 0 0 3px rgba($theme-primary, 0.2);
}
```

Applied to: buttons, inputs, selects, links within nav, pagination items. Visible on keyboard navigation, subtle enough not to distract mouse users.

### 10.4 Form Inputs (Mobile)

```scss
@media (max-width: 767.98px) {
    .form-control, .custom-select, select.form-control {
        min-height: 44px;
        font-size: 16px; // prevents iOS Safari auto-zoom
    }
}
```

---

## 11. Print Styles

**File**: `resources/sass/_print.scss`

**Updates needed** to match brand:

| Element | Current | Target |
|---------|---------|--------|
| Header | None | Brand logo + "SPMS Peternakan" + report title + date |
| Accent color | None | `$theme-primary` (#F28B1E) for table headers, borders |
| Footer | None | "Dicetak dari SPMS Peternakan" + page number |
| Tables | Basic borders | Striped rows, orange header background |

**Print rules** (existing, retained):
- Hide: sidebar, navbar, buttons, pagination, bottom-nav, filter-panel
- Show: content area full-width
- Page breaks: avoid breaking inside cards and table rows
- Font: system serif for readability at 10pt

---

## 12. Shadow Scale

| Level | Value | Usage |
|-------|-------|-------|
| `shadow-sm` | `0 1px 2px rgba(0,0,0,0.04)` | Subtle lift (optional card hover) |
| `shadow-soft` (card default) | `0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06)` | Cards, dropdowns |
| `shadow-md` | `0 4px 12px rgba(0,0,0,0.08)` | Dropdowns, Select2 |
| `shadow-lg` | `0 10px 25px rgba(0,0,0,0.08)` | Modals, elevated overlays |
| `shadow-xl` | `0 20px 60px rgba(0,0,0,0.15)` | Auth card, critical modal |
| `shadow-nav` | `0 -2px 8px rgba(0,0,0,0.06)` | Bottom nav (upward shadow) |
| `shadow-sticky` | `0 -2px 10px rgba(0,0,0,0.08)` | Sticky form actions (upward) |
| `shadow-sidebar` | `2px 0 8px rgba(0,0,0,0.08)` | Sidebar right edge |

---

## 13. Icon System

**Primary**: FontAwesome 5 (included via AdminLTE)
**Secondary**: Bootstrap Icons (loaded as plugin in adminlte.php)

**Rules**:
- Use FontAwesome for action icons (fas fa-plus, fas fa-edit, fas fa-trash)
- Use Bootstrap Icons for supplementary/decorative icons where FA lacks coverage
- Icon size in buttons: inherits font-size
- Icon size in stat cards: 1.1rem
- Icon size in sidebar: 0.9rem, width 1.6rem (centered)
- Icon color follows parent text color unless explicitly overridden

---

## 14. Loading States

### 14.1 Page Load

Branded loading overlay (optional, for slow pages):
- Full-viewport overlay, `$bg-body` background at 0.9 opacity
- Centered: brand logo (48px) + CSS spinner ring in `$theme-primary`
- Auto-dismiss on `DOMContentLoaded`

### 14.2 Button Loading

When form is submitting:
- Button disabled, text replaced with spinner + "Menyimpan..."
- Prevents double-submit
- Implementation: Alpine.js `@submit` handler or vanilla JS

### 14.3 Table Loading (AJAX)

If table data loads via AJAX:
- Skeleton rows: 3 rows of animated gray bars (CSS `@keyframes shimmer`)
- Replaces empty table body during fetch

---

**End of Design System Specification**

---

**Approved by**: (pending Gemi approval — Phase 3 gate)
**Date**: 2026-08-10
