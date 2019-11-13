@extends('Layout.master')
@section('Title','Listado de solicitudes')
@section('app','ng-app="appSolicitud"')
@section('controller','ng-controller="ver_masCtrl"')


@section('contenido')
    <div class="container">
            
            <input type="hidden" ng-model="id" ng-init="id={{$idSolicitudVerMas}}"/>
            <input type="hidden" ng-model="rol" ng-init="rol={{$rol}}"/>
                  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                       otro elemento que se pueda ocultar al minimizar la barra -->
            <div>
                
                <!-- Nav tabs -->
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs" role="tablist">
                
                            <a class="navbar-brand ">Solicitudes</a>
                            <li role="presentation" class="active"><a href="" aria-controls="lista" role="tab" data-toggle="tab">Detalle solicitud</a></li>
                          </ul>
                    </div>
                </div>
              
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="lista">
                    <div class="row">
                        <div class="col-xs-12">
                            <ol class="breadcrumb">
                              <li><a href="" ng-click="volverPagina()">Inicio</a></li>
                              <li class="active">Ver más de la solicitud</li>
                            </ol>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label for="tipoSolicitud">Tipo de la solicitud</label>
                            <input type="text" id="tipoSolicitud" ng-model="solicitud.tipos.nombre" class="form-control" readonly/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" >
                            <label for="asuntoSolicitud">Asunto</label>
                            <input type="text" id="asuntoSolicitud" ng-model="solicitud.asunto" class="form-control" readonly/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" ng-if="solicitud.asunto_id!=null">
                            <label>Descripción del asunto</label>
                                    <div ng-html="solicitud.asunto_nuevo.descripcion"></div>
                                      
                              </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Descripción de la solicitud</label>
                            <textarea style="height:110px;" class="form-control" name="descripCrearIdo" ng-model="solicitud.contenido" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" >
                            <h3 style="text-align:center;">Historial</h3>
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
                                      <div class="panel-body" ng-if="x.acciones.id==7 || x.acciones.id==8 || x.acciones.id==5 || x.acciones.id==11 || x.acciones.id==12" >
                                          @if (Auth::user()->contieneRol('Estudiante'))
                                          <div class="row">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                  
                                                  <h3>Respuesta <a href="/pdfRespuesta/@{{id}}" target="_blank"><span class="glyphicon glyphicon-print" title="Respuesta en PDF"></span></a></h3>    
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
                                          @else
                                              <div class="row" ng-if="x.acciones.id==7">
                                                  <div class="col-md-12 col-xs-12 col-sm-12">
                                                      
                                                      <h3>Respuesta <a href="/pdfRespuesta/@{{id}}" target="_blank"><span class="glyphicon glyphicon-print" title="Respuesta en PDF"></span></a></h3>    
                                                  </div>
                                                      
                                              </div>
                                              
                                              <div class="row" ng-if="x.acciones.id==7">
                                                  <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div ng-html="x.solicitude_user.respuestas[0].mensaje"></div>
                                                  </div>
                                                      
                                              </div>
                                              <div class="row" ng-if="x.acciones.id==7">
                                                <div class="col-md-12 col-xs-12 col-sm-12" ng-repeat="m in x.multimedia">
                                                            <a href="@{{m.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
                                                </div>
                                              </div>
                                          @endif                  
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
                                      <div class="panel-body" ng-if="x.acciones.id==6 || x.acciones.id == 9 || x.acciones.id == 13" >
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
                                      <div class="panel-body" ng-if="!(x.acciones.id==7 || x.acciones.id==8 || x.acciones.id==5 || x.acciones.id==6 || x.acciones.id==9 || x.acciones.id==11 || x.acciones.id==12 || x.acciones.id == 13 ||(x.acciones.id==1 && m_solicitud.length>0))" >
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
                    <br>
                    
                    <div class="row" ng-if="novedades.length!=0">
                        
                        <div class="col-md-12 col-sm-12 col-xs-12" >
                            <h3 style="text-align:center;">Novedades</h3>
                            <div class="panel-group" id="accordion_novedades"  role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default" ng-repeat="x in novedades">
                                    <div class="panel-heading" role="tab" id="heading_novedades@{{$index}}">
                                      <h4 class="panel-title" >
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_novedades" href="#collapse_novedades@{{$index}}" aria-expanded="false" aria-controls="collapse_novedades@{{$index}}" >
                                            <div class="row">
                                                
                                                <div class="col-md-6 col-xs-6 col-sm-6">
                                                    @{{x.user_create}}
                                                </div>
                                                <div class="col-md-6 col-xs-6 col-sm-6">
                                                    @{{x.created_at}}
                                                    
                                                </div>
                                            </div>
                                          
                                          
                                        </a>
                                      </h4>
                                    </div>
                                    <div id="collapse_novedades@{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_novedades@{{$index}}">
                                      <div class="panel-body" >
                                          <div class="row">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                  <h3>Novedad</h3>    
                                              </div>
                                                  
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                 @{{x.texto}}
                                              </div>
                                                  
                                          </div>
                                          <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12" ng-repeat="s in x.multimedias_novedades">
                                                      
                                                        <a href="@{{s.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
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
                                                        <a href="" ng-click="ver_pdf_sol(m_s.ruta)" >Archivo adjunto @{{$index+1}}</a>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-if="solicitudesConceptos.length!=0">
                        
                        <div class="col-md-12 col-sm-12 col-xs-12" >
                            <h3 style="text-align:center;">Solicitudes de conceptos</h3>
                            <div class="panel-group" id="accordion_solicitudes_conceptos"  role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default" ng-repeat="x in solicitudesConceptos">
                                    <div class="panel-heading" role="tab" id="heading_solicitudes_conceptos@{{$index}}">
                                      <h4 class="panel-title" >
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_solicitudes_conceptos" href="#collapse_solicitudes_conceptos@{{$index}}" aria-expanded="false" aria-controls="collapse_solicitudes_conceptos@{{$index}}" >
                                            <div class="row">
                                                
                                                <div class="col-md-6 col-xs-6 col-sm-6">
                                                    @{{x.nombreCreador}}
                                                </div>
                                                <div class="col-md-6 col-xs-6 col-sm-6">
                                                    @{{x.created_at}}
                                                    
                                                </div>
                                            </div>
                                          
                                          
                                        </a>
                                      </h4>
                                    </div>
                                    <div id="collapse_solicitudes_conceptos@{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_solicitudes_conceptos@{{$index}}">
                                      <div class="panel-body" >
                                          <div class="row">
                                              <div class="col-xs-12">
                                                  <a href="/vista_solicitud_concepto/@{{x.id}}">Ver detalle de solicitud</a>
                                              </div>
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                  <label>Remitente</label><br/>
                                                  <span>@{{x.nombreCreador}}</span>
                                              </div>
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                  <label>Destinatario</label><br/>
                                                  <span>@{{x.nombreDirigida}}</span>
                                              </div>
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                  <label>Asunto</label><br/>
                                                  <span>@{{x.asunto}}</span>
                                              </div>
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                <label>Descripción</label><br/>
                                                <div ng-html="x.texto"></div>
                                              </div>
                                                  
                                          </div>
                                          <div class="row" ng-if="x.multimedias_solicitude_concepto.length>0">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <label>Multimedia solicitud</label><br/>
                                                <div  ng-repeat="s in x.multimedias_solicitude_concepto">
                                                          
                                                            <a href="@{{s.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                          </div>
                                          <div class="row" ng-if="x.respuesta_concepto.length>0">
                                              <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <label>Respuesta</label><br/>
                                                    <div ng-html="x.respuesta_concepto[0].mensaje"></div>
                                              </div>
                                          </div>
                                          <div class="row" ng-if="x.respuesta_concepto[0].multimedias_respuestas_conceptos.length>0">
                                              <label>Multimedia de la respuesta</label><br/>
                                            <div class="col-md-12 col-xs-12 col-sm-12" ng-repeat="s in x.respuesta_concepto[0].multimedias_respuestas_conceptos">
                                                      
                                                        <a href="@{{s.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
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
                                                        <a href="" ng-click="ver_pdf_sol(m_s.ruta)" >Archivo adjunto @{{$index+1}}</a>
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
                                    </div>
                                </div>
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
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    
   
  	<script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
  	<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
  	<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
      <script src="{{asset('/js/plugins/lf-ng-md-file-input.min.js')}}"></script>
      <script src="{{asset('/js/plugins/select.min.js')}}"></script>
  	<script src="{{asset('/js/solicitudes/solicitudes.js')}}"></script>
    <script src="{{asset('/js/solicitudes/solicitudesServices.js')}}"></script>
@endsection