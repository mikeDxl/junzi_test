<section class="">
  <div class="container-fluid">
    <div class="card" style="padding-left:0px;">
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
        <div class="row">

        </div>
        <nav class="nav nav-pills nav-fill ms-auto">
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa1 }}" aria-hidden="true"></i></span> <br> Curriculum</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa2 }}" aria-hidden="true"></i></span> <br> Programar <br> Entrevista</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa3 }}" aria-hidden="true"></i></span> <br> Resultado <br> Entrevista</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa4 }}" aria-hidden="true"></i></span> <br> Referencias</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa5 }}" aria-hidden="true"></i></span> <br> Exámen <br> psicométrico</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa6 }}" aria-hidden="true"></i></span> <br> Documentación</a>
          <a class="nav-link tab-pills text-center" href="#"> <span><i class="{{ $clase_fa7 }}" aria-hidden="true"></i></span> <br> Alta candidato</a>
        </nav>
      </div>
      <div class="card-body">
        <div class="tab d-none">
      <style media="screen">
      .question {
margin-bottom: 20px;
}

.stars {
display: inline-block;
}

.star {
font-size: 30px;
color: #ccc;
cursor: pointer;
}

.star.active, .star:hover {
color: orange;
}

      </style>
          @if($procesoinfo->curriculum)

           <div class="row">
             <div class="col-md-6">
               <p id="mensajedeerror"></p>
               @if ($datosPreguntasAvg->isNotEmpty())
               <h3>Promedio: {{ number_format($promedio,2) }}</h3>
                  @foreach ($datosPreguntasAvg as $pregunta)
                      <div class="question">
                          <div class="row">
                              <div class="col-6">
                                  <p>{{ $pregunta->pregunta }}:</p>
                              </div>
                              <div class="col-6">
                                  <div class="" id="{{ Str::slug($pregunta->pregunta) }}Stars">
                                      @for ($i = 1; $i <= $pregunta->valoracion; $i++)
                                          <i class="fa fa-star" style="color:orange;"></i>
                                      @endfor
                                  </div>
                              </div>
                          </div>
                      </div>
                  @endforeach
                  <br>
                  <p class="d-inline-flex gap-1">
                    <a class="btn btn-link" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Cambiar respuestas
                    </a>
                  </p>
                  <div class="collapse" id="collapseExample">
                    <form id="ratingForm" action="{{ route('calificar') }}" method="post">
                      @csrf
                         <div class="question">
                             <div class="row">
                               <div class="col-6">
                                 <p>Experiencia adecuada</p>
                               </div>
                               <div class="col-6">
                                 <div class="stars" id="expStars"></div>
                                 <input type="hidden" name="pregunta[]" value="Experiencia adecuada">
                                 <input type="hidden" name="valoracion[]" id="expRating" value="0">
                               </div>
                             </div>
                         </div>

                         <div class="question">
                           <div class="row">
                             <div class="col-6">
                               <p>Habilidades técnicas</p>

                             </div>
                             <div class="col-6">
                               <div class="stars" id="techSkillsStars"></div>
                               <input type="hidden" name="pregunta[]" value="Habilidades técnicas">
                               <input type="hidden" name="valoracion[]" id="techSkillsRating" value="0">
                             </div>
                           </div>
                         </div>

                         <div class="question">
                           <div class="row">
                             <div class="col-6">
                               <p>Perfil demográfico</p>

                             </div>
                             <div class="col-6">
                               <div class="stars" id="demographicStars"></div>
                               <input type="hidden" name="pregunta[]" value="Perfil demográfico">
                               <input type="hidden" name="valoracion[]" id="demographicRating" value="0">
                             </div>
                           </div>
                         </div>

                         <div class="question">
                           <div class="row">
                             <div class="col-6">
                               <p>Ubicación geográfica</p>

                             </div>
                             <div class="col-6">
                               <div class="stars" id="locationStars"></div>
                               <input type="hidden" name="pregunta[]" value="Ubicación geográfica">
                               <input type="hidden" name="valoracion[]" id="locationRating" value="0">
                             </div>
                           </div>
                         </div>

                         <div class="question">
                           <div class="row">
                             <div class="col-6">
                               <p>Escolaridad</p>

                             </div>
                             <div class="col-6">
                               <div class="stars" id="educationStars"></div>
                               <input type="hidden" name="pregunta[]" value="Escolaridad">
                               <input type="hidden" name="valoracion[]" id="educationRating" value="0">
                             </div>
                           </div>
                         </div>

                         <div class="question">
                           <div class="row">
                             <div class="col-6">
                               <p>Estabilidad laboral</p>

                             </div>
                             <div class="col-6">
                               <div class="stars" id="jobStabilityStars"></div>
                               <input type="hidden" name="pregunta[]" value="Estabilidad laboral">
                               <input type="hidden" name="valoracion[]" id="jobStabilityRating" value="0">
                             </div>
                           </div>
                         </div>
                         <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                         <input type="hidden" name="company_id" value="{{ $vacante->company_id }}">
                         <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                         <input type="hidden" name="etapa" value="Curriculum">
                         <input type="hidden" name="perfil" value="{{ auth()->user()->rol }}">
                         <button type="submit" class="btn btn-info">Enviar calificaciones</button>
                     </form>
                  </div>

              @else
              <form id="ratingForm" action="{{ route('calificar') }}" method="post">
                @csrf
                   <div class="question">
                       <div class="row">
                         <div class="col-6">
                           <p>Experiencia adecuada</p>

                         </div>
                         <div class="col-6">
                           <div class="stars" id="expStars"></div>
                           <input type="hidden" name="pregunta[]" value="Experiencia adecuada">
                           <input type="hidden" name="valoracion[]" id="expRating" value="0">
                         </div>
                       </div>
                   </div>

                   <div class="question">
                     <div class="row">
                       <div class="col-6">
                         <p>Habilidades técnicas</p>

                       </div>
                       <div class="col-6">
                         <div class="stars" id="techSkillsStars"></div>
                         <input type="hidden" name="pregunta[]" value="Habilidades técnicas">
                         <input type="hidden" name="valoracion[]" id="techSkillsRating" value="0">
                       </div>
                     </div>
                   </div>

                   <div class="question">
                     <div class="row">
                       <div class="col-6">
                         <p>Perfil demográfico</p>

                       </div>
                       <div class="col-6">
                         <div class="stars" id="demographicStars"></div>
                         <input type="hidden" name="pregunta[]" value="Perfil demográfico">
                         <input type="hidden" name="valoracion[]" id="demographicRating" value="0">
                       </div>
                     </div>
                   </div>

                   <div class="question">
                     <div class="row">
                       <div class="col-6">
                         <p>Ubicación geográfica</p>

                       </div>
                       <div class="col-6">
                         <div class="stars" id="locationStars"></div>
                         <input type="hidden" name="pregunta[]" value="Ubicación geográfica">
                         <input type="hidden" name="valoracion[]" id="locationRating" value="0">
                       </div>
                     </div>
                   </div>

                   <div class="question">
                     <div class="row">
                       <div class="col-6">
                         <p>Escolaridad</p>

                       </div>
                       <div class="col-6">
                         <div class="stars" id="educationStars"></div>
                         <input type="hidden" name="pregunta[]" value="Escolaridad">
                         <input type="hidden" name="valoracion[]" id="educationRating" value="0">
                       </div>
                     </div>
                   </div>

                   <div class="question">
                     <div class="row">
                       <div class="col-6">
                         <p>Estabilidad laboral</p>

                       </div>
                       <div class="col-6">
                         <div class="stars" id="jobStabilityStars"></div>
                         <input type="hidden" name="pregunta[]" value="Estabilidad laboral">
                         <input type="hidden" name="valoracion[]" id="jobStabilityRating" value="0">
                       </div>
                     </div>
                   </div>
                   <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                   <input type="hidden" name="company_id" value="{{ $vacante->company_id }}">
                   <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                   <input type="hidden" name="etapa" value="Curriculum">
                   <input type="hidden" name="perfil" value="{{ auth()->user()->rol }}">
                   <button type="submit" class="btn btn-info">Enviar calificaciones</button>
               </form>
              @endif



             </div>
             <div class="col-md-6">
               <iframe src="/storage/app/public/{{ $procesoinfo->curriculum }}#zoom=100&navpanes=0&view=FitH" width="100%" height="600"></iframe>


               <div class="text-center">
                 <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_cv{{ $vacante->id }}_{{ $candidato }}')" id="btn_cambiar_file_cv{{ $vacante->id }}_{{ $candidato }}" name="button">Cambiar</button>
               </div>
              <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('vacantes_subircv') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                  <div class="col-lg-10 text-center">
                    <div class="fileinput fileinput-new text-center" id="div_cambiar_file_cv{{ $vacante_id }}_{{ $candidato }}" data-provides="fileinput" >
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
                        <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                        <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
             </div>
           </div>

           <div class="row" style="margin-top:50px;">
             <div class="col-md-4">
               <form class="" action="{{ route('rechazar_candidato') }}" method="post">
                 @csrf
                 <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                 <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                 <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                 <button type="submit" class="btn btn-danger btn-sm" name="button">Rechazar candidato</button>
               </form>
             </div>
           </div>
          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif

        </div>

        <div class="tab d-none">
          @if($procesoinfo->entrevista1_fecha)
          <?php
          $fechas1=explode(',',$procesoinfo->entrevista1_fecha);
          $desde1=explode(',',$procesoinfo->entrevista1_desde);
          $hasta1=explode(',',$procesoinfo->entrevista1_hasta);

           ?>
           <div class="row" id="div_fechas_programadas2_{{ $vacante->id }}_{{ $candidato }}">
           <div class="col-md-12">
             @if($procesoinfo->entrevista2_fecha)
             <p>La fecha de la entrevista es: {{ $procesoinfo->entrevista2_fecha.' '.$procesoinfo->entrevista2_hora }} </p>

               @if($procesoinfo->estatus_proceso=='Rechazado')

               @else
               <button type="button" class="btn btn-link" name="button" data-bs-toggle="collapse" href="#collapseExampleCambiarFechas" role="button" aria-expanded="false" aria-controls="collapseExampleCambiarFechas">
                 <i class="fa fa-edit"></i> Cambiar Fechas
               </button>

               <div class="collapse" id="collapseExampleCambiarFechas">
                 <div class="card card-body">
                   <p>Selecciona una fecha para programar la entrevista con {{ qcolab($vacante->jefe) }}</p>
                   <br>
                   <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('programar_fechas_entrevista') }}" method="post">
                         @csrf
                         @for ($i = 0; $i < count($fechas1); $i++)


                             <div class="row">
                                 <div class="col-1">
                                   @if($procesoinfo->entrevista2_fecha==$fechas1[$i])
                                      <input type="radio" checked name="horario" value="{{ $i }}">
                                   @else
                                      <input type="radio"  name="horario" value="{{ $i }}">
                                   @endif
                                 </div>
                                 <div class="col-2">
                                     <p>{{ $fechas1[$i] ?? '' }}</p>
                                     <input type="hidden" name="fecha[]" value="{{ $fechas1[$i] }}">
                                 </div>
                                 <div class="col-4">
                                     <p>Elige un horario entre {{ $desde1[$i] ?? '' }} y {{ $hasta1[$i] ?? '' }}</p>
                                 </div>
                                 <div class="col-2">
                                   <?php
                                  $inicio = $desde1[$i]; // Tu variable de inicio
                                  $fin = $hasta1[$i];   // Tu variable de fin

                                  // Convertir las horas de inicio y fin a formato de 24 horas
                                  $inicio24 = date("H:i", strtotime($inicio));
                                  $fin24 = date("H:i", strtotime($fin));

                                  // Lista de horarios disponibles
                                  $horarios_disponibles = array(
                                      "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
                                      "12:00", "12:30", "13:00", "13:30", "14:00", "14:30",
                                      "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
                                      "18:00", "18:30", "19:00", "19:30", "20:00",
                                  );

                                  ?>
                                  <select class="form-control" name="desde[]" required>

                                    @if($procesoinfo->entrevista2_hora)
                                    <?php
                                    $hora2=explode(' - ',$procesoinfo->entrevista2_hora);
                                     ?>
                                      <option value="{{ $hora2[0] }}">{{ $hora2[0] }}</option>
                                    @endif
                                       <?php
                                       // Generar opciones del select solo con horarios disponibles dentro del rango
                                       foreach ($horarios_disponibles as $hora) {
                                           // Convertir la hora a formato de 24 horas
                                           $hora24 = date("H:i", strtotime($hora));

                                           // Verificar si la hora está dentro del rango
                                           if ($hora24 >= $inicio24 && $hora24 <= $fin24) {
                                               echo '<option value="' . $hora24 . '">' . $hora . '</option>';
                                           }
                                       }
                                       ?>
                                    </select>
                                 </div>
                                 <div class="col-2">
                                   <select class="form-control" name="hasta[]" required>
                                     @if($procesoinfo->entrevista2_hora)
                                     <option value="{{ $hora2[1] }}">{{ $hora2[1] }}</option>
                                     @endif
                                        <?php
                                        // Generar opciones del select solo con horarios disponibles dentro del rango
                                        foreach ($horarios_disponibles as $hora) {
                                            // Convertir la hora a formato de 24 horas
                                            $hora24 = date("H:i", strtotime($hora));

                                            // Verificar si la hora está dentro del rango
                                            if ($hora24 >= $inicio24 && $hora24 <= $fin24) {
                                                echo '<option value="' . $hora24 . '">' . $hora . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                 </div>
                             </div>


                         @endfor
                         <div class="row" style="margin-top:50px;">
                             <div class="col-sm-12">
                                 <div class="input-group">
                                     <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                                     <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                                     <input type="hidden" name="candidato_id" value="{{ $candidato }}">
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
               @endif

             @else

             <p>Selecciona una fecha para programar la entrevista con {{ qcolab($vacante->jefe) }}</p>
             <br>
             <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('programar_fechas_entrevista') }}" method="post">
                   @csrf
                   @for ($i = 0; $i < count($fechas1); $i++)


                       <div class="row">
                           <div class="col-1">
                             @if($procesoinfo->entrevista2_fecha==$fechas1[$i])
                                <input type="radio" checked name="horario" value="{{ $i }}">
                             @else
                                <input type="radio"  name="horario" value="{{ $i }}">
                             @endif
                           </div>
                           <div class="col-2">
                               <p>{{ $fechas1[$i] ?? '' }}</p>
                               <input type="hidden" name="fecha[]" value="{{ $fechas1[$i] }}">
                           </div>
                           <div class="col-4">
                               <p>Elige un horario entre {{ $desde1[$i] ?? '' }} y {{ $hasta1[$i] ?? '' }}</p>
                           </div>
                           <div class="col-2">
                             <?php
                            $inicio = $desde1[$i]; // Tu variable de inicio
                            $fin = $hasta1[$i];   // Tu variable de fin

                            // Convertir las horas de inicio y fin a formato de 24 horas
                            $inicio24 = date("H:i", strtotime($inicio));
                            $fin24 = date("H:i", strtotime($fin));

                            // Lista de horarios disponibles
                            $horarios_disponibles = array(
                                "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
                                "12:00", "12:30", "13:00", "13:30", "14:00", "14:30",
                                "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
                                "18:00", "18:30", "19:00", "19:30", "20:00",
                            );

                            ?>
                            <select class="form-control" name="desde[]" required>

                              @if($procesoinfo->entrevista2_hora)
                              <?php
                              $hora2=explode(' - ',$procesoinfo->entrevista2_hora);
                               ?>
                                <option value="{{ $hora2[0] }}">{{ $hora2[0] }}</option>
                              @endif
                                 <?php
                                 // Generar opciones del select solo con horarios disponibles dentro del rango
                                 foreach ($horarios_disponibles as $hora) {
                                     // Convertir la hora a formato de 24 horas
                                     $hora24 = date("H:i", strtotime($hora));

                                     // Verificar si la hora está dentro del rango
                                     if ($hora24 >= $inicio24 && $hora24 <= $fin24) {
                                         echo '<option value="' . $hora24 . '">' . $hora . '</option>';
                                     }
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="col-2">
                             <select class="form-control" name="hasta[]" required>
                               @if($procesoinfo->entrevista2_hora)
                               <option value="{{ $hora2[1] }}">{{ $hora2[1] }}</option>
                               @endif
                                  <?php
                                  // Generar opciones del select solo con horarios disponibles dentro del rango
                                  foreach ($horarios_disponibles as $hora) {
                                      // Convertir la hora a formato de 24 horas
                                      $hora24 = date("H:i", strtotime($hora));

                                      // Verificar si la hora está dentro del rango
                                      if ($hora24 >= $inicio24 && $hora24 <= $fin24) {
                                          echo '<option value="' . $hora24 . '">' . $hora . '</option>';
                                      }
                                  }
                                  ?>
                              </select>
                           </div>
                       </div>


                   @endfor
                   <div class="row" style="margin-top:50px;">
                       <div class="col-sm-12">
                           <div class="input-group">
                               <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                               <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                               <input type="hidden" name="candidato_id" value="{{ $candidato }}">
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
          @if($procesoinfo->estatus_entrevista)

          @if($procesoinfo->estatus_entrevista=='aprobado')
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="alert alert-success" style="text-transform:uppercase;">
                {{ $procesoinfo->estatus_entrevista }}
              </div>
            </div>
          </div>
          @elseif($procesoinfo->estatus_entrevista=='rechazado')
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="alert alert-danger" style="text-transform:uppercase;">
                {{ $procesoinfo->estatus_entrevista }}
              </div>
            </div>
          </div>
          @endif

          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>

        <div class="tab d-none">
          @if($procesoinfo->estatus_entrevista=='aprobado')

          <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('subir_referencias') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-4 text-center">
                <div class="fileinput fileinput-new text-center" id="div_cambiar_file_buro{{ $vacante->id }}_{{ $candidato }}" data-provides="fileinput">
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
                <p> <br> </p>
                @if(buscarburo($candidato , $vacante->id)!="")
                <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarburo($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Buró Laboral</a>
                <br>


                @endif
              </div>
              <div class="col-md-8 text-center">


                  <div class="row">
                    <div class="col-md-6 text-center">
                      <div class="fileinput fileinput-new text-center" id="div_cambiar_file_carta{{ $vacante->id }}_{{ $candidato }}" data-provides="fileinput" >
                        <div class="fileinput-new thumbnail">
                          <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail">

                        </div>

                        <div>
                          <span class="btn btn-info btn-sm btn-simple btn-file">
                            <span class="fileinput-new">Carta de recomendación</span>
                            <span class="fileinput-exists">Cambiar</span>
                            <input type="file" name="carta"/>
                          </span>
                          <a class="btn btn-danger btn-sm btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>

                        </div>
                      </div>
                      <p> <br> </p>
                      @if(buscarcarta($candidato , $vacante->id)!="")
                      <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarcarta($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Carta</a>
                      <br>
                      @endif
                    </div>
                    <div class="col-md-6 text-center">
                      <div class="fileinput fileinput-new text-center" id="div_cambiar_file_carta2{{ $vacante->id }}_{{ $candidato }}" data-provides="fileinput" >
                        <div class="fileinput-new thumbnail">
                          <img src="{{ asset('white') }}/img/image_placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail">

                        </div>

                        <div>
                          <span class="btn btn-info btn-sm btn-simple btn-file">
                            <span class="fileinput-new">Carta de recomendación (2)</span>
                            <span class="fileinput-exists">Cambiar</span>
                            <input type="file" name="carta2"/>
                          </span>
                          <a class="btn btn-danger btn-sm btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>

                        </div>
                      </div>
                      <p> <br> </p>
                      @if(buscarcarta2($candidato , $vacante->id)!="")
                      <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarcarta2($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Carta</a>
                      <br>
                      @endif
                    </div>
                  </div>
              </div>
            </div>
            <div class="row">

              <div class="col-md-12 text-center">
                <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                <br>
                <br>
                <div class="text-center">
                  <button type="submit" class="fileinput-exists btn btn-info" name="button">Subir referencias</button>
                </div>
              </div>
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
          <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('examen') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">

              <div class="col-sm-5">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="tim-icons icon-single-02"></i>
                    </div>
                  </div>
                  <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                  <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                  <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                  <input type="text" name="resultados"  class="form-control" placeholder="Resultado" value="{{ buscarresultados($candidato , $vacante->id) ?? '' }}">
                </div>
              </div>

              <div class="col-md-12 text-center">
                <div class="fileinput fileinput-new text-center" id="div_cambiar_file_examen{{ $vacante->id }}_{{ $candidato }}" data-provides="fileinput" >
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
                @if(buscarexamen($candidato , $vacante->id)!="")
                <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarexamen($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Resultado</a>
                <br>

                @endif
              </div>
              <?php
              $res=buscarresultados($candidato, $vacante->id);
               ?>


              <div class="col-md-12 text-center">
                <p><br></p>
                <button type="submit" class="fileinput-exists btn btn-info" name="button">Subir resultados</button>
              </div>


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
          <form class="" action="{{ route('documentacion') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">
            <div class="col-sm-12">
              <h5 class="info-text"> Documentación </h5>
            </div>


            <div class="col-lg-5 text-center col-file">
              <h4>Identificación</h4>
              @if(buscardocumento1($candidato , $vacante->id)!="")
              <br>
              @if(estatusDocumento1($candidato , $vacante->id))
                @if(estatusDocumento1($candidato , $vacante->id)=='Aprobado')
                <div class="alert alert-sm alert-success">{{ estatusDocumento1($candidato , $vacante->id) }}</div>
                @elseif(estatusDocumento1($candidato , $vacante->id)=='Rechazado')
                <div class="alert alert-sm alert-danger">{{ estatusDocumento1($candidato , $vacante->id) }} <br> {{ comentarioDocumento1($candidato , $vacante->id) }}</div>
                @endif
              @endif
              <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento1($candidato , $vacante->id) }}" > Descargar Identificación </a>
              <br>
                @if(auth()->user()->rol=='Reclutamiento1')
                <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento1{{ $vacante_id }}_{{ $candidato }}')" id="btn_cambiar_file_documento1{{ $vacante_id }}_{{ $candidato }}" name="button">Cambiar</button>
                @endif
              @endif

              <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento1{{ $vacante_id }}_{{ $candidato }}" data-provides="fileinput" >
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
              @if(buscardocumento2($candidato , $vacante->id)!="")
              <br>
              @if(estatusDocumento2($candidato , $vacante->id))
                @if(estatusDocumento2($candidato , $vacante->id)=='Aprobado')
                <div class="alert alert-sm alert-success">{{ estatusDocumento2($candidato , $vacante->id) }}</div>
                @elseif(estatusDocumento2($candidato , $vacante->id)=='Rechazado')
                <div class="alert alert-sm alert-danger">{{ estatusDocumento2($candidato , $vacante->id) }} <br> {{ comentarioDocumento2($candidato , $vacante->id) }}</div>
                @endif
              @endif
              <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento2($candidato , $vacante->id) }}" > Descargar Comprobante </a>

              <br>
                @if(auth()->user()->rol=='Reclutamiento1')
                <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento2{{ $vacante_id }}_{{ $candidato }}')" id="btn_cambiar_file_documento2{{ $vacante_id }}_{{ $candidato }}" name="button">Cambiar</button>
                @endif
              @endif
              <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento2{{ $vacante_id }}_{{ $candidato }}" data-provides="fileinput" >
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
              @if(buscardocumento3($candidato , $vacante->id)!="")
              <br>
              @if(estatusDocumento3($candidato , $vacante->id))
                @if(estatusDocumento3($candidato , $vacante->id)=='Aprobado')
                <div class="alert alert-sm alert-success">{{ estatusDocumento3($candidato , $vacante->id) }}</div>
                @elseif(estatusDocumento3($candidato , $vacante->id)=='Rechazado')
                <div class="alert alert-sm alert-danger">{{ estatusDocumento3($candidato , $vacante->id) }} <br> {{ comentarioDocumento3($candidato , $vacante->id) }}</div>
                @endif
              @endif
              <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento3($candidato , $vacante->id) }}" > Descargar CURP </a>
              <br>
                @if(auth()->user()->rol=='Reclutamiento1')
                <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento3{{ $vacante_id }}_{{ $candidato }}')" id="btn_cambiar_file_documento3{{ $vacante_id }}_{{ $candidato }}" name="button">Cambiar</button>
                @endif
              @endif
              <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento3{{ $vacante_id }}_{{ $candidato }}" data-provides="fileinput" >
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
              @if(buscardocumento4($candidato , $vacante->id)!="")
              <br>
              @if(estatusDocumento4($candidato , $vacante->id))
                @if(estatusDocumento4($candidato , $vacante->id)=='Aprobado')
                <div class="alert alert-sm alert-success">{{ estatusDocumento4($candidato , $vacante->id) }}</div>
                @elseif(estatusDocumento4($candidato , $vacante->id)=='Rechazado')
                <div class="alert alert-sm alert-danger">{{ estatusDocumento4($candidato , $vacante->id) }} <br> {{ comentarioDocumento4($candidato , $vacante->id) }}</div>
                @endif
              @endif
              <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento4($candidato , $vacante->id) }}" > Descargar Acta de nacimiento </a>
              <br>
                @if(auth()->user()->rol=='Reclutamiento1')
                <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento4{{ $vacante_id }}_{{ $candidato }}')" id="btn_cambiar_file_documento4{{ $vacante_id }}_{{ $candidato }}" name="button">Cambiar</button>
                @endif
              @endif
              <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento4{{ $vacante_id }}_{{ $candidato }}" data-provides="fileinput" >
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
              @if(buscardocumento5($candidato , $vacante->id)!="")
              <br>
              @if(estatusDocumento5($candidato , $vacante->id))
                @if(estatusDocumento5($candidato , $vacante->id)=='Aprobado')
                <div class="alert alert-sm alert-success">{{ estatusDocumento5($candidato , $vacante->id) }}</div>
                @elseif(estatusDocumento5($candidato , $vacante->id)=='Rechazado')
                <div class="alert alert-sm alert-danger">{{ estatusDocumento5($candidato , $vacante->id) }} <br> {{ comentarioDocumento5($candidato , $vacante->id) }} </div>

                @endif
              @endif
              <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscardocumento5($candidato , $vacante->id) }}" > Descargar IMSS </a>
              <br>
                @if(auth()->user()->rol=='Reclutamiento1')
                <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'div_cambiar_file_documento5{{ $vacante_id }}_{{ $candidato }}')" id="btn_cambiar_file_documento5{{ $vacante_id }}_{{ $candidato }}" name="button">Cambiar</button>
                @endif
              @endif
              <div class="fileinput fileinput-new text-center" id="div_cambiar_file_documento5{{ $vacante_id }}_{{ $candidato }}" data-provides="fileinput" >
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
              <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
              <input type="hidden" name="candidato_id" value="{{ $candidato }}">
              <input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' value='Subir documentos' />
            </div>

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
              <p>Fecha Jefatura</p>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="tim-icons icon-single-02"></i>
                  </div>
                </div>
                <input type="date" min="{{ date('Y-m-d') }}" name="fecha_jefatura" class="form-control" placeholder="Fecha"  value="{{ fechajefatura($proc->candidato_id , $vacante->id) }}">
              </div>
              <p>Fecha Nómina</p>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="tim-icons icon-single-02"></i>
                  </div>
                </div>
                <input type="date" min="{{ date('Y-m-d') }}" name="fecha_nomina" class="form-control" placeholder="Fecha" readonly value="{{ fechanomina($proc->candidato_id , $vacante->id) }}">
              </div>

          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>
      </div>
      <div class="card-footer text-center">
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

<script type="text/javascript">
document.getElementById('ratingForm').addEventListener('submit', function(event) {
  const requiredRatings = ['expRating', 'techSkillsRating', 'demographicRating', 'educationRating', 'jobStabilityRating'];
  let valid = true;

  requiredRatings.forEach(function(ratingId) {
      const rating = document.getElementById(ratingId);
      if (rating && rating.value === '0') {
          valid = false;
          var elementoMensaje = document.getElementById('mensajedeerror');
           // Actualiza el contenido del elemento <p> con el mensaje de error
           elementoMensaje.textContent = 'Por favor, complete todas las calificaciones requeridas.';
          rating.closest('.question').classList.add('has-error'); // Agrega alguna clase CSS para resaltar el error
      }
  });

  if (!valid) {
      event.preventDefault();
  }
});

</script>
