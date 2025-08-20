@extends('layouts.app', ['activePage' => 'dashboard', 'menuParent' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
  <div class="row">
    <div class="col-12">
      <div class="card card-chart">
        <div class="card-header">
          <div class="row">
            <div class="col-sm-6 text-left">
              <h5 class="card-category">{{ date('Y') }}</h5>
              <h2 class="card-title">Gráfica</h2>
            </div>
            <div class="col-sm-6">

            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="chartBig1"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6" id="dashboard">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-warning">
                <i class="tim-icons icon-single-02"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category"></p>
                <h3 class="card-title"></h3>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-primary">
                  <i class="tim-icons icon-single-02"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category"></p>
                <h3 class="card-title"></h3>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <div class="info-icon text-center icon-success">
                <i class="tim-icons icon-single-02"></i>
              </div>
            </div>
            <div class="col-7">
              <div class="numbers">
                <p class="card-category"></p>
                <h3 class="card-title"></h3>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category"></h5>
          <h3 class="card-title"><i class="tim-icons icon-bell-55 text-primary"></i> 20</h3>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="chartLineOrange"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category"></h5>
          <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> 3,500</h3>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="CountryChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category"></h5>
          <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> 30</h3>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="chartLineGreen"></canvas>
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
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();
      demo.initVectorMap();
    });
  </script>
@endpush
