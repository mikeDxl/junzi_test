@extends('home', ['activePage' => 'dashboardJefatura', 'menuParent' => 'dashboardJefatura', 'titlePage' => __('Dashboard Jefaturas')])

@section('contentJunzi')
<style>
.badge {
  font-size: 11px;
  padding: 4px 8px;
}

/* Estilos para filtros de fecha individuales por gráfica */
.chart-individual-filters {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  padding: 15px;
  margin-bottom: 15px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.chart-filter-header {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 12px;
}

.chart-filter-title {
  font-size: 14px;
  font-weight: 600;
  color: #495057;
  margin: 0;
}

.chart-filter-controls {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

.chart-date-group {
  display: flex;
  flex-direction: column;
  gap: 4px;
  min-width: 140px;
}

.chart-date-group label {
  font-size: 12px;
  font-weight: 500;
  color: #6c757d;
  margin: 0;
}

.chart-date-group input[type="date"] {
  padding: 6px 10px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 13px;
  background: white;
  color: #495057;
  transition: border-color 0.3s ease;
}

.chart-date-group input[type="date"]:focus {
  outline: none;
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.chart-filter-buttons {
  display: flex;
  gap: 8px;
  align-items: end;
  padding-bottom: 2px;
}

.btn-chart-individual {
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.btn-apply-chart {
  background: #007bff;
  color: white;
}

.btn-apply-chart:hover {
  background: #0056b3;
}

.btn-clear-chart {
  background: #6c757d;
  color: white;
}

.btn-clear-chart:hover {
  background: #545b62;
}

/* Diferentes colores para cada gráfica */
.chart-filter-areas {
  border-left: 4px solid #17a2b8;
}

.chart-filter-criticidad {
  border-left: 4px solid #28a745;
}

@media (max-width: 768px) {
  .chart-filter-controls {
    flex-direction: column;
    align-items: stretch;
  }
  
  .chart-date-group {
    min-width: 100%;
  }
  
  .chart-filter-buttons {
    justify-content: center;
  }
}
</style>

<div class="content mt-4">
  <div class="row">
    
   <!-- Cards de métricas principales (SIN FILTROS) -->
    <div class="col-lg-3 col-md-6">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-primary">
                <i class="tim-icons icon-notes"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category">Auditorías del mes</p>
                <h3 class="card-title" id="stat-auditorias-mes">{{ $stats['auditorias_mes'] ?? 0 }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <hr>
          <div class="stats">
            <i class="tim-icons icon-check-2 text-success"></i> Realizadas este mes
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
                <i class="tim-icons icon-alert-circle-exc"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category">Hallazgos activos</p>
                <h3 class="card-title" id="stat-hallazgos-activos">{{ $stats['hallazgos_activos'] ?? 0 }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <hr>
          <div class="stats">
            <i class="tim-icons icon-refresh-01"></i> Pendientes de solución
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-warning">
                <i class="tim-icons icon-time-alarm"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category">Hallazgos vencidos</p>
                <h3 class="card-title" id="stat-hallazgos-vencidos">{{ $stats['hallazgos_vencidos'] ?? 0 }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <hr>
          <div class="stats">
            <i class="tim-icons icon-sound-wave"></i> Requieren atención urgente
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
                <i class="tim-icons icon-check-2"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category">Hallazgos subsanados</p>
                <h3 class="card-title" id="stat-hallazgos-subsanados">{{ $stats['hallazgos_subsanados'] ?? 0 }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <hr>
          <div class="stats">
            <i class="tim-icons icon-trophy"></i> Cerrados exitosamente
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <!-- Gráfico de barras verticales - Áreas con mayor recurrencia -->
    <div class="col-lg-6">
      <div class="card card-chart">
        <div class="card-header">
          <h3 class="card-title"><i class="tim-icons icon-chart-pie-36 text-info"></i> Áreas con mayor recurrencia</h3>
        </div>
        <div class="card-body">
          <!-- Filtros específicos para gráfica de áreas -->
          <!-- NOTA: Al cargar la página, se muestran datos generales. Los filtros solo se aplican cuando el usuario los usa explícitamente -->
          <div class="chart-individual-filters chart-filter-areas">
            <div class="chart-filter-header">
              <i class="tim-icons icon-calendar-60 text-info"></i>
              <h6 class="chart-filter-title">Filtrar por fechas</h6>
            </div>
            <div class="chart-filter-controls">
              <div class="chart-date-group">
                <label for="areas_fecha_inicio">Desde:</label>
                <input type="date" id="areas_fecha_inicio" name="areas_fecha_inicio">
              </div>
              
              <div class="chart-date-group">
                <label for="areas_fecha_fin">Hasta:</label>
                <input type="date" id="areas_fecha_fin" name="areas_fecha_fin">
              </div>
              
              <div class="chart-filter-buttons">
                <button type="button" id="aplicar-filtro-areas" class="btn-chart-individual btn-apply-chart">
                  <i class="tim-icons icon-zoom-split"></i>
                  Aplicar
                </button>
                <button type="button" id="limpiar-filtro-areas" class="btn-chart-individual btn-clear-chart">
                  <i class="tim-icons icon-simple-remove"></i>
                  Limpiar
                </button>
              </div>
            </div>
          </div>
          
          <div class="chart-area">
            <canvas id="chartAreasRecurrencia" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Gráfico de barras horizontales - Hallazgos por área y criticidad -->
    <div class="col-lg-6">
      <div class="card card-chart">
        <div class="card-header">
          <h3 class="card-title"><i class="tim-icons icon-chart-bar-32 text-primary"></i> Hallazgos por área, criticidad y tipo</h3>
        </div>
        <div class="card-body">
          <!-- Filtros específicos para gráfica de criticidad -->
          <!-- NOTA: Al cargar la página, se muestran datos generales. Los filtros solo se aplican cuando el usuario los usa explícitamente -->
          <div class="chart-individual-filters chart-filter-criticidad">
            <div class="chart-filter-header">
              <i class="tim-icons icon-calendar-60 text-success"></i>
              <h6 class="chart-filter-title">Filtrar por fechas</h6>
            </div>
            <div class="chart-filter-controls">
              <div class="chart-date-group">
                <label for="criticidad_fecha_inicio">Desde:</label>
                <input type="date" id="criticidad_fecha_inicio" name="criticidad_fecha_inicio">
              </div>
              
              <div class="chart-date-group">
                <label for="criticidad_fecha_fin">Hasta:</label>
                <input type="date" id="criticidad_fecha_fin" name="criticidad_fecha_fin">
              </div>
              
              <div class="chart-filter-buttons">
                <button type="button" id="aplicar-filtro-criticidad" class="btn-chart-individual btn-apply-chart">
                  <i class="tim-icons icon-zoom-split"></i>
                  Aplicar
                </button>
                <button type="button" id="limpiar-filtro-criticidad" class="btn-chart-individual btn-clear-chart">
                  <i class="tim-icons icon-simple-remove"></i>
                  Limpiar
                </button>
              </div>
            </div>
          </div>
          
          <div class="chart-area">
            <canvas id="chartHallazgosCriticidad" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// Variables globales para los gráficos y datos
let chartAreasRecurrencia;
let chartHallazgosCriticidad;
let currentHallazgosCriticidad = {};

// Variables para filtros de fechas SEPARADOS por gráfica
let areasChartFilters = {
  fecha_inicio: null,
  fecha_fin: null,
  hasActiveFilters: false  // Flag para saber si tiene filtros activos
};

let criticidadChartFilters = {
  fecha_inicio: null,
  fecha_fin: null,
  hasActiveFilters: false  // Flag para saber si tiene filtros activos
};

// Colores para los gráficos
const colors = [
  '#e74c3c', // Rojo
  '#e67e22', // Naranja
  '#f39c12', // Amarillo
  '#27ae60', // Verde
  '#3498db', // Azul
  '#9b59b6', // Morado
  '#34495e', // Gris oscuro
  '#16a085'  // Verde azulado
];

$(document).ready(function() {
  console.log('Inicializando dashboard...');
  
  // Inicializar filtros de fecha separados para cada gráfica
  initSeparateChartFilters();
  
  // Obtener datos GENERALES del controlador (primera carga)
  const chartData = @json($chartData ?? []);
  console.log('Datos iniciales del servidor (consulta general):', chartData);
  
  // Preparar datos para el gráfico de áreas con mayor recurrencia (DATOS GENERALES INICIALES)
  const areasRecurrencia = chartData.areas_recurrencia || [];
  const labelsRecurrencia = areasRecurrencia.map(item => item.area);
  const dataRecurrencia = areasRecurrencia.map(item => parseInt(item.total));
  
  // Preparar datos para el gráfico de hallazgos por criticidad (DATOS GENERALES INICIALES)
  const hallazgosCriticidad = chartData.hallazgos_criticidad || {};
  currentHallazgosCriticidad = hallazgosCriticidad;
  const labelsCriticidad = Object.keys(hallazgosCriticidad);
  
  console.log('Datos procesados (CONSULTA GENERAL INICIAL):', {
    areasRecurrencia: { labels: labelsRecurrencia, data: dataRecurrencia },
    hallazgosCriticidad: { labels: labelsCriticidad, data: hallazgosCriticidad }
  });

  // GRÁFICO 1 - Áreas con mayor recurrencia
  const canvasAreasRecurrencia = document.getElementById('chartAreasRecurrencia');
  if (canvasAreasRecurrencia) {
    console.log('Creando gráfico de áreas recurrencia...');
    
    if (chartAreasRecurrencia) {
      chartAreasRecurrencia.destroy();
    }
    
    try {
      const ctx = canvasAreasRecurrencia.getContext('2d');
      
      chartAreasRecurrencia = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labelsRecurrencia,
          datasets: [{
            label: 'Cantidad de hallazgos',
            data: dataRecurrencia,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)',
            borderWidth: 1,
            borderRadius: 5,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            mode: 'index',
            intersect: false,
          },
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              enabled: true,
              backgroundColor: 'rgba(0, 0, 0, 0.9)',
              titleColor: '#ffffff',
              bodyColor: '#ffffff',
              borderColor: '#ffffff',
              borderWidth: 1,
              cornerRadius: 6,
              displayColors: true,
              callbacks: {
                title: function(tooltipItems) {
                  return tooltipItems[0].label;
                },
                label: function(context) {
                  return `Total: ${context.parsed.y} hallazgos`;
                },
                afterLabel: function(context) {
                  const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                  const percentage = total > 0 ? ((context.parsed.y / total) * 100).toFixed(1) : '0';
                  return `Porcentaje: ${percentage}%`;
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              display: true,
              ticks: {
                display: true,
                color: '#000',
                font: { 
                  size: 12,
                  weight: 'normal'
                },
                precision: 0,
                stepSize: 1,
                callback: function(value) {
                  return Math.floor(value);
                }
              },
              grid: {
                display: true,
                drawBorder: true,
                drawOnChartArea: true,
                drawTicks: true,
                color: 'rgba(0, 0, 0, 0.2)',
                borderColor: 'rgba(0, 0, 0, 0.6)',
                borderWidth: 2,
                lineWidth: 1,
                tickColor: 'rgba(255, 255, 255, 0.4)',
                tickLength: 8,
                tickWidth: 1
              },
              title: {
                display: true,
                text: 'Número de hallazgos',
                color: '#000',
                font: { size: 13, weight: 'bold' }
              }
            },
            x: {
              display: true,
              ticks: {
                display: true,
                color: '#000',
                font: { 
                  size: 11, 
                  weight: 'bold' 
                },
                maxRotation: 45,
                minRotation: 0,
                autoSkip: false,
                callback: function(value, index) {
                  const label = this.getLabelForValue(value);
                  return label ;
                }
              },
              grid: {
                display: true,
                drawBorder: true,
                drawOnChartArea: true,
                drawTicks: true,
                color: 'rgba(0, 0, 0, 0.1)',
                borderColor: 'rgba(0, 0, 0, 0.6)',
                borderWidth: 2,
                lineWidth: 1,
                tickColor: 'rgba(0, 0, 0, 0.4)',
                tickLength: 8,
                tickWidth: 1
              },
              title: {
                display: true,
                text: 'Áreas de auditoría',
                color: '#000',
                font: { size: 13, weight: 'bold' }
              }
            }
          },
          layout: {
            padding: { 
              top: 15, 
              bottom: 15, 
              left: 15, 
              right: 15 
            }
          },
          onHover: (event, activeElements, chart) => {
            if (chart && chart.canvas) {
              chart.canvas.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            }
          }
        }
      });
      
      console.log('Gráfico de áreas recurrencia creado exitosamente');
      
    } catch (error) {
      console.error('Error creando gráfico de áreas recurrencia:', error);
    }
  }
  
  // GRÁFICO 2 - Hallazgos por criticidad (barras apiladas)
  const canvasHallazgos = document.getElementById('chartHallazgosCriticidad');
  if (canvasHallazgos) {
    console.log('Creando gráfico de hallazgos por criticidad...');
    
    if (chartHallazgosCriticidad) {
      chartHallazgosCriticidad.destroy();
    }
    
    try {
      const ctx = canvasHallazgos.getContext('2d');
      
      // Preparar datos para barras apiladas
      const areas = Object.keys(hallazgosCriticidad);
      const dataAlta = areas.map(area => hallazgosCriticidad[area]?.alta || 0);
      const dataMedia = areas.map(area => hallazgosCriticidad[area]?.media || 0);
      const dataBaja = areas.map(area => hallazgosCriticidad[area]?.baja || 0);
      
      chartHallazgosCriticidad = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: areas,
          datasets: [
            {
              label: 'Alta',
              data: dataAlta,
              backgroundColor: '#dc2626',
              hoverBackgroundColor: '#ef4444',
              stack: 'criticidad',
              borderWidth: 0,
              borderRadius: 3,
              borderSkipped: false,
            },
            {
              label: 'Media',
              data: dataMedia,
              backgroundColor: '#f59e0b',
              hoverBackgroundColor: '#fbbf24',
              stack: 'criticidad',
              borderWidth: 0,
              borderRadius: 3,
              borderSkipped: false,
            },
            {
              label: 'Baja',
              data: dataBaja,
              backgroundColor: '#10b981',
              hoverBackgroundColor: '#34d399',
              stack: 'criticidad',
              borderWidth: 0,
              borderRadius: 3,
              borderSkipped: false,
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            mode: 'index',
            intersect: false,
          },
          plugins: {
            title: {
              display: false
            },
            legend: {
              display: true,
              position: 'top',
              labels: {
                color: '#000',
                font: { size: 11, weight: 'bold' },
                padding: 15,
                usePointStyle: true,
                pointStyle: 'rect'
              }
            },
            tooltip: {
              enabled: true,
              backgroundColor: 'rgba(0, 0, 0, 0.9)',
              titleColor: '#ffffff',
              bodyColor: '#ffffff',
              borderColor: '#ffffff',
              borderWidth: 1,
              cornerRadius: 6,
              displayColors: true,
              callbacks: {
                title: function(tooltipItems) {
                  return tooltipItems[0].label;
                },
                label: function(context) {
                  return `${context.dataset.label}: ${context.parsed.y} hallazgos`;
                },
                afterLabel: function(context) {
                  const dataIndex = context.dataIndex;
                  const datasets = context.chart.data.datasets;
                  const total = datasets.reduce((sum, dataset) => {
                    return sum + (dataset.data[dataIndex] || 0);
                  }, 0);
                  const percentage = total > 0 ? ((context.parsed.y / total) * 100).toFixed(1) : '0';
                  return `Porcentaje del área: ${percentage}%`;
                }
              }
            }
          },
          scales: {
            x: {
              stacked: true,
              display: true,
              title: {
                display: true,
                text: 'Áreas',
                color: '#000',
                font: { size: 13, weight: 'bold' }
              },
              ticks: {
                display: true,
                color: '#000',
                font: { size: 11, weight: 'bold' },
                autoSkip: false,
                maxRotation: 45,
                minRotation: 15,
                callback: function(value, index) {
                  const label = this.getLabelForValue(value);
                  return label;
                }
              },
              grid: {
                display: true,
                drawBorder: true,
                drawOnChartArea: true,
                drawTicks: true,
                color: 'rgba(0, 0, 0, 0.1)',
                borderColor: 'rgba(0, 0, 0, 0.6)',
                borderWidth: 2,
                lineWidth: 1,
                tickColor: 'rgba(0, 0, 0, 0.4)',
                tickLength: 8,
                tickWidth: 1
              }
            },
            y: {
              stacked: true,
              beginAtZero: true,
              display: true,
              title: {
                display: true,
                text: 'Total de hallazgos',
                color: '#000',
                font: { size: 13, weight: 'bold' }
              },
              ticks: {
                display: true,
                color: '#000',
                font: { size: 12 },
                stepSize: 1,
                callback: function(value) {
                  return Math.floor(value);
                }
              },
              grid: {
                display: true,
                drawBorder: true,
                drawOnChartArea: true,
                drawTicks: true,
                color: 'rgba(0, 0, 0, 0.2)',
                borderColor: 'rgba(0, 0, 0, 0.6)',
                borderWidth: 2,
                lineWidth: 1,
                tickColor: 'rgba(0, 0, 0, 0.4)',
                tickLength: 8,
                tickWidth: 1
              }
            }
          },
          layout: {
            padding: { 
              top: 15, 
              bottom: 15, 
              left: 15, 
              right: 15 
            }
          },
          onHover: (event, activeElements, chart) => {
            if (chart && chart.canvas) {
              chart.canvas.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            }
          }
        }
      });
      
      console.log('Gráfico de hallazgos por criticidad creado exitosamente');
      
    } catch (error) {
      console.error('Error creando gráfico de hallazgos:', error);
    }
  }

  console.log('Inicialización de gráficos completada');
  
  updateStats();

  // Inicializar actualizaciones automáticas
  const autoUpdateInterval = startAutoUpdate(5);
  
  // Agregar botón manual de actualización
  const refreshButton = `
    <button id="manual-refresh-btn" style="
      position: fixed;
      bottom: 70px;
      right: 20px;
      background: #3498db;
      color: white;
      border: none;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      z-index: 1000;
    " title="Actualizar estadísticas y gráficos">
      <i class="tim-icons icon-refresh-01"></i>
    </button>
  `;
  
  $('body').append(refreshButton);
  
  // Event listener para botón manual
  $('#manual-refresh-btn').on('click', function() {
    $(this).find('i').addClass('fa-spin');
    updateStats();
    setTimeout(() => {
      $(this).find('i').removeClass('fa-spin');
    }, 2000);
  });
  
  // Limpiar al salir de la página
  $(window).on('beforeunload', function() {
    stopAutoUpdate(autoUpdateInterval);
  });
});

// ========================================
// FUNCIONES PARA FILTROS SEPARADOS POR GRÁFICA
// ========================================

function initSeparateChartFilters() {
  const today = new Date();
  const maxDate = today.toISOString().split('T')[0];
  
  // Establecer fecha máxima para ambas gráficas
  $('#areas_fecha_inicio, #areas_fecha_fin, #criticidad_fecha_inicio, #criticidad_fecha_fin').attr('max', maxDate);
  
  // Event listeners para gráfica de ÁREAS
  $('#aplicar-filtro-areas').on('click', function() {
    aplicarFiltroAreas();
  });
  
  $('#limpiar-filtro-areas').on('click', function() {
    limpiarFiltroAreas();
  });
  
  // Event listeners para gráfica de CRITICIDAD
  $('#aplicar-filtro-criticidad').on('click', function() {
    aplicarFiltroCriticidad();
  });
  
  $('#limpiar-filtro-criticidad').on('click', function() {
    limpiarFiltroCriticidad();
  });
  
  // Event listeners para validación de fechas por gráfica
  $('#areas_fecha_inicio, #areas_fecha_fin').on('change', function() {
    validarRangoFechas('areas');
  });
  
  $('#criticidad_fecha_inicio, #criticidad_fecha_fin').on('change', function() {
    validarRangoFechas('criticidad');
  });
}

// FUNCIONES PARA GRÁFICA DE ÁREAS
function aplicarFiltroAreas() {
  const fechaInicio = $('#areas_fecha_inicio').val();
  const fechaFin = $('#areas_fecha_fin').val();
  
  if (!fechaInicio || !fechaFin) {
    mostrarNotificacion('error', 'Debe seleccionar ambas fechas para el gráfico de áreas');
    return;
  }
  
  if (fechaInicio > fechaFin) {
    mostrarNotificacion('error', 'La fecha de inicio no puede ser mayor a la fecha fin');
    return;
  }
  
  areasChartFilters = {
    fecha_inicio: fechaInicio,
    fecha_fin: fechaFin
  };
  
  // Marcar que este gráfico ahora tiene filtros activos
  areasChartFilters.hasActiveFilters = true;
  
  actualizarGraficaAreas();
  mostrarNotificacion('success', 'Filtro aplicado al gráfico de áreas');
}

function limpiarFiltroAreas() {
  $('#areas_fecha_inicio, #areas_fecha_fin').val('');
  areasChartFilters = {
    fecha_inicio: null,
    fecha_fin: null,
    hasActiveFilters: false
  };
  
  // Volver a cargar datos generales para esta gráfica
  cargarDatosGeneralesAreas();
  mostrarNotificacion('success', 'Filtros del gráfico de áreas limpiados - Mostrando datos generales');
}

function cargarDatosGeneralesAreas() {
  console.log('Cargando datos generales para gráfica de áreas...');
  showLoadingIndicator();
  
  // Usar la ruta general sin parámetros para obtener todos los datos
  fetch('/dashboard/chart-areas-data', {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('Datos generales de gráfica de áreas recibidos:', data);
    updateAreasChart(data.areas_recurrencia || []);
  })
  .catch(error => {
    console.error('Error al cargar datos generales de áreas:', error);
    mostrarNotificacion('error', 'Error al cargar datos generales de áreas');
  })
  .finally(() => {
    hideLoadingIndicator();
  });
}

function limpiarFiltroAreas() {
  $('#areas_fecha_inicio, #areas_fecha_fin').val('');
  areasChartFilters = {
    fecha_inicio: null,
    fecha_fin: null
  };
  
  actualizarGraficaAreas();
  mostrarNotificacion('success', 'Filtros del gráfico de áreas limpiados');
}

function actualizarGraficaAreas() {
  console.log('Actualizando gráfica de áreas con filtros:', areasChartFilters);
  showLoadingIndicator();
  
  const params = new URLSearchParams();
  params.append('chart_type', 'areas');
  if (areasChartFilters.fecha_inicio) {
    params.append('fecha_inicio', areasChartFilters.fecha_inicio);
  }
  if (areasChartFilters.fecha_fin) {
    params.append('fecha_fin', areasChartFilters.fecha_fin);
  }
  
  const url = '/dashboard/chart-areas-data?' + params.toString();
  
  fetch(url, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('Datos de gráfica de áreas recibidos:', data);
    updateAreasChart(data.areas_recurrencia || []);
  })
  .catch(error => {
    console.error('Error al actualizar gráfica de áreas:', error);
    mostrarNotificacion('error', 'Error al actualizar gráfica de áreas');
  })
  .finally(() => {
    hideLoadingIndicator();
  });
}

// FUNCIONES PARA GRÁFICA DE CRITICIDAD
function aplicarFiltroCriticidad() {
  const fechaInicio = $('#criticidad_fecha_inicio').val();
  const fechaFin = $('#criticidad_fecha_fin').val();
  
  if (!fechaInicio || !fechaFin) {
    mostrarNotificacion('error', 'Debe seleccionar ambas fechas para el gráfico de criticidad');
    return;
  }
  
  if (fechaInicio > fechaFin) {
    mostrarNotificacion('error', 'La fecha de inicio no puede ser mayor a la fecha fin');
    return;
  }
  
  criticidadChartFilters = {
    fecha_inicio: fechaInicio,
    fecha_fin: fechaFin
  };
  
  // Marcar que este gráfico ahora tiene filtros activos
  criticidadChartFilters.hasActiveFilters = true;
  
  actualizarGraficaCriticidad();
  mostrarNotificacion('success', 'Filtro aplicado al gráfico de criticidad');
}

function limpiarFiltroCriticidad() {
  $('#criticidad_fecha_inicio, #criticidad_fecha_fin').val('');
  criticidadChartFilters = {
    fecha_inicio: null,
    fecha_fin: null,
    hasActiveFilters: false
  };
  
  // Volver a cargar datos generales para esta gráfica
  cargarDatosGeneralesCriticidad();
  mostrarNotificacion('success', 'Filtros del gráfico de criticidad limpiados - Mostrando datos generales');
}

function cargarDatosGeneralesCriticidad() {
  console.log('Cargando datos generales para gráfica de criticidad...');
  showLoadingIndicator();
  
  // Usar la ruta general sin parámetros para obtener todos los datos
  fetch('/dashboard/chart-criticidad-data', {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('Datos generales de gráfica de criticidad recibidos:', data);
    updateCriticidadChart(data.hallazgos_criticidad || {});
  })
  .catch(error => {
    console.error('Error al cargar datos generales de criticidad:', error);
    mostrarNotificacion('error', 'Error al cargar datos generales de criticidad');
  })
  .finally(() => {
    hideLoadingIndicator();
  });
}

function limpiarFiltroCriticidad() {
  $('#criticidad_fecha_inicio, #criticidad_fecha_fin').val('');
  criticidadChartFilters = {
    fecha_inicio: null,
    fecha_fin: null
  };
  
  actualizarGraficaCriticidad();
  mostrarNotificacion('success', 'Filtros del gráfico de criticidad limpiados');
}

function actualizarGraficaCriticidad() {
  console.log('Actualizando gráfica de criticidad con filtros:', criticidadChartFilters);
  showLoadingIndicator();
  
  const params = new URLSearchParams();
  params.append('chart_type', 'criticidad');
  if (criticidadChartFilters.fecha_inicio) {
    params.append('fecha_inicio', criticidadChartFilters.fecha_inicio);
  }
  if (criticidadChartFilters.fecha_fin) {
    params.append('fecha_fin', criticidadChartFilters.fecha_fin);
  }
  
  const url = '/dashboard/chart-criticidad-data?' + params.toString();
  
  fetch(url, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('Datos de gráfica de criticidad recibidos:', data);
    updateCriticidadChart(data.hallazgos_criticidad || {});
  })
  .catch(error => {
    console.error('Error al actualizar gráfica de criticidad:', error);
    mostrarNotificacion('error', 'Error al actualizar gráfica de criticidad');
  })
  .finally(() => {
    hideLoadingIndicator();
  });
}

// FUNCIÓN GENERAL DE VALIDACIÓN
function validarRangoFechas(chartType) {
  const prefijo = chartType === 'areas' ? 'areas' : 'criticidad';
  const fechaInicio = $(`#${prefijo}_fecha_inicio`).val();
  const fechaFin = $(`#${prefijo}_fecha_fin`).val();
  const today = new Date().toISOString().split('T')[0];
  
  // Validar que no sean fechas futuras
  if (fechaInicio > today) {
    $(`#${prefijo}_fecha_inicio`).val(today);
    mostrarNotificacion('warning', 'No se permiten fechas futuras');
  }
  
  if (fechaFin > today) {
    $(`#${prefijo}_fecha_fin`).val(today);
    mostrarNotificacion('warning', 'No se permiten fechas futuras');
  }
  
  // Validar rango
  if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
    $(`#${prefijo}_fecha_fin`).val(fechaInicio);
    mostrarNotificacion('warning', 'Fecha fin ajustada automáticamente');
  }
}

