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
            <h4 class="card-title">Vacaciones</h4>
          </div>
          <div class="card-body">

            @if (session('success'))
                <div class="alert alert-info">
                    {{ session('success') }}
                </div>
            @endif

            </div>
            <div class="nav-buttons">
              <button id="prevBtn" class="nav-button">←</button>
              <button id="nextBtn" class="nav-button">→</button>
            </div>
            <div class="tab-container">
              @foreach($companies as $index => $company)
                <div class="tab @if($index == 0) active @endif" data-index="{{ $index }}">
                  <h5>{{ $company->razon_social }} <br> <small>{{ $company->rfc }}</small> </h5>
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
                        <th scope="col">Fecha Alta</th>
                        <th scope="col">Actuales</th>
                        <th scope="col">Pendientes</th>

                        <th scope="col">Opciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($vacaciones as $vacacion)
                        @if($vacacion->company_id==$company->id)
                        @if(auth()->user()->nomina=='1')
                        <form action="{{ route('vacaciones.pendientes.update', $vacacion->id) }}" method="post">
                              @csrf
                              @method('POST') <!-- Usa POST ya que el formulario está enviando una solicitud POST -->
                        @endif
                              <tr>
                                  <td>
                                      {{ qcolab($vacacion->colaborador_id) }}
                                      <input type="hidden" name="colaborador_id" value="{{ $vacacion->colaborador_id }}">
                                  </td>
                                  <td>{{ $vacacion->fecha_alta }}</td>

                                  <td>
                                      @if(auth()->user()->nomina=='1')
                                      <input type="text" name="actuales" value="{{ $vacacion->actuales }}">
                                      @else
                                      {{ $vacacion->actuales }}
                                      @endif
                                  </td>
                                  <td>
                                        @if(auth()->user()->nomina=='1')
                                        <input type="text" name="anteriores" value="{{ $vacacion->anteriores }}">
                                          @else
                                          {{ $vacacion->anteriores }}
                                        @endif

                                  </td>
                                  <td>
                                  @if(auth()->user()->nomina=='1')
                                      <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
                                  @endif
                                  </td>
                              </tr>
                              @if(auth()->user()->nomina=='1')
                          </form>
                          @endif
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
