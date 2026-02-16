<div class="col-12">
    <h2 class="h4">Data Populasi Ayam</h2>
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
            labels: ['Flock 1', 'Flock 2', 'Flock 3', 'Flock 4', 'Flock 5'],
            datasets: [
                {
                    label: 'Ayam Sehat (Fit)',
                    data: [450, 480, 510, 540, 580],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Ayam Sakit',
                    data: [25, 30, 35, 40, 50],
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Ayam Afkir',
                    data: [15, 18, 20, 25, 30],
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Masuk Karantina',
                    data: [10, 12, 15, 18, 20],
                    borderWidth: 2,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                },
                {
                    label: 'Keluar Karantina',
                    data: [10, 14, 13, 15, 0],
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
            labels: [@js($kandang->nama)],
            datasets: [
                {
                    label: 'Ayam Sehat (Fit)',
                    data: [450],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Ayam Sakit',
                    data: [25],
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Ayam Afkir',
                    data: [15],
                    borderWidth: 2,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                },
                {
                    label: 'Masuk Karantina',
                    data: [10],
                    borderWidth: 2,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                },
                {
                    label: 'Keluar Karantina',
                    data: [10],
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
});
</script>
@endpush