// FUNCIONES PARA ACTUALIZAR GRÁFICAS INDIVIDUALES
function updateAreasChart(areasData) {
  if (!chartAreasRecurrencia || !areasData) return;
  
  const newLabels = areasData.map(item => item.area);
  const newData = areasData.map(item => parseInt(item.total));
  
  console.log('Actualizando gráfica de áreas - Labels:', newLabels, 'Data:', newData);
  
  chartAreasRecurrencia.data.labels = newLabels;
  chartAreasRecurrencia.data.datasets[0].data = newData;
  chartAreasRecurrencia.data.datasets[0].backgroundColor = colors.slice(0, newLabels.length);
  chartAreasRecurrencia.update('active');
  
  console.log('Gráfica de áreas actualizada');
}

function updateCriticidadChart(criticidadData) {
  if (!chartHallazgosCriticidad || !criticidadData) return;
  
  currentHallazgosCriticidad = criticidadData;
  
  const newLabels = Object.keys(criticidadData);
  const dataAlta = newLabels.map(area => criticidadData[area].alta || 0);
  const dataMedia = newLabels.map(area => criticidadData[area].media || 0);
  const dataBaja = newLabels.map(area => criticidadData[area].baja || 0);
  
  console.log('Actualizando gráfica de criticidad - Labels:', newLabels);
  console.log('Data Alta:', dataAlta, 'Media:', dataMedia, 'Baja:', dataBaja);
  
  chartHallazgosCriticidad.data.labels = newLabels;
  chartHallazgosCriticidad.data.datasets[0].data = dataAlta;
  chartHallazgosCriticidad.data.datasets[1].data = dataMedia;
  chartHallazgosCriticidad.data.datasets[2].data = dataBaja;
  chartHallazgosCriticidad.update('active');
  
  console.log('Gráfica de criticidad actualizada');
}

