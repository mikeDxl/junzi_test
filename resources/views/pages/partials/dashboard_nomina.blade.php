@extends('layouts.app', ['activePage' => 'dashboard', 'menuParent' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

<style media="screen">
  canvas{ margin-bottom: 100px; }
</style>
<div class="content">
  <div class="row">
    <div class="col-lg-3 col-md-6" id="dashboard">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-warning">
                <i class="tim-icons icon-watch-time"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category">Horas extra</p>
                <h3 class="card-title">0</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <hr>
          <div class="stats">
            <i class="tim-icons icon-watch-time text-danger"></i> <span class="text-danger"> <small>Enero 2024</small>  <b>0</b> ( <i class="fa fa-plus"></i> 0 )</span>
          </div>
          <div class="stats">
            <i class="tim-icons icon-watch-time text-danger"></i> <span class="text-danger"> <small>Febrero 2023</small> <b>0</b> ( <i class="fa fa-plus"></i> 140 )</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      @include('dashboard.partials.cards.headcount')
    </div>
    <div class="col-lg-3 col-md-6">
      @include('dashboard.partials.cards.vacantes')
    </div>
    <div class="col-lg-3 col-md-6">
      @include('dashboard.partials.cards.desvinculados')
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      @include('dashboard.partials.cards.pendientes')
    </div>
    <div class="col-md-6">
            @include('dashboard.partials.loading')
      </div>
  </div>

  
    <div class="row">
         <div class="col-md-6">
            @include('dashboard.partials.charts.headcount')
        </div>
       
        <div class="col-md-6">
            @include('dashboard.partials.charts.estabilidad')
        </div>
    
        <div class="col-md-6">
            @include('dashboard.partials.loading')
        </div>

        <div class="col-md-6">
            @include('dashboard.partials.loading')
        </div>

        <div class="col-md-6">
            @include('dashboard.partials.loading')
        </div>

        <div class="col-md-6">
            @include('dashboard.partials.loading')
        </div>
        
        
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    demo.initDashboardPageCharts();
    demo.initVectorMap();
  });
</script>
@endpush
