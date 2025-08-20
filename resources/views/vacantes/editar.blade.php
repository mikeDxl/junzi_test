@extends('layouts.app', ['activePage' => 'Vacantes', 'menuParent' => 'laravel', 'titlePage' => __('Vacantes')])

@section('content')

     <div class="content">
    <form action="{{ route('vacantes.update', $vacante->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="company_id" class="form-label">Empresa</label>
                <select class="form-control colabselect" id="company_id" name="company_id" required>
                    <option value="">Seleccione una empresa</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ $vacante->company_id == $empresa->id ? 'selected' : '' }}>
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
                        <option value="{{ $departamento->id }}" {{ $vacante->departamento_id == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->departamento }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="solicitadas" class="form-label">Solicitadas</label>
                <input type="number" class="form-control" id="solicitadas" name="solicitadas" value="{{ $vacante->solicitadas }}" required>
            </div>

            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select class="form-control " id="prioridad" name="prioridad">
                    <option value="Alta" {{ $vacante->prioridad == 'Alta' ? 'selected' : '' }}>Alta</option>
                    <option value="Media" {{ $vacante->prioridad == 'Media' ? 'selected' : '' }}>Media</option>
                    <option value="Baja" {{ $vacante->prioridad == 'Baja' ? 'selected' : '' }}>Baja</option>
                </select>
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="puesto_id" class="form-label">Puesto</label>
                <select class="form-control colabselect" id="puesto_id" name="puesto_id" required>
                    <option value="">Seleccione un puesto</option>
                    @foreach ($puestos as $puesto)
                        <option value="{{ $puesto->id }}" {{ $vacante->puesto_id == $puesto->id ? 'selected' : '' }}>
                            {{ $puesto->puesto }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="jefe" class="form-label">Jefe directo</label>
                <select class="form-control colabselect" id="jefe" name="jefe">
                    @foreach ($colaboradores as $colaborador)
                        <option value="{{ $colaborador->id }}" {{ $vacante->jefe == $colaborador->id ? 'selected' : '' }}>
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
                        <option value="{{ $centro->id }}" {{ $vacante->area_id == $centro->id ? 'selected' : '' }}>
                            {{ $centro->centro_de_costo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $vacante->fecha }}">
            </div>
        </div>
    </div>

   <div class="row">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-info">Guardar Cambios</button>
    </div>
   </div>
</form>



    <hr>
    <form action="{{ route('vacantes.destroy', $vacante->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-danger" type="submit">
                    Eliminar
                </button>
            </div>
        </div>
    </form>



     </div>

@endsection
