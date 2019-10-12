@extends('Layout.master')



@section('contenido')
    <div class="container" ng-controller="aprobar_vistaCtrl" ng-app="myApp">
            <input type="hidden" ng-model="solicitud_id"  ng-init="solicitud_id={{$solicitud}}" name=""/>
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                
                <br><br>
                <!-- Nav tabs -->
              <ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12" role="tablist">
                
                <a href="/bandeja2" class="navbar-brand ">Listado de solicitudes</a>
                <li class="navbar-right" role="presentation"><a href="/cerrar_sesion">Cerrar sesión</a></li>
                <li class="navbar-right" role="presentation"><a href="/bandeja2">{{Auth::user()->nombre}}</a></li>
              </ul>
                
            </div>
            
                <br><br>
                    <div style="padding:30px" class="col-md-12 col-sm-12 col-xs-12 row-center" >
                            <div class="alert alert-danger" ng-if="errores != null">
                                <h6>Errores</h6>
                                <span class="messages" ng-repeat="error in errores">
                                      <span>@{{error}}</span>
                                </span>
                            </div>
                            
                            <h3 style="text-align:center;">Datos de la solicitud</h3>
                            <form role="form" name="formCrear"  novalidate>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 colxs-12">
                                        <label>Dependencia a donde se dirige la solicitud</label>
                                        <input type="text" name="Dependencia" class="form-control" ng-model="dependencia.nombre_dependencia" ng-required="true" readonly />
                                    </div>
                                    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                            <label><span class="asterisco">*</span>Tipo de solicitud</label>
                                            <input type="text" name="Asunto" class="form-control" ng-model="solicitud.tipos.nombre" ng-required="true" readonly />
                                            
                                            
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Tipo.$touched">
                                                <span ng-show="formCrear.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                              
                                    </div>
                                    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-xs-12 col-sm-12">
                                        <div class="alinea_load"><label><span class="asterisco">*</span>Codigo</label></div>
                                            <input type="number" name="Estudiante" class="form-control" ng-model="estudiante.codigo" ng-required="true" readonly />

                                        
                                    </div>
                                
                                    <div class="col-md-8 col-xs-12 col-sm-12">
                                        <div class="alinea_load"><label><span class="asterisco">*</span>Nombres</label></div>
                                            <input type="text" name="Estudiante" class="form-control" ng-model="estudiante.nombre" ng-required="true" readonly/>

                                    </div>
                                </div>
                                
                                <br>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="alinea_load"><label><span class="asterisco">*</span>Correo</label></div>
                                            <input type="email" name="Estudiante" class="form-control" ng-model="estudiante.email" ng-required="true" readonly />
                 
                                    
                                    </div>
                                    
                                </div>
                                
                                <br>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        
                                            <label><span class="asterisco">*</span>Asunto</label>
                                            <input type="text" name="Asunto" class="form-control" ng-model="solicitud.Asunto" ng-required="true" readonly />
                                            <div ng-if="dependencia.dependencia_id ==39">
                                                <br>
                                                <label>Descripción del asunto</label>
                                                <input ng-if="descripcion_asunto" type="text" name="descripcion_asunto" class="form-control" ng-model="descripcion_asunto" ng-required="true" readonly />
                                            </div>
                                            
                                            
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Asunto.$touched">
                                                <span ng-show="formCrear.Asunto.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                            
                                        
                                    </div>
                                    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Descripción</label>
                                        <textarea style="height:110px;" class="form-control" name="descripCrearIdo" ng-model="solicitud.contenido" ng-required="true"></textarea>
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
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <a ng-if="solicitud.multimedias_solicitudes.length>0" class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                  Ver soportes (@{{solicitud.multimedias_solicitudes.length}})
                                </a>
                            </div>
                            
                            
                            
                            <div class="collapse col-md-12 col-xs-12 col-sm-12" id="collapseExample">
                              <div class="well">
                            
                                  <div ng-repeat="s in solicitud.multimedias_solicitudes">
                                      
                                      <a href="" ng-click="ver_pdf(s.ruta)">Archivo adjunto @{{$index+1}}</a>
                                      
                                  </div>
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
                        <div class="row">
                            <div class="col-md-12  col-xs-12 col-sm-12">
                                 <lf-ng-md-file-input lf-files="galeria" id="galeria" name="galeria" lf-totalsize="10MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
                                               <div ng-messages="formCrear.galeria.$error">
                                                    <br>
                                                    <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                                                    <div ng-message="mimetype" ><span class="color_errores">solo archivos pdf.</span></div>
                                                </div>  
                                                                    
                            </div>
                        </div>
                        <div style="text-align:center;">
                            <a  href="" ng-click="aprobar_solicitud()" class="btn btn-primary">Aprobar</a>    
                        </div>
                        </form>
                    </div>
                    
            
    </div>
@endsection

