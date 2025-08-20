@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Organigrama')])

@section('content')
<style media="screen">
.panel-header2 {
  height: 60px;
  background: #fff;
  background: none;
  position: relative;
  overflow: hidden;
}
</style>
<?php
use App\Models\OrganigramaLinealNiveles;

$niv1=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','1')->count();
$niv2=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','2')->count();
$niv3=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','3')->count();
$niv4=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','4')->count();
$niv5=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','5')->count();
$niv6=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','6')->count();
$niv7=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','7')->count();
$niv8=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','8')->count();
$niv9=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','9')->count();
$niv10=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)->where('nivel','10')->count();
$med=180;
$niv=($niv1*$med)+($niv2*$med)+($niv3*$med)+($niv4*$med)+($niv5*$med)+($niv6*$med)+($niv7*$med)+($niv8*$med)+($niv9*$med)+($niv10*$med);

$niveles=$lineal->niveles;

 ?>

<div class="row">
  <div class="col-md-3">

  </div>
  <div class="col-md-9">
    <div class="main-content">
      <div class="breadcrumb">
        <a href="/organigrama"><h1> <i class="fa fa-arrow-left"></i> Organigrama</h1></a>

      </div>
      <h2> <a href="/organigrama"> <button type="button" class="btn btn-link" name="button"> <i class="fa fa-chevron-left"></i> </button> </a> {{ $area }} </h2>


      <div class="row">
        <div class="col-md-11 text-right">
          <button type="button" class="btn btn-info btn-sm" name="button"><a href="/ver-organigrama/{{ $area }}" style="color:#fff;">Ver tabla <i class="fa fa-table"></i> </a></button>
        </div>
      </div>


      <style media="screen">

        .select2-container {
            width: 350px;
          }
        .panel{ margin-bottom: 50px; }
        .scroll{ overflow-x: scroll; min-height: 200px; max-height: auto;}
        .scroll2{ overflow-x: scroll; height: auto;}
        .colnivel{ border-right:1px solid #ddd; max-width:350px!important; min-height: 200px;}
        .labelorganigrama{
          padding: 10px;
          width: 160px;
          height: 150px;
          overflow: hidden;
          white-space: nowrap;
          margin-bottom: 10px;
        }

        .select2--large{
           font-size:10px!important;
         }

         .colab-org{ font-size: 10px;
           width: 200px;
           border-radius: 10px;
           border: 1px solid #ddd;
           padding: 8px;
           margin-bottom: 10px;
         }
         .contenedor {
              display: flex;
              flex-direction: column;
              justify-content: top; /* Centrado horizontal */
              align-items: center; /* Centrado vertical */
              /* Otros estilos para el contenedor si los deseas */
            }

            .div_organigrama{ overflow-x: scroll; width: auto;}
            .organigrama-container {
                overflow-x: auto; /* Permite el desplazamiento horizontal */
                white-space: nowrap; /* Evita el salto de línea de los elementos */
              }
             .btn-outline-primary , .btn-outline-info , .btn-outline-danger{ background: #f5f5f5; }
             .btn-outline-primary:hover , .btn-outline-info:hover , .btn-outline-danger:hover{ background: #f5f5f5; }

      </style>
      <?php
      $niveles=$lineal->niveles;
      $ancho=350*$niveles;
       ?>

    <div class="separator-breadcrumb border-top"></div>


    <div class="div_organigrama">



    <section class="" style="width: {{$niv}}px;">


      @if($niv1==0)
      <div class="row">
        <div class="col-md-12 text-center" >
          <div class="colab-org text-center dropzone" >
            <img src="{{ auth()->user()->profilePicture() }}" alt="" style="height:60px;">
            <br>
            <span>Colaborador no asignado en nivel 1</span>
            <div style="margin:5px;" >
              <div class="text-center">
                  <div class="btn-group">
                    <a class="btn btn-outline-primary btn-sm text-center" data-bs-toggle="modal" data-bs-target="#modalPanel4" > <i class="fa fa-user"></i> </a>
                  </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      @endif





      @for($i=1; $i<=$lineal->niveles; $i++)
      <div class="row">




        @foreach($asignados as $as)

          @if($as->nivel==$i)
            @if($i==1)
            <div class="col text-center contenedor">
              <div class="colab-org text-center dropzone" id="colab{{$as->id}}"  draggable="true" onmouseover="showBtn('btn{{$as->colaborador_id}}')" onmouseout="hideBtn('btn{{$as->colaborador_id}}')">

                <img src="{{ auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                <br>
                <span>{{ qcolabv($as->colaborador_id) }}</span>
                <br><br>
                <b>{{ puestosid($as->puesto) }}</b>
                <div style="margin:5px; display:none;" id="btn{{$as->colaborador_id}}">
                  <div class="text-center">

                      <div class="btn-group">
                        <a class="btn btn-outline-primary btn-sm text-center"  onclick="enviarPrimary('{{ $as->colaborador_id }}' , '{{ $as->nivel }}' , '{{ qcolabv($as->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel1"> <i class="fa fa-arrow-down"></i> </a>
                        <a class="btn btn-outline-info btn-sm text-center"  onclick="enviarInfo('{{ $as->colaborador_id }}' , '{{ $as->nivel }}'  , '{{ qcolabv($as->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2"> <i class="fa fa-arrow-up"></i> </a>
                        <a class="btn btn-outline-danger btn-sm text-center"  onclick="enviarDanger('{{ $as->colaborador_id }}' , '{{ $as->nivel }}' , '{{ qcolabv($as->colaborador_id) }}' , '{{$as->id}}')" data-bs-toggle="modal" data-bs-target="#modalPanel3"> <i class="fa fa-user"></i> </a>
                        <a class="btn btn-outline-danger btn-sm text-center"  onclick="MostrarPanel5('{{ $as->colaborador_id }}' , '{{ $as->id }}' , '{{ qcolabv($as->colaborador_id) }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5"> <i class="fa fa-times"></i> </a>
                      </div>

                  </div>
                </div>
              </div>
            </div>
            @elseif($i==2)

            <div class="col text-center contenedor colnivel2">
              <div class="linea-horizontal"></div> <!-- Línea horizontal -->
              <div class="linea"></div>
              <div class="colab-org text-center dropzone" id="colab{{$as->id}}"  draggable="true" onmouseover="showBtn('btn{{$as->colaborador_id}}')" onmouseout="hideBtn('btn{{$as->colaborador_id}}')">

                <img src="{{ auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                <br>
                <span>{{ qcolabv($as->colaborador_id) }}</span>
                <br><br>

                <b>{{ puestosid($as->puesto) }}</b>
                <div style="margin:5px; display:none;" id="btn{{$as->colaborador_id}}">
                  <div class="text-center">

                      <div class="btn-group">
                        <a class="btn btn-outline-primary btn-sm text-center"  onclick="enviarPrimary('{{ $as->colaborador_id }}' , '{{ $as->nivel }}' , '{{ qcolabv($as->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel1"> <i class="fa fa-arrow-down"></i> </a>
                        <a class="btn btn-outline-info btn-sm text-center"  onclick="enviarInfo('{{ $as->colaborador_id }}' , '{{ $as->nivel }}'  , '{{ qcolabv($as->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2"> <i class="fa fa-arrow-up"></i> </a>
                        <a class="btn btn-outline-danger btn-sm text-center"  onclick="enviarDanger('{{ $as->colaborador_id }}' , '{{ $as->nivel }}' , '{{ qcolabv($as->colaborador_id) }}'  , '{{$as->id}}')" data-bs-toggle="modal" data-bs-target="#modalPanel3"> <i class="fa fa-user"></i> </a>
                        <a class="btn btn-outline-danger btn-sm text-center"  onclick="MostrarPanel5('{{ $as->colaborador_id }}' , '{{ $as->id }}' , '{{ qcolabv($as->colaborador_id) }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5"> <i class="fa fa-times"></i> </a>
                      </div>

                  </div>
                </div>
              </div>
              <div class="">
                <div class="row">
                  <br>
                  <?php
                  $colabs=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)
                  ->where('nivel',$i+1)
                  ->where('jefe_directo_id',$as->colaborador_id)
                  ->get();
                   ?>
                   @if(count($colabs)>0)
                    @foreach($colabs as $ascol)
                    <div class="col text-center contenedor"  >
                      <div class="linea-horizontal"></div> <!-- Línea horizontal -->
                      <div class="linea"></div>
                      <div class="colab-org text-center dropzone" id="colab{{$ascol->id}}"  draggable="true" onmouseover="showBtn('btn{{$ascol->colaborador_id}}')" onmouseout="hideBtn('btn{{$ascol->colaborador_id}}')">
                        <img src="{{ auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                        <br>
                        <span>{{ qcolabv($ascol->colaborador_id) }}</span>
                        <br><br>
                        <b>{{ puestosid($ascol->puesto) }}</b>
                        <div style="margin:5px; display:none;" id="btn{{$ascol->colaborador_id}}">
                          <div class="text-center">

                              <div class="btn-group">
                                <a class="btn btn-outline-primary btn-sm text-center"  onclick="enviarPrimary('{{ $ascol->colaborador_id }}' , '{{ $ascol->nivel }}' , '{{ qcolabv($ascol->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel1"> <i class="fa fa-arrow-down"></i> </a>
                                <a class="btn btn-outline-info btn-sm text-center"  onclick="enviarInfo('{{ $ascol->colaborador_id }}' , '{{ $ascol->nivel }}'  , '{{ qcolabv($ascol->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2"> <i class="fa fa-arrow-up"></i> </a>
                                <a class="btn btn-outline-danger btn-sm text-center"  onclick="enviarDanger('{{ $ascol->colaborador_id }}' , '{{ $ascol->nivel }}' , '{{ qcolabv($ascol->colaborador_id) }}'  , '{{$as->id}}')" data-bs-toggle="modal" data-bs-target="#modalPanel3"> <i class="fa fa-user"></i> </a>
                                <a class="btn btn-outline-danger btn-sm text-center"  onclick="MostrarPanel5('{{ $ascol->colaborador_id }}' , '{{ $ascol->id }}' , '{{ qcolabv($ascol->colaborador_id) }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5"> <i class="fa fa-times"></i> </a>
                              </div>

                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <br>
                        <?php
                        $colabs2=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)
                        ->where('nivel',$i+2)
                        ->where('jefe_directo_id',$ascol->colaborador_id)
                        ->get();
                         ?>
                         @if(count($colabs2)>0)
                          @foreach($colabs2 as $ascol2)
                          <div class="col text-center contenedor"  >
                            <div class="linea"></div>
                            <div class="colab-org text-center dropzone" id="colab{{$ascol2->id}}"  draggable="true" onmouseover="showBtn('btn{{$ascol2->colaborador_id}}')" onmouseout="hideBtn('btn{{$ascol2->colaborador_id}}')">
                              <img src="{{ auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                              <br>
                              <span>{{ qcolabv($ascol2->colaborador_id) }}</span>
                              <br><br>
                              <b>{{ puestosid($ascol2->puesto) }}</b>
                              <br>
                              <div style="margin:5px; display:none;" id="btn{{$ascol2->colaborador_id}}">
                                <div class="text-center">

                                    <div class="btn-group">
                                      <a class="btn btn-outline-primary btn-sm text-center"  onclick="enviarPrimary('{{ $ascol2->colaborador_id }}' , '{{ $ascol2->nivel }}' , '{{ qcolabv($ascol2->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel1" > <i class="fa fa-arrow-down"></i> </a>
                                      <a class="btn btn-outline-info btn-sm text-center"  onclick="enviarInfo('{{ $ascol2->colaborador_id }}' , '{{ $ascol2->nivel }}'  , '{{ qcolabv($ascol2->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2" > <i class="fa fa-arrow-up"></i> </a>
                                      <a class="btn btn-outline-danger btn-sm text-center"  onclick="enviarDanger('{{ $ascol2->colaborador_id }}' , '{{ $ascol2->nivel }}' , '{{ qcolabv($ascol2->colaborador_id) }}'  , '{{$as->id}}')" data-bs-toggle="modal" data-bs-target="#modalPanel3" > <i class="fa fa-user"></i> </a>
                                      <a class="btn btn-outline-danger btn-sm text-center"  onclick="MostrarPanel5('{{ $ascol2->colaborador_id }}' , '{{ $ascol2->id }}' , '{{ qcolabv($ascol2->colaborador_id) }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5" > <i class="fa fa-times"></i> </a>
                                    </div>

                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <br>
                              <?php
                              $colabs3=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)
                              ->where('nivel',$i+3)
                              ->where('jefe_directo_id',$ascol2->colaborador_id)
                              ->get();
                               ?>

                               @if(count($colabs3)>0)
                                @foreach($colabs3 as $ascol3)
                                <div class="col text-center contenedor"  >
                                  <div class="linea"></div>
                                  <div class="colab-org text-center dropzone" id="colab{{$ascol3->id}}"  draggable="true" onmouseover="showBtn('btn{{$ascol3->colaborador_id}}')" onmouseout="hideBtn('btn{{$ascol3->colaborador_id}}')">
                                    <img src="{{ auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                                    <br>
                                    <span>{{ qcolabv($ascol3->colaborador_id) }}</span>
                                    <br><br>
                                    <b>{{ puestosid($ascol3->puesto) }}</b>
                                    <br>
                                    <div style="margin:5px; display:none;" id="btn{{$ascol3->colaborador_id}}">
                                      <div class="text-center">

                                          <div class="btn-group">
                                            <a class="btn btn-outline-primary btn-sm text-center"  onclick="enviarPrimary('{{ $ascol3->colaborador_id }}' , '{{ $ascol3->nivel }}' , '{{ qcolabv($ascol3->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel1"> <i class="fa fa-arrow-down"></i> </a>
                                            <a class="btn btn-outline-info btn-sm text-center"  onclick="enviarInfo('{{ $ascol3->colaborador_id }}' , '{{ $ascol3->nivel }}'  , '{{ qcolabv($ascol3->colaborador_id) }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2"> <i class="fa fa-arrow-up"></i> </a>
                                            <a class="btn btn-outline-danger btn-sm text-center"  onclick="enviarDanger('{{ $ascol3->colaborador_id }}' , '{{ $ascol3->nivel }}' , '{{ qcolabv($ascol3->colaborador_id) }}'  , '{{$as->id}}' )" data-bs-toggle="modal" data-bs-target="#modalPanel3"> <i class="fa fa-user"></i> </a>
                                            <a class="btn btn-outline-danger btn-sm text-center"  onclick="MostrarPanel5('{{ $ascol3->colaborador_id }}' , '{{ $ascol3->id }}' , '{{ qcolabv($ascol3->colaborador_id) }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5"> <i class="fa fa-times"></i> </a>
                                          </div>

                                      </div>
                                    </div>
                                  </div>


                                </div>
                                @endforeach
                               @endif
                            </div>

                          </div>
                          @endforeach
                         @endif
                      </div>
                    </div>
                    @endforeach
                   @endif
                </div>
              </div>
            </div>
            @else


            @endif

          @endif

        @endforeach
      </div>
      @endfor
    </section>

    <hr>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-12">

          </div>
          <div class="col-md-12" style="margin-top:300px;">
            <table class="table table-stripped table-bordered">
              <tr>
                <th>Puesto</th>
                <th>Jefe Directo</th>
                <th>Colaborador</th>
                <th>Nivel</th>
              </tr>
              @foreach($asignados as $as)


              <tr>
                <td>{{ puestosid($as->puesto) }}</td>
                <td>{{ qcolabv($as->jefe_directo_id) }}</td>
                <td>{{ qcolabv($as->colaborador_id)}}</td>
                <td>{{ $as->nivel }}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </section>

    </div>
  </div>
