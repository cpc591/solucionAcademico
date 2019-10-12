@extends('Layout.master')
@section('Title','Listado de solicitudes')
@section('app','ng-app="appDependencia"')
@section('controller','ng-controller="listado_solicitudes_dependenciasCtrl"')


@section('contenido')
    <div class="container">
            
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                <!-- Nav tabs -->
                <div class="row">
                  <div class="col-xs-12">
                    <ul class="nav nav-tabs" role="tablist">
                
                      <a class="navbar-brand ">Solicitudes</a>
                      <li role="presentation" class="active"><a href="#lista" aria-controls="lista" role="tab" data-toggle="tab">Listado de solicitudes</a></li>
                      <li role="respondidas" ><a href="#respondidas" aria-controls="respondidas" role="tab" data-toggle="tab">Respondidas</a></li>
                      <li role="listaSolicitudConcepto" ><a href="#listaSolicitudConcepto" aria-controls="listaSolicitudConcepto" role="tab" data-toggle="tab">Solicitudes de conceptos</a></li>
                      <!--<li class="navbar-right" role="presentation"><a href="/cerrar_sesion">Cerrar sesión</a></li>
                      <li class="navbar-right" role="presentation"><a href="/bandeja3">{{Auth::user()->nombre}}</a></li>-->
                    </ul>
                  </div>
                </div>
              
            
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="lista" style="padding:30px">
                    <!--
                    <div class="row">
                      <div class="col-md-3 col-xs-12">
                        <label>Filtrar por estado</label>
                        <select class="form-control" name="accion" id="accion" ng-options="accion.id as accion.nombre for accion in acciones" ng-model="accion" ng-required="true">
                          <option value="">Seleccione una acción</option>
                        </select>
                      </div>
                      <div class="col-md-3 col-xs-12">
                        <label>Filtrar por tipo</label>
                        <select class="form-control" name="tipo" id="tipo" ng-options="tipo.id as tipo.nombre for tipo in tipos" ng-model="tipo" ng-required="true">
                          <option value="">Seleccione un tipo</option>
                        </select>
                      </div>
                      <br>
                      <div class="col-md-4 col-xs-12">
                        <label>&nbsp</label>
                        <input type="text" class="form-control" placeholder="Buscar" ng-model="buscar">
                      </div>
                      <div class="col-md-2 col-xs-12">
                        <label>&nbsp</label>
                        <div class="alert alert-info cant_tabla">
                            <span>@{{(listado_solicitudes_dependencias | filter:search).length}} resultados</span>
                        </div>
                      </div>
                      
                    </div>-->
                    
                    
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(listado_solicitudes_dependencias | filter:search).length > 0 ">
                        <p>Hay @{{(listado_solicitudes_dependencias | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="listado_solicitudes_dependencias.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(listado_solicitudes_dependencias | filter:search).length == 0 && listado_solicitudes_dependencias.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.asunto_nuevo.nombre.length > 0 || search.accion_nombre.length > 0 || search.created_at.length > 0 || search.duracion.length > 0 || search.fechaEstimada.length > 0 || search.estudiante.nombre.length > 0 || search.estudiante.codigo.length > 0 || search.encargado.length > 0 )">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                            
                    <table class="table table-hover">
                      <thead>
                        <tr>
                            <th>Radicado</th>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th>Fecha de creación</th>
                            <th>Duración</th>
                            <th>Fecha estimada</th>
                            <th>Estudiante</th>
                            <th>Código</th>
                            @if(Auth::user()->id == 39)
                              <th>Encargado</th>
                            @endif
                            <th style="width:100px;">Acción</th>
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                            <td><input type="text" ng-model="search.consecutivo" name="consecutivo" id="consecutivo" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.asunto_nuevo.nombre" name="asunto" id="asunto" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                                    
                            <td><input type="text" ng-model="search.accion_nombre" name="accion_nombre" id="accion_nombre" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.created_at" name="created_at" id="created_at" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.duracion" name="duracion" id="duracion" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.fechaEstimada" name="fechaEstimada" id="fechaEstimada" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estudiante.nombre" name="nombreEstudiante" id="nombreEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estudiante.codigo" name="codigoEstudiante" id="codigoEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            @if(Auth::user()->id == 39)
                            <td><input type="text" ng-model="search.encargado" name="encargado" id="encargado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            @endif
                            <td></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr dir-paginate="x in listado_solicitudes_dependencias | filter:search | itemsPerPage:10" pagination-id="paginacion_solicitudes"  ng-if="(x.accion_id!=7 || x.accion_id != 8)" ng-class="{'danger':(x.alertaDuracion<=3  && x.alertaDuracion>=0) || x.alertaDuracion<0 && x.accion_id!=7 && x.accion_id!=2, 'warning':x.alertaDuracion<=6 && x.alertaDuracion>=4 && x.accion_id!=7 && x.accion_id!=2,'success':x.alertaDuracion>6 && x.accion_id!=7 && x.accion_id!=2}">
                            <td>@{{x.consecutivo}}</td>
                            <td>
                              <span ng-if="x.asunto!=null">@{{x.asunto}}</span>
                              <span ng-if="x.asunto_id!=null">@{{x.asunto_nuevo.nombre}}</span>
                            
                            </td>
                            <td>@{{x.accion_nombre}}</td>
                            <td >@{{x.created_at}}</td>
                            <td >@{{x.duracion}}</td>
                            <td >@{{x.fechaEstimada}}</td>
                            <td>@{{x.estudiante.nombre}}</td>
                            <td>@{{x.estudiante.codigo}}</td>
                            @if(Auth::user()->id == 39)
                              <td >@{{x.encargado == null ? '-' : x.encargado}}</td>
                            @endif
                            
                            <td>
                              <div class="dropdown"  style="float:left">
                                <a href="" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span></a>
                                <ul class="dropdown-menu">
                                  <li><a href="" ng-click="detalle_solicitud(x)" data-toggle="modal" data-target="#myModal">Ver detalle</a></li>
                                  <li><a href="/ver_mas/@{{x.id}}">Ver más</a></li>
                                  <li ng-if="(x.accion_id==4 || x.accion_id==8) && x.acciones[0].user_id=={{Auth::user()->id}}"><a href="" ng-click="crear_novedad_modal(x.id)">Novedad </a></li>
                                  <li ng-if="(x.accion_id==4 || x.accion_id==8) && x.acciones[0].user_id=={{Auth::user()->id}}"><a href="" ng-click="crear_solicitudConcepto_modal(x.id)">Solicitud de concepto</a></li>
                                  <li ng-if="{{Auth::user()->id}} == 39 && (x.encargado == null || x.encargado == '')"><a href="" ng-click="guardarEncargado_modal(x)">Guardar encargado</a></li>
                                </ul>
                              </div>
                              <a  ng-if="(x.accion_id==4 || x.accion_id==8 || x.accion_id == 9) && x.acciones[0].user_id=={{Auth::user()->id}}" class="btn btn-default" style="float:left"  href="/responder/@{{x.id}}"><span style="transform: rotateY(180deg);" class="glyphicon glyphicon-share-alt texto_verde"></span></a>
                            </td>
                        </tr>
                      </tbody>  
                        
                        
                        
                    </table>
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_solicitudes"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Detalle Solicitud</h4>
                          </div>
                          <div class="modal-body">
                              <table class="table table-striped">
                                    <tr>
                                        <th>Usuarios</th>
                                        <th>Acciones</th>
                                        <th>Fecha</th>
                                    </tr>
                                    <tr ng-repeat="y in lista_acciones">
                                        <td>@{{y.nombre}}</td>
                                        <td>@{{y.accion}}   
                                        
                                          <a href="" data-dismiss="modal" ng-click="ver_comentario(y)" ng-if="y.comentario!=null && y.id_acciones==6"><span class="glyphicon glyphicon-eye-open"></span></a>
                                          
                                        </td>
                                        <td>@{{y.fecha}}</td>
                                    </tr>
                                </table>
                           
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="comentario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Comentario</h4>
                          </div>
                          <div class="modal-body">
                              @{{comentario}}
                           
                          </div>
                          <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal"  ng-click="cerrar_comentario(comentario)">Cerrar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="respuesta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Respuesta</h4>
                          </div>
                          <div class="modal-body">
                              @{{lista_respuestas.mensaje}}
                              <br><br>
                                <a ng-if="lista_respuestas.multimedias_respuestas.length>0" class="btn btn-primary" role="button" data-toggle="collapse" href="#rutas" aria-expanded="false" aria-controls="rutas">
                                  Ver soportes (@{{lista_respuestas.multimedias_respuestas.length}})
                                </a>
                                <div class="collapse" id="rutas">
                                  <div class="well">
                                      <div ng-repeat="s in lista_respuestas.multimedias_respuestas">
                                          <a href="" data-dismiss="modal" ng-click="ver_pdf(s.ruta)">Archivo adjunto @{{$index+1}}</a>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal"  ng-click="cerrar_respuesta()">Cerrar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" ng-click="cerrar_pdf()" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Soporte</h4> 
                          </div>
                          <div class="modal-body">
                            <div style="text-align: center;">
                    <iframe src="@{{ruta}}" 
                    style="width:500px; height:500px;" frameborder="0"></iframe>
                    </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cerrar_pdf()">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal form solicitudConcepto-->
                    <div class="modal fade" id="encargadoModal" tabindex="-1" role="dialog" aria-labelledby="encargado">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                      </button>
                      <h3 class="modal-title" id="myModalLabel">Encargado de solicitud</h3>
                    </div>
                    <div class="modal-body">
                      <form role="form" name="formEncargado"  novalidate>
                        
                          <br>
                          <div class="row">
                              <div class="col-md-12 col-xs-12 col-sm-12">
                                      <label><span class="asterisco">*</span>Encargado</label>
                                      <input type="text" name="encargado" class="form-control" ng-model="encargado.encargado" ng-required="true" />
                                      
                                      <span class="messages" ng-show="(formEncargado.$submitted || formEncargado.encargado.$touched)">
                                          <span ng-show="formEncargado.encargado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                
                              </div>
                          </div>
                        
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <a type="button" ng-click="guardarEncargado()" class="btn btn-primary">Guardar</a>
                    </div>
                  </div>
                </div>
            </div> 
                </div>
                <div role="tabpanel" class="tab-pane " id="respondidas" style="padding:30px">
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(respondidas_dependencias | filter:searchRespondidas).length > 0 ">
                        <p>Hay @{{(respondidas_dependencias | filter:searchRespondidas).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="respondidas_dependencias.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(respondidas_dependencias | filter:searchRespondidas).length == 0 && respondidas_dependencias.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (searchRespondidas.estudiante.radicadoSolicitud.length > 0  || searchRespondidas.respuestas.radicado.length > 0 || searchRespondidas.asunto_nuevo.nombre.length > 0 || searchRespondidas.accion_nombre.length > 0 || searchRespondidas.created_at.length > 0 || searchRespondidas.duracion.length > 0 || searchRespondidas.fechaEstimada.length > 0 || searchRespondidas.estudiante.nombre.length > 0 || searchRespondidas.estudiante.codigo.length > 0 || searchRespondidas.encargado.length > 0 )">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="searchRespondidas = ''">aquí</a></span>
                    </div>
                    
                    <table class="table table-hover">
                      <thead>
                        <tr>
                            <th>Radicado solicitud</th>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th>Fecha de creación</th>
                            <th>Duración</th>
                            <th>Fecha estimada</th>
                            <th>Estudiante</th>
                            <th>Código</th>
                            <th>Radicado respuesta</th>
                            @if(Auth::user()->id == 39)
                              <th>Encargado</th>
                            @endif
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                            <td><input type="text" ng-model="searchRespondidas.estudiante.radicadoSolicitud" name="radicadoSolicitud" id="radicadoSolicitud" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.asunto_nuevo.nombre" name="asunto" id="asunto" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                    
                            <td><input type="text" ng-model="searchRespondidas.accion_nombre" name="accion_nombre" id="accion_nombre" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.created_at" name="created_at" id="created_at" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.duracion" name="duracion" id="duracion" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.fechaEstimada" name="fechaEstimada" id="fechaEstimada" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.estudiante.nombre" name="nombreEstudiante" id="nombreEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.estudiante.codigo" name="codigoEstudiante" id="codigoEstudiante" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.respuestas.radicado" name="radicadoRespuesta" id="radicadoRespuesta" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            @if(Auth::user()->id == 39)
                            <td><input type="text" ng-model="searchRespondidas.encargado" name="encargado" id="encargado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            @endif
                            <td></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr dir-paginate="x in respondidas_dependencias | filter:searchRespondidas | itemsPerPage:10" pagination-id="paginacion_respondidas" >
                            <td>@{{x.estudiante.radicadoSolicitud}}</td>
                            <td> 
                              <span ng-if="x.asunto!=null">@{{x.asunto}}</span>
                              <span ng-if="x.asunto_id!=null">@{{x.asunto_nuevo.nombre}}</span>
                            </td>
                            <td>@{{x.accion_nombre}}</td>
                            <td >@{{x.created_at}}</td>
                            <td >@{{x.duracion}}</td>
                            <td>@{{x.fechaEstimada}}</td>
                            <td>@{{x.estudiante.nombre}}</td>
                            <td>@{{x.estudiante.codigo}}</td>
                            <td>@{{x.respuestas.radicado}}</td>
                            @if(Auth::user()->id == 39)
                            <td>@{{x.encargado}}</td>
                            @endif
                            <td>
                              <div class="dropdown"  style="float:left">
                                <a href="" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span></a>
                                <ul class="dropdown-menu">
                                  <li><a href="" ng-click="detalle_solicitud(x)" data-toggle="modal" data-target="#respondida_detalle">Ver detalle</a></li>
                                  <li><a href="/ver_mas/@{{x.id}}">Ver más</a></li>
                                </ul>
                              </div>
                              
                            </td>
                            
                        </tr>
                      </tbody> 
                        
                        
                    </table>
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_respondidas" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="respondida_detalle" tabindex="-1" role="dialog" aria-labelledby="respondida_detalle">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="respondida_detalle">Detalle Solicitud</h4>
                          </div>
                          <div class="modal-body">
                              <table class="table table-striped">
                                    <tr>
                                        <th>Usuarios</th>
                                        <th>Acciones</th>
                                        <th>Fecha</th>
                                    </tr>
                                    <tr ng-repeat="y in lista_acciones" >
                                        <td>@{{y.nombre}}</td>
                                        <td>@{{y.accion}}   
                                            <a href="" data-dismiss="modal" ng-click="ver_comentario2(y)" ng-if="y.comentario!=null"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            
                                        </td>
                                        <td>@{{y.fecha}}</td>
                                    </tr>
                                </table>
                           
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="comentario2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Comentario</h4>
                          </div>
                          <div class="modal-body">
                              @{{comentario}}
                           
                          </div>
                          <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal"  ng-click="cerrar_comentario2(comentario)">Cerrar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="respuesta2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Respuesta</h4>
                          </div>
                          <div class="modal-body">
                              @{{lista_respuestas.mensaje}}
                              <br><br>
                                <a ng-if="lista_respuestas.multimedias_respuestas!=null" class="btn btn-primary" role="button" data-toggle="collapse" href="#collapse_respondida" aria-expanded="false" aria-controls="collapse_respondida">
                                  Ver soportes (@{{lista_respuestas.multimedias_respuestas.length}})
                                </a>
                                <div class="collapse" id="collapse_respondida">
                                  <div class="well">
                                      <div ng-repeat="s in lista_respuestas.multimedias_respuestas">
                                          <a href="" data-dismiss="modal" ng-click="ver_pdf2(s.ruta)">Archivo adjunto @{{$index+1}}</a>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal"  ng-click="cerrar_respuesta2()">Cerrar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="pdf2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" ng-click="cerrar_pdf()" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Soporte</h4> 
                          </div>
                          <div class="modal-body">
                            <div style="text-align: center;">
                    <iframe src="@{{ruta}}" 
                    style="width:500px; height:500px;" frameborder="0"></iframe>
                    </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cerrar_pdf2()">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="listaSolicitudConcepto">
                    <div class="row">
                      <div class="col-md-4 col-md-offset-6">
                        <label>&nbsp</label>
                        <input type="text" class="form-control" placeholder="Buscar" ng-model="buscarSolicitudConcepto">
                      </div>
                      <div class="col-md-2">
                        <label>&nbsp</label>
                        <div class="alert alert-info cant_tabla">
                            <span>@{{(solicitudesConceptos | filter:buscarSolicitudConcepto).length}} resultados</span>
                        </div>
                      </div>
                      
                    </div>
                    
                    <br>
                    
                    <div class="row">
                      <div class="col-xs-12">
                        <table class="table table-hover table-striped">
                        <tr>
                            <th style="width:400px;">Asunto</th>
                            <th>Dependencia solicitante</th>
                            <th>Fecha de creación</th>
                            <th>Acción</th>
                        </tr>
                   
                        <tr dir-paginate="x in solicitudesConceptos | filter:buscarSolicitudConcepto  | itemsPerPage:10" pagination-id="paginacion_solicitudesConceptos" >

                            <td>@{{x.asunto}}</td>
                            <td>@{{x.nombreCreador}}</td>
                            <td >@{{x.fechaCreacion}}</td>
                            
                            <td>
                                <div class="dropdown"  style="float:left">
                                  <a  ng-if="x.dirigidaId=={{Auth::user()->id}} && x.respuesta_concepto.length==0" class="btn btn-default" style="float:left"  href="/vista_solicitud_concepto/@{{x.id}}"><span style="transform: rotateY(180deg);" class="glyphicon glyphicon-share-alt texto_verde"></span></a>
                                  <a ng-if="x.dirigidaId!={{Auth::user()->id}} || (x.respuesta_concepto.length>0 && x.dirigidaId=={{Auth::user()->id}})" href="/vista_solicitud_concepto/@{{x.id}}">Ver más</a>
                                  
                                </div>
                              
                            </td>
                            
                        </tr>
                        
                    </table>
                    
                     <div class="row" ng-if="solicitudesConceptos.length==0 || solicitudesConceptos==null || (solicitudesConceptos | filter:buscarSolicitudConcepto).length==0 ">
                       <div class="col-xs-12">
                         <div class="alert alert-warning" style="text-align:center"><label>No se encontró solicitudes de conceptos</label></div>
                       </div>
                       
                     </div> 
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                        <dir-pagination-controls pagination-id="paginacion_solicitudesConceptos" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                      </div>
                    </div>
                    
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="crear">
                    <div  style="padding:30px">
                            <table class="table table-hover">
                                <tr>
                                    <th>Solicitud</th>
                                    <th>Estado</th>
                                    <th>Tipo de Solicitud</th>
                                    <th>Fecha de creación</th>
                                    <th>Duraciòn</th>
                                    <th>Usuario</th>
                                    <th>Acciòn</th>
                                </tr>
                                <tr ng-repeat="z in total_solicitudes" >
                                    <td>@{{z.asunto}}</td>
                                    <td>@{{z.acciones[0].accion}}</td>
                                    <td>@{{z.tipo_solicitud}}</td>
                                    <td >@{{z.created_at}}</td>
                                    <td >@{{z.duracion}}</td>
                                    <td>@{{z.acciones[0].nombre}}</td>
                                    <td><a href="" ng-click="detalle_solicitud2(z)" data-toggle="modal" data-target="#myModal2"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                </tr>
                            </table>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Detalle Solicitud</h4>
                                  </div>
                                  <div class="modal-body">
                                      <table class="table table-striped">
                                            <tr>
                                                <th>Usuarios</th>
                                                <th>Acciones</th>
                                                <th>Fecha</th>
                                            </tr>
                                            <tr ng-repeat="w in lista_acciones">
                                                <td>@{{w.nombre}}</td>
                                                <td>@{{w.accion}}   
                                                  <a href="" data-dismiss="modal" ng-click="ver_comentario(w)" ng-if="w.comentario!=null"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                  <a href="" data-dismiss="modal" ng-click="ver_respuesta_respondidas()" ng-if="w.id_solicitude_user== lista_respuestas.solicitude_user_id && (w.id_acciones==7 ||w.id_acciones==5)"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                </td>
                                                <td>@{{w.fecha}}</td>
                                            </tr>
                                        </table>
                                   
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="comentario_respondidas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Comentario</h4>
                                  </div>
                                  <div class="modal-body">
                                      @{{comentario}}
                                   
                                  </div>
                                  <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal"  ng-click="cerrar_comentario(comentario)">Cerrar</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="respuesta_respondidas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Respuesta</h4>
                                  </div>
                                  <div class="modal-body">
                                      @{{lista_respuestas.mensaje}}
                                      <br><br>
                                      
                                        
                                          <a ng-if="lista_respuestas.multimedias_respuestas.length>0" class="btn btn-primary" role="button" data-toggle="collapse" href="#rutas_respondidas" aria-expanded="false" aria-controls="rutas_respondidas">
                                            Ver soportes (@{{lista_respuestas.multimedias_respuestas.length}})
                                          </a>
                                        
                                        
                                        <div class="collapse" id="rutas_respondidas">
                                          <div class="well">
                                              <div ng-repeat="s in lista_respuestas.multimedias_respuestas">
                                                  <a href="" data-dismiss="modal" ng-click="ver_pdf_respondidas(s.ruta)">Link</a>
                                              </div>
                                          </div>
                                        </div>
                                  </div>
                                  <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal"  ng-click="cerrar_respuesta_respondidas()">Cerrar</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="pdf_respondidas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" ng-click="cerrar_pdf_respondidas()" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Modal title</h4> 
                                  </div>
                                  <div class="modal-body">
                                    <div style="text-align: center;">
                            <iframe src="@{{ruta}}" 
                            style="width:500px; height:500px;" frameborder="0"></iframe>
                            </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cerrar_pdf_respondidas()">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        
                    </div>
                </div>
                
              </div>
              
             
            </div>
             
            <!-- Modal form novedad-->
            <div class="modal fade" id="novedad" tabindex="-1" role="dialog" aria-labelledby="novedad">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" id="myModalLabel">Crear novedad</h3>
                  </div>
                  <div class="modal-body">
                    <form role="form" name="formNovedad"  novalidate>
                      <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                    <label><span class="asterisco">*</span>Novedad</label>
                                    <textarea  style="height:110px; text-align:left;" ng-model="novedad.novedad" class="form-control" name="Novedad" ng-required="true" >
                
                                    </textarea>
                            </div>
                            <div class="col-sm-12">
                              <span class="messages" ng-show="formNovedad.$submitted || formNovedad.Novedad.$touched">
                                        <span ng-show="formNovedad.Novedad.$error.required" class="color_errores">* El campo es obligatorio.</span>
                              </span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                              <div class="col-md-8 col-xs-12 col-sm-8">
                                      <label><span class="asterisco"></span>Dependencia</label>
                                      
                                      <select class="form-control" name="dependencia" id="dependencia" ng-options="dependencia.id as dependencia.nombre for dependencia in dependencias" ng-model="novedad.dependencia_destino" readonly>
                                          <option value="">Seleccione un tipo</option>
                                      </select>
                                
                              </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-xs-12">
                            <div class="alert alert-warning">
                                    <strong>* Adjuntar archivos formatos PDF.</strong>
                                    <br>
                                    <strong>* Adjuntar máximo un archivo.</strong>
                                    <br>
                                    <strong>* Tamaño de archivos 5 MB.</strong>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <lf-ng-md-file-input  lf-files="galeria_novedad" id="galeria_novedad" name="galeria_novedad" lf-totalsize="5MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag></lf-ng-md-file-input>
                                <div ng-messages="formNovedad.galeria_novedad.$error">
                                    <br>
                                    <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                                    <div ng-message="mimetype" ><span class="color_errores">solo archivos pdf.</span></div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <label><span class="asterisco">*</span>Permitir que el estudiante vea novedad</label>
                                <input type="radio" ng-model="novedad.permiso" name="permiso" value="1" ng-required="true">Si
                                <input type="radio" ng-model="novedad.permiso" name="permiso" value="0"ng-required="true">No
                            </div>
                            <div class="col-sm-12">
                              <span class="messages" ng-show="formNovedad.$submitted || formNovedad.permiso.$touched">
                                        <span ng-show="formNovedad.permiso.$error.required" class="color_errores">* El campo es obligatorio.</span>
                              </span>  
                            </div>
                            
                            
                      </div>
                      
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <a type="button" ng-click="crear_novedad(novedad)" class="btn btn-primary">Guardar</a>
                  </div>
                </div>
              </div>
          </div> 
          
            <!-- Modal form solicitudConcepto-->
              <div class="modal fade" id="solicitudConcepto" tabindex="-1" role="dialog" aria-labelledby="solicitudConcepto">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                      </button>
                      <h3 class="modal-title" id="myModalLabel">Crear solicitud de concepto</h3>
                    </div>
                    <div class="modal-body">
                      <form role="form" name="formSolicitudConcepto"  novalidate>
                        
                          <br>
                          <div class="row">
                                <div class="col-md-8 col-xs-12 col-sm-8">
                                        <label><span class="asterisco">*</span>Dependencia</label>
                                        
                                        <select class="form-control" name="Dependencia_destino" id="Dependencia_destino" ng-options="dependencia.id as dependencia.nombre for dependencia in dependencias" ng-model="solicitudConcepto.Dependencia_destino" ng-required="true">
                                            <option value="">Seleccione una dependencia</option>
                                        </select>
                                        <span class="messages" ng-show="(formSolicitudConcepto.$submitted || formSolicitudConcepto.Dependencia_destino.$touched)">
                                          <span ng-show="formSolicitudConcepto.Dependencia_destino.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                </div>
                          </div>
                          <br/>
                          <div class="row">
                              <div class="col-md-12 col-xs-12 col-sm-12">
                                      <label><span class="asterisco">*</span>Asunto</label>
                                      <input type="text" name="Asunto" class="form-control" ng-model="solicitudConcepto.Asunto" ng-required="true" />
                                      
                                      <span class="messages" ng-show="(formSolicitudConcepto.$submitted || formSolicitudConcepto.Asunto.$touched)">
                                          <span ng-show="formSolicitudConcepto.Asunto.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                
                              </div>
                          </div>
                          <br/>
                          <div class="row">
                              <div class="col-md-12 col-xs-12 col-sm-12">
                                      <label><span class="asterisco">*</span>Solicitud</label>
                                      <textarea  style="height:110px; text-align:left;" ng-model="solicitudConcepto.Descripcion" class="form-control" name="Descripcion" id="Descripcion" ng-required="true"></textarea>
                                      
                                      <span class="messages" ng-show="(formSolicitudConcepto.$submitted || formSolicitudConcepto.Descripcion.$touched)">
                                          <span ng-show="formSolicitudConcepto.Descripcion.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                
                              </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-xs-12">
                              <div class="alert alert-warning">
                                      <strong>* Adjuntar archivos formatos PDF.</strong>
                                      <br>
                                      <strong>* Adjuntar máximo un archivo.</strong>
                                      <br>
                                      <strong>* Tamaño total de archivos (5 MB).</strong>
                              </div>
                            </div>
                          </div>
                          
                          <div class="row">
                              <div class="col-md-12 col-xs-12 col-sm-12">
                                  <lf-ng-md-file-input  lf-files="galeria_solicitudConcepto" id="galeria_solicitudConcepto" name="galeria_solicitudConcepto" lf-totalsize="5MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag></lf-ng-md-file-input>
                                  <div ng-messages="formSolicitudConcepto.galeria_solicitudConcepto.$error">
                                      <br>
                                      <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                                      <div ng-message="mimetype" ><span class="color_errores">solo archivos pdf.</span></div>
                                  </div> 
                              </div>
                          </div>
                        
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <a type="button" ng-click="crear_solicitudConcepto()" class="btn btn-primary">Guardar</a>
                    </div>
                  </div>
                </div>
            </div> 
            <!-- Modal para ver archivo pdf-->
            <div class="modal fade" id="pdf_nove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Soporte</h4> 
                  </div>
                  <div class="modal-body">
                    <div style="text-align: center;">
                    <iframe src="@{{ruta}}" 
                    style="width:500px; height:500px;" frameborder="0"></iframe>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Modal form solicitudConcepto-->
              <div class="modal fade" id="encargadoModal" tabindex="-1" role="dialog" aria-labelledby="encargado">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                      </button>
                      <h3 class="modal-title" id="myModalLabel">Encargado de solicitud</h3>
                    </div>
                    <div class="modal-body">
                      <form role="form" name="formEncargado"  novalidate>
                        
                          <br>
                          <div class="row">
                              <div class="col-md-12 col-xs-12 col-sm-12">
                                      <label><span class="asterisco">*</span>Encargado</label>
                                      <input type="text" name="encargado" class="form-control" ng-model="encargado.encargado" ng-required="true" />
                                      
                                      <span class="messages" ng-show="(formEncargado.$submitted || formEncargado.encargado.$touched)">
                                          <span ng-show="formEncargado.encargado.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                
                              </div>
                          </div>
                        
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <a type="button" ng-click="guardarEncargado()" class="btn btn-primary">Guardar</a>
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
    <script src="{{asset('/js/plugins/lf-ng-md-file-input.min.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
  	<script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
  	<script src="{{asset('/js/dependencias/dependencias.js')}}"></script>
    <script src="{{asset('/js/dependencias/dependenciasServices.js')}}"></script>
@endsection
