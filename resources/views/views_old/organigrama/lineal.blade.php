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
.btn-organigrama{
background: #f5f5f5!important;
border: #344675 1px solid!important;
color: #344675!important;
}

.btn-organigrama:hover{
background: #344675!important;
border: #344675 1px solid!important;
color: #f5f5f5!important;
}
.proximabaja{ color: red; text-decoration: line-through;}

.nav-link{ border-radius: 20px 20px 0px 0px!important;}


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
     width: auto;
     border-radius: 10px;
     border: 1px solid #ddd;
     padding: 8px;
     margin-bottom: 10px;
     background: #fff!important;
   }
   .colab-org-direccion{ font-size: 10px;
     width: 200px;
     border-radius: 10px;
     border: 1px solid #ddd;
     padding: 8px;
     margin-bottom: 10px;
     background: #f5f5f5!important;
     border: #344675 1px solid!important;
     color: #344675!important;
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
       .btn-organigrama , .btn-organigrama , .btn-organigrama{ background: #f5f5f5; }
       .btn-organigrama:hover , .btn-organigrama:hover , .btn-organigrama:hover{ background: #f5f5f5; }

       #section_organigrama {
                  /* Estilo base para el section */
                  border: 1px solid #ccc;
                  transition: width 0.10s;
                  background: #f5f5f5!important;
              }

    .btn-zoom{
      background: #f5f5f5!important;
      border: #344675 1px solid!important;
      color: #344675!important;
    }

    .btn-zoom:hover{
      background: #f5f5f5!important;
      border: #344675 1px solid!important;
      color: #344675!important;
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
$med=250;
$niv=($niv1*$med)+($niv2*$med)+($niv3*$med)+($niv4*$med)+($niv5*$med)+($niv6*$med)+($niv7*$med)+($niv8*$med)+($niv9*$med)+($niv10*$med);

$niveles=$lineal->niveles;


$niveles=$lineal->niveles;
$ancho=350*$niveles;


$nombretitulo='Jefatura';

if ($matricial->orientacion=='matricial') {
  $nombretitulo='Dirección';
}else {
  $nombretitulo='Jefatura';
}

 ?>
<input type="hidden" id="cc_id" name="cc_id" value="{{ $area_id }}">
<div class="content">
    <div id="chart_div"></div>
    <div class="row">
      <div class="col-6">
        <h2> <a href="/organigrama"> <button type="button" class="btn btn-link" name="button"> <i class="fa fa-chevron-left"></i> </button> </a> {{ $area }}</h2>
      </div>
      <div class="col-6">
        <button type="button" class="btn btn-info btn-sm" name="button"><a href="/ver-organigrama/{{ $area }}" style="color:#fff;">Ver tabla <i class="fa fa-table"></i> </a></button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        @if(buscarDirector($area_id,$orientacion)!="")
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="colab-org-direccion text-center ">
                <h4>Dirección</h4>
                <img src="{{ auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                <br>
                <span>{{ buscarDirector($area_id,$orientacion) }}</span>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
    <div class="row">
      @if($niv1!=0)
      <div class="col-12" style="margin-bottom:50px;">
        <input type="range" id="zoomRange" class="form-control" min="100" max="{{$niv}}" value="{{$niv}}">
        <div class="btn-group" style="display:none;">
          <button class="btn btn-zoom btn-sm" id="zoomOutButton"><i class="fa fa-minus"></i> </button>
          <button class="btn btn-zoom btn-sm" id="zoomInButton"> <i class="fa fa-plus"></i> </button>
        </div>
      </div>
      @endif

      @if($niv1==0)
        @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin')
        <div class="row">
          <div class="col-md-12 text-center" >
            <div class="text-center">
              <div style="margin:5px;" >
                <div class="text-center">
                    <div class="btn-group">
                      <a class="btn btn-organigrama btn-sm text-center" data-bs-toggle="modal" data-bs-target="#modalPanel4" > <i class="fa fa-user"></i> Asignar {{ $nombretitulo }}</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      @endif

      <div class="div_organigrama" id="div_organigrama">
        <section class="" id="section_organigrama" style="width: {{$niv}}px;">



          @for($i=1; $i<=$lineal->niveles; $i++)
          <div class="row">


            @foreach($asignados as $as)

              @if($as->nivel==$i)
                @if($i==1)
                <div class="col text-center contenedor">
                  <div class="colab-org text-center " id="colab{{$as->id}}"  onmouseover="showBtn('btn{{$as->id}}')" onmouseout="hideBtn('btn{{$as->id}}')">
                    <h6>{{ nombre_empresa($as->company_id) }}</h4>
                    <br>
                    <p>{{ $as->codigo }}</p>
                    <img src="/storage/app/public/{{ fotoperfil($as->colaborador_id) ?? auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                    <br>
                    <span class="{{ buscarsiesbaja($as->colaborador_id) }}">{{ qcolabv($as->colaborador_id) }}</span>
                    <br><br>
                    <b>{{ catalogopuesto($as->puesto) }}</b>
                    <div style="margin:5px; display:none;" id="btn{{$as->id}}">
                      <div class="text-center">

                          @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin' || auth()->user()->colaborador_id==$as->colaborador_id)
                          <div class="btn-group">
                            <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia abajo"  onclick="enviarPrimary('{{ $as->colaborador_id }}' , '{{ $as->nivel }}' , '{{ qcolabv($as->colaborador_id)}}' , '{{ $as->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel1"> <i class="fa fa-arrow-down"></i> </a>
                            <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia arriba"  onclick="enviarPrimary('{{ $as->colaborador_id }}' , '{{ $as->nivel }}'  , '{{ qcolabv($as->colaborador_id) }}' , '{{ $as->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2"> <i class="fa fa-arrow-up"></i> </a>
                            <a class="btn btn-organigrama btn-sm text-center" title="Reemplazar colaborador"  onclick="enviarDanger('{{ $as->colaborador_id }}' , '{{ $as->nivel }}' , '{{ qcolabv($as->colaborador_id) }}' , '{{$as->id}}' , '{{ $as->codigo }}' , '{{ puestosid($as->puesto , $as->company_id) }}' , '{{ $as->puesto }}')" data-bs-toggle="modal" data-bs-target="#modalPanel3"> <i class="fa fa-user"></i> </a>
                            @if (!buscarsiesbaja($as->colaborador_id))
                            <a class="btn btn-organigrama btn-sm text-center" title="Borrar posición"  onclick="MostrarPanel5('{{ $as->colaborador_id }}' , '{{ $as->id }}' , '{{ qcolabv($as->colaborador_id) }}' ,  '{{ $as->codigo }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5"> <i class="fa fa-times"></i> </a>
                            @endif
                          </div>
                          @endif
                      </div>
                    </div>
                  </div>
                </div>
                @elseif($i==2)

                <div class="col text-center contenedor">
                  <div class="linea-horizontal"></div> <!-- Línea horizontal -->
                  <div class="linea"></div>
                  <div class="colab-org text-center " id="colab{{$as->id}}"  draggable="true" onmouseover="showBtn('btn{{$as->id}}')" onmouseout="hideBtn('btn{{$as->id}}')">
                    <h6>{{ nombre_empresa($as->company_id) }}</h4>
                    <br>
                    <p>{{ $as->codigo }}</p>
                    <img src="/storage/app/public/{{ fotoperfil($as->colaborador_id) ?? auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                    <br>
                    <span class="{{ buscarsiesbaja($as->colaborador_id) }}">{{ qcolabv($as->colaborador_id) }}</span>
                    <br><br>

                    <b>{{ catalogopuesto($as->puesto) }}</b>
                    <div style="margin:5px; display:none;" id="btn{{$as->id}}">
                      <div class="text-center">

                          @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin' || auth()->user()->colaborador_id==$as->jefe_directo_id)
                          <div class="btn-group">
                            <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia abajo"  onclick="enviarPrimary('{{ $as->colaborador_id }}' , '{{ $as->nivel }}' , '{{ qcolabv($as->colaborador_id)}}' , '{{ $as->codigo }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel1"> <i class="fa fa-arrow-down"></i> </a>
                            <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia arriba"  onclick="enviarPrimary('{{ $as->colaborador_id }}' , '{{ $as->nivel }}'  , '{{ qcolabv($as->colaborador_id) }}' , '{{ $as->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2"> <i class="fa fa-arrow-up"></i> </a>
                            <a class="btn btn-organigrama btn-sm text-center" title="Reemplazar colaborador"  onclick="enviarDanger('{{ $as->colaborador_id }}' , '{{ $as->nivel }}' , '{{ qcolabv($as->colaborador_id) }}'  , '{{ $as->id }}' , '{{ $as->codigo }}' , '{{ puestosid($as->puesto , $as->company_id) }}' , '{{ $as->puesto }}')" data-bs-toggle="modal" data-bs-target="#modalPanel3"> <i class="fa fa-user"></i> </a>
                            @if (!buscarsiesbaja($as->colaborador_id))
                            <a class="btn btn-organigrama btn-sm text-center" title="Borrar posición"  onclick="MostrarPanel5('{{ $as->colaborador_id }}' , '{{ $as->id }}' , '{{ qcolabv($as->colaborador_id) }}' ,  '{{ $as->codigo }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5"> <i class="fa fa-times"></i> </a>
                            @endif
                          </div>
                          @endif

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
                      ->where('jefe_directo_codigo',$as->codigo)
                      ->get();
                       ?>
                       @if(count($colabs)>0)
                        @foreach($colabs as $ascol)
                        <div class="col text-center contenedor"  >
                          <div class="linea-horizontal"></div> <!-- Línea horizontal -->
                          <div class="linea"></div>
                          <div class="colab-org text-center " id="colab{{$ascol->id}}"  onmouseover="showBtn('btn{{$ascol->id}}')" onmouseout="hideBtn('btn{{$ascol->id}}')">
                            <h6>{{ nombre_empresa($ascol->company_id) }}</h4>
                            <br>
                            <p>{{ $ascol->codigo }}</p>
                            <img src="/storage/app/public/{{ fotoperfil($ascol->colaborador_id) ?? auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                            <br>
                            <span class="{{ buscarsiesbaja($ascol->colaborador_id) }}">{{ qcolabv($ascol->colaborador_id) }}</span>
                            <br><br>
                            <b>{{ catalogopuesto($ascol->puesto) }}</b>
                            <div style="margin:5px; display:none;" id="btn{{$ascol->id}}">
                              <div class="text-center">

                                  @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin' || auth()->user()->colaborador_id==$as->jefe_directo_id)
                                  <div class="btn-group">
                                    <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia abajo"  onclick="enviarPrimary('{{ $ascol->colaborador_id }}' , '{{ $ascol->nivel }}' , '{{ qcolabv($ascol->colaborador_id)}}' , '{{ $ascol->codigo }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel1"> <i class="fa fa-arrow-down"></i> </a>
                                    <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia arriba"  onclick="enviarPrimary('{{ $ascol->colaborador_id }}' , '{{ $ascol->nivel }}'  , '{{ qcolabv($ascol->colaborador_id) }}' , '{{ $ascol->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2"> <i class="fa fa-arrow-up"></i> </a>
                                    <a class="btn btn-organigrama btn-sm text-center" title="Reemplazar colaborador"  onclick="enviarDanger('{{ $ascol->colaborador_id }}' , '{{ $ascol->nivel }}' , '{{ qcolabv($ascol->colaborador_id) }}'  , '{{ $ascol->id}}' , '{{ $ascol->codigo }}' , '{{ puestosid($ascol->puesto , $ascol->company_id) }}' , '{{ $ascol->puesto }}')" data-bs-toggle="modal" data-bs-target="#modalPanel3"> <i class="fa fa-user"></i> </a>
                                    @if (!buscarsiesbaja($ascol->colaborador_id))
                                    <a class="btn btn-organigrama btn-sm text-center" title="Borrar posición"  onclick="MostrarPanel5('{{ $ascol->colaborador_id }}' , '{{ $ascol->id }}' , '{{ qcolabv($ascol->colaborador_id) }}'  ,  '{{ $ascol->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel5"> <i class="fa fa-times"></i> </a>
                                    @endif
                                  </div>
                                  @endif

                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <br>
                            <?php
                            $colabs2=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)
                            ->where('nivel',$i+2)
                            ->where('jefe_directo_id',$ascol->colaborador_id)
                            ->where('jefe_directo_codigo',$ascol->codigo)
                            ->get();
                             ?>
                             @if(count($colabs2)>0)
                              @foreach($colabs2 as $ascol2)
                              <div class="col text-center contenedor"  >
                                <div class="linea"></div>
                                <div class="colab-org text-center " id="colab{{$ascol2->id}}" onmouseover="showBtn('btn{{$ascol2->id}}')" onmouseout="hideBtn('btn{{$ascol2->id}}')">
                                  <h6>{{ nombre_empresa($ascol2->company_id) }}</h4>
                                  <br>
                                  <p>{{ $ascol2->codigo }}</p>
                                  <img src="/storage/app/public/{{ fotoperfil($ascol2->colaborador_id) ?? auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                                  <br>
                                  <span class="{{ buscarsiesbaja($ascol2->colaborador_id) }}">{{ qcolabv($ascol2->colaborador_id) }}</span>
                                  <br><br>
                                  <b>{{ catalogopuesto($ascol2->puesto) }}</b>
                                  <br>
                                  <div style="margin:5px; display:none;" id="btn{{$ascol2->id}}">
                                    <div class="text-center">

                                        @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin' || auth()->user()->colaborador_id==$as->jefe_directo_id)
                                        <div class="btn-group">
                                          <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia abajo"  onclick="enviarPrimary('{{ $ascol2->colaborador_id }}' , '{{ $ascol2->nivel }}' , '{{ qcolabv($ascol2->colaborador_id)}}' , '{{ $ascol2->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel1" > <i class="fa fa-arrow-down"></i> </a>
                                          <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia arriba"  onclick="enviarPrimary('{{ $ascol2->colaborador_id }}' , '{{ $ascol2->nivel }}'  , '{{ qcolabv($ascol2->colaborador_id) }}' , '{{ $ascol2->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2" > <i class="fa fa-arrow-up"></i> </a>
                                          <a class="btn btn-organigrama btn-sm text-center" title="Reemplazar colaborador"  onclick="enviarDanger('{{ $ascol2->colaborador_id }}' , '{{ $ascol2->nivel }}' , '{{ qcolabv($ascol2->colaborador_id) }}'  , '{{$ascol2->id}}' , '{{ $ascol2->codigo }}' , '{{ puestosid($ascol2->puesto , $ascol2->company_id) }}' , '{{ $ascol2->puesto }}')" data-bs-toggle="modal" data-bs-target="#modalPanel3" > <i class="fa fa-user"></i> </a>
                                          @if (!buscarsiesbaja($ascol2->colaborador_id))
                                          <a class="btn btn-organigrama btn-sm text-center" title="Borrar posición"  onclick="MostrarPanel5('{{ $ascol2->colaborador_id }}' , '{{ $ascol2->id }}' , '{{ qcolabv($ascol2->colaborador_id) }}' , '{{ $ascol2->codigo }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5" > <i class="fa fa-times"></i> </a>
                                          @endif
                                        </div>
                                        @endif

                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <?php
                                  $colabs3=OrganigramaLinealNiveles::where('organigrama_id',$lineal->id)
                                  ->where('nivel',$i+3)
                                  ->where('jefe_directo_id',$ascol2->colaborador_id)
                                  ->where('jefe_directo_codigo',$ascol2->codigo)
                                  ->get();
                                   ?>

                                   @if(count($colabs3)>0)
                                    @foreach($colabs3 as $ascol3)
                                    <div class="col text-center contenedor"  >
                                      <div class="linea"></div>
                                      <div class="colab-org text-center " id="colab{{$ascol3->id}}"  draggable="true" onmouseover="showBtn('btn{{$ascol3->id}}')" onmouseout="hideBtn('btn{{$ascol3->id}}')">
                                        <h6>{{ nombre_empresa($ascol3->company_id) }}</h4>
                                        <br>
                                        <p>{{ $ascol3->codigo }}</p>
                                        <img src="/storage/app/public/{{ fotoperfil($ascol3->colaborador_id) ?? auth()->user()->profilePicture() }}" alt="" style="height:60px;">
                                        <br>
                                        <span class="{{ buscarsiesbaja($ascol3->colaborador_id) }}">{{ qcolabv($ascol3->colaborador_id) }}</span>
                                        <br><br>
                                        <b>{{ catalogopuesto($ascol3->puesto) }}</b>
                                        <br>
                                        <div style="margin:5px; display:none;" id="btn{{$ascol3->id}}">
                                          <div class="text-center">

                                              @if(auth()->user()->rol=='Nómina' || auth()->user()->perfil=='Admin' || auth()->user()->colaborador_id==$as->jefe_directo_id)
                                              <div class="btn-group">
                                                <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia abajo"  onclick="enviarPrimary('{{ $ascol3->colaborador_id }}' , '{{ $ascol3->nivel }}' , '{{ qcolabv($ascol3->colaborador_id) }}' , '{{ $ascol3->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel1"> <i class="fa fa-arrow-down"></i> </a>
                                                <a class="btn btn-organigrama btn-sm text-center" title="Agregar un colaborador hacia arriba"  onclick="enviarPrimary('{{ $ascol3->colaborador_id }}' , '{{ $ascol3->nivel }}'  , '{{ qcolabv($ascol3->colaborador_id) }}' , '{{ $ascol3->codigo }}')" data-bs-toggle="modal" data-bs-target="#modalPanel2"> <i class="fa fa-arrow-up"></i> </a>
                                                <a class="btn btn-organigrama btn-sm text-center" title="Reemplazar colaborador"  onclick="enviarDanger('{{ $ascol3->colaborador_id }}' , '{{ $ascol3->nivel }}' , '{{ qcolabv($ascol3->colaborador_id) }}'  , '{{$ascol3->id}}'  , '{{ $ascol3->codigo }}' , '{{ puestosid($ascol3->puesto , $ascol3->company_id) }}' , '{{ $ascol3->puesto }}')" data-bs-toggle="modal" data-bs-target="#modalPanel3"> <i class="fa fa-user"></i> </a>
                                                @if (!buscarsiesbaja($ascol3->colaborador_id))
                                                <a class="btn btn-organigrama btn-sm text-center" title="Borrar posición"  onclick="MostrarPanel5('{{ $ascol3->colaborador_id }}' , '{{ $ascol3->id }}' , '{{ qcolabv($ascol3->colaborador_id) }}' , '{{ $ascol3->codigo }}' )" data-bs-toggle="modal" data-bs-target="#modalPanel5"> <i class="fa fa-times"></i> </a>
                                                @endif
                                              </div>
                                              @endif

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
              <h5 class="panel-title text-center">Asignar posición <i class="fa fa-arrow-down"></i> </h5>
            </div>
            <div class="panel-body">
              <div class="card">
                <div class="card-body">
                  <ul class="nav nav-pills nav-pills-info">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#link1" onclick="document.getElementById('tipo_asignar_abajo').value='colaborador';">
                        Colaborador
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link2" onclick="document.getElementById('tipo_asignar_abajo').value='vacante';">
                        Vacante
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link3" onclick="document.getElementById('tipo_asignar_abajo').value='espacio';">
                        Espacio en blanco
                      </a>
                    </li>
                  </ul>
                  <div class="row">
                    <div class="col-md-12 text-right">
                      <p> <small>Jefe directo:</small> <span id="colab_primary"></span> </p>
                    </div>
                  </div>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="link1">
                      <div class="row">

                        <div class="col-md-12 text-center">
                          <div class="form-group">
                            <label for="">Puesto:</label>
                            <select name="puestoid" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="puesto1" onchange="buscarColaborador1();">
                              <option value="">Selecciona una opción</option>
                                 @foreach($puestos as $pst)
                                 <option value="{{ $pst->id }}">{{ $pst->puesto }}</option>
                                 @endforeach
                             </select>
                          </div>
                          <div class="form-group">
                            <label for="">Colaboradores:</label>
                            <select name="nuevo_colabid" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="colaboradores1" >

                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="link2">
                      <div class="form-group">
                        <label for="">Empresa:</label>
                        <select name="company_id" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="company_id1v" onchange="buscarPuestoEmpresa();">
                          <option value="">Selecciona una opción</option>
                             @foreach($listado_empresas as $le)
                             <option value="{{ $le->id }}">{{ $le->razon_social }}</option>
                             @endforeach
                         </select>
                      </div>
                      <div class="form-group">
                        <label for="">Puesto:</label>
                        <select name="puestoidvac" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="puesto1v">
                          <option value="">Selecciona una opción</option>
                             @foreach($puestos as $pst)
                             <option value="{{ $pst->id }}">{{ $pst->puesto }}</option>
                             @endforeach
                         </select>
                      </div>
                    </div>
                    <div class="tab-pane" id="link3">
                      <div class="form-group">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="tipo_asignar_abajo" name="tipo_asignar_abajo" value="colaborador">
          <input type="hidden" name="idcolab" id="idcolab_primary">
          <input type="hidden" name="nivel" id="nivel_primary">
          <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
          <input type="hidden" name="area" value="{{ $area }}">
          <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
          <input type="hidden" name="id_codigo" id="codigo_primary" value="">
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
              <h5 class="panel-title text-center">Asignar posición <i class="fa fa-arrow-up"></i> </h5>
            </div>
            <div class="panel-body">
              <div class="card">
                <div class="card-body">
                  <ul class="nav nav-pills nav-pills-info">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#link11" onclick="document.getElementById('tipo_asignar_abajo_2').value='colaborador';">
                        Colaborador
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link22" onclick="document.getElementById('tipo_asignar_abajo_2').value='vacante';">
                        Vacante
                      </a>
                    </li>
                  </ul>
                  <div class="row">
                    <div class="col-md-12 text-right">
                      <p> <small>Jefe directo:</small> <span id="colab_info"></span> </p>
                    </div>
                    <div class="tab-content tab-space">
                      <div class="tab-pane active" id="link11">
                        <div class="row">
                          <div class="col-md-12 text-center">
                            <div class="form-group">
                              <label for="">Puesto:</label>
                              <select name="puestoid" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="puesto2" onchange="buscarColaborador2();">
                                <option value="">Selecciona una opción</option>
                                   @foreach($puestos as $pst)
                                   <option value="{{ $pst->id }}">{{ $pst->puesto }}</option>
                                   @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                              <label for="">Colaboradores:</label>
                              <select name="nuevo_colabid" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="colaboradores2" >

                               </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="link22">
                        <div class="form-group">
                          <label for="">Puesto:</label>
                          <select name="puestoidvac" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="puesto12v">
                            <option value="">Selecciona una opción</option>
                               @foreach($puestos as $pst)
                               <option value="{{ $pst->id }}">{{ $pst->puesto }}</option>
                               @endforeach
                           </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="text" id="tipo_asignar_abajo_2" name="tipo_asignar_abajo" value="colaborador">
          <input type="hidden" name="idcolab" id="idcolab_info">
          <input type="hidden" name="nivel" id="nivel_info">
          <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
          <input type="hidden" name="area" value="{{ $area }}">
          <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
          <input type="hidden" name="id_codigo" id="codigo_info" value="">
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
                <p> <input type="checkbox" name="forzar_cambio" checked value="Si"> Forzar cambio de puesto al nuevo colaborador</p>
                <input type="hidden" readonly name="puesto_old_text" id="puesto_danger" class="form-control">
                <input type="text" readonly name="puesto_old" id="puesto_danger_text" class="form-control">
                <div class="form-group">
                  <label for="">Puesto:</label>
                  <select name="puestoid" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="puesto3" onchange="buscarColaborador3();">
                    <option value="">Selecciona una opción</option>
                       @foreach($puestos as $pst)
                       <option value="{{ $pst->id }}">{{ $pst->puesto }}</option>
                       @endforeach
                   </select>
                </div>
                <div class="form-group">
                  <label for="">Colaboradores:</label>
                  <select name="nuevo_colabid" class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" id="colaboradores3" >

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
          <input type="hidden" name="id_codigo" id="codigo_danger" value="">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalPanel4" tabindex="-1" aria-labelledby="modalPanel4" aria-hidden="true">
  <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <div class="modal-body">
          <div class="panel-content">
            <div class="panel-header2">
              <h5 class="panel-title text-center">Asignar {{ $nombretitulo }}</h5>
            </div>

            <div class="panel-body">
              <form class="" action="{{ route('asignarnivel1') }}" method="post">
                @csrf
                <div class="row">
                  <div class="col-md-12 text-center">
                    <div class="form-group">
                      <label for="">Puesto:</label>
                      <select name="puestoid"  class="form-control sel" required  data-style="select-with-transition"  data-style="select-with-transition" id="puesto4" onchange="buscarColaborador4();">
                        <option value="">Selecciona una opción</option>
                           @foreach($puestos as $pst)
                           <option value="{{ $pst->id }}">{{ $pst->puesto }}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class="form-group">
                      <label for="">Colaboradores:</label>
                      <select name="nuevo_colabid" class="form-control sel" required  data-style="select-with-transition"  data-style="select-with-transition" id="colaboradores4" onchange="nuevo_usuario();">

                       </select>
                    </div>
                    <hr>
                    <div id="seccion_usuario" style="display:none;">
                      <div class="form-group">
                        @if($orientacion=='matricial')
                        <label for="">Usuario Dirección:</label>
                        <input type="hidden" name="perfil" value="Dirección">
                        @else
                        <label for="">Usuario Jefatura:</label>
                        <input type="hidden" name="perfil" value="Jefatura">
                        @endif
                        <input type="text" name="usuario" class="form-control" id="nuevo_user" value="">
                        <input type="hidden" name="nombre" class="form-control" id="nuevo_nombre" value="">
                      </div>
                      <div class="form-group">
                        <label for="">Contraseña:</label>
                        <input type="text" name="password" class="form-control" id="nuevo_pass" value="Junzi2023!!!">
                      </div>
                      <div class="form-group">
                        <label for="">Asignar permisos adicionales</label> <br>
                        <input type="radio" name="permisos" value="Nómina"> Nómina <br>
                        <input type="radio" name="permisos" value="Reclutamiento"> Reclutamiento <br>
                        <input type="radio" name="permisos" value="Auditoría"> Auditoría <br>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="container">
                  <div class="row">
                    <div class="col-6 text-center">

                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="col-6 text-center">
                      <input type="hidden" name="nivel" value="1">
                      <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
                      <input type="hidden" name="area" value="{{ $area }}">
                      <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
                      <button type="submit" class="btn btn-info">Guardar</button>
                    </div>
                  </div>
                </div>
                </form>
                <br>

                <div class="container">
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <hr>
                      <form class="" action="{{ route('unoabajo') }}" method="post">
                        @csrf
                        <input type="hidden" id="tipo_asignar_abajo" name="tipo_asignar_abajo" value="colaborador">
                        <input type="hidden" name="idcolab"  value="0">
                        <input type="hidden" name="nivel"  value="1">
                        <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
                        <input type="hidden" name="area" value="{{ $area }}">
                        <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
                        <button type="submit" class="btn btn-info">Crear espacio en blanco</button>
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

<div class="modal fade" id="modalPanel5" tabindex="-1" aria-labelledby="modaldelCC" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="" action="{{ route('eliminardelorganigrama') }}" method="post">
      @csrf
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel-content">
            <div class="panel-header2">
              <h5 class="panel-title text-center">Eliminar del organigrama</h5>
            </div>
            <div class="panel-body">

              <div class="row">
                <div class="col-6">
                  <p id="colab_delete_text">Posición a eliminar: </p>
                  <p id="colab_delete"></p>
                  <p id="id_codigo_delete_text"></p>

                  <input type="hidden" name="idcolab" id="idcolab_delete">
                  <input type="hidden" name="iddepartamento" value="{{ $area_id }}">
                  <input type="hidden" name="area" value="{{ $area }}">
                  <input type="hidden" name="idorganigrama" value="{{ $lineal->id  }}">
                  <input type="hidden" name="id_delete" id="id_delete">
                  <input type="hidden" name="id_codigo" id="id_codigo_delete">

                  <div class="form-group">
                    <label for="">Opciones</label>
                    <select class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" name="tipo_de_eliminacion" id="tipo_de_eliminacion" onchange="opciones();">
                      <option value="">Selecciona una opción</option>
                      <option value="1">Dar de baja al colaborador</option>
                      <option value="2">Dar de baja al colaborador y crear vacante</option>
                      <option value="3">Eliminar solo del organigrama</option>
                    </select>
                  </div>
                </div>
                <div class="col-6">

                  <div class="row">
                    <div class="col-12">
                      <small>En caso de que existan colaboradores en un nivel inmediato inferior, selecciona un nuevo jefe directo para asignarselos.</small>
                    </div>
                  </div>
                  <div class="form-group">

                    <label for="">Nuevo Jefe Directo</label>
                    <select class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" name="nuevo_jefe">
                      <option value="">Selecciona una opción</option>
                      @foreach($asignados as $as)
                        <option value="{{ $as->colaborador_id }}">{{ qcolab($as->colaborador_id) }}</option>
                      @endforeach
                    </select>
                  </div>

                </div>
              </div>



                <div class="" id="div_baja" style="display:none;">


                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Fecha de baja</label>
                        <input type="date" min="{{ date('Y-m-d') }}" name="fecha_baja" class="form-control">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Motivo baja</label>
                        <select class="form-control sel"  data-style="select-with-transition"  data-style="select-with-transition" name="tipobaja">
                          <option value="">Selecciona el tipo de baja:</option>
                          <option value="Renuncia">Renuncia</option>
                          <option value="Baja solicitada">Baja solicitada</option>
                        </select>
                      </div>
                    </div>
                  </div>


                </div>

            </div>

          </div>
        </div>
        <div class="modal-footer">
          <div class="container">
            <div class="row">
              <div class="col-6 text-center">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              </div>
              <div class="col-6 text-center">

                <button type="submit" class="btn btn-danger">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        var jsonData = <?php echo $organigrama_json; ?>;
        data.addRows(jsonData);


        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {'allowHtml':true});
      }
   </script>

<script type="text/javascript">
  function opciones(){

    var op=document.getElementById('tipo_de_eliminacion').value;

    if (op=='1' || op=='2') {

      document.getElementById('div_baja').style.display='block';

    }else {
      document.getElementById('div_baja').style.display='none';
    }
  }
</script>

<script type="text/javascript">
function formarNuevaPalabra(texto) {
  // Dividir el texto en palabras
  var palabras = texto.trim().split(/\s+/);

  if (palabras.length < 3) {
    // Si hay menos de 3 palabras, usar la primera letra de la primera palabra,
    // la segunda palabra y la primera letra de la última palabra.
    var primeraLetra = palabras[0].charAt(0);
    var ultimaPalabra = palabras[palabras.length - 1].charAt(0);
    return (primeraLetra + palabras[1] + ultimaPalabra).toLowerCase();
  } else {
    // Si hay 3 o más palabras, usar la primera letra de la primera palabra,
    // la penúltima palabra y la primera letra de la última palabra.
    var primeraLetra = palabras[0].charAt(0);
    var penultimaPalabra = palabras[palabras.length - 2];
    var ultimaLetra = palabras[palabras.length - 1].charAt(0);
    return (primeraLetra + penultimaPalabra + ultimaLetra).toLowerCase();
  }
}

  function nuevo_usuario(){

    document.getElementById('seccion_usuario').style.display='block';

    var select = document.getElementById('colaboradores4');
    var selectedOption = select.selectedOptions[0]; // Obtiene el primer elemento seleccionado (puede haber varios si el select permite selección múltiple)

    if (selectedOption) {
        var textoSeleccionado = selectedOption.textContent; // Obtiene el texto del option seleccionado
        var nuevaPalabra = formarNuevaPalabra(textoSeleccionado);
        document.getElementById('nuevo_user').value=nuevaPalabra+'@junzi.com';
        document.getElementById('nuevo_nombre').value=textoSeleccionado;

    } else {
        console.log("Ninguna opción seleccionada.");
    }
  }
</script>

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
    // alert(puesto);
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



  function buscarPuestoEmpresa(){
       var token = '{{csrf_token()}}';
       var cc_id = document.getElementById('cc_id').value;
       var company_id = document.getElementById('company_id1v').value;
      // alert(puesto);
       var data={_token:token , puesto:puesto };
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       $.ajax({
           type    : 'POST',
           url     :'/buscarPuestoxEmpresa',
           data    : data,
           datatype: 'html',
           encode  : true,
           success: function (response) {
             //document.getElementById('puesto1v').innerHTML=response;
           },
           error: function(jqXHR, textStatus, errorThrown){

           }
       });

     }
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

  function enviarPrimary(idcolab , nivel , colab , codigo){
    document.getElementById('colab_primary').innerText=colab;
    document.getElementById('idcolab_primary').value=idcolab;
    document.getElementById('nivel_primary').value=nivel;
    document.getElementById('codigo_primary').value=codigo;
  }

  function enviarInfo(idcolab , nivel , colab , codigo){
    document.getElementById('colab_info').innerText=colab;
    document.getElementById('idcolab_info').value=idcolab;
    document.getElementById('nivel_info').value=nivel;
    document.getElementById('codigo_info').value=codigo;
  }

  function enviarDanger(idcolab , nivel , colab , pos , codigo , puesto , idpuesto){

    document.getElementById('colab_danger').innerText=colab;
    document.getElementById('idcolab_danger').value=idcolab;
    document.getElementById('nivel_danger').value=nivel;
    document.getElementById('pos_danger').value=pos;
    document.getElementById('codigo_danger').value=pos;
    document.getElementById('puesto_danger_text').value=puesto;
    document.getElementById('puesto_danger').value=idpuesto;

  }


  function MostrarPanel4(){

    document.getElementById('panel1').style.display='none';
    document.getElementById('panel2').style.display='none';
    document.getElementById('panel3').style.display='none';
    document.getElementById('panel5').style.display='none';

    document.getElementById('panel4').style.display='block';

  }

  function MostrarPanel5(idcolab , id , colab , codigo){


    document.getElementById('colab_delete').innerText=colab;
    document.getElementById('idcolab_delete').value=idcolab;
    document.getElementById('id_delete').value=id;
    document.getElementById('id_codigo_delete').value=codigo;
    document.getElementById('id_codigo_delete_text').innerText=codigo;

  }
</script>

<script>
        // Obtenemos el elemento section y los botones
        const section = document.getElementById('section_organigrama');
        const zoomInButton = document.getElementById('zoomInButton');
        const zoomOutButton = document.getElementById('zoomOutButton');
        const zoomRange = document.getElementById('zoomRange');

        // Manejadores de eventos para los botones
        zoomInButton.addEventListener('click', () => {
            // Aumentar el ancho de la sección en 10px (ajusta según tu necesidad)
            section.style.width = (parseFloat(section.style.width) + 10) + 'px';
        });

        zoomOutButton.addEventListener('click', () => {
            // Disminuir el ancho de la sección en 10px (ajusta según tu necesidad)
            section.style.width = (parseFloat(section.style.width) - 10) + 'px';
        });

        // Manejador de eventos para la barra de entrada
        zoomRange.addEventListener('input', () => {
            // Actualizamos el ancho de la sección según el valor de la barra de entrada
            section.style.width = zoomRange.value + 'px';
        });
    </script>

<script type="text/javascript">
/*
if (document.getElementById('puesto4')) {
var element = document.getElementById('puesto4');
const example = new Choices(element, {
  searchEnabled: true
});
};
*/
</script>

@endsection

@push('js')
@endpush
