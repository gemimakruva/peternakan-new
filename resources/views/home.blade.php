@extends('adminlte::page')
<style>
.chart-responsive {
    position: relative;
    width: 100%;
    height: 250px; 
}

@media (max-width: 768px) {
    .chart-responsive {
        height: 200px;
    }
}

.scroll-wrapper {
    overflow-x: auto;
    padding-bottom: 8px;
    scrollbar-width: thin;
}

.scroll-wrapper::-webkit-scrollbar {
    height: 6px;
}

.scroll-wrapper::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.chart-container {
    position: relative;
    width: 100%;
    height: 180px; 
}

</style>
@section('content')
<div class="pt-3">
    {{--  ======================  Card Filter ========================== --}}
<div class="card">
       <div class="card-header">
    <h5 class="m-0">Ikhtisam Pemantauan</h5>
</div>

    <div class="card-body">
<div class="row g-3 align-items-end mb-3">

    {{-- Dropdown Kandang --}}
    <div class="col-12 col-sm-6 col-md-3">
        <label class="form-label">Pilih Kandang</label>
        <select class="form-control form-control-sm">
            <option value="">-- Pilih Kandang --</option>
            <option value="A">Kandang A</option>
            <option value="B">Kandang B</option>
            <option value="C">Kandang C</option>
        </select>
    </div>

    {{-- Dropdown Flock --}}
    <div class="col-12 col-sm-6 col-md-3">
        <label class="form-label">Pilih Baris</label>
        <select class="form-control form-control-sm">
            <option value="">-- Pilih Baris --</option>
            <option value="A1">Flock A1</option>
            <option value="A2">Flock A2</option>
            <option value="B1">Flock B1</option>
            <option value="B2">Flock B2</option>
        </select>
    </div>

    {{-- Dropdown Periode --}}
    <div class="col-12 col-sm-6 col-md-3">
        <label class="form-label">Periode Tampilan</label>
        <select class="form-control form-control-sm">
            <option value="daily">Harian</option>
            <option value="weekly">Mingguan</option>
            <option value="monthly">Bulanan</option>
        </select>
    </div>

    {{-- Tanggal Update --}}
    <div class="col-12 col-sm-6 col-md-3 text-md-end">
        <label class="form-label d-block">Terakhir Diperbarui</label>
        <input type="text"
               class="form-control form-control-sm d-inline-block"
               value="11 Nov 2025, 14:35"
               style="max-width: 180px;"
               disabled>
    </div>

</div>


</div>
    {{-- =============== Card Detail Summerly Poluation ================--}}
<div class="row g-3 pb-3 px-2">
    <!-- Umur Ayam -->
    <div class="col-md-3 col-6">
        <div class="d-flex align-items-center gap-3 p-3 rounded shadow-sm bg-white h-100">
            <i class="bi bi-clock-fill text-primary px-3" style="font-size: 1.5rem;"></i>
            <div class="lh-sm">
                <small class="text-muted d-block">Umur</small>
                <span class="fw-semibold">42 Hari</span>
            </div>
        </div>
    </div>

    <!-- Populasi -->
    <div class="col-md-3 col-6">
        <div class="d-flex align-items-center gap-3 p-3 rounded shadow-sm bg-white h-100">
            <i class="bi bi-people-fill text-success px-3" style="font-size: 1.5rem;"></i>
            <div class="lh-sm">
                <small class="text-muted d-block">Populasi</small>
                <span class="fw-semibold">9,847</span>
            </div>
        </div>
    </div>

    <!-- Konsumsi Pakan -->
    <div class="col-md-2 col-6">
        <div class="d-flex align-items-center gap-3 p-3 rounded shadow-sm bg-white h-100">
            <i class="bi bi-basket-fill text-warning px-3" style="font-size: 1.5rem;"></i>
            <div class="lh-sm">
                <small class="text-muted d-block">Pakan/Ekor</small>
                <span class="fw-semibold">125 g</span>
            </div>
        </div>
    </div>

    <!-- Produksi Telur -->
    <div class="col-md-2 col-6">
        <div class="d-flex align-items-center gap-3 p-3 rounded shadow-sm bg-white h-100">
            <i class="bi bi-egg-fill text-purple px-3" style="font-size: 1.5rem;"></i>
            <div class="lh-sm">
                <small class="text-muted d-block">Produksi</small>
                <span class="fw-semibold">87.5%</span>
            </div>
        </div>
    </div>

    <!-- FCR -->
    <div class="col-md-2 col-6">
        <div class="d-flex align-items-center gap-3 p-3 rounded shadow-sm bg-white h-100">
            <i class="bi bi-speedometer2 text-danger px-3" style="font-size: 1.5rem;"></i>
            <div class="lh-sm">
                <small class="text-muted d-block">FCR</small>
                <span class="fw-semibold">2.1</span>
            </div>
        </div>
    </div>
