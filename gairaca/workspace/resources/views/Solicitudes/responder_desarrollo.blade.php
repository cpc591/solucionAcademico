@extends('Layout.master')



@section('contenido')
    <div class="container" ng-controller="responder_desarrolloCtrl" ng-app="myApp">
            
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                <br><br>
                <!-- Nav tabs -->
              <ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12" role="tablist">
                
                <a href="/bandeja" class="navbar-brand ">Listado de solicitudes</a>
                <li class="navbar-right" role="presentation"><a href="/cerrar_sesion">Cerrar sesion</a></li>
                <li class="navbar-right" role="presentation"><a href="/bandeja">{{Auth::user()->nombre}}</a></li>
              </ul>
                
            </div>
            
                                        <!-- Modal -->
                                        <div class="modal fade" id="reenviar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h3 class="modal-title" id="myModalLabel">Reenviar solicitud a otra dependencia</h3>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="row">
                                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                                                <label><span class="asterisco">*</span>Dependencia</label>
                                                                <select class="form-control" name="Tipo" id="Tipo" ng-options="dependencia.id as dependencia.nombre for dependencia in dependencias" ng-model="respuesta.dependencia_reenviar" ng-required="true" readonly>
                                                                    <option value="">Seleccione un tipo</option>
                                                                </select>
                                                                
                                                                <span class="messages" ng-show="formCrear.$submitted">
                                                                    <span ng-show="formCrear.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                                                </span>
                                                          
                                                        </div>
                                                  </div>
                                                  <div class="row">
                                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                                                <label><span class="asterisco">*</span>Comentario</label>
                                                                <textarea  style="height:110px; text-align:left;" ng-model="respuesta.Comentario" class="form-control" name="comentario" ng-required="true" >
                                            
                                                                </textarea>
                                                                
                                                                <span class="messages" ng-show="formCrear.$submitted">
                                                                    <span ng-show="formCrear.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                                                </span>
                                                          
                                                        </div>
                                                  </div>
                                                  
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                <a type="button" ng-click="reenviar(respuesta.dependencia_reenviar)" class="btn btn-primary">Reenviar</a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                <br><br>
                    <div style="padding:30px" class="col-md-6 col-sm-6 col-xs-12" >
                            
                            <h3 style="text-align:center;">Datos de la solicitud</h3>
                            <form role="form" name="formCrear"  novalidate>

                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Tipo de solicitud</label>
                                            <input type="text" ng-init="solicitud.Tipo={{$solicitud["tipos"]->nombre}}" ng-model="solicitud.Tipo" class="form-control" ng-required="true" readonly/>
                                            
                                            
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Tipo.$touched">
                                                <span ng-show="formCrear.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                            
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 col-xs-12 col-sm-12">
                                            <div class="alinea_load"><label><span class="asterisco">*</span>Codigo</label></div>
                                        
                                            <input type="number" ng-init="solicitud.Estudiante={{$user->codigo}}" ng-model="solicitud.Estudiante" class="form-control" ng-required="true" readonly/>
                                            <span class="messages" ng-init="solicitud.Estudiante={{$user->codigo}}" diante.$touched>
                                                <span ng-show="formCrear.Estudiante.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                                <span ng-show= "ErrorCodigo" class="color_errores">* Codigo no encontrado.</span>
                                            </span>
                                    </div>
                                
                                    <div class="col-md-8 col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Nombres</label>
                                        <input type="text" value="{{$user->nombre}}"  class="form-control" ng-required="true" readonly />
                                    </div>
                                </div>
                                
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Identificacion</label>
                                        <input type="number" name="Identificacion" class="form-control" value="{{$datos["estudiante"]->NUMDOC}}" ng-required="true" readonly />
                                    </div>
                                    <div class="col-md-8 col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Correo</label>
                                        <input type="text" name="Correo" class="form-control" value="{{$user->email}}" ng-required="true" readonly />
                                    
                                    </div>
                                    
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <button ng-disabled="boton" type="button" style="margin-top:25px; width:100%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Ver más</button>
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
                                                                  <td colspan="5">{{$datos["estudiante"]->NOMBRES}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Documento:</th>
                                                                  <td>{{$datos["estudiante"]->NUMDOC}}</td>
                                                                  <th>Código:</th>
                                                                  <td>{{$datos["estudiante"]->COD}}</td>
                                                              </tr>
                                                              
                                                              <tr>
                                                                  <th>Celular:</th>
                                                                  <td>{{$datos["estudiante"]->CELULAR}}</td>
                                                                  <th>Teléfono:</th>
                                                                  <td>{{$datos["estudiante"]->TELEFONO}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Edad:</th>
                                                                  <td>{{$datos["estudiante"]->EDAD}}</td>
                                                                  <th>Sexo:</th>
                                                                  <td>{{$datos["estudiante"]->SEXO}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Email personal:</th>
                                                                  <td colspan="5">{{$datos["estudiante"]->EMAIL}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Facultad:</th>
                                                                  <td>{{$datos["estudiante"]->FACULTAD}}</td>
                                                                  <th>Programa:</th>
                                                                  <td>{{$datos["estudiante"]->PROGRAMA}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Estado:</th>
                                                                  <td>{{$datos["estudiante"]->ESTADO}}</td>
                                                                  <th>Situación academica:</th>
                                                                  <td>{{$datos["estudiante"]->SIT}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Créditos aprobados:</th>
                                                                  <td>{{$datos["estudiante"]->CREDAPRO}}</td>
                                                                  <th>Porcentaje créditos aprobados:</th>
                                                                  <td>{{$datos["estudiante"]->PORCAPRO}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Ciudad de origen:</th>
                                                                  <td colspan="5">{{$datos["estudiante"]->CIUDADORIGEN}}</td>
                                                              </tr>
                                                              <tr>
                                                                  <th>Estrato:</th>
                                                                  <td>{{$datos["estudiante"]->ESTRATO}}</td>
                                                                  <th>Dirección:</th>
                                                                  <td>{{$datos["estudiante"]->DIRECCION}}</td>
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
                                <div class="row" >
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Asunto</label>
                                        @if($solicitud->asunto_id!=null)
                                            <input type="text" ng-init="solicitud.Asunto='{{$solicitud["asunto_nuevo"]->nombre}}'" ng-model="solicitud.Asunto" class="form-control" ng-required="true"  readonly/>
                                        @endif
                                        @if($solicitud->asunto_id==null)
                                            <input type="text" ng-init="solicitud.Asunto='{{$solicitud->asunto}}'" ng-model="solicitud.Asunto" class="form-control" ng-required="true" readonly />
                                        @endif
                                    </div>
                                    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Descripción</label>
                                        <textarea  style="height:110px; text-align:left;" ng-init="solicitud.Descripcion='{{$solicitud->contenido}}'" ng-model="solicitud.Descripcion" class="form-control" name="descripCrearIdo" ng-required="true" readonly>
                                            
                                        </textarea>
                                        
                                    </div>
                                </div>
                                
                                
                                <hr>
                                <a ng-if="{{count($multimedias)>0}}" class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                  Ver soportes ({{sizeof($multimedias)}})
                                </a>
                                <div class="collapse" id="collapseExample">
                                  <div class="well">
                                      <div ng-repeat="s in {{$multimedias}}">
                                          <a href="" ng-click="ver_pdf(s.ruta)">Archivo adjunto @{{$index+1}}</a>
                                      </div>
                                  </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                
                                
                        </form>
                        
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12" style="padding:30px" >
                        
                        <form role="form" name="formRespuesta"  novalidate>
                            <input type="hidden" class="form-control" name="solicitud" ng-init="respuesta.solicitud={{$solicitud->id}}" ng-model="respuesta.solicitud" value="{{$solicitud->id}}" ng-update-hidden>
                            <input type="hidden" class="form-control" name="user" ng-init="respuesta.user={{$user->user_id}}" value="{{$user->user_id}}" ng-update-hidden>
                            <h3 style="text-align:center;">Datos de respuesta</h3>
                            <div class="row" ng-if="errores != null">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-danger errores">
                                        <h6 class="errores">Errores</h6>
                                        <span class="messages" ng-repeat="error in errores">
                                              <span>@{{error}}</span>
                                        </span>
                                    </div>
                                        
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12  col-xs-12 col-sm-12">
                                    <label><span class="asterisco">*</span>Respuesta</label>
                                    <textarea style="height:110px;" class="form-control" name="respuesta" ng-model="respuesta.contenido" ng-required="true"></textarea>
                                    <span class="messages" ng-show="formRespuesta.$submitted || formRespuesta.respuesta.$touched">
                                        <span ng-show="formRespuesta.respuesta.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12  col-xs-12 col-sm-12">
                                                      <lf-ng-md-file-input lf-files="galeria" id="galeria" name="galeria" lf-totalsize="20MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
                                                       <div ng-messages="formCrear.galeria.$error">
                                                            <br>
                                                            <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                                                            <div ng-message="mimetype" ><span class="color_errores">solo archivos pdf.</span></div>
                                                        </div>  
                                </div>
                            </div>
                            <br>
                            <div class="row" style="text-align:center;">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input  class="btn btn-success" value="Responder" ng-click="crear_respuesta(respuesta)">
                                </div>
                                
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input  class="btn btn-primary" value="Reenviar" href="" data-toggle="modal" data-target="#reenviar">
                                </div> 
                            </div>
                            
                        </form>
                    </div>
            
    </div>
@endsection