function mostrarNotificacion(tipo, mensaje) {
  const colores = {
    success: '#27ae60',
    error: '#e74c3c',
    warning: '#f39c12'
  };
  
  const iconos = {
    success: 'icon-check-2',
    error: 'icon-simple-remove',
    warning: 'icon-alert-circle-exc'
  };
  
  const notification = document.createElement('div');
  notification.innerHTML = `
    <div style="
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 12px 20px;
      border-radius: 6px;
      color: white;
      font-weight: 500;
      z-index: 10000;
      opacity: 0;
      transform: translateX(100%);
      transition: all 0.3s ease;
      background-color: ${colores[tipo]};
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    ">
      <i class="tim-icons ${iconos[tipo]}"></i>
      ${mensaje}
    </div>
  `;
  
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.firstElementChild.style.opacity = '1';
    notification.firstElementChild.style.transform = 'translateX(0)';
  }, 100);
  
  setTimeout(() => {
    notification.firstElementChild.style.opacity = '0';
    notification.firstElementChild.style.transform = 'translateX(100%)';
    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 300);
  }, 3000);
}

// ========================================
// FUNCIONES GLOBALES (MODIFICADAS PARA COMPATIBILIDAD)
// ========================================

function updateCharts() {
  console.log('Iniciando actualización global de gráficos...');
  
  // Solo actualizar gráficas que NO tienen filtros activos (usar datos generales)
  if (!areasChartFilters.hasActiveFilters) {
    console.log('Actualizando gráfica de áreas con datos generales...');
    cargarDatosGeneralesAreas();
  } else {
    console.log('Gráfica de áreas tiene filtros activos, manteniendo filtros...');
  }
  
  if (!criticidadChartFilters.hasActiveFilters) {
    console.log('Actualizando gráfica de criticidad con datos generales...');
    cargarDatosGeneralesCriticidad();
  } else {
    console.log('Gráfica de criticidad tiene filtros activos, manteniendo filtros...');
  }
  
  return Promise.resolve();
}

