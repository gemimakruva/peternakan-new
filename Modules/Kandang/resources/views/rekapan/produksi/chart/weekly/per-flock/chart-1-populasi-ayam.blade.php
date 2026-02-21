<div class="col-12">
    <h2 class="h4">Data Populasi Ayam Hari Ini</h2>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="populasi-ayam-chart-per-flock"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="populasi-ayam-chart-per-kandang"></canvas>
        </div>
    </div>
</div>


@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('populasi-ayam-chart-per-flock'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'Ayam Sehat (Fit)',
                    data: @js($rekapanFlock->pluck('sehat')),
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Ayam Mati',
                    data: @js($rekapanFlock->pluck('mati')),
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Ayam Afkir',
                    data: @js($rekapanFlock->pluck('afkir')),
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Masuk Karantina',
                    data: @js($rekapanFlock->pluck('masuk_karantina')),
                    borderWidth: 2,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                },
                {
                    label: 'Keluar Karantina',
                    data: @js($rekapanFlock->pluck('keluar_karantina')),
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
                    text: 'Data Populasi Ayam per Flock'
                }
            }
        }
    });

    new Chart(document.getElementById('populasi-ayam-chart-per-kandang'), {
        type: 'bar',
        data: {
            labels: [@js("Data Kandang \"$rekapanKandang->nama_kandang\"")],
            datasets: [
                {
                    label: 'Ayam Sehat (Fit)',
                    data: [@js($rekapanKandang->sehat)],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Ayam Mati',
                    data: [@js($rekapanKandang->mati)],
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Ayam Afkir',
                    data: [@js($rekapanKandang->afkir)],
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Masuk Karantina',
                    data: [@js($rekapanKandang->masuk_karantina ?? 0)],
                    borderWidth: 2,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                },
                {
                    label: 'Keluar Karantina',
                    data: [@js($rekapanKandang->keluar_karantina ?? 0)],
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
                    text: @js("Data Kandang \"$rekapanKandang->nama_kandang\"")
                }
            }
        }
    });
});
</script>
@endpush