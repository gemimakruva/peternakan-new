<div class="col-12">
    <h2 class="h4">Produksi Telur</h2>
    <h3 class="h6">(yang dari semua kandang tidak memungkinkan karena sedang dalam filter {{ $kandang->nama }})</h3>
</div>

@foreach ([1, 2, 3, 4, 5] as $num)
    <div class="col-12 col-lg-3">
        <div class="card">
            <div class="card-body">
                <canvas id="produksi-butir-telur-pie-chart-flock-{{ $num }}"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="card">
            <div class="card-body">
                <canvas id="produksi-berat-telur-pie-chart-flock-{{ $num }}"></canvas>
            </div>
        </div>
    </div>
@endforeach

<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-butir-telur-pipe-chart-semua-flock"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-berat-telur-pipe-chart-semua-flock"></canvas>
        </div>
    </div>
</div>

<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-butir-telur-pie-per-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-berat-telur-pie-per-kandang"></canvas>
        </div>
    </div>
</div>


<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-butir-telur-pipe-chart-semua-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-berat-telur-pipe-chart-semua-kandang"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-body">
            <canvas id="produksi-berat-telur-pie-semua-kandang"></canvas>
        </div>
    </div>
</div>

@push('js')
@foreach ([1, 2, 3, 4, 5] as $num)
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('produksi-butir-telur-pie-chart-flock-' + @js($num)), {
        type: 'pie',
        data: {
            labels: ['Telur Bagus', 'Telur Reject', 'Telur Putih'],
            datasets: [
                {
                    data: [180, 10, 30],
                    backgroundColor: ['#28a745', '#dc3545', '#fd7e14'],
                    hoverOffset: 4,
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
                    text: 'Produksi Telur (Butir) - Flock ' + @js($num)
                }
            }
        }
    });

    new Chart(document.getElementById('produksi-berat-telur-pie-chart-flock-' + @js($num)), {
        type: 'pie',
        data: {
            labels: ['Telur Bagus', 'Telur Reject', 'Telur Putih'],
            datasets: [
                {
                    data: [10, .6, .8],
                    backgroundColor: ['#28a745', '#dc3545', '#fd7e14'],
                    hoverOffset: 4,
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
                    text: 'Produksi Telur (Kilogram) - Flock ' + @js($num)
                }
            }
        }
    });
})
</script>
@endforeach

<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('produksi-butir-telur-pipe-chart-semua-flock'), {
        type: 'bar',
        data: {
            labels: ['Flock 1', 'Flock 2', 'Flock 3', 'Flock 4', 'Flock 5'],
            datasets: [
                {
                    label: 'Butir Telur',
                    data: [450, 480, 510, 540, 580],
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
                    text: 'Jumlah Butir Telur semua Flock'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('produksi-berat-telur-pipe-chart-semua-flock'), {
        type: 'bar',
        data: {
            labels: ['Flock 1', 'Flock 2', 'Flock 3', 'Flock 4', 'Flock 5'],
            datasets: [
                {
                    label: 'Berat Telur (Kilogram)',
                    data: [450, 480, 510, 540, 580],
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
                    text: 'Berat Telur semua Flock (Kilogram)'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('produksi-butir-telur-pie-per-kandang'), {
        type: 'pie',
        data: {
            labels: ['Telur Bagus', 'Telur Reject', 'Telur Putih'],
            datasets: [
                {
                    data: [180, 10, 30],
                    backgroundColor: ['#28a745', '#dc3545', '#fd7e14'],
                    hoverOffset: 4,
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
                    text: 'Produksi Telur (Butir) - Kandang 1'
                }
            }
        }
    });
    
    new Chart(document.getElementById('produksi-berat-telur-pie-per-kandang'), {
        type: 'pie',
        data: {
            labels: ['Telur Bagus', 'Telur Reject', 'Telur Putih'],
            datasets: [
                {
                    data: [180, 10, 30],
                    backgroundColor: ['#28a745', '#dc3545', '#fd7e14'],
                    hoverOffset: 4,
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
                    text: 'Produksi Telur (Kilogram) - Kandang 1'
                }
            }
        }
    });

    new Chart(document.getElementById('produksi-butir-telur-pipe-chart-semua-kandang'), {
        type: 'bar',
        data: {
            labels: ['Kandang 1', 'Kandang 2', 'Kandang 3', 'Kandang 4', 'Kandang 5'],
            datasets: [
                {
                    label: 'Butir Telur',
                    data: [450, 480, 510, 540, 580],
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
                    text: 'Jumlah Butir Telur semua Kandang'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('produksi-berat-telur-pipe-chart-semua-kandang'), {
        type: 'bar',
        data: {
            labels: ['Kandang 1', 'Kandang 2', 'Kandang 3', 'Kandang 4', 'Kandang 5'],
            datasets: [
                {
                    label: 'Berat Telur (Kilogram)',
                    data: [450, 480, 510, 540, 580],
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
                    text: 'Berat Telur semua Kandang (Kilogram)'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('produksi-berat-telur-pie-semua-kandang'), {
        type: 'pie',
        data: {
            labels: ['Telur Bagus', 'Telur Reject', 'Telur Putih'],
            datasets: [
                {
                    data: [180, 10, 30],
                    backgroundColor: ['#28a745', '#dc3545', '#fd7e14'],
                    hoverOffset: 4,
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
                    text: 'Produksi Telur (Kilogram) - Semua Kandang'
                }
            }
        }
    });
});
</script>
@endpush