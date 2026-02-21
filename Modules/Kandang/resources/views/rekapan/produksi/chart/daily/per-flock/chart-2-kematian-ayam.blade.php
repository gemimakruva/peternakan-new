<div class="col-12">
    <h2 class="h4">Data Akumulasi Kematian Ayam</h2>
</div>
<div class="col-12 col-lg-4">
    <div class="card">
        <div class="card-body">
            <canvas id="kematian-ayam-chart-per-flock"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-4">
    <div class="card">
        <div class="card-body">
            <canvas id="kematian-ayam-chart-per-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-4">
    <div class="card">
        <div class="card-body">
            <canvas id="akumulasi-kematian-ayam-chart-per-flock"></canvas>
        </div>
    </div>
</div>
<div class="col-12">
    <x-adminlte-text-editor
        label="Catatan Kematian"
        name="catatan_kematian"
        fgroup-class="mb-2"
        :config="config('adminlte.plugins.Summernote.defaultConfig')"
    >{{ old('catatan_kematian', @$catatanLaporan->catatan_kematian) }}</x-adminlte-text-editor>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('kematian-ayam-chart-per-flock'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'Akumulasi Kematian',
                    data: @js($rekapanFlock->pluck('akumulasi_mati')),
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Afkir',
                    data: @js($rekapanFlock->pluck('akumulasi_afkir')),
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Kematian dan Afkir',
                    data: @js($rekapanFlock->pluck('akumulasi_mati_afkir')),
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
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
                    text: 'Data Kematian Ayam per Flock'
                }
            }
        }
    });

    new Chart(document.getElementById('kematian-ayam-chart-per-kandang'), {
        type: 'bar',
        data: {
            labels: [@js("Data Kandang \"$rekapanKandang->nama_kandang\"")],
            datasets: [
                {
                    label: 'Akumulasi Kematian',
                    data: [@js($rekapanKandang->akumulasi_mati)],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Afkir',
                    data: [@js($rekapanKandang->akumulasi_afkir)],
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Kematian dan Afkir',
                    data: [@js($rekapanKandang->akumulasi_mati_afkir)],
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
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
                    text: @js("Data Kandang \"$rekapanKandang->nama_kandang\"") 
                }
            }
        }
    });

    new Chart(document.getElementById('akumulasi-kematian-ayam-chart-per-flock'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'Akumulasi Kematian',
                    data: @js($rekapanFlock->pluck('persen_mati')),
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Afkir',
                    data: @js($rekapanFlock->pluck('persen_afkir')->map(fn($item) => $item*100)),
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Kematian dan Afkir',
                    data: @js($rekapanFlock->pluck('persen_mati_afkir')->map(fn($item) => $item*100)),
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Standart Kematian dan Afkir',
                    data: @js($rekapanFlock->pluck('standar_mati_afkir')),
                    borderWidth: 2,
                    borderColor: '#1424fdff',
                    backgroundColor: 'rgba(102, 20, 253, 0.1)',
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
                    text: 'Data Kematian Ayam per Flock'
                }
            }
        }
    });
});
</script>
@endpush