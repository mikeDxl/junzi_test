@extends('layouts.app', ['activePage' => 'calendar', 'menuParent' => 'calendar', 'titlePage' => __('Calendar')])

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-10 ml-auto mr-auto">
      <div class="card card-calendar">
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div id="fullCalendar"></div>
            </div>
            <div class="col-md-3">
              <form action="{{ route('calendar.filtro') }}" method="post" id="filtro-form">
                  @csrf
                  <input type="radio" name="filtro" value="todo" onchange="document.getElementById('filtro-form').submit();" {{ $filtro == 'todo' ? 'checked' : '' }}> Todo <br>
                  @if(auth()->user()->perfil!='Colaborador')
                  <input type="radio" name="filtro" value="entrevistas" onchange="document.getElementById('filtro-form').submit();" {{ $filtro == 'entrevistas' ? 'checked' : '' }}> Entrevistas <br>
                  <input type="radio" name="filtro" value="bajas" onchange="document.getElementById('filtro-form').submit();" {{ $filtro == 'bajas' ? 'checked' : '' }}> Bajas <br>
                  <input type="radio" name="filtro" value="ingresos" onchange="document.getElementById('filtro-form').submit();" {{ $filtro == 'ingresos' ? 'checked' : '' }}> Ingresos <br>
                  @endif
                  <input type="radio" name="filtro" value="vacaciones" onchange="document.getElementById('filtro-form').submit();" {{ $filtro == 'vacaciones' ? 'checked' : '' }}> Vacaciones <br>
                  <input type="radio" name="filtro" value="permisos" onchange="document.getElementById('filtro-form').submit();" {{ $filtro == 'permisos' ? 'checked' : '' }}> Permisos <br>
                  <input type="radio" name="filtro" value="incapacidades" onchange="document.getElementById('filtro-form').submit();" {{ $filtro == 'incapacidades' ? 'checked' : '' }}> Incapacidades <br>
                  <input type="radio" name="filtro" value="hallazgos" onchange="document.getElementById('filtro-form').submit();" {{ $filtro == 'hallazgos' ? 'checked' : '' }}> Hallazgos <br>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      var eventosDesdePHP = @json($eventos);
      demo.initFullCalendar(eventosDesdePHP);
    });
  </script>
@endpush
