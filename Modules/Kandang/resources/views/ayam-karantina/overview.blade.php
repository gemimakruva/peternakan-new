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
<div class="pt-3" style="max-width: 1200px; padding: 0 15px;">
    {{--  ======================  Card Filter ========================== --}}
    <div class="card">
            <div class="card-header">
            <h5 class="m-0">Ikhtisam Ayam Karantina</h5>
        </div>
    <div class="card-body">
    </div>
        {{-- =============== Card Detail Summerly Poluation ================--}}
    <div class="row g-3 pb-3 px-2">
            <!-- Total Ayam Masuk Karantina -->
        <div class="col-xl-3 col-lg-3 col-md-4 col-6">
            <div class="d-flex justify-content-between align-items-center p-3 rounded shadow-sm bg-white h-100 w-100">
                <i class="bi bi-box-arrow-in-right text-primary d-flex align-items-center justify-content-center"
                style="
                    font-size: 1.2rem;
                    background: rgba(13, 110, 253, .15);
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                ">
                </i>
                <div class="lh-sm text-end">
                    <small class="text-muted d-block">Masuk Karantina</small>
                    <span class="fw-semibold fs-6">42 Ekor</span>
                </div>
            </div>
        </div>

            <!-- Total Ayam Mati  -->
            <div class="col-md-3 col-6">
                <div class="d-flex justify-content-between align-items-center p-3 rounded
                shadow-sm bg-white h-100 w-100">
                    <i class="bi bi-x-circle-fill text-danger d-flex
                    align-items-center justify-content-center"
                    style="
                        font-size: 1.2rem;
                        background: rgba(220, 53, 69, .15);
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                    ">
                    </i>
                    <div class="lh-sm text-end">
                        <small class="text-muted d-block">Ayam Mati</small>
                        <span class="fw-semibold fs-6">125</span>
                    </div>
                </div>
            </div>
            <!-- Total Ayam Afkir -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="d-flex justify-content-between align-items-center p-3 rounded shadow-sm
                bg-white h-100 w-100">
                    <i class="bi bi-scissors text-warning d-flex align-items-center
                    justify-content-center"
                    style="
                        font-size: 1.2rem;
                        background: rgba(255, 193, 7, .18);
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                    ">
                    </i>
                    <div class="lh-sm text-end">
                        <small class="text-muted d-block">Ayam Afkir</small>
                        <span class="fw-semibold fs-6">125 Ekor</span>
                    </div>
                </div>
            </div>


            <!-- Total Ayam Keluar Karantina -->
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center gap-3 p-3 rounded shadow-sm bg-white h-100">
                    <i class="bi bi-arrow-up-circle-fill text-success mr-2 d-flex align-items-center
                    justify-content-center"
                    style="
                        font-size: 1.3rem;
                        background: rgba(25, 135, 84, .18);
                        width: 42px;
                        height: 42px;
                        border-radius: 50%;
                    ">
                    </i>
                    <div class="lh-sm">
                        <small class="text-muted d-block">Ayam Keluar Karantina</small>
                        <span class="fw-semibold fs-6">120 Ekor</span>
                    </div>
                </div>
        </div>
    </div>
    </div>

    {{-- =============== SAMMURLY PAKAN DAN TELUR KARANTINA ================--}}

<div class="card align-center">
        <div class="card-header">
            <h5 class="m-0">Ikhtisam Pemantauan</h5>
        </div>

         <div  div class="card-body">
            <div class="row g-3">

                <!-- Total Pemberian Pakan -->
                <div class="col-md-2 col-6">
                    <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
                        <small class="text-muted d-block">Total Pemberian Pakan</small>
                        <div class="fw-bold fs-5">20 Kg</div>
                    </div>
                </div>

                <!-- Total Sisa Pakan-->
                <div class="col-md-3 col-6">
                    <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
                        <small class="text-muted d-block">Total Sisa Pakan</small>
                        <div class="fw-bold fs-5">1,412 Kg</div>
                    </div>
                </div>

                <!-- Total Telur Bagus  -->
                <div class="col-md-2 col-6">
                    <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
                        <small class="text-muted d-block">Total Telur Bagus</small>
                        <div class="fw-bold fs-5">2.08 Kg</div>
                    </div>
                </div>

                <!-- Total Telur Retak -->
                <div class="col-md-2 col-6">
                    <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
                        <small class="text-muted d-block">Total telur retak</small>
                        <div class="fw-bold fs-5">62 Kg</div>
                    </div>
                </div>
            <!-- Total Telur rusak -->
                <div class="col-md-2 col-6">
                    <div class="p-3 rounded shadow-sm bg-white h-100 text-center">
                        <small class="text-muted d-block">Total telur rusak</small>
                        <div class="fw-bold fs-5">62 Kg</div>
                    </div>
                </div>
             </div>
        </div>
