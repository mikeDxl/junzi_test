@include('layouts.header')
<body class="text-start">
      @include('layouts.menu')
    <div class="main-content">
      <div class="breadcrumb">
        <h1>Blank</h1>
        <ul>
          <li><a href="">Pages</a></li>
          <li>Blank</li>
        </ul>
      </div>

      <div class="separator-breadcrumb border-top"></div>

    <form action="{{ route('guardar-vacantes') }}" method="post" >
        @csrf

        <div class="row row-colaboradores">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputNombreEmpresa">Empresa:</label>
                    <select class="form-control" name="company_id" id="company_id" onchange="buscarDepartamentos();">
                      <option value="{{ $vacante->company_id }}"> {{ empresa($vacante->company_id) }} </option>
                      @foreach($empresas as $co)
                      <option value="{{ $co->id }}">{{ $co->nombre }}</option>
                      @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputDepartamento">Departamento:</label>
                    <select class=" form-control" id="departamentos" name="departamento" onchange="buscarPuestos();">
                      <option value="{{ $vacante->departamento }}">{{ depa($vacante->departamento , $vacante->company_id) }}</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputDepartamento">Puesto:</label>
                    <select class=" form-control" id="puestos" name="puesto" onchange="buscarColaboradores();">
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Sueldo bruto:</label>
                    <input type="text" class="form-control" name="bruto" value="{{ $vacante->bruto }}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Sueldo neto:</label>
                    <input type="text" class="form-control" name="neto" value="{{ $vacante->neto }}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Número de vacantes:</label>
                    <input type="text" class="form-control" name="numvacantes" value="{{ $vacante->numvacantes }}"/>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Area:</label>
                    <input type="text" class="form-control" name="area" value="{{ $vacante->area }}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Jefe inmediato:</label>
                    <select class="form-control" name="jefe" id="colaboradores" value="{{ $vacante->jefe }}">

                    </select>
                </div>
            </div>



            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Zona de trabajo:</label>
                    <input type="text" class="form-control" name="zona" value="{{ $vacante->zona }}"/>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Motivo de solicitu de vacante:</label>
                    <input type="text" class="form-control" name="motivo" value="{{ $vacante->motivo }}"/>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Horario de trabajo:</label>
                    <input type="text" class="form-control" name="horario" value="{{ $vacante->horario }}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Día de descanso:</label>
                    <input type="text" class="form-control" name="descanso" value="{{ $vacante->descanso }}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Escolaridad:</label>
                    <input type="text" class="form-control" name="escolaridad" value="{{ $vacante->escolaridad }}"/>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Experiencia mínima:</label>
                    <input type="text" class="form-control" name="experiencia" value="{{ $vacante->experiencia }}"/>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Género:</label>
                    <input type="text" class="form-control" name="genero" value="{{ $vacante->genero }}"/>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Estado civil:</label>
                    <input type="text" class="form-control" name="civil" value="{{ $vacante->civil }}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Rango de edad:</label>
                    <input type="text" class="form-control" name="rangoedad" value="{{ $vacante->rangoedad }}"/>
                </div>
            </div>




        </div>

        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Idioma:</label>
                  <input type="text" class="form-control" name="idioma" value="{{ $vacante->idioma }}"/>
              </div>
          </div>

          <div class="col-md-3">
              <div class="form-group">
                  <label for="">% hablado:</label>
                  <input type="text" class="form-control" name="hablado" value="{{ $vacante->hablado }}"/>
              </div>
          </div>

          <div class="col-md-3">
              <div class="form-group">
                  <label for="">% escrito:</label>
                  <input type="text" class="form-control" name="escrito" value="{{ $vacante->escrito }}"/>
              </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Software:</label>
                  <input type="text" class="form-control" name="software1" value="{{ $vacante->software1 }}"/>
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label for="">% de dominio:</label>
                  <input type="text" class="form-control" name="porcentajesw1" value="{{ $vacante->porcentajesw1 }}"/>
              </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Software:</label>
                  <input type="text" class="form-control" name="software2" value="{{ $vacante->software2 }}"/>
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label for="">% de dominio:</label>
                  <input type="text" class="form-control" name="porcentajesw2" value="{{ $vacante->porcentajesw2 }}"/>
              </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Software:</label>
                  <input type="text" class="form-control" name="software3" value="{{ $vacante->software3 }}"/>
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label for="">% de dominio:</label>
                  <input type="text" class="form-control" name="porcentajesw3" value="{{ $vacante->porcentajesw3 }}"/>
              </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Competencias técnicas / Conocimientos en:</label>
                  <textarea name="competencias" class="form-control" style="resize:none;">{{ $vacante->competencias }}</textarea>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Principales actividades del puesto:</label>
                  <textarea name="principales" class="form-control" style="resize:none;">{{ $vacante->principales }}</textarea>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Rasgos de personalidad:</label>
                  <textarea name="rasgos" class="form-control" style="resize:none;">{{ $vacante->rasgos }}</textarea>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Observaciones:</label>
                  <textarea name="observaciones" class="form-control" style="resize:none;">{{ $vacante->observaciones }}</textarea>
              </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Estatus:</label>
                  <select class="form-control" name="estatus">
                    <option value="{{ $vacante->estatus }}">{{ $vacante->estatus }}</option>
                    <optgroup label="estatus">
                      <option value="activa">activa</option>
                      <option value="inactiva">inactiva</option>
                    </optgroup>
                  </select>
              </div>
          </div>
        </div>


        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-primary" type="submit">
                    Actualizar
                </button>
            </div>
        </div>
    </form>



    <hr>
    <form class="" action="{{ route('eliminar-vacante') }}" method="post">
      @csrf
      <input type="hidden" name="idvacante" value="{{ $vacante->id }}">
      <div class="row">
          <div class="col-md-12 text-center">
              <button class="btn btn-danger" type="submit">
                  Eliminar
              </button>
          </div>
      </div>
    </form>



    <script type="text/javascript">
    function buscarDepartamentos(){

      console.log('departamentos');
      var token = '{{csrf_token()}}';
      var empresa = document.getElementById('company_id').value;
      var data={_token:token , empresa:empresa };
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type    : 'POST',
          url     :'{{ route('buscarDepartamentos') }}',
          data    : data,
          datatype: 'html',
          encode  : true,
          success: function (response) {
            document.getElementById('departamentos').innerHTML=response;
            console.log(response);
          },
          error: function(jqXHR, textStatus, errorThrown){

          }
      });

    }


    function buscarPuestos(){
      var token = '{{csrf_token()}}';
      var empresa = document.getElementById('company_id').value;
      var data={_token:token , empresa:empresa };
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type    : 'POST',
          url     :'{{ route('buscarPuestos') }}',
          data    : data,
          datatype: 'html',
          encode  : true,
          success: function (response) {
            document.getElementById('puestos').innerHTML=response;
          },
          error: function(jqXHR, textStatus, errorThrown){

          }
      });

    }


    function buscarColaboradores(){
      var token = '{{csrf_token()}}';
      var empresa = document.getElementById('company_id').value;
      var data={_token:token , empresa:empresa };
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type    : 'POST',
          url     :'{{ route('buscarColaboradores') }}',
          data    : data,
          datatype: 'html',
          encode  : true,
          success: function (response) {
            document.getElementById('colaboradores').innerHTML=response;
          },
          error: function(jqXHR, textStatus, errorThrown){

          }
      });

    }
    </script>

    @include('layouts.footer')
