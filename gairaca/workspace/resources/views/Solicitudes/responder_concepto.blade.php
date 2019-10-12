@extends('Layout.master')
@section('Title','Responder solicitud de concepto')
@section('app','ng-app="appSolicitudConcepto"')
@section('controller','ng-controller="responder_conceptoCtrl"')


@section('contenido')
    <div class="container">
        <div>
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs" role="tablist">
                
                        <a href="/academico" class="navbar-brand ">Listado de solicitudes</a>
                      </ul>
                      <ol class="breadcrumb">
                          <li><a href="" ng-click="volverPagina()">Inicio</a></li>
                          <li class="active">Responder solicitud de concepto</li>
                        </ol>
                </div>
            </div>
            <!-- Nav tabs -->
              
            
        </div>
        
        <div class="row block-center">
                <input type="hidden" ng-init="idConcepto='{{$idConcepto}}'"/>
                <div class="col-xs-12">
                    <div class="row">
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                
                                    <label>Remitente</label>
                                    <input type="text" class="form-control" value="@{{solicitudConcepto.nombreCreador}}" readonly/>
                                    
                            </div>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                
                                    <label>Destinatario</label>
                                    <input type="text" class="form-control" value="@{{solicitudConcepto.nombreDirigida}}" readonly/>
                                    
                            </div>
                            
                    </div>
                    <br>
                    <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                
                                    <label>Asunto</label>
                                    <input type="text" class="form-control" value="@{{solicitudConcepto.asunto}}" readonly/>
                                    
                            </div>
                            
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12  col-xs-12 col-sm-12">
                            <label>Descripción</label>
                            <textarea  style="height:110px;" class="form-control" ng-required="true" resize="none" readonly>@{{solicitudConcepto.descripcion}}</textarea>
                            
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="list-group"  ng-if="multimediasConcepto.length > 0">
                              <div  class="list-group-item active">Soportes creación</div>
                              <div ng-repeat="multimedia in multimediasConcepto" class="list-group-item">
                                      <a target="_blank" href="http://desarrollo-estudiantil-luifer.c9users.io/@{{multimedia.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                
        </div>
        <br><hr><br>
            
        <div class="row" ng-show="solicitudConcepto.respuesta_concepto.length == 0 && solicitudConcepto.dirigidaId == {{Auth::user()->id}}">
            <div class="alert alert-danger col-md-12" ng-if="errores != null">
                <h5><strong>Errores</strong></h5>
                <span class="messages" ng-repeat="error in errores">
                      <span><strong>*@{{error[0]}}</strong></span>
                      <br>
                </span>
            </div>
            <form role="form" name="formRespuesta"  novalidate>
                <div class="col-md-6">
                        <ng-ckeditor  
                                      ng-model="respuesta.contenido"
                                      ng-disabled="editorDIsabled" 
                                      skin="moono" 
                                      remove-buttons="Image" 
                                      remove-plugins="iframe,flash,smiley"
                                      required>
                        </ng-ckeditor>
                </div>
                    
                    
                <div class="col-md-6">
                    
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
                       <div class="col-xs-12 colsm-12 col-md-12">
                           <input  type="submit" class="btn btn-success" value="Responder" ng-click="crear_respuesta(respuesta)">
                       </div>    
                        
                    </div>
                </div>
                
            </form>
        </div>
        
        <div class="row" ng-show="solicitudConcepto.respuesta_concepto.length > 0">
              <div class="col-md-12 col-xs-12 col-sm-12">
                  <h3>Respuesta</h3>    
              </div>
              <div class="col-md-12 col-xs-12 col-sm-12">
                <div ng-html="solicitudConcepto.respuesta_concepto[0].mensaje"></div>
              </div>
            <div class="col-md-12 col-xs-12 col-sm-12" ng-repeat="m in solicitudConcepto.respuesta_concepto[0].multimedias_respuestas_conceptos">
                        <a href="http://desarrollo-estudiantil-luifer.c9users.io/@{{m.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
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
  	<script src="{{asset('/js/plugins/lf-ng-md-file-input.min.js')}}"></script>
  	<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
  	<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
  	<script src="{{asset('/js/solicitudConcepto/solicitudConcepto.js')}}"></script>
    <script src="{{asset('/js/solicitudConcepto/solicitudConceptoServices.js')}}"></script>
@endsection