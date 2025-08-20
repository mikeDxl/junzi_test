@extends('layouts.app', ['activePage' => 'Externos', 'menuParent' => 'forms', 'titlePage' => __('Externos')])

@section('content')

<style media="screen">
.tab-container {
  width: 100%;
}

.tabs {
  display: flex;
  margin-bottom: 10px;
}

.tab-button {
  flex: 1;
  padding: 10px;
  cursor: pointer;
  background-color: #f1f1f1;
  border: 1px solid #ccc;
  text-align: center;
}

.tab-button.active {
  background-color: #ddd;
  font-weight: bold;
}

.tab-content {
  display: none;
  border: 1px solid #ccc;
  padding: 10px;
  background-color: #fff;
}

.tab-content.active {
  display: block;
}

.custom-table {
  width: 100%;
  border-collapse: collapse;
}

.custom-table th,
.custom-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}

.custom-table th {
  background-color: #f9f9f9;
  font-weight: bold;
}

</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Colaboradres externos</h4>
            </div>
            <div class="card-body">

              <div class="row">
                <div class="col-12">
                  <!-- Mensaje de éxito -->
                   @if(session('success'))
                       <div class="alert alert-success">
                           {{ session('success') }}
                       </div>
                   @endif

                   <!-- Mensaje de error -->
                   @if(session('error'))
                       <div class="alert alert-danger">
                           {{ session('error') }}
                       </div>
                   @endif
                </div>
              </div>

              <div class="row">
                <div class="col-4 mb-3">
                  <a href="/colaboradores" class="btn btn-sm btn-link"> <i class="fa fa-chevron-left"></i> {{ __('Colaboradores') }}</a>
                </div>
                <div class="col-4" >


                </div>

                <div class="col-4 text-right mb-3">
                  <a href="/colaboradores/crear_externos" class="btn btn-sm btn-default">{{ __('Agregar') }}</a>
                </div>
              </div>



              <div class="tab-container">
                  <div class="tabs">
                      <button class="tab-button active" onclick="openTab(event, 'empresa')">Empresas</button>
                      <button class="tab-button" onclick="openTab(event, 'persona')">Personas</button>
                  </div>

                  <!-- Tab Empresas -->
                  <div id="empresa" class="tab-content active">
                      <table class="custom-table">
                          <thead>
                              <tr>
                                  <th>Razón Social</th>
                                  <th>Centro de costos</th>
                                  <th>Empresa</th>
                                  <th>Presupuesto</th>
                                  <th>Cantidad</th>
                                  <th>Estatus</th>
                                  <th>RFC</th>
                                  <th>Jefe</th>
                                  <th>Ingreso</th>
                                  <th>Opciones</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($externos->where('tipo', 'Empresa') as $ext)
                              <tr>
                                  <td>{{ empresa($ext->company_id) }}</td>
                                  <td>{{ nombrecc($ext->area) }}</td>
                                  <td>{{ $ext->empresa }}</td>
                                  <td>${{ number_format($ext->presupuesto,2) }}</td>
                                  <td>{{ $ext->cantidad }}</td>
                                  <td>
                                      <form action="{{ route('toggle_status_externo', $ext->id) }}" method="post" style="display:inline-block;">
                                          @csrf
                                          @method('PATCH')
                                          <button type="submit" class="btn btn-link {{ $ext->estatus == 'Activo' ? 'btn-danger' : 'btn-info' }}">
                                              <i class="fa {{ $ext->estatus == 'Activo' ? 'fa-eye' : 'fa-eye-slash' }}" aria-hidden="true"></i>
                                          </button>
                                      </form>
                                  </td>
                                  <td>{{ $ext->rfc }}</td>
                                  <td>{{ qcolab($ext->jefe) ?? '' }}</td>
                                  <td>{{ \Carbon\Carbon::parse($ext->ingreso)->format('Y-m-d') }}</td>
                                  <td>
                                      <a href="{{ route('edit_externo', $ext->id) }}" class="btn btn-link btn-sm">Editar</a>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>

                  <!-- Tab Personas -->
                  <div id="persona" class="tab-content">
                      <table class="custom-table">
                          <thead>
                              <tr>
                                  <th>Razón Social</th>
                                  <th>Centro de costos</th>
                                  <th>Empresa</th>
                                  <th>Presupuesto</th>
                                  <th>Cantidad</th>
                                  <th>Estatus</th>
                                  <th>RFC</th>
                                  <th>Jefe</th>
                                  <th>Ingreso</th>
                                  <th>Opciones</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($externos->where('tipo', 'Persona') as $ext)
                              <tr>
                                  <td>{{ empresa($ext->company_id) }}</td>
                                  <td>{{ nombrecc($ext->area) }}</td>
                                  <td>{{ $ext->empresa }}</td>
                                  <td>{{ $ext->presupuesto }}</td>
                                  <td>{{ $ext->cantidad }}</td>
                                  <td>
                                      <form action="{{ route('toggle_status_externo', $ext->id) }}" method="post" style="display:inline-block;">
                                          @csrf
                                          @method('PATCH')
                                          <button type="submit" class="btn btn-link">
                                              <i class="fa {{ $ext->estatus == 'Activo' ? 'fa-eye' : 'fa-eye-slash' }}" aria-hidden="true"></i>
                                          </button>
                                      </form>
                                  </td>
                                  <td>{{ $ext->rfc }}</td>
                                  <td>{{ qcolab($ext->jefe) ?? '' }}</td>
                                  <td>{{ \Carbon\Carbon::parse($ext->ingreso)->format('Y-m-d') }}</td>
                                  <td>
                                      <a href="{{ route('edit_externo', $ext->id) }}" class="btn btn-link btn-sm">Editar</a>
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

<script type="text/javascript">
function openTab(event, tabName) {
  var i, tabcontent, tabbuttons;

  // Ocultar todas las pestañas
  tabcontent = document.getElementsByClassName("tab-content");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
      tabcontent[i].classList.remove("active");
  }

  // Remover la clase "active" de todos los botones
  tabbuttons = document.getElementsByClassName("tab-button");
  for (i = 0; i < tabbuttons.length; i++) {
      tabbuttons[i].classList.remove("active");
  }

  // Mostrar la pestaña actual y añadir la clase "active" al botón que se presionó
  document.getElementById(tabName).style.display = "block";
  document.getElementById(tabName).classList.add("active");
  event.currentTarget.classList.add("active");
}

</script>
@endsection
