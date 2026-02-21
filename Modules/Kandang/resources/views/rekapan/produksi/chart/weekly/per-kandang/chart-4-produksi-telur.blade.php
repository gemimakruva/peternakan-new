<div class="col-12">
    <h2 class="h4">Produksi Telur</h2>
</div>

<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-butir-telur-pipe-chart-semua-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-berat-telur-pipe-chart-semua-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-butir-telur-pie-semua-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-berat-telur-pie-semua-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12">
    <x-adminlte-text-editor
        label="Catatan Produksi Telur"
        name="catatan_produksi_telur"
        fgroup-class="mb-2"
        :config="config('adminlte.plugins.Summernote.defaultConfig')"
    >{{ old('catatan_produksi_telur', @$catatanLaporan->catatan_produksi_telur) }}</x-adminlte-text-editor>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('produksi-butir-telur-pipe-chart-semua-kandang'), {
        type: 'bar',
        data: {
            labels: @js($rekapanKandang->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'Butir Telur',
                    data: @js($rekapanKandang->pluck('total_jumlah_telur')),
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
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
                    text: 'Jumlah Butir Telur semua Kandang'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('produksi-berat-telur-pipe-chart-semua-kandang'), {
        type: 'bar',
        data: {
            labels: @js($rekapanKandang->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'Berat Telur (Kilogram)',
                    data: @js($rekapanKandang->pluck('total_berat_telur')),
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
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
                    text: 'Berat Telur semua Kandang (Kilogram)'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('produksi-butir-telur-pie-semua-kandang'), {
        type: 'pie',
        data: {
            labels: @js($rekapanKandang->pluck('nama_kandang')),
            datasets: [
                {
                    data: @js($rekapanKandang->pluck('total_jumlah_telur')),
                    hoverOffset: 4,
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
                    text: 'Jumlah Produksi Telur - Semua Kandang'
                }
            }
        }
    });

    new Chart(document.getElementById('produksi-berat-telur-pie-semua-kandang'), {
        type: 'pie',
        data: {
            labels: @js($rekapanKandang->pluck('nama_kandang')),
            datasets: [
                {
                    data: @js($rekapanKandang->pluck('total_berat_telur')),
                    hoverOffset: 4,
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
                    text: 'Produksi Telur (Kilogram) - Semua Kandang'
                }
            }
        }
    });
});
</script>
@endpush