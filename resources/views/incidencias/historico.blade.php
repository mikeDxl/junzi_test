@extends('layouts.app', ['activePage' => 'Incidencias', 'menuParent' => 'laravel', 'titlePage' => __('Incidencias')])

@section('content')
<style media="screen">
/* Estilos para las pestañas */
.tab-container {
display: flex;
overflow-x: auto;
white-space: nowrap;
}

.tab {
display: inline-block;
padding: 10px 20px;
cursor: pointer;
border: 1px solid #ccc;
border-bottom: none;
background-color: #f1f1f1;
}

.tab.active {
background-color: #fff;
border-bottom: 1px solid #fff;
}

.tab-content {
border: 1px solid #ccc;
padding: 10px;
display: none;
}

.tab-content.active {
display: block;
}

/* Contenedor para botones de navegación */
.nav-buttons {
display: flex;
justify-content: space-between;
margin-bottom: 10px;
}

.nav-button {
cursor: pointer;
padding: 5px 10px;
background-color: #007bff;
color: #fff;
border: none;
border-radius: 5px;
}
.banner{ background-color: rgba(0,0,0,.8); border-radius: 8px;}
small{ font-weight: 800!important;}
</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Incidencias <small>(Histórico)</small> </h4>
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-md-4">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Pendientes</th>
                      <td> {{ $compensacionesPendientes+$permisosPendientes+$horasExtraPendientes+$incapacidadesPendientes+$vacacionesPendientes }} </td>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

            @if (session('success'))
                <div class="alert alert-info">
                    {{ session('success') }}
                </div>
            @endif
                <div class="row">
                  <div class="col-md-12" style="text-align:right;">
                    <a href="/incidencias">Ver actuales</a>
                  </div>
                </div>
                <form method="GET" action="{{ route('incidencias.historico') }}">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                          <label for="start_date">Fecha de inicio:</label>
                          <input type="date" id="start_date" name="start_date" value="{{ $startOfMonth }}" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label for="end_date">Fecha de fin:</label>
                          <input type="date" id="end_date" name="end_date" value="{{ $endOfMonth }}" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <br>
                      <button type="submit" class="btn btn-info">Buscar</button>
                    </div>
                  </div>
                </form>

            <div class="nav-buttons">
              <button id="prevBtn" class="nav-button">←</button>
              <button id="nextBtn" class="nav-button">→</button>
            </div>
            <div class="tab-container">
              @foreach($companies as $index => $company)
                <div class="tab @if($index == 0) active @endif" data-index="{{ $index }}">
                  <h5>{{ $company->razon_social }} <br> <small>{{ $company->rfc }}</small> </h5>
                  <b> {{incidencias_pendientes($company->id,$startOfMonth, $endOfMonth)}} </b>
                </div>
              @endforeach
            </div>
            <div class="tab-contents">
              @foreach($companies as $index => $company)
                <div class="tab-content table-responsive @if($index == 0) active @endif" id="content-{{ $company->id }}">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Colaborador</th>
                        <th scope="col">Incidencia</th>
                        <th style="width:120px;" scope="col">Fecha</th>
                        <th scope="col">Valor</th>
                        <th nowrap style="width:120px;" scope="col">Estatus</th>
                        <th scope="col">Comentario</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($compensaciones as $compensacion)
                        @if($compensacion->company_id==$company->id)
                        <tr>
                          <td>{{ qcolab($compensacion->colaborador_id) ?? 'Sin nombre' }}</td>
                          <td>Compensación</td>
                          <td nowrap style="width:120px;">{{ $compensacion->fecha_gratificacion }}</td>
                          <td>${{ number_format($compensacion->monto,2) }}</td>
                          <td nowrap style="width:120px;">
                            <form class="" action="{{ route('validarGratificaciones') }}" method="post">
                              @csrf
                              <input type="hidden" name="idgratificacion[]" value="{{ $compensacion->id }}">
                                <select class="form-control compensacion-status" name="estatus[]">
                                <option selected value="{{ $compensacion->estatus }}">{{ $compensacion->estatus }}</option>
                                @if($compensacion->estatus!='Pendiente')
                                <option value="Pendiente">Pendiente</option>
                                @endif
                                @if($compensacion->estatus!='Aprobada')
                                <option value="Aprobada">Aprobada</option>
                                @endif
                                @if($compensacion->estatus!='Rechazada')
                                <option value="Rechazada">Rechazada</option>
                                @endif
                              </select>
                            </form>
                          </td>
                          <td>{{ $compensacion->comentarios }}</td>
                        </tr>
                        @endif
                      @endforeach
                      @foreach($horasextra as $he)
                          @if($he->company_id == $company->id)
                              <tr>
                                  <td>{{ qcolab($he->colaborador_id) ?? 'Sin nombre' }}</td>
                                  <td>Horas extra</td>
                                  <td nowrap style="width:120px;">{{ $he->fecha_hora_extra }}</td>
                                  <td>{{ number_format($he->cantidad, 0) }}</td>
                                  <td nowrap style="width:120px;">
                                      <form action="{{ route('validarHorasExtra') }}" method="post">
                                          @csrf
                                          <input type="hidden" name="idhoraextra[]" value="{{ $he->id }}">
                                          <select class="form-control horas-extra-status" name="estatus[]">
                                              <option selected value="{{ $he->estatus }}">{{ $he->estatus }}</option>
                                              @if($he->estatus != 'Pendiente')
                                                  <option value="Pendiente">Pendiente</option>
                                              @endif
                                              @if($he->estatus != 'Aprobada')
                                                  <option value="Aprobada">Aprobada</option>
                                              @endif
                                              @if($he->estatus != 'Rechazada')
                                                  <option value="Rechazada">Rechazada</option>
                                              @endif
                                          </select>
                                      </form>
                                  </td>
                                  <td>{{ $he->comentarios }}</td>
                              </tr>
                          @endif
                      @endforeach


                      @foreach($asistencias as $asistencia)
                        @if($he->company_id==$company->id)
                        <tr>
                          <td>{{ qcolab($asistencia->colaborador_id) ?? 'Sin nombre' }}</td>
                          <td>Horas extra</td>
                          <td nowrap style="width:120px;">{{ $asistencia->fecha }}</td>
                          <td>{{ $asistencia->asistencia }}</td>
                          <td nowrap style="width:120px;">{{ $asistencia->estatus }}</td>
                          <td>{{ $asistencia->comentarios }}</td>
                        </tr>
                        @endif
                      @endforeach

                      @foreach($permisos as $permiso)
                        @if($permiso->company_id==$company->id)
                        <tr>
                          <td>{{ qcolab($permiso->colaborador_id) ?? 'Sin nombre' }}</td>
                          <td>Permiso</td>
                          <td nowrap style="width:120px;">{{ $permiso->fecha_permiso }}</td>
                          <td>{{ $permiso->tipo }}</td>
                          <td nowrap style="width:120px;">
                            <form action="{{ route('validarPermisos') }}" method="post">
                                @csrf
                                <input type="hidden" name="idpermiso[]" value="{{ $permiso->id }}">
                                <select class="form-control permiso-status" name="estatus[]">
                                    <option selected value="{{ $permiso->estatus }}">{{ $permiso->estatus }}</option>
                                    @if($permiso->estatus!='Pendiente')
                                        <option value="Pendiente">Pendiente</option>
                                    @endif
                                    @if($permiso->estatus!='Aprobada')
                                        <option value="Aprobada">Aprobada</option>
                                    @endif
                                    @if($permiso->estatus!='Rechazada')
                                        <option value="Rechazada">Rechazada</option>
                                    @endif
                                </select>
                            </form>
                          </td>
                          <td>{{ $permiso->comentarios }}</td>
                        </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endforeach
            </div>
          </div>
        </div>


