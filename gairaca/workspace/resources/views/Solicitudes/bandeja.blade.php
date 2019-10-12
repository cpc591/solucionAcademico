@extends('Layout.master')



@section('contenido')
    <div class="container" ng-controller="listado_solicitudesCtrl" ng-app="myApp">
            
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                <br><br>
                
                <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                
                <a class="navbar-brand ">Solicitudes</a>
                <li role="presentation" class="active"><a href="#lista" aria-controls="lista" role="tab" data-toggle="tab">Listado de solicitudes</a></li>
                <li role="presentation" ><a href="#respondidas" aria-controls="respondidas" role="tab" data-toggle="tab">Respondidas</a></li>
                <li role="novedades" ><a href="#novedades" aria-controls="novedades" role="tab" data-toggle="tab">Novedades</a></li>
                <li role="presentation"><a href="#crear" aria-controls="crear" role="tab" data-toggle="tab">Crear solicitud</a></li>
                <li role="presentation" ng-if="representante == 1"><a href="#solicitudesRespresentanteEstudiantil" aria-controls="solicitudesRespresentanteEstudiantil" role="tab" data-toggle="tab">Solicitudes representante</a></li>
                <li class="navbar-right" role="presentation"><a href="/cerrar_sesion">Cerrar sesión</a></li>
                <li class="navbar-right" role="presentation"><a href="/bandeja">{{Auth::user()->nombre}}</a></li>
              </ul>
              
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="lista" style="padding:30px">
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
                            <th style="width:100px;" >Acción</th>
                        </tr>
                        
                        <tr dir-paginate="x in solicitudes | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar | itemsPerPage:10" pagination-id="paginacion_solicitudes" ng-if="x.accion_id!=7" ng-class="{'danger':x.alertaDuracion<=3 && x.alertaDuracion>=0 && x.accion_id!=7 && x.accion_id!=2, 'warning':x.alertaDuracion<=6 && x.alertaDuracion>=4 && x.accion_id!=7 && x.accion_id!=2,'success':x.alertaDuracion>6 && x.accion_id!=7 && x.accion_id!=2}">
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
                              <div class="dropdown" style="float:left">
                                 <a href="" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span></a>
                                 
                                <ul class="dropdown-menu" >
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
                                            <a href="" data-dismiss="modal" ng-click="ver_comentario(y)" ng-if="y.comentario!=null"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            
                                        </td>
                                        <td>@{{y.fecha}}</td>
                                    </tr>
                                </table>
                           
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar
                            </button>
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
                                <a ng-if="lista_respuestas.multimedias_respuestas.length>0" class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
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
                          <span>@{{(respondidas_desarrollo | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar).length}} resultados</span>
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
                        
                        <tr dir-paginate="x in respondidas_desarrollo | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar | itemsPerPage:10" pagination-id="paginacion_respondidas" >
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
                    
                     <div class="row" ng-if="(respondidas_desarrollo | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscar).length==0 || solicitudes==null">
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
                <div role="tabpanel" class="tab-pane " id="novedades" style="padding:30px">
                    <div class="row">
                      <div class="col-md-4 col-md-offset-6">
                        <input type="text" style="margin-top:15px;" class="form-control" placeholder="Buscar" ng-model="buscarNovedad">
                      </div>
                      <div class="alert alert-info col-md-2 pull-right cant_tabla">
                          <span>@{{(lista_novedades | filter:buscarNovedad).length}} resultados</span>
                      </div>
                    </div>
                    <br>
                    
                    
                    <table class="table table-hover">
                        <tr>
                            <th>Solicitud</th>
                            <th>Dependencia solicitante</th>
                            <th>Fecha de creación</th>
                            <th>Acción</th>
                        </tr>
                   
                        <tr dir-paginate="x in lista_novedades | filter:buscarNovedad | itemsPerPage:10" pagination-id="paginacion_novedades">
                            
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
                    
                     <div class="row" ng-if="lista_novedades.length==0 || lista_novedades==null || (lista_novedades | filter:buscarNovedad).length==0">
                       <div class="alert alert-warning" style="text-align:center"><h5>No se encontró solicitudes</h5></div>
                     </div> 
                    <div class="row">
                      <div class="col-6" style="text-align:center;">
                      <dir-pagination-controls pagination-id="paginacion_novedades" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                      </div>
                    </div>
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="crear">
                    <div  ng-app="myApp" ng-controller="solicitudesCtrl" style="padding:30px">
                            <div class="alert alert-danger" ng-if="errores != null">
                                <h6>Errores</h6>
                                <span class="messages" ng-repeat="error in errores">
                                      <span>@{{error[0]}}</span><br>
                                </span>
                            </div>
                            <form role="form" name="formCrear"  novalidate>
                                 <br> <br>  
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                            <label><span class="asterisco">*</span>Tipo de solicitud</label>
                                            <select class="form-control" name="Tipo" id="Tipo" ng-options="tipo.id as tipo.nombre for tipo in tipos" ng-model="solicitud.Tipo" ng-required="true">
                                                <option value="">Seleccione un tipo</option>
                                            </select>
                                            
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Tipo.$touched">
                                                <span ng-show="formCrear.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                      
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <label><span class="asterisco">*</span>Dependencia</label>
                                        <input type="text" class="form-control" value="Consejo académico" readonly/>
                                        
                                        <!--<select class="form-control" name="dependencia" id="depenencia" ng-options="dependencia.id as dependencia.nombre for dependencia in dependencias" ng-model="solicitud.Dependencia" ng-required="true">
                                            <option value="">Seleccione una dependencia</option>
                                        </select>
                                        
                                        <span class="messages" ng-show="formCrear.$submitted || formCrear.dependencia.$touched">
                                            <span ng-show="formCrear.dependencia.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>-->
                                
                                    </div>
                                
                                
                                
                                
                                </div>
                                
                                <div class="row">
                                  <br>
                                    <div class="col-md-4 col-xs-12 col-sm-4">
                                            <div class="alinea_load"><label><span class="asterisco">*</span>Codigo</label></div>
                                            
                                            <div class="sk-fading-circle alinea_load" style="margin-left: 10px; margin-bottom:5px;" ng-show="load">
                                              <div class="sk-circle1 sk-circle"></div>
                                              <div class="sk-circle2 sk-circle"></div>
                                              <div class="sk-circle3 sk-circle"></div>
                                              <div class="sk-circle4 sk-circle"></div>
                                              <div class="sk-circle5 sk-circle"></div>
                                              <div class="sk-circle6 sk-circle"></div>
                                              <div class="sk-circle7 sk-circle"></div>
                                              <div class="sk-circle8 sk-circle"></div>
                                              <div class="sk-circle9 sk-circle"></div>
                                              <div class="sk-circle10 sk-circle"></div>
                                              <div class="sk-circle11 sk-circle"></div>
                                              <div class="sk-circle12 sk-circle"></div>
                                            </div>
                                            <input type="number" ng-keypress="busca_estudiante($event)" name="Estudiante" class="form-control" ng-model="solicitud.Estudiante" ng-blur="carga_estudiante()" ng-required="true" />
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Estudiante.$touched">
                                                <span ng-show="formCrear.Estudiante.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                                <span ng-show= "ErrorCodigo" class="color_errores">* Codigo no encontrado.</span>
                                            </span>
                                        
                                    </div>
                                
                                    <div class="col-md-8 col-xs-12 col-sm-8">
                                        <label><span class="asterisco">*</span>Nombres</label>
                                        <input type="text" name="Nombres" class="form-control" ng-model="solicitud.Nombres" ng-required="true" readonly />
                                    </div>
                                </div>
                                
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-xs-12 col-sm-4">
                                        <label><span class="asterisco">*</span>Identificacion</label>
                                        <input type="number" name="Identificacion" class="form-control" ng-model="solicitud.Identificacion" ng-required="true" readonly />
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <label><span class="asterisco">*</span>Correo</label>
                                        <input type="text" name="Correo" class="form-control" ng-model="solicitud.Correo" ng-required="true" readonly />
                                    
                                    </div>
                                    
                                    <div class="col-md-2 col-xs-12 col-sm-2">
                                        <button ng-disabled="!boton" type="button" style="margin-top:25px; width:100%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Ver más</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h3 class="modal-title" id="myModalLabel">Información detallada del estudiante</h3>
                                              </div>
                                              <div class="modal-body">
                                                    <table class="table table-bordered">
                                                          
                                                            <tbody>
                                                              <tr>
                                                                  <th >Nombres:</th>
                                                                  <td colspan="5">@{{datos_estudiante.NOMBRES}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Documento:</th>
                                                                  <td>@{{datos_estudiante.NUMDOC}}</td>
                                                                  <th>Código:</th>
                                                                  <td>@{{datos_estudiante.COD}}</td>
                                                              </tr>
                                                              
                                                              <tr>
                                                                  <th>Celular:</th>
                                                                  <td>@{{datos_estudiante.CELULAR}}</td>
                                                                  <th>Teléfono:</th>
                                                                  <td>@{{datos_estudiante.TELEFONO}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Edad:</th>
                                                                  <td>@{{datos_estudiante.EDAD}}</td>
                                                                  <th>Sexo:</th>
                                                                  <td>@{{datos_estudiante.SEXO}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Email personal:</th>
                                                                  <td colspan="5">@{{datos_estudiante.EMAIL}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Facultad:</th>
                                                                  <td>@{{datos_estudiante.FACULTAD}}</td>
                                                                  <th>Programa:</th>
                                                                  <td>@{{datos_estudiante.PROGRAMA}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Estado:</th>
                                                                  <td>@{{datos_estudiante.ESTADO}}</td>
                                                                  <th>Situación academica:</th>
                                                                  <td>@{{datos_estudiante.SIT}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Créditos aprobados:</th>
                                                                  <td>@{{datos_estudiante.CREDAPRO}}</td>
                                                                  <th>Porcentaje créditos aprobados:</th>
                                                                  <td>@{{datos_estudiante.PORCAPRO}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Ciudad de origen:</th>
                                                                  <td colspan="5">@{{datos_estudiante.CIUDADORIGEN}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Estrato:</th>
                                                                  <td>@{{datos_estudiante.ESTRATO}}</td>
                                                                  <th>Dirección:</th>
                                                                  <td>@{{datos_estudiante.DIRECCION}}</td>
                                                              </tr>
                                                            </tbody>
                                                    </table>
                                                  
                                                  
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <br>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Asunto</label>
                                        <select ng-change="buscar_descripcion()" class="form-control" name="asunto" id="asunto" ng-options="asunto.id as asunto.nombre for asunto in asuntos" ng-model="solicitud.asunto" ng-required="true">
                                            <option value="">Seleccione un asunto</option>
                                        </select>
                                        <br>
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
                                        <label>Descripción de asunto</label>
                                      
                                        <input type="text" name="descripcion_asunto" class="form-control" ng-model="descripcion_asunto" ng-required="true" readonly/>
                                        
                                        
                                    </div>
                                    
                                </div>
                                <!--<div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Asunto</label>
                                        <input ng-if="solicitud.Dependencia!=39" type="text" name="Asunto" class="form-control" ng-model="solicitud.Asunto" ng-required="true" />
                                        <select ng-if="solicitud.Dependencia==39" ng-change="buscar_descripcion()" class="form-control" name="asunto" id="asunto" ng-options="asunto.id as asunto.nombre for asunto in asuntos" ng-model="solicitud.asunto" ng-required="true">
                                            <option value="">Seleccione un asunto</option>
                                        </select>
                                        <br>
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
                                        <label ng-if="solicitud.Dependencia==39">Descripción de asunto</label>
                                      
                                        <input ng-if="solicitud.Dependencia==39" type="text" name="descripcion_asunto" class="form-control" ng-model="descripcion_asunto" ng-required="true" readonly/>
                                        
                                        
                                    </div>
                                    
                                </div>-->
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
                                
                                
                                
                                <div class="alert alert-warning col-md-12">
                                    <strong>* Adjuntar archivos formatos PDF.</strong>
                                    <br>
                                    <strong>* Adjuntar máximo tres archivos.</strong>
                                    <br>
                                    <strong>* Tamaño de archivos 10 MB.</strong>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                         <lf-ng-md-file-input lf-files="galeria" id="galeria" name="galeria" lf-totalsize="10MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
                                                       <div ng-messages="formCrear.galeria.$error" >
                                                            <br>
                                                            <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                                                            <div ng-message="mimetype" ><span class="color_errores">solo archivos pdf.</span></div>
                                                        </div>  
                                                                            
                                    </div>
                                </div>
                               <br>
                               
                               
                               <br>
                               
                               <div class="row col-md-12 col-sm-12 col-xs-12" style="text-align:center">
                                   <input  class="btn btn-success" ng-disabled="load2" value="Enviar"  ng-click="crear_solicitud()">
                               </div>
                               
                               <br><br>
                               
                        </form>
                        
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" ng-if="representante == 1" id="solicitudesRespresentanteEstudiantil" style="padding:30px">
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
                          <option value="">Seleccione un tipo</option>
                        </select>
                      </div>
                      <br>
                      <div class="col-md-4">
                        <input type="text" style="margin-top:15px;" class="form-control" placeholder="Buscar" ng-model="buscarRepresentante">
                      </div>
                      <div class="alert alert-info col-md-2 pull-right cant_tabla">
                          <span>@{{(solicitudesRespresentanteEstudiantil | filter:{accion_id:accion} | filter:{tipo_id:tipo} | filter:buscarRepresentante).length}} resultados</span>
                      </div>
                    </div>
                    <br>
                            
                    <table class="table table-hover table-striped">
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
                       <div class="alert alert-warning" style="text-align:center"><h5>No se encontró solicitudes</h5></div>
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
                                    <strong>* Adjuntar máximo un archivo.</strong>
                                    <br>
                                    <strong>* Tamaño de archivos 5 MB.</strong>
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
@endsection

