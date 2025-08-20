@extends('layouts.app', ['activePage' => 'Ubicaciones', 'menuParent' => 'laravel', 'titlePage' => __('Ubicaciones')])

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

.banner {
  background-color: rgba(0,0,0,.8);
  border-radius: 8px;
}

small {
  font-weight: 800!important;
}

</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Ubicaciones</h4>
          </div>
          <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('ubicaciones.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                          <div class="form-group">
                              <label for="ubicacion">Ubicación</label>
                              <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="" required>
                              @error('ubicacion')
                                  <small class="text-danger">{{ $message }}</small>
                              @enderror
                          </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="company_id">Empresa</label>
                            <select class="form-control" name="company_id"> 
                              <option></option>
                              @foreach($companies as $company)
                                <option value={{ $company->id }}>{{ $company->razon_social }}</option>
                              @endforeach
                            </select>
                            @error('company_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <br>
                        <button type="submit" class="btn btn-info btn-sm">Crear Ubicación</button>
                    </div>
                </div>
            </form>

            <div class="nav-buttons">
                <button id="prevBtn" class="nav-button">←</button>
                <button id="nextBtn" class="nav-button">→</button>
            </div>

            <div class="tab-container">
                @foreach($ubicaciones as $index => $ubicacion)
                    <div class="tab @if($index == 0) active @endif" data-index="{{ $index }}">
                        <h5>{{ $ubicacion->ubicacion ?? 'Sin nombre' }}</h5>
                    </div>
                @endforeach
            </div>

            <div class="tab-contents">
                @foreach($ubicaciones as $index => $ubicacion)
                    <div class="tab-content table-responsive @if($index == 0) active @endif" id="content-{{ $ubicacion->id }}" style="min-height:500px;">
                            <br>
                                <form action="{{ route('editar_ubicaciones') }}" method="POST" style="height:200px;">
                                  @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                        <input type="text" class="form-control" name="ubicacion_nombre" value="{{ $ubicacion->ubicacion }}">
                                        </div>
                                        <div class="col-md-4">
                                        <input type="hidden" name="ubicacion_old" value="{{ $ubicacion->ubicacion }}">
                                    <button type="submit" class="btn btn-sm btn-info">Actualizar</button>
                                        </div>
                                    </div>
                                
                                    
                                </form>
                            <br>

                            <form action="{{ route('ubicacion.agregar') }}" method="POST" style="height:200px;">
                                  @csrf
                                <table class="table" style="z-index:999999!important;">
                                <tr>
                                    <td>
                                        <select class="form-control colabselect" name="colaborador_id" style="z-index:999999!important;">
                                            <option value="">Selecciona</option>
                                            @foreach($colaboradores as $colaborador)
                                                <option value="{{ $colaborador->id }}">{{$colaborador->apellido_paterno.' '.$colaborador->apellido_materno.' '.$colaborador->nombre}} - {{ buscarPuesto($colaborador->puesto,$colaborador->company_id) }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-info">Agregar</button>
                                    </td>
                                </tr>
                                </table>
                                <input type="hidden" name="ubicacion_nombre" value="{{ $ubicacion->ubicacion }}">
                         </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Colaborador</th>
                                    <th>Puesto</th>
                                    <th>Salario</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($colaboradores as $colaborador)
                                    @if($colaborador->ubicaciones == $ubicacion->ubicacion)
                                        <tr>
                                            <td>{{ $colaborador->apellido_paterno.' '.$colaborador->apellido_materno.' '.$colaborador->nombre }}</td>
                                            <td>{{ buscarPuesto($colaborador->puesto,$colaborador->company_id) }}</td>
                                            <td>${{ number_format($colaborador->salario_diario*30,2) }}</td>
                                            <td>
                                                <form action="{{ route('ubicacion.destroy', $colaborador->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar al colaborador de esta ubicación?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-link text-danger" name="button">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        <br>
                        <br>
                                <form action="{{ route('eliminar_ubicaciones') }}" method="POST" style="height:200px;">
                                  @csrf
                                    <input type="hidden" name="ubicacion_old" value="{{ $ubicacion->ubicacion }}">
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            <br>
                    </div>
                @endforeach
            </div>

          </div>
        </div>
      </div>
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

  updateTabs(activeIndex);
});
</script>
@endpush
