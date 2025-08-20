@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Organigrama')])

@section('content')

<style media="screen">
.direccion_v {
  writing-mode: vertical-lr!important;
  transform: rotate(180deg)!important;
  width: 50px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 2px;
}

td a{ color: #3358f4!important;}
 td { height: 120px; width: 120px; border: none!important;}

.capsulaadd{
    border: 1px dotted #3358f4!important;
    padding: 10px;
    height: 100%; width: 100%;
    background:none!important;
    border-radius: 10px!important;
    text-align: center;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
  }
.centered-content {
    text-align: center; /* Centrar horizontalmente el contenido */
  }

.capsula1top{
    border: 3px solid #fff!important;
    padding: 10px; background:#1A006B!important;
    border-radius: 10px!important;
    height: 100%; width: 100%;
    text-align: center;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff!important;
    margin: 5px;
}

.capsula1{
  border: 3px solid #fff!important;
  padding: 10px; background:#3358f4!important;
  border-radius: 10px!important;
  height: 100%; width: 100%;
  text-align: center;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff!important;
  margin: 5px;
}
.capsula1 a{ color:#f5f5f5!important;}
.capsula1 p{ color:#f5f5f5!important;}
.capsula2{ border: 1px solid #900C3F!important; padding: 10px; background:#900C3F!important; border-radius: 10px!important; height: 100px; text-align: center;}
.capsula2 a{ color:#f5f5f5!important;}
.capsula2 p{ color:#f5f5f5!important;}

  [id^="eliminar"] {
    display: none;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
  }

  [id^="elemento"]:hover [id^="eliminar"] {
    display: block;
  }
</style>


<?php
$colspan=3;

if ($count_h>=3) {
  $colspan=$count_h+1;
}else {
  $colspan=3;
}

$rowspan=2;

if ($count_v>=2) {
  $rowspan=$count_v+1;
}else {
  $rowspan=2;
}
 ?>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h2 class="card-title text-center">Organigrama Matricial</h2>
              </div>
              <div class="card-body">

                <div class="row">
                    <div class="col-md-12 table-responsive">
                      <table class="table table-bordered table-stripped">
                        <tbody>
                          <tr>
                            <td>
                              @if($matricial->esquina)
                              <a href="organigrama-lineal/{{ $matricial->esquina }}" class="capsula1top">
                                <div class="centered-content">
                                  {{ nombrecc($matricial->esquina) }}
                                </div>
                              </a>
                              @else
                                @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
                                <label for="DireccionE" class="capsulaadd">
                                  <form action="" method="post" class="centered-content">
                                    @csrf
                                    <button type="button" id="DireccionE" data-bs-toggle="modal" data-bs-target="#modalDireccionE" class="btn btn-link" name="button"> <i class="fa fa-plus "></i> </button>
                                  </form>
                                </label>
                                @endif
                              @endif
                            </td>
                            <td colspan="{{ $colspan }}">
                              @if($matricial->horizontal)
                              <a href="organigrama-lineal/{{ $matricial->horizontal }}" class="capsula1top">
                                <div class="centered-content">
                                  {{ nombrecc($matricial->horizontal) }}
                                </div>
                              </a>
                              @else
                                @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
                                <label for="DireccionH" class="capsulaadd">
                                  <form action="" method="post" class="centered-content">
                                    @csrf
                                    <button type="button" id="DireccionH" data-bs-toggle="modal" data-bs-target="#modalDireccionH" class="btn btn-link" name="button"> <i class="fa fa-plus "></i> </button>
                                  </form>
                                </label>
                                @endif
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td rowspan="{{ $rowspan }}">
                              @if($matricial->vertical)
                              <a href="organigrama-lineal/{{ $matricial->vertical }}" class="capsula1top">
                                <div class="centered-content">
                                  {{ nombrecc($matricial->vertical) }}
                                </div>
                              </a>
                              @else
                                @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
                                <label for="DireccionV" class="capsulaadd">
                                  <form action="" method="post" class="centered-content">
                                    @csrf
                                    <button type="button" id="DireccionV" data-bs-toggle="modal" data-bs-target="#modalDireccionV" class="btn btn-link" name="button"> <i class="fa fa-plus "></i> </button>
                                  </form>
                                </label>
                                @endif
                              @endif
                            </td>
                            <td>
                              @if($matricial->horizontal || $matricial->vertical)
                                @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
                                <label for="addCC" class="capsulaadd">
                                  <form action="" method="post" class="centered-content">
                                    @csrf
                                    <button type="button" id="addCC" data-bs-toggle="modal" data-bs-target="#modaladdCC" class="btn btn-link" name="button"> <i class="fa fa-plus "></i> </button>
                                  </form>
                                </label>
                                @endif
                              @endif
                            </td>
                            <!-- aquí va inicia hacia la derecha -->

                            @foreach($agrupadores_h as $ah)
                            <td>
                              <a href="organigrama-lineal/{{ $ah->agrupador_id }}" class="capsula1">
                                {{ $ah->nombre }}
                              </a>
                            </td>
                            @endforeach
                            <!-- aquí va termina hacia la derecha -->
                          </tr>
                          @if($count_v>=1)
                          @foreach($agrupadores_v as $av)
                          <tr>
                            <td>
                              <a href="organigrama-lineal/{{ $av->agrupador_id }}" class="capsula1">
                                {{ $av->nombre }}
                              </a>
                            </td>
                            <td colspan="{{ $colspan-1 }}"></td>
                          </tr>
                          @endforeach
                          @else
                          <tr>
                            <td></td>
                            <td colspan="{{ $colspan-1 }}"></td>
                          </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalDireccionH" tabindex="-1" aria-labelledby="modalDireccionHLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <form action="{{ route('matricialh') }}" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 text-center">
                  <h4>Agrega un centro de costo para la parte superior del organigrama</h4>
                  <br>

                  <div class="form-group">
                    <label for="">Centro de costo</label>
                    <select class="form-control" name="cc" required>
                      <option value="">Selecciona una opción</option>
                      @foreach($centros_de_costos as $cc)
                       @if($cc->centro_de_costo!="")<option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>@endif
                      @endforeach
                    </select>
                  </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal fade" id="modalDireccionV" tabindex="-1" aria-labelledby="modalDireccionVLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-dialog modal-sm">
        <form action="{{ route('matricialv') }}" method="post">
          @csrf
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 text-center">

                    <h4>Agrega un centro de costo para la parte lateral del organigrama</h4>
                    <br>
                    <div class="form-group">
                      <label for="">Centro de costo</label>
                      <select class="form-control" name="cc" required>
                        <option value="">Selecciona una opción</option>
                        @foreach($centros_de_costos as $cc)
                           @if($cc->centro_de_costo!="")<option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>@endif
                        @endforeach
                      </select>
                    </div>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-info">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalDireccionE" tabindex="-1" aria-labelledby="modalDireccionELabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-dialog modal-sm">
        <form action="{{ route('matriciale') }}" method="post">
          @csrf
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 text-center">
                    <h4>Agrega un centro de costo para la esquina del organigrama</h4>
                    <br>
                    <div class="form-group">
                      <label for="">Centro de costo</label>
                      <select class="form-control" name="cc" required>
                        <option value="">Selecciona una opción</option>
                        @foreach($centros_de_costos as $cc)
                         @if($cc->centro_de_costo!="")<option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>@endif
                        @endforeach
                      </select>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-info">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modaladdCC" tabindex="-1" aria-labelledby="modaladdCC" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <form action="{{ route('matricial') }}" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 text-center">
                <h4>Agrega un centro de costo al organigrama</h4>
                <br>
                <div class="form-group">
                  <label for="">Dirección:</label>
                  <select class="form-control" name="orientacion" required>
                    <option value="">Selecciona una opción</option>
                    @if($matricial->horizontal)
                    <option value="horizontal">{{ nombrecc($matricial->horizontal) }}</option>
                    @endif
                    @if($matricial->vertical)
                    <option value="vertical">{{ nombrecc($matricial->vertical) }}</option>
                    @endif
                  </select>
                </div>
                <br>
                <div class="form-group">
                  <label for="">Centro de costo</label>
                  <select class="form-control" name="cc" required>
                    <option value="">Selecciona una opción</option>
                    @foreach($centros_de_costos as $cc)
                     @if($cc->centro_de_costo!="")<option value="{{ $cc->id }}">{{ $cc->centro_de_costo }}</option>@endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal fade" id="modaldelCC" tabindex="-1" aria-labelledby="modaldelCC" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <form action="" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('js')
@endpush
