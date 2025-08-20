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
      </style>

    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-start">
                  <div class="card-body">

                    <div class="row">
                      <div class="col-md-8">

                        <form action="{{ route('postular_candidatos') }}" method="post">
                          @csrf
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
                          <br>
                          <p>Candidato 1</p>
                          <select name="candidato1" >
                            <option></option>
                            @foreach($candidatos as $cand)
                              <option value="{{ $cand->id }}" style="margin-left:3px!important;">{{ $cand->nombre.' '.$cand->apellido_paterno.' '.$cand->apellido_materno }}</option>
                            @endforeach
                          </select>
                          <br>
                          <br>
                          <p>Candidato 2</p>
                          <select name="candidato2" >
                            <option></option>
                            @foreach($candidatos as $cand)
                              <option value="{{ $cand->id }}" style="margin-left:3px!important;">{{ $cand->nombre.' '.$cand->apellido_paterno.' '.$cand->apellido_materno }}</option>
                            @endforeach
                          </select>
                          <br>
                          <br>
                          <p>Candidato 3</p>
                          <select name="candidato3" >
                            <option></option>
                            @foreach($candidatos as $cand)
                              <option value="{{ $cand->id }}" style="margin-left:3px!important;">{{ $cand->nombre.' '.$cand->apellido_paterno.' '.$cand->apellido_materno }}</option>
                            @endforeach
                          </select>
                          <br>
                          <br>
                          <p>Comentarios</p>
                          <textarea name="comentarios" class="form-control" style="resize:none;"></textarea>
                          <br>
                          <button type="submit" class="btn btn-success">Postular candidatos</button>
                        </form>
                        <!--
                        <form class="" action="{{ route('cubrirvacante') }}" method="post">
                          @csrf
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
                          <p>Nuevo colaborador:</p>
                          <select name="colaborador_id" >
                            <option></option>
                            @foreach($colaboradores as $col)
                              <option value="{{ $col->id }}" style="margin-left:3px!important;">{{ qcolab($col->id) }}</option>
                            @endforeach
                          </select>
                          <br>
                          <input type="hidden" name="idvacante" value="{{ $vacante->id }}">
                          <div class="" style="height:50px;">

                          </div>
                          <button type="submit" class="btn btn-success">Actualizar</button>
                        </form>
                       -->
                      </div>
                    </div>


                  </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.footer')
