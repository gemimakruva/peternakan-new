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
{{-- <div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kpi-produksi-per-kandang"></canvas>
        </div>
    </div>
</div> --}}

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('kpi-produksi-per-flock'), {
        type: 'bar',
        data: {
            labels: ['Flock 1', 'Flock 2', 'Flock 3', 'Flock 4', 'Flock 5', 'Rata-rata'],
            datasets: [
                {
                    label: 'FCR',
                    data: [15, 20, 25, 30, 35, 28],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'HDP',
                    data: [25, 30, 35, 40, 50, 38],
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'HHP',
                    data: [40, 50, 60, 70, 80, 66],
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Egg Mass',
                    data: [30, 35, 40, 45, 50, 55],
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Egg Weight',
                    data: [35, 40, 45, 50, 55, 40],
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
                    text: 'KPI Produksi per Flock'
                }
            }
        }
    });

    // new Chart(document.getElementById('kpi-produksi-per-kandang'), {
    //     type: 'bar',
    //     data: {
    //         labels: ['Kandang 1', 'Kandang 2', 'Kandang 3', 'Kandang 4', 'Kandang 5'],
    //         datasets: [
    //             {
    //                 label: 'FCR',
    //                 data: [15, 20, 25, 30, 35],
    //                 borderWidth: 2,
    //                 borderColor: '#28a745',
    //                 backgroundColor: 'rgba(40, 167, 69, 0.1)',
    //             },
    //             {
    //                 label: 'HDP',
    //                 data: [25, 30, 35, 40, 50],
    //                 borderWidth: 2,
    //                 borderColor: '#dc3545',
    //                 backgroundColor: 'rgba(220, 53, 69, 0.1)',
    //             },
    //             {
    //                 label: 'HHP',
    //                 data: [40, 50, 60, 70, 80],
    //                 borderWidth: 2,
    //                 borderColor: '#fd7e14',
    //                 backgroundColor: 'rgba(253, 126, 20, 0.1)',
    //             },
    //             {
    //                 label: 'Egg Mass',
    //                 data: [30, 35, 40, 45, 50],
    //                 borderWidth: 2,
    //                 borderColor: '#fd7e14',
    //                 backgroundColor: 'rgba(253, 126, 20, 0.1)',
    //             },
    //             {
    //                 label: 'Egg Weight',
    //                 data: [35, 40, 45, 50, 55],
    //                 borderWidth: 2,
    //                 borderColor: '#fd7e14',
    //                 backgroundColor: 'rgba(253, 126, 20, 0.1)',
    //             },
    //         ]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         },
    //         plugins: {
    //             title: {
    //                 display: true,
    //                 text: 'KPI Produksi per Kandang'
    //             }
    //         }
    //     }
    // });
});
</script>
@endpush