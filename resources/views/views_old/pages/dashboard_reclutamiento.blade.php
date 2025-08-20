@extends('layouts.app', ['activePage' => 'dashboard', 'menuParent' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

<style media="screen">
  canvas{ margin-bottom: 100px;}
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
          <h6 class="title d-inline">Vacantes Pendientes</h6>

        </div>
        <div class="card-body">
          <div class="table-full-width table-responsive">
            <table class="table">
              <tbody>
                @foreach($vacantes as $vac)
                <tr>
                  <td>
                    <a href="/proceso_vacante/{{ $vac->id }}" class="btn btn-link"><p class="title">{{ catalogopuesto($vac->puesto_id) }}</p></a>

                    <p class="text-muted">
                      <small>{{ $vac->area }} - </small>
                      <small>{{ $vac->codigo }} - </small>
                      <small>{{ nombre_empresa($vac->company_id) }}</small>
                      <small>{{ str_replace(' 12:00:00:AM','',$vac->fecha) }}</small>
                    </p>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          <div class="tools float-right">
            <div class="dropdown">
              <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                <i class="tim-icons icon-settings-gear-63"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#pablo">Action</a>
                <a class="dropdown-item" href="#pablo">Another action</a>
                <a class="dropdown-item" href="#pablo">Something else</a>
                <a class="dropdown-item text-danger" href="#pablo">Remove Data</a>
              </div>
            </div>
          </div>
          <h5 class="card-title">Estatus de candidatos</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class="text-primary">
                <tr>
                  <th>
                    Candidato
                  </th>
                  <th>
                    Puesto
                  </th>
                  <th>
                    Proceso
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($procesorh as $proceso)
                <tr>
                  <td>
                    {{ candidato($proceso->candidato_id)  }}
                  </td>
                  <td>
                    Puesto
                  </td>
                  <td class="text-center">
                    <div class="progress-container progress-sm">
                      <div class="progress">
                        <span class="progress-value">85%</span>
                        <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                      </div>
                    </div>
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
      <div class="input-group mb-3">
        <input type="date" class="form-control" placeholder="Fecha inicio" aria-label="Fecha inicio">
        <span class="input-group-text">-</span>
        <input type="date" class="form-control" placeholder="Fecha fin" aria-label="Fecha fin">
        <button class="btn btn-link" type="button">Actualizar</button>
      </div>
    </div>
  <div class="col-md-12 text-center">
    <canvas id="lineChart" width="800" height="300"></canvas>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="input-group mb-3">
      <input type="date" class="form-control" placeholder="Fecha inicio" aria-label="Fecha inicio">
      <span class="input-group-text">-</span>
      <input type="date" class="form-control" placeholder="Fecha fin" aria-label="Fecha fin">
      <button class="btn btn-link" type="button">Actualizar</button>
    </div>
  </div>
  <div class="col-12 text-center">
    <canvas id="barChart" width="800" height="300"></canvas>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
          <input type="date" class="form-control" placeholder="Fecha inicio" name="inicio_g1" aria-label="Fecha inicio" value="" required>
          <span class="input-group-text">-</span>
          <input type="date" class="form-control" placeholder="Fecha fin" name="fin_g1" aria-label="Fecha fin" value="" required>
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
          <input type="date" class="form-control" placeholder="Fecha inicio" aria-label="Fecha inicio">
          <span class="input-group-text">-</span>
          <input type="date" class="form-control" placeholder="Fecha fin" aria-label="Fecha fin">
          <button class="btn btn-link" type="button">Actualizar</button>
        </div>
      </div>
    </div>
    <canvas id="barChartAntiguedad" width="800" height="300"></canvas>
  </div>
</div>

</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  // Función para generar valores aleatorios
  function generateRandomData(count, min, max) {
    var data = [];
    for (var i = 0; i < count; i++) {
      data.push(Math.floor(Math.random() * (max - min + 1)) + min);
    }
    return data;
  }
  var labels = <?php echo json_encode($labels); ?>;
  // Datos de muestra para el nuevo gráfico de línea
  var lineChartData = {
    labels: labels,
    datasets: [
      {
        label: 'Altas',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 2,
        fill: false,
        data: {{json_encode($altasPorMes)}} // Genera valores aleatorios entre 5 y 15
      },
      {
        label: 'Bajas',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 2,
        fill: false,
        data: {{json_encode($bajasPorMes)}} // Genera valores aleatorios entre 10 y 20
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
  var datosAltasReferencias = <?php echo json_encode($datosAltasReferencias); ?>;
  var datosAltasRedesSociales = <?php echo json_encode($datosAltasRedesSociales); ?>;
  var datosAltasVolanteo = <?php echo json_encode($datosAltasVolanteo); ?>;
  var datosAltasBolsaDeTrabajo = <?php echo json_encode($datosAltasBolsaDeTrabajo); ?>;


  var datosBajasAbandonodeEmpleo = <?php echo json_encode($datosBajasAbandonodeEmpleo); ?>;
  var datosBajasAusentismo = <?php echo json_encode($datosBajasAusentismo); ?>;
  var datosBajasCambiodePuesto = <?php echo json_encode($datosBajasCambiodePuesto); ?>;
  var datosBajasDefuncion = <?php echo json_encode($datosBajasDefuncion); ?>;
  var datosBajasResciciondeContrato = <?php echo json_encode($datosBajasResciciondeContrato); ?>;
  var datosBajasSeparacionVoluntaria = <?php echo json_encode($datosBajasSeparacionVoluntaria); ?>;
  var datosBajasTerminodeContrato = <?php echo json_encode($datosBajasTerminodeContrato); ?>;
  var datosBajasNulo = <?php echo json_encode($datosBajasNulo); ?>;

  var permanencia3meses = <?php echo json_encode($permanencia3meses); ?>;
  var permanencia12meses = <?php echo json_encode($permanencia12meses); ?>;
  var permanenciamayor1anio = <?php echo json_encode($permanenciamayor1anio); ?>;

  // Datos de muestra para el nuevo gráfico de barras apiladas
  var barChartData = {
  labels: labels,
  datasets: [
    {
      label: 'Altas - Referencias',
      backgroundColor: 'rgba(40, 145, 214, 0.5)', // Color personalizado para referencias
      data: datosAltasReferencias, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 0',
    },
    {
      label: 'Altas - Redes Sociales',
      backgroundColor: 'rgba(24, 98, 146, 0.5)', // Color personalizado para redes sociales
      data: datosAltasRedesSociales, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 0',
    },
    {
      label: 'Altas - Volanteo',
      backgroundColor: 'rgba(54, 176, 255, 0.5)', // Color personalizado para volanteo
      data: datosAltasVolanteo, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 0',
    },
    {
      label: 'Altas - Bolsa de Trabajo',
      backgroundColor: 'rgba(0, 73, 120, 0.5)', // Color personalizado para bolsa de trabajo
      data: datosAltasBolsaDeTrabajo, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 0',
    },
    {
      label: 'Bajas - Abandono de empleo',
      backgroundColor: 'rgba(120, 0, 75, 0.5)', // Color personalizado para volanteo
      data: datosBajasAbandonodeEmpleo, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 1',
    },
    {
      label: 'Bajas - Ausentismo',
      backgroundColor: 'rgba(118, 59, 96, 0.5)', // Color personalizado para volanteo
      data: datosBajasAusentismo, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 1',
    },
    {
      label: 'Bajas - Cambio de puesto',
      backgroundColor: 'rgba(153, 93, 131, 0.5)', // Color personalizado para volanteo
      data: datosBajasCambiodePuesto, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 1',
    },
    {
      label: 'Bajas - Defunción',
      backgroundColor: 'rgba(170, 59, 129, 0.5)', // Color personalizado para volanteo
      data: datosBajasDefuncion, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 1',
    },
    {
      label: 'Bajas - Rescision de Contrato',
      backgroundColor: 'rgba(182, 13, 119, 0.5)', // Color personalizado para volanteo
      data: datosBajasResciciondeContrato, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 1',
    },
    {
      label: 'Bajas - Separación voluntaria',
      backgroundColor: 'rgba(226, 14, 147, 0.5)', // Color personalizado para volanteo
      data: datosBajasSeparacionVoluntaria, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 1',
    },
    {
      label: 'Bajas - Término de contrato',
      backgroundColor: 'rgba(246, 145, 208, 0.5)', // Color personalizado para volanteo
      data: datosBajasTerminodeContrato, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 1',
    },
    {
      label: 'Bajas - Nulo',
      backgroundColor: 'rgba(218, 0, 40, 0.5)', // Color personalizado para volanteo
      data: datosBajasNulo, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 1',
    },
    {
      label: 'Permanencia - Menos de 3 meses',
      backgroundColor: 'rgba(89, 200, 80, 0.5)', // Color personalizado para bolsa de trabajo
      data: permanencia3meses, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 2',
    },
    {
      label: 'Permanencia - 3 a 12 meses',
      backgroundColor: 'rgba(16, 218, 0, 0.5)', // Color personalizado para bolsa de trabajo
      data: permanencia12meses, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 2',
    },
    {
      label: 'Permanencia - Más de 1 año',
      backgroundColor: 'rgba(35, 122, 28, 0.5)', // Color personalizado para bolsa de trabajo
      data: permanenciamayor1anio, // Genera valores aleatorios entre 5 y 15
      stack: 'Stack 2',
    }


  ]
};



var ctxBar = document.getElementById('barChart').getContext('2d');
var barChart = new Chart(ctxBar, {
type: 'bar',
data: barChartData,
options: {
  plugins: {
    title: {
      display: true,
      text: 'Altas y Bajas por Mes y Concepto'
    },
    legend: {
      position: 'right' // Establece la posición de la leyenda a la derecha
    }
  },
  responsive: true,
  scales: {
    x: {
      stacked: true,
    },
    y: {
      stacked: true
    }
  }
}
});


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
  // Datos de muestra para el nuevo gráfico de barras (empleados por antigüedad)
  var barChartDataAntiguedad = {
      labels: ['Menos de 3 meses', 'Entre 3 y 6 meses', 'Más de 1 año'],
      datasets: [{
          label: 'Empleados por antigüedad',
          backgroundColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
          data: [300, 400, 500] // Puedes ajustar estos valores según sea necesario
      }]
  };

  var ctxBarAntiguedad = document.getElementById('barChartAntiguedad').getContext('2d');
  var barChartAntiguedad = new Chart(ctxBarAntiguedad, {
      type: 'bar',
      data: barChartDataAntiguedad,
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true,
                      stepSize: 10, // Paso entre cada etiqueta
                      min: 25, // Edad mínima
                      max: 65 // Edad máxima
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
