@include('layouts.header')
<body class="text-start">
      @include('layouts.menu')
    <div class="main-content">
      <div class="breadcrumb">
        <h1>Vacante</h1>
      </div>

      <div class="separator-breadcrumb border-top"></div>
      <style media="screen">
        select{ width: 100%;}
        textarea{ resize: none;}
      </style>

    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-start">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <p>Puesto: {{ puestosid($vacante->puesto_id) }}</p>
                        <input type="hidden" name="puesto" value="{{ $vacante->puesto_id }}">
                        <p>Departamento: {{ $vacante->area }}</p>
                        <input type="hidden" name="area" value="{{ $vacante->area }}">
                        <p>Fecha: {{ formatFecha($vacante->fecha) }}</p>
                        <p>Jefe directo: {{ qcolab($vacante->jefe) ?? 'Sin asignar' }}</p>
                        @if($vacante->jefe == null)
                        <select name="jefe_directo">
                          <option></option>
                          @foreach($colaboradores as $col)
                            <option value="{{ $col->id }}" style="margin-left:3px!important;">{{ qcolab($col->id) }}</option>
                          @endforeach
                        </select>
                        @else
                        <input type="hidden" name="jefe_directo" value="{{ $vacante->jefe }}">
                        @endif
                        <br>
                      </div>
                    </div>
                    <div class="">
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="false">Candidato 1</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Candidato 2</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Candidato 3</button>
                        <button class="nav-link active" id="nav-add-tab" data-bs-toggle="tab" data-bs-target="#nav-add" type="button" role="tab" aria-controls="nav-add" aria-selected="true">Agregar</button>
                      </div>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                          <div class="" style="margin:0px!important; padding:0px!important;">
                            <div class="row">
                              <div class="col-md-3" style="margin:0px!important; padding:0px!important;">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                  <a class="nav-link active" id="v-pills-cv-tab-1" data-bs-toggle="pill" href="#v-pills-cv-1" role="tab" aria-controls="v-pills-cv-1" aria-selected="true">CV</a>
                                  <a class="nav-link" id="v-pills-coordinar-tab-1" data-bs-toggle="pill" href="#v-pills-coordinar-1" role="tab" aria-controls="v-pills-coordinar-1" aria-selected="true">Coordinar entrevista</a>
                                  <a class="nav-link" id="v-pills-programar-tab-1" data-bs-toggle="pill" href="#v-pills-programar-1" role="tab" aria-controls="v-pills-programar-1" aria-selected="false">Programar entrevista</a>
                                  <a class="nav-link" id="v-pills-comentarios-tab-1" data-bs-toggle="pill" href="#v-pills-comentarios-1" role="tab" aria-controls="v-pills-comentarios-1" aria-selected="false">Comentarios y observaciones</a>
                                  <a class="nav-link" id="v-pills-referencias-tab-1" data-bs-toggle="pill" href="#v-pills-referencias-1" role="tab" aria-controls="v-pills-referencias-1" aria-selected="false">Referencias</a>
                                  <a class="nav-link" id="v-pills-examen-tab-1" data-bs-toggle="pill" href="#v-pills-examen-1" role="tab" aria-controls="v-pills-examen-1" aria-selected="false">Examen psicométrico</a>
                                  <a class="nav-link" id="v-pills-documentacion-tab-1" data-bs-toggle="pill" href="#v-pills-documentacion-1" role="tab" aria-controls="v-pills-documentacion-1" aria-selected="false">Documentación</a>
                                  <a class="nav-link" id="v-pills-contratacion-tab-1" data-bs-toggle="pill" href="#v-pills-contratacion-1" role="tab" aria-controls="v-pills-contratacion-1" aria-selected="false">Contratación</a>
                                </div>
                              </div>
                              <div class="col-md-9" style="border: 1px solid #ddd;">
                                <div class="tab-content" id="v-pills-tabContent">
                                  <div class="tab-pane fade show active" id="v-pills-cv-1" role="tabpanel" aria-labelledby="v-pills-cv-tab-1">
                                    <iframe src="http://127.0.0.1:8000/storage/vacantes/1/candidatos/1/cv1.pdf" width="100%" height="500px"></iframe>
                                  </div>
                                  <div class="tab-pane fade" id="v-pills-coordinar-1" role="tabpanel" aria-labelledby="v-pills-coordinar-tab-1">
                                    <form class="" action="index.html" method="post">
                                      <div class="form-group">
                                        <label for="">Coordinar entrevista</label>
                                        <br>
                                      <div class="row">
                                        <div class="col-md-4">
                                          <label for="">Opción 1</label>
                                          <input type="date" name="" value="" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                          <label for="">Opción 2</label>
                                          <input type="date" name="" value="" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                          <label for="">Opción 3</label>
                                          <input type="date" name="" value="" class="form-control">
                                        </div>
                                      </div>
                                      </div>
                                      <br>
                                      <div class="form-group">
                                        <label for="">Comentarios</label>
                                        <textarea name="comentarios" class="form-control"></textarea>
                                      </div>
                                      <br>
                                      <button type="button" class="btn btn-primary" name="button">Guardar</button>
                                    </form>
                                  </div>
                                  <div class="tab-pane fade" id="v-pills-programar-1" role="tabpanel" aria-labelledby="v-pills-programar-tab-1">
                                    <form class="" action="index.html" method="post">
                                      <div class="form-group">
                                        <label for="">Fecha de entrevista</label>
                                        <input type="date" class="form-control" name="" value="">
                                      </div>
                                      <br>
                                      <div class="form-group">
                                        <label for="">Comentarios</label>
                                        <textarea name="comentarios" class="form-control"></textarea>
                                      </div>
                                      <br>
                                      <button type="button" class="btn btn-primary" name="button">Guardar</button>
                                    </form>
                                  </div>
                                  <div class="tab-pane fade" id="v-pills-comentarios-1" role="tabpanel" aria-labelledby="v-pills-comentarios-tab-1">
                                    <form class="" action="index.html" method="post">

                                      <div class="form-group">
                                        <label for="">Comentarios</label>
                                        <textarea name="comentarios" class="form-control" style="height:250px;"></textarea>
                                      </div>
                                      <br>
                                      <button type="button" class="btn btn-primary" name="button">Guardar</button>
                                    </form>
                                  </div>
                                  <div class="tab-pane fade" id="v-pills-referencias-1" role="tabpanel" aria-labelledby="v-pills-referencias-tab-1">
                                    <form class="" action="index.html" method="post">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="">Nombre</label>
                                            <input type="text" class="form-control" name="" value="">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="">Teléfono</label>
                                            <input type="text" class="form-control" name="" value="">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="">Nombre</label>
                                            <input type="text" class="form-control" name="" value="">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="">Teléfono</label>
                                            <input type="text" class="form-control" name="" value="">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="">Comentarios</label>
                                        <textarea name="comentarios" class="form-control"></textarea>
                                      </div>
                                      <br>
                                      <button type="button" class="btn btn-primary" name="button">Guardar</button>
                                    </form>
                                  </div>
                                  <div class="tab-pane fade" id="v-pills-examen-1" role="tabpanel" aria-labelledby="v-pills-examen-tab-1">
                                    <form class="" action="index.html" method="post">
                                      <div class="form-group">
                                        <label for="">Link</label>
                                        <input type="url" class="form-control" name="" value="">
                                      </div>
                                      <br>
                                      <div class="form-group">
                                        <label for="">Resultado</label>
                                        <input type="text" class="form-control" name="" value="">
                                      </div>
                                      <br>
                                      <div class="form-group">
                                        <label for="">Comentarios</label>
                                        <textarea name="name" class="form-control" ></textarea>
                                      </div>
                                      <br>
                                      <button type="button" class="btn btn-primary" name="button">Guardar</button>
                                    </form>
                                  </div>
                                  <div class="tab-pane fade" id="v-pills-documentacion-1" role="tabpanel" aria-labelledby="v-pills-documentacion-tab-1">
                                    <form class="" action="index.html" method="post" enctype="multipart/form-data">


                                      <div class="row">
                                        <div class="col-md-5">
                                          <div class="form-group">
                                            <label for="">Nombre del documento</label>
                                            <input type="text" name="" value="" placeholder="Identificación" class="form-control">
                                          </div>
                                        </div>
                                        <div class="col-md-7">
                                          <div class="form-group">
                                            <label for="">Documento</label>
                                            <input type="file" name="" value=""  class="form-control">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-5">
                                          <div class="form-group">
                                            <label for="">Nombre del documento</label>
                                            <input type="text" name="" value="" placeholder="Comprobante de domicilio" class="form-control">
                                          </div>
                                        </div>
                                        <div class="col-md-7">
                                          <div class="form-group">
                                            <label for="">Documento</label>
                                            <input type="file" name="" value=""   class="form-control">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-5">
                                          <div class="form-group">
                                            <label for="">Nombre del documento</label>
                                            <input type="text" name="" value="" placeholder="Curp" class="form-control">
                                          </div>
                                        </div>
                                        <div class="col-md-7">
                                          <div class="form-group">
                                            <label for="">Documento</label>
                                            <input type="file" name="" value="" class="form-control">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-5">
                                          <div class="form-group">
                                            <label for="">Nombre del documento</label>
                                            <input type="text" name="" value="" placeholder="otro" class="form-control">
                                          </div>
                                        </div>
                                        <div class="col-md-7">
                                          <div class="form-group">
                                            <label for="">Documento</label>
                                            <input type="file" name="" value="" class="form-control">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-5">
                                          <div class="form-group">
                                            <label for="">Nombre del documento</label>
                                            <input type="text" name="" value="" placeholder="otro" class="form-control">
                                          </div>
                                        </div>
                                        <div class="col-md-7">
                                          <div class="form-group">
                                            <label for="">Documento</label>
                                            <input type="file" name="" value="" class="form-control">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="">Comentarios</label>
                                        <textarea name="comentarios" class="form-control"></textarea>
                                      </div>
                                      <br>
                                      <button type="button" class="btn btn-primary" name="button">Guardar</button>
                                    </form>
                                  </div>
                                  <div class="tab-pane fade" id="v-pills-contratacion-1" role="tabpanel" aria-labelledby="v-pills-contratacion-tab-1">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <form class="" action="index.html" method="post">
                                          <div class="form-group">
                                            <label for="">Contratar al candidato</label>
                                          </div>
                                          <br>
                                          <button type="button" class="btn btn-primary" name="button">Contratar</button>
                                        </form>
                                      </div>
                                      <div class="col-md-6">
                                        <form class="" action="index.html" method="post">
                                          <div class="form-group">
                                            <label for="">Comentarios</label>
                                            <textarea name="comentarios" class="form-control"></textarea>
                                          </div>
                                          <br>
                                          <p>Aquí va la encuesta</p>
                                          <br>
                                          <button type="button" class="btn btn-primary" name="button">Rechazar</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">





                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                        </div>
                        <div class="tab-pane fade show active" id="nav-add" role="tabpanel" aria-labelledby="nav-add-tab">
                          <div class="row">
                            <div class="col-md-8">
                              <form action="{{ route('postular_candidatos') }}" method="post">
                                @csrf
                                <input type="hidden" name="puesto" value="{{ $vacante->puesto_id }}">
                                <input type="hidden" name="area" value="{{ $vacante->area }}">
                                @if($vacante->jefe == null)
                                <select name="jefe_directo">
                                  <option></option>
                                  @foreach($colaboradores as $col)
                                    <option value="{{ $col->id }}" style="margin-left:3px!important;">{{ qcolab($col->id) }}</option>
                                  @endforeach
                                </select>
                                @else
                                <input type="hidden" name="jefe_directo" value="{{ $vacante->jefe }}">
                                @endif
                                <br>
                                <select name="candidato">
                                  <option></option>
                                  @foreach($candidatos as $cand)
                                    <option value="{{ $cand->id }}" style="margin-left:3px!important;">{{ $cand->nombre.' '.$cand->apellido_paterno.' '.$cand->apellido_materno }}</option>
                                  @endforeach
                                </select>
                                <br>
                                <div class="" style="height:50px;">

                                </div>
                                <button type="submit" class="btn btn-success">Postular candidato</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.footer')
