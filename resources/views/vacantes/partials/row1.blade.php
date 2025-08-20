<!-- vacantes/partials/row.blade.php -->
<tr>
    <td>{{ $vac->prioridad }}</td>
    <td>{{ cuantoscandidatos($vac->id) }}</td>
    <td>
        {{ catalogopuesto($vac->puesto_id) }}
        @if(buscarperfil($vac->puesto_id))
            <span><a target="_blank" href="storage/{{ buscarperfil($vac->puesto_id) }}"><i class="tim-icons icon-cloud-download-93"></i></a></span>
        @endif
        <br><small>{{ $vac->area }}</small>
        <br><small>{{ $vac->codigo }}</small>
        <br><small>{{ nombre_empresa($vac->company_id) }}</small>
    </td>
    <td class="text-center">{{ $vac->completadas.'/'.$vac->solicitadas }}</td>

    @if($tab == 'enEspera')
        <td class="text-right text-success">
            @php
                $fechaAlta = $vac->altas()->latest('fecha_alta')->first()->fecha_alta ?? 'No disponible';
            @endphp
            {{ $fechaAlta != 'No disponible' ? \Carbon\Carbon::parse($fechaAlta)->format('d/m/Y') : $fechaAlta }}
        </td>
    @elseif($tab == 'historico')
        <td class="text-right text-info">
            @php
                $ultimaModificacion = \Carbon\Carbon::parse($vac->updated_at)->format('d/m/Y');
            @endphp
            {{ $ultimaModificacion }}
        </td>
    @else
        <td class="text-right text-success">
            @php
                $diasActiva = \Carbon\Carbon::parse($vac->fecha)->diffInDays(\Carbon\Carbon::now());
                $fechaFormateada = str_replace(' 12:00:00 AM', '', $vac->fecha);
            @endphp
            {{ $fechaFormateada }} ({{ $diasActiva }} días activa)
        </td>
    @endif

    <td class="text-right">
        <a href="/proceso_vacante/{{ $vac->id }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-minimal-right"></i></a>
    </td>
</tr>
