@include('layouts.header')
<style media="screen">
  td { font-size: 8pt;}
</style>
<body class="text-start">
      @include('layouts.menu')
    <div class="main-content">
      <div class="breadcrumb">
        <h1>Vacantes</h1>
      </div>
      <div class="separator-breadcrumb border-top"></div>


      <div class="row">
        <div class="col-md-6">
          <h4>Puestos Activos</h4>
          <table class="table">
            <thead>
              <th>Puesto</th>
              <th>Antiguedad</th>
            </thead>
            @foreach($puestosactivos as $pst)
            <tr>
              <td>{{ puesto($pst->puesto, session('company_id')) }}</td>
              <td>{{ calcularDiferenciaEnAnios($pst->fecha_alta) }}</td>
            </tr>
            @endforeach
          </table>

          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        </div>



      </div>

@include('layouts.footer')
