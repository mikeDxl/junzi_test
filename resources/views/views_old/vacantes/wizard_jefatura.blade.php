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
            <br>
            <p>Última actualización: {{ $procesoinfo->updated_at ?? '' }}</p>
            <input type="hidden" id="tipo" value="{{ $tipo }}">
          </div>

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
          @if($procesoinfo->curriculum)

          <div class="row">
            <div class="col-md-6">

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
            </div>
          </div>

          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>

        <div class="tab d-none">
          @if($procesoinfo->curriculum)

           @if($procesoinfo->entrevista1_fecha)

           <?php
           $fendia=explode(',',$procesoinfo->entrevista1_fecha);
           $fenhora1=explode(',',$procesoinfo->entrevista1_desde);
           $fenhora2=explode(',',$procesoinfo->entrevista1_hasta);

            ?>
             <div class="row">

               <div class="col-md-12 text-center">
            <!--   <button type="button" class="btn btn-sm btn-danger" onclick="mostrarDivFile(this.id , 'cambio_fechas{{ $vacante->id }}_{{ $candidato }}')" id="btn_cambiar_file_cv{{ $vacante->id }}_{{ $candidato }}" name="button">Cambiar</button> -->
               </div>
             </div>
           @endif
           <div class="row" id="cambio_fechas{{ $vacante->id }}_{{ $candidato }}">

             <div class="col-md-12">
               @if($procesoinfo->entrevista1_fecha)
               <div class="col-md-12">
                 <p>La fecha de la entrevista es: {{ $procesoinfo->entrevista2_fecha.' '.$procesoinfo->entrevista2_hora }} </p>
                   @if($procesoinfo->estatus_proceso=='Rechazado')

                   @else
                   <button type="button" class="btn btn-link" name="button" data-bs-toggle="collapse" href="#collapseExampleCambiarFechas" role="button" aria-expanded="false" aria-controls="collapseExampleCambiarFechas">
                     <i class="fa fa-edit"></i> Cambiar Fechas
                   </button>
                   @endif
                 </p>
                 <br>
                 <div class="collapse" id="collapseExampleCambiarFechas">
                   <div class="card card-body">
                     Elige 3 fechas en la que estes disponible para tener la entrevista con el candidato.
                     <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('asignar_fechas_entrevista') }}" method="post">
                       @csrf
                       <div class="row justify-content-center mt-5">
                         <div class="col-sm-4">
                           <h5>1.- Fecha</h5>

                           <div class="input-group">
                             <div class="input-group-prepend">
                               <div class="input-group-text">

                               </div>
                             </div>
                             <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control" placeholder="Fecha" value="{{ $fendia[0] ?? date('Y-m-d') }}">
                           </div>

                         </div>
                         <div class="col-sm-4">
                             <h5> Hora inicial </h5>
                           <div class="input-group">
                             <div class="input-group-prepend">
                               <div class="input-group-text">

                               </div>
                             </div>
                             <select class="form-control" name="desde[]" required>

                                  <option value="{{ $fenhora1[0] ?? '' }}">{{ $fenhora1[0] ?? '' }}</option>

                                  <option value="09:00">09:00</option>
                                  <option value="09:30">09:30</option>
                                  <option value="10:00">10:00</option>
                                  <option value="10:30">10:30</option>
                                  <option value="11:00">11:00</option>
                                  <option value="11:30">11:30</option>
                                  <option value="12:00">12:00</option>
                                  <option value="12:30">12:30</option>
                                  <option value="13:00">13:00</option>
                                  <option value="13:30">13:30</option>
                                  <option value="14:00">14:00</option>
                                  <option value="14:30">14:30</option>
                                  <option value="15:00">15:00</option>
                                  <option value="15:30">15:30</option>
                                  <option value="16:00">16:00</option>
                                  <option value="16:30">16:30</option>
                                  <option value="17:00">17:00</option>
                                  <option value="17:30">17:30</option>
                              </select>

                           </div>
                         </div>
                         <div class="col-sm-4">
                             <h5> Hora final </h5>
                           <div class="input-group">
                             <div class="input-group-prepend">
                               <div class="input-group-text">

                               </div>
                             </div>
                             <select class="form-control" name="hasta[]" required>

                               <option value="{{ $fenhora2[0] ?? ''  }}">{{ $fenhora2[0] ?? ''  }}</option>


                               <option value="09:00">09:00</option>
                               <option value="09:30">09:30</option>
                               <option value="10:00">10:00</option>
                               <option value="10:30">10:30</option>
                               <option value="11:00">11:00</option>
                               <option value="11:30">11:30</option>
                               <option value="12:00">12:00</option>
                               <option value="12:30">12:30</option>
                               <option value="13:00">13:00</option>
                               <option value="13:30">13:30</option>
                               <option value="14:00">14:00</option>
                               <option value="14:30">14:30</option>
                               <option value="15:00">15:00</option>
                               <option value="15:30">15:30</option>
                               <option value="16:00">16:00</option>
                               <option value="16:30">16:30</option>
                               <option value="17:00">17:00</option>
                               <option value="17:30">17:30</option>
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

                               </div>
                             </div>
                             <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control" placeholder="Fecha" value="{{ $fendia[1] ?? date('Y-m-d') }}">
                           </div>

                         </div>
                         <div class="col-sm-4">
                             <h5> Hora inicial </h5>
                           <div class="input-group">
                             <div class="input-group-prepend">
                               <div class="input-group-text">

                               </div>
                             </div>
                             <select class="form-control" name="desde[]" required>

                               <option value="{{ $fenhora1[1] ?? '' }}">{{ $fenhora1[1] ?? '' }}</option>


                               <option value="09:00">09:00</option>
                               <option value="09:30">09:30</option>
                               <option value="10:00">10:00</option>
                               <option value="10:30">10:30</option>
                               <option value="11:00">11:00</option>
                               <option value="11:30">11:30</option>
                               <option value="12:00">12:00</option>
                               <option value="12:30">12:30</option>
                               <option value="13:00">13:00</option>
                               <option value="13:30">13:30</option>
                               <option value="14:00">14:00</option>
                               <option value="14:30">14:30</option>
                               <option value="15:00">15:00</option>
                               <option value="15:30">15:30</option>
                               <option value="16:00">16:00</option>
                               <option value="16:30">16:30</option>
                               <option value="17:00">17:00</option>
                               <option value="17:30">17:30</option>
                              </select>
                           </div>
                         </div>
                         <div class="col-sm-4">
                             <h5> Hora final </h5>
                           <div class="input-group">
                             <div class="input-group-prepend">
                               <div class="input-group-text">

                               </div>
                             </div>
                             <select class="form-control" name="hasta[]" required>

                               <option value="{{ $fenhora2[1] ?? '' }}">{{ $fenhora2[1] ?? '' }}</option>


                               <option value="09:00">09:00</option>
                               <option value="09:30">09:30</option>
                               <option value="10:00">10:00</option>
                               <option value="10:30">10:30</option>
                               <option value="11:00">11:00</option>
                               <option value="11:30">11:30</option>
                               <option value="12:00">12:00</option>
                               <option value="12:30">12:30</option>
                               <option value="13:00">13:00</option>
                               <option value="13:30">13:30</option>
                               <option value="14:00">14:00</option>
                               <option value="14:30">14:30</option>
                               <option value="15:00">15:00</option>
                               <option value="15:30">15:30</option>
                               <option value="16:00">16:00</option>
                               <option value="16:30">16:30</option>
                               <option value="17:00">17:00</option>
                               <option value="17:30">17:30</option>
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

                               </div>
                             </div>
                             <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control"  placeholder="Fecha" value="{{ $fendia[2] ?? date('Y-m-d') }}">
                           </div>

                         </div>
                         <div class="col-sm-4">
                           <h5> Hora incial </h5>
                           <div class="input-group">
                             <div class="input-group-prepend">
                               <div class="input-group-text">

                               </div>
                             </div>
                             <select class="form-control" name="desde[]" required>

                               <option value="{{ $fenhora1[2] ?? '' }}">{{ $fenhora1[2] ?? '' }}</option>


                               <option value="09:00">09:00</option>
                               <option value="09:30">09:30</option>
                               <option value="10:00">10:00</option>
                               <option value="10:30">10:30</option>
                               <option value="11:00">11:00</option>
                               <option value="11:30">11:30</option>
                               <option value="12:00">12:00</option>
                               <option value="12:30">12:30</option>
                               <option value="13:00">13:00</option>
                               <option value="13:30">13:30</option>
                               <option value="14:00">14:00</option>
                               <option value="14:30">14:30</option>
                               <option value="15:00">15:00</option>
                               <option value="15:30">15:30</option>
                               <option value="16:00">16:00</option>
                               <option value="16:30">16:30</option>
                               <option value="17:00">17:00</option>
                               <option value="17:30">17:30</option>
                              </select>
                           </div>
                         </div>
                         <div class="col-sm-4">
                             <h5> Hora final </h5>
                           <div class="input-group">
                             <div class="input-group-prepend">
                               <div class="input-group-text">

                               </div>
                             </div>
                             <select class="form-control" name="hasta[]" required>

                               <option value="{{ $fenhora2[2] ?? '' }}">{{ $fenhora2[2] ?? '' }}</option>


                               <option value="09:00">09:00</option>
                               <option value="09:30">09:30</option>
                               <option value="10:00">10:00</option>
                               <option value="10:30">10:30</option>
                               <option value="11:00">11:00</option>
                               <option value="11:30">11:30</option>
                               <option value="12:00">12:00</option>
                               <option value="12:30">12:30</option>
                               <option value="13:00">13:00</option>
                               <option value="13:30">13:30</option>
                               <option value="14:00">14:00</option>
                               <option value="14:30">14:30</option>
                               <option value="15:00">15:00</option>
                               <option value="15:30">15:30</option>
                               <option value="16:00">16:00</option>
                               <option value="16:30">16:30</option>
                               <option value="17:00">17:00</option>
                               <option value="17:30">17:30</option>
                              </select>
                           </div>
                         </div>

                       </div>
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
                           <button type="submit" class="btn btn-info" name="button">Siguiente</button>
                         </div>
                       </div>
                     </form>
                   </div>
                 </div>
               </div>
               @else
               <br>
               Elige 3 fechas en la que estes disponible para tener la entrevista con el candidato.
               <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('asignar_fechas_entrevista') }}" method="post">
                 @csrf
                 <div class="row justify-content-center mt-5">
                   <div class="col-sm-4">
                     <h5>1.- Fecha</h5>

                     <div class="input-group">
                       <div class="input-group-prepend">
                         <div class="input-group-text">

                         </div>
                       </div>
                       <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control" placeholder="Fecha" value="{{ $fendia[0] ?? date('Y-m-d') }}">
                     </div>

                   </div>
                   <div class="col-sm-4">
                       <h5> Hora inicial </h5>
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <div class="input-group-text">

                         </div>
                       </div>
                       <select class="form-control" name="desde[]" required>

                            <option value="{{ $fenhora1[0] ?? '' }}">{{ $fenhora1[0] ?? '' }}</option>

                            <option value="09:00">09:00</option>
                            <option value="09:30">09:30</option>
                            <option value="10:00">10:00</option>
                            <option value="10:30">10:30</option>
                            <option value="11:00">11:00</option>
                            <option value="11:30">11:30</option>
                            <option value="12:00">12:00</option>
                            <option value="12:30">12:30</option>
                            <option value="13:00">13:00</option>
                            <option value="13:30">13:30</option>
                            <option value="14:00">14:00</option>
                            <option value="14:30">14:30</option>
                            <option value="15:00">15:00</option>
                            <option value="15:30">15:30</option>
                            <option value="16:00">16:00</option>
                            <option value="16:30">16:30</option>
                            <option value="17:00">17:00</option>
                            <option value="17:30">17:30</option>
                            <option value="18:00">18:00</option>
                            <option value="18:30">18:30</option>
                            <option value="19:00">19:00</option>
                        </select>

                     </div>
                   </div>
                   <div class="col-sm-4">
                       <h5> Hora final </h5>
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <div class="input-group-text">

                         </div>
                       </div>
                       <select class="form-control" name="hasta[]" required>

                         <option value="{{ $fenhora2[0] ?? ''  }}">{{ $fenhora2[0] ?? ''  }}</option>


                         <option value="09:00">09:00</option>
                         <option value="09:30">09:30</option>
                         <option value="10:00">10:00</option>
                         <option value="10:30">10:30</option>
                         <option value="11:00">11:00</option>
                         <option value="11:30">11:30</option>
                         <option value="12:00">12:00</option>
                         <option value="12:30">12:30</option>
                         <option value="13:00">13:00</option>
                         <option value="13:30">13:30</option>
                         <option value="14:00">14:00</option>
                         <option value="14:30">14:30</option>
                         <option value="15:00">15:00</option>
                         <option value="15:30">15:30</option>
                         <option value="16:00">16:00</option>
                         <option value="16:30">16:30</option>
                         <option value="17:00">17:00</option>
                         <option value="17:30">17:30</option>
                         <option value="18:00">18:00</option>
                         <option value="18:30">18:30</option>
                         <option value="19:00">19:00</option>
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

                         </div>
                       </div>
                       <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control" placeholder="Fecha" value="{{ $fendia[1] ?? date('Y-m-d') }}">
                     </div>

                   </div>
                   <div class="col-sm-4">
                       <h5> Hora inicial </h5>
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <div class="input-group-text">

                         </div>
                       </div>
                       <select class="form-control" name="desde[]" required>

                         <option value="{{ $fenhora1[1] ?? '' }}">{{ $fenhora1[1] ?? '' }}</option>


                         <option value="09:00">09:00</option>
                         <option value="09:30">09:30</option>
                         <option value="10:00">10:00</option>
                         <option value="10:30">10:30</option>
                         <option value="11:00">11:00</option>
                         <option value="11:30">11:30</option>
                         <option value="12:00">12:00</option>
                         <option value="12:30">12:30</option>
                         <option value="13:00">13:00</option>
                         <option value="13:30">13:30</option>
                         <option value="14:00">14:00</option>
                         <option value="14:30">14:30</option>
                         <option value="15:00">15:00</option>
                         <option value="15:30">15:30</option>
                         <option value="16:00">16:00</option>
                         <option value="16:30">16:30</option>
                         <option value="17:00">17:00</option>
                         <option value="17:30">17:30</option>
                         <option value="18:00">18:00</option>
                         <option value="18:30">18:30</option>
                         <option value="19:00">19:00</option>
                        </select>
                     </div>
                   </div>
                   <div class="col-sm-4">
                       <h5> Hora final </h5>
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <div class="input-group-text">

                         </div>
                       </div>
                       <select class="form-control" name="hasta[]" required>

                         <option value="{{ $fenhora2[1] ?? '' }}">{{ $fenhora2[1] ?? '' }}</option>


                         <option value="09:00">09:00</option>
                         <option value="09:30">09:30</option>
                         <option value="10:00">10:00</option>
                         <option value="10:30">10:30</option>
                         <option value="11:00">11:00</option>
                         <option value="11:30">11:30</option>
                         <option value="12:00">12:00</option>
                         <option value="12:30">12:30</option>
                         <option value="13:00">13:00</option>
                         <option value="13:30">13:30</option>
                         <option value="14:00">14:00</option>
                         <option value="14:30">14:30</option>
                         <option value="15:00">15:00</option>
                         <option value="15:30">15:30</option>
                         <option value="16:00">16:00</option>
                         <option value="16:30">16:30</option>
                         <option value="17:00">17:00</option>
                         <option value="17:30">17:30</option>
                         <option value="18:00">18:00</option>
                         <option value="18:30">18:30</option>
                         <option value="19:00">19:00</option>
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

                         </div>
                       </div>
                       <input type="date" min="{{ date('Y-m-d') }}" name="fecha[]" class="form-control"  placeholder="Fecha" value="{{ $fendia[2] ?? date('Y-m-d') }}">
                     </div>

                   </div>
                   <div class="col-sm-4">
                     <h5> Hora incial </h5>
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <div class="input-group-text">

                         </div>
                       </div>
                       <select class="form-control" name="desde[]" required>

                         <option value="{{ $fenhora1[2] ?? '' }}">{{ $fenhora1[2] ?? '' }}</option>


                         <option value="09:00">09:00</option>
                         <option value="09:30">09:30</option>
                         <option value="10:00">10:00</option>
                         <option value="10:30">10:30</option>
                         <option value="11:00">11:00</option>
                         <option value="11:30">11:30</option>
                         <option value="12:00">12:00</option>
                         <option value="12:30">12:30</option>
                         <option value="13:00">13:00</option>
                         <option value="13:30">13:30</option>
                         <option value="14:00">14:00</option>
                         <option value="14:30">14:30</option>
                         <option value="15:00">15:00</option>
                         <option value="15:30">15:30</option>
                         <option value="16:00">16:00</option>
                         <option value="16:30">16:30</option>
                         <option value="17:00">17:00</option>
                         <option value="17:30">17:30</option>
                         <option value="18:00">18:00</option>
                         <option value="18:30">18:30</option>
                         <option value="19:00">19:00</option>
                        </select>
                     </div>
                   </div>
                   <div class="col-sm-4">
                       <h5> Hora final </h5>
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <div class="input-group-text">

                         </div>
                       </div>
                       <select class="form-control" name="hasta[]" required>

                         <option value="{{ $fenhora2[2] ?? '' }}">{{ $fenhora2[2] ?? '' }}</option>


                         <option value="09:00">09:00</option>
                         <option value="09:30">09:30</option>
                         <option value="10:00">10:00</option>
                         <option value="10:30">10:30</option>
                         <option value="11:00">11:00</option>
                         <option value="11:30">11:30</option>
                         <option value="12:00">12:00</option>
                         <option value="12:30">12:30</option>
                         <option value="13:00">13:00</option>
                         <option value="13:30">13:30</option>
                         <option value="14:00">14:00</option>
                         <option value="14:30">14:30</option>
                         <option value="15:00">15:00</option>
                         <option value="15:30">15:30</option>
                         <option value="16:00">16:00</option>
                         <option value="16:30">16:30</option>
                         <option value="17:00">17:00</option>
                         <option value="17:30">17:30</option>
                        </select>
                     </div>
                   </div>

                 </div>
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
                     <button type="submit" class="btn btn-info" name="button">Siguiente</button>
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
          @if($procesoinfo->entrevista2_fecha)
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
          <div class="container">
            <div class="row">
              <div class="col-md-6">

                @if ($datosPreguntasAvg2->isNotEmpty())
                <h3>Promedio: {{ number_format($promedio2,2) }}</h3>
                   @foreach ($datosPreguntasAvg2 as $pregunta)
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
                     <form id="ratingForm2" action="{{ route('calificar') }}" method="post">
                       @csrf
                          <div class="question">
                              <div class="row">
                                <div class="col-6">
                                  <p>Idoneidad cultural:</p>
                                </div>
                                <div class="col-6">
                                  <div class="stars" id="idoneidadStars"></div>
                                  <input type="hidden" name="pregunta[]" value="Idoneidad cultural">
                                  <input type="hidden" name="valoracion[]" id="idoneidadRating" value="0">
                                </div>
                              </div>
                          </div>

                          <div class="question">
                              <div class="row">
                                <div class="col-6">
                                  <p>Desempeño durante la entrevista:</p>
                                </div>
                                <div class="col-6">
                                  <div class="stars" id="desempenoStars"></div>
                                  <input type="hidden" name="pregunta[]" value="Desempeño durante la entrevista">
                                  <input type="hidden" name="valoracion[]" id="desempenoRating" value="0">
                                </div>
                              </div>
                          </div>

                          <div class="question">
                              <div class="row">
                                <div class="col-6">
                                  <p>Experiencia adecuada:</p>
                                </div>
                                <div class="col-6">
                                  <div class="stars" id="exp2Stars"></div>
                                  <input type="hidden" name="pregunta[]" value="Experiencia adecuada">
                                  <input type="hidden" name="valoracion[]" id="exp2Rating" value="0">
                                </div>
                              </div>
                          </div>

                          <div class="question">
                            <div class="row">
                              <div class="col-6">
                                <p>Habilidades técnicas:</p>
                              </div>
                              <div class="col-6">
                                <div class="stars" id="techSkills2Stars"></div>
                                <input type="hidden" name="pregunta[]" value="Habilidades técnicas">
                                <input type="hidden" name="valoracion[]" id="techSkills2Rating" value="0">
                              </div>
                            </div>
                          </div>

                          <div class="question">
                            <div class="row">
                              <div class="col-6">
                                <p>Ubicación geográfica:</p>
                              </div>
                              <div class="col-6">
                                <div class="stars" id="location2Stars"></div>
                                <input type="hidden" name="pregunta[]" value="Ubicación geográfica">
                                <input type="hidden" name="valoracion[]" id="location2Rating" value="0">
                              </div>
                            </div>
                          </div>


                          <div class="question">
                            <div class="row">
                              <div class="col-6">
                                <p>Estabilidad laboral:</p>
                              </div>
                              <div class="col-6">
                                <div class="stars" id="jobStability2Stars"></div>
                                <input type="hidden" name="pregunta[]" value="Estabilidad laboral">
                                <input type="hidden" name="valoracion[]" id="jobStability2Rating" value="0">
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                          <input type="hidden" name="company_id" value="{{ $vacante->company_id }}">
                          <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                          <input type="hidden" name="etapa" value="Entrevista">
                          <input type="hidden" name="perfil" value="{{ auth()->user()->rol }}">
                          <button type="submit" class="btn btn-info">Enviar calificaciones</button>
                      </form>
                   </div>

               @else
               <form id="ratingForm2" action="{{ route('calificar') }}" method="post">
                 @csrf
                    <div class="question">
                        <div class="row">
                          <div class="col-6">
                            <p>Idoneidad cultural:</p>
                          </div>
                          <div class="col-6">
                            <div class="stars" id="idoneidadStars"></div>
                            <input type="hidden" name="pregunta[]" value="Idoneidad cultural">
                            <input type="hidden" name="valoracion[]" id="idoneidadRating" value="0">
                          </div>
                        </div>
                    </div>

                    <div class="question">
                        <div class="row">
                          <div class="col-6">
                            <p>Desempeño durante la entrevista:</p>
                          </div>
                          <div class="col-6">
                            <div class="stars" id="desempenoStars"></div>
                            <input type="hidden" name="pregunta[]" value="Desempeño durante la entrevista">
                            <input type="hidden" name="valoracion[]" id="desempenoRating" value="0">
                          </div>
                        </div>
                    </div>

                    <div class="question">
                        <div class="row">
                          <div class="col-6">
                            <p>Experiencia adecuada:</p>
                          </div>
                          <div class="col-6">
                            <div class="stars" id="exp2Stars"></div>
                            <input type="hidden" name="pregunta[]" value="Experiencia adecuada">
                            <input type="hidden" name="valoracion[]" id="exp2Rating" value="0">
                          </div>
                        </div>
                    </div>

                    <div class="question">
                      <div class="row">
                        <div class="col-6">
                          <p>Habilidades técnicas:</p>
                        </div>
                        <div class="col-6">
                          <div class="stars" id="techSkills2Stars"></div>
                          <input type="hidden" name="pregunta[]" value="Habilidades técnicas">
                          <input type="hidden" name="valoracion[]" id="techSkills2Rating" value="0">
                        </div>
                      </div>
                    </div>

                    <div class="question">
                      <div class="row">
                        <div class="col-6">
                          <p>Ubicación geográfica:</p>
                        </div>
                        <div class="col-6">
                          <div class="stars" id="location2Stars"></div>
                          <input type="hidden" name="pregunta[]" value="Ubicación geográfica">
                          <input type="hidden" name="valoracion[]" id="location2Rating" value="0">
                        </div>
                      </div>
                    </div>


                    <div class="question">
                      <div class="row">
                        <div class="col-6">
                          <p>Estabilidad laboral:</p>
                        </div>
                        <div class="col-6">
                          <div class="stars" id="jobStability2Stars"></div>
                          <input type="hidden" name="pregunta[]" value="Estabilidad laboral">
                          <input type="hidden" name="valoracion[]" id="jobStability2Rating" value="0">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                    <input type="hidden" name="company_id" value="{{ $vacante->company_id }}">
                    <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                    <input type="hidden" name="etapa" value="Entrevista">
                    <input type="hidden" name="perfil" value="{{ auth()->user()->rol }}">
                    <button type="submit" class="btn btn-info">Enviar calificaciones</button>
                </form>
               @endif



              </div>
              <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('apruebaestatus') }}" method="post">
                        @csrf
                        <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                        <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                        <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                        <?php $suma=0; $estilo="display:none;"; ?>
                        @foreach($procesos as $proc)
                          @if($proc->estatus=='Aprobado')
                          <?php $suma++; ?>
                          @endif
                        @endforeach
                        @if($suma>1)
                        <?php $estilo="display:block;"; ?>
                        @else
                        <?php $estilo="display:none;"; ?>
                        @endif

                        <textarea name="comentarios" class="form-control" placeholder="Comentarios">{{ buscarcomentarios($proc->candidato_id , $vacante->id) ?? '' }}</textarea>
                        <button type="submit" class="btn btn-info btn-sm" name="button">Aprobar candidato</button>
                      </form>
                    </div>
                    <div class="col-md-6">
                      <form class="" action="{{ route('rechazar_candidato') }}" method="post">
                        @csrf
                        <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                        <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                        <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                        <button type="submit" class="btn btn-danger btn-sm" name="button">Rechazar candidato</button>
                      </form>
                    </div>
                  </div>
                  <div class="row">
                    <br>
                    <div class="col-md-12">
                      <form class="" action="{{ route('prioridad') }}" method="post" style="display:none;">
                        @csrf
                        <table class="table" style="{{ $estilo }}">
                          <tr>
                            <th>Prioridad</th>
                            <th>Candidato</th>
                          </tr>
                          @foreach($procesos as $proc)
                            @if($proc->estatus=='Aprobado')
                            <tr>
                              <td>
                                <select class="form-control" name="prioridad[]">
                                  <option value="{{ $proc->prioridad }}">{{ $proc->prioridad }}</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                </select>
                              </td>
                              <td> <input type="hidden" name="idcand[]" value="{{ $proc->candidato_id }}"> {{ candidato($proc->candidato_id)  }}</td>
                            </tr>
                            @endif
                          @endforeach

                        </table>
                        <br>
                        <input type="hidden" name="vacante_id" value="{{ $vacante->id }}">
                        <input type="hidden" name="proceso_id" value="{{ $procesoinfo->id }}">
                        <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                        <button type="submit" class="btn btn-info" name="button">Priorizar candidatos</button>
                      </form>

                    </div>
                  </div>
              </div>
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
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>

        <div class="tab d-none">
          @if($procesoinfo->estatus_entrevista=='aprobado')

          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
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
          @else
          <div class="alert alert-contenido text-center">
            <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
          </div>
          @endif
        </div>

        <div class="tab d-none">
          @if($procesoinfo->estatus_entrevista=='aprobado')
          <form class="" action="{{ route('proponer_ingreso') }}" method="post">
            @csrf
            <h4>Proponer fecha para ingreso del candidato</h4>
            <br>
            <br>
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


            <input type="hidden" name="candidato_id" value="{{ $candidato }}">
            <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">

            <input type='submit' class='btn btn-info btn-fill' />

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
