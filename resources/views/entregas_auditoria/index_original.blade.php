@extends('layouts.app', ['activePage' => 'Entregables', 'menuParent' => 'forms', 'titlePage' => __('Entregas de Auditoría')])

@section('content')
    <div class="content">
        <h2>Listado de Entregas de Auditoría</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <style>
            /* Estilo para las Tabs */
.nav-tabs .nav-link {
    background-color: #495057!important;
    border: 1px solid #dee2e6!important;
    color: #dee2e6!important;
    margin-right: 5px;
    border-radius: 0.25rem;
}

.nav-tabs .nav-link.active {
    background-color: #007bff!important;
    color: #fff!important;
    border-color: #007bff!important;
}

.nav-tabs .nav-link:hover {
    background-color: #007bff!important;
    color: #007bff1!important;
}

.tab-content {
    border: 1px solid #dee2e6!important;
    border-top: none!important;
    background-color: #ffffff!important;
    padding: 20px;
    border-radius: 0 0 0.25rem 0.25rem;
}

        </style>
        <!-- Botón para crear nueva entrega -->
        <div class="row">
            <div class="col-md-10">
                <a href="{{ route('entregas_auditoria.create') }}" class="btn btn-info mb-3">Programar Entregable</a>
            </div>
            <div class="col-md-2">
                @if(auth()->user()->auditoria=="1")
                <a class="btn btn-link" href="/config-entregas-auditoria"> <i class="fa fa-cog"></i> </a>
                @endif
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="entregasTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pendientes-tab" data-bs-toggle="tab" data-bs-target="#pendientes" type="button" role="tab" aria-controls="pendientes" aria-selected="true">
                    Pendientes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="enviadas-tab" data-bs-toggle="tab" data-bs-target="#enviadas" type="button" role="tab" aria-controls="enviadas" aria-selected="false">
                    Enviadas
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completadas-tab" data-bs-toggle="tab" data-bs-target="#completadas" type="button" role="tab" aria-controls="completadas" aria-selected="false">
                    Completadas
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="detenidas-tab" data-bs-toggle="tab" data-bs-target="#detenidas" type="button" role="tab" aria-controls="detenidas" aria-selected="false">
                    Detenidas
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="entregasTabsContent">
            <!-- Tab Pendientes -->
            <div class="tab-pane fade show active" id="pendientes" role="tabpanel" aria-labelledby="pendientes-tab">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Reporte</th>
                            <th>Responsable</th>
                            <th>Jefe Directo</th>
                            <th>Fecha de Entrega</th>
                            <th>Fecha Completada</th>
                            <th>Días de Retraso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entregas_pendientes as $entrega)
                            <tr>
                                <td>{{ $entrega->configReporte->reporte ?? 'No especificado' }}</td>
                                <td>{{ qcolab($entrega->responsable) }}</td>
                                <td>{{ qcolab($entrega->jefe_directo) }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</td>
                                <td>{{ $entrega->fecha_completada }}</td>
                                <td>
                                    @php
                                        $fechaEntrega = \Carbon\Carbon::parse($entrega->fecha_de_entrega);
                                        $hoy = \Carbon\Carbon::now();
                                        $diferencia = $hoy->diffInDays($fechaEntrega, false);
                                    @endphp

                                    @if ($diferencia >= 0)
                                        {{ $diferencia }} días restantes
                                    @else
                                        {{ abs($diferencia) }} días de retraso
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('entregas_auditoria.detenido') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                        <button type="submit" class="btn btn-link text-success"> <i class="fa fa-pause"></i> </button>
                                    </form>
                                    <form action="{{ route('entregas_auditoria.eliminar') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                        <button type="submit"  class="btn btn-link text-danger"> <i class="fa fa-trash"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab Enviadas -->
            <div class="tab-pane fade" id="enviadas" role="tabpanel" aria-labelledby="enviadas-tab">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Reporte</th>
                            <th>Responsable</th>
                            <th>Jefe Directo</th>
                            <th>Fecha de Entrega</th>
                            <th>Fecha Completada</th>
                            <th>Acciones</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entregas_enviadas as $entrega)
                            <tr>
                                <td>{{ $entrega->configReporte->reporte ?? 'No especificado' }}</td>
                                <td>{{ qcolab($entrega->responsable) }}</td>
                                <td>{{ qcolab($entrega->jefe_directo) }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</td>
                                <td>{{ $entrega->fecha_completada }}</td>
                                <td>
                                    <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" download>Descargar entregable</a>
                                </td>
                                <td>
                                    <form action="{{ route('entregas_auditoria.completar') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                        <button type="submit"  class="btn btn-link text-success"> <i class="fa fa-check"></i> </button>
                                    </form>
                                    <form action="{{ route('entregas_auditoria.eliminar') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                        <button type="submit"  class="btn btn-link text-danger"> <i class="fa fa-times"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab Completadas -->
            <div class="tab-pane fade" id="completadas" role="tabpanel" aria-labelledby="completadas-tab">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Reporte</th>
                            <th>Responsable</th>
                            <th>Jefe Directo</th>
                            <th>Fecha de Entrega</th>
                            <th>Fecha Completada</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entregas_completadas as $entrega)
                            <tr>
                                <td>{{ $entrega->configReporte->reporte ?? 'No especificado' }}</td>
                                <td>{{ qcolab($entrega->responsable) }}</td>
                                <td>{{ qcolab($entrega->jefe_directo) }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</td>
                                <td>{{ $entrega->fecha_completada }}</td>
                                <td>
                                    <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" download>Descargar entregable</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab Detenidas -->
            <div class="tab-pane fade" id="detenidas" role="tabpanel" aria-labelledby="detenidas-tab">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Reporte</th>
                            <th>Responsable</th>
                            <th>Jefe Directo</th>
                            <th>Fecha de Entrega</th>
                            <th>Fecha Completada</th>
                            <th>Descargar</th>
                            <th>Activar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entregas_detenidas as $entrega)
                            <tr>
                                <td>{{ $entrega->configReporte->reporte ?? 'No especificado' }}</td>
                                <td>{{ qcolab($entrega->responsable) }}</td>
                                <td>{{ qcolab($entrega->jefe_directo) }}</td>
                                <td>{{ str_replace(' 00:00:00.000','',$entrega->fecha_de_entrega) }}</td>
                                <td>{{ $entrega->fecha_completada }}</td>
                                <td>
                                    <a href="/storage/app/public/archivos_adjuntos/{{ $entrega->archivo_adjunto }}" download>Descargar entregable</a>
                                </td>
                                <td>
                                    <form action="{{ route('entregas_auditoria.activar') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $entrega->id }}" name="entrega_id">
                                        <button type="submit"  class="btn btn-link text-success"> <i class="fa fa-play"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
