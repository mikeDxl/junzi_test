@include('layouts.header')
<body class="text-start">
      @include('layouts.menu')
    <div class="main-content">
      <div class="breadcrumb">
        <h1>Reclutamiento</h1>
      </div>

      <div class="separator-breadcrumb border-top"></div>

    <style>
        .candidato{ text-transform: uppercase; }
        .nav-link{ text-transform: uppercase; }
        .mayus{ text-transform: uppercase;  }
    </style>

    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-start">
                  <div class="card-body">

                      <div class="table-responsive">
                          <table id="ul-contact-list" class="display table " style="width:100%">
                              <thead>
                                  <tr>
                                      <th>Compañia</th>
                                      <th>Departamento</th>
                                      <th>Puesto</th>
                                      <th># de vacantes</th>
                                      <th>Estatus</th>
                                      <th>Proceso</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($vacantes as $vac)
                                      <tr>
                                          <td>{{ empresa($vac->company_id)  }}</td>
                                          <td>{{ depa($vac->departamento , $vac->company_id)  }}</td>
                                          <td>{{ puesto($vac->puesto , $vac->company_id)  }}</td>
                                          <td>{{ $vac->numvacantes  }}</td>
                                          <td>{{ $vac->estatus  }}</td>
                                          <td>
                                              <a href="/proceso-vacantes/{{ $vac->id }}" class="ul-link-action text-success" data-toggle="tooltip"
                                                 data-placement="top" title="Edit">
                                                  <i class="i-Edit"></i>
                                              </a>
                                          </td>
                                      </tr>
                                  @endforeach


                              </tbody>

                          </table>
                      </div>

                  </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.footer')
