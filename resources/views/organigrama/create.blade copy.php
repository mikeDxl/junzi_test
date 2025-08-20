@extends('layouts.app', ['activePage' => 'Organigrama', 'menuParent' => 'laravel', 'titlePage' => __('Organigrama')])

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
<div class="container">
    <style>
        td, th { font-size:9pt; }


    </style>

    <h2>Agregar colaborador al organigrama</h2>

    <form action="{{ route('organigrama.store') }}" method="POST">
        @csrf


        <div class="form-group">
            <label for="colaborador_id">Colaborador</label>
            <select name="colaborador_id" id="colaborador_id" class="form-control colabselect" required>
                <option value="">Selecciona un Colaborador</option>
                <option value="0">Vacante</option>
                @foreach($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}">{{ qcolab($colaborador->id) }}</option>
                @endforeach
            </select>
            @error('colaborador_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jefe_directo_id">Jefe Directo</label>
            <select name="jefe_directo_id" id="jefe_directo_id" class="form-control colabselect" required>
                @if($last == NULL)
                    <option value="0">Sin jefe directo</option>
                @else
                    <option value="{{ $last->jefe_directo_id }}">{{ qcolab($last->jefe_directo_id) }}</option>
                @endif

                @foreach($jefes as $jefe)
                    @if($jefe->jefe_directo_id=='0')
                    <option value="{{ $jefe->id }}">VACANTE</option>
                    @else
                    <option value="{{ $jefe->id }}">{{ qcolab($jefe->id) }}</option>
                    @endif
                @endforeach
            </select>
            @error('jefe_directo_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="puesto">Puesto</label>
            <input type="text" class="form-control" name="puesto" id="puesto" readonly>
            <div id="id_puesto" style="display:none!important;">
                <select name="id_puesto" class="form-control colabselect">
                    <option value="">Selecciona un puesto</option>
                    @foreach($catalogo_puestos as $puesto)
                        <option value="{{ $puesto->id }}">{{ $puesto->puesto }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-info btn-sm">Guardar</button>
    </form>

    <br>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nivel</th>
                        <th>Colaborador</th>
                        <th>Puesto</th>
                        <th>Jefe directo</th>
                        <th>Area</th>
                        <th>Código</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($organigrama as $org)
                        <tr>
                            <td>{{ $org->nivel }}</td>
                            <td>
                                @if($org->colaborador_id == '0')
                                    @if($org->nivel=='1')
                                    @else
                                        Vacante
                                    @endif
                                @else
                                    {{ qcolab($org->colaborador_id) }}
                                @endif
                            </td>
                            <td>{{ catalogopuesto($org->puesto) }}</td>
                            <td>
                                @if($org->jefe_directo_id == '0')
                                    @if($org->nivel=='1')
                                    @else
                                        Vacante
                                    @endif
                                @else
                                    {{ qcolab($org->jefe_directo_id) }}
                                @endif
                            </td>

                            <td>{{ nombrecc($org->cc) }}</td>
                            <td>{{ $org->codigo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <ul>
            @foreach ($niveles as $colaborador)
                @php $left = 20 * $colaborador->nivel; @endphp  {{-- Aumenta el espaciado por nivel --}}
                <li style="margin-left: {{ $left }}px;">
                    Nivel {{ $colaborador->nivel }} - {{ $colaborador->puesto }} ({{ $colaborador->codigo }})
                </li>
            @endforeach
        </ul>
        </div>
    </div>
</div>

</div>

<script>
    // Detecta el cambio en el select de colaboradores
    document.getElementById('colaborador_id').addEventListener('change', function() {
        var colaboradorId = this.value; // obtiene el id del colaborador seleccionado

        if (colaboradorId) {
            // Obtener el token CSRF desde el meta tag (esto debe estar en tu layout)
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Realiza una solicitud AJAX para obtener el puesto del colaborador
            fetch(`/colaborador/${colaboradorId}/puesto`, {
                method: 'GET', // Método GET ya que solo estamos obteniendo información
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Agregar el token CSRF al encabezado
                }
            })
                .then(response => response.json())
                .then(data => {
                if (data.success) {
                    // Si se encontró el puesto, asignarlo y ocultar el select
                    document.getElementById('puesto').value = data.puesto;
                    document.getElementById('puesto').style.display = 'block';
                    document.getElementById('id_puesto').style.display = 'none';
                } else {
                    // Si no se encuentra, ocultar input y mostrar select
                    document.getElementById('puesto').style.display = 'none';
                    document.getElementById('id_puesto').style.display = 'block';
                    document.getElementById('puesto').value = ''; // Limpiar input
                   // alert(data.message);
                }
                })
                .catch(error => {
                    console.error('Error:', error);
                   // alert('Ocurrió un error al obtener el puesto.');
                    document.getElementById('puesto').style.display = 'none';
                    document.getElementById('id_puesto').style.display = 'block';
                });
        } else {
            // Si no se seleccionó un colaborador, limpiar el puesto
            document.getElementById('puesto').value = '';
            document.getElementById('puesto').style.display = 'none';
             document.getElementById('id_puesto').style.display = 'block';
        }
    });
</script>


@endsection
