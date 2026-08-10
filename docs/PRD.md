# PRD — SPMS Peternakan UI/UX Redesign & Mobile

**Project**: SPMS Peternakan (Smart Poultry Management System)
**BRD Reference**: docs/BRD.md (Approved 2026-08-10)
**Class**: A — Production
**Date**: 2026-08-10
**Version**: 1.0

---

## 1. Product Overview

SPMS Peternakan adalah sistem internal berbasis web untuk mengelola operasional peternakan ayam petelur — mulai dari pengadaan ayam, monitoring populasi, perhitungan pakan, produksi telur, sampling, treatment, hingga gudang pakan dan telur.

Proyek ini **bukan pembuatan fitur baru**, melainkan:
1. Audit dan perbaikan UI/UX menyeluruh (visual + fungsional)
2. Rebranding design system ke identitas brand (orange/charcoal chicken-egg logo)
3. Pembuatan tampilan mobile responsive untuk semua role (gaptek-friendly)
4. Perbaikan semua error (runtime, logic, code quality)
5. Penambahan onboarding, empty states, dan branded error pages
6. Lokalisasi penuh ke Bahasa Indonesia
7. Penulisan comprehensive tests (critical-first)

**Codebase**: 288 blade templates (143 Kandang, 68 GudangPakan, 45 GudangTelur, 32 shared), Laravel 12 + AdminLTE 3 + Bootstrap 5.

---

## 2. User Personas

### 2.1 Superadmin
- **Nama**: Pak Budi (pemilik peternakan)
- **Kebutuhan**: Melihat overview seluruh operasional, mengatur user dan permission
- **Pain Points**: Tampilan default AdminLTE terasa generik, tidak mencerminkan brand peternakan; tidak bisa akses dari HP saat di lapangan
- **Device**: Desktop (primary) + Mobile (saat di lapangan)
- **Frekuensi**: Harian (cek dashboard), mingguan (review rekapan)

### 2.2 Admin User
- **Nama**: Bu Sari (admin kantor)
- **Kebutuhan**: Mengelola akun user, assign role, konfigurasi sistem
- **Pain Points**: Form user management tidak responsif di tablet kantor
- **Device**: Desktop (primary)
- **Frekuensi**: Mingguan (tambah/edit user)

### 2.3 Manager Produksi
- **Nama**: Pak Hendra (manager produksi)
- **Kebutuhan**: Melihat rekapan produksi harian/mingguan, monitor KPI, bandingkan performa antar kandang
- **Pain Points**: Tabel rekapan sulit dibaca di mobile; chart tidak responsive; data kadang error (ambiguous column)
- **Device**: Desktop (review data) + Mobile (saat meeting/lapangan)
- **Frekuensi**: Harian

### 2.4 SPV Kandang
- **Nama**: Pak Andi (supervisor kandang)
- **Kebutuhan**: Oversight operasional harian — populasi, pakan, produksi telur, treatment
- **Pain Points**: Harus scroll horizontal di HP untuk lihat tabel; navigasi sidebar terlalu dalam (nested submenu)
- **Device**: Desktop + Mobile (50/50)
- **Frekuensi**: Harian, multiple times

### 2.5 Petugas Kandang
- **Nama**: Mas Joko (petugas lapangan)
- **Kebutuhan**: Input data populasi ayam, catat pemberian pakan, input sampling, lihat jadwal treatment
- **Pain Points**: **Gaptek** — tidak familiar dengan komputer, sering salah klik; form terlalu kecil di HP; tidak ada panduan cara input; halaman kosong membingungkan
- **Device**: **Mobile primary** (HP Android murah, layar 5-6 inch)
- **Frekuensi**: Harian, setiap shift

### 2.6 Dokter Hewan
- **Nama**: Drh. Rina (dokter hewan)
- **Kebutuhan**: Jadwalkan dan catat treatment, monitoring kesehatan, nekropsi
- **Pain Points**: Butuh akses cepat ke treatment dan monitoring dari HP saat di kandang
- **Device**: Mobile (di kandang) + Desktop (buat laporan)
- **Frekuensi**: 3-4x seminggu

### 2.7 Petugas Gudang Telur
- **Nama**: Mas Dedi (petugas gudang telur)
- **Kebutuhan**: Input grading telur, kelola kemasan, catat telur masuk/keluar, opname inventory
- **Pain Points**: Form input kemasan memiliki banyak field; inventory overview sulit dibaca di mobile
- **Device**: Desktop (primary) + Mobile (saat di gudang)
- **Frekuensi**: Harian

