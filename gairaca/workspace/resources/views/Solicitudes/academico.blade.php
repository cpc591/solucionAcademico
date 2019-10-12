@extends('Layout.master')



@section('contenido')
    <div class="container" ng-controller="academicoCtrl" ng-app="myApp">
            
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                <br><br>
                
                <!-- Nav tabs -->
              <ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12" role="tablist">
                
                <a class="navbar-brand ">Solicitudes</a>
                <li role="presentation" class="active"><a href="#lista" aria-controls="lista" role="tab" data-toggle="tab">Listado de soliicitudes</a></li>
                <li role="respondidas" role="respondidas"><a href="#respondidas" aria-controls="respondidas" role="tab" data-toggle="tab">Respondidas</a></li>
                <li role="novedades" ><a href="#novedades" aria-controls="novedades" role="tab" data-toggle="tab">Novedades</a></li>
                <li class="navbar-right" role="presentation"><a href="/cerrar_sesion">Cerrar sesión</a></li>
                <li class="navbar-right" role="presentation"><a href="/academico">{{Auth::user()->nombre}}</a></li>
              </ul>
            
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="lista" style="padding:30px">
                  
                    <br><br>
                    
                    <div class="row">
                      <div class="col-md-3">
                        <h5>Filtrar por estado</h5>
                        <select class="form-control" name="accion" id="accion" ng-options="accion.id as accion.nombre for accion in acciones" ng-model="accion" ng-required="true">
                          <option value="">Seleccione una acción</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <h5>Filtrar por tipo</h5>
                        <select class="form-control" name="tipo" id="tipo" ng-options="tipo.id as tipo.nombre for tipo in tipos" ng-model="tipo" ng-required="true">
                          <option value="">Seleccione una tipo</option>
                        </select>
                      </div>
                      <br>
                      <div class="col-md-4">
                        <input type="text" style="margin-top:15px;" class="form-control" placeholder="Buscar" ng-model="buscar">
                      </div>
                      <div class="alert alert-info col-md-2 pull-right cant_tabla">
                          <span>@{{(solicitudes | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar).length}} resultados</span>
                      </div>
                    </div>
                    <br>
                    
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th>Tipo de Solicitud</th>
                            <th>Fecha de creación</th>
                            <th>Duración</th>
                            <th>Fecha Estimada</th>
                            <th>Usuario</th>
                            <th style="width:100px;">Acción</th>
                        </tr>
                        
                        <tr dir-paginate="x in solicitudes | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar | itemsPerPage:10" pagination-id="paginacion_solicitudes"  ng-if="x.accion_id!=7" ng-class="{'danger':x.alertaDuracion<=3 && x.alertaDuracion>=0 && x.accion_id!=7 && x.accion_id!=2, 'warning':x.alertaDuracion<=6 && x.alertaDuracion>=4 && x.accion_id!=7 && x.accion_id!=2,'success':x.alertaDuracion>6 && x.accion_id!=7 && x.accion_id!=2}">
                            <td> 
                              <span ng-if="x.asunto!=null">@{{x.asunto}}</span>
                              <span ng-if="x.asunto_id!=null">@{{x.asunto_nuevo.nombre}}</span>
                            </td>
                            <td>@{{x.acciones[0].accion}}</td>
                            <td>@{{x.tipo_solicitud}}</td>
                            <td >@{{x.created_at}}</td>
                            <td >@{{x.duracion}}</td>
                            <td >@{{x.fechaEstimada}}</td>
                            <td>@{{x.acciones[0].nombre}}</td>
                            <td>
                              <div class="dropdown"  style="float:left">
                                <a href="" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span></a>
                                <ul class="dropdown-menu">
                                  <li><a href="" ng-click="detalle_solicitud(x)" data-toggle="modal" data-target="#myModal">Ver detalle</a></li>
                                  <li><a href="/ver_mas/@{{x.id}}">Ver más</a></li>
                                  <li ng-if="(x.accion_id==4 || x.accion_id==8) && x.acciones[0].user_id=={{Auth::user()->id}}"><a href="" ng-click="crear_novedad_modal(x.id)">Novedad </a></li>
                                </ul>
                              </div>
                              <a  ng-if="(x.accion_id==4 || x.accion_id==8) && x.acciones[0].user_id=={{Auth::user()->id}}" class="btn btn-default" style="float:left"  href="/responder/@{{x.id}}"><span style="transform: rotateY(180deg);" class="glyphicon glyphicon-share-alt texto_verde"></span></a>
                            </td>
                            
                        </tr>
                        
                    </table>
                    
                     <div class="row" ng-if="(solicitudes | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar).length==0 || solicitudes==null">
                       <div class="alert alert-warning" style="text-align:center"><h5>No se encontró solicitudes</h5></div>
                     </div> 
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
                                    <tr ng-repeat="y in lista_acciones" >
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
                                <a ng-if="lista_respuestas.multimedias_respuestas!=null" class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                  Ver soportes (@{{lista_respuestas.multimedias_respuestas.length}})
                                </a>
                                <div class="collapse" id="collapseExample">
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
                  
                    <br><br>
                    
                    <div class="row">
                      <div class="col-md-3">
                        <h5>Filtrar por estado</h5>
                        <select class="form-control" name="accion" id="accion" ng-options="accion.id as accion.nombre for accion in acciones" ng-model="accion" ng-required="true">
                          <option value="">Seleccione una acción</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <h5>Filtrar por tipo</h5>
                        <select class="form-control" name="tipo" id="tipo" ng-options="tipo.id as tipo.nombre for tipo in tipos" ng-model="tipo" ng-required="true">
                          <option value="">Seleccione una tipo</option>
                        </select>
                      </div>
                      <br>
                      <div class="col-md-4">
                        <input type="text" style="margin-top:15px;" class="form-control" placeholder="Buscar" ng-model="buscar">
                      </div>
                      <div class="alert alert-info col-md-2 pull-right cant_tabla">
                          <span>@{{(respondidas_academico | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar).length}} resultados</span>
                      </div>
                    </div>
                    <br>
                    
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th>Tipo de Solicitud</th>
                            <th>Fecha de creación</th>
                            <th>Duración</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                        </tr>
                        
                        <tr dir-paginate="x in respondidas_academico | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar | itemsPerPage:10" pagination-id="paginacion_respondidas" ng-class="{'danger':(x.duracion2-x.duracion)<=3 && (x.duracion2-x.duracion)>=0 && x.accion_id!=7, 'warning':(x.duracion2-x.duracion)<=6 && (x.duracion2-x.duracion)>=4 && x.accion_id!=7,'success':(x.duracion2-x.duracion)>6 && x.accion_id!=7 }">
                            <td> 
                              <span ng-if="x.asunto!=null">@{{x.asunto}}</span>
                              <span ng-if="x.asunto_id!=null">@{{x.asunto_nuevo.nombre}}</span>
                            </td>
                            <td>@{{x.acciones[0].accion}}</td>
                            <td>@{{x.tipo_solicitud}}</td>
                            <td >@{{x.created_at}}</td>
                            <td >@{{x.duracion}}</td>
                            <td>@{{x.acciones[0].nombre}}</td>
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
                    
                     <div class="row" ng-if="(respondidas_academico | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar).length==0 || solicitudes==null">
                       <div class="alert alert-warning" style="text-align:center"><h5>No se encontró solicitudes</h5></div>
                     </div> 
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_respondidas"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
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
                <div role="tabpanel" class="tab-pane " id="novedades" style="padding:30px">
                  
                    <br><br>
                    
                    
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Dependencia solicitante</th>
                            <th>Fecha de creación</th>
                            <th>Acción</th>
                        </tr>
                   
                        <tr dir-paginate="x in lista_novedades  | itemsPerPage:10" pagination-id="paginacion_novedades" >
                            
                            <td>@{{x.texto}}</td>
                            <td>@{{x.user_create}}</td>
                            <td >@{{x.created_at}}</td>
                            <td>
                              <div ng-repeat="y in x.multimedias_novedades">
                                <a href="" ng-click="soporte_novedad(y.ruta)" ng-if="x.multimedias_novedades.length>0" title="Soportes de novedad">Soporte @{{$index+1}}</a><br>
                              </div>
                            </td>
                            
                        </tr>
                        
                    </table>
                    
                     <div class="row" ng-if="lista_novedades.length==0 || lista_novedades==null">
                       <div class="alert alert-warning" style="text-align:center"><h5>No se encontró solicitudes</h5></div>
                     </div> 
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_novedades"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
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
                                    
                                    <span class="messages" ng-show="formNovedad.$submitted || formNovedad.Novedad.$touched">
                                        <span ng-show="formNovedad.Novedad.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                    </span>
                              
                            </div>
                        </div>
                        <br>
                        <div class="alert alert-warning col-md-12">
                                    <strong>* Adjuntar archivos formatos PDF.</strong>
                                    <br>
                                    <strong>* Adjuntar máximo tres archivos.</strong>
                                    <br>
                                    <strong>* Tamaño de archivos 10 MB.</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <lf-ng-md-file-input  lf-files="galeria" id="galeria" name="galeria" lf-totalsize="10MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
                                <div ng-messages="formNovedad.galeria.$error">
                                    <br>
                                    <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                                    <div ng-message="mimetype" ><span class="color_errores">solo archivos pdf.</span></div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <label><span>Permitir que el estudiante vea novedad</span></label>
                                <input type="radio" ng-model="novedad.permiso" name="permiso" value="1" ng-required="true">Si
                                <input type="radio" ng-model="novedad.permiso" name="permiso" value="0"ng-required="true">No
                            </div>
                            <span class="messages" ng-show="formNovedad.$submitted || formNovedad.permiso.$touched">
                                        <span ng-show="formNovedad.permiso.$error.required" class="color_errores">* El campo es obligatorio.</span>
                            </span>
                            
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
              </div>
              
             
            </div>
                
            
    </div>
@endsection

