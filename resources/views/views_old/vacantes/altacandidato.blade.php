@include('layouts.header')
<body class="text-start">
      @include('layouts.menu')
    <div class="main-content">
      <div class="breadcrumb">
        <h1>Alta Candidatos</h1>
      </div>

      <div class="separator-breadcrumb border-top"></div>

    <form action="{{ route('guardar-candidato') }}" method="post" >
        @csrf

        <div class="row row-colaboradores">



            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Apellido Paterno:</label>
                    <input type="text" class="form-control" name="apellido_paterno" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Apellido Materno:</label>
                    <input type="text" class="form-control" name="apellido_materno" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Edad:</label>
                    <input type="text" class="form-control" name="edad" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Cv:</label>
                    <input type="file" class="form-control" name="cv" />
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




    @include('layouts.footer')