@endsection

@push('js')


  <script>
    $(document).ready(function() {
      $('#datatables').fadeIn(1100);
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Buscar",
        },
        "columnDefs": [
          { "orderable": false, "targets": 4 },
        ],
      });
    });
  </script>

  <script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
const tabs = document.querySelectorAll(".tab");
const contents = document.querySelectorAll(".tab-content");
const tabContainer = document.querySelector(".tab-container");

let activeIndex = 0;

function updateTabs(index) {
  tabs.forEach((tab, i) => {
    if (i === index) {
      tab.classList.add("active");
      contents[i].classList.add("active");
    } else {
      tab.classList.remove("active");
      contents[i].classList.remove("active");
    }
  });
}

tabs.forEach((tab, index) => {
  tab.addEventListener("click", () => {
    activeIndex = index;
    updateTabs(index);
  });
});

// Botones de navegación
document.querySelector("#prevBtn").addEventListener("click", () => {
  if (activeIndex > 0) {
    activeIndex--;
    updateTabs(activeIndex);
    tabContainer.scrollLeft -= tabs[0].offsetWidth;
  }
});

document.querySelector("#nextBtn").addEventListener("click", () => {
  if (activeIndex < tabs.length - 1) {
    activeIndex++;
    updateTabs(activeIndex);
    tabContainer.scrollLeft += tabs[0].offsetWidth;
  }
});

// Inicializar la primera pestaña como activa
updateTabs(activeIndex);
});

  </script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const selectsPermiso = document.querySelectorAll('.permiso-status');
      selectsPermiso.forEach(function(select) {
          select.addEventListener('change', function() {
              select.closest('form').submit();
          });
      });

      const selectsHorasExtra = document.querySelectorAll('.horas-extra-status');
      selectsHorasExtra.forEach(function(select) {
          select.addEventListener('change', function() {
              select.closest('form').submit();
          });
      });

      const selectsCompensacion = document.querySelectorAll('.compensacion-status');
      selectsCompensacion.forEach(function(select) {
          select.addEventListener('change', function() {
              select.closest('form').submit();
          });
      });
  });
  </script>

@endpush
