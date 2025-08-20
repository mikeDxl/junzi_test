<style media="screen">
.white-content .form-control[disabled], .white-content .form-control[readonly], .white-content fieldset[disabled] .form-control {
  background: #fff;
  border-color: rgba(29, 37, 59, .3);
}
</style>

<section class="mt-4">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="row">

          <div class="col-md-12 text-center">
            @if($procesoinfo->estatus_proceso=='Rechazado')
            <h3 class="text-danger" style="text-decoration: line-through;">{{ candidato($candidato) }}</h3>
            @elseif($procesoinfo->estatus_proceso=='Aprobado')
            <h3 class="text-success">{{ candidato($candidato) }}</h3>
            @else
            <h3>{{ candidato($candidato) }}</h3>
            @endif
            <p>{{ $infodelcandidato->comentarios }}</p>
            <br>
            <p>Fuente: {{ $infodelcandidato->fuente }}</p>
          </div>
        </div>
        <nav class="nav nav-pills nav-fill ms-auto">
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa1 }}" aria-hidden="true"></i></span> <br> Curriculum</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa4 }}" aria-hidden="true"></i></span> <br> Referencias</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa5 }}" aria-hidden="true"></i></span> <br> Exámen <br> psicométrico</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa6 }}" aria-hidden="true"></i></span> <br> Documentación</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa7 }}" aria-hidden="true"></i></span> <br> Alta candidato</a>
        </nav>
      </div>
      <div class="card-body">
        <div class="tab d-none">
          @if($procesoinfo->curriculum)
          <iframe src="/storage/app/public/{{ $procesoinfo->curriculum }}#zoom=100&navpanes=0&view=FitH" width="100%" height="600"></iframe>

          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>

        <div class="tab d-none">
          @if($procesoinfo->estatus_entrevista=='aprobado')
            <div class="row">
              <div class="col-md-4 text-center">

                <p> <br> </p>
                @if(buscarburo($candidato , $vacante->id)!="")
                <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarburo($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Buró Laboral</a>
                <br>
                <form class="" action="{{ route('eliminar_referencia') }}" method="post">
                  @csrf
                  <input type="hidden" name="referencia" value="buro">
                  <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                  <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                  <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                  <button type="submit" class="btn btn-danger btn-link" name="button"> <i class="fa fa-trash"></i> </button>
                </form>


                @endif
              </div>
              <div class="col-md-4 text-center">

                <p> <br> </p>
                @if(buscarcarta($candidato , $vacante->id)!="")
                <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarcarta($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Carta</a>
                <br>
                <form class="" action="{{ route('eliminar_referencia') }}" method="post">
                  @csrf
                  <input type="hidden" name="referencia" value="carta">
                  <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                  <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                  <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                  <button type="submit" class="btn btn-danger btn-link" name="button"> <i class="fa fa-trash"></i> </button>
                </form>
                @endif

              </div>

              <div class="col-md-4 text-center">


                <p> <br> </p>
                @if(buscarcarta2($candidato , $vacante->id)!="")
                <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarcarta2($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Carta 2</a>
                <br>
                <form class="" action="{{ route('eliminar_referencia') }}" method="post">
                  @csrf
                  <input type="hidden" name="referencia" value="carta2">
                  <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                  <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                  <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                  <button type="submit" class="btn btn-danger btn-link" name="button"> <i class="fa fa-trash"></i> </button>
                </form>
                @endif

              </div>

            </div>

          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>

        <div class="tab d-none">
          @if($procesoinfo->estatus_entrevista=='aprobado')

            <div class="row justify-content-center">

              <div class="col-md-12 text-center">

                <p> <br> </p>

                <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarexamen($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Resultado</a>
                <br>


              </div>
              <?php
              $res=buscarresultados($candidato , $vacante->id);
               ?>
            </div>
          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>

        <div class="tab d-none">
          @if($procesoinfo->estatus_entrevista=='aprobado')
          <form class="" action="{{ route('validar_documentacion') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">

              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-3">
                    Identificación
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento1($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento1($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento1($candidato , $vacante->id)!="")
                    <select class="form-control" name="estatus_documento1" required>
                      @if(estatusDocumento1($candidato , $vacante->id))
                      <option value="{{ estatusDocumento1($candidato , $vacante->id) }}">{{ estatusDocumento1($candidato , $vacante->id) }}</option>
                      @endif
                      <option value="">Selecciona:</option>
                      <option value="Aprobado">Aprobado</option>
                      <option value="Rechazado">Rechazado</option>
                    </select>
                    @endif
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="comentariodoc1" placeholder="comentario" value="{{ comentarioDocumento1($candidato , $vacante->id) }}">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    Comprobante de domicilio
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento2($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento2($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento2($candidato , $vacante->id)!="")
                    <select class="form-control" name="estatus_documento2" required>
                      @if(estatusDocumento2($candidato , $vacante->id))
                      <option value="{{ estatusDocumento2($candidato , $vacante->id) }}">{{ estatusDocumento2($candidato , $vacante->id) }}</option>
                      @endif
                      <option value="">Selecciona:</option>
                      <option value="Aprobado">Aprobado</option>
                      <option value="Rechazado">Rechazado</option>
                    </select>
                    @endif
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="comentariodoc2" placeholder="comentario" value="{{ comentarioDocumento2($candidato , $vacante->id) }}">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    CURP
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento3($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento3($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento3($candidato , $vacante->id)!="")
                    <select class="form-control" name="estatus_documento3" required>
                      @if(estatusDocumento3($candidato , $vacante->id))
                      <option value="{{ estatusDocumento3($candidato , $vacante->id) }}">{{ estatusDocumento3($candidato , $vacante->id) }}</option>
                      @endif
                      <option value="">Selecciona:</option>
                      <option value="Aprobado">Aprobado</option>
                      <option value="Rechazado">Rechazado</option>
                    </select>
                    @endif
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="comentariodoc3" placeholder="comentario" value="{{ comentarioDocumento3($candidato , $vacante->id) }}">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    Acta de nacimiento
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento4($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento4($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento4($candidato , $vacante->id)!="")
                    <select class="form-control" name="estatus_documento4" required>
                      @if(estatusDocumento4($candidato , $vacante->id))
                      <option value="{{ estatusDocumento4($candidato , $vacante->id) }}">{{ estatusDocumento4($candidato , $vacante->id) }}</option>
                      @endif
                      <option value="">Selecciona:</option>
                      <option value="Aprobado">Aprobado</option>
                      <option value="Rechazado">Rechazado</option>
                    </select>
                    @endif
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="comentariodoc4" placeholder="comentario" value="{{ comentarioDocumento4($candidato , $vacante->id) }}">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    IMSS
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento5($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento5($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-3">
                    @if(buscardocumento5($candidato , $vacante->id)!="")
                    <select class="form-control" name="estatus_documento5" required>
                      @if(estatusDocumento5($candidato , $vacante->id))
                      <option value="{{ estatusDocumento5($candidato , $vacante->id) }}">{{ estatusDocumento5($candidato , $vacante->id) }}</option>
                      @endif
                      <option value="">Selecciona:</option>
                      <option value="Aprobado">Aprobado</option>
                      <option value="Rechazado">Rechazado</option>
                    </select>
                    @endif
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="comentariodoc5" placeholder="comentario" value="{{ comentarioDocumento5($candidato , $vacante->id) }}">
                  </div>
                </div>
              </div>

            </div>
            <div class="col-md-12 text-center">
              <br>
              <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
              <input type="hidden" name="proceso_id" value="{{ $procesoinfo }}">
              <input type="hidden" name="candidato_id" value="{{ $candidato }}">
              <br>
              <input type='submit' class='btn btn-info ' value='Validar Documentos' />
            </div>
          </form>
          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>

        <div class="tab d-none">
          @if($procesoinfo->estatus_entrevista=='aprobado')
          <form class="" action="{{ route('contratar_colaborador') }}" method="post">
            @csrf
            <p>Fecha Jefatura</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tim-icons icon-single-02"></i>
                </div>
              </div>
              <input type="date" min="{{ date('Y-m-d') }}" name="fecha_jefatura" class="form-control" placeholder="Fecha" readonly value="{{ fechajefatura($proc->candidato_id , $vacante->id) }}">
            </div>
            <p>Fecha alta:</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tim-icons icon-single-02"></i>
                </div>
              </div>
              <input type="date" min="{{ date('Y-m-d') }}" name="fecha_alta" class="form-control" placeholder="Fecha" value="{{ fechanomina($proc->candidato_id , $vacante->id) }}" required>
            </div>
            <p>Jefatura:</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tim-icons icon-single-02"></i>
                </div>
              </div>
            <input type="text" readonly class="form-control" name="jefe" value="{{ qcolab($vacante->jefe) }}">
            </div>
            <p> Puesto:</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tim-icons icon-single-02"></i>
                </div>
              </div>
            <input type="text" readonly class="form-control" name="puesto" value="{{ catalogopuesto($vacante->puesto_id) }}">
            </div>
            <p>Posición:</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tim-icons icon-single-02"></i>
                </div>
              </div>
              <input type="text" class="form-control" readonly  name="codigoorganigrama" value="{{ $vacante->codigo }}">
            </div>
            <input type="hidden" name="candidato_id" value="{{ $candidato }}">
            <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
            <input type="hidden" name="estatus" value="Contratado">

                <input type='submit' class='btn btn-success btn-fill btn-info btn-wd' name='finish' value='Alta de candidato' />

          </form>
          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>
      </div>
      <div class="card-footer text-end">
        <div class="text-center">
          <button type="button" id="back_button" style="display:none;" class="btn btn-link" onclick="back()">Anterior</button>
          <button type="button" id="next_button" style="display:none;" class="btn btn-info ms-auto" onclick="next()">Siguiente</button>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtén todos los elementos select de clase 'form-control' en la página
        var selectDesde = document.querySelectorAll('select[name="desde[]"]');
        var selectHasta = document.querySelectorAll('select[name="hasta[]"]');

        // Agrega un evento change a cada selectDesde
        selectDesde.forEach(function (element, index) {
            element.addEventListener("change", function () {
                // Obtén el valor seleccionado en el selectDesde
                var selectedDesde = element.value;

                // Actualiza las opciones disponibles en el selectHasta correspondiente
                actualizarOpcionesHasta(index, selectedDesde);
            });
        });

        // Función para actualizar las opciones en el selectHasta
        function actualizarOpcionesHasta(index, selectedDesde) {
            // Obtén el selectHasta correspondiente al index
            var selectHastaActual = selectHasta[index];

            // Elimina todas las opciones actuales
            selectHastaActual.innerHTML = '';

            // Agrega la opción predeterminada
            var optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.text = 'Seleccionar';
            selectHastaActual.appendChild(optionDefault);

            // Define las horas disponibles en función de la hora seleccionada en selectDesde
            var horasDisponibles = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30' , '18:00' , '18:30' , '19:00' , '19:30' , '20:00'];

            // Filtra las horas disponibles para aquellas que sean después de selectedDesde
            var horasFiltradas = horasDisponibles.filter(function (hora) {
                return hora > selectedDesde;
            });

            // Agrega las opciones actualizadas al selectHasta
            horasFiltradas.forEach(function (hora) {
                var option = document.createElement('option');
                option.value = hora;
                option.text = hora;
                selectHastaActual.appendChild(option);
            });
        }
    });
</script>
