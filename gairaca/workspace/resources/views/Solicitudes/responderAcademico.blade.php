@extends('Layout.master')



@section('contenido')
    <div class="container" style="padding-left:70px;padding-right:70px;" ng-controller="responderCtrl" ng-app="myApp">
            
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <input type="hidden" ng-model="idUsuario_sesion" ng-init="idUsuario_sesion='{{Auth::user()->id}}'" />
            <input type="hidden" ng-model="idSolicitud" ng-init="idSolicitud='{{$solicitud->id}}'" /> 
            <div>
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs" role="tablist">
                
                            <a href="/bandeja3" class="navbar-brand ">Listado de solicitudes</a>
                          </ul>
                    </div>
                </div>
                <!-- Nav tabs -->
              
                
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                      <li><a href="javascript:history.back();">Inicio</a></li>
                      <li class="active">Ver más de la solicitud</li>
                    </ol>
                </div>
            </div>
                    
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                
                                    <label><span class="asterisco">*</span>Tipo de solicitud</label>
                                    <input type="text" class="form-control" value="{{$solicitud["tipos"]->nombre}}" readonly/>
                                    <input type="hidden" ng-model="respuesta.solicitud" ng-init="respuesta.solicitud={{$solicitud->id}}"/>
                            </div>
                            
                    </div>
                    <br>
                    <div class="row">
                            <div class="col-md-12  col-xs-12 col-sm-12">
                                <label><span class="asterisco">*</span>Asunto</label>
                                <input type="text" value="{{$solicitud->asunto}}" name="Asunto" class="form-control" ng-required="true" readonly />
                                
                            </div>
                            
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12  col-xs-12 col-sm-12">
                            <label><span class="asterisco">*</span>Descripción</label>
                            <textarea  style="height:110px;" class="form-control" name="descripCrearIdo" ng-required="true" resize="none" readonly>{{$solicitud->contenido}}</textarea>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    
                    <form role="form" name="formCrear"  novalidate>

                        
                        
                        <div class="row">
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                    <div class="alinea_load"><label><span class="asterisco">*</span>Codigo</label></div>
                                
                                    <input type="number" value="{{$user->codigo}}" class="form-control" ng-required="true" readonly/>
                                
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
                            <div class="col-md-5 col-xs-12 col-sm-12">
                                <label><span class="asterisco">*</span>Correo</label>
                                <input type="text" name="Correo" class="form-control" value="{{$user->email}}" ng-required="true" readonly />
                            
                            </div>
                            
                            <div class="col-md-3 col-xs-12 col-sm-12">
                                <button ng-disabled="boton" type="button" style="margin-top:25px; width:100%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Ver más</button>
                                
                            </div>
                        </div>
                        
                        <br>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="list-group"  ng-if="{{count($multimedias) >0 }}">
                                  <div  class="list-group-item active">Soportes creación</div>
                                  <div ng-repeat="s in {{$multimedias}}" class="list-group-item">
                                          <a href="" ng-click="ver_pdf(s.ruta)">Archivo adjunto @{{$index+1}}</a>
                                      </div>
                                </div>
                            </div>
                        </div>
                        
                        
                </form>
                    
                </div>
            </div>
            
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <hr><br>
                </div>
            </div>
            
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
                    @if($respuesta!=null)
                        
                        <div class="col-xs-12">
                                <ng-ckeditor  ng-init="respuesta.contenido='{{$respuesta->mensaje}}'"
                                              ng-model="respuesta.contenido"
                                              ng-disabled="editorDIsabled" 
                                              skin="moono" 
                                              remove-buttons="Image" 
                                              remove-plugins="iframe,flash,smiley"
                                              required
                                              >
                                </ng-ckeditor>
                        </div>
                    @else
                        <div class="col-xs-12">
                                <ng-ckeditor  
                                              ng-model="respuesta.contenido"
                                              ng-disabled="editorDIsabled" 
                                              skin="moono" 
                                              remove-buttons="Image" 
                                              remove-plugins="iframe,flash,smiley"
                                              required>
                                </ng-ckeditor>
                        </div>
                    @endif
                        
                        
                    <div class="col-xs-12">
                        <br>
                        <div class="list-group"  ng-if="{{count($multimedias_respuesta) >0}}">
                          <div  class="list-group-item active">Soportes respuesta</div>
                          <div ng-repeat="s in {{$multimedias_respuesta}}" class="list-group-item">
                                  <a href="" ng-click="ver_pdf(s.ruta)">Archivo adjunto @{{$index+1}}</a> <a href="" ng-click="eliminar_soporteRespuesta(s.id)"><span class="glyphicon glyphicon-remove"></span></a> 
                              </div>
                        </div>
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
                    
                    <div class="col-md-12">
                        <div class="row" style="text-align:center;padding:50px;">
                           <div class="col-xs-12 colsm-6 col-md-6">
                               <input  class="btn btn-success" value="Responder" ng-click="crear_respuesta(respuesta)">
                           </div>
                           <div class="col-xs-12 colsm-6 col-md-4" ng-if="{{Auth::user()->id}}!=39">
                               <input  class="btn btn-primary" value="Reenviar" href="" data-toggle="modal" data-target="#reenviar">
                           </div>
                           <div class="col-xs-12 colsm-6 col-md-6">
                               <input  class="btn btn-primary" value="Borrador" href="" ng-click="crear_borrador(respuesta)">
                           </div>
                                
                            
                                
                           
                                
                                
                                
                                
                                            
                                     
                                    
                                        
                                   
                            
                        </div>
                    </div>
                    
                    
                    <br><br>
                    
                </form>
            </div>
            
                    

        <!-- Modal ver_mas del estudiante-->
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
        
        <!-- Modal para ver archivo pdf-->
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
         
        <!-- Modal form reenviar-->
        <div class="modal fade" id="reenviar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
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
                                <select class="form-control" name="Tipo" id="Tipo" ng-options="dependencia.id as dependencia.nombre for dependencia in dependencias" ng-model="reenviar.dependencia_reenviar" ng-required="true" readonly>
                                    <option value="">Seleccione un tipo</option>
                                </select>
                                <input type="hidden" ng-model="reenviar.solicitude_id" ng-init="reenviar.solicitude_id={{$solicitud->id}}"/>
                                <span class="messages" ng-show="formCrear.$submitted">
                                    <span ng-show="formCrear.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                          
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                                <label><span class="asterisco">*</span>Comentario</label>
                                <textarea  style="height:110px; text-align:left;" ng-model="reenviar.Comentario" class="form-control" name="comentario" ng-required="true" >
            
                                </textarea>
                                
                                <span class="messages" ng-show="formCrear.$submitted">
                                    <span ng-show="formCrear.Tipo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                          
                        </div>
                  </div>
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a type="button" ng-click="reenviar_sol(reenviar.dependencia_reenviar)" class="btn btn-primary">Reenviar</a>
              </div>
            </div>
          </div>
        </div> 
        
        <!-- Modal form reenviar-->
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
                                <textarea  style="height:110px; text-align:left;" ng-model="novedad" class="form-control" name="Novedad" ng-required="true" >
            
                                </textarea>
                                
                                <span class="messages" ng-show="formNovedad.$submitted">
                                    <span ng-show="formNovedad.Novedad.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <lf-ng-md-file-input  lf-files="galeria_novedad" id="galeria_novedad" name="galeria_novedad" lf-totalsize="20MB" lf-mimetype="pdf"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
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
                            <input type="radio" ng-model="permiso" name="permiso" value="1">Si
                            <input type="radio" ng-model="permiso" name="permiso" value="0">No
                        </div>
                        <span class="messages" ng-show="formNovedad.$submitted">
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
           
    </div>
@endsection

