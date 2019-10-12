@extends('Layout.master')



@section('contenido')
    <div class="container" ng-controller="aprobar_vista_academicoCtrl" ng-app="myApp">
            <input type="hidden" ng-model="solicitud_id"  ng-init="solicitud_id={{$solicitud->id}}" name=""/>
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                <br><br>
                <!-- Nav tabs -->
              <ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12" role="tablist">
                
                <a href="/directorAcademico" class="navbar-brand ">Listado de solicitudes</a>
                <li class="navbar-right" role="presentation"><a href="/cerrar_sesion">Cerrar sesión</a></li>
                <li class="navbar-right" role="presentation"><a href="/directorAcademico">{{Auth::user()->nombre}}</a></li>
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
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                            <label><span class="asterisco">*</span>Tipo de solicitud</label>
                                            <input type="text" name="Estudiante" class="form-control" ng-model="solicitud.tipos.nombre" ng-required="true" readonly />
                                      
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
                                            <input type="text" name="Asunto" class="form-control" ng-model="solicitud.asunto" ng-required="true" readonly/>
                                            <span class="messages" ng-show="formCrear.$submitted || formCrear.Asunto.$touched">
                                                <span ng-show="formCrear.Asunto.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                            </span>
                                        
                                        
                                    </div>
                                    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12  col-xs-12 col-sm-12">
                                        <label><span class="asterisco">*</span>Descripción</label>
                                        <textarea style="height:110px;" class="form-control" name="descripCrearIdo" ng-model="solicitud.contenido" ng-required="true" readonly></textarea>
                                        <span class="messages" ng-show="formCrear.$submitted || formCrear.descripCrearIdo.$touched">
                                            <span ng-show="formCrear.descripCrearIdo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                        </span>
                                        
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
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                        </form>
                                    <br>
                                    
                                    <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-danger" ng-if="errores != null">
                        <h5><strong>Errores</strong></h5>
                        <span class="messages" ng-repeat="error in errores">
                              <span><strong>*@{{error[0]}}</strong></span>
                              <br>
                        </span>
                    </div>
                </div>
                
                <form role="form" name="formRespuesta"  novalidate>
                        
                        <div class="col-xs-12">
                                <ng-ckeditor  ng-init="respuesta.contenido=x.solicitude_user.respuestas[0].mensaje"
                                              ng-model="respuesta.contenido"
                                              ng-disabled="editorDIsabled" 
                                              skin="moono" 
                                              remove-buttons="Image" 
                                              remove-plugins="iframe,flash,smiley"
                                              required
                                              >
                                </ng-ckeditor>
                        </div>
                        
                        
                    <div class="col-xs-12">
                        <br>
                        <!--<div class="list-group"  ng-if="respuesta.multimediaRespuesta">
                          <div  class="list-group-item active">Soportes respuesta</div>
                          <div ng-repeat="s in respuesta.multimediaRespuesta" class="list-group-item">
                                  <a href="" ng-click="ver_pdf(s.ruta)">Archivo adjunto @{{$index+1}}</a> <a href="" ng-click="eliminar_soporteRespuesta(s)"><span class="glyphicon glyphicon-remove"></span></a> 
                              </div>
                        </div>-->
                        <div class="alert alert-warning">
                            <strong>* Adjuntar archivos formatos PDF.</strong>
                            <br>
                            <strong>* Adjuntar máximo tres archivos.</strong>
                            <br>
                            <strong>* Tamaño de archivos 10 MB.</strong>
                        </div>
                        <lf-ng-md-file-input lf-files="galeria" id="galeria" name="galeria" lf-totalsize="20MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
                        <div ng-messages="formRespuesta.galeria.$error">
                            <br>
                            <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                            <div ng-message="mimetype" ><span class="color_errores">solo archivos pdf.</span></div>
                        </div>  

                    </div>
                    
                    <br><br>
                    
                </form>
            </div>
            <div class="row" style="text-align:center;">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a  href="" ng-click="aprobar_solicitud()" class="btn btn-success">Aprobar</a>    
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a  href="" ng-click="noAprobar_modal({{$solicitud->id}})" class="btn btn-primary">No aprobar</a>    
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <a  href="" ng-click="corregir()" class="btn btn-success">Corregir</a>
               </div>
            </div>                        
                                    <br>
                                    <h3 style="text-align:center;">Historial</h3>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" >
                            <div class="panel-group" id="accordion"  role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default" ng-repeat="x in datos_solicitud" ng-if="x.acciones.id!=2 && x.acciones.id!=3">
                                    <div class="panel-heading" role="tab" id="heading@{{$index}}">
                                      <h4 class="panel-title" >
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse@{{$index}}" aria-expanded="false" aria-controls="collapse@{{$index}}" >
                                        
                                            <div class="row">
                                                <div class="col-md-4 col-xs-4 xol-sm-4">
                                                    @{{x.acciones.nombre}}
                                                </div>
                                                <div class="col-md-4 col-xs-4 xol-sm-4">
                                                    @{{x.solicitude_user.user.nombre}}
                                                </div>
                                                <div class="col-md-4 col-xs-4 xol-sm-4">
                                                    @{{x.fecha}}
                                                    <span class="glyphicon glyphicon-ok texto_verde" title="Solicitud aprobada por el estudiante" ng-if="$index>2 && x.acciones.id==1"></span>
                                                </div>
                                                <!--<div class="col-md-1 col-xs-1 xol-sm-1">
                                                    <i ng-if="x.acciones.id==7 x.acciones.id==8 || x.acciones.id==5 || x.acciones.id==6 || (x.acciones.id==1 && m_solicitud.length>0)" class="more-less glyphicon glyphicon-plus"></i>
                                                    <i ng-if="x.acciones.id==7 || x.acciones.id==5 || x.acciones.id==6 || (x.acciones.id==1 && m_solicitud.length>0)" class="more-less glyphicon glyphicon-minus"></i>
                                                </div>-->
                                            </div>
                                          
                                          
                                        </a>
                                      </h4>
                                    </div>
                                    <div id="collapse@{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading@{{$index}}">
                                      <div class="panel-body" ng-if="x.acciones.id==7 || x.acciones.id==8 || x.acciones.id==5" >
                                          <div class="row">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                  <h3>Respuesta <a href="/pdfRespuesta/@{{solicitud_id}}" target="_blank"><span class="glyphicon glyphicon-print" title="Respuesta en PDF"></span></a></h3>    
                                              </div>
                                                  
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div ng-html="x.solicitude_user.respuestas[0].mensaje"></div>
                                              </div>
                                                  
                                          </div>
                                          <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12" ng-repeat="m in x.multimedia">
                                                        <a href="@{{m.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
                                            </div>
                                          </div>
                                                            
                                      </div>
                                      <div class="panel-body" ng-if="x.acciones.id==1 && m_solicitud.length>0" >
                                          <div class="row">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                  <h3>Soportes</h3>    
                                              </div>
                                                  
                                          </div>
                                          <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12" ng-repeat="m_s in m_solicitud">
                                                        <a href="@{{m_s.ruta}}" target="_blank" >Archivo adjunto @{{$index+1}}</a>
                                            </div>
                                          </div>
                                                            
                                      </div>
                                      <div class="panel-body" ng-if="x.acciones.id==6" >
                                          <div class="row">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                  <h3>Comentarios</h3>    
                                              </div>
                                                  
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                      @{{x.comentario}}
                                              </div>
                                                  
                                          </div>
                                                            
                                      </div>
                                      <div class="panel-body" ng-if="!(x.acciones.id==7 || x.acciones.id==8 || x.acciones.id==5 || x.acciones.id==6 || (x.acciones.id==1 && m_solicitud.length>0))" >
                                          <div class="row">
                                              <div class="col-xs-12">
                                                  <span>No hay soportes</span>    
                                              </div>
                                                  
                                          </div>
                                                            
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                    </div>
                                    
                        
                           <!-- Modal form solicitudConcepto-->
              <div class="modal fade" id="noAprobacion" tabindex="-1" role="dialog" aria-labelledby="noAprobacion">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                      </button>
                      <h3 class="modal-title" id="myModalLabel">Encargado de solicitud</h3>
                    </div>
                    <div class="modal-body">
                      <form role="form" name="formNoAprobar"  novalidate>
                        
                          <br>
                          <div class="row">
                              <div class="col-md-12 col-xs-12 col-sm-12">
                                      <label><span class="asterisco">*</span>Observación</label>
                                      <input type="text" name="comentario" class="form-control" ng-model="noAprobacion.comentario" ng-required="true" />
                                      
                                      <span class="messages" ng-show="(formNoAprobar.$submitted || formNoAprobar.encargado.$touched)">
                                          <span ng-show="formNoAprobar.comentario.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                      </span>
                                
                              </div>
                          </div>
                        
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <a type="button" ng-click="noAprobar()" class="btn btn-primary">Guardar</a>
                    </div>
                  </div>
                </div>
            </div>    
                        
                    </div>
                    
              
    </div>
@endsection