function updateChartsWithData(chartData) {
  console.log('Actualizando gráficos con datos proporcionados (datos generales):', chartData);
  
  // Solo actualizar con datos generales si no hay filtros activos en cada gráfica
  if (!areasChartFilters.hasActiveFilters && chartData.areas_recurrencia) {
    console.log('Aplicando datos generales a gráfica de áreas...');
    updateAreasChart(chartData.areas_recurrencia);
  }
  
  if (!criticidadChartFilters.hasActiveFilters && chartData.hallazgos_criticidad) {
    console.log('Aplicando datos generales a gráfica de criticidad...');
    updateCriticidadChart(chartData.hallazgos_criticidad);
  }
  
  return Promise.resolve();
}

// ========================================
// FUNCIONES PARA ESTADÍSTICAS (CARDS) - SIN CAMBIOS
// ========================================

function updateStats() {
  console.log('Actualizando estadísticas...');
  showLoadingIndicator();
  
  fetch('/dashboard/statistics', {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('Datos de estadísticas recibidos:', data);
    
    if (data.stats) {
      updateStatsCards(data.stats);
      showUpdateNotification('success', 'Estadísticas actualizadas');
    }
    
    // Actualizar gráficas solo si no tienen filtros activos (usar datos generales)
    if (data.charts) {
      return updateChartsWithData(data.charts);
    } else {
      return updateCharts();
    }
  })
  .then(() => {
    updateLastUpdateTime();
  })
  .catch(error => {
    console.error('Error:', error);
    showUpdateNotification('error', 'Error al actualizar: ' + error.message);
  })
  .finally(() => {
    hideLoadingIndicator();
  });
}

