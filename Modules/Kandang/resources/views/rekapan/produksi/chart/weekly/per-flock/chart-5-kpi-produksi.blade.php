<div class="col-12">
    <h2 class="h4">KPI Produksi</h2>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-flock"></canvas>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('kpi-produksi-per-flock'), {
        type: 'bar',
        data: {
            labels: @js($rekapanFlock->pluck('nama_flock')),
            datasets: [
                {
                    label: 'FCR',
                    data: @js($rekapanFlock->pluck('fcr')),
                    borderWidth: 2,
                },
                {
                    label: 'HDP',
                    data: @js($rekapanFlock->pluck('hdp')),
                    borderWidth: 2,
                },
                {
                    label: 'HHP',
                    data: @js($rekapanFlock->pluck('hhp')),
                    borderWidth: 2,
                },
                {
                    label: 'Egg Mass',
                    data: @js($rekapanFlock->pluck('egg_mass')),
                    borderWidth: 2,
                },
                {
                    label: 'Egg Weight',
                    data: @js($rekapanFlock->pluck('egg_weight')),
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
                    text: 'KPI Produksi per Kandang'
                }
            }
        }
    });
});
</script>
@endpush