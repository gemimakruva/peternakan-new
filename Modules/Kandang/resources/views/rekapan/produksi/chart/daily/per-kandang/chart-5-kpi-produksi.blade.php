<div class="col-12">
    <h2 class="h4">KPI Produksi</h2>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-kandang"></canvas>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('kpi-produksi-per-kandang'), {
        type: 'bar',
        data: {
            labels: @js($kpiProduksi->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'FCR',
                    data: @js($kpiProduksi->pluck('fcr')),
                    borderWidth: 2,
                },
                {
                    label: 'HDP',
                    data: @js($kpiProduksi->pluck('hdp')),
                    borderWidth: 2,
                },
                {
                    label: 'HHP',
                    data: @js($kpiProduksi->pluck('hhp')),
                    borderWidth: 2,
                },
                {
                    label: 'Egg Mass',
                    data: @js($kpiProduksi->pluck('egg_mass')),
                    borderWidth: 2,
                },
                {
                    label: 'Egg Weight',
                    data: @js($kpiProduksi->pluck('egg_weight')),
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