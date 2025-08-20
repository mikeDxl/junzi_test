@extends('layouts.app', ['activePage' => 'Vacantes', 'menuParent' => 'laravel', 'titlePage' => __('Vacantes')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Vacantes</h4>
              </div>
              <div class="card-body">
                <div class="col-md-12 text-end" style="text-align:right;">
                  <a href="/vacantes">Ver actuales</a>
                </div>
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <h5 class="card-title">Proceso de Reclutamiento</h5>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table" id="datatables">
                            <thead class="text-primary">
                              <tr>
                                <th>
                                  Prioridad
                                </th>
                                <th>
                                  # Candidatos
                                </th>
                                <th>
                                  Puesto
                                </th>
                                <th>
                                  Proceso
                                </th>
                                <th class="text-right">
                                  Tiempo abierta
                                </th>
                                <th class="text-right">
                                  Seguimiento
                                </th>
                              </tr>
                            </thead>
                            <tbody>

                              @foreach($vacantes as $vac)
                                <tr>
                                  <td>{{ $vac->prioridad }}</td>
                                  <td>
                                    {{ cuantoscandidatos($vac->id) }}
                                  </td>
                                  <td>
                                    {{ catalogopuesto($vac->puesto_id) }} @if(buscarperfil($vac->puesto_id)) <span> <a target="_blank" href="storage/{{ buscarperfil($vac->puesto_id) }}"> <i class="tim-icons icon-cloud-download-93"></i> </a> </span> @endif
                                    <br><small>{{ $vac->area }}</small>
                                    <br><small>{{ $vac->codigo }}</small>
                                    <br><small>{{ nombre_empresa($vac->company_id) }}</small>
                                  </td>
                                  <td class="text-center">
                                    {{ $vac->completadas.'/'.$vac->solicitadas }}
                                  </td>
                                  <td class="text-right text-success">
                                    @php
                                        // Calcular los días activos
                                        $diasActiva = \Carbon\Carbon::parse($vac->fecha)->diffInDays(\Carbon\Carbon::now());
                                        // Formatear la fecha sin la hora (si es necesario)
                                        $fechaFormateada = str_replace(' 12:00:00 AM', '', $vac->fecha);
                                    @endphp


                                       {{ $fechaFormateada }} ({{ $diasActiva }} días activa)

                                  </td>
                                  <td class="text-right">
                                    <a href="/proceso_vacante/{{ $vac->id }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-minimal-right"></i></a>
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
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')

@endpush
