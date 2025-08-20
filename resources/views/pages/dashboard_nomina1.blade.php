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
      <div class="card card-stats">
    <div class="card-body">
        <div class="row">
            <div class="col-5">
                <div class="info-icon text-center icon-success">
                    <i class="tim-icons icon-molecule-40"></i>
                </div>
            </div>
            <div class="col-7">
                <div class="numbers">
                    <p class="card-category">Headcount</p>
                    <h3 class="card-title">{{ number_format($porcentajeActivos, 0) }}%</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <hr>
        <div class="stats">
            <i class="tim-icons icon-molecule-40 text-success"></i>
            <span class="@if($porcentajeActivosMesAnterior > $porcentajeActivos) text-danger @else text-success @endif">
                <small>
                    <?php \Carbon\Carbon::setLocale('es'); ?>
                    {{ \Carbon\Carbon::now()->subMonth()->formatLocalized('%B %Y') }}
                </small>
                <b>{{ number_format($porcentajeActivosMesAnterior, 0) }}</b>
                @if($porcentajeActivosMesAnterior > $porcentajeActivos)
                    ( <i class="fa fa-plus"></i> {{ number_format($porcentajeActivosMesAnterior - $porcentajeActivos, 0) }}% )
                @elseif($porcentajeActivosMesAnterior < $porcentajeActivos)
                    ( <i class="fa fa-minus"></i> {{ number_format($porcentajeActivos - $porcentajeActivosMesAnterior, 0) }}% )
                @else
                    ( <i class="fa fa-equals"></i> 0% )
                @endif
            </span>
        </div>
    </div>
</div>

    </div>
    <div class="col-lg-3 col-md-6">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-success">
                <i class="tim-icons icon-single-02"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category">Vacantes</p>
                <h3 class="card-title">{{ $vacantesall-$vacantespendientesall }} / {{ $vacantesall }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <hr>
          @php
              $porcentajeCompletadas = 0;
              if ($vacantesall != 0) {
                  $porcentajeCompletadas = ($vacantesall - $vacantespendientesall) / $vacantesall * 100;
              }
          @endphp
          <div class="stats">
            <i class="tim-icons icon-single-02"></i> {{ $porcentajeCompletadas }}% Cubierto
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-danger">
                <i class="tim-icons icon-single-02"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category">Desvinculaciones</p>
                <h3 class="card-title">{{$totalDesvinculados}}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <hr>
          <div class="stats">
            <i class="tim-icons icon-single-02"></i> Programadas <b>{{$totalBajas}}</b>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-5">
      <div class="card card-tasks">
        <div class="card-header">
          <h6 class="title d-inline">Pendientes</h6>
          <p class="card-category d-inline">today</p>
          <div class="dropdown">
            <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
              <i class="tim-icons icon-settings-gear-63"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#pablo">Action</a>
              <a class="dropdown-item" href="#pablo">Another action</a>
              <a class="dropdown-item" href="#pablo">Something else</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-full-width table-responsive">
            <table class="table">
              <tbody>
                @foreach($pendientes as $pendiente)
                <tr>
                  <td>
                    <p class="title">{{ $pendiente->texto }}</p>
                    <p class="text-muted">{{ $pendiente->fecha }}</p>
                  </td>
                  <td class="td-actions text-right">
                    <a href="{{ $pendiente->ruta }}" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                      >
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="row">

        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12">
              <div class="input-group mb-3">
                <input type="date" class="form-control" placeholder="Fecha inicio" name="inicio_g1" aria-label="Fecha inicio" value="{{$primerDiaHace6Meses_g1}}" required>
                <span class="input-group-text">-</span>
                <input type="date" class="form-control" placeholder="Fecha fin" name="fin_g1" aria-label="Fecha fin" value="{{$ultimoDiaMesActual_g1}}" required>
                <button class="btn btn-link" type="submit">Actualizar</button>
              </div>
            </div>
          </div>
            <canvas id="headcount" width="400" height="300"></canvas>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12">
              <div class="input-group mb-3">
                <input type="date" class="form-control" placeholder="Fecha inicio" name="inicio_g2" aria-label="Fecha inicio" value="{{$primerDiaHace6Meses_g2}}">
                <span class="input-group-text">-</span>
                <input type="date" class="form-control" placeholder="Fecha fin" name="fin_g2" aria-label="Fecha fin" value="{{$ultimoDiaMesActual_g2}}">
                <button class="btn btn-link" type="button">Actualizar</button>
              </div>
            </div>
          </div>
            <div class="text-center">
              <p>Menos de 1 año {{$menosDeUnAno}}</p>
              <p>Más de 1 año {{$masDeUnAno}}</p>
              <h3>Indice de estabilidad <b>{{number_format($indiceDeEstabilidad,2)}}%</b> </h3>
            </div>
            <br>
            <canvas class="barChartAntiguedad" id="barChartAntiguedad" width="400" height="240"></canvas>

        </div>
    </div>
    <div class="row">
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
    document.addEventListener('DOMContentLoaded', function () {
        // Datos de muestra para el gráfico de barras existente
        var data = {
            labels:  <?php echo json_encode($labels); ?>,
            datasets: [
                {
                    label: 'Pendientes',
                    type: 'bar',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    data: <?php echo json_encode($vacantesPendientes); ?>,
                },
                {
                    label: 'Concretadas',
                    type: 'bar',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    data: <?php echo json_encode($vacantesCompletadas); ?>,
                },
                {
                    label: 'Objetivo',
                    type: 'line',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                    data: [15, 15, 15, 15, 15, 15], // Puedes mantener estos valores fijos o ajustarlos dinámicamente
                }
            ]
        };


        var ctxBar = document.getElementById('headcount').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: data,
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