</div>
</div>

    {{-- =============== SAMMURLY PRODUCTION KPI ================--}}

<div class="card align-center">
        <div class="card-header">
            <h5 class="m-0">Ikhtisam Pemantauan</h5>
        </div>

    <div class="card-body">
        <div class="row g-3">

    <!-- Produksi per Kandang -->
    <div class="col-md-3 col-6">
        <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
            <small class="text-muted d-block">Produksi / Kandang</small>
            <div class="fw-bold fs-5">4,230 Butir</div>
        </div>
    </div>

    <!-- Produksi per Hari -->
    <div class="col-md-3 col-6">
        <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
            <small class="text-muted d-block">Produksi / Hari</small>
            <div class="fw-bold fs-5">1,412 Butir</div>
        </div>
    </div>

    <!-- FCR -->
    <div class="col-md-3 col-6">
        <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
            <small class="text-muted d-block">Feed Conversion Ratio</small>
            <div class="fw-bold fs-5">2.08</div>
        </div>
    </div>

    <!-- Berat Telur -->
    <div class="col-md-3 col-6">
        <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
            <small class="text-muted d-block">Berat Telur (Rata-rata)</small>
            <div class="fw-bold fs-5">62 gram</div>
        </div>
    </div>
</div>
</div>
</div>
    {{-- =============== SAMMURLY DIAGRAM FEED INTAKE, EGG PRODUCTION, MORTALITY CULLING ========--}}
<div class="row g-3 mt-4">

    <!-- Diagram Konsumsi Pakan per Ekor -->
    <div class="col-12 col-md-4">
        <div class="card shadow-sm h-fit">
            <div class="card-header">
                <strong>Konsumsi Pakan / Ekor</strong>
            </div>
            <div class="card-body">
                <div class="chart-responsive">
                    <canvas id="feedIntakeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram Produksi Telur -->
    <div class="col-12 col-md-4">
        <div class="card shadow-sm h-fit">
            <div class="card-header">
                <strong>Produksi Telur (%)</strong>
            </div>
            <div class="card-body">
                <div class="chart-responsive">
                    <canvas id="eggProductionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram Kematian & Culling -->
    <div class="col-12 col-md-4">
        <div class="card shadow-sm h-fit">
            <div class="card-header">
                <strong>Kematian & Culling</strong>
            </div>
            <div class="card-body">
                <div class="chart-responsive">
                    <canvas id="mortalityChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- =============== DAILY PRODUCTION RECORD ========--}}
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Catatan Produksi Harian</h5>
        <div x-data="{ open: false }" class="ms-auto position-relative">
            <button 
                @click="open = !open" 
                class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2">
                <i class="bi bi-box-arrow-down"></i>
                Export
            </button>

            <ul 
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="dropdown-menu show"
                style="right: 0; top: 105%; position: absolute;">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                        <i class="bi bi-file-earmark-excel text-success"></i>
                        Export ke Excel
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                        <i class="bi bi-filetype-csv text-primary"></i>
                        Export ke CSV
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                        Export ke PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Populasi</th>
                        <th>Kematian</th>
                        <th>Pemotongan</th>
                        <th>Pakan/Ekor (g)</th>
                        <th>Jumlah Telur</th>
                        <th>Produksi (%)</th>
                        <th>Berat Rata-rata (g)</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Dummy -->
                    <tr>
                        <td>11 Nov 2025</td>
                        <td>9,847</td>
                        <td class="text-danger">3</td>
                        <td class="text-warning">1</td>
                        <td>125</td>
                        <td>8,120</td>
                        <td class="fw-semibold">84,3%</td>
                        <td>61</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>12 Nov 2025</td>
                        <td>9,843</td>
                        <td class="text-danger">2</td>
                        <td class="text-warning">0</td>
                        <td>128</td>
                        <td>8,310</td>
                        <td class="fw-semibold">86,1%</td>
                        <td>62</td>
                        <td>Pakan sedikit meningkat</td>
                    </tr>
                    <tr>
                        <td>13 Nov 2025</td>
                        <td>9,841</td>
                        <td class="text-danger">1</td>
                        <td class="text-warning">0</td>
                        <td>130</td>
                        <td>8,420</td>
                        <td class="fw-semibold">87,5%</td>
                        <td>63</td>
                        <td>Produksi stabil</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 d-flex justify-content-between align-items-center">
            <span class="text-muted">Menampilkan 1 sampai 3 dari 30 Data</span>

            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link">Sebelumnya</a></li>
                    <li class="page-item active"><a class="page-link">1</a></li>
                    <li class="page-item"><a class="page-link">2</a></li>
                    <li class="page-item"><a class="page-link">3</a></li>
                    <li class="page-item"><a class="page-link">Berikutnya</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

 {{-- =============== NOTIFICATION SCEDULE ==============--}}
