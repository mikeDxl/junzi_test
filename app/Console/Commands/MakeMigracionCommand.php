<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeMigracionCommand extends Command
{
    protected $signature = 'make:migracion {name : Nombre de la migracion, por ejemplo Agrupadores}';
    protected $description = 'Crear un comando migrador con signature y description automáticos';

    protected $files;

    public function __construct()
    {
        parent::__construct();

        $this->files = new Filesystem();
    }

    public function handle()
    {
        $name = $this->argument('name');

        // Formateamos el nombre para la clase: Migrar + Nombre (pascal case)
        $className = 'Migrar' . Str::studly($name);

        // Nombre del archivo a crear
        $fileName = app_path("Console/Commands/{$className}.php");

        if ($this->files->exists($fileName)) {
            $this->error("El comando {$className} ya existe.");
            return 1;
        }

        // Generamos el contenido del archivo con signature y description dinámicos
        $tableName = Str::snake($name);

        $stub = $this->getStub();
        $stub = str_replace('{{ namespace }}', 'App\Console\Commands', $stub);
        $stub = str_replace('{{ class }}', $className, $stub);
        $stub = str_replace('{{ table }}', $tableName, $stub);

        // Guardamos el archivo
        $this->files->put($fileName, $stub);

        $this->info("Comando {$className} creado con éxito.");
        $this->info("Usa: php artisan migrar:{$tableName}");

        return 0;
    }

    protected function getStub()
    {
        return <<<'EOT'
<?php

namespace {{ namespace }};

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class {{ class }} extends Command
{
    protected $signature = 'migrar:{{ table }}';
    protected $description = 'Migrar datos de la tabla {{ table }} de SQL Server a MySQL';

    public function handle()
    {
        $this->info('Iniciando migración de la tabla {{ table }}...');

        $datos = DB::connection('sqlsrv')->table('{{ table }}')->get();

        if ($datos->isEmpty()) {
            $this->warn('No hay datos para migrar.');
            return;
        }

        foreach ($datos as $registro) {
            $arrayRegistro = (array) $registro;
            DB::connection('mysql_destino')->table('{{ table }}')->insert($arrayRegistro);
        }

        $this->info('Migración completada con éxito. Total registros: ' . count($datos));
    }
}

EOT;
    }
}
