<?php

namespace Database\Seeders;

use App\Models\CatalogosdeTiposdeContratos;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UserSeeder::class);
        $this->call(EstadosSeeder::class);
       // $this->call(GeneroSeeder::class);
        $this->call(AforeSeeder::class);
       // $this->call(EstadoCivilSeeder::class);
        $this->call(CatalogoTiposdeBasedeCotizacionSeeder::class);
        $this->call(CatalogoTiposdeBasedePagoSeeder::class);
        $this->call(CatalogoTiposdeContratosSeeder::class);
        $this->call(CatalogoTiposdeJornadaSeeder::class);
        $this->call(CatalogoTiposdeMetododePagoSeeder::class);
        $this->call(CatalogoTiposdePeriodoSeeder::class);
        $this->call(CatalogoTiposdePrestacionSeeder::class);
        $this->call(CatalogoTiposdeRegimenSeeder::class);
        $this->call(CatalogoTiposdeTurnodeTrabajoSeeder::class);
        $this->call(CatalogoTiposdeZonadeSalarioSeeder::class);
        //$this->call(EstadoCivilSeeder::class);
    }
}
