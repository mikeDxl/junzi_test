<section class="mt-4">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-12 text-right">

            <!-- Button trigger modal -->
              <button type="button" class="btn btn-link text-danger" data-bs-toggle="modal" data-bs-target="#exampleModalRechazo">
                Rechazar
              </button>

              <!-- Modal -->
              <div class="modal fade" id="exampleModalRechazo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('rechazar_candidato') }}" method="post">
                            @csrf
                            <input type="hidden" name="candidato_id" value="{{ $candidato }}">
                            <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                            <input type="hidden" name="estatus" value="Rechazado">
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
                                <label id="label_option_1_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">No cumple con los requisitos demográficos<input type="checkbox" name="motivorechazo[]" value="No cumple con los requisitos demográficos" id="radio_option_1_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                <label id="label_option_2_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">Ubicación geográfica incompatible<input type="checkbox" name="motivorechazo[]" value="Ubicación geográfica incompatible" id="radio_option_2_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                <label id="label_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">Falta de experiencia laboral<input type="checkbox" name="motivorechazo[]" value="Falta de experiencia laboral" id="radio_option_3_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                <label id="label_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">Poca permanencia en trabajos anteriores<input type="checkbox" name="motivorechazo[]" value="Poca permanencia en trabajos anteriores" id="radio_option_4_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                <label id="label_option_5_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">No hay claridad en sus actividades laborales realizadas<input type="checkbox" name="motivorechazo[]" value="No hay claridad en sus actividades laborales realizadas" id="radio_option_5_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                                <label id="label_option_6_{{ $vacante_id }}_{{ $proc->candidato_id }}" onclick="radioOption(this.id , 'option_{{ $vacante_id }}_{{ $proc->candidato_id }}');" class="rating-option option_{{ $vacante_id }}_{{ $proc->candidato_id }}">Enfoque laboral no deseado<input type="checkbox" name="motivorechazo[]" value="Enfoque laboral no deseado" id="radio_option_6_{{ $vacante_id }}_{{ $proc->candidato_id }}" style="display:none;"></label>
                              </div>
                            </div>
                            <p> <br> </p>
                            <button type="submit" class="btn btn-sm btn-danger" name="button">Rechazar candidato</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
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
          <iframe src="/storage/app/public/{{ $procesoinfo->curriculum }}#zoom=100&navpanes=0&view=FitH" width="100%" height="600"></iframe>


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

             @if($procesoinfo->entrevista2_fecha)
             <div class="col-md-12">
               <p>La fecha de la entrevista es: {{ $procesoinfo->entrevista2_fecha.' '.$procesoinfo->entrevista2_hora }} <span> <button type="button" class="btn btn-link" name="button"> <i class="fa fa-edit"></i> Cambiar Fechas</button> </span> </p>
               <br>
             </div>
             @endif
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
                       <option value="18:00">18:00</option>
                       <option value="18:30">18:30</option>
                       <option value="19:00">19:00</option>
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
              <div class="col-md-4">

              </div>
              <div class="col-md-4">
                @if($procesoinfo->estatus_proceso!='Rechazado')
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
                    <table class="table" style="{{ $estilo }}">
                      <tr>
                        <th>Prioridad</th>
                        <th>Candidato</th>
                      </tr>
                      @foreach($procesos as $proc)
                        @if($proc->estatus=='Aprobado')
                        <tr>
                          <td>
                            <select class="form-control" name="prioridad">
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
                    <textarea name="comentarios" class="form-control" placeholder="Comentarios">{{ buscarcomentarios($proc->candidato_id , $vacante->id) ?? '' }}</textarea>
                    <button type="submit" class="btn btn-info btn-sm" name="button">Aprobar candidato</button>
                  </form>
                @else
                <div class="alert alert-contenido text-center">
                  <i class="fa fa-lock" aria-hidden="true"></i> Contenido no disponible
                </div>
                @endif
              </div>
              <div class="col-md-4">

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

            <div class="row justify-content-center">

              <div class="col-md-12 text-center">

                <p> <br> </p>
                @if(buscarexamen($candidato , $vacante->id)!="")
                <a class="btn bnt-info btn-sm" target="_blank" href="/storage/app/public/{{ buscarexamen($candidato , $vacante->id) }}" class="btn btn-primary">Descargar Resultado</a>
                <br>

                @endif
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
                  <div class="col-md-4">
                    Identificación
                  </div>
                  <div class="col-md-4">
                    @if(buscardocumento1($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento1($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-4">
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
                </div>

                <div class="row">
                  <div class="col-md-4">
                    Comprobante de domicilio
                  </div>
                  <div class="col-md-4">
                    @if(buscardocumento2($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento2($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-4">
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
                </div>

                <div class="row">
                  <div class="col-md-4">
                    CURP
                  </div>
                  <div class="col-md-4">
                    @if(buscardocumento3($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento3($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-4">
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
                </div>

                <div class="row">
                  <div class="col-md-4">
                    Acta de nacimiento
                  </div>
                  <div class="col-md-4">
                    @if(buscardocumento4($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento4($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-4">
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
                </div>

                <div class="row">
                  <div class="col-md-4">
                    IMSS
                  </div>
                  <div class="col-md-4">
                    @if(buscardocumento5($candidato , $vacante->id)!="")

                    <a target="_blank" href="/storage/app/public/{{ buscardocumento5($candidato , $vacante->id) }}"> Descargar </a>

                    @endif
                  </div>
                  <div class="col-md-4">
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
            @if (fechajefatura($candidato, $vacante->id) !== null && fechajefatura($candidato, $vacante->id) !== '' &&
                fechajefatura($candidato, $vacante->id) == fechanomina($candidato, $vacante->id))
            <form class="" action="{{ route('contratar_colaborador') }}" method="post">
              @csrf
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="tim-icons icon-single-02"></i>
                  </div>
                </div>
                <input type="date" min="{{ date('Y-m-d') }}" name="fecha_alta" class="form-control" placeholder="Fecha" value="{{ fechanomina($proc->candidato_id , $vacante->id) }}">
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
                <input type="date" min="{{ date('Y-m-d') }}" name="fecha_jefatura" class="form-control" placeholder="Fecha" readonly value="{{ fechajefatura($proc->candidato_id , $vacante->id) }}">
              </div>
              <p>Fecha Nómina</p>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="tim-icons icon-single-02"></i>
                  </div>
                </div>
                <input type="date" min="{{ date('Y-m-d') }}" name="fecha_nomina" class="form-control" placeholder="Fecha" value="{{ fechanomina($proc->candidato_id , $vacante->id) }}">
              </div>



              <input type="hidden" name="candidato_id" value="{{ $candidato }}">
              <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">

              <input type='submit' class='btn btn-info btn-fill' />

            </form>
            @endif
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
