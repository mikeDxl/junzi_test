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


   .alert-contenido{ background: rgba(0,0,0,.5); color: #f5f5f5;}
   </style>

   <?php
   if ($procesoinfo->curriculum) {
     $clase_fa1="fa fa-check";
   }else {
     $clase_fa1="fa fa-clock";
   }


   if(auth()->user()->rol=='Reclutamiento'){
     if ($procesoinfo->entrevista2_fecha) {
       $clase_fa2="fa fa-check";
     }else {
       $clase_fa2="fa fa-clock";
     }
   }
   elseif(auth()->user()->rol=='Nómina' && auth()->user()->perfil=='Jefatura'){

     if ($procesoinfo->entrevista2_fecha) {
       $clase_fa2="fa fa-check";
     }else {
       $clase_fa2="fa fa-clock";
     }

   }
   elseif(auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina'){

     if ($procesoinfo->entrevista1_fecha) {
       $clase_fa2="fa fa-check";
     }else {
       $clase_fa2="fa fa-clock";
     }

   }


   if(auth()->user()->rol=='Reclutamiento'){
     if ($procesoinfo->estatus_entrevista) {
       $clase_fa3="fa fa-check";
     }else {
       $clase_fa3="fa fa-clock";
     }
   }
   elseif(auth()->user()->rol=='Nómina' && auth()->user()->perfil=='Jefatura'){

     if ($procesoinfo->estatus_entrevista) {
       $clase_fa3="fa fa-check";
     }else {
       $clase_fa3="fa fa-clock";
     }

   }
   elseif(auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina'){

     if ($procesoinfo->estatus_entrevista) {
       $clase_fa3="fa fa-check";
     }else {
       $clase_fa3="fa fa-clock";
     }

   }


   if ($procesoinfo->estatus_entrevista=='aprobado') {


     if ($procesoinfo->referencia_nombre1 && $procesoinfo->referencia_nombre2) {
       $clase_fa4="fa fa-check";
     }else {
       $clase_fa4="fa fa-clock";
     }


     if ($procesoinfo->examen) {
       $clase_fa5="fa fa-check";
     }else {
       $clase_fa5="fa fa-clock";
     }


     if ($procesoinfo->documento1=='Aprobado' && $procesoinfo->documento2=='Aprobado' && $procesoinfo->documento3=='Aprobado' && $procesoinfo->documento4=='Aprobado' && $procesoinfo->documento5=='Aprobado') {
       $clase_fa6="fa fa-check";
     }else {
       $clase_fa6="fa fa-clock";
     }

     $clase_fa7="fa fa-clock";
   }else {
     $clase_fa4="fa fa-lock";
     $clase_fa5="fa fa-lock";
     $clase_fa6="fa fa-lock";
     $clase_fa7="fa fa-lock";
   }





    ?>
<div class="content">
  <div class="row">
    <div class="col-md-8">
      <a href="/vacantes"> <button type="button" class="btn btn-link" name="button"> <i class="fa fa-arrow-left"> Regresar</i> </button> </a>
    </div>
  </div>
  <div class="row">
        <div class="col-md-12">
            <p>Jefe directo: {{ qcolab($vacante->jefe) ?: 'No disponible' }}</p>
        </div>
    </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <table class="table">
        <tr>
          <td>Proceso Vacante</td>
          <td>{{$vacante->area}}</td>
          <td>
            @if(buscarperfildePuesto($vacante->puesto_id))
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm" name="button">Ver perfil del puesto</button>
            @else
            No hay perfil de puesto para mostrar
            @endif
          </td>
          <td>{{ nombre_puesto($vacante->puesto_id) }}</td>
          <td>Cantidad: {{  $vacante->completadas.' / '.$vacante->solicitadas }}</td>
        </tr>
      </table>
  </div>
</div>

<div class="row">
  <div class="col-md-8">

  </div>
  <div class="col-md-4 text-end text-right">
    @if(auth()->user()->rol=='Reclutamiento')
      <button type="button" data-bs-toggle="modal" data-bs-target="#exampleAltaCandidato" class="btn btn-sm" name="button">Agregar candidato</button>
    @endif
  </div>
</div>


<div class="row">
  <div class="col-md-12">
    <h2 class="text-center">Candidatos</h2>
  </div>
  <div class="col-md-4 text-center">
    <button class="btn btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAprobados" aria-expanded="false" aria-controls="collapseAprobados">
     Aprobados
   </button>
    <div class="collapse" id="collapseAprobados">
     <div class="card card-body">
       @foreach($procesos as $proc)
         @if($proc->estatus=='Aprobado')
         <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}">{{ candidato($proc->candidato_id)  }}</a> <br>
         @endif
       @endforeach
     </div>
   </div>
  </div>
  <div class="col-md-4 text-center">
    <button class="btn btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePendientes" aria-expanded="false" aria-controls="collapsePendientes">
     En proceso
   </button>
    <div class="collapse" id="collapsePendientes">
     <div class="card card-body">
       @foreach($procesos as $proc)
         @if($proc->estatus=='Pendiente')
         <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}">{{ candidato($proc->candidato_id)  }}</a> <br>
         @endif
       @endforeach
     </div>
   </div>
  </div>
  <div class="col-md-4 text-center">
    <button class="btn btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRechazados" aria-expanded="false" aria-controls="collapseRechazados">
     Rechazados
   </button>
   <div class="collapse" id="collapseRechazados">
    <div class="card card-body">
      @foreach($procesos as $proc)
        @if($proc->estatus=='Rechazado')
        <a href="/proceso_vacante/{{ $proc->vacante_id }}/{{ $proc->candidato_id }}">{{ candidato($proc->candidato_id)  }}</a> <br>
        @endif
      @endforeach
    </div>
  </div>

  </div>
</div>



@if(auth()->user()->rol=='Reclutamiento')
  @include('vacantes.wizard_reclutamiento')
@elseif(auth()->user()->rol=='Nómina' && auth()->user()->perfil=='Jefatura')
  @include('vacantes.wizard_nomina')
@elseif(auth()->user()->perfil=='Jefatura' && auth()->user()->rol!='Nómina')
  @include('vacantes.wizard_jefatura')
@endif

  @include('vacantes.modals')

</div>
@endsection

@push('js')

<script type="text/javascript">
  var current = {{ $procesoinfo->current }};
  var tabs = $(".tab");
 var tabs_pill = $(".tab-pills");

 loadFormData(current);

 function loadFormData(n) {
   tabs_pill.removeClass("active");
   $(tabs_pill[n]).addClass("active");

   tabs.addClass("d-none");
   $(tabs[n]).removeClass("d-none");

   $("#back_button").attr("disabled", n == 0 ? true : false);

   if (n == tabs.length - 1) {
     $("#next_button").text("Programar alta").removeAttr("onclick");
   } else {
     $("#next_button")
       .attr("type", "button")
       .text("Siguiente")
       .attr("onclick", "next()");
   }
 }

 function next() {
   $(tabs[current]).addClass("d-none");
   tabs_pill.removeClass("active");

   current++;
   loadFormData(current);
 }

 function back() {
   $(tabs[current]).addClass("d-none");
   tabs_pill.removeClass("active");

   current--;
   loadFormData(current);
 }

 $(document).ready(function() {
   $(".tab-pills").click(function() {
     var index = $(this).index();
     current = index;
     loadFormData(current);
   });
 });
</script>





@endpush