<div class="row g-3 mt-3">

    {{-- Monitoring Note --}}
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <strong>Monitoring Note</strong>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Pemeriksaan Kesehatan Harian</span>
                        <span class="text-muted">11 Nov 2025</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Pembersihan Litter</span>
                        <span class="text-muted">12 Nov 2025</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Pengecekan Kelembapan & Ventilasi</span>
                        <span class="text-muted">13 Nov 2025</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Treatment Schedule --}}
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <strong>Treatment Schedule</strong>
            </div>
            <div class="card-body">
              <ul class="list-group list-group-flush small">

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>Vitamin & Electrolyte</span>
        <i class="bi bi-bell-fill text-primary"></i>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>Vaksin ND</span>
        <i class="bi bi-bell-fill text-warning"></i>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>Antibiotic Course</span>
        <i class="bi bi-bell-fill text-danger"></i>
    </li>

</ul>

            </div>
        </div>
    </div>
</div>

</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Diagram Konsumsi Pakan per Ekor
    new Chart(document.getElementById('feedIntakeChart'), {
        type: 'line',
        data: {
              labels: ['Minggu 1','Minggu 2','Minggu 3','Minggu 4','Minggu 5'],
            datasets: [
                {
                    label: 'Standar (g)',
                    data: [105, 112, 120, 128, 135, 140], // contoh standar
                    borderWidth: 2,
                    borderColor: '#0d6efd', // biru
                    tension: 0.3
                },
                {
                    label: 'Realita (g)',
                    data: [110, 118, 123, 130, 137, 140], // data aktual
                    borderWidth: 2,
                    borderColor: '#198754', // hijau
                    borderDash: [5,5], // garis putus-putus agar beda
                    tension: 0.3
                }
            ]
        }
    });

    // Diagram Produksi Telur
    new Chart(document.getElementById('eggProductionChart'), {
        type: 'line',
        data: {
            labels: ['Minggu 1','Minggu 2','Minggu 3','Minggu 4','Minggu 5'],
            datasets: [
                {
                    label: 'Standar (%)',
                    data: [70, 75, 82, 88, 92],
                    borderWidth: 2,
                    borderColor: '#0d6efd',
                    tension: 0.3
                },
                {
                    label: 'Realita (%)',
                    data: [72, 78, 83, 87, 90],
                    borderWidth: 2,
                    borderColor: '#198754',
                    borderDash: [5,5],
                    tension: 0.3
                }
            ]
        }
    });

    // Diagram Kematian & Culling
    new Chart(document.getElementById('mortalityChart'), {
        type: 'line',
        data: {
            labels: ['Minggu 1','Minggu 2','Minggu 3','Minggu 4','Minggu 5'],
            datasets: [
                {
                    label: 'Standar (ekor)',
                    data: [3, 5, 5, 6, 6],
                    borderWidth: 2,
                    borderColor: '#0d6efd',
                    tension: 0.3
                },
                {
                    label: 'Realita (ekor)',
                    data: [5, 8, 6, 10, 7],
                    borderWidth: 2,
                    borderColor: '#dc3545', // merah
                    borderDash: [5,5],
                    tension: 0.3
                }
            ]
        }
    });

});
</script>



@endsection
