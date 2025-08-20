


         
    <div class="input-group mb-3">
        <input type="date" class="form-control" placeholder="Fecha inicio" name="inicio_g2" aria-label="Fecha inicio" value="{{$primerDiaHace6Meses_g2}}">
        <span class="input-group-text">-</span>
        <input type="date" class="form-control" placeholder="Fecha fin" name="fin_g2" aria-label="Fecha fin" value="{{$ultimoDiaMesActual_g2}}">
        <button class="btn btn-link" type="button">Actualizar</button>
    </div>
    <div class="text-center">
        <p>Menos de 1 año {{$menosDeUnAno}}</p>
        <p>Más de 1 año {{$masDeUnAno}}</p>
        <h3>Indice de estabilidad <b>{{number_format($indiceDeEstabilidad,2)}}%</b> </h3>
    </div>
    <br>
    <canvas class="barChartAntiguedad" id="barChartAntiguedad" width="400" height="240"></canvas>

 

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
 // Función para generar valores aleatorios
        function generateRandomData(count, min, max) {
            var data = [];
            for (var i = 0; i < count; i++) {
                data.push(Math.floor(Math.random() * (max - min + 1)) + min);
            }
            return data;
        }

        var barChartDataAntiguedad = {
            labels: ['Colaboradores activos por antigüedad'],
            datasets: [
                {
                    label: 'Menos de 3 meses: {{$menosDeTresMeses}}',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    data: [{{$menosDeTresMeses}}]
                },
                {
                    label: 'Entre 3 y 6 meses: {{$tresASeisMeses}}',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    data: [{{$tresASeisMeses}}]
                },
                {
                    label: 'Más de 1 año: {{$masDeUnAno}}',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    data: [{{$masDeUnAno}}]
                }
            ]
        };

        var ctxBarAntiguedad = document.getElementById('barChartAntiguedad').getContext('2d');
        var barChartAntiguedad = new Chart(ctxBarAntiguedad, {
            type: 'bar',
            data: barChartDataAntiguedad,
            options: {
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true,
                    }]
                }
            }
        });

</script>