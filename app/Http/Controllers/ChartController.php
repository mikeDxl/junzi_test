<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function grafico()
    {
        $data = [
            'labels' => ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            'datasets' => [
                [
                    'label' => 'Columna 1',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'data' => [12, 19, 3, 5, 2, 3],
                ],
                [
                    'label' => 'Columna 2',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'data' => [6, 7, 8, 9, 10, 11],
                ],
            ],
        ];

        return response()->json($data);
    }
}
