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

</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Incidencias</h4>
          </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Incidencia</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Comentario</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($compensaciones as $compensacion)
                    <tr>
                      <td>Compensación</td>
                      <td>{{ $compensacion->fecha_gratificacion }}</td>
                      <td>${{ number_format($compensacion->monto,2) }}</td>
                      <td>{{ $compensacion->estatus }}</td>
                      <td>{{ $compensacion->comentarios }}</td>
                    </tr>
                  @endforeach
                  @foreach($horasextra as $he)
                    <tr>
                      <td>Horas extra</td>
                      <td>{{ $he->fecha_hora_extra }}</td>
                      <td>{{ number_format($he->cantidad,0) }}</td>
                      <td>{{ $he->estatus }}</td>
                      <td>{{ $he->comentarios }}</td>
                    </tr>
                  @endforeach

                  @foreach($asistencias as $asistencia)
                    <tr>
                      <td>Horas extra</td>
                      <td>{{ $asistencia->fecha }}</td>
                      <td>{{ $asistencia->asistencia }}</td>
                      <td>{{ $asistencia->estatus }}</td>
                      <td>{{ $asistencia->comentarios }}</td>
                    </tr>
                  @endforeach

                  @foreach($permisos as $permiso)
                    <tr>
                      <td>Permiso</td>
                      <td>{{ $permiso->fecha_permiso }}</td>
                      <td>{{ $permiso->tipo }}</td>
                      <td>{{ $permiso->estatus }}</td>
                      <td>{{ $permiso->comentarios }}</td>
                    </tr>
                  @endforeach

                  @foreach($incapacidades as $incapacidad)
                    <tr>
                      <td>Incapacidad</td>
                      <td>{{ $incapacidad->apartir }}</td>
                      <td>
                        {{ $incapacidad->dias . ' días' }}
                        @if($incapacidad->archivo)
                            <a href="{{ asset('storage/app/public/' . $incapacidad->archivo) }}" target="_blank">
                                <i class="fa fa-file" aria-hidden="true"></i>
                            </a>
                        @endif
                      </td>
                      <td>{{ $incapacidad->estatus }}</td>
                      <td>{{ $incapacidad->comentarios }}</td>
                    </tr>
                  @endforeach

                  @foreach($vacaciones as $vacacion)
                    <tr>
                          <td>Vacaciones</td>
                          <td nowrap style="width:120px;">{{ $vacacion->desde }}</td>
                          <td>{{ $vacacion->hasta }}</td>
                          <td nowrap style="width:120px;">
                            {{ $vacacion->estatus }}
                          </td>
                          <td>{{ $vacacion->comentarios }}</td>
                        </tr>
                  @endforeach
                </tbody>
              </table>

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
@endpush