</div>



<div class="modal fade" id="modalPanel1" tabindex="-1" aria-labelledby="modaldelCC" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form class="" action="{{ route('unoabajo') }}" method="post">
      @csrf
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel-content">
            <div class="panel-header2">
              <h5 class="panel-title text-center">Asignar Colaboradores</h5>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12 text-right">
                  <p> <small>Jefe directo:</small> <span id="colab_primary"></span> </p>
                </div>
                <div class="col-md-12 text-center">
                  <div class="form-group">
                    <label for="">Puesto:</label>
                    <select name="puestoid" class="form-control" id="puesto1" onchange="buscarColaborador1();">
                      <option value="">Selecciona una opción</option>
                         @foreach($puestos as $pst)
                         <option value="{{ $pst->idpuesto }}">{{ $pst->puesto }}</option>
                         @endforeach
                     </select>
                  </div>
                  <div class="form-group">
                    <label for="">Colaboradores:</label>
                    <select name="nuevo_colabid" class="form-control" id="colaboradores1" >

                     </select>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="idcolab" id="idcolab_primary">
          <input type="hidden" name="nivel" id="nivel_primary">
          <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
          <input type="hidden" name="area" value="{{ $area }}">
          <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info">Crear</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalPanel2" tabindex="-1" aria-labelledby="modaldelCC" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form class="" action="{{ route('unoarriba') }}" method="post">
      @csrf
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel-content">
            <div class="panel-header2">
              <h5 class="panel-title text-center">Asignar Jefe Directo</h5>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12 text-right">
                  <p> <small>Jefe directo:</small> <span id="colab_info"></span> </p>
                </div>
                <div class="col-md-12 text-center">
                  <div class="form-group">
                    <label for="">Puesto:</label>
                    <select name="puestoid" class="form-control" id="puesto2" onchange="buscarColaborador2();">
                      <option value="">Selecciona una opción</option>
                         @foreach($puestos as $pst)
                         <option value="{{ $pst->idpuesto }}">{{ $pst->puesto }}</option>
                         @endforeach
                     </select>
                  </div>
                  <div class="form-group">
                    <label for="">Colaboradores:</label>
                    <select name="nuevo_colabid" class="form-control" id="colaboradores2" >

                     </select>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="idcolab" id="idcolab_info">
          <input type="hidden" name="nivel" id="nivel_info">
          <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
          <input type="hidden" name="area" value="{{ $area }}">
          <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info">Crear</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalPanel3" tabindex="-1" aria-labelledby="modaldelCC" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form class="" action="{{ route('reemplazar') }}" method="post">
      @csrf
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel-content">
            <div class="panel-header2">
              <h5 class="panel-title text-center" id="exampleModalLabel">Reemplazar</h5>
            </div>
            <div class="panel-body">

            <div class="row">
              <div class="col-md-12 text-right">
                <p><small>Colaborador actual:</small> <span id="colab_danger"></span> </p>
              </div>
              <div class="col-md-12 text-center">
                <div class="form-group">
                  <label for="">Puesto:</label>
                  <select name="puestoid" class="form-control" id="puesto3" onchange="buscarColaborador3();">
                    <option value="">Selecciona una opción</option>
                       @foreach($puestos as $pst)
                       <option value="{{ $pst->idpuesto }}">{{ $pst->puesto }}</option>
                       @endforeach
                   </select>
                </div>
                <div class="form-group">
                  <label for="">Colaboradores:</label>
                  <select name="nuevo_colabid" class="form-control" id="colaboradores3" >

                   </select>
                </div>
              </div>
            </div>



            </div>

          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="pos" id="pos_danger">
          <input type="hidden" name="idcolab" id="idcolab_danger">
          <input type="hidden" name="nivel" id="nivel_danger">
          <input type="hidden" value="{{ $area }}" name="area" id="area">
          <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
          <input type="hidden" name="area" value="{{ $area }}">
          <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalPanel4" tabindex="-1" aria-labelledby="modalPanel4" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form class="" action="{{ route('asignarnivel1') }}" method="post">
      @csrf
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel-content">
            <div class="panel-header2">
              <h5 class="panel-title text-center">Asignar colaborador nivel #1</h5>
            </div>
            <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 text-center">
                    <div class="form-group">
                      <label for="">Puesto:</label>
                      <select name="puestoid" class="form-control" id="puesto4" onchange="buscarColaborador4();">
                        <option value="">Selecciona una opción</option>
                           @foreach($puestos as $pst)
                           <option value="{{ $pst->idpuesto }}">{{ $pst->puesto }}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class="form-group">
                      <label for="">Colaboradores:</label>
                      <select name="nuevo_colabid" class="form-control" id="colaboradores4" >

                       </select>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="idcolab" id="idcolab_danger">
          <input type="hidden" name="nivel" id="nivel_danger">
         <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
         <input type="hidden" name="area" value="{{ $area }}">
         <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalPanel5" tabindex="-1" aria-labelledby="modaldelCC" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form class="" action="{{ route('eliminardelorganigrama') }}" method="post">
      @csrf
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel-content">
            <div class="panel-header2">
              <h5 class="panel-title">Eliminar del organigrama</h5>
            </div>
            <div class="panel-body">

                <p>Colaborador a eliminar: </p>
                <p id="colab_delete"></p>
                <input type="hidden" name="idcolab" id="idcolab_delete">
                <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
                <input type="hidden" name="area" value="{{ $area }}">
                <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
                <input type="hidden" name="id_delete" id="id_delete">


            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">


