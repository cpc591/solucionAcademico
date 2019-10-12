@extends('Layout.master')
@section('Title','Listado de solicitudes')
@section('app','ng-app="appRadicacion"')
@section('controller','ng-controller="vista_consecutivosCtrl"')


@section('contenido')
    <div class="container">
             
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                
                <a class="navbar-brand ">Solicitudes</a>
                <li role="presentation" class="active"><a href="#lista" aria-controls="lista" role="tab" data-toggle="tab">Solicitudes sin radicar</a></li>
                <li role="presentation"><a href="#listaSolicitudesRadicadas" aria-controls="listaSolicitudesRadicadas" role="tab" data-toggle="tab">Solicitudes con radicado</a></li>
                <li role="presentation"><a href="#respuestasRadicadas" aria-controls="listaRespuestasRadicadas" role="tab" data-toggle="tab">Respuestas con radicado</a></li>
                <li role="presentation"><a href="#respuestasSinRadicar" aria-controls="listaRespuestasSinRadicar" role="tab" data-toggle="tab">Respuestas sin radicar</a></li>
                <li role="presentation"><a href="#rechazadas" aria-controls="rechazadas" role="tab" data-toggle="tab">Solicitudes rechazadas</a></li>
              </ul>
            
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="lista" style="padding:30px">
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(solicitudes | filter:searchSolSinRad).length > 0 ">
                        <p>Hay @{{(solicitudes | filter:searchSolSinRad).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="solicitudes.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(solicitudes | filter:searchSolSinRad).length == 0 && solicitudes.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (searchSolSinRad.asunto_nuevo.nombre.length > 0 || searchSolSinRad.created_at.length > 0 || searchSolSinRad.estudiante.nombre.length > 0 || searchSolSinRad.estudiante.codigo.length > 0 )">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estudiante</th>
                            <th>Código</th>
                            <th>Fecha de creación</th>
                            <th>Acciòn</th>
                            
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                            <td><input type="text" ng-model="searchSolSinRad.asunto_nuevo.nombre" name="asunto" id="asunto" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchSolSinRad.estudiante.nombre" name="nombreEstudiante" id="nombreEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchSolSinRad.estudiante.codigo" name="codigoEstudiante" id="codigoEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchSolSinRad.created_at" name="created_at" id="created_at" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                            <td></td>
                        </tr>
                        
                        <tr dir-paginate="x in solicitudes | filter:searchSolSinRad| itemsPerPage:10"  pagination-id="paginacion_solicitudesSinRadicar" ng-if="x.consecutivo == null">
                            <td> 
                              <span ng-if="x.asunto!=null">@{{x.asunto}}</span>
                              <span ng-if="x.asunto_id!=null">@{{x.asunto_nuevo.nombre}}</span>
                            </td>
                            <td>@{{x.estudiante.nombre}}</td>
                            <td>@{{x.estudiante.codigo}}</td>
                            <td >@{{x.created_at}}</td>
                            <td>
                              <a ng-if="x.consecutivo==null" href="" ng-click="crear_consecutivo(x)"  class="btn btn-sm btn-default texto_azul" title="Crear consecutivo"><span class="glyphicon glyphicon-plus-sign"></span></a>
                              <a ng-if="x.consecutivo==null" href="/ver_mas/@{{x.id}}"  class="btn btn-sm btn-default texto_azul" title="Ver más de solicitud"><span class="glyphicon glyphicon-eye-open"></span></a>
                              <a ng-if="x.consecutivo==null" href="" ng-click="rechazarRadicacionModal(x)"  class="btn btn-sm btn-default" title="Rechazo de radicación"><span class="glyphicon glyphicon-remove"></span></a>
                            <!--<a ng-if="x.consecutivo!=null" href="" ng-click="editar_consecutivo2(x)"  class="btn btn-sm btn-default texto_azul" title="Editar consecutivo"><span class="glyphicon glyphicon-edit"></span></a>-->
                            </td>
                        </tr>
                        
                    </table> 
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_solicitudesSinRadicar" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal_consecutivo" tabindex="-1" role="dialog" aria-labelledby="modal_consecutivo">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="modal_consecutivo">Creación radicado de solicitud</h3>
                          </div>
                          <div class="modal-body">
                              <div class="alert alert-danger" ng-if="errores != null">
                                <h6>Errores</h6>
                                <span class="messages" ng-repeat="error in errores">
                                      <span>@{{error}}</span>
                                </span>
                            </div>
                            
                            <form role="form" name="formConsecutivo"  novalidate>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12" >
                                        <label><span class="asterisco">*</span>Radicado</label>
                                        <input class="form-control" type="text" name="consecutivo" ng-model="consecutivo.consecutivo" ng-required="true"></input>
                                        <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.consecutivo.$touched">
                                            <span ng-show="formConsecutivo.consecutivo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-xs-12">
                                    <label><span class="asterisco">*</span>Fecha de radicación</label>
                                    <adm-dtp ng-model='consecutivo.fecha' name="fechaRad" options='date1_options'></adm-dtp>
                                    <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.fechaRad.$touched">
                                        <span ng-show="formConsecutivo.fechaRad.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                    </span>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Hora radicado</label>
                                      <input class="form-control" min="0" max="12" type="number" name="horaRadicado" ng-model="consecutivo.horaRadicado" ng-required="true"></input>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.horaRadicado.$touched">
                                          <span ng-show="formConsecutivo.horaRadicado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.horaRadicado.$touched">
                                          <span ng-show="formConsecutivo.horaRadicado.$error.min" class="color_errores">Debe ser mayor o igual a cero.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.horaRadicado.$touched">
                                          <span ng-show="formConsecutivo.horaRadicado.$error.max" class="color_errores">Debe ser menor o igual a 12.</span>
                                      </span>
                                  </div>
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Minuto radicado</label>
                                      <input class="form-control" min="0" max="59" type="number" name="minutoRadicado" ng-model="consecutivo.minutoRadicado" ng-required="true"></input>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivo.minutoRadicado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivo.minutoRadicado.$error.min" class="color_errores">Debe ser mayor o igual a cero.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivo.minutoRadicado.$error.max" class="color_errores">Debe ser menor o igual a 59.</span>
                                      </span>
                                  </div>
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Jornada</label><br>
                                    <input ng-model="consecutivo.am" checked="checked" ng-required="true" type="radio" name="am" value="0"> AM
                                    <input ng-model="consecutivo.am" ng-required="true" type="radio" name="am" value="1"> PM<br>
                                  </div>
                                </div>
                            </form>
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a  type="button" ng-click="guardar_consecutivo()" class="btn btn-primary">Guardar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal_editar_consecutivo" tabindex="-1" role="dialog" aria-labelledby="modal_editar_consecutivo">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="modal_consecutivo">Editar consecutivo</h3>
                          </div>
                          <div class="modal-body">
                              <div class="alert alert-danger" ng-if="errores != null">
                                <h6>Errores</h6>
                                <span class="messages" ng-repeat="error in errores">
                                      <span>@{{error}}</span>
                                </span>
                            </div>
                            
                            <form role="form" name="editarConsecutivo"  novalidate>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Consecutivo</label>
                                        <input class="form-control" type="text" name="consecutivo" ng-model="editar_consecutivo.consecutivo" ng-required="true"></input>
                                        <span class="messages" ng-show="editarConsecutivo.$submitted || editarConsecutivo.consecutivo.$touched">
                                            <span ng-show="editarConsecutivo.consecutivo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                    </div>
                                </div>
                            </form>
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a  type="button" ng-click="modificar_consecutivo()" class="btn btn-primary">Guardar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Modal form reenviar-->
                    <div class="modal fade" id="rechazoRadicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="myModalLabel">Razón por la cual la solicitud no se radica</h3>
                          </div>
                          <div class="modal-body">
                            <form role="form" name="formRechazoRadicacion"  novalidate>
                              <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                            <label><span class="asterisco">*</span>Comentario</label>
                                            <textarea  style="height:110px; text-align:left;" ng-model="rechazo.comentario" class="form-control" name="comentario" ng-required="true" >
                        
                                            </textarea>
                                            
                                            <span class="messages" ng-show="formRechazoRadicacion.$submitted">
                                                <span ng-show="formRechazoRadicacion.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                      
                                    </div>
                              </div>
                            </form>
                              
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a type="button" ng-click="rechazarRadicacion()" class="btn btn-success">Guardar</a>
                          </div>
                        </div>
                      </div>
                    </div> 
              </div>
                <div role="tabpanel" class="tab-pane " id="listaSolicitudesRadicadas" style="padding:30px">
                    
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltroSolRadicadas=!mostrarFiltroSolRadicadas" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(solicitudesConRadicacion | filter:search).length > 0 ">
                        <p>Hay @{{(solicitudesConRadicacion | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="solicitudesConRadicacion.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(solicitudesConRadicacion | filter:search).length == 0 && encuestas.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltroSolRadicadas == false && (search.asunto_nuevo.nombre.length > 0 || search.created_at.length > 0 || search.consecutivo.length > 0 || search.estudiante.nombre.length > 0 || search.estudiante.codigo.length > 0 )">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                    
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estudiante</th>
                            <th>Código</th>
                            <th>Fecha de creación</th>
                            <th>Radicado</th>
                            
                        </tr>
                        <tr ng-show="mostrarFiltroSolRadicadas == true">
                            <td><input type="text" ng-model="search.asunto_nuevo.nombre" name="asunto" id="asunto" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estudiante.nombre" name="nombreEstudiante" id="nombreEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estudiante.codigo" name="codigoEstudiante" id="codigoEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.created_at" name="created_at" id="created_at" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.consecutivo" name="consecutivo" id="consecutivo" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            
                            <td></td>
                        </tr>
                        
                        <tr dir-paginate="x in solicitudesConRadicacion | filter:search| itemsPerPage:10" pagination-id="paginacion_solicitudesRadicadas">
                            <td> 
                              <span ng-if="x.asunto!=null">@{{x.asunto}}</span>
                              <span ng-if="x.asunto_id!=null">@{{x.asunto_nuevo.nombre}}</span>
                            </td>
                            <td >@{{x.estudiante.nombre}}</td>
                            <td >@{{x.estudiante.codigo}}</td>
                            <td >@{{x.created_at}}</td>
                            <td>@{{x.consecutivo}}</td>
                        </tr>
                        
                    </table>
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_solicitudesRadicadas" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
              </div>
                
                <div role="tabpanel" class="tab-pane" id="respuestasRadicadas" style="padding:30px">
                  
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltroResRadicadas=!mostrarFiltroResRadicadas" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(resRadicadas | filter:searchResRadicadas).length > 0 ">
                        <p>Hay @{{(resRadicadas | filter:searchResRadicadas).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="resRadicadas.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(resRadicadas | filter:searchResRadicadas).length == 0 && resRadicadas.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltroResRadicadas == false && (searchResRadicadas.estudiante.radicadoSolicitud.length > 0 || searchResRadicadas.estudiante.nombreAsunto.length > 0 || searchResRadicadas.user_create.length > 0 || searchResRadicadas.estudiante.nombre.length > 0 || searchResRadicadas.estudiante.codigo.length > 0 || searchResRadicadas.fecha_radicado.length > 0 || searchResRadicadas.radicado.length > 0 )">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                    <table class="table table-hover">
                        <tr>
                            <th>Radicado solicitud</th>
                            <th>Solicitud</th>
                            <th>Dependencia</th>
                            <th>Estudiante</th>
                            <th>Código</th>
                            <th>Radicado</th>
                            <th>Fecha de radicado</th>
                            <th>Acción</th>
                            
                        </tr>
                        
                        <tr ng-show="mostrarFiltroResRadicadas == true">
                            <td><input type="text" ng-model="searchResRadicadas.estudiante.radicadoSolicitud" name="radicadoSolicitud" id="radicadoSolicitud" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchResRadicadas.estudiante.nombreAsunto" name="asunto" id="asunto" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchResRadicadas.user_create" name="user_create" id="user_create" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                            <td><input type="text" ng-model="searchResRadicadas.estudiante.nombre" name="nombreEstudiante" id="nombreEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchResRadicadas.estudiante.codigo" name="codigoEstudiante" id="codigoEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchResRadicadas.radicado" name="radicado" id="radicado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchResRadicadas.fecha_radicado" name="fecha_radicado" id="fecha_radicado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            
                            
                            <td></td>
                        </tr>
                        
                        <tr dir-paginate="x in resRadicadas | filter:searchResRadicadas| itemsPerPage:10"  pagination-id="paginacion_respuestasRadicadas">
                            <td>@{{x.estudiante.radicadoSolicitud}}</td>
                            <td>@{{x.estudiante.nombreAsunto != null ? x.estudiante.nombreAsunto : x.estudiante.asunto}}</td>
                            <td> 
                              @{{x.user_create}}
                            </td>
                            <td>@{{x.estudiante.nombre}}</td>
                            <td>@{{x.estudiante.codigo}}</td>
                            <td>@{{x.radicado}}</td>
                            <td>@{{x.fecha_radicado}}</td>
                            <td><a ng-if="x.radicado!=null" target="_blank" href="/pdfRespuesta/@{{x.estudiante.idSolicitud}}" class="btn btn-sm btn-default texto_azul" title="Ver respuesta"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                        </tr>
                        
                    </table> 
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_respuestasRadicadas" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
              </div>
                <div role="tabpanel" class="tab-pane" id="respuestasSinRadicar" style="padding:30px">
                  <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltroResSinRad=!mostrarFiltroResSinRad" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(resSinRadicar | filter:searchResSinRad).length > 0 ">
                        <p>Hay @{{(resSinRadicar | filter:searchResSinRad).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="resSinRadicar.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(resSinRadicar | filter:searchResSinRad).length == 0 && resSinRadicar.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltroResSinRad == false && (searchResSinRad.estudiante.radicadoSolicitud.length > 0||searchResSinRad.estudiante.nombreAsunto.length > 0 || searchSolSinRad.user_create.length > 0 || searchSolSinRad.estudiante.nombre.length > 0 || searchSolSinRad.estudiante.codigo.length > 0 )">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Dependencia</th>
                            <th>Estudiante</th>
                            <th>Código</th>
                            <th>Radicado</th>
                            <th>Acciòn</th>
                            
                        </tr>
                        
                        <tr ng-show="mostrarFiltroResSinRad == true">
                            <td><input type="text" ng-model="searchResSinRad.estudiante.nombreAsunto" name="asunto" id="asunto" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchResSinRad.user_create" name="user_create" id="user_create" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                            <td><input type="text" ng-model="searchResSinRad.estudiante.nombre" name="nombreEstudiante" id="nombreEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchResSinRad.estudiante.codigo" name="codigoEstudiante" id="codigoEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchResSinRad.estudiante.radicadoSolicitud" name="consecutivo" id="consecutivo" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                            <td></td>
                        </tr>
                        
                        <tr dir-paginate="x in resSinRadicar | filter:searchResSinRad| itemsPerPage:10"  pagination-id="paginacion_respuestasSinRadicar">
                            <td>@{{x.estudiante.nombreAsunto != null ? x.estudiante.nombreAsunto : x.estudiante.asunto}}</td>
                            <td> 
                              @{{x.user_create}}
                            </td>
                            <td>@{{x.estudiante.nombre}}</td>
                            <td>@{{x.estudiante.codigo}}</td>
                            <td>@{{x.estudiante.radicadoSolicitud}}</td>
                            <td>
                              <a ng-if="x.radicado==null" href="" ng-click="crear_consecutivoRespuesta(x)"  class="btn btn-sm btn-default texto_azul" title="Crear radicado"><span class="glyphicon glyphicon-plus-sign"></span></a>
                              <a ng-if="x.radicado==null" target="_blank" href="/pdfRespuesta/@{{x.estudiante.idSolicitud}}" class="btn btn-sm btn-default texto_azul" title="Ver respuesta"><span class="glyphicon glyphicon-eye-open"></span></a>
                              <a ng-if="x.radicado==null" href="" ng-click="rechazarRespuestaModal(x)"  class="btn btn-sm btn-default" title="Rechazo de radicación"><span class="glyphicon glyphicon-remove"></span></a>
                            <!--<a ng-if="x.consecutivo!=null" href="" ng-click="editar_consecutivo2(x)"  class="btn btn-sm btn-default texto_azul" title="Editar consecutivo"><span class="glyphicon glyphicon-edit"></span></a>-->
                            </td>
                        </tr>
                        
                    </table>
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_respuestasSinRadicar" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal_consecutivoRespuesta" tabindex="-1" role="dialog" aria-labelledby="modal_consecutivoRespuesta">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="modal_consecutivoRespuesta">Creación radicado de solicitud</h3>
                          </div>
                          <div class="modal-body">
                              <div class="alert alert-danger" ng-if="errores != null">
                                <h6>Errores</h6>
                                <span class="messages" ng-repeat="error in errores">
                                      <span>@{{error}}</span>
                                </span>
                            </div>
                            
                            <form role="form" name="formConsecutivoRespuesta"  novalidate>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Radicado</label>
                                        <input class="form-control" type="text" name="consecutivo" ng-model="consecutivo.consecutivo" ng-required="true"></input>
                                        <span class="messages" ng-show="formConsecutivoRespuesta.$submitted || formConsecutivoRespuesta.consecutivo.$touched">
                                            <span ng-show="formConsecutivoRespuesta.consecutivo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-xs-12">
                                    <label><span class="asterisco">*</span>Fecha de radicación</label>
                                    <adm-dtp ng-model='consecutivo.fecha' name="fechaRadicado" options='date1_options'></adm-dtp>
                                    <span class="messages" ng-show="formConsecutivoRespuesta.$submitted || formConsecutivoRespuesta.fechaRadicado.$touched">
                                        <span ng-show="formConsecutivoRespuesta.fechaRadicado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                    </span>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Hora radicado</label>
                                      <input class="form-control" min="0" max="12" type="number" name="horaRadicado" ng-model="consecutivo.horaRadicado" ng-required="true"></input>
                                      <span class="messages" ng-show="formConsecutivoRespuesta.$submitted || formConsecutivoRespuesta.horaRadicado.$touched">
                                          <span ng-show="formConsecutivoRespuesta.horaRadicado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivoRespuesta.$submitted || formConsecutivoRespuesta.horaRadicado.$touched">
                                          <span ng-show="formConsecutivoRespuesta.horaRadicado.$error.min" class="color_errores">Debe ser mayor o igual a cero.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivoRespuesta.$submitted || formConsecutivoRespuesta.horaRadicado.$touched">
                                          <span ng-show="formConsecutivoRespuesta.horaRadicado.$error.max" class="color_errores">Debe ser menor o igual a 12.</span>
                                      </span>
                                  </div>
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Minuto radicado</label>
                                      <input class="form-control" min="0" max="59" type="number" name="minutoRadicado" ng-model="consecutivo.minutoRadicado" ng-required="true"></input>
                                      <span class="messages" ng-show="formConsecutivoRespuesta.$submitted || formConsecutivoRespuesta.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivoRespuesta.minutoRadicado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivoRespuesta.$submitted || formConsecutivoRespuesta.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivoRespuesta.minutoRadicado.$error.min" class="color_errores">Debe ser mayor o igual a cero.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivoRespuesta.$submitted || formConsecutivoRespuesta.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivoRespuesta.minutoRadicado.$error.max" class="color_errores">Debe ser menor o igual a 59.</span>
                                      </span>
                                  </div>
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Jornada</label><br>
                                    <input ng-model="consecutivo.am" ng-required="true" type="radio" name="am" value="0"> AM
                                    <input ng-model="consecutivo.am" ng-required="true" type="radio" name="am" value="1"> PM<br>
                                  </div>
                                </div>
                            </form>
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a  type="button" ng-click="guardar_consecutivoRespuesta()" class="btn btn-primary">Guardar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Modal form rechazo respuesta-->
                    <div class="modal fade" id="rechazoRespuesta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="myModalLabel">Razón por la cual la respuesta no se radica</h3>
                          </div>
                          <div class="modal-body">
                            <form role="form" name="formRechazoRespuesta"  novalidate>
                              <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                            <label><span class="asterisco">*</span>Comentario</label>
                                            <textarea  style="height:110px; text-align:left;" ng-model="rechazo.comentario" class="form-control" name="comentario" ng-required="true" >
                        
                                            </textarea>
                                            
                                            <span class="messages" ng-show="formRechazoRadicacion.$submitted">
                                                <span ng-show="formRechazoRadicacion.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                      
                                    </div>
                              </div>
                            </form>
                              
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a type="button" ng-click="rechazarRespuesta()" class="btn btn-success">Guardar</a>
                          </div>
                        </div>
                      </div>
                    </div> 
                    
              </div>
              
                <div role="tabpanel" class="tab-pane" id="rechazadas" style="padding:30px">
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltroRechazadas=!mostrarFiltroRechazadas" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(solicitudesRechazadas | filter:searchRechazadas).length > 0 ">
                        <p>Hay @{{(solicitudesRechazadas | filter:searchRechazadas).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="solicitudesRechazadas.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(solicitudesRechazadas | filter:searchRechazadas).length == 0 && solicitudesRechazadas.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltroRechazadas == false && (searchRechazadas.asunto_nuevo.nombre.length > 0 || searchRechazadas.created_at.length > 0 || searchRechazadas.estudiante.nombre.length > 0 || searchRechazadas.estudiante.codigo.length > 0 )">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estudiante</th>
                            <th>Código</th>
                            <th>Fecha de creación</th>
                            <th>Acciòn</th>
                            
                        </tr>
                        <tr ng-show="mostrarFiltroRechazadas == true">
                            <td><input type="text" ng-model="searchRechazadas.asunto_nuevo.nombre" name="asunto" id="asunto" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRechazadas.estudiante.nombre" name="nombreEstudiante" id="nombreEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRechazadas.estudiante.codigo" name="codigoEstudiante" id="codigoEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRechazadas.created_at" name="created_at" id="created_at" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                            <td></td>
                        </tr>
                        
                        <tr dir-paginate="x in solicitudesRechazadas | filter:searchRechazadas| itemsPerPage:10"  pagination-id="paginacion_solicitudesRechazadas" ng-if="x.consecutivo == null">
                            <td> 
                              <span ng-if="x.asunto!=null">@{{x.asunto}}</span>
                              <span ng-if="x.asunto_id!=null">@{{x.asunto_nuevo.nombre}}</span>
                            </td>
                            <td>@{{x.estudiante.nombre}}</td>
                            <td>@{{x.estudiante.codigo}}</td>
                            <td >@{{x.created_at}}</td>
                            <td>
                              <a ng-if="x.consecutivo==null" href="/ver_mas/@{{x.id}}"  class="btn btn-sm btn-default texto_azul" title="Ver más de solicitud"><span class="glyphicon glyphicon-eye-open"></span></a>
                              
                            <!--<a ng-if="x.consecutivo!=null" href="" ng-click="editar_consecutivo2(x)"  class="btn btn-sm btn-default texto_azul" title="Editar consecutivo"><span class="glyphicon glyphicon-edit"></span></a>-->
                            </td>
                        </tr>
                        
                    </table> 
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_solicitudesRechazadas" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal_consecutivo" tabindex="-1" role="dialog" aria-labelledby="modal_consecutivo">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="modal_consecutivo">Creación radicado de solicitud</h3>
                          </div>
                          <div class="modal-body">
                              <div class="alert alert-danger" ng-if="errores != null">
                                <h6>Errores</h6>
                                <span class="messages" ng-repeat="error in errores">
                                      <span>@{{error}}</span>
                                </span>
                            </div>
                            
                            <form role="form" name="formConsecutivo"  novalidate>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12" >
                                        <label><span class="asterisco">*</span>Radicado</label>
                                        <input class="form-control" type="text" name="consecutivo" ng-model="consecutivo.consecutivo" ng-required="true"></input>
                                        <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.consecutivo.$touched">
                                            <span ng-show="formConsecutivo.consecutivo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-xs-12">
                                    <label><span class="asterisco">*</span>Fecha de radicación</label>
                                    <adm-dtp ng-model='consecutivo.fecha' name="fechaRad" options='date1_options'></adm-dtp>
                                    <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.fechaRad.$touched">
                                        <span ng-show="formConsecutivo.fechaRad.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                    </span>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Hora radicado</label>
                                      <input class="form-control" min="0" max="12" type="number" name="horaRadicado" ng-model="consecutivo.horaRadicado" ng-required="true"></input>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.horaRadicado.$touched">
                                          <span ng-show="formConsecutivo.horaRadicado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.horaRadicado.$touched">
                                          <span ng-show="formConsecutivo.horaRadicado.$error.min" class="color_errores">Debe ser mayor o igual a cero.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.horaRadicado.$touched">
                                          <span ng-show="formConsecutivo.horaRadicado.$error.max" class="color_errores">Debe ser menor o igual a 12.</span>
                                      </span>
                                  </div>
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Minuto radicado</label>
                                      <input class="form-control" min="0" max="59" type="number" name="minutoRadicado" ng-model="consecutivo.minutoRadicado" ng-required="true"></input>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivo.minutoRadicado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivo.minutoRadicado.$error.min" class="color_errores">Debe ser mayor o igual a cero.</span>
                                      </span>
                                      <span class="messages" ng-show="formConsecutivo.$submitted || formConsecutivo.minutoRadicado.$touched">
                                          <span ng-show="formConsecutivo.minutoRadicado.$error.max" class="color_errores">Debe ser menor o igual a 59.</span>
                                      </span>
                                  </div>
                                  <div class="col-md-4 col-xs-12">
                                    <label><span class="asterisco">*</span>Jornada</label><br>
                                    <input ng-model="consecutivo.am" checked="checked" ng-required="true" type="radio" name="am" value="0"> AM
                                    <input ng-model="consecutivo.am" ng-required="true" type="radio" name="am" value="1"> PM<br>
                                  </div>
                                </div>
                            </form>
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a  type="button" ng-click="guardar_consecutivo()" class="btn btn-primary">Guardar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal_editar_consecutivo" tabindex="-1" role="dialog" aria-labelledby="modal_editar_consecutivo">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="modal_consecutivo">Editar consecutivo</h3>
                          </div>
                          <div class="modal-body">
                              <div class="alert alert-danger" ng-if="errores != null">
                                <h6>Errores</h6>
                                <span class="messages" ng-repeat="error in errores">
                                      <span>@{{error}}</span>
                                </span>
                            </div>
                            
                            <form role="form" name="editarConsecutivo"  novalidate>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Consecutivo</label>
                                        <input class="form-control" type="text" name="consecutivo" ng-model="editar_consecutivo.consecutivo" ng-required="true"></input>
                                        <span class="messages" ng-show="editarConsecutivo.$submitted || editarConsecutivo.consecutivo.$touched">
                                            <span ng-show="editarConsecutivo.consecutivo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                    </div>
                                </div>
                            </form>
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a  type="button" ng-click="modificar_consecutivo()" class="btn btn-primary">Guardar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Modal form reenviar-->
                    <div class="modal fade" id="rechazoRadicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="myModalLabel">Razón por la cual la solicitud no se radica</h3>
                          </div>
                          <div class="modal-body">
                            <form role="form" name="formRechazoRadicacion"  novalidate>
                              <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                            <label><span class="asterisco">*</span>Comentario</label>
                                            <textarea  style="height:110px; text-align:left;" ng-model="rechazo.comentario" class="form-control" name="comentario" ng-required="true" >
                        
                                            </textarea>
                                            
                                            <span class="messages" ng-show="formRechazoRadicacion.$submitted">
                                                <span ng-show="formRechazoRadicacion.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                      
                                    </div>
                              </div>
                            </form>
                              
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <a type="button" ng-click="rechazarRadicacion()" class="btn btn-success">Guardar</a>
                          </div>
                        </div>
                      </div>
                    </div> 
              </div>
             
            </div>
            
    </div>
@endsection

@section('javascript')
    
    
    <script src="{{asset('/js/plugins/angular-material/angular-animate.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-material/angular-aria.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-material/angular-messages.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-material/angular-material.min.js')}}"></script>
    <script src="{{asset('/js/plugins/material.min.js')}}"></script>
    
    <script src="{{asset('/js/plugins/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
  	<script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
  	<script src="{{asset('/js/radicacion/radicacion.js')}}"></script>
    <script src="{{asset('/js/radicacion/radicacionServices.js')}}"></script>
@endsection