@extends('layouts.app', ['activePage' => 'Incidencias', 'menuParent' => 'laravel', 'titlePage' => __('Incidencias')])

@section('content')

<style media="screen">
/* Estilos para las pestañas */
.tab-container, .sub-tab-container {
  display: flex;
  overflow-x: auto;
  white-space: nowrap;
}

.tab, .sub-tab {
  display: inline-block;
  padding: 10px 20px;
  cursor: pointer;
  border: 1px solid #ccc;
  border-bottom: none;
  background-color: #f1f1f1;
}

.tab.active, .sub-tab.active {
  background-color: #fff;
  border-bottom: 1px solid #fff;
}

.tab-content, .sub-tab-content {
  border: 1px solid #ccc;
  padding: 10px;
  display: none;
}

.tab-content.active, .sub-tab-content.active {
  display: block;
}

/* Contenedor para botones de navegación */
.nav-buttons, .sub-nav-buttons {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.nav-button, .sub-nav-button {
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
            <h4 class="card-title">Proyectos</h4>
          </div>
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-info">
                  {{ session('success') }}
              </div>
            @endif

            <form action="{{ route('proyecto.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                          <div class="form-group">
                              <label for="proyecto">Proyecto</label>
                              <input type="text" class="form-control" id="proyecto" name="proyecto" value="" required>
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
                @foreach($proyectos as $index => $proyecto)
                    <div class="tab @if($index == 0) active @endif" data-index="{{ $index }}">
                        <h5>{{ $proyecto->proyecto ?? 'Sin nombre' }}</h5>
                    </div>
                @endforeach
            </div>

            <div class="tab-contents">
              @foreach($proyectos as $index => $proyecto)
                  <div class="tab-content table-responsive @if($index == 0) active @endif" id="content-{{ $proyecto->id }}" style="min-height:500px;">
                            <br>
                                <form action="{{ route('editar_proyectos') }}" method="POST" >
                                  @csrf
                                    <input type="text" class="form-control" name="proyecto_nombre" value="{{ $proyecto->proyecto }}">
                                    <input type="hidden" name="proyecto_old" value="{{ $proyecto->proyecto }}">
                                    <button type="submit" class="btn btn-sm btn-info">Actualizar</button>
                                </form>
                            <br>
                      <form action="{{ route('proyecto.agregar') }}" method="POST" style="height:200px;">
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
                                <input type="hidden" name="proyecto_nombre" value="{{ $proyecto->proyecto }}">
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
                                  @if($colaborador->proyectos == $proyecto->proyecto)
                                      <tr>
                                          <td>{{$colaborador->apellido_paterno.' '.$colaborador->apellido_materno.' '.$colaborador->nombre}}</td>
                                        <td>{{ buscarPuesto($colaborador->puesto,$colaborador->company_id) }}</td>
                                            <td>${{ number_format($colaborador->salario_diario*30,2) }}</td>
                                            
                                          <td>
                                              <form action="{{ route('proyecto.destroy', $colaborador->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proyecto?');">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="btn btn-sm btn-link text-danger">
                                                      <i class="fa fa-trash"></i>
                                                  </button>
                                              </form>
                                          </td>
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

  document.querySelectorAll(".sub-prevBtn").forEach(button => {
      button.addEventListener("click", () => {
          const content = button.closest(".tab-content");
          const subTabs = content.querySelectorAll(".sub-tab");
          const subTabContainer = content.querySelector(".sub-tab-container");

          if (activeIndex > 0) {
              activeIndex--;
              updateTabs(activeIndex);
              subTabContainer.scrollLeft -= subTabs[0].offsetWidth;
          }
      });
  });

  document.querySelectorAll(".sub-nextBtn").forEach(button => {
      button.addEventListener("click", () => {
          const content = button.closest(".tab-content");
          const subTabs = content.querySelectorAll(".sub-tab");
          const subTabContainer = content.querySelector(".sub-tab-container");

          if (activeIndex < subTabs.length - 1) {
              activeIndex++;
              updateTabs(activeIndex);
              subTabContainer.scrollLeft += subTabs[0].offsetWidth;
          }
      });
  });

  updateTabs(activeIndex);

  // Sub-tabs
  document.querySelectorAll(".tab-content").forEach(content => {
      const subTabs = content.querySelectorAll(".sub-tab");
      const subContents = content.querySelectorAll(".sub-tab-content");
      const subTabContainer = content.querySelector(".sub-tab-container");

      let subActiveIndex = 0;

      function updateSubTabs(index) {
          subTabs.forEach((subTab, i) => {
              if (i === index) {
                  subTab.classList.add("active");
                  subContents[i].classList.add("active");
              } else {
                  subTab.classList.remove("active");
                  subContents[i].classList.remove("active");
              }
          });
      }

      subTabs.forEach((subTab, index) => {
          subTab.addEventListener("click", () => {
              subActiveIndex = index;
              updateSubTabs(index);
          });
      });

      content.querySelector(".sub-prevBtn").addEventListener("click", () => {
          if (subActiveIndex > 0) {
              subActiveIndex--;
              updateSubTabs(subActiveIndex);
              subTabContainer.scrollLeft -= subTabs[0].offsetWidth;
          }
      });

      content.querySelector(".sub-nextBtn").addEventListener("click", () => {
          if (subActiveIndex < subTabs.length - 1) {
              subActiveIndex++;
              updateSubTabs(subActiveIndex);
              subTabContainer.scrollLeft += subTabs[0].offsetWidth;
          }
      });

      updateSubTabs(subActiveIndex);
  });
});

</script>
@endpush