function buscarColaborador1(){
     var token = '{{csrf_token()}}';
     var puesto = document.getElementById('puesto1').value;

     var data={_token:token , puesto:puesto };
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     $.ajax({
         type    : 'POST',
         url     :'/buscarColaboradorOrganigrama',
         data    : data,
         datatype: 'html',
         encode  : true,
         success: function (response) {
           document.getElementById('colaboradores1').innerHTML=response;
         },
         error: function(jqXHR, textStatus, errorThrown){

         }
     });

   }

</script>
<script type="text/javascript">


function buscarColaborador2(){
     var token = '{{csrf_token()}}';
     var puesto = document.getElementById('puesto2').value;

     var data={_token:token , puesto:puesto };
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     $.ajax({
         type    : 'POST',
         url     :'/buscarColaboradorOrganigrama',
         data    : data,
         datatype: 'html',
         encode  : true,
         success: function (response) {
           document.getElementById('colaboradores2').innerHTML=response;
         },
         error: function(jqXHR, textStatus, errorThrown){

         }
     });

   }

</script>
<script type="text/javascript">


function buscarColaborador3(){
     var token = '{{csrf_token()}}';
     var puesto = document.getElementById('puesto3').value;

     var data={_token:token , puesto:puesto };
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     $.ajax({
         type    : 'POST',
         url     :'/buscarColaboradorOrganigrama',
         data    : data,
         datatype: 'html',
         encode  : true,
         success: function (response) {
           document.getElementById('colaboradores3').innerHTML=response;
         },
         error: function(jqXHR, textStatus, errorThrown){

         }
     });

   }

