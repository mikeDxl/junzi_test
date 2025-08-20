<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Asistencia;

class ImportarAsistencia implements ToModel
{
    public function model(array $row)
    {
        return new Asistencia([
            'fecha' => $row[0], // Asume que la columna 0 es la fecha en el archivo CSV/XLS
            'hora_entrada' => $row[1], // Asume que la columna 1 es la hora de entrada
            'hora_salida' => $row[2], // Asume que la columna 2 es la hora de salida
            // Define aquí cómo asignar los datos a tu modelo de Asistencia
        ]);
    }
}
