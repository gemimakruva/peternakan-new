<div class="col-12">
    <h2 class="h4">Data Konsumsi Ayam</h2>
</div>
<div class="col-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <canvas id="feed-intake-ayam-chart"></canvas>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    
    new Chart(document.getElementById('feed-intake-ayam-chart'), {
        type: 'bar',
        data: {
            labels: ['Flock 1', 'Flock 2', 'Flock 3', 'Flock 4', 'Flock 5', 'Rata-rata'],
            datasets: [
                {
                    label: 'Konsumsi per Ekor Ayam',
                    data: [80, 82, 80, 85, 90, 84],
                    borderWidth: 2,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
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
                    text: 'Konsumsi Pakan Ayam'
                }
            }
        }
    });

});
</script>
@endpush