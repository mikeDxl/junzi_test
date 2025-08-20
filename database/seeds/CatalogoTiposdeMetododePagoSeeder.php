<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTiposdeMetododePagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('catalogo_de_tipos_de_metodo_de_pago')->truncate();

        DB::table('catalogo_de_tipos_de_metodo_de_pago')->insert([
            ['tipo' => 'Efectivo' , 'nomipaq' => '01'],
            ['tipo' => 'Cheque nominativo' , 'nomipaq' => '02'],
            ['tipo' => 'Transferencia Electrónica', 'nomipaq' => '03'],
            ['tipo' => 'Tarjeta de crédito' , 'nomipaq' => '04'],
            ['tipo' => 'Monedero electrónico' , 'nomipaq' => '05'],
            ['tipo' => 'Monedero electrónico' , 'nomipaq' => '06'],
            ['tipo' => 'Dinero electrónico' , 'nomipaq' => '07'],
            ['tipo' => 'Vales de despensa' , 'nomipaq' => '08'],
            ['tipo' => 'Dación en pago' , 'nomipaq' => '12'],
            ['tipo' => 'Pago por subrogación' , 'nomipaq' => '13'],
            ['tipo' => 'Pago por consignación', 'nomipaq' => '14' ],
            ['tipo' => 'Condonación' , 'nomipaq' => '15'],
            ['tipo' => 'Compensación', 'nomipaq' => '17' ],
            ['tipo' => 'Novación' , 'nomipaq' => '23'],
            ['tipo' => 'Confusión' , 'nomipaq' => '24'],
            ['tipo' => 'Remisión de deuda' , 'nomipaq' => '25'],
            ['tipo' => 'Prescripción o caducidad' , 'nomipaq' => '26' ],
            ['tipo' => 'A satisfacción del acreedor' , 'nomipaq' => '27' ],
            ['tipo' => 'Tarjeta de débito' , 'nomipaq' => '28' ],
            ['tipo' => 'Tarjeta de servicios' , 'nomipaq' => '29' ],
            ['tipo' => 'Por definir' , 'nomipaq' => '99' ],
        ]);
    }
}
