<div class="col-12">
    <h2 class="h4">Produksi Telur</h2>
</div>

<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-butir-telur-pipe-chart-semua-flock"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-berat-telur-pipe-chart-semua-flock"></canvas>
        </div>
    </div>
</div>

<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-butir-telur-pie-per-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-berat-telur-pie-per-kandang"></canvas>
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
    new Chart(document.getElementById('produksi-butir-telur-pipe-chart-semua-flock'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'Butir Telur',
                    data: @js($rekapanFlock->pluck('total_jumlah_telur')),
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                // {
                //     label: 'Telur Bagus',
                //     data: @js($rekapanFlock->pluck('jumlah_telur_bagus')),
                //     borderWidth: 2,
                //     borderColor: '#28a745',
                //     backgroundColor: 'rgba(40, 167, 69, 0.1)',
                // },
                // {
                //     label: 'Telur Putih',
                //     data: @js($rekapanFlock->pluck('jumlah_telur_putih')),
                //     borderWidth: 2,
                //     borderColor: '#dc3545',
                //     backgroundColor: 'rgba(220, 53, 69, 0.1)',
                // },
                // {
                //     label: 'Telur Reject',
                //     data: @js($rekapanFlock->pluck('jumlah_telur_reject')),
                //     borderWidth: 2,
                //     borderColor: '#fd7e14',
                //     backgroundColor: 'rgba(253, 126, 20, 0.1)',
                // }
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
                    text: 'Jumlah Butir Telur semua Flock'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('produksi-berat-telur-pipe-chart-semua-flock'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'Berat Telur (Kilogram)',
                    data: @js($rekapanFlock->pluck('total_berat_telur')),
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
                    text: 'Berat Telur semua Flock (Kilogram)'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('produksi-butir-telur-pie-per-kandang'), {
        type: 'pie',
        data: {
            labels: ['Telur Bagus', 'Telur Reject', 'Telur Putih'],
            datasets: [
                {
                    data: [
                        @js($rekapanKandang->jumlah_telur_bagus),
                        @js($rekapanKandang->jumlah_telur_putih),
                        @js($rekapanKandang->jumlah_telur_reject),
                    ],
                    backgroundColor: ['#28a745', '#dc3545', '#fd7e14'],
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
                    text: @js("Data Produksi Telur (Kilogram) Kandang \"$rekapanKandang->nama_kandang\"")
                }
            }
        }
    });
    
    new Chart(document.getElementById('produksi-berat-telur-pie-per-kandang'), {
        type: 'pie',
        data: {
            labels: ['Telur Bagus', 'Telur Reject', 'Telur Putih'],
            datasets: [
                {
                    data: [
                        @js($rekapanKandang->berat_telur_bagus),
                        @js($rekapanKandang->berat_telur_putih),
                        @js($rekapanKandang->berat_telur_reject),
                    ],
                    backgroundColor: ['#28a745', '#dc3545', '#fd7e14'],
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
                    text: @js("Data Produksi Telur (Kilogram) Kandang \"$rekapanKandang->nama_kandang\"")
                }
            }
        }
    });

});
</script>
@endpush