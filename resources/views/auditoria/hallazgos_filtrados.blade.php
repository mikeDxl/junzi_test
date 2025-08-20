@extends('home', ['activePage' => 'Auditorias', 'menuParent' => 'laravel', 'titlePage' => __('Desvinculados')])


@section('contentJunzi')
<div class="content">
    <div class="container-fluid">
    <h1>Filtrar Hallazgos</h1>
    <form method="GET" action="{{ route('reporte.filtrado') }}">
        <div class="row">
            <div class="col-md-3">
                <label for="area">Área</label>
                <select id="area" name="area" class="form-control">
                    <option value="todas">Todas las áreas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->clave }}">{{ $area->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="responsable">Responsables</label>
                <select id="responsable" name="responsable" class="form-control">
                    <option value="todos">Todos los responsables</option>
                    @foreach($responsables as $responsable)
                        <option value="{{ $responsable->id }}">
                            {{ $responsable->nombre . ' ' . $responsable->apellido_paterno }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="jefe">Jefes</label>
                <select id="jefe" name="jefe" class="form-control">
                    <option value="todos">Todos los jefes</option>
                    @foreach($jefes as $jefe)
                        <option value="{{ $jefe->id }}">
                            {{ $jefe->nombre . ' ' . $jefe->apellido_paterno }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="desde">Fecha Desde</label>
                <input type="date" id="desde" name="desde" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="hasta">Fecha Hasta</label>
                <input type="date" id="hasta" name="hasta" class="form-control">
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>
    </div>
</div>


@endsection