</script>
<script type="text/javascript">


function buscarColaborador4(){
     var token = '{{csrf_token()}}';
     var puesto = document.getElementById('puesto4').value;

     var data={_token:token , puesto:puesto };
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     $.ajax({
         type    : 'POST',
         url     :'/buscarColaboradorOrganigrama',
         data    : data,
         datatype: 'html',
         encode  : true,
         success: function (response) {
           document.getElementById('colaboradores4').innerHTML=response;
         },
         error: function(jqXHR, textStatus, errorThrown){

         }
     });

   }

</script>
<script type="text/javascript">
// Obtener todas las zonas de destino
var dropZones = document.querySelectorAll(".dropzone");

// Configurar eventos "dragover" y "drop" en las zonas de destino
dropZones.forEach(function(dropZone) {
dropZone.addEventListener("dragover", function(event) {
event.preventDefault();
dropZone.classList.add("dragover");
});

dropZone.addEventListener("dragleave", function(event) {
dropZone.classList.remove("dragover");
});

dropZone.addEventListener("drop", function(event) {
event.preventDefault();
dropZone.classList.remove("dragover");

// Obtener el ID del elemento arrastrado
var draggedElementId = event.dataTransfer.getData("text/plain");

// Obtener el ID de la zona de destino
var dropZoneId = event.target.id;

if (draggedElementId!=dropZoneId) {
  if (dropZoneId && draggedElementId) {
    //console.log("Elemento arrastrado: " + draggedElementId);
    //console.log("Zona de destino: " + dropZoneId);

    var token = '{{csrf_token()}}';
    var origen = draggedElementId;
    var destino = dropZoneId;
    var data={_token:token , origen:origen , destino:destino };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type    : 'POST',
        url     :'{{ route('moverposicion') }}',
        data    : data,
        datatype: 'html',
        encode  : true,
        success: function (response) {

          //alert(response);
          window.location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown){

        }
    });



  }
  else {
    alert('No se pudo realizar el movimiento , intentalo de nuevo.');
  }
}else {
  alert('El colaborador ya pertenece a esa posición');
}
});
});

