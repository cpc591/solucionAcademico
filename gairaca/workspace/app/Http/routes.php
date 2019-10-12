<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('index', function () {
    return view('index');
});
Route::get('master', function () {
    return view('Layout/master');
});
Route::get('solicitar', function () {
    return view('solicitar');
});

Route::get('/calendario', 'CalendarioController@calendario');
Route::get('/calendarioIncluidos', 'CalendarioController@calendarioIncluidos');
Route::get('/calendarioExcluidos', 'CalendarioController@calendarioExcluidos');

Route::get('/crear', 'UserController@crear');

Route::post('/loginestudiante', 'LoginController@loginestudiante');
Route::post('/logindependencia', 'LoginController@logindependencia');
Route::get('/cerrar_sesion', 'LoginController@cerrar_sesion');

//Solicitudes
Route::get('directorAcademico', 'SolicitudeController@directorAcademico');
Route::get('bandeja3', 'SolicitudeController@bandeja3');
Route::get('vista_consecutivos', 'RadicacionController@vista_consecutivos');
Route::get('bandeja2', 'SolicitudeController@bandeja2');
Route::get('bandeja', 'SolicitudeController@bandeja');
Route::get('academico', 'SolicitudeController@academico');
Route::get('/responder/{id}', 'SolicitudeController@responder');
Route::get('/obtener_solicitud/{id}', 'SolicitudeController@obtener_solicitud');
Route::get('/responder_desarrollo/{id}', 'SolicitudeController@responder_desarrollo');
Route::get('/responder_academico/{id}', 'SolicitudeController@responder_academico');
Route::get('/aprobar_vista/{id}', 'SolicitudeController@aprobar_vista');
Route::get('/aprobar_vista_desarrollo/{id}', 'SolicitudeController@aprobar_vista_desarrollo');
Route::get('/aprobar_directorAcademico/{id}', 'SolicitudeController@aprobar_vista_academico');
Route::get('/ver_mas/{id}', 'SolicitudeController@ver_mas');
Route::get('/ver_mas_academico/{id}', 'SolicitudeController@ver_mas_academico');
Route::get('/ver_mas_concepto/{id}', 'SolicitudeController@ver_mas_concepto');

Route::get('/datos_para_solicitud', 'SolicitudeController@datos_para_solicitud');
Route::get('/tipos', 'TipoController@lista_tipos');
Route::get('/acciones', 'AccioneController@lista_acciones');
Route::get('/asuntos', 'AsuntoController@lista_asuntos');
Route::post('/crear_solicitud', 'SolicitudeController@crear_solicitud');
Route::post('/crear_solicitud_estudiante', 'SolicitudeController@crear_solicitud_estudiante');
Route::get('/lista_dependencia', 'UserController@lista_dependencia');
Route::get('/lista_dependencia_responder', 'UserController@lista_dependencia_responder');

Route::post('/eliminar_soporteRespuesta', 'RespuestaController@eliminar_soporteRespuesta');
Route::post('/guardarEncargado', 'SolicitudeController@guardarEncargado');

Route::post('/peticion', 'UserController@peticion');
Route::get('/listado_solicitudes', 'SolicitudeController@listado_solicitudes');

Route::get('/prueba', 'SolicitudeController@prueba');
Route::get('/listado_solicitudes_dependencias', 'SolicitudeController@listado_solicitudes_dependencias');
Route::get('/total_solicitudes', 'SolicitudeController@total_solicitudes');
Route::get('/listado_solicitudes_dependencias', 'SolicitudeController@listado_solicitudes_dependencias');
Route::get('/listado_solicitudes_estudiantes', 'SolicitudeController@listado_solicitudes_estudiantes');
Route::get('/listado_solicitudes_academico', 'SolicitudeController@listado_solicitudes_academico');
Route::get('/listado_solicitudes_por_aprobar', 'SolicitudeController@listado_solicitudes_por_aprobar');
Route::get('/listado_solicitudes_respondidas_a_desarrollo', 'SolicitudeController@listado_solicitudes_respondidas_a_desarrollo');
Route::get('/listado_solicitudes_respondidas_por_desarrollo', 'SolicitudeController@listado_solicitudes_respondidas_por_desarrollo');
Route::get('/listado_solicitudes_directorAcademico', 'SolicitudeController@listado_solicitudes_directorAcademico');


Route::post('/aprobar_solicitud', 'SolicitudeController@aprobar_solicitud');
Route::post('/reenviar_solicitud', 'SolicitudeController@reenviar_solicitud');
Route::post('/datos_solicitud', 'SolicitudeController@datos_solicitud');
Route::post('/datos_solicitud_desarrollo', 'SolicitudeController@datos_solicitud_desarrollo');
Route::get('/ver_mas_solicitud/{id}', 'SolicitudeController@ver_mas_solicitud');
Route::post('/ver_mas_solicitudAcademico', 'SolicitudeController@ver_mas_solicitudAcademico');

Route::get('/solicitudes_radicacion', 'RadicacionController@solicitudes_radicacion');
Route::post('/guardar_consecutivo', 'RadicacionController@guardar_consecutivo');
Route::post('/guardar_consecutivoRespuesta', 'RadicacionController@guardar_consecutivoRespuesta');
//Respuesta
Route::post('/crear_respuesta', 'RespuestaController@crear_respuesta');
Route::post('/crear_borrador', 'RespuestaController@crear_borrador');


Route::post('/crear_novedad', 'NovedadeController@crear_novedad');
Route::post('/crear_solicitud_concepto', 'Solicitude_conceptoController@crear_solicitud_concepto');

Route::post('/asignar_limite', 'SolicitudeController@asignar_limite');
Route::get('/listado_novedades', 'NovedadeController@listado_novedades');
Route::post('/agregarFechasIncluidos', 'SolicitudeController@agregarFechasIncluidos');
Route::post('/agregarFechasExcluidos', 'SolicitudeController@agregarFechasExcluidos');
Route::get('/fechasCalendario', 'CalendarioController@fechasCalendario');
Route::get('/fechasCalendarioIncluidos', 'CalendarioController@fechasCalendarioIncluidos');
Route::get('/fechasCalendarioExcluidos', 'CalendarioController@fechasCalendarioExcluidos');
Route::post('/noAprobarDirector', 'SolicitudeController@noAprobarDirector');

Route::get('/vista_solicitud_concepto/{id}', 'Solicitude_conceptoController@vista_solicitud_concepto');
Route::get('/datos_solicitud_concepto/{id}', 'Solicitude_conceptoController@datos_solicitud_concepto');
Route::post('/crear_respuesta_concepto', 'RespuestaConceptoController@crear_respuesta_concepto');
Route::post('/corregir', 'RespuestaController@corregir');
Route::get('/pdfRespuesta/{id}', 'RespuestaController@pdf_respuesta');

Route::get('/agregarSolicitudeUser', 'SolicitudeController@agregarSolicitudeUser');
Route::post('/rechazarRadicacion', 'RadicacionController@rechazarRadicacion');
Route::post('/rechazarRespuesta', 'RespuestaController@rechazarRespuesta');

Route::post('/loginestudiante', 'LoginController@loginestudiante');
Route::post('/logindependencia', 'LoginController@logindependencia');
Route::get('/cerrar_sesion', 'LoginController@cerrar_sesion');
