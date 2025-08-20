@extends('layouts.app', ['activePage' => 'dashboard', 'menuParent' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

<style media="screen">
  canvas{ margin-bottom: 100px; }
</style>
<div class="content">
  <div class="row">
    <div class="col-lg-3 col-md-6" id="dashboard">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-warning">
                <i class="tim-icons icon-watch-time"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category">Horas extra</p>
                <h3 class="card-title">0</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <hr>
          <div class="stats">
            <i class="tim-icons icon-watch-time text-danger"></i> <span class="text-danger"> <small>Enero 2024</small>  <b>0</b> ( <i class="fa fa-plus"></i> 0 )</span>
          </div>
          <div class="stats">
            <i class="tim-icons icon-watch-time text-danger"></i> <span class="text-danger"> <small>Febrero 2023</small> <b>0</b> ( <i class="fa fa-plus"></i> 140 )</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      @include('dashboard.partials.cards.headcount')
    </div>
    <div class="col-lg-3 col-md-6">
      @include('dashboard.partials.cards.vacantes')
    </div>
    <div class="col-lg-3 col-md-6">
      @include('dashboard.partials.cards.desvinculados')
    </div>
  </div>

  <div class="row">
    <div class="col-lg-5">
      @include('dashboard.partials.cards.pendientes')
    </div>
  </div>

  
    <div class="row">
         <div class="col-md-6">
            @include('dashboard.partials.charts.headcount')
        </div>
       
        <div class="col-md-6">
            @include('dashboard.partials.charts.estabilidad')
        </div>
    
    
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12">
              <div class="input-group mb-3">
                <input type="date" class="form-control" placeholder="Fecha inicio" aria-label="Fecha inicio">
                <span class="input-group-text">-</span>
                <input type="date" class="form-control" placeholder="Fecha fin" aria-label="Fecha fin">
                <button class="btn btn-link" type="button">Actualizar</button>
              </div>
            </div>
            <div class="col-md-4">
              <select class="form-contol" name="">
                <option value="">Todos los centros de costos</option>
                <option value="">Financiera</option>
                <option value="">Compras</option>
                <option value="">...</option>
              </select>
            </div>
          </div>
            <canvas id="lineChart" width="400" height="300"></canvas>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12">
              <div class="input-group mb-3">
                <input type="date" class="form-control" placeholder="Fecha inicio" aria-label="Fecha inicio">
                <span class="input-group-text">-</span>
                <input type="date" class="form-control" placeholder="Fecha fin" aria-label="Fecha fin">
                <button class="btn btn-link" type="button">Actualizar</button>
              </div>
            </div>
          </div>
            <canvas id="barChartVacaciones" width="400" height="300"></canvas>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
       

        // Datos de muestra para el nuevo gráfico de línea
        var lineChartData = {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [
                {
                    label: 'Presupuesto mensual',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false,
                    data: generateRandomData(6, 5, 15) // Genera valores aleatorios entre 5 y 15
                },
                {
                    label: 'Presupuesto real',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: false,
                    data: generateRandomData(6, 10, 20) // Genera valores aleatorios entre 10 y 20
                }
            ]
        };

        var ctxLine = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctxLine, {
            type: 'line',
            data: lineChartData,
            options: {
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Meses'
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Valores'
                        }
                    }]
                }
            }
        });

        // Datos de muestra para el nuevo gráfico de barras (días de vacaciones por mes)
        var barChartDataVacaciones = {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Días de vacaciones',
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                data: [1500, 2000, 2500, 2200, 1800, 2700] // Puedes ajustar estos valores según sea necesario
            }]
        };

        var ctxBarVacaciones = document.getElementById('barChartVacaciones').getContext('2d');
        var barChartVacaciones = new Chart(ctxBarVacaciones, {
            type: 'bar',
            data: barChartDataVacaciones,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    demo.initDashboardPageCharts();
    demo.initVectorMap();
  });
</script>
@endpush
