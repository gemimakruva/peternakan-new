<div class="col-12">
    <h2 class="h4">Data Populasi Ayam Minggu Ini</h2>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="populasi-ayam-chart-per-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="populasi-ayam-chart-semua-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12">
    <x-adminlte-text-editor
        label="Catatan Populasi"
        name="catatan_populasi"
        fgroup-class="mb-2"
        :config="config('adminlte.plugins.Summernote.defaultConfig')"
    >{{ old('catatan_populasi', @$catatanLaporan->catatan_populasi) }}</x-adminlte-text-editor>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    Chart.register(ChartDataLabels);

    Chart.defaults.set('plugins.scales', {
        y: {
            beginAtZero: true
        }
    });

    Chart.defaults.set('plugins.datalabels', {
        color: '#000',
        anchor: 'end',
        align: 'bottom',
        formatter: function(value) {
            if (value == 0) return '';
            return Number(value || 0).toFixed(2)
        }
    });

    new Chart(document.getElementById('populasi-ayam-chart-per-kandang'), {
        type: 'bar',
        data: {
            labels: @js($rekapanKandang->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'Ayam Sehat (Fit)',
                    data: @js($rekapanKandang->pluck('sehat')),
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Ayam Mati',
                    data: @js($rekapanKandang->pluck('mati')),
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Ayam Afkir',
                    data: @js($rekapanKandang->pluck('afkir')),
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Masuk Karantina',
                    data: @js($rekapanKandang->pluck('masuk_karantina')),
                    borderWidth: 2,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                },
                {
                    label: 'Keluar Karantina',
                    data: @js($rekapanKandang->pluck('keluar_karantina')),
                    borderWidth: 2,
                    borderColor: '#ff7707ff',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                }
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
                    text: 'Data Populasi Ayam per Kandang'
                }
            }
        }
    });

    new Chart(document.getElementById('populasi-ayam-chart-semua-kandang'), {
        type: 'bar',
        data: {
            labels: ['Semua Kandang'],
            datasets: [
                {
                    label: 'Ayam Sehat (Fit)',
                    data: [@js($rekapanKandang->sum('sehat'))],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Ayam Mati',
                    data: [@js($rekapanKandang->sum('mati'))],
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Ayam Afkir',
                    data: [@js($rekapanKandang->sum('afkir'))],
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Masuk Karantina',
                    data: [@js($rekapanKandang->sum('masuk_karantina'))],
                    borderWidth: 2,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                },
                {
                    label: 'Keluar Karantina',
                    data: [@js($rekapanKandang->sum('keluar_karantina'))],
                    borderWidth: 2,
                    borderColor: '#ff7707ff',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                }
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
                    text: 'Data Populasi Semua Kandang'
                }
            }
        }
    });
});
</script>
@endpush