function updateStatsCards(stats) {
  console.log('Actualizando cards con:', stats);
  
  const cardMappings = {
    'auditorias_mes': 'stat-auditorias-mes',
    'hallazgos_activos': 'stat-hallazgos-activos',
    'hallazgos_vencidos': 'stat-hallazgos-vencidos', 
    'hallazgos_subsanados': 'stat-hallazgos-subsanados'
  };
  
  Object.keys(cardMappings).forEach(statKey => {
    const elementId = cardMappings[statKey];
    const element = document.getElementById(elementId);
    
    if (element && stats[statKey] !== undefined) {
      const currentValue = parseInt(element.textContent) || 0;
      const newValue = stats[statKey];
      
      console.log(`${statKey}: ${currentValue} → ${newValue}`);
      
      if (currentValue !== newValue) {
        animateNumber(element, currentValue, newValue);
      }
    } else {
      console.warn(`Elemento no encontrado: ${elementId} o valor undefined:`, stats[statKey]);
    }
  });
}

function animateNumber(element, from, to) {
  if (from === to) return;
  
  const duration = 1000;
  const steps = 60;
  const stepTime = duration / steps;
  const difference = to - from;
  const stepValue = difference / steps;
  
  let current = from;
  let step = 0;
  
  const timer = setInterval(() => {
    step++;
    current += stepValue;
    
    if (step >= steps) {
      current = to;
      clearInterval(timer);
    }
    
    element.textContent = Math.round(current);
    
    if (Math.abs(difference) > 0) {
      element.style.color = difference > 0 ? '#e74c3c' : '#27ae60';
      setTimeout(() => {
        element.style.color = '';
      }, 2000);
    }
  }, stepTime);
}

