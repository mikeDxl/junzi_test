@include('layouts.header')
<body class="text-start">
      @include('layouts.menu')
    <div class="main-content">
      <div class="breadcrumb">
        <h1>Candidatos</h1>
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
                  <div class="card-header text-end bg-transparent">
                      <a href="/alta-candidato"><button type="button" class="btn btn-primary btn-md m-1"><i class="i-Add-User text-white me-2"></i> Agregrar candidato</button></a>
                  </div>
                  <div class="card-body">

                      <div class="table-responsive">
                          <table id="ul-contact-list" class="display table " style="width:100%">
                              <thead>
                                  <tr>
                                      <th>Nombre</th>
                                      <th>Apellido paterno</th>
                                      <th>Apellido materno</th>
                                      <th>Edad</th>
                                      <th>Estatus</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($candidatos as $cand)
                                <tr>
                                  <td>{{ $cand->nombre }}</td>
                                  <td>{{ $cand->apellido_paterno }}</td>
                                  <td>{{ $cand->apellido_materno }}</td>
                                  <td>{{ $cand->edad }}</td>
                                  <td>{{ $cand->estatus }}</td>
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
