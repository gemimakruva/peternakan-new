<div class="col-12">
    <h2 class="h4">Data Konsumsi Ayam</h2>
</div>
<div class="col-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <canvas id="feed-intake-ayam-chart-per-flock"></canvas>
        </div>
    </div>
</div>
<div class="col-12">
    <x-adminlte-text-editor
        label="Catatan Konsumsi"
        name="catatan_konsumsi"
        fgroup-class="mb-2"
        :config="config('adminlte.plugins.Summernote.defaultConfig')"
    >{{ old('catatan_konsumsi', @$catatanLaporan->catatan_konsumsi) }}</x-adminlte-text-editor>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    
    new Chart(document.getElementById('feed-intake-ayam-chart-per-flock'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'Realisasi',
                    data: @js($rekapanFlock->pluck('feed_intake_per_ekor')),
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Standar',
                    data: @js($rekapanFlock->pluck('feed_intake_per_ekor_standar')),
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
                    text: 'Konsumsi Rata-rata per Ekor Ayam per Flock'
                }
            }
        }
    });

});
</script>
@endpush