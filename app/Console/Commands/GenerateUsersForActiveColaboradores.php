<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Colaboradores;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GenerateUsersForActiveColaboradores extends Command
{
    // El nombre y la firma del comando (lo que escribirás en la terminal para ejecutarlo)
    protected $signature = 'generate:users';

    // La descripción del comando
    protected $description = 'Genera usuarios para colaboradores con estatus activo, validando que no exista previamente el colaborador_id';

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
        // Obtener todos los colaboradores con estatus activo
        $colaboradores = Colaboradores::where('estatus', 'activo')
          ->select('id', 'nombre', 'apellido_paterno', 'apellido_materno')
          ->orderBy('apellido_paterno')
          ->get();

        foreach ($colaboradores as $colaborador) {
            // Verificar si ya existe un usuario con este colaborador_id
            $userExists = User::where('colaborador_id', $colaborador->id)->exists();

            if (!$userExists) {
                // Crear un nuevo usuario
                $user = new User();
                $user->name = $colaborador->nombre . ' ' . $colaborador->apellido_paterno . ' ' . $colaborador->apellido_materno;
                $user->email = $this->generateUniqueEmail($colaborador);
                $user->password = Hash::make('Junzi2024!!!'); // Puedes cambiar esto por una contraseña generada o predeterminada
                $user->perfil = 'Colaborador';
                $user->colaborador_id = $colaborador->id;
                $user->rol = 'Colaborador'; // Asignar un rol por defecto
                $user->save();

                $this->info("Usuario creado para el colaborador: {$colaborador->nombre} {$colaborador->apellido_paterno}");
            } else {
                $this->info("El colaborador: {$colaborador->nombre} {$colaborador->apellido_paterno} ya tiene un usuario.");
            }
        }

        return 0;
    }

    private function generateUniqueEmail($colaborador)
    {
        // Eliminar acentos y convertir la ñ a n en el apellido paterno
        $apellidoPaterno = Str::slug($this->removeAccents($colaborador->apellido_paterno), '');

        // Crear el email base
        $baseEmail = strtolower(
            substr($colaborador->nombre, 0, 1) .
            $apellidoPaterno .
            substr($colaborador->apellido_materno, 0, 1)
        );

        $email = $baseEmail . '@gonie.com';
        $counter = 1;
        $maternoLength = strlen($colaborador->apellido_materno);

        // Verificar si el email ya existe
        while (User::where('email', $email)->exists()) {
            if ($counter < $maternoLength) {
                $email = strtolower(
                    substr($colaborador->nombre, 0, 1) .
                    $apellidoPaterno .
                    substr($colaborador->apellido_materno, 0, $counter + 1)
                ) . '@gonie.com';
            } else {
                $email = strtolower($baseEmail . $counter . '@gonie.com');
            }
            $counter++;
        }

        return $email;
    }

    private function removeAccents($string)
    {
        $unwanted_array = [
            'á' => 'a', 'Á' => 'A',
            'é' => 'e', 'É' => 'E',
            'í' => 'i', 'Í' => 'I',
            'ó' => 'o', 'Ó' => 'O',
            'ú' => 'u', 'Ú' => 'U',
            'ñ' => 'n', 'Ñ' => 'N',
        ];
        return strtr($string, $unwanted_array);
    }
}
