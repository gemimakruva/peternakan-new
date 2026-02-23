<div class="col-12">
    <h2 class="h4">KPI Produksi</h2>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-kandang-fcr"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-kandang-hdp"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-kandang-hhp"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-kandang-egg-mass"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-kandang-egg-weight"></canvas>
        </div>
    </div>
</div>
<div class="col-12">
    <x-adminlte-text-editor
        label="Catatan KPI Produksi"
        name="catatan_kpi_produksi"
        fgroup-class="mb-2"
        :config="config('adminlte.plugins.Summernote.defaultConfig')"
    >{{ old('catatan_kpi_produksi', @$catatanLaporan->catatan_kpi_produksi) }}</x-adminlte-text-editor>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('kpi-produksi-per-kandang-fcr'), {
        type: 'bar',
        data: {
            labels: @js($kpiProduksi->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'FCR',
                    data: @js($kpiProduksi->pluck('fcr')),
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    borderWidth: 2,
                },
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'KPI Produksi Semua Kandang'
                }
            }
        }
    });

    new Chart(document.getElementById('kpi-produksi-per-kandang-hdp'), {
        type: 'bar',
        data: {
            labels: @js($kpiProduksi->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'HDP',
                    data: @js($kpiProduksi->pluck('hdp')),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderWidth: 2,
                },
            ]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'KPI Produksi Semua Kandang'
                }
            }
        }
    });

    new Chart(document.getElementById('kpi-produksi-per-kandang-hhp'), {
        type: 'bar',
        data: {
            labels: @js($kpiProduksi->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'HHP',
                    data: @js($kpiProduksi->pluck('hhp')),
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderWidth: 2,
                },
            ]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'KPI Produksi Semua Kandang'
                }
            }
        }
    });

    new Chart(document.getElementById('kpi-produksi-per-kandang-egg-mass'), {
        type: 'bar',
        data: {
            labels: @js($kpiProduksi->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'Egg Mass',
                    data: @js($kpiProduksi->pluck('egg_mass')),
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.2)',
                    borderWidth: 2,
                },
            ]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'KPI Produksi Semua Kandang'
                }
            }
        }
    });

    new Chart(document.getElementById('kpi-produksi-per-kandang-egg-weight'), {
        type: 'bar',
        data: {
            labels: @js($kpiProduksi->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'Egg Weight',
                    data: @js($kpiProduksi->pluck('egg_weight')),
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.2)',
                    borderWidth: 2,
                },
            ]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'KPI Produksi Semua Kandang'
                }
            }
        }
    });
});
</script>
@endpush