<?php

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AreasAuditoriaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MensajesController;
use App\Http\Controllers\BajasController;
use App\Http\Controllers\OrganigramaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\ConfigEntregasAuditoriaController;
use App\Http\Controllers\ConfigEntregasJefaturaController;
use App\Http\Controllers\EntregaAuditoriaController;
use App\Http\Controllers\EntregaJefaturaController;
use App\Http\Controllers\TablaISRController;
use App\Http\Controllers\DiasVacacionesController;
use App\Http\Controllers\ValorController;
use App\Http\Controllers\ConfigHallazgosController;
use App\Http\Controllers\TrazabilidadVentaController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\ErrorController;





Route::get('/', function () {
  return view('auth.login');
});

Auth::routes();



// Fallback route para capturar todas las rutas no definidas
  Route::fallback([ErrorController::class, 'notFound'])->name('fallback.404'); 
  Route::get('pricing', 'ExamplePagesController@pricing')->name('page.pricing');
  Route::get('lock', 'ExamplePagesController@lock')->name('page.lock');

  Route::get('home', 'HomeController@index')->name('home');

  Route::middleware('auth')->group(function () {

    //manejo de errores
    Route::prefix('error')->name('error.')->group(function () {
        Route::get('/404', [ErrorController::class, 'notFound'])->name('404');
        Route::get('/403', [ErrorController::class, 'forbidden'])->name('403');
        Route::get('/500', [ErrorController::class, 'serverError'])->name('500');
        Route::get('/419', [ErrorController::class, 'tokenMismatch'])->name('419');
        Route::get('/429', [ErrorController::class, 'tooManyRequests'])->name('429');
    });

    Route::get('/welcome', function () {
        return view('home');
    })->name('welcome');

    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');

    //Route::get('dashboard', 'HomeController@index')->name('home');

    Route::get('/altas-bajas', [NominaController::class, 'mostrarAltasBajas'])->name('altas.bajas');

    Route::resource('trazabilidad_ventas', TrazabilidadVentaController::class);

    Route::get('/reporte_entregables_semanal', [EntregaAuditoriaController::class, 'reporteEntregablesSemanal'])
        ->name('reporte.entregables.semanal');

    Route::get('/reporte_entregables_mensual', [EntregaAuditoriaController::class, 'reporteEntregablesMensual'])
        ->name('reporte.entregables.mensual');

    Route::get('/tabla-isr/create', [TablaISRController::class, 'create'])->name('tabla-isr.create');
    Route::post('/tabla-isr/store', [TablaISRController::class, 'store'])->name('tabla-isr.store');
    Route::get('/dias-vacaciones/create', [DiasVacacionesController::class, 'create'])->name('dias-vacaciones.create');
    Route::post('/dias-vacaciones/store', [DiasVacacionesController::class, 'store'])->name('dias-vacaciones.store');
    Route::get('/valores/create', [ValorController::class, 'create'])->name('valores.create');
    Route::post('/valores/store', [ValorController::class, 'store'])->name('valores.store');

    Route::get('config-entregas-auditoria', [ConfigEntregasAuditoriaController::class, 'index'])->name('config-entregas-auditoria.index');
    Route::get('config-entregas-auditoria/create', [ConfigEntregasAuditoriaController::class, 'create'])->name('config-entregas-auditoria.create');
    Route::post('config-entregas-auditoria', [ConfigEntregasAuditoriaController::class, 'store'])->name('config-entregas-auditoria.store');
    Route::get('config-entregas-auditoria/{id}/edit', [ConfigEntregasAuditoriaController::class, 'edit'])->name('config-entregas-auditoria.edit');
    Route::put('config-entregas-auditoria/{id}', [ConfigEntregasAuditoriaController::class, 'update'])->name('config-entregas-auditoria.update');
    Route::delete('config-entregas-auditoria/{id}', [ConfigEntregasAuditoriaController::class, 'destroy'])->name('config-entregas-auditoria.destroy');

    Route::get('config-entregas-jefatura', [ConfigEntregasJefaturaController::class, 'index'])->name('config-entregas-jefatura.index');
    Route::get('config-entregas-jefatura/create', [ConfigEntregasJefaturaController::class, 'create'])->name('config-entregas-jefatura.create');
    Route::post('config-entregas-jefatura', [ConfigEntregasJefaturaController::class, 'store'])->name('config-entregas-jefatura.store');
    Route::get('config-entregas-jefatura/{id}/edit', [ConfigEntregasJefaturaController::class, 'edit'])->name('config-entregas-jefatura.edit');
    Route::put('config-entregas-jefatura/{id}', [ConfigEntregasJefaturaController::class, 'update'])->name('config-entregas-jefatura.update');
    Route::delete('config-entregas-jefatura/{id}', [ConfigEntregasJefaturaController::class, 'destroy'])->name('config-entregas-jefatura.destroy');

    Route::get('entregas_auditoria', [EntregaAuditoriaController::class, 'index'])->name('entregas_auditoria.index');
    Route::get('entregas_auditoria/create', [EntregaAuditoriaController::class, 'create'])->name('entregas_auditoria.create');
    Route::post('entregas_auditoria/store', [EntregaAuditoriaController::class, 'store'])->name('entregas_auditoria.store');
    Route::get('entregas-auditoria/lista', [EntregaAuditoriaController::class, 'lista'])->name('entregas_auditoria.lista');
    Route::post('entregas-auditoria/estatus/pendiente', [EntregaAuditoriaController::class, 'pendiente'])->name('entregas_auditoria.pendiente');
    Route::post('entregas-auditoria/estatus/detener', [EntregaAuditoriaController::class, 'detener'])->name('entregas_auditoria.detenido');
    Route::post('entregas-auditoria/estatus/completar', [EntregaAuditoriaController::class, 'completar'])->name('entregas_auditoria.completar');
    Route::post('entregas-auditoria/estatus/eliminar', [EntregaAuditoriaController::class, 'eliminar'])->name('entregas_auditoria.eliminar');
    Route::post('entregas-auditoria/estatus/activar', [EntregaAuditoriaController::class, 'activar'])->name('entregas_auditoria.activar');
    Route::post('/entregas_auditoria/{id}/upload', [EntregaAuditoriaController::class, 'uploadArchivo'])->name('entregas_auditoria.upload');

    Route::get('entregas_jefatura', [EntregaJefaturaController::class, 'index'])->name('entregas_jefatura.index');
    Route::get('entregas_jefatura/create', [EntregaJefaturaController::class, 'create'])->name('entregas_jefatura.create');
    Route::post('entregas_jefatura/store', [EntregaJefaturaController::class, 'store'])->name('entregas_jefatura.store');
    Route::get('entregas-jefatura/lista', [EntregaJefaturaController::class, 'lista'])->name('entregas_jefatura.lista');
    Route::post('entregas-jefatura/estatus/pendiente', [EntregaJefaturaController::class, 'pendiente'])->name('entregas_jefatura.pendiente');
    Route::post('entregas-jefatura/estatus/detener', [EntregaJefaturaController::class, 'detener'])->name('entregas_jefatura.detenido');
    Route::post('entregas-jefatura/estatus/completar', [EntregaJefaturaController::class, 'completar'])->name('entregas_jefatura.completar');
    Route::post('entregas-jefatura/estatus/eliminar', [EntregaJefaturaController::class, 'eliminar'])->name('entregas_jefatura.eliminar');
    Route::post('entregas-jefatura/estatus/activar', [EntregaJefaturaController::class, 'activar'])->name('entregas_jefatura.activar');
    Route::post('/entregas_jefatura/{id}/upload', [EntregaJefaturaController::class, 'uploadArchivo'])->name('entregas_jefatura.upload');

    Route::get('/dashboard/cards/vacantes-data', [DashboardController::class, 'getCardVacantesData'])->name('dashboard.cards.vacantesData');
    Route::get('/dashboard/cards/headcount-data', [DashboardController::class, 'getCardHeadcountData'])->name('dashboard.cards.headcountData');
    Route::get('/dashboard/cards/desvinculados', [DashboardController::class, 'getCardDesvinculados'])->name('dashboard.cards.desvinculados');
    Route::get('/dashboard/cards/pendientes', [DashboardController::class, 'getCardPendientes'])->name('dashboard.cards.pendientes');
    Route::get('/get-chart-headcount-data', [DashboardController::class, 'getChartHeadcountData'])->name('dashboard.chart.headcount.data');
    //Route::get('/dashboard/jefatura', [AuditoriaController::class, 'dashboardJefatura'])->name('dashboard.jefatura');
    Route::get('/dashboard/statistics', [DashboardController::class, 'getStatisticsApi'])->name('dashboard.statistics');
    //Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartDataApi'])->name('dashboard.chart-data');
    // ========================================
    // NUEVAS RUTAS PARA GRÁFICAS SEPARADAS
    // ========================================

    // RUTA PARA GRÁFICA DE ÁREAS (independiente)
    Route::get('/dashboard/chart-areas-data', [DashboardController::class, 'getChartAreasData'])
        ->name('dashboard.chart-areas-data');

    // RUTA PARA GRÁFICA DE CRITICIDAD (independiente)
    Route::get('/dashboard/chart-criticidad-data', [DashboardController::class, 'getChartCriticidadData'])
        ->name('dashboard.chart-criticidad-data');

    // RUTA PARA AMBAS GRÁFICAS (método original, opcional)
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartDataApi'])
        ->name('dashboard.chart-data');

    Route::resource('grupos', GrupoController::class);
    Route::resource('mensajes', MensajesController::class);
    Route::post('/upload-image', [MensajesController::class, 'uploadImage'])->name('uploadImage');
    Route::get('areas-auditoria', [AreasAuditoriaController::class, 'index'])->name('areas_auditoria.index');
    Route::get('areas-auditoria/create', [AreasAuditoriaController::class, 'create'])->name('areas_auditoria.create');
    Route::post('areas-auditoria', [AreasAuditoriaController::class, 'store'])->name('areas_auditoria.store');
    Route::get('areas-auditoria/{id}/edit', [AreasAuditoriaController::class, 'edit'])->name('areas_auditoria.edit');
    Route::put('areas-auditoria/{id}', [AreasAuditoriaController::class, 'update'])->name('areas_auditoria.update');
    Route::delete('areas-auditoria/{id}', [AreasAuditoriaController::class, 'destroy'])->name('areas_auditoria.destroy');
    Route::post('areas-auditoria/update-planta/{id}', [AreasAuditoriaController::class, 'updatePlanta'])->name('areas_auditoria.update_planta');
    Route::post('areas-auditoria/update-trazabilidad/{id}', [AreasAuditoriaController::class, 'updateTrazabilidad'])->name('areas_auditoria.update_trazabilidad');
    Route::get('/reportes-auditoria', [AuditoriaController::class, 'reportesAuditoria'])->name('reportes-auditoria');
    Route::get('/reportes/hallazgos', [AuditoriaController::class, 'reporteHallazgos'])->name('reportes.hallazgos');
    Route::get('/reporte-filtrado', [AuditoriaController::class, 'reporteFiltrado'])->name('reporte.filtrado');
    Route::get('/config-hallazgos', [AuditoriaController::class, 'configHallazgos'])->name('config.hallazgos');
    Route::post('/config-hallazgos/store', [AuditoriaController::class, 'storeConfigHallazgo'])->name('config.hallazgos.store');
    Route::put('/config-hallazgos/update/{id}', [AuditoriaController::class, 'updateConfigHallazgo'])->name('config.hallazgos.update');
    Route::delete('/config-hallazgos/destroy/{id}', [AuditoriaController::class, 'destroyConfigHallazgo'])->name('config.hallazgos.destroy');
    Route::post('/config-hallazgos/obligatorio/{id}', [AuditoriaController::class, 'configHallazgosObligatorio'])->name('config.hallazgos.obligatorio');

    Route::post('/obtener-titulos', [ConfigHallazgosController::class, 'obtenerTitulos'])->name('obtener-titulos');
    Route::post('/obtener-subtitulos', [ConfigHallazgosController::class, 'obtenerSubTitulos'])->name('obtener-subtitulos');

    Route::get('/perfil', [App\Http\Controllers\HomeController::class, 'perfil'])->name('perfil');

    Route::post('/auditoria', [AuditoriaController::class, 'crear'])->name('auditoria.crear');
    Route::get('/auditoria/{id}/edit', [AuditoriaController::class, 'edit'])->name('auditoria.edit');
    Route::put('/auditoria/{id}', [AuditoriaController::class, 'update'])->name('auditoria.update');
    Route::post('/auditoria/{id}/hallazgo', [AuditoriaController::class, 'storeHallazgo'])->name('auditoria.storeHallazgo');
    Route::get('/export/auditorias', [AuditoriaController::class, 'exportAuditorias'])->name('export.auditorias');
    Route::get('/hallazgo/{id}/edit', [AuditoriaController::class, 'editHallazgo'])->name('hallazgo.edit');
    Route::put('/hallazgo/{id}', [AuditoriaController::class, 'updateHallazgo'])->name('hallazgo.update');
    Route::post('/hallazgo-cerrar/{id}', [AuditoriaController::class, 'cerrarHallazgo'])->name('hallazgo.cerrar');
    Route::delete('/hallazgo/{hallazgo}/evidencia', [AuditoriaController::class, 'eliminarEvidencia'])->name('hallazgo.evidencia.eliminar');


    Route::get('/tablero_directivo_nomina', [App\Http\Controllers\SQLController::class, 'tableroDirectivoNomina'])->name('tableroDirectivoNomina');
    Route::get('/insertarDesdeJson', [App\Http\Controllers\SQLController::class, 'insertarDesdeJson'])->name('insertarDesdeJson');
    Route::get('/dividirJson', [App\Http\Controllers\SQLController::class, 'dividirJson'])->name('dividirJson');

    Route::get('/incidencias', [App\Http\Controllers\IncidenciasController::class, 'showIncidencias'])->name('incidencias');
    Route::get('/incidencias/historico', [App\Http\Controllers\IncidenciasController::class, 'showIncidenciasHistorico'])->name('incidencias.historico');
    Route::get('/capturar-incidencias', [App\Http\Controllers\IncidenciasController::class, 'capturarIncidencias'])->name('incidencias.capturar');

    Route::get('/vacante/editar/{id}', [App\Http\Controllers\VacantesController::class, 'editar'])->name('editar.vacante');

    Route::get('vacantes/create', [App\Http\Controllers\VacantesController::class, 'create'])->name('vacantes.create');
    Route::post('vacantes', [App\Http\Controllers\VacantesController::class, 'store'])->name('vacantes.store');


    Route::delete('/vacantes/{id}', [App\Http\Controllers\VacantesController::class, 'destroy'])->name('vacantes.destroy');
    Route::put('/vacantes/{id}', [App\Http\Controllers\VacantesController::class, 'update'])->name('vacantes.update');


    Route::post('/calificar', [App\Http\Controllers\VacantesController::class, 'calificar'])->name('calificar');

    Route::get('/evaluaciones', [App\Http\Controllers\EvaluacionesController::class, 'index'])->name('evaluaciones');
    Route::post('/evaluaciones', [App\Http\Controllers\EvaluacionesController::class, 'store'])->name('evaluaciones.store');
    Route::get('/evaluaciones/evaluar/{id_evaluador}/{id_colaborador}', [App\Http\Controllers\EvaluacionesController::class, 'evaluar'])->name('evaluaciones.evaluar');
    Route::get('/evaluaciones/ver/{id_evaluador}/{id_colaborador}', [App\Http\Controllers\EvaluacionesController::class, 'ver'])->name('evaluaciones.ver');
    Route::post('/guardarEvaluacion', [App\Http\Controllers\EvaluacionesController::class, 'guardarEvaluacion'])->name('guardarEvaluacion');

    Route::post('/pdfFiniquito', [App\Http\Controllers\PdfController::class, 'pdfFiniquito'])->name('pdfFiniquito');

    Route::get('/logout-other-devices', [App\Http\Controllers\HomeController::class, 'logoutOtherDevices'])->name('logout.other.devices');

    Route::get('/tablero-nomina', [App\Http\Controllers\TableroNominaController::class, 'index'])->name('tablero.nomina');

    Route::get('/grafico1', [App\Http\Controllers\ChartController::class, 'grafico1'])->name('grafico1');

    Route::post('/fijar_rs', [App\Http\Controllers\RazonesSocialesController::class, 'fijar_rs'])->name('fijar_rs');
    Route::put('/companies/{id}', [App\Http\Controllers\RazonesSocialesController::class, 'update'])->name('companies.update');

    Route::post('/actualizar_roles', [App\Http\Controllers\ColaboradoresController::class, 'actualizar_roles'])->name('actualizar_roles');
    Route::get('/generar_usuarios', [App\Http\Controllers\ColaboradoresController::class, 'generar_usuarios'])->name('generar_usuarios');
    Route::get('/colaborador/{id}/incidencias', [App\Http\Controllers\ColaboradoresController::class, 'incidencias'])->name('colaborador_incidencias');
    Route::get('/test_colab', [App\Http\Controllers\ColaboradoresController::class, 'test_colab'])->name('test_colab');
    Route::delete('/eliminar-documento/{id}', [App\Http\Controllers\ColaboradoresController::class, 'eliminarDocumento'])->name('colaboradores.eliminarDocumento');
    Route::post('/importarNomipaq', [App\Http\Controllers\ColaboradoresController::class, 'importarNomipaq'])->name('importarNomipaq');
    Route::get('/colaboradores/crear', [App\Http\Controllers\ColaboradoresController::class, 'crear'])->name('crear_colaborador');
    Route::post('/colaboradores/alta', [App\Http\Controllers\ColaboradoresController::class, 'alta'])->name('alta_colaborador');
    Route::post('/buscarDepartamentos', [App\Http\Controllers\ColaboradoresController::class, 'buscarDepartamentos'])->name('buscarDepartamentos');
    Route::post('/buscarPuestos', [App\Http\Controllers\ColaboradoresController::class, 'buscarPuestos'])->name('buscarPuestos');
    Route::post('/buscarJefesDirectos', [App\Http\Controllers\ColaboradoresController::class, 'buscarJefesDirectos'])->name('buscarJefesDirectos');
    Route::post('/buscarColaborador', [App\Http\Controllers\ColaboradoresController::class, 'buscarColaborador'])->name('buscarColaborador');
    Route::get('/vista-colaborador/{colaborador_id}', [App\Http\Controllers\ColaboradoresController::class, 'show'])->name('vista-colaborador');
    Route::get('/editar-colaborador/{colaborador_id}', [App\Http\Controllers\ColaboradoresController::class, 'edit'])->name('editar-colaborador');
    Route::get('/colaborador/{colaboradorId}/puesto', [ColaboradoresController::class, 'getPuesto'])->name('colaborador.puesto');

    Route::get('/centro_de_costos', [App\Http\Controllers\CentrodeCostosController::class, 'index'])->name('centro_de_costos');
    Route::get('/centro_de_costo/{id}', [App\Http\Controllers\CentrodeCostosController::class, 'ver'])->name('ver_centro_de_costos');
    Route::post('/centro_de_costo/editar', [App\Http\Controllers\CentrodeCostosController::class, 'editar'])->name('editar_centro_de_costos');
    Route::get('/centro_de_costos/nuevo', [App\Http\Controllers\CentrodeCostosController::class, 'nuevo'])->name('nuevo_centro_de_costos');
    Route::post('/centro_de_costo/crear', [App\Http\Controllers\CentrodeCostosController::class, 'crear'])->name('crear_centro_de_costos');
    Route::post('/centro_de_costo/eliminar', [App\Http\Controllers\CentrodeCostosController::class, 'eliminar'])->name('eliminar_centro_de_costos');
    Route::post('/centro_de_costo/eliminar_hp', [App\Http\Controllers\CentrodeCostosController::class, 'eliminar_hp'])->name('eliminar_hp');

    Route::get('/razones_sociales', [App\Http\Controllers\RazonesSocialesController::class, 'index'])->name('razones_sociales');
    Route::get('/razon_social/{id}', [App\Http\Controllers\RazonesSocialesController::class, 'ver'])->name('ver_razones_sociales');
    Route::get('/razones_sociales/nuevo', [App\Http\Controllers\RazonesSocialesController::class, 'nuevo'])->name('nuevo_razones_sociales');
    Route::post('/razones_sociales/crear', [App\Http\Controllers\RazonesSocialesController::class, 'crear'])->name('crear_razones_sociales');
    Route::post('/razones_sociales/eliminar', [App\Http\Controllers\RazonesSocialesController::class, 'eliminar'])->name('eliminar_razones_sociales');
    Route::post('/razones_sociales/restaurar', [App\Http\Controllers\RazonesSocialesController::class, 'restaurar'])->name('restaurar_razones_sociales');
    Route::get('/catalogos', [App\Http\Controllers\RazonesSocialesController::class, 'catalogos'])->name('catalogos');
    Route::get('/borrado', [App\Http\Controllers\RazonesSocialesController::class, 'borrado'])->name('borrado');
    Route::get('/meterdesvinculados', [App\Http\Controllers\RazonesSocialesController::class, 'meterdesvinculados'])->name('meterdesvinculados');

    Route::get('/puestos', [App\Http\Controllers\PuestosController::class, 'index'])->name('puestos');
    Route::get('/puesto/{id}', [App\Http\Controllers\PuestosController::class, 'ver'])->name('puestos_ver');
    Route::post('/subirperfil', [App\Http\Controllers\PuestosController::class, 'subirperfil'])->name('subirperfil');

    Route::get('/bajas', [App\Http\Controllers\BajasController::class, 'index'])->name('bajas');
    Route::post('/tramitar', [App\Http\Controllers\BajasController::class, 'tramitar'])->name('tramitar');
    Route::post('/baja_comprobante', [App\Http\Controllers\BajasController::class, 'baja_comprobante'])->name('baja_comprobante');
    Route::get('/baja/{id}', [App\Http\Controllers\BajasController::class, 'ver'])->name('bajas_ver');
    Route::post('/comprobante_pago', [App\Http\Controllers\BajasController::class, 'comprobante_pago'])->name('comprobante_pago');
    Route::post('/desvincular', [App\Http\Controllers\BajasController::class, 'desvincular'])->name('desvincular');

    Route::get('/obtener-limite-inferior/{base}', [BajasController::class, 'obtenerLimiteInferior'])->name('obtener-limite-inferior');
    Route::get('/obtener-limite-superior/{base}', [BajasController::class, 'obtenerLimiteSuperior'])->name('obtener-limite-superior');
    Route::get('/obtener-cuota-fija/{baseGravable}', [BajasController::class, 'obtenerCuotaFija'])->name('obtener-cuota-fija');
    Route::get('/calcular-porcentaje/{baseGravable}', [BajasController::class, 'calcularPorcentaje'])->name('calcular-porcentaje');

    Route::get('/ubicaciones', [App\Http\Controllers\UbicacionesController::class, 'index'])->name('ubicaciones');
    Route::get('/ubicacion/{id}', [App\Http\Controllers\UbicacionesController::class, 'ver'])->name('ver_ubicaciones');
    Route::post('/ubicaciones/editar', [App\Http\Controllers\UbicacionesController::class, 'editar'])->name('editar_ubicaciones');
    Route::get('/ubicaciones/nuevo', [App\Http\Controllers\UbicacionesController::class, 'nuevo'])->name('nuevo_ubicaciones');
    Route::post('/ubicaciones/crear', [App\Http\Controllers\UbicacionesController::class, 'crear'])->name('crear_ubicaciones');
    Route::post('/ubicaciones/eliminar', [App\Http\Controllers\UbicacionesController::class, 'eliminar'])->name('eliminar_ubicaciones');
    Route::get('/ubicaciones_alta', [App\Http\Controllers\UbicacionesController::class, 'alta'])->name('ubicaciones_alta');
    Route::delete('/ubicacion/{id}', [App\Http\Controllers\UbicacionesController::class, 'destroy'])->name('ubicacion.destroy');
    Route::post('/ubicacion/agregar', [App\Http\Controllers\UbicacionesController::class, 'agregar'])->name('ubicacion.agregar');
    Route::post('/ubicacion/store', [App\Http\Controllers\UbicacionesController::class, 'store'])->name('ubicaciones.store');

    Route::get('/auditorias', [App\Http\Controllers\AuditoriaController::class, 'index'])->name('auditorias');
    Route::get('/nueva_auditoria', [App\Http\Controllers\AuditoriaController::class, 'nueva'])->name('auditorias.nueva');
    Route::post('/crear_auditoria', [App\Http\Controllers\AuditoriaController::class, 'crear'])->name('crear_auditoria');
    Route::post('/crear_hallazgo', [App\Http\Controllers\AuditoriaController::class, 'crear_hallazgo'])->name('crear_hallazgo');
    Route::get('/auditoria/{id}', [App\Http\Controllers\AuditoriaController::class, 'ver'])->name('ver_auditoria');

    Route::get('/hallazgo-reporte-duplicado', [App\Http\Controllers\AuditoriaController::class, 'generarReporteDuplicado'])->name('generarReporteDuplicado');

    // En web.php
    Route::get('hallazgos/{id}/editar', [AuditoriaController::class, 'editar'])->name('editar_hallazgo');
    Route::delete('/eliminar-auditoria', [AuditoriaController::class, 'eliminar_auditoria'])->name('eliminar_auditoria');
    Route::delete('/eliminar-hallazgos', [AuditoriaController::class, 'eliminar_hallazgo'])->name('eliminar_hallazgo');


    Route::post('/datos_baja', [App\Http\Controllers\BajasController::class, 'datos_baja'])->name('datos_baja');
    Route::get('/solicitar', [App\Http\Controllers\BajasController::class, 'solicitar'])->name('solicitar');
    Route::post('/priorizar', [App\Http\Controllers\VacantesController::class, 'priorizar'])->name('priorizar');

    Route::get('/desvinculados', [App\Http\Controllers\DesvinculadosController::class, 'index'])->name('desvinculados');
    Route::get('/desvinculado/{id}', [App\Http\Controllers\DesvinculadosController::class, 'ver'])->name('ver_desvinculados');
    Route::post('/desvinculados/editar', [App\Http\Controllers\DesvinculadosController::class, 'editar'])->name('editar_desvinculados');
    Route::post('/desvinculados/eliminar', [App\Http\Controllers\DesvinculadosController::class, 'eliminar'])->name('eliminar_desvinculados');

    Route::post('/proyectos/agregar', [App\Http\Controllers\ProyectosController::class, 'agregar'])->name('proyecto.agregar');
    Route::get('/proyectos', [App\Http\Controllers\ProyectosController::class, 'index'])->name('proyectos');
    Route::get('/proyecto/{id}', [App\Http\Controllers\ProyectosController::class, 'ver'])->name('ver_proyectos');
    Route::post('/proyectos/editar', [App\Http\Controllers\ProyectosController::class, 'editar'])->name('editar_proyectos');
    Route::get('/proyectos/nuevo', [App\Http\Controllers\ProyectosController::class, 'nuevo'])->name('nuevo_proyectos');
    Route::post('/proyectos/crear', [App\Http\Controllers\ProyectosController::class, 'crear'])->name('crear_proyectos');
    Route::post('/proyectos/eliminar', [App\Http\Controllers\ProyectosController::class, 'eliminar'])->name('eliminar_proyectos');
    Route::delete('/proyecto/{id}', [App\Http\Controllers\ProyectosController::class, 'destroy'])->name('proyecto.destroy');
    Route::post('/proyecto/store', [App\Http\Controllers\ProyectosController::class, 'store'])->name('proyecto.store');

    Route::get('/departamentos', [App\Http\Controllers\DepartamentosController::class, 'index'])->name('departamentos');
    Route::get('/departamento/{id}', [App\Http\Controllers\DepartamentosController::class, 'ver'])->name('ver_departamento');
    Route::post('/departamentos/editar', [App\Http\Controllers\DepartamentosController::class, 'editar'])->name('editar_departamento');
    Route::get('/departamentos/nuevo', [App\Http\Controllers\DepartamentosController::class, 'nuevo'])->name('nuevo_departamento');
    Route::post('/departamentos/crear', [App\Http\Controllers\DepartamentosController::class, 'crear'])->name('crear_departamento');
    Route::post('/departamentos/eliminar', [App\Http\Controllers\DepartamentosController::class, 'eliminar'])->name('eliminar_departamento');

    Route::post('/subircv', [App\Http\Controllers\VacantesController::class, 'subircv'])->name('vacantes_subircv');
    Route::post('/asignar_fechas_entrevista', [App\Http\Controllers\VacantesController::class, 'asignar_fechas_entrevista'])->name('asignar_fechas_entrevista');
    Route::post('/programar_fechas_entrevista', [App\Http\Controllers\VacantesController::class, 'programar_fechas_entrevista'])->name('programar_fechas_entrevista');
    Route::post('/subir_referencias', [App\Http\Controllers\VacantesController::class, 'subir_referencias'])->name('subir_referencias');
    Route::post('/examen', [App\Http\Controllers\VacantesController::class, 'examen'])->name('examen');
    Route::post('/documentacion', [App\Http\Controllers\VacantesController::class, 'documentacion'])->name('documentacion');
    Route::post('/validar_documentacion', [App\Http\Controllers\VacantesController::class, 'validar_documentacion'])->name('validar_documentacion');
    Route::post('/apruebaestatus', [App\Http\Controllers\VacantesController::class, 'apruebaestatus'])->name('apruebaestatus');
    Route::get('/descargar-cv/{ruta}', [App\Http\Controllers\VacantesController::class, 'subircv'])->name('descargar.cv');
    Route::get('/vacantes', [App\Http\Controllers\VacantesController::class, 'index'])->name('vacantes');
    Route::post('/vacantes/prioridad', [App\Http\Controllers\VacantesController::class, 'prioridad'])->name('prioridad');
    Route::get('/vacantes/historico', [App\Http\Controllers\VacantesController::class, 'historico'])->name('vacantes.historico');
    Route::get('/proceso_vacante/{id}', [App\Http\Controllers\VacantesController::class, 'proceso_vacante'])->name('proceso_vacante');
    Route::get('/proceso_vacante/{id}/{candidato}', [App\Http\Controllers\VacantesController::class, 'proceso_vacante_candidato'])->name('proceso_vacante_candidato');
    Route::get('/proceso_vacante/{id}/{candidato}/{current}', [App\Http\Controllers\VacantesController::class, 'proceso_vacante_candidato_current'])->name('proceso_vacante_candidato_current');
    Route::post('/alta_candidato_rh', [App\Http\Controllers\VacantesController::class, 'alta_candidato_rh'])->name('alta_candidato_rh');
    Route::post('/aprobar_candidato', [App\Http\Controllers\VacantesController::class, 'aprobar_candidato'])->name('aprobar_candidato');
    Route::post('/rechazar_candidato', [App\Http\Controllers\VacantesController::class, 'rechazar_candidato'])->name('rechazar_candidato');
    Route::post('/contratar_colaborador', [App\Http\Controllers\VacantesController::class, 'contratar_colaborador'])->name('contratar_colaborador');
    Route::get('/altas', [App\Http\Controllers\VacantesController::class, 'altas'])->name('altas');
    Route::get('/terminaralta/{id}', [App\Http\Controllers\VacantesController::class, 'terminaralta'])->name('terminaralta');
    Route::post('/proponer_ingreso', [App\Http\Controllers\VacantesController::class, 'proponer_ingreso'])->name('proponer_ingreso');
    Route::post('/eliminar_referencia', [App\Http\Controllers\VacantesController::class, 'eliminar_referencia'])->name('eliminar_referencia');

    Route::post('/alta_colaborador/{candidato_id}', [App\Http\Controllers\ColaboradoresController::class, 'ingreso_candidato'])->name('ingreso_candidato');
    Route::get('/colaboradores', [App\Http\Controllers\ColaboradoresController::class, 'index'])->name('colaboradores');
    Route::post('/generarbaja', [App\Http\Controllers\ColaboradoresController::class, 'generarbaja'])->name('generarbaja');
    Route::get('/colaboradores/externos', [App\Http\Controllers\ColaboradoresController::class, 'externos'])->name('externos');
    Route::patch('/externos/{id}/toggle-status', [App\Http\Controllers\ColaboradoresController::class, 'toggleStatusExterno'])->name('toggle_status_externo');

    Route::get('/colaboradores/crear_externos', [App\Http\Controllers\ColaboradoresController::class, 'crear_externos'])->name('crear_externos');
    Route::get('/colaboradores/externo/{id}', [App\Http\Controllers\ColaboradoresController::class, 'ver_externo'])->name('ver_externo');
    Route::post('/colaboradores/alta_externos', [App\Http\Controllers\ColaboradoresController::class, 'alta_externos'])->name('alta_externos');
    Route::put('/colaboradores/externos/{id}', [App\Http\Controllers\ColaboradoresController::class, 'update_externo'])->name('update_externo');
    Route::get('/colaboradores/externos/{id}/edit', [App\Http\Controllers\ColaboradoresController::class, 'edit_externo'])->name('edit_externo');
    Route::delete('/colaboradores/externos/{id}', [App\Http\Controllers\ColaboradoresController::class, 'delete_externo'])->name('delete_externo');
    Route::post('/colaboradores/editar_externos', [App\Http\Controllers\ColaboradoresController::class, 'editar_externos'])->name('editar_externos');
    Route::post('/colaboradores/eliminar_externos', [App\Http\Controllers\ColaboradoresController::class, 'eliminar_externos'])->name('eliminar_externos');
    Route::post('/colaboradores/update1', [App\Http\Controllers\ColaboradoresController::class, 'update1'])->name('colaboradores.update1');
    Route::post('/colaboradores/update2', [App\Http\Controllers\ColaboradoresController::class, 'update2'])->name('colaboradores.update2');
    Route::post('/colaboradores/update3', [App\Http\Controllers\ColaboradoresController::class, 'update3'])->name('colaboradores.update3');
    Route::post('/colaboradores/update4', [App\Http\Controllers\ColaboradoresController::class, 'update4'])->name('colaboradores.update4');
    Route::post('/colaboradores/update5', [App\Http\Controllers\ColaboradoresController::class, 'update5'])->name('colaboradores.update5');
    Route::post('/colaboradores/update6', [App\Http\Controllers\ColaboradoresController::class, 'update6'])->name('colaboradores.update6');
    Route::post('/colaboradores/update7', [App\Http\Controllers\ColaboradoresController::class, 'update7'])->name('colaboradores.update7');
    Route::post('/colaboradores/update8', [App\Http\Controllers\ColaboradoresController::class, 'update8'])->name('colaboradores.update8');
    Route::post('/colaboradores/update9', [App\Http\Controllers\ColaboradoresController::class, 'update9'])->name('colaboradores.update9');
    Route::post('/colaboradores/update10', [App\Http\Controllers\ColaboradoresController::class, 'update10'])->name('colaboradores.update10');
    Route::post('/colaboradores/cargarDocumentos', [App\Http\Controllers\ColaboradoresController::class, 'cargarDocumentos'])->name('colaboradores.cargarDocumentos');
    Route::get('/get-max-employee-number/{company_id}', [App\Http\Controllers\ColaboradoresController::class, 'getMaxEmployeeNumber'])->name('get.max.employee.number');

    Route::get('/organigrama-lineal/{id}', [App\Http\Controllers\OrganigramaController::class, 'organigrama_lineal'])->name('organigrama_lineal');
    Route::get('/ver-organigrama/{agrupador_id}', [App\Http\Controllers\OrganigramaController::class, 'ver'])->name('verorganigrama');
    Route::post('/matricial', [App\Http\Controllers\OrganigramaController::class, 'matricial'])->name('matricial');
    Route::post('/matricialh', [App\Http\Controllers\OrganigramaController::class, 'matricialh'])->name('matricialh');
    Route::post('/matricialv', [App\Http\Controllers\OrganigramaController::class, 'matricialv'])->name('matricialv');
    Route::post('/matriciale', [App\Http\Controllers\OrganigramaController::class, 'matriciale'])->name('matriciale');
    Route::post('/agregarnivel', [App\Http\Controllers\OrganigramaController::class, 'agregarnivel'])->name('agregarnivel');
    Route::post('/reemplazar', [App\Http\Controllers\OrganigramaController::class, 'reemplazar'])->name('reemplazar');
    Route::post('/unoarriba', [App\Http\Controllers\OrganigramaController::class, 'unoarriba'])->name('unoarriba');
    Route::post('/unoabajo', [App\Http\Controllers\OrganigramaController::class, 'unoabajo'])->name('unoabajo');
    Route::post('/asignarnivel1', [App\Http\Controllers\OrganigramaController::class, 'asignarnivel1'])->name('asignarnivel1');
    Route::post('/moverposicion', [App\Http\Controllers\OrganigramaController::class, 'moverposicion'])->name('moverposicion');
    Route::post('/asignarjefe', [App\Http\Controllers\OrganigramaController::class, 'asignarjefe'])->name('asignarjefe');
    Route::post('/eliminardelorganigrama', [App\Http\Controllers\OrganigramaController::class, 'eliminardelorganigrama'])->name('eliminardelorganigrama');
    Route::get('/organigrama_old', [App\Http\Controllers\OrganigramaController::class, 'index'])->name('organigrama');
    Route::get('/organigrama', [App\Http\Controllers\OrganigramaController::class, 'showorganigrama'])->name('showorganigrama');
    Route::post('/buscarColaboradorOrganigrama', [App\Http\Controllers\OrganigramaController::class, 'buscarColaborador'])->name('buscarColaboradorOrganigrama');
    Route::post('/buscarPuestoxEmpresa', [App\Http\Controllers\OrganigramaController::class, 'buscarPuestoxEmpresa'])->name('buscarPuestoxEmpresa');

    Route::get('/organigrama-create', [App\Http\Controllers\OrganigramaController::class, 'crear'])->name('organigrama.create');
    Route::post('/organigrama-store', [App\Http\Controllers\OrganigramaController::class, 'store'])->name('organigrama.store');
    Route::get('/organigrama-custom/{id}', [App\Http\Controllers\OrganigramaController::class, 'showOrganigramaCustom'])->name('organigrama.custom');
    Route::get('/organigrama-editar/{id}', [App\Http\Controllers\OrganigramaController::class, 'showOrganigramaEditar'])->name('organigrama.editar');
    Route::post('/organigrama-update', [App\Http\Controllers\OrganigramaController::class, 'showOrganigramaUpdate'])->name('organigrama.update');
    Route::post('/organigrama-mover-ubicacion', [App\Http\Controllers\OrganigramaController::class, 'moverUbicacion'])->name('organigrama.moverUbicacion');
    Route::get('/organigrama-ubicacion/{id}', [App\Http\Controllers\OrganigramaController::class, 'ubicacion'])->name('organigrama.ubicacion');

    Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('usuarios');

    Route::get('/vacaciones', [App\Http\Controllers\IncidenciasController::class, 'vacaciones'])->name('vacaciones');
    Route::post('/vacaciones/pendientes', [App\Http\Controllers\IncidenciasController::class, 'vacaciones_pendientes'])->name('vacaciones_pendientes');
    Route::get('/busqueda_vacaciones', [App\Http\Controllers\IncidenciasController::class, 'busqueda_vacaciones_get'])->name('busqueda_vacaciones_get');
    Route::get('/vacaciones-pendientes/fecha-alta/{colaboradorId}', [App\Http\Controllers\IncidenciasController::class, 'getFechaAlta']);
    Route::post('/busqueda_vacaciones', [App\Http\Controllers\IncidenciasController::class, 'busqueda_vacaciones_post'])->name('busqueda_vacaciones_post');
    Route::get('/solicitar_vacaciones', [App\Http\Controllers\IncidenciasController::class, 'solicitar_vacaciones'])->name('solicitar_vacaciones');
    Route::post('/guardar_vacaciones', [App\Http\Controllers\IncidenciasController::class, 'guardar_vacaciones'])->name('guardar_vacaciones');
    Route::post('/vacaciones/validar', [App\Http\Controllers\IncidenciasController::class, 'validarVacaciones'])->name('validarVacaciones');
    Route::post('/buscarDiasVacaciones', [App\Http\Controllers\IncidenciasController::class, 'buscarDiasVacaciones'])->name('buscarDiasVacaciones');
    Route::get('/vacacion/{id}', [App\Http\Controllers\IncidenciasController::class, 'vervacaciones'])->name('vervacaciones');
    Route::post('/vacaciones_pendientes/{id}', [App\Http\Controllers\IncidenciasController::class, 'vacaciones_pendientes_update'])->name('vacaciones.pendientes.update');
    Route::get('/colaborador/vacaciones/{id}', [App\Http\Controllers\IncidenciasController::class, 'getVacaciones'])->name('colaborador.vacaciones');

    Route::get('/horas_extra', [App\Http\Controllers\IncidenciasController::class, 'horas_extra'])->name('horas_extra');
    Route::get('/capturar_horas_extra', [App\Http\Controllers\IncidenciasController::class, 'capturar_horas_extra'])->name('capturar_horas_extra');
    Route::post('/guardar_horas_extras', [App\Http\Controllers\IncidenciasController::class, 'guardar_horas_extras'])->name('guardar_horas_extras');
    Route::get('/busqueda_horas_extra', [App\Http\Controllers\IncidenciasController::class, 'busqueda_horas_extra_get'])->name('busqueda_horas_extra_get');
    Route::post('/busqueda_horas_extra', [App\Http\Controllers\IncidenciasController::class, 'busqueda_horas_extra_post'])->name('busqueda_horas_extra_post');
    Route::post('/horas_extra/validar', [App\Http\Controllers\IncidenciasController::class, 'validarHorasExtra'])->name('validarHorasExtra');

    Route::get('/gratificaciones', [App\Http\Controllers\IncidenciasController::class, 'gratificaciones'])->name('gratificaciones');
    Route::get('/capturar_gratificaciones', [App\Http\Controllers\IncidenciasController::class, 'capturar_gratificaciones'])->name('capturar_gratificaciones');
    Route::post('/guardar_gratificaciones', [App\Http\Controllers\IncidenciasController::class, 'guardar_gratificaciones'])->name('guardar_gratificaciones');
    Route::post('/gratificaciones/validar', [App\Http\Controllers\IncidenciasController::class, 'validarGratificaciones'])->name('validarGratificaciones');


    Route::get('/permisos', [App\Http\Controllers\IncidenciasController::class, 'permisos'])->name('permisos');
    Route::get('/capturar_permisos', [App\Http\Controllers\IncidenciasController::class, 'capturar_permisos'])->name('capturar_permisos');
    Route::post('/guardar_permisos', [App\Http\Controllers\IncidenciasController::class, 'guardar_permisos'])->name('guardar_permisos');
    Route::post('/permisos/validar', [App\Http\Controllers\IncidenciasController::class, 'validarPermisos'])->name('validarPermisos');


    Route::get('/incapacidades', [App\Http\Controllers\IncidenciasController::class, 'incapacidades'])->name('incapacidades');
    Route::get('/capturar_incapacidades', [App\Http\Controllers\IncidenciasController::class, 'capturar_incapacidades'])->name('capturar_incapacidades');
    Route::post('/guardar_incapacidades', [App\Http\Controllers\IncidenciasController::class, 'guardar_incapacidades'])->name('guardar_incapacidades');
    Route::post('/incapacidades/validar', [App\Http\Controllers\IncidenciasController::class, 'validarIncapacidades'])->name('validarIncapacidades');


    Route::get('/asistencias', [App\Http\Controllers\IncidenciasController::class, 'asistencias'])->name('asistencias');
    Route::get('/capturar_asistencias', [App\Http\Controllers\IncidenciasController::class, 'capturar_asistencias'])->name('capturar_asistencias');
    Route::post('/guardar_asistencias', [App\Http\Controllers\IncidenciasController::class, 'guardar_asistencias'])->name('guardar_asistencias');

    Route::get('/calendar', [App\Http\Controllers\CalendarioController::class, 'calendar'])->name('calendar');
    Route::post('/calendar_filtro', [App\Http\Controllers\CalendarioController::class, 'filtro'])->name('calendar.filtro');
    Route::get('/notificaciones', [App\Http\Controllers\NotificacionesController::class, 'notificaciones'])->name('notificaciones');
    Route::post('/notificaciones_navbar', [App\Http\Controllers\NotificacionesController::class, 'navbar'])->name('notificaciones.navbar');
    Route::post('/notificaciones_open', [App\Http\Controllers\NotificacionesController::class, 'open'])->name('notificaciones.open');
    Route::post('/notificaciones_show', [App\Http\Controllers\NotificacionesController::class, 'show'])->name('notificaciones.show');
    Route::post('/notificaciones/archivar', [App\Http\Controllers\NotificacionesController::class, 'archivar'])->name('notificaciones.archivar');
    Route::post('/notificaciones/eliminar', [App\Http\Controllers\NotificacionesController::class, 'eliminar'])->name('notificaciones.eliminar');
    Route::post('/notificaciones_archivadas', [App\Http\Controllers\NotificacionesController::class, 'archivadas'])->name('notificaciones.archivadas');
    // Route::post('/notificaciones/marcar-todas-leidas', [App\Http\Controllers\NotificacionesController::class, 'marcarTodasLeidas'])->name('notificaciones.marcar_todas_leidas');
    // Nuevas rutas para toast notifications
   // Nuevas rutas para toast notifications
    Route::post('/notificaciones_toast', [App\Http\Controllers\NotificacionesController::class, 'obtenerToast'])
        ->name('notificaciones.toast');
    Route::post('/notificaciones/marcar_leida', [App\Http\Controllers\NotificacionesController::class, 'marcarLeida'])
        ->name('notificaciones.marcar_leida');
    Route::post('/notificaciones/archivar', [App\Http\Controllers\NotificacionesController::class, 'archivarToast'])
        ->name('notificaciones.archivar');


    Route::get('/candidatos', [App\Http\Controllers\CandidatosController::class, 'index'])->name('candidatos');

    Route::get('/cargar-excel', 'ExcelController@cargarArchivo');
    Route::post('/cargar-excel', 'ExcelController@procesarArchivo');

    Route::post('/cancelar-baja', [BajasController::class, 'cancelarBaja'])->name('cancelarBaja');
    Route::post('/restaurar-baja', [BajasController::class, 'restaurarBaja'])->name('restaurarBaja');
    Route::post('/crear-baja', [BajasController::class, 'store'])->name('bajas.store');
    Route::post('/actualizar-motivo-baja', [BajasController::class, 'actualizarMotivoBaja'])->name('actualizarMotivoBaja');
    Route::post('/actualizar-fecha-baja', [BajasController::class, 'actualizarFechaBaja'])->name('actualizarFechaBaja');
    Route::post('/actualizar-fecha-elaboracion', [BajasController::class, 'actualizarFechaElaboracion'])->name('actualizarFechaElaboracion');
    Route::post('/ruta/actualizar-salario', [BajasController::class, 'actualizarSalario'])->name('actualizar.salario');
    Route::post('/ruta/actualizar-dias-de-salario', [BajasController::class, 'actualizarDiasdeSalario'])->name('actualizar.dias.salario');
    Route::post('/ruta/actualizar-aguinaldo', [BajasController::class, 'actualizarAguinaldo'])->name('actualizar.aguinaldo');
    Route::post('/ruta/actualizar-vacaciones', [BajasController::class, 'actualizarVacaciones'])->name('actualizar.vacaciones');
    Route::post('/ruta/actualizar-vacaciones-pendientes', [BajasController::class, 'actualizarVacacionesPendientes'])->name('actualizar_vacaciones_pendientes');
    Route::post('/ruta/actualizar-prima-vacacional', [BajasController::class, 'actualizarPrimaVacacional'])->name('actualizar_prima_vacacional');
    Route::post('/ruta/actualizar-prima-vacacional-pendiente', [BajasController::class, 'actualizarPrimaVacacionalPendiente'])->name('actualizar_prima_vacacional_pendiente');
    Route::post('/ruta/actualizar-incentivo', [BajasController::class, 'actualizarIncentivo'])->name('actualizar_incentivo');
    Route::post('/ruta/actualizar-gratificacion', [BajasController::class, 'actualizarGratificacion'])->name('actualizar_gratificacion');
    Route::post('/ruta/actualizar-veinte-dias', [BajasController::class, 'actualizarVeinteDias'])->name('actualizar_veinte_dias');
    Route::post('/ruta/calcular-prima-de-antiguedad', [BajasController::class, 'calcularPrimaDeAntiguedad'])->name('calcular-prima-de-antiguedad');


    Route::get('tabla/ubicaciones' ,[OrganigramaController::class, 'ubicaciones'])->name('tabla.ubicaciones');
    Route::get('tabla/proyectos' ,[OrganigramaController::class, 'proyectos'])->name('tabla.proyectos');

    Route::get('/tabla/centros_de_costo', [OrganigramaController::class, 'centros'])->name('tabla.centros');
    Route::get('/centros/{idCentroDeCosto}/puestos', [OrganigramaController::class, 'obtenerPuestos']);
    Route::get('/puestos/{puestoId}/colaboradores', [OrganigramaController::class, 'getColaboradores']);

    Route::get('ubicaciones/{ubicacion_id}/colaboradores', [OrganigramaController::class, 'getColaboradores2']);



    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::resource('category', 'CategoryController', ['except' => ['show']]);
    Route::resource('tag', 'TagController', ['except' => ['show']]);
    Route::resource('item', 'ItemController', ['except' => ['show']]);
    Route::resource('role', 'RoleController', ['except' => ['show', 'destroy']]);
    Route::resource('user', 'UserController', ['except' => ['show']]);

    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::get('rtl-support', ['as' => 'page.rtl-support', 'uses' => 'ExamplePagesController@rtlSupport']);
    Route::get('timeline', ['as' => 'page.timeline', 'uses' => 'ExamplePagesController@timeline']);
    Route::get('widgets', ['as' => 'page.widgets', 'uses' => 'ExamplePagesController@widgets']);
    Route::get('charts', ['as' => 'page.charts', 'uses' => 'ExamplePagesController@charts']);
    //Route::get('calendar', ['as' => 'page.calendar', 'uses' => 'ExamplePagesController@calendar']);

    Route::get('buttons', ['as' => 'page.buttons', 'uses' => 'ComponentPagesController@buttons']);
    Route::get('grid-system', ['as' => 'page.grid', 'uses' => 'ComponentPagesController@grid']);
    Route::get('panels', ['as' => 'page.panels', 'uses' => 'ComponentPagesController@panels']);
    Route::get('sweet-alert', ['as' => 'page.sweet-alert', 'uses' => 'ComponentPagesController@sweetAlert']);
    Route::get('notifications', ['as' => 'page.notifications', 'uses' => 'ComponentPagesController@notifications']);
    Route::get('icons', ['as' => 'page.icons', 'uses' => 'ComponentPagesController@icons']);
    Route::get('typography', ['as' => 'page.typography', 'uses' => 'ComponentPagesController@typography']);

    Route::get('regular-tables', ['as' => 'page.regular_tables', 'uses' => 'TablePagesController@regularTables']);
    Route::get('extended-tables', ['as' => 'page.extended_tables', 'uses' => 'TablePagesController@extendedTables']);
    Route::get('datatable-tables', ['as' => 'page.datatable_tables', 'uses' => 'TablePagesController@datatableTables']);

    Route::get('regular-form', ['as' => 'page.regular_forms', 'uses' => 'FormPagesController@regularForms']);
    Route::get('extended-form', ['as' => 'page.extended_forms', 'uses' => 'FormPagesController@extendedForms']);
    Route::get('validation-form', ['as' => 'page.validation_forms', 'uses' => 'FormPagesController@validationForms']);
    Route::get('wizard-form', ['as' => 'page.wizard_forms', 'uses' => 'FormPagesController@wizardForms']);

    Route::get('google-maps', ['as' => 'page.google_maps', 'uses' => 'MapPagesController@googleMaps']);
    Route::get('fullscreen-maps', ['as' => 'page.fullscreen_maps', 'uses' => 'MapPagesController@fullscreenMaps']);
    Route::get('vector-maps', ['as' => 'page.vector_maps', 'uses' => 'MapPagesController@vectorMaps']);
  });
