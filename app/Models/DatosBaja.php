<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosBaja extends Model
{
    use HasFactory;

    protected $table = 'datos_baja';

    protected $fillable = [
        'salario_radio',
        'salario_diario',
        'salario_diario_integral', // Nueva columna
        'salario_nuevo',           // Nueva columna
        'baja_id',
        'colaborador_id',
        'fecha_baja',
        'motivo_baja',
        's_salario_normal',        // Nueva columna
        'd_salario_normal',
        'salario_normal',
        's_aguinaldo',             // Nueva columna
        'd_aguinaldo',
        'd2_aguinaldo',
        'aguinaldo',
        's_vacaciones',            // Nueva columna
        'd_vacaciones',
        'vacaciones',
        's_vacaciones_pend',            // Nueva columna
        'd_vacaciones_pend',
        'vacaciones_pend',
        's_primavacacional',       // Nueva columna
        'd_primavacacional',
        'prima_vacacional',
        's_primavacacional_pend',       // Nueva columna
        'd_primavacacional_pend',
        'prima_vacacional_pend',
        's_incentivo',             // Nueva columna
        'd_incentivo',
        'incentivo',
        's_prima_de_antiguedad',   // Nueva columna
        'd_prima_de_antiguedad',
        'prima_de_antiguedad',
        's_gratificacion',         // Nueva columna
        'd_gratificacion',
        'gratificacion',
        's_veinte_dias',          // Nueva columna
        'd_veinte_dias',
        'veinte_dias',
        's_despensa',             // Nueva columna
        'd_despensa',
        'despensa',
        's_isr',                  // Nueva columna
        'isr',
        's_imss',                 // Nueva columna
        'imss',
        's_deudores',             // Nueva columna
        'deudores',
        's_isr_finiquito',        // Nueva columna
        'isr_finiquito',
        'percepciones',
        'deducciones',
        'total',
        'comprobante',
        'fecha_elaboracion',
        'periodo_isr',
        'uma',
        'salario_minimo',                    // Nueva columna
        // Puedes agregar created_at y updated_at si es necesario
    ];

    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class, 'colaborador_id');
    }

    // Agrega otras relaciones si es necesario
}
