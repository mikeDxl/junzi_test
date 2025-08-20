<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaboradores extends Model
{
    use HasFactory;

    protected $table = 'colaboradores';

    protected $dates = ['fecha_alta'];

    protected $fillable = [
        'numero_de_empleado',
        'company_id',
        'departamento_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'telefono',
        'celular',
        'fotografia',
        'genero',
        'sueldo',
        'puesto',
        'rfc',
        'curp',
        'jefe_directo',
        'periodo_id',
        'salario_diario',
        'base_de_cotizacion_id',
        'sbc_parte_fija',
        'sbc_parte_variable',
        'sbc',
        'sindicalizado',
        'prestacion_id',
        'base_de_pago_id',
        'metodo_de_pago_id',
        'turno_de_trabajo_id',
        'zona_de_salario_id',
        'jornada_id',
        'regimen_id',
        'fonacot',
        'afore_id',
        'email',
        'nss',
        'registro_patronal_id',
        'umf',
        'estado_civil_id',
        'fecha_alta',
        'fecha_baja',
        'cuenta_cheques',
        'banco',
        'estado_nacimiento',
        'ciudad_nacimiento',
        'clabe_interbancaria',
        'afore',
        'estatus',
        'organigrama',
        'proyectos',
        'ubicaciones',
        'estado',
        'poblacion',
        'direccion',
        'codigopostal',
        'tipo_de_contrato_id',
        'estadoempleado',
        'idempleado',
        'sueldovariable',
        'sueldointegrado',
        'csueldomixto',
        'causabaja',
        'tipo_de_sangre',
        'tiene_alergia',
        'alergias'
    ];



    // Relación muchos a muchos con CatalogoPuestos a través de PuestosColaboradores
    public function catalogoPuestos()
    {
        return $this->belongsToMany(CatalogoPuestos::class, 'puestos_colaborador', 'id_colaborador', 'id_catalogo_puesto_id');
    }

    // Relación muchos a muchos con DepartamentosColaboradores
    public function departamentosColaboradores()
    {
        return $this->belongsToMany(DepartamentosColaboradores::class, 'departamento_colaboradores', 'colaborador_id', 'id_catalogo_departamento_id');
    }

    // Relación muchos a muchos con CatalogoDepartamentos a través de DepartamentosColaboradores
    public function catalogoDepartamentos()
    {
        return $this->belongsToMany(CatalogoDepartamentos::class, 'departamento_colaboradores', 'colaborador_id', 'id_catalogo_departamento_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    // Relación con el modelo ColaboradoresEmpresa
    public function colaboradoresEmpresa()
    {
        return $this->hasMany(ColaboradoresEmpresa::class, 'colaborador_id');
    }

    public static function cumpleanerosDelMes()
    {
        // Obtener el mes actual
        $mesActual = Carbon::now()->month;

        // Filtrar colaboradores con estatus activo y cuyo cumpleaños sea en el mes actual
        return self::where('estatus', 'activo')
                    ->whereMonth('fecha_nacimiento', $mesActual)
                    ->get();
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupos_colaboradores', 'colaborador_id', 'grupo_id');
    }

    public function mensajes()
    {
        return $this->hasManyThrough(Mensaje::class, GrupoColaborador::class, 'colaborador_id', 'grupo_id', 'id', 'grupo_id');
    }

    public function centroDeCosto()
    {
        return $this->belongsTo(CentroDeCosto::class);
    }

    public function puestos()
    {
        return $this->belongsToMany(CatalogoPuestos::class, 'puestos_colaborador', 'id_colaborador', 'id_catalogo_puesto_id');
    }


    public function catalogoCentroDeCostos()
    {
        return $this->hasOne(ColaboradoresCC::class, 'colaborador_id');
    }

    public function puestosColaboradores()
    {
        return $this->hasMany(PuestosColaboradores::class, 'id_colaborador');
    }

    public function bajas()
    {
        return $this->hasMany(Bajas::class, 'colaborador_id');
    }
}
