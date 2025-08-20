@extends('layouts.app', ['activePage' => 'Vacantes', 'menuParent' => 'laravel', 'titlePage' => __('Vacantes')])

@section('content')
    <div class="content">
        <form action="{{ route('vacantes.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Columna 1 -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="company_id" class="form-label">Empresa</label>
                        <select class="form-control colabselect" id="company_id" name="company_id" required>
                            <option value="">Seleccione una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">
                                    {{ $empresa->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="departamento_id" class="form-label">Departamento</label>
                        <select class="form-control colabselect" id="departamento_id" name="departamento_id" required>
                            <option value="">Seleccione un departamento</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">
                                    {{ $departamento->departamento }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="solicitadas" class="form-label">Solicitadas</label>
                        <input type="number" class="form-control" id="solicitadas" name="solicitadas" required>
                    </div>

                    <div class="mb-3">
                        <label for="prioridad" class="form-label">Prioridad</label>
                        <select class="form-control" id="prioridad" name="prioridad">
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nivel" class="form-label">Nivel</label>
                        <input type="number" class="form-control" id="nivel" name="nivel" min="2" required>
                    </div>

                </div>

                <!-- Columna 2 -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="puesto_id" class="form-label">Puesto</label>
                        <select class="form-control colabselect" id="puesto_id" name="puesto_id" required>
                            <option value="">Seleccione un puesto</option>
                            @foreach ($puestos as $puesto)
                                <option value="{{ $puesto->id }}">
                                    {{ $puesto->puesto }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="completadas" class="form-label">Completadas</label>
                        <input type="number" class="form-control" id="completadas" name="completadas">
                    </div>

                    <div class="mb-3">
                        <label for="jefe" class="form-label">Jefe directo</label>
                        <select class="form-control colabselect" id="jefe" name="jefe">
                        <option value="">Seleccione un jefe directo</option>
                            @foreach ($colaboradores as $colaborador)
                                <option value="{{ $colaborador->id }}">
                                    {{ $colaborador->nombre }} {{ $colaborador->apellido_paterno }} {{ $colaborador->apellido_materno }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="area_id" class="form-label">Centro de costo</label>
                        <select class="form-control colabselect" id="area_id" name="area_id" required>
                            <option value="">Seleccione un centro de costo</option>
                            @foreach ($centros as $centro)
                                <option value="{{ $centro->id }}">
                                    {{ $centro->centro_de_costo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-info">Crear Vacante</button>
                </div>
            </div>
        </form>
    </div>
@endsection