### 2.8 Petugas Gudang Pakan
- **Nama**: Mas Agus (petugas gudang pakan)
- **Kebutuhan**: Kelola bahan pakan, input pembelian, mixing, distribusi finished good
- **Pain Points**: Flow mixing pakan multi-step sulit di-navigate; inventory sulit di-track
- **Device**: Desktop (primary) + Mobile (saat di gudang)
- **Frekuensi**: Harian

---

## 3. User Stories

### 3.1 Design System & Branding

**US-DS-01**: Sebagai semua user, saya ingin melihat identitas brand peternakan (logo, warna orange/charcoal) di setiap halaman, sehingga aplikasi terasa profesional dan milik perusahaan.
- **AC**: Given user login, When halaman apapun dimuat, Then sidebar menampilkan logo chicken-egg, warna primary orange (#F28B1E), sidebar charcoal (#2D3436), font Inter.

**US-DS-02**: Sebagai semua user, saya ingin favicon browser menampilkan logo peternakan, sehingga tab browser mudah dikenali.
- **AC**: Given user membuka aplikasi, When halaman dimuat, Then favicon di browser tab menampilkan versi kecil logo chicken-egg.

**US-DS-03**: Sebagai semua user, saya ingin loading spinner yang branded saat halaman dimuat, sehingga terasa konsisten dengan identitas aplikasi.
- **AC**: Given halaman sedang memuat, When loading indicator tampil, Then spinner menggunakan warna orange brand dengan animasi smooth.

**US-DS-04**: Sebagai semua user, saya ingin card, button, table, form, badge, alert, dan pagination memiliki styling yang konsisten dan modern, sehingga aplikasi mudah dibaca dan digunakan.
- **AC**: Given user di halaman manapun, When elemen UI ditampilkan, Then semua komponen menggunakan border-radius konsisten (0.5rem), shadow subtle, spacing yang cukup, dan warna sesuai palette brand.

**US-DS-05**: Sebagai manager/superadmin, saya ingin halaman print report menggunakan brand baru (header, warna, font), sehingga dokumen cetak konsisten dengan tampilan digital.
- **AC**: Given user menekan tombol print/PDF, When halaman cetak dibuka, Then header menampilkan logo + nama peternakan, warna sesuai brand, font legible untuk cetak.

### 3.2 Mobile Responsive

**US-MR-01**: Sebagai petugas kandang, saya ingin mengakses aplikasi dari HP Android (layar 360px), sehingga saya bisa input data langsung dari kandang tanpa perlu ke kantor.
- **AC**: Given user akses dari HP (viewport < 768px), When halaman index (list) dimuat, Then data ditampilkan sebagai card list (bukan tabel), setiap card memiliki info utama + tombol aksi.

**US-MR-02**: Sebagai semua user mobile, saya ingin tombol dan link berukuran minimal 48x48px, sehingga mudah di-tap tanpa salah klik.
- **AC**: Given user di mobile, When elemen interaktif ditampilkan, Then semua button, link, dan input memiliki touch target minimal 48px.

**US-MR-03**: Sebagai semua user mobile, saya ingin tidak perlu scroll horizontal untuk melihat konten, sehingga pengalaman browsing nyaman.
- **AC**: Given user di mobile, When halaman apapun dimuat, Then tidak ada horizontal scroll, semua konten fit dalam viewport width.

**US-MR-04**: Sebagai semua user mobile, saya ingin form input yang mudah diisi di HP, sehingga tidak perlu zoom atau horizontal scroll untuk mengisi form.
- **AC**: Given user di mobile membuka form create/edit, When form ditampilkan, Then semua input field full-width, label di atas field, spacing cukup antar field, keyboard yang sesuai tipe input muncul (number untuk angka, date untuk tanggal).

**US-MR-05**: Sebagai petugas kandang, saya ingin tabel data yang complex ditampilkan sebagai card di HP, sehingga saya bisa membaca data tanpa perlu scroll horizontal.
- **AC**: Given user mobile membuka halaman index dengan tabel, When viewport < 768px, Then tabel diganti card list. Desktop (>= 768px) tetap menampilkan tabel normal.

**US-MR-06**: Sebagai semua user mobile, saya ingin filter/pencarian yang mudah diakses di HP, sehingga bisa mencari data dengan cepat.
- **AC**: Given user di mobile membuka halaman index, When filter panel dimuat, Then filter ditampilkan dalam collapsible panel, tombol "Filter" visible, field filter responsif (col-12 di mobile).

### 3.3 Bottom Navigation

**US-BN-01**: Sebagai petugas kandang (mobile primary), saya ingin bottom navigation bar di HP dengan shortcut ke fitur utama saya (Dashboard, Populasi, Pakan, Sampling, Menu), sehingga tidak perlu buka sidebar setiap kali.
- **AC**: Given user mobile dengan role Petugas Kandang, When halaman dimuat, Then bottom nav menampilkan 5 item: Dashboard, Populasi, Pakan, Sampling, Menu (hamburger). Item aktif diberi highlight. Tap item navigasi ke halaman terkait.

**US-BN-02**: Sebagai user mobile dengan role apapun, saya ingin bottom nav menampilkan menu yang relevan dengan role saya, sehingga navigasi efisien dan tidak membingungkan.
- **AC**: Given user mobile login, When bottom nav ditampilkan, Then item sesuai role mapping:
  - Superadmin: Dashboard, Kandang, Gudang Pakan, Gudang Telur, Menu
  - Admin User: Dashboard, Users, Roles, Settings, Menu
  - Manager Produksi: Dashboard, Rekapan, Populasi, Produksi Telur, Menu
  - SPV Kandang: Dashboard, Populasi, Pakan, Produksi Telur, Menu
  - Petugas Kandang: Dashboard, Populasi, Pakan, Sampling, Menu
  - Dokter Hewan: Dashboard, Treatment, Monitoring, —, Menu
  - Petugas Gudang Telur: Dashboard, Grading, Kemasan, Telur Inventory, Menu
  - Petugas Gudang Pakan: Dashboard, Bahan Pakan, Mixing, Finished Good, Menu

**US-BN-03**: Sebagai user mobile, saya ingin item Menu (hamburger) di bottom nav membuka sidebar navigation lengkap, sehingga semua fitur tetap accessible meskipun tidak ada di shortcut bottom nav.
- **AC**: Given user mobile tap item Menu di bottom nav, When sidebar terbuka, Then sidebar slide-in dari kiri menampilkan full navigation menu.

**US-BN-04**: Sebagai user desktop, saya tidak ingin melihat bottom navigation, sehingga UI desktop tetap bersih.
- **AC**: Given user di desktop (viewport >= 768px), When halaman dimuat, Then bottom nav tidak ditampilkan (d-md-none).

### 3.4 Onboarding & Walkthrough

**US-OB-01**: Sebagai user baru yang pertama kali login, saya ingin guided tour yang menjelaskan area utama dashboard dan cara navigasi sidebar, sehingga saya bisa mulai menggunakan aplikasi tanpa bingung.
- **AC**: Given user login pertama kali (has_seen_tour = false), When dashboard dimuat, Then Shepherd.js walkthrough muncul dengan step-by-step: (1) Selamat datang, (2) Area sidebar — menu utama, (3) Area content — data ditampilkan di sini, (4) Profile/logout, (5) Selesai. Tour auto-save flag ke database saat dismissed/completed.

**US-OB-02**: Sebagai user yang sudah pernah melihat tour, saya ingin bisa membuka panduan lagi kapan saja melalui tombol "Panduan" di header, sehingga saya bisa refresh ingatan.
- **AC**: Given user sudah pernah complete tour, When user klik tombol "Panduan" di navbar, Then walkthrough berjalan ulang dari awal.

**US-OB-03**: Sebagai user mobile yang pertama kali login, saya ingin tour menjelaskan bottom navigation dan cara akses menu lengkap, sehingga saya paham cara navigasi di HP.
- **AC**: Given user mobile login pertama kali, When tour dimulai, Then tour menambahkan step khusus mobile: "Gunakan bar navigasi di bawah untuk akses cepat. Tap Menu untuk melihat semua fitur."

### 3.5 Empty States

**US-ES-01**: Sebagai semua user, saya ingin halaman yang belum memiliki data menampilkan pesan dan ilustrasi yang jelas, sehingga saya tahu apa yang harus dilakukan selanjutnya.
- **AC**: Given user membuka halaman index, When tidak ada data (0 records), Then halaman menampilkan: (1) SVG illustration dari unDraw yang relevan, (2) Teks "Belum ada data [nama item]", (3) Tombol CTA "Tambah [nama item]" (jika user punya permission create). Tidak menampilkan tabel kosong.

**US-ES-02**: Sebagai petugas kandang, saya ingin empty state di halaman populasi ayam yang menjelaskan langkah pertama, sehingga saya tahu harus mulai dari mana.
- **AC**: Given petugas kandang membuka populasi ayam, When belum ada data, Then pesan menampilkan: "Belum ada data populasi ayam. Pastikan pengadaan ayam sudah dicatat, lalu mulai input data populasi harian."

**US-ES-03**: Sebagai semua user, saya ingin chart/grafik yang belum memiliki data menampilkan pesan yang jelas, bukan area kosong atau error.
- **AC**: Given user membuka halaman dengan chart, When chart tidak ada data, Then menampilkan placeholder: "[Ikon grafik] Belum ada data untuk ditampilkan" dengan background abu-abu muda.

### 3.6 Error Pages

**US-EP-01**: Sebagai semua user, saya ingin halaman error (404, 500, 403, 419, 503) menampilkan pesan dalam Bahasa Indonesia dengan branding peternakan, sehingga saya tidak bingung saat menemui error.
- **AC**: Given user menemui error, When error page ditampilkan, Then halaman menampilkan:
  - **404**: Ilustrasi + "Halaman tidak ditemukan" + tombol "Kembali ke Dashboard"
  - **500**: Ilustrasi + "Terjadi kesalahan pada server" + tombol "Kembali ke Dashboard"
  - **403**: Ilustrasi + "Anda tidak memiliki izin untuk mengakses halaman ini" + tombol "Kembali ke Dashboard"
  - **419**: Ilustrasi + "Sesi Anda telah berakhir. Silakan login kembali." + tombol "Login"
  - **503**: Ilustrasi + "Aplikasi sedang dalam pemeliharaan. Silakan coba beberapa saat lagi."
  - Semua halaman menggunakan brand colors, logo, dan font Inter.

### 3.7 Performance

**US-PF-01**: Sebagai semua user, saya ingin setiap halaman dimuat dalam waktu kurang dari 3 detik, sehingga tidak perlu menunggu lama.
- **AC**: Given user navigasi ke halaman manapun, When halaman dimuat, Then Time to Interactive < 3 detik pada koneksi 3G (1.5Mbps).

**US-PF-02**: Sebagai manager produksi yang sering buka rekapan, saya ingin halaman rekapan produksi tidak lemot meskipun banyak data, sehingga review data lancar.
- **AC**: Given user buka rekapan produksi, When halaman dimuat, Then query N+1 ter-eliminate, eager loading diterapkan, kolom yang di-filter/sort memiliki database index.

### 3.8 Bahasa Indonesia

**US-BI-01**: Sebagai petugas kandang yang tidak fasih Bahasa Inggris, saya ingin semua teks di aplikasi dalam Bahasa Indonesia, sehingga saya bisa memahami setiap pesan dan instruksi.
- **AC**: Given user di halaman manapun, When teks UI ditampilkan, Then semua label, tombol, placeholder, pesan sukses, pesan error, dan pesan validasi dalam Bahasa Indonesia.

**US-BI-02**: Sebagai semua user, saya ingin pesan validasi form dalam Bahasa Indonesia, sehingga saya tahu apa yang salah saat input data.
- **AC**: Given user submit form dengan data tidak valid, When validation error muncul, Then pesan dalam Bahasa Indonesia (misal: "Kolom nama wajib diisi" bukan "The name field is required").

**US-BI-03**: Sebagai semua user, saya ingin format tanggal dan angka sesuai standar Indonesia, sehingga data mudah dibaca.
- **AC**: Given angka/tanggal ditampilkan, When data dirender, Then angka menggunakan pemisah ribuan titik dan desimal koma (misal: 1.234,56), tanggal format "10 Agustus 2026".

### 3.9 Code Quality & Bug Fix

**US-BF-01**: Sebagai manager produksi, saya ingin halaman rekapan produksi mingguan tidak error, sehingga saya bisa melihat data produksi per minggu.
- **AC**: Given user buka `/rekapan-produksi/report/weekly`, When halaman dimuat, Then data ditampilkan tanpa error "ambiguous column name". Semua kolom di query ter-qualify dengan table alias.

**US-BF-02**: Sebagai semua user, saya ingin tidak ada halaman yang menampilkan error 500 saat diakses, sehingga semua fitur bisa digunakan.
- **AC**: Given user mengakses halaman manapun yang tersedia di menu, When halaman dimuat, Then response HTTP 200 (atau redirect yang valid). Tidak ada uncaught exception.

**US-BF-03**: Sebagai developer yang melakukan UAT, saya ingin tidak ada deprecation warning di log, sehingga codebase siap untuk upgrade Laravel berikutnya.
- **AC**: Given developer menjalankan aplikasi, When log di-inspect, Then tidak ada deprecation warning dari Laravel, PHP, atau package yang digunakan.

**US-BF-04**: Sebagai SPV Kandang, saya ingin data populasi ayam hanya menggunakan satu implementasi yang benar (v2), sehingga tidak bingung ada 2 halaman populasi yang berbeda.
- **AC**: Given PopulasiAyam v1 dan v2 ada di codebase, When konsolidasi selesai, Then hanya v2 yang tersisa. Route v1 dihapus. Semua referensi mengarah ke v2. Data integrity terjaga.

**US-BF-05**: Sebagai Superadmin, saya ingin menu sidebar "Laporan Mingguan" muncul untuk role yang berhak, sehingga manager produksi bisa akses laporan mingguan.
- **AC**: Given permission string di adminlte.php, When menu di-render, Then typo `psroduksi` diperbaiki menjadi `produksi`. Menu "Laporan Mingguan" tampil untuk role dengan permission `kandang.rekapan.menu-rekapan-produksi`.

**US-BF-06**: Sebagai developer, saya ingin tidak ada orphaned views atau misspelled class names, sehingga codebase bersih dan maintainable.
- **AC**: Given audit codebase, When selesai, Then: (1) vitamin-obat-minum views dihapus (orphaned, no route/controller), (2) `KemasanInventoryShowReposotory.php` di-rename ke `KemasanInventoryShowRepository.php`, (3) `PengadaanAyamSedeer.php` di-rename ke `PengadaanAyamSeeder.php`.

### 3.10 Security

**US-SC-01**: Sebagai admin, saya ingin aplikasi terlindung dari serangan OWASP Top 10, sehingga data peternakan aman.
- **AC**: Given security audit dilakukan, When selesai, Then checklist terpenuhi:
  - [ ] Tidak ada XSS vulnerability (semua output di-escape via Blade `{{ }}`)
  - [ ] Tidak ada SQL injection (semua query via Eloquent/Query Builder)
  - [ ] CSRF protection aktif di semua form
  - [ ] Tidak ada auth bypass (semua route protected by middleware)
  - [ ] Tidak ada hardcoded secrets di code
  - [ ] User input divalidasi di setiap endpoint
  - [ ] File upload divalidasi (type, size)

### 3.11 Testing

**US-TS-01**: Sebagai developer UAT, saya ingin test suite yang memverifikasi auth flow, sehingga login/logout/register berfungsi dengan benar.
- **AC**: Given test suite dijalankan, When auth tests berjalan, Then: login sukses, login gagal (wrong password), register, logout — semua pass.

**US-TS-02**: Sebagai developer UAT, saya ingin test suite yang memverifikasi permission setiap route untuk setiap role, sehingga RBAC benar-benar enforced.
- **AC**: Given test suite dijalankan, When permission tests berjalan, Then: setiap route ditest dengan setiap role. Authorized role mendapat 200/302. Unauthorized role mendapat 403. Matrix: ~100 routes × 8 roles.

**US-TS-03**: Sebagai developer UAT, saya ingin test suite yang memverifikasi business logic kritis (kalkulasi produksi, populasi, rekapan), sehingga data yang ditampilkan akurat.
- **AC**: Given test suite dijalankan, When business logic tests berjalan, Then: kalkulasi akumulasi mati, persentase kematian, feed intake per ekor, HDP, HHP, FCR, egg weight, egg mass — semua menghasilkan nilai yang benar berdasarkan data input yang diketahui.

---

## 4. Non-Functional Requirements

### 4.1 Performance
| Metric | Target |
|--------|--------|
| Time to Interactive | < 3 detik (3G / 1.5 Mbps) |
| First Contentful Paint | < 1.5 detik |
| N+1 Queries | Zero |
| Database Indexes | Semua kolom yang di-WHERE/ORDER BY |
| Asset Size | CSS + JS bundled < 500KB gzipped |

### 4.2 Security (OWASP Top 10 Basic)
| Check | Method |
|-------|--------|
| XSS | Blade auto-escape, no `{!! !!}` tanpa sanitize |
| SQL Injection | Eloquent/Query Builder only, no raw user input |
| CSRF | `@csrf` di semua form, verified by middleware |
| Auth Bypass | `auth` middleware di semua protected routes |
| Secrets | No hardcoded credentials, all via `.env` |
| Input Validation | `FormRequest` atau inline validation di setiap store/update |
| File Upload | Validate mime type, max size, sanitize filename |

### 4.3 Browser Support (Progressive Enhancement)
| Tier | Browsers | Support |
|------|----------|---------|
| **Full** | Chrome (Android + Desktop), Edge, Firefox, Safari | 100% fitur |
| **Enhanced Degradation** | UC Browser, Android WebView | Core CRUD + navigation. No: walkthrough, Chart.js, complex animations |
| **Basic** | Opera Mini | HTML + CSS rendering only. No JavaScript-dependent features |

Strategy: Feature detection via `@supports` dan `if (typeof X !== 'undefined')`. Core functionality (navigate, CRUD, read data) harus jalan tanpa JavaScript.

### 4.4 Accessibility
| Requirement | Standard |
|-------------|----------|
| Touch targets | Min 48×48px |
| Color contrast | WCAG AA (4.5:1 text, 3:1 large text) |
| Form labels | Semua input memiliki `<label>` yang ter-associate |
| Focus indicators | Visible focus ring pada keyboard navigation |
| Alt text | Semua `<img>` memiliki alt text deskriptif |

### 4.5 Code Quality
| Metric | Target |
|--------|--------|
| File size | < 300 baris per file |
| Separation of concerns | Controller thin, logic di Service/Repository |
| Naming | Konsisten dengan domain (Bahasa Indonesia untuk domain terms) |
| Deprecations | Zero deprecation warnings |

---

## 5. Modules & Features Matrix

### 5.1 Shared / Core (32 templates)

| Area | Templates | Changes Needed |
|------|-----------|----------------|
| **Auth** (login, register, password) | 6 | Brand styling, responsive form, Bahasa Indonesia messages |
| **Components** (page-header, mobile-card, filter-panel, stat-card, pagination, sort-th, form-alert, snackbar) | 8 | Review existing, ensure brand compliance, add empty-state component |
| **Layouts** (app, dashboard, print) | 3 | Inject bottom nav, walkthrough init, brand loading spinner, language tag |
| **Dashboard** (home) | 1 | Brand welcome, role-based content, empty state for fresh install |
| **User CRUD** | 4 | Mobile card views, brand styling, Bahasa Indonesia |
| **Role CRUD** | 4 | Mobile card views, brand styling, Bahasa Indonesia |
| **Settings** | 2 | Brand styling, responsive |
| **Notifications** | 1 | Brand styling |
| **Welcome/Landing** | 1 | Brand landing page |
| **Error Pages** (NEW) | 5 | Create: 404, 500, 403, 419, 503 |
| **SCSS** (_theme, _variables, _print, dashboard) | 4 | Review existing brand colors, update print styles |

### 5.2 Module Kandang (143 templates)

| Feature Area | Templates | Changes Needed |
|-------------|-----------|----------------|
| **Master Data: Peternakan** | 4 | Mobile card, brand styling, Bahasa Indonesia |
| **Master Data: Kandang** | 8+4+3 = 15 | Mobile card, brand styling, nested flock/pipe responsive |
| **Master Data: Flock** | 3 | Mobile card, brand styling |
| **Master Data: Pipe** | 4 | Mobile card, brand styling |
| **Master Data: Jenis Pakan** | 4 | Mobile card, brand styling |
| **Master Data: Jenis Treatment** | 4 | Mobile card, brand styling |
| **Master Data: Metode Treatment** | 4 | Mobile card, brand styling |
| **Master Data: Strain Ayam** | 1 | Mobile card, brand styling |
| **Pengadaan Ayam** | 8 | Mobile card, complex form responsive, document upload UI |
| **Populasi Ayam (v1)** | 9 | **DELETE** — consolidate to v2 |
| **Populasi Ayam v2** | 6 | Mobile card, form responsive, Bahasa Indonesia |
| **Ayam Afkir** | 3 | Mobile card, brand styling |
| **Ayam Karantina** | 5 | Mobile card, brand styling, overview responsive |
| **Perhitungan Pakan** | 7 | Mobile card, complex form responsive, Bahasa Indonesia |
| **Pemberian Pakan Sisa Pakan** | 4 | Mobile card, brand styling |
| **Recording Telur** | 5 | Mobile card, brand styling |
| **Sampling Ayam** | 5 | Mobile card, brand styling |
| **Treatment** | 4 | Mobile card, brand styling |
| **Treatment Pelaksanaan** | 3 | Mobile card, calendar/jadwal responsive |
| **Monitoring Kesehatan** | 5 | Mobile card, form responsive (nekropsi), Bahasa Indonesia |
| **Rekapan Produksi** | 12 | Fix ambiguous column, responsive charts, print brand update |
| **Rekapan Charts** (daily + weekly × per-kandang + per-flock) | 20 | Responsive Chart.js, empty state, progressive enhancement |
| **Rekapan Pakan** | 1 | Mobile card, brand styling |
| **Rekapan Populasi Ayam** | 1 | Mobile card, brand styling |
| **Rekapan Produksi Telur** | 1 | Mobile card, brand styling |
| **Vitamin Obat Minum** | 4 | **DELETE** — orphaned (no route/controller) |
| **Component Layout** | 1 | **DELETE** — replaced by shared dashboard layout |

### 5.3 Module GudangPakan (68 templates)

| Feature Area | Templates | Changes Needed |
|-------------|-----------|----------------|
| **Master Data: Bahan Pakan** | 5 | Mobile card, price history table responsive |
| **Supplier Bahan Pakan** | 5 | Mobile card, brand styling |
| **Bahan Pakan Pembelian** | 5 | Mobile card, multi-item form responsive |
| **Bahan Pakan Masuk** | 5 | Mobile card, multi-item form responsive |
| **Bahan Pakan Keluar** | 5 | Mobile card, brand styling |
| **Bahan Pakan Opname** | 5 | Mobile card, opname list responsive |
| **Bahan Pakan Inventory** | 2 | Mobile card, inventory show detail responsive |
| **Bahan Pakan Formulasi** | 6 | Mobile card, complex formulasi form responsive |
| **Pakan Pre-Mixing** | 5 | Mobile card, detail view responsive |
| **Pakan Pre-Mixing Inventory** | 2 | Mobile card, brand styling |
| **Pakan Pre-Mixing Opname** | 5 | Mobile card, opname form responsive |
| **Pakan Mixing** | 5 | Mobile card, detail view responsive |
| **Pakan Finished Good Inventory** | 2 | Mobile card, brand styling |
| **Pakan Finished Good Opname** | 5 | Mobile card, opname form responsive |
| **Pakan Finished Good Distribusi** | 4 | Mobile card, brand styling |
| **Component Layout** | 1 | **DELETE** — replaced by shared dashboard layout |
| **Module Index** | 1 | Brand styling |

### 5.4 Module GudangTelur (45 templates)

| Feature Area | Templates | Changes Needed |
|-------------|-----------|----------------|
| **Master Data: Kemasan** | 5 | Mobile card, price history responsive |
| **Supplier** | 5 | Mobile card, brand styling |
| **Kemasan Input** | 4 | Mobile card, brand styling |
| **Kemasan Output** | 4 | Mobile card, brand styling |
| **Kemasan Opname** | 4 | Mobile card, opname form responsive |
| **Kemasan Inventory** | 2 | Mobile card, show detail responsive |
| **Grading Telur** | 4 | Mobile card, grading detail responsive |
| **Telur Masuk** | 4 | Mobile card, brand styling |
| **Telur Keluar** | 6 | Mobile card, multi-list form responsive |
| **Telur Opname** | 4 | Mobile card, brand styling |
| **Telur Inventory** | 1 | Mobile card, brand styling |
| **Component Layout** | 1 | **DELETE** — replaced by shared dashboard layout |
| **Module Index** | 1 | Brand styling |

### 5.5 Summary

| Module | Total Templates | Delete | Modify | New |
|--------|----------------|--------|--------|-----|
| Shared | 32 | 0 | 27 | 6 (error pages + empty-state component) |
| Kandang | 143 | 14 (v1 populasi + vitamin + component layout) | 129 | 0 |
| GudangPakan | 68 | 1 (component layout) | 67 | 0 |
| GudangTelur | 45 | 1 (component layout) | 44 | 0 |
| **Total** | **288** | **16** | **267** | **6** |

---

## 6. Test Requirements

### Priority 1 — Critical (Must-have sebelum UAT)

| Test Category | Scope | Est. Test Cases |
|--------------|-------|-----------------|
| **Auth Flow** | Login, logout, register, forgot password, session expired | ~15 |
| **Permission Matrix** | ~100 routes × 8 roles (authorized vs unauthorized) | ~800 assertions |
| **Business Logic** | Kalkulasi: akumulasi mati, % kematian, feed intake, HDP, HHP, FCR, egg weight, egg mass | ~30 |
| **Data Integrity** | PopulasiAyam v2 CRUD, query tanpa ambiguous columns | ~20 |

### Priority 2 — Important (Backlog, setelah UAT round 1)

| Test Category | Scope | Est. Test Cases |
|--------------|-------|-----------------|
| **CRUD Operations** | Create/Read/Update/Delete per feature per role | ~200 |
| **Validation** | Form validation rules per feature | ~100 |
| **Edge Cases** | Zero data, max values, concurrent edits | ~50 |
| **Mobile Rendering** | Responsive breakpoints per template category | ~40 |

### Priority 3 — Nice-to-have

| Test Category | Scope | Est. Test Cases |
|--------------|-------|-----------------|
| **Browser Compat** | Cross-browser rendering check | Manual |
| **Performance** | Load time per page category | ~20 |
| **Accessibility** | WCAG AA compliance per template | ~40 |

---

## 7. Dependencies & Risks

### Dependencies
| # | Dependency | Impact | Mitigation |
|---|-----------|--------|------------|
| D1 | AdminLTE 3 structure | Redesign terbatas pada override CSS, tidak bisa ubah HTML structure AdminLTE | CSS override layer pattern — semua custom styling via SCSS variables + overrides |
| D2 | Shepherd.js (new dependency) | Walkthrough bergantung pada library external | Pin version, bundle locally, progressive enhancement (jalan tanpa walkthrough) |
| D3 | unDraw SVG illustrations | Availability dan licensing | MIT license, download dan bundle locally, tidak bergantung pada CDN |
| D4 | Existing seed data | UAT bergantung pada kecukupan data demo | Verify semua module memiliki seed data, tambah jika kurang |
| D5 | PHP 8.2+ | composer.lock requires PHP 8.2 minimum | Verify developer team memiliki PHP 8.2+ |

### Risks
| # | Risk | Likelihood | Impact | Mitigation |
|---|------|-----------|--------|------------|
| R1 | AdminLTE CSS override conflicts dengan upgrade AdminLTE | Medium | Medium | Pin AdminLTE version, scope semua override ke custom namespace |
| R2 | PopulasiAyam v1→v2 consolidation breaks existing data | Low | High | Backup database sebelum migration, verify semua query v2 menghasilkan data yang sama dengan v1 |
| R3 | Opera Mini / UC Browser rendering broken | Medium | Low | Progressive enhancement — core tetap jalan, enhanced features degrade gracefully |
| R4 | Test coverage menambah waktu delivery signifikan | High | Medium | Critical-first delivery — auth + permissions + business logic dulu, sisanya backlog |
| R5 | 267 templates yang harus dimodify — scope creep | Medium | High | Batch per module, review per batch, automated testing per batch |

---

## 8. Glossary (Domain Terms)

| Term | Definition |
|------|-----------|
| **Flock** | Kelompok ayam dalam satu batch pengadaan di satu kandang |
| **Pipe** | Sub-group ayam dalam satu flock (biasanya per baris/lorong kandang) |
| **Populasi Ayam** | Data harian jumlah ayam sehat, mati, afkir per kandang/flock/pipe |
| **HDP** (Hen Day Production) | Persentase produksi telur per hari = jumlah telur / jumlah ayam hidup |
| **HHP** (Hen Housed Production) | Persentase produksi telur per hari = jumlah telur / jumlah ayam awal (pengadaan) |
| **FCR** (Feed Conversion Ratio) | Efisiensi pakan = berat pakan / berat telur |
| **Egg Mass** | HHP × berat rata-rata telur |
| **Feed Intake** | Jumlah pakan yang dikonsumsi per ekor per hari (gram) |
| **Opname** | Stock taking / penghitungan stok fisik vs stok sistem |
| **Grading** | Proses sortasi telur berdasarkan kualitas (bagus, putih, reject) |
| **Pre-Mixing** | Pencampuran awal bahan pakan sebelum mixing utama |
| **Finished Good** | Pakan jadi hasil mixing yang siap didistribusikan ke kandang |
| **Treatment** | Pemberian vitamin/obat/vaksin pada ayam |
| **Afkir** | Ayam yang dikeluarkan dari produksi karena tidak produktif |
| **Karantina** | Pemisahan ayam sakit/bermasalah dari populasi utama |

---

**Document Status**: Complete
**Next Phase**: Phase 3 — UI/UX Design (DESIGN.md + Interactive Mockup)
