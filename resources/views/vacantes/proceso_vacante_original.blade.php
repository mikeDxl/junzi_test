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
          <td>  </td>
          <td>{{ $vacante->area }}</td>
          <td>
            @if(buscarperfildePuesto($vacante->puesto_id))
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm" name="button">Ver perfil del puesto</button>
            @else
            No hay perfil de puesto para mostrar
            @endif
          </td>
          <td>{{ catalogopuesto($vacante->puesto_id) }}</td>
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
    <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAprobados" aria-expanded="false" aria-controls="collapseRechazados">
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
    <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePendientes" aria-expanded="false" aria-controls="collapseRechazados">
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
    <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRechazados" aria-expanded="false" aria-controls="collapseRechazados">
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


@include('vacantes.modals')

</div>
@endsection

@push('js')


<script type="text/javascript">
var current = 0;
var tabs = $(".tab");
var tabs_pill = $(".tab-pills");

loadFormData(current);

function loadFormData(n) {
$(tabs_pill[n]).addClass("active");
$(tabs[n]).removeClass("d-none");
$("#back_button").attr("disabled", n == 0 ? true : false);
n == tabs.length - 1
  ? $("#next_button").text("Submit").removeAttr("onclick")
  : $("#next_button")
      .attr("type", "button")
      .text("Next")
      .attr("onclick", "next()");
}

function next() {
$(tabs[current]).addClass("d-none");
$(tabs_pill[current]).removeClass("active");

current++;
loadFormData(current);
}

function back() {
$(tabs[current]).addClass("d-none");
$(tabs_pill[current]).removeClass("active");

current--;
loadFormData(current);
}

</script>




@endpush
