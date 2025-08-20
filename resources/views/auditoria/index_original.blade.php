@extends('layouts.app', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])

@section('content')
<style media="screen">
.tabs-container {
width: 100%;
margin: 20px 0;
}

.custom-tabs {
display: flex;
border-bottom: 2px solid #ddd;
}

.custom-tab-button {
flex: 1;
padding: 10px 20px;
background-color: #f1f1f1;
border: none;
cursor: pointer;
text-align: center;
font-size: 16px;
transition: background-color 0.3s ease;
}

.custom-tab-button.active {
background-color: #3358f4;
color: #ffffff;
font-weight: bold;
border-bottom: 2px solid #000;
}

.custom-tab-button:hover {
background-color: #dddddd;
}

.custom-tab-content {
padding: 20px;
background-color: #ffffff;
}

.custom-tab-pane {
display: none;
}

.custom-tab-pane.active {
display: block;
}

.custom-table {
width: 100%;
border-collapse: collapse;
}

.custom-table-header {
background-color: #3358f4;
color: #ffffff;
}

.custom-table th, .custom-table td {
padding: 8px 12px;
border: 1px solid #ddd;
}

.custom-table th {
text-align: left;
}

.custom-button {
background-color: #3358f4;
color: #ffffff;
padding: 5px 10px;
border-radius: 3px;
text-decoration: none;
font-size: 14px;
}

.custom-button:hover {
background-color: #2247d1;
}

th{ color: #fff!important;}
.responsables-cell {
    position: relative; /* Necesario para el posicionamiento absoluto del tooltip */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px; /* Ajusta según sea necesario */
}

.responsables-tooltip {
    display: none;
    position: absolute;
    background: #333;
    color: #fff;
    padding: 10px;
    border-radius: 3px;
    z-index: 1000;
    max-width: 300px;
    word-wrap: break-word;
    left: 0;
    top: 100%; /* Asegura que el tooltip se muestre debajo de la celda */
    margin-top: 5px; /* Espacio entre la celda y el tooltip */
    white-space: normal; /* Permite el salto de línea en el tooltip */
    box-shadow: 0 2px 5px rgba(0,0,0,0.2); /* Agrega sombra para mejorar la visibilidad */
}

.responsables-cell:hover .responsables-tooltip {
    display: block;
}

.table-responsive {
    overflow: visible; /* Asegura que el contenido (tooltip) no se corte */
}

.tooltip-inner {
    max-width: 300px; /* Ajusta el ancho máximo del tooltip */
    white-space: normal; /* Permite el salto de línea */
    text-overflow: clip; /* Evita el recorte del texto */
}
.responsables-tooltip {
    display: block !important;
    position: absolute;
    background: #333;
    color: #fff;
    padding: 10px;
    border-radius: 3px;
    z-index: 1000;
    max-width: 300px;
    word-wrap: break-word;
    left: 0;
    top: 100%;
    margin-top: 5px;
    white-space: normal;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

</style>
  <div class="content">
    <div class="container-fluid">
     @if(auth()->user()->auditoria=='1')
        <div class="row">
            <div class="col-md-12" style="text-align:right;">
            <a href="{{ route('auditorias.nueva') }}" class="btn btn-info" name="button">Crear auditoria</a>
            </div>
        </div>
        @endif
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-12 text-start">
                    <h4 class="card-title">Auditorías <small> ({{ count($auditorias) }}) </small> </h4>
                  </div>
                </div>
                 @if(auth()->user()->auditoria=='1')
                <div class="row">
                  <div class="col-12 text-end" style="text-align:right;">
                    <a href="/export/auditorias" class="btn btn-link">Exportar</a>
                  </div>
                </div>
                @endif
              </div>
              <div class="card-body">

                <div class="tabs-container">
                  <div class="custom-tabs">
                    <button class="custom-tab-button active" data-target="#tab-pendientes">Sin cerrar</button>
                    <button class="custom-tab-button" data-target="#tab-completadas">Cerradas</button>
                  </div>

                  <div class="custom-tab-content">
                      <!-- Tab de Auditorías Pendientes -->
                      <div id="tab-pendientes" class="custom-tab-pane active">
                          <div class="table-responsive">
                              <table class="table">
                                  <thead class="custom-table-header">
                                      <tr>
                                          <th>{{ __('Auditorias') }}</th>
                                          <th>{{ __('Hallazgos') }}</th>
                                          <th class="text-right">{{ __('Opciones') }}</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($auditoriasPendientes as $auditoria)
                                        <tr>
                                            <td nowrap>{{ $auditoria->tipo.'-'.$auditoria->area.'-'.$auditoria->anio.'-'.$auditoria->folio.'-'.$auditoria->id }}</td>
                                            <td>{{ $auditoria->hallazgos_count }}</td>
                                            <td class="text-right">
                                            <a href="/auditoria/{{ $auditoria->id }}" class="btn btn-info btn-sm">Ver</a>
                                        </td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>

                      <!-- Tab de Auditorías Completadas -->
                      <div id="tab-completadas" class="custom-tab-pane">
                          <div class="table-responsive">
                              <table class="table">
                                  <thead class="custom-table-header">
                                      <tr>
                                          <th>{{ __('Auditorias') }}</th>
                                          <th>{{ __('Hallazgos') }}</th>
                                          <th class="text-right">{{ __('Opciones') }}</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                     @foreach($auditoriasCerradas as $auditoria)
                                          <tr>
                                            <td nowrap>{{ $auditoria->tipo.'-'.$auditoria->area.'-'.$auditoria->ubicacion.'-'.$auditoria->anio.'-'.$auditoria->folio.'-'.$auditoria->id }}</td>
                                            <td>{{ $auditoria->hallazgos_count }}</td>
                                            <td class="text-right">
                                                <a href="/auditoria/{{ $auditoria->id }}" class="btn btn-info btn-sm">Ver</a>
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
            </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
  const tabButtons = document.querySelectorAll('.custom-tab-button');
  const tabPanes = document.querySelectorAll('.custom-tab-pane');

  tabButtons.forEach(button => {
      button.addEventListener('click', () => {
          // Remover la clase 'active' de todos los botones y pestañas
          tabButtons.forEach(btn => btn.classList.remove('active'));
          tabPanes.forEach(pane => pane.classList.remove('active'));

          // Añadir la clase 'active' al botón y pestaña seleccionados
          button.classList.add('active');
          const target = button.getAttribute('data-target');
          document.querySelector(target).classList.add('active');
      });
  });
});

  </script>
  <script type="text/javascript">
  $(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
});

  </script>
  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.responsables-cell').forEach(function (cell) {
        const tooltip = cell.querySelector('.responsables-tooltip');
        if (tooltip) {
            cell.addEventListener('mouseover', function () {
                tooltip.style.display = 'block';
            });
            cell.addEventListener('mouseout', function () {
                tooltip.style.display = 'none';
            });
        }
    });
});

  </script>
@endsection
