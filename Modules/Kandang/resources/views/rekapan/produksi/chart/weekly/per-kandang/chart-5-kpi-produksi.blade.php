<div class="col-12">
    <h2 class="h4">KPI Produksi</h2>
</div>
<div class="col-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12">
    <x-adminlte-text-editor
        label="Catatan KPI Produksi"
        name="catatan_kpi_produksi"
        fgroup-class="mb-2"
    >{{ @$catatanLaporan->catatan_kpi_produksi }}</x-adminlte-text-editor>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('kpi-produksi-per-kandang'), {
        type: 'bar',
        data: {
            labels: @js($rekapanKandang->pluck('nama_kandang')),
            datasets: [
                {
                    label: 'FCR',
                    data: @js($rekapanKandang->pluck('fcr')),
                    borderWidth: 2,
                },
                {
                    label: 'HDP',
                    data: @js($rekapanKandang->pluck('hdp')),
                    borderWidth: 2,
                },
                {
                    label: 'HHP',
                    data: @js($rekapanKandang->pluck('hhp')),
                    borderWidth: 2,
                },
                {
                    label: 'Egg Mass',
                    data: @js($rekapanKandang->pluck('egg_mass')),
                    borderWidth: 2,
                },
                {
                    label: 'Egg Weight',
                    data: @js($rekapanKandang->pluck('egg_weight')),
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