function showLoadingIndicator() {
  let loadingDiv = document.getElementById('dashboard-loading');
  if (!loadingDiv) {
    loadingDiv = document.createElement('div');
    loadingDiv.id = 'dashboard-loading';
    loadingDiv.innerHTML = `
      <div style="
        position: fixed;
        top: 20px;
        right: 20px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
      ">
        <div style="
          width: 16px;
          height: 16px;
          border: 2px solid #ffffff;
          border-top: 2px solid transparent;
          border-radius: 50%;
          animation: spin 1s linear infinite;
        "></div>
        <span>Actualizando...</span>
      </div>
      <style>
        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
      </style>
    `;
    document.body.appendChild(loadingDiv);
  } else {
    loadingDiv.style.display = 'block';
  }
}

function hideLoadingIndicator() {
  const loadingDiv = document.getElementById('dashboard-loading');
  if (loadingDiv) {
    loadingDiv.style.display = 'none';
  }
}

function showUpdateNotification(type, message) {
  const notification = document.createElement('div');
  notification.className = `update-notification ${type}`;
  notification.innerHTML = `
    <div style="
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 12px 20px;
      border-radius: 5px;
      color: white;
      font-weight: 500;
      z-index: 10000;
      opacity: 0;
      transform: translateX(100%);
      transition: all 0.3s ease;
      ${type === 'success' ? 'background-color: #27ae60;' : 'background-color: #e74c3c;'}
    ">
      <i class="tim-icons ${type === 'success' ? 'icon-check-2' : 'icon-alert-circle-exc'}"></i>
      ${message}
    </div>
  `;
  
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.firstElementChild.style.opacity = '1';
    notification.firstElementChild.style.transform = 'translateX(0)';
  }, 100);
  
  setTimeout(() => {
    notification.firstElementChild.style.opacity = '0';
    notification.firstElementChild.style.transform = 'translateX(100%)';
    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 300);
  }, 3000);
}

