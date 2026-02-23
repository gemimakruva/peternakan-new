<div class="col-12">
    <h2 class="h4">KPI Produksi</h2>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-flock-fcr"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-flock-hdp"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-flock-hhp"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-flock-egg-mass"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-flock-egg-weight"></canvas>
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
    new Chart(document.getElementById('kpi-produksi-per-flock-fcr'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'FCR',
                    data: @js($rekapanFlock->pluck('fcr')),
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    borderWidth: 2,
                },
            ]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'KPI Produksi per Flock - FCR'
                }
            }
        }
    });

    new Chart(document.getElementById('kpi-produksi-per-flock-hdp'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'HDP',
                    data: @js($rekapanFlock->pluck('hdp')->map(fn($hdp) => $hdp * 100)),
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
                    text: 'KPI Produksi per Flock - HDP'
                }
            }
        }
    });

    new Chart(document.getElementById('kpi-produksi-per-flock-hhp'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'HHP',
                    data: @js($rekapanFlock->pluck('hhp')->map(fn($hhp) => $hhp * 100)),
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
                    text: 'KPI Produksi per Flock - HHP'
                }
            }
        }
    });

    new Chart(document.getElementById('kpi-produksi-per-flock-egg-mass'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'Egg Mass',
                    data: @js($rekapanFlock->pluck('egg_mass')),
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
                    text: 'KPI Produksi per Flock - Egg Mass'
                }
            }
        }
    });

    new Chart(document.getElementById('kpi-produksi-per-flock-egg-weight'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'Egg Weight',
                    data: @js($rekapanFlock->pluck('egg_weight')),
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
                    text: 'KPI Produksi per Flock - Egg Weight'
                },
            }
        }
    });
});
</script>
@endpush