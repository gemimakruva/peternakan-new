<div class="col-12">
    <h2 class="h4">Data Akumulasi Kematian Ayam</h2>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kematian-ayam-chart-per-flock"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            <canvas id="kematian-ayam-chart-per-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card">
        <div class="card-body">
            data persentase + standar kematian ayam per kandang
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('kematian-ayam-chart-per-flock'), {
        type: 'bar',
        data: {
            labels: ['Flock 1', 'Flock 2', 'Flock 3', 'Flock 4', 'Flock 5'],
            datasets: [
                {
                    label: 'Akumulasi Kematian',
                    data: [15, 20, 25, 30, 35],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Afkir',
                    data: [25, 30, 35, 40, 50],
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Kematian dan Afkir',
                    data: [40, 50, 60, 70, 80],
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
            labels: [@js($kandang->nama)],
            datasets: [
                {
                    label: 'Akumulasi Kematian',
                    data: [15],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Afkir',
                    data: [25],
                    borderWidth: 2,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                },
                {
                    label: 'Akumulasi Kematian dan Afkir',
                    data: [40],
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
                    text: 'Data Kematian Ayam per Kandang'
                }
            }
        }
    });
});
</script>
@endpush