</div>
    {{-- =============== SAMMURLY DIAGRAM FEED INTAKE, EGG PRODUCTION, MORTALITY CULLING ========--}}
<div class="row g-3 mt-4">
    <!-- Diagram Populasi Ayam Karantina -->
    <div class="col-12">
        <div class="card shadow-sm h-fit">
            <div class="card-header">
                <strong>Populasi Ayam Karantina</strong>
            </div>
            <div class="card-body">
                <div class="chart-responsive">
                    <canvas id="populasiKarantinaChart" class="w-100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


    {{-- =============== DAILY PRODUCTION RECORD ========--}}
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold" style="flex: 1;">Catatan Produksi Harian</h5>
        <div x-data="{ open: false }" class="position-relative">
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

     <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                {{-- Column Headers --}}
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Tanggal Karantina</th>
                        <th>Nama Pencatat</th>
                        <th>Identitas Populasi</th>
                        <th>Ayam Masuk</th>
                        <th>Ayam Mati</th>
                        <th>Ayam Afkir</th>
                        <th>Ayam Keluar</th>
                        <th>Pakan Diberikan (kg)</th>
                        <th>Sisa Pakan (kg)</th>
                        <th>Telur Bagus</th>
                        <th>Telur retak</th>
                         <th>Telur rusak</th>
                        <th>Pengobatan</th>
                        <th>Jumlah Ayam Diobati</th>
                        <th>Penyemprotan</th>
                        <th>Vaksin</th>
                        <th>Catatan</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
              <tbody>
                @forelse($listAyamKarantina as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_karantina)
                     ->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $item->picUser->name ?? '-' }}</td>
                    <td>
                        <button class="btn btn-info btn-sm"
                            onclick="showPopulasi('{{ $item->populasi->kandang->nama ?? '-' }}',
                                                '{{ $item->populasi->flock->nama ?? '-' }}',
                                                '{{ $item->populasi->pipe->nama ?? '-' }}')">
                            Lihat
                        </button>
                    </td>
                    <td>{{ $item->ayam_masuk_karantina ?? 0 }}</td>
                    <td>{{ $item->ayam_mati ?? 0 }}</td>
                    <td>{{ $item->ayam_afkir ?? 0 }}</td>
                    <td>{{ $item->ayam_keluar_karantina ?? 0 }}</td>
                    <td>{{ $item->pemberian_pakan ?? 0 }}</td>
                    <td>{{ $item->sisa_pakan ?? 0 }}</td>
                    <td>{{ $item->jumlah_telur_bagus ?? 0 }}</td>
                    <td>{{ $item->jumlah_telur_retak ?? 0 }}</td>
                    <td>{{ $item->jumlah_telur_rusak ?? 0 }}</td>
                    <td>{{ $item->pengobatan_yang_dilakukan ?? '-' }}</td>
                    <td>{{ $item->jumlah_ayam_diobati ?? 0 }}</td>
                    <td>{{ $item->penyemprotan ?? '-' }}</td>
                    <td>{{ $item->vaksin ?? '-' }}</td>
                    <td>
                        <button onclick="showCatatan(`{{ $item->catatan ?? 'Tidak ada catatan' }}`)"
                                class="btn btn-warning btn-sm">
                            Detail
                        </button>
                    </td>
                    <td>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="18" class="text-center text-muted">
                            Data Ayam Karantina belum tersedia</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('populasiKarantinaChart').getContext('2d');

    // Data dummy
    const minggu = ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4", "Minggu 5"];
    const populasiNyata = [1000, 980, 955, 930, 905]; // Data populasi aktual
    const standarPopulasi = [1000, 995, 990, 985, 980]; // Standar ideal

    new Chart(ctx, {
        type: "line",
        data: {
            labels: minggu,
            datasets: [
                {
                    label: "Populasi Aktual",
                    data: populasiNyata,
                    borderColor: "#0d6efd",
                    backgroundColor: "rgba(13, 110, 253, .3)",
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: "Standar Ideal",
                    data: standarPopulasi,
                    borderColor: "#dc3545",
                    backgroundColor: "rgba(220, 53, 69, .3)",
                    borderWidth: 2,
                    tension: 0.3,
                    fill: false,
                    borderDash: [6,3] // garis putus-putus
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    title: {
                        display: true,
                        text: "Jumlah Populasi (Ekor)"
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: "Minggu Karantina"
                    }
                }
            }
        }
    });
});
</script>





@endsection