function updateLastUpdateTime() {
  let timestampDiv = document.getElementById('last-update-time');
  if (!timestampDiv) {
    timestampDiv = document.createElement('div');
    timestampDiv.id = 'last-update-time';
    timestampDiv.style.cssText = `
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: rgba(0,0,0,0.7);
      color: white;
      padding: 5px 10px;
      border-radius: 3px;
      font-size: 12px;
      z-index: 1000;
    `;
    document.body.appendChild(timestampDiv);
  }
  
  const now = new Date();
  const timeString = now.toLocaleTimeString('es-ES', { 
    hour: '2-digit', 
    minute: '2-digit', 
    second: '2-digit' 
  });
  timestampDiv.textContent = `Última actualización: ${timeString}`;
}

function startAutoUpdate(intervalMinutes = 5) {
  updateStats();
  
  const intervalMs = intervalMinutes * 60 * 1000;
  const updateInterval = setInterval(updateStats, intervalMs);
  
  console.log(`Actualizaciones automáticas iniciadas cada ${intervalMinutes} minutos`);
  
  return updateInterval;
}

function stopAutoUpdate(intervalId) {
  if (intervalId) {
    clearInterval(intervalId);
    console.log('Actualizaciones automáticas detenidas');
  }
}

function formatNumber(num) {
  if (num >= 1000000) {
    return (num / 1000000).toFixed(1) + 'M';
  }
  if (num >= 1000) {
    return (num / 1000).toFixed(1) + 'K';
  }
  return num.toString();
}

</script>
@endpush