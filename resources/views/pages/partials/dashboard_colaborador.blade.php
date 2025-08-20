@extends('home', ['activePage' => 'dashboardColaborador', 'menuParent' => 'dashboardColaborador', 'titlePage' => __('Dashboard Colaborador')])

@section('contentJunzi')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <h2>Bienvenid@ {{ auth()->user()->name }}</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h3 class="text-center">Cumpleañeros del mes</h3>
        <div style="max-height: 400px; overflow-y: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Puesto</th>
                        <th>Día de Cumpleaños</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cumpleaneros as $cumpleanero)
                    <tr>
                        <td>{{ $cumpleanero['nombre'] }}</td>
                        <td>{{ $cumpleanero['apellido_paterno'] }}</td>
                        <td>{{ buscarPuesto($cumpleanero['puesto'], $cumpleanero['company_id']) }}</td>
                        <td>{{ $cumpleanero['dia_cumple'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">No hay colaboradores que cumplan años este mes.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

   <div class="col-md-6">
   <h3 class="text-center">AVISOS ({{ count($mensajes) }}) </h3>
    @if($mensajes->isEmpty())
        <!-- Mensaje cuando no hay mensajes disponibles -->
        <div class="alert alert-info">
            No tienes mensajes asignados en este momento.
        </div>
    @else
        <!-- Carrusel de mensajes cuando sí hay mensajes -->
        <div id="carouselMensajes" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($mensajes as $key => $mensaje)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="card">
                            <div class="card-body">
                                {!! $mensaje->contenido !!} <!-- Mostrar el contenido HTML -->
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Flechas de navegación debajo del carrusel -->
        <div class="carousel-controls text-center mt-2">
            <button class="btn btn-info btn-sm" type="button" data-bs-target="#carouselMensajes" data-bs-slide="prev">
                <span><</span>
            </button>
            <button class="btn btn-info btn-sm" type="button" data-bs-target="#carouselMensajes" data-bs-slide="next">
                <span>></span>
            </button>
        </div>
    @endif
</div>


</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();
      demo.initVectorMap();
    });
  </script>
@endpush
