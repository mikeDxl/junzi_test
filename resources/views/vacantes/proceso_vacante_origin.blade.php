@extends('layouts.app', ['activePage' => 'Proceso Vacante', 'menuParent' => 'forms', 'titlePage' => __('Proceso Vacante')])

@section('content')

<?php
if (isset($_GET["can"]) && isset($_GET["paso"])) {
    $can = $_GET["can"];
    $paso = $_GET["paso"];
} else {
    $can = '0';
    $paso = '1';
}
?>


<input type="hidden" id="can" value="candidato<?php echo $can; ?>">
<input type="hidden" id="paso" value="tab_paso<?php echo $can; ?>-<?php echo $paso; ?>">
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
        <a href="#" class="text-danger"> <i class="fa fa-alert"></i>  No hay perfil de puesto para mostrar </a>
      </div>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <table>
        <tr>
          <td>Proceso Vacante</td>
          <td>{{$vacante->area}}</td>
          <td>{{ nombre_puesto($vacante->puesto_id) }}</td>
          <td>Posición: {{  $vacante->codigo}}</td>
        </tr>
      </table>
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
            <?php $navlinkactive=""; ?>
            @foreach($procesos as $proc)
              @if($can==$proc->candidato_id)
              <?php $navlinkactive=' active '; ?>
              @else
              <?php $navlinkactive=''; ?>
              @endif
              <li class="nav-item">
                <a class="nav-link {{ $navlinkactive }}" id="candidato{{ $proc->candidato_id }}" data-toggle="tab" href="#candidatotab{{ $proc->candidato_id }}">
                  <i class="tim-icons icon-user"></i> {{ candidatoiniciales($proc->candidato_id) }}
                </a>
              </li>
            @endforeach
          </ul>
          <div class="tab-content tab-space tab-subcategories">
            <?php $tabactive=''; ?>
            @foreach($procesos as $proc)
              @if($can==$proc->candidato_id)
              <?php $tabactive=' active show '; ?>
              @else
              <?php $tabactive=''; ?>
              @endif
              <div class="tab-pane {{ $tabactive }}" id="candidatotab{{ $proc->candidato_id }}">
              <div class="row">
                <div class="col-md-12 mr-auto ml-auto">

                  <!--      Wizard container        -->
                  <div class="wizard-container">
                    <div class="card card-wizard" data-color="info" id="wizardProfile">

                        <!--        You can switch " data-color="info" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="card-header text-center">

                          <h2 style="text-transform:uppercase;">{{ candidato($proc->candidato_id) }}</h2>
                          <h5 class="description">Estatus: {{ $proc->estatus }}</h5>
                          <?php

                          $navactivo="";

                          $navlistocv="";

                          $navlistoentrevista="";

                          $navlistoreferencias="";

                          $navlistoexamen="";

                          $navlistodocumentacion="";

                           ?>
                          <div class="wizard-navigation">
                            <div class="progress-with-circle">
                              <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
                            </div>
                            <ul>

                              <!-- Proceso de Reclutamiento -->
                              @if(auth()->user()->rol=='Reclutamiento')



                                <li class="nav-item">
                                  <a class="nav-link" id="tab_paso{{ $proc->candidato_id }}-1" href="#paso{{ $proc->candidato_id }}-1" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Curriculum</p>
                                  </a>
                                </li>



                                <li class="nav-item">
                                  <a class="nav-link" id="tab_paso{{ $proc->candidato_id }}-2" href="#paso{{ $proc->candidato_id }}-2" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Programar Entrevista</p>
                                  </a>
                                </li>

                                <li class="nav-item">
                                  <a class="nav-link" id="tab_paso{{ $proc->candidato_id }}-3" href="#paso{{ $proc->candidato_id }}-3" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Resultado Entrevista</p>
                                  </a>
                                </li>

                                @if(buscarestatus($proc->candidato_id , $vacante_id)=='aprobado')

                                  <li class="nav-item">
                                    <a class="nav-link" id="tab_paso{{ $proc->candidato_id }}-4" href="#paso{{ $proc->candidato_id }}-4" data-toggle="tab">
                                      <i class="tim-icons icon-single-02"></i>
                                      <p>Referencias</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="tab_paso{{ $proc->candidato_id }}-5" href="#paso{{ $proc->candidato_id }}-5" data-toggle="tab">
                                      <i class="tim-icons icon-single-02"></i>
                                      <p>Exámen psicométrico</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="tab_paso{{ $proc->candidato_id }}-6" href="#paso{{ $proc->candidato_id }}-6" data-toggle="tab">
                                      <i class="tim-icons icon-single-02"></i>
                                      <p>Documentación</p>
                                    </a>
                                  </li>

                                @endif

                             @endif

                              @if(auth()->user()->perfil=='Jefatura')
                                <li class="nav-item">
                                  <a class="nav-link {{ $navlistocv }}" id="tab_paso1{{ $proc->candidato_id }}" href="#paso{{$proc->candidato_id }}-1" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Curriculum</p>
                                  </a>
                                </li>


                                <li class="nav-item">
                                  <a class="nav-link {{ $navlistoentrevista }}" id="tab_paso2{{ $proc->candidato_id }}" href="#paso{{$proc->candidato_id }}-2" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Programar Entrevista</p>
                                  </a>
                                </li>

                                <li class="nav-item">
                                  <a class="nav-link {{ $navlistoentrevista }}" id="tab_paso3{{ $proc->candidato_id }}" href="#paso{{$proc->candidato_id }}-3" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Resultado Entrevista</p>
                                  </a>
                                </li>

                                @if(buscarestatus($proc->candidato_id , $vacante_id)=='aprobado')

                                <li class="nav-item">
                                  <a class="nav-link" id="tab_paso4{{ $proc->candidato_id }}" href="#paso{{$proc->candidato_id }}-4" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Referencias</p>
                                  </a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="tab_paso5{{ $proc->candidato_id }}" href="#paso{{$proc->candidato_id }}-5" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Exámen psicométrico</p>
                                  </a>
                                </li>

                                <li class="nav-item">
                                  <a class="nav-link" id="tab_paso6{{ $proc->candidato_id }}" href="#paso{{$proc->candidato_id }}-6" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Documentación</p>
                                  </a>
                                </li>

                                @endif

                              @endif


                              @if(buscarestatus($proc->candidato_id , $vacante_id)=='aprobado')
                                @if(auth()->user()->rol=='Nómina')
                                <li class="nav-item">
                                  <a class="nav-link" id="tab_paso7{{ $proc->candidato_id }}" href="#paso{{$proc->candidato_id }}-7" data-toggle="tab">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>Programar alta</p>
                                  </a>
                                </li>
                                @endif
                              @endif

                              <!-- Fin Proceso Nómina -->
                            </ul>
                          </div>
                        </div>
                        <div class="card-body">

                          <div class="tab-content">
                            <!-- Reclutamiento -->
                            @if(auth()->user()->rol=='Reclutamiento')

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-1">
                                <!--  subir curriculum  -->
                                <?php

                                $estilo_file_cv="display:none;";
                                if(buscarcv($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_cv="display:block;";
                                }else {
                                  $estilo_file_cv="display:none;";
                                }

                                 ?>
                                <h5 class="info-text"> Curriculum</h5>
                                <div class="row">
                                  <div class="col-md-12">
                                    @if(auth()->user()->rol=='Reclutamiento')
                                    <div class="text-center">
                                      <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_cv{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_cv{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                    </div>
                                    @endif
                                    <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('vacantes_subircv') }}" method="post" enctype="multipart/form-data">
                                      @csrf
                                      <div class="row justify-content-center">
                                        <div class="col-lg-10 text-center">
                                          <div class="fileinput fileinput-new text-center" id="div_cambiar_file_cv{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_cv }}">
                                            <div class="fileinput-new thumbnail">
                                              <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail">

                                            </div>

                                            <div>
                                              <span class="btn btn-info btn-sm btn-simple btn-file">
                                                <span class="fileinput-new">Buscar CV</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="cv" />
                                              </span>
                                              <a class="btn btn-danger btn-sm btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                              <button type="submit" class="fileinput-exists btn btn-sm" name="button">Subir</button>
                                              <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                              <input type="hidden" name="proceso_id" value="{{ $proc->id }}">
                                              <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="text-center">
                                      @if(buscarcv($proc->candidato_id , $vacante_id))
                                      <iframe src="/storage/app/public/{{ buscarcv($proc->candidato_id , $vacante_id) }}" width="100%" height="600"></iframe>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-2">
                                  <!--  Ver fechas que puso jefatura  -->
                                  <?php

                                  $fechas1=explode(',',buscarfechas1($proc->candidato_id , $vacante->id));
                                  $desde1=explode(',',buscardesde1($proc->candidato_id , $vacante->id));
                                  $hasta1=explode(',',buscarhasta1($proc->candidato_id , $vacante->id));


                                   ?>
                                   <?php

                                     $div_fechas_progrmadas="display:block;";

                                     if (buscarFechaProgramada($proc->candidato_id , $vacante->id)=='Fechas programadas') {
                                       $div_fechas_progrmadas="display:none;";
                                     }else {
                                       $div_fechas_progrmadas="display:block;";
                                     }
                                    ?>

                                  @if(buscarFechaProgramada($proc->candidato_id , $vacante->id)=='Fechas programadas')
                                    <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-success">
                                        <p>La fecha para entrevista es: {{ buscarFechaEntrevista($proc->candidato_id , $vacante->id) }}</p>
                                      </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                      <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_fechas_programadas2_{{ $vacante->id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_fechas_programadas{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                    </div>
                                  </div>
                                  @endif

                                  @if(buscarFechaPropuesta($proc->candidato_id , $vacante->id)=='Fechas asignadas')
                                    <div class="row" id="div_fechas_programadas2_{{ $vacante->id }}_{{ $proc->candidato_id }}" style="{{ $div_fechas_progrmadas }}">
                                    <div class="col-md-12">
                                      <p>Selecciona una fecha para programar la entrevista con {{ qcolab($vacante->jefe) }}</p>
                                      <br>
                                      <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('programar_fechas_entrevista') }}" method="post">
                                            @csrf
                                            @for ($i = 0; $i < count($fechas1); $i++)
                                                <div class="row">
                                                    <div class="col-2">

                                                    </div>
                                                    <div class="col-1">
                                                        <input type="radio"  name="horario" value="{{ $i }}">
                                                    </div>
                                                    <div class="col-2">
                                                        <p>{{ $fechas1[$i] ?? '' }}</p>
                                                        <input type="hidden" name="fecha[]" value="{{ $fechas1[$i] }}">
                                                        <input type="hidden" name="hora[]" value="{{ $desde1[$i] }}">
                                                    </div>
                                                    <div class="col-2">
                                                        <p>{{ $desde1[$i] ?? '' }} - {{ $hasta1[$i] ?? '' }}</p>
                                                    </div>
                                                    <div class="col-2">
                                                      <input type="time" min="{{ $desde1[$i] ?? '' }}" max="{{ $hasta1[$i] ?? '' }}" class="form-control" name="nuevahora" value="{{ $desde1[$i] ?? '' }}">
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>


                                            @endfor
                                            <div class="row" style="margin-top:50px;">
                                                <div class="col-sm-12">
                                                    <div class="input-group">
                                                        <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                                        <input type="hidden" name="proceso_id" value="{{ $proc->id }}">
                                                        <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <br>
                                                    <button type="submit" class="btn btn-info" name="button">Enviar a Jefatura</button>
                                                </div>
                                            </div>
                                       </form>

                                    </div>
                                  </div>
                                  @else
                                    <div class="row">
                                    <div class="col-md-12">
                                      <div class="alert alert-danger">
                                      {{ buscarFechaPropuesta($proc->candidato_id , $vacante->id) }}
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-3">
                                @if(buscarestatus($proc->candidato_id , $vacante_id))
                                  @if(buscarestatus($proc->candidato_id , $vacante_id)=='aprobado')
                                  <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-success" style="text-transform:uppercase;">
                                        {{ buscarestatus($proc->candidato_id , $vacante_id) }}
                                      </div>
                                    </div>
                                  </div>
                                  @elseif(buscarestatus($proc->candidato_id , $vacante_id)=='rechazado')
                                  <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-danger" style="text-transform:uppercase;">
                                        {{ buscarestatus($proc->candidato_id , $vacante_id) }}
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                @else
                                <div class="row">
                                  <div class="col-md-12 text-center">
                                    <div class="alert alert-danger" style="text-transform:uppercase;">
                                      Pendiente la respuesta de la entrevista
                                    </div>
                                  </div>
                                </div>
                                @endif
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-4">
                                  <!--  Capturar Referencias  -->

                                    <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('subir_referencias') }}" method="post" enctype="multipart/form-data">
                                      @csrf
                                      <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                          <h5 class="info-text"> Referencias laborales </h5>
                                        </div>
                                      </div>
                                      <?php
                                      $estilo_file_buro="display:none;";
                                      if(buscarburo($proc->candidato_id , $vacante_id)==""){
                                          $estilo_file_buro="display:block;";
                                      }else {
                                        $estilo_file_buro="display:none;";
                                      }

                                      $estilo_file_carta="display:none;";
                                      if(buscarcarta($proc->candidato_id , $vacante_id)==""){
                                          $estilo_file_carta="display:block;";
                                      }else {
                                        $estilo_file_carta="display:none;";
                                      }

                                       ?>
                                      <div class="row justify-content-center">
                                        <div class="col-md-6 text-center">
                                          @if(auth()->user()->rol=='Reclutamiento')

                                            <div class="fileinput fileinput-new text-center" id="div_cambiar_file_buro{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_buro }}">
                                              <div class="fileinput-new thumbnail">
                                                <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                              </div>
                                              <div class="fileinput-preview fileinput-exists thumbnail">

                                              </div>

                                              <div>
                                                <span class="btn btn-info btn-sm btn-simple btn-file">
                                                  <span class="fileinput-new">Buró laboral</span>
                                                  <span class="fileinput-exists">Cambiar</span>
                                                  <input type="file" name="buro" />
                                                </span>
                                                <a class="btn btn-danger btn-sm btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>

                                              </div>
                                            </div>

                                          @endif
                                          <p> <br> </p>
                                          @if(buscarburo($proc->candidato_id , $vacante_id)!="")
                                          <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarburo($proc->candidato_id , $vacante_id) }}" class="btn btn-primary">Descargar Buró Laboral</a>
                                          <br>
                                            @if(auth()->user()->rol=='Reclutamiento')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_buro{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_buro{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                            @endif
                                          @endif
                                        </div>
                                        <div class="col-md-6 text-center">
                                          @if(auth()->user()->rol=='Reclutamiento')

                                            <div class="fileinput fileinput-new text-center" id="div_cambiar_file_carta{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_carta }}">
                                              <div class="fileinput-new thumbnail">
                                                <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                              </div>
                                              <div class="fileinput-preview fileinput-exists thumbnail">

                                              </div>

                                              <div>
                                                <span class="btn btn-info btn-sm btn-simple btn-file">
                                                  <span class="fileinput-new">Carta de recomendación</span>
                                                  <span class="fileinput-exists">Cambiar</span>
                                                  <input type="file" name="carta" />
                                                </span>
                                                <a class="btn btn-danger btn-sm btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>

                                              </div>
                                            </div>
                                          @endif
                                          <p> <br> </p>
                                          @if(buscarcarta($proc->candidato_id , $vacante_id)!="")
                                          <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarcarta($proc->candidato_id , $vacante_id) }}" class="btn btn-primary">Descargar Carta</a>
                                          <br>
                                            @if(auth()->user()->rol=='Reclutamiento')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_carta{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_carta{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                            @endif
                                          @endif
                                        </div>
                                      </div>

                                      <div class="row justify-content-center">

                                        <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                        <input type="hidden" name="proceso_id" value="{{ $proc->id }}">
                                        <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                        <br>
                                        <br>
                                        <button type="submit" class="fileinput-exists btn btn-info" name="button">Subir referencias</button>
                                      </div>
                                    </form>
                                </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-5">
                                <!--  Exámen psicométrico  -->
                                <?php
                                $estilo_file_examen="display:none;";
                                if(buscarexamen($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_examen="display:block;";
                                }else {
                                  $estilo_file_examen="display:none;";
                                }
                                 ?>
                                @if(auth()->user()->rol=='Reclutamiento')
                                <div class="row">
                                  <div class="col-md-12">
                                    <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('examen') }}" method="post" enctype="multipart/form-data">
                                      @csrf
                                      <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                          <h5 class="info-text"> Exámen psicométrico </h5>
                                        </div>

                                        <div class="col-sm-5">
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                            <input type="hidden" name="proceso_id" value="{{ $proc->id }}">
                                            <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                            <input type="text" name="resultados"  class="form-control" placeholder="Resultado" value="{{ buscarresultados($proc->candidato_id , $vacante->id) ?? '' }}">
                                          </div>
                                        </div>

                                        <div class="col-md-12 text-center">
                                          <div class="fileinput fileinput-new text-center" id="div_cambiar_file_examen{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_examen }}">
                                            <div class="fileinput-new thumbnail">
                                              <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail">

                                            </div>

                                            <div>
                                              <span class="btn btn-info btn-sm btn-simple btn-file">
                                                <span class="fileinput-new">Exámen psicométrico</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="examenfoto" />
                                              </span>
                                              <a class="btn btn-danger btn-sm btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>

                                            </div>
                                          </div>
                                          <p> <br> </p>
                                          @if(buscarexamen($proc->candidato_id , $vacante_id)!="")
                                          <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarexamen($proc->candidato_id , $vacante_id) }}" class="btn btn-primary">Descargar Resultado</a>
                                          <br>
                                            @if(auth()->user()->rol=='Reclutamiento')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_examen{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_examen{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                            @endif
                                          @endif
                                        </div>
                                        <?php
                                        $res=buscarresultados($proc->candidato_id , $vacante->id);
                                         ?>
                                        @if($res<=69 && $res!="")
                                        <div class="col-md-12 text-center">
                                          <div class="" id="vacrecex_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                            <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('rechazar_candidato') }}" method="post">
                                              @csrf
                                              <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                              <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                                              <input type="hidden" name="estatus" value="Aprobado">
                                              <p>¿QUÉ TE PARECIO EL PERFIL DEL CANDIDATO?</p>
                                              <div class="star-rating">
                                                  <label id="label_star_6_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="1" id="radio_star_6_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                                  <label id="label_star_7_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="2" id="radio_star_7_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                                  <label id="label_star_8_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="3" id="radio_star_8_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                                  <label id="label_star_9_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="4" id="radio_star_9_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                                  <label id="label_star_10_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="5" id="radio_star_10_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                              </div>
                                              <p> <br> </p>
                                              <div class="rating-options">
                                                <div class="rating-options">
                                                  <label id="label_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">NO CUMPLE CON EL MÍNIMO APROBATORIO<input type="radio" name="idoneidad" value="No Cumple" id="radio_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                                  <label id="label_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">OTRA OPCIÓN<input type="radio" name="idoneidad" value="Calificación muy Baja" id="radio_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                                </div>
                                              </div>
                                              <p> <br> </p>
                                              <button type="submit" class="btn btn-sm btn-danger" name="button">Rechazar candidato</button>
                                            </form>
                                          </div>

                                        </div>
                                        @endif



                                        <div class="col-md-12 text-center">
                                          <p><br></p>
                                          <button type="submit" class="fileinput-exists btn btn-info" name="button">Subir resultados</button>
                                        </div>


                                      </div>
                                    </form>
                                  </div>
                                </div>
                                @else
                                <div class="row">
                                  <div class="col-md-12 text-center">
                                    <div class="alert alert-success">
                                      {{ buscarresultados($proc->candidato_id , $vacante_id) }}
                                    </div>
                                  </div>
                                </div>
                                @endif
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-6">
                                <!--  subir documentos  -->
                                <?php
                                $estilo_file_documento1="display:none;";
                                if(buscardocumento1($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_documento1="display:block;";
                                }else {
                                  $estilo_file_documento1="display:none;";
                                }

                                $estilo_file_documento2="display:none;";
                                if(buscardocumento2($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_documento2="display:block;";
                                }else {
                                  $estilo_file_documento2="display:none;";
                                }

                                $estilo_file_documento3="display:none;";
                                if(buscardocumento3($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_documento3="display:block;";
                                }else {
                                  $estilo_file_documento3="display:none;";
                                }

                                $estilo_file_documento4="display:none;";
                                if(buscardocumento4($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_documento4="display:block;";
                                }else {
                                  $estilo_file_documento4="display:none;";
                                }

                                $estilo_file_documento5="display:none;";
                                if(buscardocumento5($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_documento5="display:block;";
                                }else {
                                  $estilo_file_documento5="display:none;";
                                }

                                 ?>
                                <div class="row">
                                  <div class="col-md-12">
                                    <form class="" action="{{ route('documentacion') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row justify-content-center">
                                      <div class="col-sm-12">
                                        <h5 class="info-text"> Documentación </h5>
                                      </div>


                                      <div class="col-lg-5 text-center col-file">
                                        <h4>Identificación</h4>
                                        @if(buscardocumento1($proc->candidato_id , $vacante->id)!="")
                                        <br>
                                        @if(estatusDocumento1($proc->candidato_id , $vacante->id))
                                          @if(estatusDocumento1($proc->candidato_id , $vacante->id)=='Aprobado')
                                          <div class="alert alert-sm alert-success">{{ estatusDocumento1($proc->candidato_id , $vacante->id) }}</div>
                                          @elseif(estatusDocumento1($proc->candidato_id , $vacante->id)=='Rechazado')
                                          <div class="alert alert-sm alert-danger">{{ estatusDocumento1($proc->candidato_id , $vacante->id) }}</div>
                                          @endif
                                        @endif
                                        <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento1($proc->candidato_id , $vacante->id) }}" > Descargar Identificación </a>
                                        <br>
                                          @if(auth()->user()->rol=='Reclutamiento')
                                          <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento1{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_documento1{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                          @endif
                                        @endif

                                        <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento1{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_documento1 }}">
                                          <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                          </div>
                                          <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                          <div>
                                            <span class="btn btn-info btn-simple btn-file">
                                              <span class="fileinput-new">Subir Identificación</span>
                                              <span class="fileinput-exists">Cambiar</span>
                                              <input type="file" name="documento1" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Borrar</a>
                                          </div>
                                        </div>
                                        <br>
                                      </div>


                                      <div class="col-lg-5 text-center col-file">
                                        <h4>Comprobante de domicilio</h4>
                                        @if(buscardocumento2($proc->candidato_id , $vacante->id)!="")
                                        <br>
                                        @if(estatusDocumento2($proc->candidato_id , $vacante->id))
                                          @if(estatusDocumento2($proc->candidato_id , $vacante->id)=='Aprobado')
                                          <div class="alert alert-sm alert-success">{{ estatusDocumento2($proc->candidato_id , $vacante->id) }}</div>
                                          @elseif(estatusDocumento2($proc->candidato_id , $vacante->id)=='Rechazado')
                                          <div class="alert alert-sm alert-danger">{{ estatusDocumento2($proc->candidato_id , $vacante->id) }}</div>
                                          @endif
                                        @endif
                                        <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento2($proc->candidato_id , $vacante->id) }}" > Descargar Comprobante </a>

                                        <br>
                                          @if(auth()->user()->rol=='Reclutamiento')
                                          <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento2{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_documento2{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                          @endif
                                        @endif
                                        <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento2{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_documento2 }}">
                                          <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                          </div>
                                          <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                          <div>
                                            <span class="btn btn-info btn-simple btn-file">
                                              <span class="fileinput-new">Subir Comprobante de domicilio</span>
                                              <span class="fileinput-exists">Cambiar</span>
                                              <input type="file" name="documento2" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Borrar</a>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="col-lg-5 text-center col-file">
                                        <h4>CURP</h4>
                                        @if(buscardocumento3($proc->candidato_id , $vacante->id)!="")
                                        <br>
                                        @if(estatusDocumento3($proc->candidato_id , $vacante->id))
                                          @if(estatusDocumento3($proc->candidato_id , $vacante->id)=='Aprobado')
                                          <div class="alert alert-sm alert-success">{{ estatusDocumento3($proc->candidato_id , $vacante->id) }}</div>
                                          @elseif(estatusDocumento3($proc->candidato_id , $vacante->id)=='Rechazado')
                                          <div class="alert alert-sm alert-danger">{{ estatusDocumento3($proc->candidato_id , $vacante->id) }}</div>
                                          @endif
                                        @endif
                                        <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento3($proc->candidato_id , $vacante->id) }}" > Descargar CURP </a>
                                        <br>
                                          @if(auth()->user()->rol=='Reclutamiento')
                                          <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento3{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_documento3{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                          @endif
                                        @endif
                                        <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento3{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_documento3 }}">
                                          <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                          </div>
                                          <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                          <div>
                                            <span class="btn btn-info btn-simple btn-file">
                                              <span class="fileinput-new">Subir CURP</span>
                                              <span class="fileinput-exists">Cambiar</span>
                                              <input type="file" name="documento3" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Borrar</a>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="col-lg-5 text-center col-file">
                                        <h4>Acta de nacimiento</h4>
                                        @if(buscardocumento4($proc->candidato_id , $vacante->id)!="")
                                        <br>
                                        @if(estatusDocumento4($proc->candidato_id , $vacante->id))
                                          @if(estatusDocumento4($proc->candidato_id , $vacante->id)=='Aprobado')
                                          <div class="alert alert-sm alert-success">{{ estatusDocumento4($proc->candidato_id , $vacante->id) }}</div>
                                          @elseif(estatusDocumento4($proc->candidato_id , $vacante->id)=='Rechazado')
                                          <div class="alert alert-sm alert-danger">{{ estatusDocumento4($proc->candidato_id , $vacante->id) }}</div>
                                          @endif
                                        @endif
                                        <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento4($proc->candidato_id , $vacante->id) }}" > Descargar Acta de nacimiento </a>
                                        <br>
                                          @if(auth()->user()->rol=='Reclutamiento')
                                          <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento4{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_documento4{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                          @endif
                                        @endif
                                        <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento4{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_documento4 }}">
                                          <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                          </div>
                                          <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                          <div>
                                            <span class="btn btn-info btn-simple btn-file">
                                              <span class="fileinput-new">Subir Acta de nacimiento</span>
                                              <span class="fileinput-exists">Cambiar</span>
                                              <input type="file" name="documento4" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Borrar</a>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="col-lg-5 text-center col-file">
                                        <h4>IMSS</h4>
                                        @if(buscardocumento5($proc->candidato_id , $vacante->id)!="")
                                        <br>
                                        @if(estatusDocumento5($proc->candidato_id , $vacante->id))
                                          @if(estatusDocumento5($proc->candidato_id , $vacante->id)=='Aprobado')
                                          <div class="alert alert-sm alert-success">{{ estatusDocumento5($proc->candidato_id , $vacante->id) }}</div>
                                          @elseif(estatusDocumento5($proc->candidato_id , $vacante->id)=='Rechazado')
                                          <div class="alert alert-sm alert-danger">{{ estatusDocumento5($proc->candidato_id , $vacante->id) }}</div>
                                          @endif
                                        @endif
                                        <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento5($proc->candidato_id , $vacante->id) }}" > Descargar IMSS </a>
                                        <br>
                                          @if(auth()->user()->rol=='Reclutamiento')
                                          <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento5{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_documento5{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                          @endif
                                        @endif
                                        <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento5{{ $vacante_id }}_{{ $proc->candidato_id }}" data-provides="fileinput" style="{{ $estilo_file_documento5 }}">
                                          <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                                          </div>
                                          <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                          <div>
                                            <span class="btn btn-info btn-simple btn-file">
                                              <span class="fileinput-new">Subir IMSS</span>
                                              <span class="fileinput-exists">Cambiar</span>
                                              <input type="file" name="documento5" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Borrar</a>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="col-md-12 text-center">
                                        <br><br>
                                        <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                        <input type="hidden" name="proceso_id" value="{{ $proc->id }}">
                                        <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                        <input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' value='Subir documentos' />
                                      </div>

                                    </div>
                                  </form>
                                  </div>
                                </div>
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-7">
                                <!--  Alta de candidato  -->
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>Fecha de ingreso</p>
                                    <form class="" action="{{ route('contratar_colaborador') }}" method="post">
                                      @csrf
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                        <input type="date" name="fecha_alta" class="form-control" placeholder="Fecha" value="{{ date('Y-m-d') }}">
                                      </div>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                      <input type="text" readonly class="form-control" name="jefe" value="{{ qcolab($vacante->jefe) }}">
                                      </div>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                      <input type="text" readonly class="form-control" name="puesto" value="{{ nombre_puesto($vacante->puesto_id) }}">
                                      </div>
                                      <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                      <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                                      <input type="hidden" name="estatus" value="Contratado">
                                      <input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' value='Aprobar contratación' />
                                    </form>
                                  </div>
                                </div>
                              </div>
                            @endif
                            <!-- Fin Reclutamiento -->

                            <!-- Jefatura -->
                            @if(auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina')

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-1">
                                <div class="row">
                                  <div class="col-md-12 text-center">
                                    @if(buscarcv($proc->candidato_id , $vacante_id))
                                    <iframe src="/storage/app/public/{{ buscarcv($proc->candidato_id , $vacante_id) }}" width="100%" height="600"></iframe>
                                    @endif
                                  </div>
                                  <div class="col-md-12">
                                    <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('rechazar_candidato') }}" method="post">
                                      @csrf
                                      <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                      <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                                      <input type="hidden" name="estatus" value="Aprobado">
                                      <p>¿QUÉ TE PARECIO EL PERFIL DEL CANDIDATO?</p>
                                      <div class="star-rating">
                                          <label id="label_star_11_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="1" id="radio_star_11_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                          <label id="label_star_12_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="2" id="radio_star_12_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                          <label id="label_star_13_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="3" id="radio_star_13_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                          <label id="label_star_14_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="4" id="radio_star_14_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                          <label id="label_star_15_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="5" id="radio_star_15_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                      </div>
                                      <p> <br> </p>
                                      <div class="rating-options">
                                        <div class="rating-options">
                                          <label id="label_option_56_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">NO CUMPLE CON EL MÍNIMO APROBATORIO<input type="radio" name="idoneidad" value="No Cumple" id="radio_option_56_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                          <label id="label_option_55_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">OTRA OPCIÓN<input type="radio" name="idoneidad" value="Calificación muy Baja" id="radio_option_55_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                        </div>
                                      </div>
                                      <p> <br> </p>
                                      <button type="submit" class="btn btn-sm btn-danger" name="button">Rechazar candidato</button>
                                    </form>
                                  </div>
                                </div>
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-2">
                                <!--  Proponer fechas para entrevista  -->
                                  <?php
                                    $div_fechas="display:block;";

                                    if (buscarFechaPropuesta($proc->candidato_id , $vacante->id)=='Fechas asignadas') {
                                      $div_fechas="display:none;";
                                    }else {
                                      $div_fechas="display:block;";
                                    }
                                   ?>
                                @if(buscarFechaPropuesta($proc->candidato_id , $vacante->id)=='Fechas asignadas')
                                  <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-success">
                                        <p>La fecha para entrevista es: {{ buscarFechaEntrevista($proc->candidato_id , $vacante->id) }}</p>
                                      </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                      <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'cambio_fechas{{ $vacante_id }}_{{ $proc->candidato_id }}')" id="btn_cambiar_file_cv{{ $vacante_id }}_{{ $proc->candidato_id }}" name="button">Cambiar</button>
                                    </div>
                                  </div>
                                @endif
                                  <div class="row" id="cambio_fechas{{ $vacante_id }}_{{ $proc->candidato_id }}" style="{{ $div_fechas }}">
                                  <div class="col-md-12">
                                    Elige 3 fechas en la que estes disponible para tener la entrevista con el candidato.
                                    <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('asignar_fechas_entrevista') }}" method="post">
                                      @csrf
                                      <div class="row justify-content-center mt-5">
                                        <div class="col-sm-4">
                                          <h5>1.- Fecha</h5>

                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control" placeholder="Fecha" value="{{ $fechas1[0] ?? date('Y-m-d') }}">
                                          </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <h5> Hora inicial </h5>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <select class="form-control" name="desde[]" required>
                                                 <option value="09:00">09:00 AM</option>
                                                 <option value="09:30">09:30 AM</option>
                                                 <option value="10:00">10:00 AM</option>
                                                 <option value="10:30">10:30 AM</option>
                                                 <option value="11:00">11:00 AM</option>
                                                 <option value="11:30">11:30 AM</option>
                                                 <option value="12:00">12:00 PM</option>
                                                 <option value="12:30">12:30 PM</option>
                                                 <option value="13:00">01:00 PM</option>
                                                 <option value="13:30">01:30 PM</option>
                                                 <option value="14:00">02:00 PM</option>
                                                 <option value="14:30">02:30 PM</option>
                                                 <option value="15:00">03:00 PM</option>
                                                 <option value="15:30">03:30 PM</option>
                                                 <option value="16:00">04:00 PM</option>
                                                 <option value="16:30">04:30 PM</option>
                                                 <option value="17:00">05:00 PM</option>
                                                 <option value="17:30">05:30 PM</option>
                                             </select>

                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <h5> Hora final </h5>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <select class="form-control" name="hasta[]" required>
                                                 <option value="09:30">09:30 AM</option>
                                                 <option value="10:00">10:00 AM</option>
                                                 <option value="10:30">10:30 AM</option>
                                                 <option value="11:00">11:00 AM</option>
                                                 <option value="11:30">11:30 AM</option>
                                                 <option value="12:00">12:00 PM</option>
                                                 <option value="12:30">12:30 PM</option>
                                                 <option value="13:00">01:00 PM</option>
                                                 <option value="13:30">01:30 PM</option>
                                                 <option value="14:00">02:00 PM</option>
                                                 <option value="14:30">02:30 PM</option>
                                                 <option value="15:00">03:00 PM</option>
                                                 <option value="15:30">03:30 PM</option>
                                                 <option value="16:00">04:00 PM</option>
                                                 <option value="16:30">04:30 PM</option>
                                                 <option value="17:00">05:00 PM</option>
                                                 <option value="17:30">05:30 PM</option>
                                                 <option value="18:00">06:00 PM</option>
                                             </select>
                                          </div>
                                        </div>



                                      </div>
                                      <div class="row justify-content-center mt-5">
                                        <div class="col-sm-4">
                                          <h5>2.- Fecha</h5>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control" placeholder="Fecha" value="{{ $fechas1[1] ?? date('Y-m-d') }}">
                                          </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <h5> Hora inicial </h5>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <select class="form-control" name="desde[]" required>
                                                 <option value="09:00">09:00 AM</option>
                                                 <option value="09:30">09:30 AM</option>
                                                 <option value="10:00">10:00 AM</option>
                                                 <option value="10:30">10:30 AM</option>
                                                 <option value="11:00">11:00 AM</option>
                                                 <option value="11:30">11:30 AM</option>
                                                 <option value="12:00">12:00 PM</option>
                                                 <option value="12:30">12:30 PM</option>
                                                 <option value="13:00">01:00 PM</option>
                                                 <option value="13:30">01:30 PM</option>
                                                 <option value="14:00">02:00 PM</option>
                                                 <option value="14:30">02:30 PM</option>
                                                 <option value="15:00">03:00 PM</option>
                                                 <option value="15:30">03:30 PM</option>
                                                 <option value="16:00">04:00 PM</option>
                                                 <option value="16:30">04:30 PM</option>
                                                 <option value="17:00">05:00 PM</option>
                                                 <option value="17:30">05:30 PM</option>
                                             </select>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <h5> Hora final </h5>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <select class="form-control" name="hasta[]" required>
                                                 <option value="09:30">09:30 AM</option>
                                                 <option value="10:00">10:00 AM</option>
                                                 <option value="10:30">10:30 AM</option>
                                                 <option value="11:00">11:00 AM</option>
                                                 <option value="11:30">11:30 AM</option>
                                                 <option value="12:00">12:00 PM</option>
                                                 <option value="12:30">12:30 PM</option>
                                                 <option value="13:00">01:00 PM</option>
                                                 <option value="13:30">01:30 PM</option>
                                                 <option value="14:00">02:00 PM</option>
                                                 <option value="14:30">02:30 PM</option>
                                                 <option value="15:00">03:00 PM</option>
                                                 <option value="15:30">03:30 PM</option>
                                                 <option value="16:00">04:00 PM</option>
                                                 <option value="16:30">04:30 PM</option>
                                                 <option value="17:00">05:00 PM</option>
                                                 <option value="17:30">05:30 PM</option>
                                                 <option value="18:00">06:00 PM</option>
                                             </select>
                                          </div>
                                        </div>


                                      </div>
                                      <div class="row justify-content-center mt-5">
                                        <div class="col-sm-4">
                                          <h5> 3.- Fecha  </h5>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control"  placeholder="Fecha" value="{{ $fechas1[2] ?? date('Y-m-d') }}">
                                          </div>

                                        </div>
                                        <div class="col-sm-4">
                                          <h5> Hora incial </h5>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <select class="form-control" name="desde[]" required>
                                                 <option value="09:00">09:00 AM</option>
                                                 <option value="09:30">09:30 AM</option>
                                                 <option value="10:00">10:00 AM</option>
                                                 <option value="10:30">10:30 AM</option>
                                                 <option value="11:00">11:00 AM</option>
                                                 <option value="11:30">11:30 AM</option>
                                                 <option value="12:00">12:00 PM</option>
                                                 <option value="12:30">12:30 PM</option>
                                                 <option value="13:00">01:00 PM</option>
                                                 <option value="13:30">01:30 PM</option>
                                                 <option value="14:00">02:00 PM</option>
                                                 <option value="14:30">02:30 PM</option>
                                                 <option value="15:00">03:00 PM</option>
                                                 <option value="15:30">03:30 PM</option>
                                                 <option value="16:00">04:00 PM</option>
                                                 <option value="16:30">04:30 PM</option>
                                                 <option value="17:00">05:00 PM</option>
                                                 <option value="17:30">05:30 PM</option>
                                             </select>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <h5> Hora final </h5>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                              </div>
                                            </div>
                                            <select class="form-control" name="hasta[]" required>
                                                 <option value="09:30">09:30 AM</option>
                                                 <option value="10:00">10:00 AM</option>
                                                 <option value="10:30">10:30 AM</option>
                                                 <option value="11:00">11:00 AM</option>
                                                 <option value="11:30">11:30 AM</option>
                                                 <option value="12:00">12:00 PM</option>
                                                 <option value="12:30">12:30 PM</option>
                                                 <option value="13:00">01:00 PM</option>
                                                 <option value="13:30">01:30 PM</option>
                                                 <option value="14:00">02:00 PM</option>
                                                 <option value="14:30">02:30 PM</option>
                                                 <option value="15:00">03:00 PM</option>
                                                 <option value="15:30">03:30 PM</option>
                                                 <option value="16:00">04:00 PM</option>
                                                 <option value="16:30">04:30 PM</option>
                                                 <option value="17:00">05:00 PM</option>
                                                 <option value="17:30">05:30 PM</option>
                                                 <option value="18:00">06:00 PM</option>
                                             </select>
                                          </div>
                                        </div>

                                      </div>
                                      <div class="row" style="margin-top:50px;">
                                        <div class="col-sm-12">
                                          <div class="input-group">
                                            <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                            <input type="hidden" name="proceso_id" value="{{ $proc->id }}">
                                            <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">

                                          </div>
                                        </div>
                                      </div>
                                      <br>
                                      <div class="row">
                                        <div class="col-md-12 text-center">
                                          <br>
                                          <button type="submit" class="btn btn-info" name="button">Enviar a Reclutamiento</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>

                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-3">
                                <!--  Aprobar la entrevista  -->
                                @if(buscarestatus($proc->candidato_id , $vacante_id))
                                  @if(buscarestatus($proc->candidato_id , $vacante_id)=='aprobado')
                                  <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-success" style="text-transform:uppercase;">
                                        {{ buscarestatus($proc->candidato_id , $vacante_id) }}
                                      </div>
                                    </div>
                                  </div>
                                  @elseif(buscarestatus($proc->candidato_id , $vacante_id)=='rechazado')
                                  <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-danger" style="text-transform:uppercase;">
                                        {{ buscarestatus($proc->candidato_id , $vacante_id) }}
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                @else
                                <div class="row">
                                  <div class="col-md-6 text-center">
                                    <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('apruebaestatus') }}" method="post">
                                      @csrf
                                      <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                      <input type="hidden" name="proceso_id" value="{{ $proc->id }}">
                                      <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                      <textarea name="comentarios" class="form-control" placeholder="Comentarios">{{ buscarcomentarios($proc->candidato_id , $vacante->id) ?? '' }}</textarea>
                                      <button type="submit" class="btn btn-info btn-sm" name="button">Aprobar candidato</button>
                                    </form>
                                  </div>
                                  <div class="col-md-6 text-center">
                                    <button type="button" class="btn btn-sm btn-danger"
                                    onclick="mostarrRechazar('vac_{{ $vacante_id }}_{{ $proc->candidato_id }}');"
                                     name="button" id="vac_{{ $vacante_id }}_{{ $proc->candidato_id }}boton">
                                      Rechazar candidato
                                    </button>
                                    <div class="" id="vac_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;">
                                      <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('rechazar_candidato') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                        <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                                        <input type="hidden" name="estatus" value="Aprobado">
                                        <p>¿QUÉ TE PARECIO EL PERFIL DEL CANDIDATO?</p>
                                        <div class="star-rating">
                                            <label id="label_star_1_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="1" id="radio_star_1_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_star_2_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="2" id="radio_star_2_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_star_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="3" id="radio_star_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_star_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="4" id="radio_star_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_star_5_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="5" id="radio_star_5_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                        </div>
                                        <p> <br> </p>
                                        <div class="rating-options">
                                          <div class="rating-options">
                                            <label id="label_option_1_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">NO CUMPLE CON EL PERFIL DE PUESTO<input type="radio" name="idoneidad" value="No Cumple" id="radio_option_1_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_option_2_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">POCA EXPERIENCIA PARA EL PUESTO<input type="radio" name="idoneidad" value="Poca Experiencia" id="radio_option_2_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                          </div>
                                        </div>
                                        <p> <br> </p>
                                        <button type="submit" class="btn btn-sm btn-danger" name="button">Rechazar candidato</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                @endif
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-4">
                                  <!--  Capturar Referencias  -->
                                      <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                          <h5 class="info-text"> Referencias laborales </h5>
                                        </div>
                                      </div>
                                      <?php
                                      $estilo_file_buro="display:none;";
                                      if(buscarburo($proc->candidato_id , $vacante_id)==""){
                                          $estilo_file_buro="display:block;";
                                      }else {
                                        $estilo_file_buro="display:none;";
                                      }

                                      $estilo_file_carta="display:none;";
                                      if(buscarcarta($proc->candidato_id , $vacante_id)==""){
                                          $estilo_file_carta="display:block;";
                                      }else {
                                        $estilo_file_carta="display:none;";
                                      }

                                       ?>
                                      <div class="row justify-content-center">
                                        <div class="col-md-6 text-center">
                                          <p> <br> </p>
                                          @if(buscarburo($proc->candidato_id , $vacante_id)!="")
                                          <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarburo($proc->candidato_id , $vacante_id) }}" class="btn btn-primary">Descargar Buró Laboral</a>
                                          <br>
                                          @endif
                                        </div>
                                        <div class="col-md-6 text-center">

                                          <p> <br> </p>
                                          @if(buscarcarta($proc->candidato_id , $vacante_id)!="")
                                          <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarcarta($proc->candidato_id , $vacante_id) }}" class="btn btn-primary">Descargar Carta</a>
                                          <br>
                                          @endif
                                        </div>
                                      </div>
                                </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-5">
                                <!--  Exámen psicométrico  -->
                                <div class="row justify-content-center">
                                  <div class="col-sm-12">
                                    <h5 class="info-text"> Exámen psicométrico </h5>
                                  </div>
                                </div>
                                <?php
                                $estilo_file_examen="display:none;";
                                if(buscarexamen($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_examen="display:block;";
                                }else {
                                  $estilo_file_examen="display:none;";
                                }

                                 $res=buscarresultados($proc->candidato_id , $vacante->id);
                                  ?>
                                 @if($res!="")
                                 <div class="row">
                                   <div class="col-md-12 text-center">
                                     <div class="alert alert-success">
                                       {{ buscarresultados($proc->candidato_id , $vacante_id) }}
                                     </div>
                                   </div>
                                 </div>
                                 @endif
                                <div class="row">
                                  @if($res<=69 && $res!="")
                                  <div class="col-md-12 text-center">
                                    <div class="" id="vacrecex_{{ $vacante_id }}_{{ $proc->candidato_id }}">
                                      <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('rechazar_candidato') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                        <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                                        <input type="hidden" name="estatus" value="Aprobado">
                                        <p>¿QUÉ TE PARECIO EL PERFIL DEL CANDIDATO?</p>
                                        <div class="star-rating">
                                            <label id="label_star_6_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="1" id="radio_star_6_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_star_7_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="2" id="radio_star_7_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_star_8_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="3" id="radio_star_8_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_star_9_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="4" id="radio_star_9_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_star_10_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioStar(this.id , 'star_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="star star_{{ $vacante_id }}_{{ $proc->candidato_id }}">&#9733;<input type="radio" name="rating" value="5" id="radio_star_10_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                        </div>
                                        <p> <br> </p>
                                        <div class="rating-options">
                                          <div class="rating-options">
                                            <label id="label_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">NO CUMPLE CON EL MÍNIMO APROBATORIO<input type="radio" name="idoneidad" value="No Cumple" id="radio_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                            <label id="label_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">OTRA OPCIÓN<input type="radio" name="idoneidad" value="Calificación muy Baja" id="radio_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                          </div>
                                        </div>
                                        <p> <br> </p>
                                        <button type="submit" class="btn btn-sm btn-danger" name="button">Rechazar candidato</button>
                                      </form>
                                    </div>

                                  </div>
                                  @endif
                                </div>
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-6">
                                  <!--  aprobar documentación  -->

                                    <div class="row justify-content-center">
                                      <div class="col-sm-12">
                                        <h5 class="info-text">Validar documentación </h5>
                                      </div>

                                      <div class="col-md-6">
                                        <div class="row">
                                          <div class="col-md-6">
                                            Identificación
                                          </div>
                                          <div class="col-md-6">
                                            @if(buscardocumento1($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento1($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @else
                                            Pendiente
                                            @endif
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            Comprobante de domicilio
                                          </div>
                                          <div class="col-md-6">
                                            @if(buscardocumento2($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento2($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @else
                                            Pendiente
                                            @endif
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            CURP
                                          </div>
                                          <div class="col-md-6">
                                            @if(buscardocumento3($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento3($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @else
                                            Pendiente
                                            @endif
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            Acta de nacimiento
                                          </div>
                                          <div class="col-md-6">
                                            @if(buscardocumento4($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento4($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @else
                                            Pendiente
                                            @endif
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            IMSS
                                          </div>
                                          <div class="col-md-6">
                                            @if(buscardocumento5($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento5($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @else
                                            Pendiente
                                            @endif
                                          </div>
                                        </div>
                                      </div>

                                    </div>
                                </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-7">
                                <!--  Alta de candidato  -->
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>Fecha de ingreso</p>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                        <input type="date" name="fecha_alta" class="form-control" placeholder="Fecha" value="{{ date('Y-m-d') }}">
                                      </div>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                      <input type="text" readonly class="form-control" name="jefe" value="{{ qcolab($vacante->jefe) }}">
                                      </div>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                        <input type="text" readonly class="form-control" name="puesto" value="{{ nombre_puesto($vacante->puesto_id) }}">
                                      </div>
                                  </div>
                                </div>
                              </div>

                            @endif

                            <!-- Fin Jefatura -->


                            <!-- Nómina -->

                            @if(auth()->user()->perfil=='Jefatura' && auth()->user()->rol=='Nómina')
                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-1">
                                <!--  subir curriculum  -->
                                <?php

                                $estilo_file_cv="display:none;";
                                if(buscarcv($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_cv="display:block;";
                                }else {
                                  $estilo_file_cv="display:none;";
                                }

                                 ?>
                                <h5 class="info-text"> Curriculum</h5>
                                <div class="col-md-12">
                                  <div class="text-center">
                                    @if(buscarcv($proc->candidato_id , $vacante_id))
                                    <iframe src="/storage/app/public/{{ buscarcv($proc->candidato_id , $vacante_id) }}" width="100%" height="600"></iframe>
                                    @endif
                                  </div>
                                </div>
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-2">
                                  <!--  Ver fechas que puso jefatura  -->
                                  <?php

                                  $fechas1=explode(',',buscarfechas1($proc->candidato_id , $vacante->id));
                                  $desde1=explode(',',buscardesde1($proc->candidato_id , $vacante->id));
                                  $hasta1=explode(',',buscarhasta1($proc->candidato_id , $vacante->id));


                                   ?>
                                   <?php

                                     $div_fechas_progrmadas="display:block;";

                                     if (buscarFechaProgramada($proc->candidato_id , $vacante->id)=='Fechas programadas') {
                                       $div_fechas_progrmadas="display:none;";
                                     }else {
                                       $div_fechas_progrmadas="display:block;";
                                     }
                                    ?>

                                  @if(buscarFechaProgramada($proc->candidato_id , $vacante->id)=='Fechas programadas')
                                    <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-success">
                                        <p>La fecha para entrevista es: {{ buscarFechaEntrevista($proc->candidato_id , $vacante->id) }}</p>
                                      </div>
                                    </div>
                                  </div>
                                  @endif

                                  @if(buscarFechaPropuesta($proc->candidato_id , $vacante->id)=='Fechas asignadas')

                                  @else
                                    <div class="row">
                                    <div class="col-md-12">
                                      <div class="alert alert-danger">
                                      {{ buscarFechaPropuesta($proc->candidato_id , $vacante->id) }}
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-3">
                                @if(buscarestatus($proc->candidato_id , $vacante_id))
                                  @if(buscarestatus($proc->candidato_id , $vacante_id)=='aprobado')
                                  <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-success" style="text-transform:uppercase;">
                                        {{ buscarestatus($proc->candidato_id , $vacante_id) }}
                                      </div>
                                    </div>
                                  </div>
                                  @elseif(buscarestatus($proc->candidato_id , $vacante_id)=='rechazado')
                                  <div class="row">
                                    <div class="col-md-12 text-center">
                                      <div class="alert alert-danger" style="text-transform:uppercase;">
                                        {{ buscarestatus($proc->candidato_id , $vacante_id) }}
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                @else
                                <div class="row">
                                  <div class="col-md-12 text-center">
                                    <div class="alert alert-danger" style="text-transform:uppercase;">
                                      Pendiente la respuesta de la entrevista
                                    </div>
                                  </div>
                                </div>
                                @endif
                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-4">
                                  <!--  Capturar Referencias  -->

                                      <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                          <h5 class="info-text"> Referencias laborales </h5>
                                        </div>
                                      </div>
                                      <?php
                                      $estilo_file_buro="display:none;";
                                      if(buscarburo($proc->candidato_id , $vacante_id)==""){
                                          $estilo_file_buro="display:block;";
                                      }else {
                                        $estilo_file_buro="display:none;";
                                      }

                                      $estilo_file_carta="display:none;";
                                      if(buscarcarta($proc->candidato_id , $vacante_id)==""){
                                          $estilo_file_carta="display:block;";
                                      }else {
                                        $estilo_file_carta="display:none;";
                                      }

                                       ?>
                                      <div class="row justify-content-center">
                                        <div class="col-md-6 text-center">
                                          @if(buscarburo($proc->candidato_id , $vacante_id))
                                          <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarburo($proc->candidato_id , $vacante_id) }}" class="btn btn-primary">Descargar Buró Laboral</a>
                                          @endif
                                        </div>
                                        <div class="col-md-6 text-center">
                                          @if(buscarcarta($proc->candidato_id , $vacante_id))
                                          <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarcarta($proc->candidato_id , $vacante_id) }}" class="btn btn-primary">Descargar Carta</a>
                                          @endif
                                        </div>
                                      </div>

                                </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-5">
                                <!--  Exámen psicométrico  -->
                                <?php
                                $estilo_file_examen="display:none;";
                                if(buscarexamen($proc->candidato_id , $vacante_id)==""){
                                    $estilo_file_examen="display:block;";
                                }else {
                                  $estilo_file_examen="display:none;";
                                }
                                 ?>

                                <div class="row">
                                  <div class="col-md-12">

                                      <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                          <h5 class="info-text"> Exámen psicométrico </h5>
                                        </div>

                                        <?php
                                        $res=buscarresultados($proc->candidato_id , $vacante->id);
                                         ?>
                                        <div class="col-md-12 text-center">
                                          <p> <br> </p>
                                          @if(buscarexamen($proc->candidato_id , $vacante_id)!="")
                                          <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarexamen($proc->candidato_id , $vacante_id) }}" class="btn btn-primary">Descargar Resultado</a>
                                          <br>
                                          @endif
                                        </div>



                                      </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-12 text-center">
                                    <div class="alert alert-success">
                                      {{ buscarresultados($proc->candidato_id , $vacante_id) }}
                                    </div>
                                  </div>
                                </div>

                              </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-6">
                                  <!--  aprobar documentación  -->
                                  <form class="" action="{{ route('validar_documentacion') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row justify-content-center">
                                      <div class="col-sm-12">
                                        <h5 class="info-text">Validar documentación </h5>
                                      </div>

                                      <div class="col-md-10">
                                        <div class="row">
                                          <div class="col-md-4">
                                            Identificación
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento1($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento1($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @endif
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento1($proc->candidato_id , $vacante->id)!="")
                                            <select class="form-control" name="estatus_documento1" required>
                                              @if(estatusDocumento1($proc->candidato_id , $vacante->id))
                                              <option value="{{ estatusDocumento1($proc->candidato_id , $vacante->id) }}">{{ estatusDocumento1($proc->candidato_id , $vacante->id) }}</option>
                                              @endif
                                              <option value="">Selecciona:</option>
                                              <option value="Aprobado">Aprobado</option>
                                              <option value="Rechazado">Rechazado</option>
                                            </select>
                                            @endif
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-4">
                                            Comprobante de domicilio
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento2($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento2($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @endif
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento2($proc->candidato_id , $vacante->id)!="")
                                            <select class="form-control" name="estatus_documento2" required>
                                              @if(estatusDocumento2($proc->candidato_id , $vacante->id))
                                              <option value="{{ estatusDocumento2($proc->candidato_id , $vacante->id) }}">{{ estatusDocumento2($proc->candidato_id , $vacante->id) }}</option>
                                              @endif
                                              <option value="">Selecciona:</option>
                                              <option value="Aprobado">Aprobado</option>
                                              <option value="Rechazado">Rechazado</option>
                                            </select>
                                            @endif
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-4">
                                            CURP
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento3($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento3($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @endif
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento3($proc->candidato_id , $vacante->id)!="")
                                            <select class="form-control" name="estatus_documento3" required>
                                              @if(estatusDocumento3($proc->candidato_id , $vacante->id))
                                              <option value="{{ estatusDocumento3($proc->candidato_id , $vacante->id) }}">{{ estatusDocumento3($proc->candidato_id , $vacante->id) }}</option>
                                              @endif
                                              <option value="">Selecciona:</option>
                                              <option value="Aprobado">Aprobado</option>
                                              <option value="Rechazado">Rechazado</option>
                                            </select>
                                            @endif
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-4">
                                            Acta de nacimiento
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento4($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento4($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @endif
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento4($proc->candidato_id , $vacante->id)!="")
                                            <select class="form-control" name="estatus_documento4" required>
                                              @if(estatusDocumento4($proc->candidato_id , $vacante->id))
                                              <option value="{{ estatusDocumento4($proc->candidato_id , $vacante->id) }}">{{ estatusDocumento4($proc->candidato_id , $vacante->id) }}</option>
                                              @endif
                                              <option value="">Selecciona:</option>
                                              <option value="Aprobado">Aprobado</option>
                                              <option value="Rechazado">Rechazado</option>
                                            </select>
                                            @endif
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-4">
                                            IMSS
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento5($proc->candidato_id , $vacante->id)!="")

                                            <a target="_blank" href="/storage/app/public/{{ buscardocumento5($proc->candidato_id , $vacante->id) }}"> Descargar </a>

                                            @endif
                                          </div>
                                          <div class="col-md-4">
                                            @if(buscardocumento5($proc->candidato_id , $vacante->id)!="")
                                            <select class="form-control" name="estatus_documento5" required>
                                              @if(estatusDocumento5($proc->candidato_id , $vacante->id))
                                              <option value="{{ estatusDocumento5($proc->candidato_id , $vacante->id) }}">{{ estatusDocumento5($proc->candidato_id , $vacante->id) }}</option>
                                              @endif
                                              <option value="">Selecciona:</option>
                                              <option value="Aprobado">Aprobado</option>
                                              <option value="Rechazado">Rechazado</option>
                                            </select>
                                            @endif
                                          </div>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="col-md-12 text-center">
                                      <br>
                                      <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                      <input type="hidden" name="proceso_id" value="{{ $proc->id }}">
                                      <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                      <br>
                                      <input type='submit' class='btn btn-info ' value='Validar Documentos' />
                                    </div>
                                  </form>
                                </div>

                              <div class="tab-pane" id="paso{{$proc->candidato_id }}-7">
                                <!--  Alta de candidato  -->
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>Fecha de ingreso</p>
                                    <form class="" action="{{ route('contratar_colaborador') }}" method="post">
                                      @csrf
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                        <input type="date" min="{{ date('Y-m-d') }}" name="fecha_alta" class="form-control" placeholder="Fecha" value="{{ date('Y-m-d') }}">
                                      </div>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                      <input type="text" readonly class="form-control" name="jefe" value="{{ qcolab($vacante->jefe) }}">
                                      </div>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <i class="tim-icons icon-single-02"></i>
                                          </div>
                                        </div>
                                      <input type="text" readonly class="form-control" name="puesto" value="{{ nombre_puesto($vacante->puesto_id) }}">
                                      </div>
                                      <input type="hidden" name="candidato_id" value="{{ $proc->candidato_id }}">
                                      <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                                      <input type="hidden" name="estatus" value="Contratado">
                                      <input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' value='Alta de candidato' />
                                    </form>
                                  </div>
                                </div>
                              </div>
                            @endif
                            <!-- Fin Nómina -->

                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="pull-right">
                            <input type='button' id="next" class='btn btn-next btn-link btn-info btn-wd' name='next' value='Siguiente >' />

                          </div>
                          <div class="pull-left">
                            <input type='button' id="prev" class='btn btn-previous btn-link btn-info btn-wd' name='previous' value='< Anterior' />
                          </div>
                          <div class="clearfix"></div>
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

  function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

$(document).ready(function() {
  // Initialise the wizard
  demo.initNowUiWizard();
  setTimeout(function() {
    $('.card.card-wizard').addClass('active');
  }, 600);

  // Obtén el valor de 'can' y 'paso' desde la URL
  var can = getParameterByName('can');
  var paso = getParameterByName('paso');

  // Activa la pestaña del candidato
  var candidatoTab = $('#tab_paso' + can);
  if (candidatoTab.length > 0) {
    candidatoTab.tab('show');
  }

  // Avanzar al paso deseado (simulando clics en el botón "Siguiente")
  var pasoDeseado = parseInt(paso); // Convertir a número
  if (!isNaN(pasoDeseado)) {

    // Detener el flujo del asistente en el paso deseado
    $('.card-wizard').bootstrapWizard('display', pasoDeseado);



    // Desactivar el paso anterior (paso 1)
    $('#tab_paso'+can+'-1').removeClass('active');
    $('#paso'+can+'-1').removeClass('active');
    $('#tab_paso'+can+'-1').removeClass('checked');
    $('#paso'+can+'-1').removeClass('checked');

    $('#tab_paso'+can+'-'+paso).click();
    $('#paso'+can+'-'+paso).click();

    $('#tab_paso'+can+'-'+paso).addClass('active');
    $('#paso'+can+'-'+paso).addClass('active');
    $('#tab_paso'+can+'-'+paso).addClass('checked');
    $('#paso'+can+'-'+paso).addClass('checked');


  }
});

  </script>




@endpush
