@extends('Layout.master')
@section('Title','Listado de solicitudes')
@section('app','ng-app="appEstudiante"')
@section('controller','ng-controller="listado_solicitudes_estudiantesCtrl"')


@section('contenido')
    <div class="container">
            
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                <br>
                <!-- Nav tabs -->
                <div class="row">
                  <div class="col-xs-12">
                    <ul class="nav nav-tabs" role="tablist">
                
                      <a class="navbar-brand ">Solicitudes</a>
                      <li role="presentation" class="active"><a href="#lista" aria-controls="lista" role="tab" data-toggle="tab">Listado de solicitudes</a></li>
                       <li role="respondidas"><a href="#respondidas" aria-controls="respondidas" role="tab" data-toggle="tab">Respondidas</a></li>
                       <li role="rechazadas"><a href="#rechazadas" aria-controls="rechazadas" role="tab" data-toggle="tab">Rechazadas</a></li>
                      <li role="presentation"><a href="#crear" aria-controls="crear" role="tab" data-toggle="tab">Crear solicitud</a></li>
                      @role('representanteEstudiantil')
                        <li role="presentation" ng-if="representante == 1"><a href="#solicitudesRespresentanteEstudiantil" aria-controls="solicitudesRespresentanteEstudiantil" role="tab" data-toggle="tab">Solicitudes representante</a></li>
                      @endrole
                      <!--<li class="navbar-right" role="presentation"><a href="/cerrar_sesion">Cerrar sesión</a></li>
                      <li class="navbar-right" role="presentation"><a href="/bandeja2">{{Auth::user()->nombre}}</a></li>-->
                    </ul>
                  </div>
                </div>
              
            
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="lista" style="padding:30px">
                  
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(listado_solicitudes_estudiantes | filter:searchCreadas).length > 0 ">
                        <p>Hay @{{(listado_solicitudes_estudiantes | filter:searchCreadas).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="listado_solicitudes_estudiantes.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(listado_solicitudes_estudiantes | filter:searchCreadas).length == 0 && listado_solicitudes_estudiantes.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.nombreAsunto.nombre.length > 0 || search.estado.length > 0 || search.created_at.length > 0 || search.usuarioEstado.length > 0)">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                            
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th>Fecha de creación</th>
                            <th>Usuario</th>
                            <th style="width:100px;">Acción</th>
                            
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                            <td><input type="text" ng-model="searchCreadas.nombreAsunto" name="nombreAsunto" id="nombreAsunto" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                                    
                            <td><input type="text" ng-model="searchCreadas.estado" name="estado" id="estado" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchCreadas.created_at" name="created_at" id="created_at" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchCreadas.usuarioEstado" name="usuarioEstado" id="usuarioEstado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                        
                        <tr dir-paginate="x in listado_solicitudes_estudiantes | filter:searchCreadas | itemsPerPage:10" pagination-id="paginacion_solicitudes" ng-if="x.accion_id!=7">
                            <td> 
                              @{{x.nombreAsunto}}
                            </td>
                            <td>@{{x.estado}}</td>
                            <td >@{{x.created_at}}</td>
                            <td>@{{x.usuarioEstado}}</td>
                            
                            <td>
                              <div class="dropdown"  style="float:left">
                                <a href="" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span></a>
                                <ul class="dropdown-menu">
                                  <li><a href="" ng-click="detalle_solicitud(x)" data-toggle="modal" data-target="#myModal" title="Ver detalle de solicitud">Ver detalle</a></li>
                                  <li><a href="/ver_mas/@{{x.id}}" >Ver más</a></li>
                                  
                                </ul>
                              </div>
                              <a ng-if="x.accion_id==2" href="/aprobar_vista/@{{x.id}}" class="btn btn-default" title="Aprobar solicitud" style="float:left"><span class="glyphicon glyphicon-ok texto_verde"></span></a>
                            </td>
                        </tr>
                        
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
                                          <a href="" data-dismiss="modal" ng-click="ver_comentario(y)" ng-if="y.comentario!=null"><span class="glyphicon glyphicon-eye-open"></span></a>
                                          
                                          
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
                </div>
                <div role="tabpanel" class="tab-pane " id="respondidas" style="padding:30px">
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltroRespondidas=!mostrarFiltroRespondidas" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(respondidas_estudiantes | filter:searchRespondidas).length > 0 ">
                        <p>Hay @{{(respondidas_estudiantes | filter:searchRespondidas).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="respondidas_estudiantes.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(respondidas_estudiantes | filter:searchRespondidas).length == 0 && respondidas_estudiantes.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltroRespondidas == false && (searchRespondidas.nombreAsunto.nombre.length > 0 || searchRespondidas.estado.length > 0 || searchRespondidas.created_at.length > 0 || searchRespondidas.usuarioEstado.length > 0)">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                    
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th>Fecha de creación</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                        </tr>
                        <tr ng-show="mostrarFiltroRespondidas == true">
                            <td><input type="text" ng-model="searchRespondidas.nombreAsunto" name="nombreAsuntoRespondidas" id="nombreAsuntoRespondidas" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                                    
                            <td><input type="text" ng-model="searchRespondidas.estado" name="estadoRespondidas" id="estadoRespondidas" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.created_at" name="created_atRespondidas" id="created_atRespondidas" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRespondidas.usuarioEstado" name="usuarioEstadoRespondidas" id="usuarioEstadoRespondidas" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                        
                        <tr dir-paginate="x in respondidas_estudiantes | filter:searchRespondidas | itemsPerPage:10" pagination-id="paginacion_respondidas" >
                            <td> 
                              @{{x.nombreAsunto}}
                            </td>
                            <td>@{{x.estado}}</td>
                            <td >@{{x.created_at}}</td>
                            <td>@{{x.usuarioEstado}}</td>
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
                        
                    </table>
                    
                     <div class="row" ng-if="(respondidas_estudiantes | filter:{accion_id:accion} | filter:{asunto_id:asuntoFiltro} | filter:buscar2).length==0 || respondidas_estudiantes==null">
                       <div class="col-xs-12">
                         <div class="alert alert-warning" style="text-align:center"><label>No se encontró solicitudes</label></div>
                       </div>
                       
                     </div> 
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
                                            <a href="" data-dismiss="modal" ng-click="ver_comentario2(y)" ng-if="y.comentario!=null && y.id_acciones==6"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            
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
                <div role="tabpanel" class="tab-pane " id="rechazadas" style="padding:30px">
                    <div class="flex-list" style="text-align:center;">
                        <div class="form-group has-feedback" style="display: inline-block;">
                            <button type="button" ng-click="mostrarFiltroRechazadas=!mostrarFiltroRechazadas" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                        </div>      
                    </div>
                    <br>
                    <div class="text-center" ng-if="(rechazadas | filter:searchRechazadas).length > 0 ">
                        <p>Hay @{{(rechazadas | filter:searchRechazadas).length}} registro(s) que coinciden con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" ng-if="rechazadas.length == 0">
                        <p>No hay registros almacenados</p>
                    </div>
                    <div class="alert alert-warning" ng-if="(rechazadas | filter:searchRechazadas).length == 0 && rechazadas.length > 0">
                        <p>No existen registros que coincidan con su búsqueda</p>
                    </div>
                    <div class="alert alert-info" role="alert"  ng-show="mostrarFiltroRechazadas == false && (searchRechazadas.nombreAsunto.nombre.length > 0 || searchRechazadas.estado.length > 0 || searchRechazadas.created_at.length > 0 || searchRechazadas.usuarioEstado.length > 0)">
                        Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                    </div>
                    
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th>Fecha de creación</th>
                            <th>Usuario</th>
                            <th style="width:100px;">Acción</th>
                            
                        </tr>
                        <tr ng-show="mostrarFiltroRechazadas == true">
                            <td><input type="text" ng-model="searchRechazadas.nombreAsunto" name="nombreAsuntoRechazadas" id="nombreAsuntoRechazadas" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            
                                    
                            <td><input type="text" ng-model="searchRechazadas.estado" name="estadoRechazadas" id="estadoRechazadas" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRechazadas.created_at" name="created_atRechazadas" id="created_atRechazadas" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="searchRechazadas.usuarioEstado" name="usuarioEstadoRechazadas" id="usuarioEstadoRechazadas" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                        
                        <tr dir-paginate="x in rechazadas | filter:searchRechazadas | itemsPerPage:10" pagination-id="paginacion_rechazadas" >
                            <td> 
                              @{{x.nombreAsunto}}
                            </td>
                            <td>@{{x.estado}}</td>
                            <td >@{{x.created_at}}</td>
                            <td>@{{x.usuarioEstado}}</td>
                            <td>
                              <div class="dropdown"  style="float:left">
                                <a href="" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span></a>
                                <ul class="dropdown-menu">
                                  <li><a href="" ng-click="detalle_solicitud(x)" data-toggle="modal" data-target="#rechazadas_detalle">Ver detalle</a></li>
                                  <li><a href="/ver_mas/@{{x.id}}">Ver más</a></li>
                                </ul>
                              </div>
                              
                            </td>
                            
                        </tr>
                        
                    </table>
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_rechazadas" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="rechazadas_detalle" tabindex="-1" role="dialog" aria-labelledby="rechazadas_detalle">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="rechazadas_detalle">Detalle Solicitud</h4>
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
                                            <a href="" data-dismiss="modal" ng-click="ver_comentario2(y)" ng-if="y.comentario!=null && y.id_acciones==6"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            
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
                <div role="tabpanel" class="tab-pane" id="crear">
                    <div>
                          <div class="row" ng-if="errores != null">
                            <div class="col-xs-12">
                              <div class="alert alert-danger">
                                  <h6>Errores</h6>
                                  <span class="messages" ng-repeat="error in errores">
                                        <span>*@{{error[0]}}</span><br/>
                                  </span>
                              </div>
                            </div>
                          </div>
                            
                            
                            <form role="form" name="formCrear"  novalidate>
                                 <br>  
                                <div class="row">
                                    
                                    <!--<div class="col-md-6 col-xs-12 col-sm-6">
                                        <label><span class="asterisco">*</span>Dependencia</label>
                                        <input type="text" class="form-control" value="Consejo académico" readonly/>
                                
                                    </div>-->
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <label><span class="asterisco">*</span>Dependencia</label>
                                        <select class="form-control" name="dependencia" id="depenencia" ng-options="dependencia.id as dependencia.nombre for dependencia in dependencias" ng-model="solicitud.Dependencia" ng-required="true">
                                            <option value="">Seleccione una dependencia</option>
                                        </select>
                                        
                                        <span class="messages" ng-show="formCrear.$submitted || formCrear.dependencia.$touched">
                                            <span ng-show="formCrear.dependencia.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                
                                    </div>
                                    
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                      <!--
                                            <label><span class="asterisco">*</span>Tipo de solicitud</label>
                                            
                                            <select class="form-control" name="Tipo" id="Tipo" ng-options="tipo.id as tipo.nombre for tipo in tipos" ng-model="solicitud.Tipo" ng-required="true">
                                                <option value="">Seleccione un tipo</option>
                                            </select>
                                            
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Tipo.$touched">
                                                <span ng-show="formCrear.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                      -->
                                      <label>Correo adicional</label>
                                        <input type="email" class="form-control" name="emailAdicional" ng-model="solicitud.emailAdicional">
                                        <span class="messages" ng-show="(formCrear.$submitted || formCrear.emailAdicional.$touched) && formCrear.emailAdicional.$error.email">
                                            <span class="color_errores">Debe ser un formato correcto de email</span>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <!--
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Asunto</label>
                                        <select ng-change="buscar_descripcion()" class="form-control" name="asunto" id="asunto" ng-options="asunto.id as asunto.nombre for asunto in asuntos" ng-model="solicitud.asunto" ng-required="true">
                                            <option value="">Seleccione un asunto</option>
                                        </select>
                                        
                                        <div class="row">
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.asunto.$touched">
                                              <span ng-show="formCrear.asunto.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Asunto.$touched">
                                              <span ng-show="formCrear.Asunto.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                          </div>
                                          
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <br ng-if="descripcion_asunto != null">
                                <div class="row" ng-if="descripcion_asunto != null">
                                    
                                      <div class="col-md-12 col-xs-12 col-sm-12">
                                        <label>Descripción de asunto</label>
                                        <div ng-html="descripcion_asunto"></div>
                                      </div>
                                          
                                  </div>
                                <br>-->
                                <!--
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Asunto</label>
                                        <select class="form-control" ng-change="buscar_descripcion()" name="Asunto" id="Asunto" ng-options="asunto.id as asunto.nombre for asunto in asuntos" ng-model="solicitud.Asunto" ng-required="true">
                                            <option value="">Seleccione un asunto</option>
                                        </select>
                                        <span class="messages" ng-show="formCrear.$submitted || formCrear.Asunto.$touched">
                                            <span ng-show="formCrear.Asunto.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                        <br>
                                        <label>Descripción de asunto</label>
                                        <input type="text" name="descripcion_asunto" class="form-control" ng-model="descripcion_asunto" ng-required="true" readonly/>
                                        
                                    </div>
                                    
                                </div>-->
                                
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Asunto</label>
                                        <input ng-if="solicitud.Dependencia!=39" type="text" name="Asunto" class="form-control" ng-model="solicitud.Asunto" ng-required="true" />
                                        <select ng-if="solicitud.Dependencia==39" ng-change="buscar_descripcion()" class="form-control" name="asunto" id="asunto" ng-options="asunto.id as asunto.nombre for asunto in asuntos" ng-model="solicitud.asunto" ng-required="true">
                                            <option value="">Seleccione un asunto</option>
                                        </select>
                                        <div class="row">
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.asunto.$touched">
                                              <span ng-show="formCrear.asunto.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Asunto.$touched">
                                              <span ng-show="formCrear.Asunto.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                          </div>
                                          
                                        </div>
                                    </div>
                                    
                                </div>
                                <br ng-show="descripcion_asunto != null">
                                <div class="row" ng-show="descripcion_asunto != null">
                                    
                                      <div class="col-md-12 col-xs-12 col-sm-12">
                                        <label>Descripción de asunto</label>
                                        <div ng-html="descripcion_asunto"></div>
                                      </div>
                                          
                                  </div>
                                <br>
                                
                                
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Descripción</label>
                                        <textarea style="height:110px;" class="form-control" name="descripCrearIdo" ng-model="solicitud.Descripcion" ng-required="true"></textarea>
                                        <span class="messages" ng-show="formCrear.$submitted || formCrear.descripCrearIdo.$touched">
                                            <span ng-show="formCrear.descripCrearIdo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                    </div>
                                </div>
                                
                                
                                <br>
                                <div class="row">
                                  <div class="col-xs-12">
                                  <div class="alert alert-warning">
                                        <strong>* Adjuntar archivos formatos PDF.</strong>
                                        <br>
                                        <strong>* Adjuntar máximo tres archivos.</strong>
                                        <br>
                                        <strong>* Tamaño total de archivos 10 MB.</strong>
                                    </div>
                                  </div>
                                </div>
                                
                                
                                
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                         <lf-ng-md-file-input lf-files="galeria" id="galeria" name="galeria" lf-totalsize="10MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
                                                       <div ng-messages="formCrear.galeria.$error">
                                                           <br>
                                                            <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                                                            <div ng-message="mimetype" ><span class="color_errores">solo archivos pdf.</span></div>
                                                        </div>                                 
                                    </div>
                                </div>
                               <br>
                               
                               <div class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
                                     <input type="submit" class="btn btn-success" ng-disabled="load2" value="Enviar"  ng-click="crear_solicitud_estudiante()">
                                 </div>
                               </div>
                               
                        </form>
                        
                    </div>
                </div>
                @role('representanteEstudiantil')
                  <div role="tabpanel" class="tab-pane" ng-if="representante == 1" id="solicitudesRespresentanteEstudiantil" style="padding:30px">
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
                      <div class="col-md-4 col-xs-12">
                        <label>&nbsp</label>
                        <input type="text" class="form-control" placeholder="Buscar" ng-model="buscarRepresentante">
                      </div>
                      <div class="col-md-2 col-xs-12">
                        <label>&nbsp</label>
                        <div class="alert alert-info cant_tabla">
                          <span>@{{(solicitudesRespresentanteEstudiantil | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscarRepresentante).length}} resultados</span>
                        </div>
                      </div>
                      
                    </div>
                    <br>
                            
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th>Tipo de Solicitud</th>
                            <th>Fecha de creación</th>
                            <th>Usuario</th>
                            <th style="width:100px;">Acción</th>
                            
                        </tr>
                        
                        <tr dir-paginate="x in solicitudesRespresentanteEstudiantil | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscarRepresentante | itemsPerPage:10" pagination-id="paginacion_solicitudes_representanteEstudiantil" ng-if="x.accion_id!=7">
                            <td> 
                              <span ng-if="x.asunto!=null">@{{x.asunto}}</span>
                              <span ng-if="x.asunto_id!=null">@{{x.asunto_nuevo.nombre}}</span>
                            </td>
                            <td>@{{x.acciones[0].accion}}</td>
                            <td>@{{x.tipo_solicitud}}</td>
                            <td >@{{x.created_at}}</td>
                            <td>@{{x.acciones[0].nombre}}</td>
                            
                            <td>
                              <div class="dropdown"  style="float:left">
                                <a href="" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span></a>
                                <ul class="dropdown-menu">
                                  <li><a href="" ng-click="detalle_solicitud(x)" data-toggle="modal" data-target="#myModalRepresentante" title="Ver detalle de solicitud">Ver detalle</a></li>
                                  <li><a href="/ver_mas/@{{x.id}}" >Ver más</a></li>
                                  
                                </ul>
                              </div>
                              <a ng-if="x.accion_id==2" href="/aprobar_vista/@{{x.id}}" class="btn btn-default" title="Aprobar solicitud" style="float:left"><span class="glyphicon glyphicon-ok texto_verde"></span></a>
                            </td>
                        </tr>
                        
                    </table>
                    
                     <div class="row" ng-if="(solicitudesRespresentanteEstudiantil | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscarRepresentante).length==0 || solicitudesRespresentanteEstudiantil==null">
                       <div class="col-xs-12">
                         <div class="alert alert-warning" style="text-align:center"><label>No se encontró solicitudes</label></div>
                       </div>
                       
                     </div> 
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_solicitudes_representanteEstudiantil"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModalRepresentante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                          <a href="" data-dismiss="modal" ng-click="ver_comentario(y)" ng-if="y.comentario!=null"><span class="glyphicon glyphicon-eye-open"></span></a>
                                          
                                          
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
                </div>
                @endrole
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
    
   
  	<script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
  	<script src="{{asset('/js/plugins/dir-pagination.js')}}"></script>
  	<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
  	<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
  	<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
  	<script src="{{asset('/js/plugins/lf-ng-md-file-input.min.js')}}"></script>
  	<script src="{{asset('/js/estudiantes/estudiantes.js')}}"></script>
    <script src="{{asset('/js/estudiantes/estudiantesServices.js')}}"></script>
@endsection