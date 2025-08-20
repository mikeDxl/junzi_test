@extends('layouts.app', ['activePage' => 'Proceso Vacante', 'menuParent' => 'forms', 'titlePage' => __('Proceso Vacante')])

@section('content')

<style media="screen">
.nav-pills .nav-item .nav-link.active, .nav-pills .nav-item .nav-link.active:focus, .nav-pills .nav-item .nav-link.active:hover {
  background-color: #1d8cf8!important;
  color: #fff;
  box-shadow: 2px 2px 6px rgba(0,0,0,.4);
}


  .nav-listo{ background: green!important; color: #fff!important;}

  .star-rating, .rating-options {
       display: inline-block;
   }

   .star {
       font-size: 34px!important;
       color: gray;
       cursor: pointer;
   }

   .star:hover,
   .star.active {
       color: orange!important;
   }

   .rating-option {
     border:1px solid orange;
     border-radius: 25px;
     padding: 10px;
       cursor: pointer;
   }

   .rating-option:hover {
     border:1px solid orange;
     background: orange;
     border-radius: 25px;
     color: #f5f5f5!important;
     padding: 10px;
       cursor: pointer;
   }

   .rating-option.active {
     border:1px solid orange;
     background: orange;
     border-radius: 25px;
     color: #f5f5f5!important;
     padding: 10px;
       cursor: pointer;
   }

   input[type="radio"],
   input[type="radio"] + label {
       display: block;
   }

   .col-file{ border: 1px solid #ccc; margin: 5px; }



   </style>


<div class="content">
  <div class="row">
    <div class="col-md-8">
      <a href="/vacantes"> <button type="button" class="btn btn-link" name="button"> <i class="fa fa-arrow-left"> Regresar</i> </button> </a>
    </div>
    <div class="col-md-4 text-right">
      @if(buscarperfildePuesto($vacante->puesto_id))
      <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm" name="button">Ver perfil del puesto</button>
      @else
      <div class="alert">
        <p>No hay perfil de puesto para mostrar</p>
      </div>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="card-title">
        Proceso Vacante
      </h2>
      <h3>{{$vacante->area}}</h3>
      <h4>{{ nombre_puesto($vacante->puesto_id) }}</h4>
      <h6>Posición: {{  $vacante->codigo}}</h6>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">

    </div>
    <div class="col-md-4">
      @if(auth()->user()->rol=='Reclutamiento')
        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleAltaCandidato" class="btn btn-sm" name="button">Agregar candidato</button>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 ml-auto mr-auto">
      <div class="card card-subcategories card-plain">
        <div class="card-header">
          <h4 class="card-title text-center mt-5">Candidatos</h4>
          <br/>
        </div>
        @if(auth()->user()->perfil=='Jefatura')
          @if(count($procesos)<=0)
          <div class=" alert alert-danger text-center">
            <p>No hay candidatos</p>
          </div>
          @endif
        @endif
        <div class="card-body">
          @if(session('success'))
              <div id="success-alert" class="alert alert-success">
                  {{ session('success') }}
              </div>

              <script>
                  $(document).ready(function () {
                      // Desvanecer la alerta después de 5 segundos (5000 milisegundos)
                      setTimeout(function () {
                          $("#success-alert").fadeOut("slow");
                      }, 5000); // 5000 milisegundos = 5 segundos
                  });
              </script>
          @endif

          <ul class="nav nav-pills nav-pills-default nav-pills-icons justify-content-center">

            @foreach($procesos as $proc)
            <li class="nav-item">
              <a class="nav-link" id="candidato{{ $proc->candidato_id }}" data-toggle="tab" href="#candidatotab{{ $proc->candidato_id }}">
                <i class="tim-icons icon-user"></i> {{ candidatoiniciales($proc->candidato_id) }}
              </a>
            </li>
            @endforeach
          </ul>
          <div class="tab-content tab-space tab-subcategories">

            @foreach($procesos as $proc)
            <div class="tab-pane" id="candidatotab{{ $proc->candidato_id }}">
              <div class="row">
                <div class="col-md-12 mr-auto ml-auto">
                  <!--      Wizard container        -->
                  <div class="wizard-container">
                    <div class="card card-wizard" data-color="info" id="wizardProfile">

                        <!--        You can switch " data-color="info" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="card-header text-center">

                          <h2 style="text-transform:uppercase;">{{ candidato($proc->candidato_id) }}</h2>
                          <h5 class="description">Estatus: {{ $proc->estatus }}</h5>

                          <div class="wizard-navigation">
                            <div class="progress-with-circle">
                              <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
                            </div>
                            <ul>
                              <li class="nav-item">
                                <a class="nav-link" id="tab_paso1{{ $proc->candidato_id }}" href="#paso1{{ $proc->candidato_id }}" data-toggle="tab">
                                  <i class="tim-icons icon-single-02"></i>
                                  <p>Curriculum</p>
                                </a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" id="tab_paso2{{ $proc->candidato_id }}" href="#paso2{{ $proc->candidato_id }}" data-toggle="tab">
                                  <i class="tim-icons icon-single-02"></i>
                                  <p>Programar Entrevista</p>
                                </a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" id="tab_paso3{{ $proc->candidato_id }}" href="#paso3{{ $proc->candidato_id }}" data-toggle="tab">
                                  <i class="tim-icons icon-single-02"></i>
                                  <p>Resultado Entrevista</p>
                                </a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" id="tab_paso4{{ $proc->candidato_id }}" href="#paso4{{ $proc->candidato_id }}" data-toggle="tab">
                                  <i class="tim-icons icon-single-02"></i>
                                  <p>Referencias</p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="tab_paso5{{ $proc->candidato_id }}" href="#paso5{{ $proc->candidato_id }}" data-toggle="tab">
                                  <i class="tim-icons icon-single-02"></i>
                                  <p>Exámen psicométrico</p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="tab_paso6{{ $proc->candidato_id }}" href="#paso6{{ $proc->candidato_id }}" data-toggle="tab">
                                  <i class="tim-icons icon-single-02"></i>
                                  <p>Documentación</p>
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="card-body">

                          <div class="tab-content">

                              <div class="tab-pane" id="paso1{{ $proc->candidato_id }}"></div>

                              <div class="tab-pane" id="paso2{{ $proc->candidato_id }}"></div>

                              <div class="tab-pane" id="paso3{{ $proc->candidato_id }}"></div>

                              <div class="tab-pane" id="paso4{{ $proc->candidato_id }}"></div>

                              <div class="tab-pane" id="paso5{{ $proc->candidato_id }}"></div>

                              <div class="tab-pane" id="paso6{{ $proc->candidato_id }}"></div>

                              <div class="tab-pane" id="paso7{{ $proc->candidato_id }}"></div>

                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- wizard container -->
                </div>
              </div>
            </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 text-right">
              <iframe src="/storage/app/public/{{ buscarperfildePuesto($vacante->puesto_id) }}" width="100%" height="650"></iframe>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

<div class="modal fade" id="exampleAltaCandidato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 text-center">
              <h3>Alta de candidato</h3>
              <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('alta_candidato_rh') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" class="form-control" name="nombre" placeholder="Nombre" value=""> <br>
                </div>
                <div class="form-group">
                  <label for="">Apellido Paterno</label>
                  <input type="text" class="form-control" name="apellido_paterno" placeholder="Apellido Paterno" value=""> <br>
                </div>
                <div class="form-group">
                  <label for="">Apellido Materno</label>
                  <input type="text" class="form-control" name="apellido_materno" placeholder="Apellido Materno" value=""> <br>
                </div>
                <div class="input-group">
                  <label for="">Curriculum</label>
                  <br>
                  <input type="file" class="" name="curriculum" value="">
                </div>
                <div class="text-center">
                  <br>
                  <button type="submit" class="btn btn-info"> Subir candidato </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection

@push('js')

<script>
    $(document).ready(function () {
        // Obtén el valor del fragmento de la URL
        var url = window.location.href;
        var fragment = url.substring(url.lastIndexOf('#') + 1);

        // Separa el fragmento en la pestaña de candidato y la de proceso
        var fragments = fragment.split('-');
        var idCandidato = fragments[0];
        var idPaso = fragments[1];

        // Activa la pestaña del candidato
        $('a[href="#candidatotab' + idCandidato + '"]').tab('show');

        // Activa la pestaña de proceso deseada
        $('#candidatotab' + idCandidato + '-' + idPaso).tab('show');
    });
</script>



<script type="text/javascript">
  function mostrarDivFile(btnId , divId){
    document.getElementById(btnId).style.display='none';
    document.getElementById(divId).style.display='block';
  }
</script>

<script>
    function radioStar(clickedId, starClass) {
        // Obtén todos los elementos con la clase starClass
        var stars = document.querySelectorAll('.' + starClass);

        // Recorre todos los elementos y elimina la clase 'active'
        for (var i = 0; i < stars.length; i++) {
            stars[i].classList.remove('active');
        }

        // Agrega la clase 'active' al elemento que se hizo clic
        var clickedStar = document.getElementById(clickedId);
        clickedStar.classList.add('active');
    }
</script>

<script>
    function radioOption(clickedId, optionClass) {
        // Obtén todos los elementos con la clase optionClass
        var options = document.querySelectorAll('.' + optionClass);

        // Recorre todos los elementos y elimina la clase 'active'
        for (var i = 0; i < options.length; i++) {
            options[i].classList.remove('active');
        }

        // Agrega la clase 'active' al elemento que se hizo clic
        var clickedOption = document.getElementById(clickedId);
        clickedOption.classList.add('active');
    }
</script>
<script type="text/javascript">
  function mostarrRechazar(id){
    var id2=id+'boton';
    document.getElementById(id).style.display='block';
    document.getElementById(id2).style.display='none';
  }
</script>
<script>
        // Obtenemos todos los elementos con la clase "hora"
        const inputHoras = document.querySelectorAll('.hora');

        // Recorremos los elementos y aplicamos la configuración a cada uno
        inputHoras.forEach(inputHora => {
            inputHora.step = 1800;   // Paso de 30 minutos
            inputHora.min = '09:00'; // Valor mínimo
            inputHora.max = '17:30'; // Valor máximo
        });
    </script>
  <script>
    $(document).ready(function() {
      // Initialise the wizard
      demo.initNowUiWizard();
      setTimeout(function() {
        $('.card.card-wizard').addClass('active');
      }, 600);
    });
  </script>
@endpush