// Agregar el evento "dragstart" a los elementos arrastrables
var draggableElements = document.querySelectorAll(".colab-org");

draggableElements.forEach(function(element) {
element.setAttribute("draggable", "true");

element.ondragstart = function(event) {
event.dataTransfer.setData("text/plain", event.target.id);
};

element.ondragend = function(event) {
dropZones.forEach(function(dropZone) {
  dropZone.classList.remove("dragover");
});
};
});


</script>

<script type="text/javascript">
function showBtn(btnId) {
  var btn = document.getElementById(btnId);
  btn.style.display = "block";
  }

  function hideBtn(btnId) {
  var btn = document.getElementById(btnId);
  btn.style.display = "none";
  }

  function enviarPrimary(idcolab , nivel , colab){
    document.getElementById('colab_primary').innerText=colab;
    document.getElementById('idcolab_primary').value=idcolab;
    document.getElementById('nivel_primary').value=nivel;
  }

  function enviarInfo(idcolab , nivel , colab){
    document.getElementById('colab_info').innerText=colab;
    document.getElementById('idcolab_info').value=idcolab;
    document.getElementById('nivel_info').value=nivel;
  }

  function enviarDanger(idcolab , nivel , colab , pos){
    document.getElementById('colab_danger').innerText=colab;
    document.getElementById('idcolab_danger').value=idcolab;
    document.getElementById('nivel_danger').value=nivel;
    document.getElementById('pos_danger').value=pos;
  }


  function MostrarPanel4(){

    document.getElementById('panel1').style.display='none';
    document.getElementById('panel2').style.display='none';
    document.getElementById('panel3').style.display='none';
    document.getElementById('panel5').style.display='none';

    document.getElementById('panel4').style.display='block';

  }

  function MostrarPanel5(idcolab , id , colab){
    document.getElementById('colab_delete').innerText=colab;
    document.getElementById('idcolab_delete').value=idcolab;
    document.getElementById('id_delete').value=id;

  }
</script>



@endsection

@push('js')
@endpush
