<div class="input-group mb-3">
    <input type="hidden" class="form-control" placeholder="Fecha inicio" name="inicio_g1" aria-label="Fecha inicio" value="{{ $primerDiaHace6Meses_g1 }}" required>
    
    <input type="hidden" class="form-control" placeholder="Fecha fin" name="fin_g1" aria-label="Fecha fin" value="{{ $ultimoDiaMesActual_g1 }}" required>
    
</div>
<canvas id="headcount" width="400" height="300"></canvas>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/get-chart-headcount-data')
            .then(response => response.json())
            .then(data => {
                var chartData = {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Pendientes',
                            type: 'bar',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            data: data.vacantesPendientes,
                        },
                        {
                            label: 'Concretadas',
                            type: 'bar',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            data: data.vacantesCompletadas,
                        },
                        {
                            label: 'Objetivo',
                            type: 'line',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false,
                            data: [15, 15, 15, 15, 15, 15], // Ajusta estos valores según tu lógica
                        }
                    ]
                };

                var ctxBar = document.getElementById('headcount').getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));
    });
</script>
