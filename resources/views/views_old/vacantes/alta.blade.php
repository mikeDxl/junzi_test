@include('layouts.header')
<body class="text-start">
      @include('layouts.menu')
    <div class="main-content">
      <div class="breadcrumb">
        <h1>Alta vacantes</h1>
      </div>

      <div class="separator-breadcrumb border-top"></div>

    <form action="{{ route('guardar-vacantes') }}" method="post" >
        @csrf

        <div class="row row-colaboradores">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputNombreEmpresa">Empresa:</label>
                    <select class="form-control" name="company_id" id="company_id" onchange="buscarDepartamentos();">
                      <option value="">Selecciona una empresa</option>
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
                    <input type="text" class="form-control" name="bruto" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Sueldo neto:</label>
                    <input type="text" class="form-control" name="neto" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Número de vacantes:</label>
                    <input type="text" class="form-control" name="numvacantes" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Area:</label>
                    <input type="text" class="form-control" name="area" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Jefe inmediato:</label>
                    <select class="form-control" name="jefe" id="colaboradores">

                    </select>
                </div>
            </div>



            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Zona de trabajo:</label>
                    <input type="text" class="form-control" name="zona" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Motivo de solicitu de vacante:</label>
                    <input type="text" class="form-control" name="motivo" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Horario de trabajo:</label>
                    <input type="text" class="form-control" name="horario" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Día de descanso:</label>
                    <input type="text" class="form-control" name="descanso" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Escolaridad:</label>
                    <input type="text" class="form-control" name="escolaridad" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Experiencia mínima:</label>
                    <input type="text" class="form-control" name="experiencia" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Género:</label>
                    <input type="text" class="form-control" name="genero" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Estado civil:</label>
                    <input type="text" class="form-control" name="civil" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Rango de edad:</label>
                    <input type="text" class="form-control" name="rangoedad" />
                </div>
            </div>




        </div>

        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Idioma:</label>
                  <input type="text" class="form-control" name="idioma" />
              </div>
          </div>

          <div class="col-md-3">
              <div class="form-group">
                  <label for="">% hablado:</label>
                  <input type="text" class="form-control" name="hablado" />
              </div>
          </div>

          <div class="col-md-3">
              <div class="form-group">
                  <label for="">% escrito:</label>
                  <input type="text" class="form-control" name="escrito" />
              </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Software:</label>
                  <input type="text" class="form-control" name="software1" />
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label for="">% de dominio:</label>
                  <input type="text" class="form-control" name="porcentajesw1" />
              </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Software:</label>
                  <input type="text" class="form-control" name="software2" />
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label for="">% de dominio:</label>
                  <input type="text" class="form-control" name="porcentajesw2" />
              </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Software:</label>
                  <input type="text" class="form-control" name="software3" />
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label for="">% de dominio:</label>
                  <input type="text" class="form-control" name="porcentajesw3" />
              </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Competencias técnicas / Conocimientos en:</label>
                  <textarea name="competencias" class="form-control" style="resize:none;"></textarea>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Principales actividades del puesto:</label>
                  <textarea name="principales" class="form-control" style="resize:none;"></textarea>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Rasgos de personalidad:</label>
                  <textarea name="rasgos" class="form-control" style="resize:none;"></textarea>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Observaciones:</label>
                  <textarea name="observaciones" class="form-control" style="resize:none;"></textarea>
              </div>
          </div>
        </div>



        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-primary" type="submit">
                    Guardar
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
