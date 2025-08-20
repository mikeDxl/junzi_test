@extends('layouts.app', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Crear Razón Social</h4>
              </div>
              <div class="card-body" style="height:100vh;">

                <div class="row">
                  <div class="col-md-6">
                    <div class="" id="categories-table">
                      <div class="card-body">
                        <form action="{{ route('crear_razones_sociales') }}" id="miFormulario" method="post" enctype="multipart/form-data">
                          @csrf
                          <label>Base de datos</label>
                          <div class="form-group">
                            <select class="form-control" name="idconexion" required>
                              <option value="">Selecciona una base de datos</option>
                              @foreach($conexiones as $conex)
                                <option value="{{ $conex->id }}">{{ $conex->name }}</option>
                              @endforeach
                            </select>
                          </div>


                          <div class="text-center">
                            <button type="submit" class="btn btn-info" id="submitButton" name="button">Crear</button>
                          </div>

                        </form>

                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">

                  </div>

                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Captura el formulario y el botón
        const formulario = document.getElementById('miFormulario');
        const submitButton = formulario.querySelector('button[type="submit"]');
        const originalText = submitButton.innerText;

        // Agrega un evento de envío al formulario
        formulario.addEventListener('submit', function (event) {
            // Evita que el formulario se envíe de inmediato
            event.preventDefault();

            // Cambia el texto del botón
            submitButton.innerText = 'Importando base de datos, por favor espere...';

            // Deshabilita el botón para evitar clics adicionales mientras se procesa
            submitButton.setAttribute('disabled', 'disabled');

            // Aquí puedes agregar la lógica para el proceso de importación
            // Por ejemplo, hacer una solicitud AJAX para importar la base de datos

            // Simulación de proceso con un retraso de 3 segundos (elimina esto en tu código real)
            setTimeout(function () {
                // Restaura el texto del botón y habilita el botón nuevamente
              //  submitButton.innerText = originalText;
              //  submitButton.removeAttribute('disabled');

                // Finalmente, envía el formulario manualmente
                formulario.submit();
            }, 3000); // 3 segundos de simulación de proceso
        });
    });
</script>

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
@endpush
