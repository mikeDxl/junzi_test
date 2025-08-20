<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Colaboradores;
use App\Models\Conexiones;
use App\Models\Actualizacion;


class NominaController extends Controller
{

    public function mostrarAltasBajas()
    {
        $conexiones = Conexiones::all(); // Obtener todas las empresas
        $altasEncontradas = [];
        $bajasEncontradas = [];

        foreach ($conexiones as $conexion) {
            // Obtener la última fecha de actualización registrada para esta empresa
            $ultimaActualizacion = Actualizacion::where('id_company', $conexion->company_id)
                                                ->orderBy('fecha', 'desc')
                                                ->first();

            $fechaUltimaActualizacion = $ultimaActualizacion ? $ultimaActualizacion->fecha : '2025-01-01 00:00:00.000';

            // Configurar la conexión a la base de datos de la empresa
            config([
                'database.connections.empresa' => [
                    'driver' => $conexion->driver,
                    'host' => $conexion->host,
                    'port' => $conexion->port,
                    'database' => $conexion->database,
                    'username' => $conexion->user,
                    'password' => $conexion->password,
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'strict' => false,
                    'engine' => null,
                ]
            ]);

            DB::purge('empresa'); // Limpiar la conexión anterior
            DB::reconnect('empresa'); // Reconectar con la nueva empresa

            // Detectar bajas
            $empleadosBaja = DB::connection('empresa')
                ->table('nom10001')
                ->where('estadoempleado', 'B') // Estado "B" significa baja
                ->where('fechabaja', '>', $fechaUltimaActualizacion) // Filtrar por fecha de baja
                ->pluck('idempleado')
                ->toArray();

            $colaboradoresBajas = DB::table('colaboradores')
                ->where('company_id', $conexion->company_id)
                ->whereIn('idempleado', $empleadosBaja)
                ->where('estatus', '!=', 'inactivo')
                ->get()
                ->map(function ($colaborador) {
                    // Concatenar el nombre completo
                    $colaborador->nombre_completo = $colaborador->nombre . ' ' . $colaborador->apellido_paterno . ' ' . $colaborador->apellido_materno;

                    // Obtener la fecha de baja directamente de la tabla 'nom10001'
                    $colaborador->fecha_baja = DB::connection('empresa')
                        ->table('nom10001')
                        ->where('idempleado', $colaborador->idempleado)
                        ->value('fechabaja');

                    return $colaborador;
                });

            if ($colaboradoresBajas->isNotEmpty()) {
                $bajasEncontradas[] = [
                    'empresa' => $conexion->database,
                    'company_id' => $conexion->company_id,
                    'bajas' => $colaboradoresBajas,
                ];
            }

            // Detectar altas
            $empleadosAlta = DB::connection('empresa')
                ->table('nom10001')
                ->whereDate('fechaalta', '>', $fechaUltimaActualizacion)
                ->pluck('idempleado')
                ->toArray();

            $colaboradoresAltas = DB::table('colaboradores')
                ->where('company_id', $conexion->company_id)
                ->whereIn('idempleado', $empleadosAlta)
                ->get()
                ->map(function ($colaborador) {
                    // Concatenar el nombre completo
                    $colaborador->nombre_completo = $colaborador->nombre . ' ' . $colaborador->apellido_paterno . ' ' . $colaborador->apellido_materno;

                    // Obtener la fecha de alta directamente de la tabla 'nom10001'
                    $colaborador->fecha_alta = DB::connection('empresa')
                        ->table('nom10001')
                        ->where('idempleado', $colaborador->idempleado)
                        ->value('fechaalta');

                    return $colaborador;
                });

            if ($colaboradoresAltas->isNotEmpty()) {
                $altasEncontradas[] = [
                    'empresa' => $conexion->database,
                    'company_id' => $conexion->company_id,
                    'altas' => $colaboradoresAltas,
                ];
            }
        }

        // Retornamos las altas y bajas a la vista
        return view('altas_bajas', [
            'altas' => $altasEncontradas,
            'bajas' => $bajasEncontradas,
        ]);
    }
}
