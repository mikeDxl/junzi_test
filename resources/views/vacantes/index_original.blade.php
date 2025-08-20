@extends('layouts.app', ['activePage' => 'Vacantes', 'menuParent' => 'laravel', 'titlePage' => __('Vacantes')])

@section('content')
<style media="screen">
/* Contenedor general de las pestañas */
.custom-tabs-container {
  width: 100%;
  margin: 20px 0;
}

/* Contenedor de los botones de las pestañas */
.custom-tabs {
  display: flex;
  border-bottom: 2px solid #ddd;
}

/* Botones de las pestañas */
.custom-tab-button {
  flex: 1;
  padding: 10px 20px;
  background-color: #f1f1f1; /* Fondo gris para las pestañas inactivas */
  border: 1px solid #ddd;
  border-bottom: none;
  cursor: pointer;
  text-align: center;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

/* Estilo del botón de la pestaña activa */
.custom-tab-button.active {
  background-color: #3358f4; /* Fondo azul para la pestaña activa */
  color: white; /* Color del texto blanco para contraste */
  border-color: #3358f4;
  border-bottom: 2px solid #3358f4; /* Línea activa azul */
  font-weight: bold;
}

/* Estilo del botón de la pestaña cuando se pasa el ratón */
.custom-tab-button:hover {
  background-color: #e0e0e0;
}

/* Contenido de las pestañas */
.custom-tab-content {
  display: none;
  padding: 20px;
  background-color: #ffffff;
}

/* Estilo del contenido activo de la pestaña */
.custom-tab-content.active {
  display: block;
}

/* Estilo de las tablas */
.custom-table {
  width: 100%;
  margin: 0;
  border-collapse: collapse;
}

.custom-table th, .custom-table td {
  padding: 12px;
  text-align: left;
  border: 1px solid #ddd;
}

.custom-table thead th {
  background-color: #f8f9fa;
  color: #007bff;
}
</style>

<div class="content">
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title">Vacantes</h4>
                  </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('vacantes.create') }}" class="btn btn-primary">Nueva Vacante</a>
                            </div>
                        </div>
                  <div class="card-body">
                      <div class="card">
                          <div class="card-header">
                              <h5 class="card-title">Proceso de Reclutamiento</h5>
                              <div class="custom-tabs">
                                  <button class="custom-tab-button active" data-tab="enProceso">En proceso</button>
                                  <button class="custom-tab-button" data-tab="enEspera">En espera de ingreso</button>
                                  <button class="custom-tab-button" data-tab="historico">Histórico</button>
                              </div>
                          </div>
                          <div class="card-body custom-tabs-container">
                              <div class="custom-tab-content active" id="enProceso">
                                  <div class="table-responsive">
                                      <table class="custom-table">
                                          <thead class="text-primary">
                                              <tr>
                                                  <th>Prioridad</th>
                                                  <th># Candidatos</th>
                                                  <th>Puesto</th>
                                                  <th>Proceso</th>
                                                  <th class="text-right">Tiempo abierta</th>
                                                  <th class="text-right">Seguimiento</th>
                                                  <th class="text-right">Edtar</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach($vacantesEnProceso as $vac)
                                                  @include('vacantes.partials.row', ['vac' => $vac, 'tab' => 'enProceso'])
                                              @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                              <div class="custom-tab-content" id="enEspera">
                                  <div class="table-responsive">
                                      <table class="custom-table">
                                          <thead class="text-primary">
                                              <tr>
                                                  <th>Prioridad</th>
                                                  <th># Candidatos</th>
                                                  <th>Puesto</th>
                                                  <th>Proceso</th>
                                                  <th class="text-right">Tiempo abierta</th>
                                                  <th class="text-right">Seguimiento</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach($vacantesEnEspera as $vac)
                                                  @include('vacantes.partials.row', ['vac' => $vac, 'tab' => 'enEspera'])
                                              @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                              <div class="custom-tab-content" id="historico">
                                  <div class="table-responsive">
                                      <table class="custom-table">
                                          <thead class="text-primary">
                                              <tr>
                                                  <th>Prioridad</th>
                                                  <th># Candidatos</th>
                                                  <th>Puesto</th>
                                                  <th>Proceso</th>
                                                  <th class="text-right">Tiempo abierta</th>
                                                  <th class="text-right">Seguimiento</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach($vacantesHistorico as $vac)
                                                  @include('vacantes.partials.row', ['vac' => $vac, 'tab' => 'historico'])
                                              @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div> <!-- custom-tabs-container -->
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('.custom-tab-button');
  const contents = document.querySelectorAll('.custom-tab-content');

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const targetTab = button.getAttribute('data-tab');

      // Remover la clase activa de todos los botones y contenidos
      buttons.forEach(btn => btn.classList.remove('active'));
      contents.forEach(content => content.classList.remove('active'));

      // Activar el botón y contenido seleccionados
      button.classList.add('active');
      document.getElementById(targetTab).classList.add('active');
    });
  });
});
</script>
@endsection
