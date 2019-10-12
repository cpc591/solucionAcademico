@extends('Layout.master')



@section('contenido')

    <div ng-app="myApp" ng-controller="solicitudesCtrl" style="padding-top:30px">
            <form role="form" name="formCrear"  novalidate>
                  
                 <div class="row">
                    <div class="col-md-4">
                        <label>Tipo documento</label>
                        <select name="Tipo" id="Tipo" ng-options="tipo.id as tipo.nombre for tipo in tipos" ng-model="solicitud.Tipo" ng-required="true">
                            <option value="">Seleccione un tipo</option>
                        </select>
                        <br>
                        <span class="messages" ng-show="formCrear.$submitted || formCrear.Tipo.$touched">
                            <span ng-show="formCrear.Tipo.$error.required">* El campo es obligatorio.</span>
                        </span>
                
                    </div>
                    <div class="col-md-4">
                        <label>Dependencia</label>
                        <select name="dependencia" id="depenencia" ng-options="dependencia.id as dependencia.nombre for dependencia in dependencias" ng-model="solicitud.Dependencia" ng-required="true">
                            <option value="">Seleccione una dependencia</option>
                        </select>
                        <br>
                        <span  ng-show="formCrear.$submitted || formCrear.dependencia.$touched">
                            <span ng-show="formCrear.dependencia.$error.required">* El campo es obligatorio.</span>
                        </span>
                
                    </div>
                
                
                
                
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <label>Codigo</label>
                        <input type="number" name="Estudiante" class="form-control" ng-model="solicitud.Estudiante" ng-blur="carga_estudiante()" ng-required="true" />
                        <span class="messages" ng-show="formCrear.$submitted || formCrear.Estudiante.$touched">
                            <span ng-show="formCrear.Estudiante.$error.required">* El campo es obligatorio.</span>
                            <span ng-show= "ErrorCodigo" >* Codigo no encontrado.</span>
                        </span>
                    </div>
                
                
                </div>
                
                <div class="row">
                    <label>Nombres</label>
                    <input type="text" name="Nombres" class="form-control" ng-model="solicitud.Nombres" ng-required="true" readonly />
                </div>
                <div class="row">
                    <label>Identificacion</label>
                    <input type="number" name="Identificacion" class="form-control" ng-model="solicitud.Identificacion" ng-required="true" readonly />
                </div>
                <div class="row">
                    <label>Correo</label>
                    <input type="text" name="Correo" class="form-control" ng-model="solicitud.Correo" ng-required="true" readonly />
                </div>
                
                <div class="row">
                    <label>Asunto</label>
                    <input type="text" name="Asunto" class="form-control" ng-model="solicitud.Asunto" ng-required="true" />
                    <span class="messages" ng-show="formCrear.$submitted || formCrear.Asunto.$touched">
                        <span ng-show="formCrear.Asunto.$error.required">* El campo es obligatorio.</span>
                    </span>
                </div>
                <div class="row">
                    <label>Descripción</label>
                    <textarea style="height:110px;" class="form-control" name="descripCrearIdo" ng-model="solicitud.Descripcion" ng-required="true"></textarea>
                    <span class="messages" ng-show="formCrear.$submitted || formCrear.descripCrearIdo.$touched">
                        <span ng-show="formCrear.descripCrearIdo.$error.required">* El campo es obligatorio.</span>
                    </span>
                </div>
                
                
                
                <hr>
                
                
            
               <lf-ng-md-file-input lf-files="galeria" lf-totalsize="20MB" lf-mimetype="pdf" id="galeria" style="background-color: rgb(16, 84, 147);" name="galeria" lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
               <div ng-messages="formCrear.galeria.$error" style="color:red;">

                    <div ng-message="totalsize">Archivos demasiados pesados para subir.</div>
                    <div ng-message="mimetype">solo archivos pdf.</div>
                </div>
               
               
                <input type="submit" class="btn btn-success" value="Guardar"  ng-click="crear_solicitud()">
        </form>
    </div>

@endsection