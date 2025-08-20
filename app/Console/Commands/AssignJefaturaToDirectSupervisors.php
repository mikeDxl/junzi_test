<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrganigramaLinealNiveles;
use App\Models\User;

class AssignJefaturaToDirectSupervisors extends Command
{
    // El nombre y la firma del comando (lo que escribirás en la terminal para ejecutarlo)
    protected $signature = 'assign:jefatura';

    // La descripción del comando
    protected $description = 'Asigna el perfil de Jefatura a los usuarios cuyo jefe_directo_id aparece en la tabla organigrama_lineal_niveles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener todos los registros donde jefe_directo_id no es nulo
        $niveles = OrganigramaLinealNiveles::whereNotNull('jefe_directo_id')
            ->select('jefe_directo_id')
            ->get();

        foreach ($niveles as $nivel) {
            // Buscar el usuario correspondiente en la tabla Users
            $user = User::where('colaborador_id', $nivel->jefe_directo_id)->first();

            if ($user) {
                // Asignar el perfil de Jefatura
                $user->perfil = 'Jefatura';
                $user->rol = 'Jefatura';
                $user->save();

                $this->info("Perfil de Jefatura asignado al usuario con colaborador_id: {$nivel->jefe_directo_id}");
            } else {
                $this->info("No se encontró un usuario con colaborador_id: {$nivel->jefe_directo_id}");
            }
        }

        return 0;
    }
}
