# Lista de tablas
$tablas = @(
'asistencias'
'auditorias'
'bajas'
'bancos'
'beneficiarios_colaborador'
'candidatos'
'catalogo_centros_de_costos'
'catalogo_departamentos'
'catalogo_proyectos'
'catalogo_puestos'
'catalogo_ubicaciones'
'centro_de_costos'
'colaboradores_centros_de_costos'
'colaboradores_empresa'
'comentario_hallazgos'
'companies'
'conceptos'
'conceptos_incidencias'
'conexiones'
'config_entregas_auditoria'
'config_entregas_jefatura'
'datos_baja'
'departamento_centros_de_costos'
'departamento_colaboradores'
'departamentos'
'desvinculados'
'dias_vacaciones'
'direcciones_colaboradores'
'direcciones_organigrama'
'documentos_colaboradores'
'entregas_auditoria'
'entregas_jefatura'
'estado_civil'
'estatus_vacantes'
'evaluaciones'
'externos'
'failed_jobs'
'familiares_colaborador'
'generos'
'gratificaciones'
'grupos'
'grupos_colaboradores'
'hallazgo_archivos'
'hallazgos'
'hallazgos_estatus'
'headcount'
'horarios'
'horas_extra'
'incapacidades'
'mensajes'
'migrations'
'motivos_rechazo'
'notificaciones'
'organigrama_colaboradores'
'organigrama_lineal'
'organigrama_lineal_niveles'
'organigrama_matricial'
'organigramas'
'password_resets'
'periodos'
'permisos'
'personal_access_tokens'
'preguntas_reclutamiento'
'proceso_reclutamiento'
'procesos'
'proyectos'
'puestos'
'puestos_centros_de_costos'
'puestos_colaborador'
'puestos_departamento'
'puestos_empresa'
'registro_patronal'
'solicitudes'
'tabla_isr'
'tablero'
'tablero_nomina'
'telescope_entries'
'telescope_entries_tags'
'telescope_monitoring'
'tipos_de_periodo'
'tipos_de_solicitudes'
'tipos_de_turno_de_trabajo'
'tiposde_solicitudes'
'titulos_hallazgos'
'trazabilidad_ventas'
'ubicaciones'
'ubicaciones_colaborador'
'users'
'vacaciones'
'vacaciones_historico'
'vacaciones_pendientes'
'vacantes'
'vacantes_generadas'
'vacantes_objetivos'
'valores'
)

# Array para errores
$errores = @()

Write-Host "Iniciando proceso de migraciones..."

foreach ($tabla in $tablas) {
    Write-Host "Generando migración para tabla: $tabla"
    php artisan make:migracion "$tabla"
    if ($LASTEXITCODE -ne 0) {
        $errores += "Error en make:migracion para $tabla"
    }

    Write-Host "Ejecutando migrar comando para tabla: $tabla"
    php artisan migrar:"$tabla"
    if ($LASTEXITCODE -ne 0) {
        $errores += "Error en migrar comando para $tabla"
    }
}

Write-Host ""
Write-Host "==== Resumen de errores ===="
if ($errores.Count -eq 0) {
    Write-Host "No se detectaron errores, todo se ejecutó correctamente."
} else {
    foreach ($error in $errores) {
        Write-Host $error
    }
}
