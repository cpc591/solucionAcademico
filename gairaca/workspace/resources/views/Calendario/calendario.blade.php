@extends('Layout.master')
@section('Title','Calendario')
@section('app','ng-app="appCalendario"')
@section('controller','ng-controller="calendarioCtrl"')



@section('contenido')
    <div class="container">
            
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                      <li><a href="/bandeja3">Inicio</a></li>
                      <li class="active">Calendario</li>
                    </ol>
                </div>
            </div>
            <div class="alert alert-info">
                
                <span class="messages">
                        <span>Ayuda</span><br/>
                        <span>*Incluir día laboral: Se refiere a los días no laborales y se desea convertir a laboral.</span><br>
                        <span>*Excluir día laboral: Se refiere a los días laborales y se desea convertir a no laboral.</span><br>
                </span>
            </div>
            <div class="alert alert-danger" ng-if="errores != null">
                <h6>Errores</h6>
                <span class="messages" ng-repeat="error in errores">
                      <span>@{{error[0]}}</span><br>
                </span>
            </div>
            <div class="alert alert-warning" ng-if="fechasMalas != null">
                <h6>Fechas que no pudieron ser almacenadas</h6>
                <span class="messages" ng-repeat="fecha in fechasMalas">
                      <span>@{{fecha}}</span><br>
                </span>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <multiple-date-picker highlight-days="highlightDays" all-days-off="true" ng-model="fechas"></multiple-date-picker>
                </div>  
            </div>
            
            <br/>
            <div class="row">
                <div class="col-md-2 col-xs-12 col-sm-2">
                    <p>
                        <i style="background: #ded101;
                            width: 20px;
                            height: 15px;
                            display: -webkit-inline-box;">
                            
                        </i> Días excluidos
                    </p>
                </div>
                <div class="col-md-2 col-xs-12 col-sm-2">
                    <p>
                        <i style="background: #00a267;
                            width: 20px;
                            height: 15px;
                            display: -webkit-inline-box;">
                            
                        </i> Días incluidos
                    </p>
                </div>
                
            </div>
            <div class="row" style="text-align:center;">
                
                <div class=" col-md-offset-4 col-md-2 col-xs-12 col-sm-6">
                    <a href="/calendarioIncluidos" type="button" title="Incluir días" class="btn btn-primary"><span>Incluir días</span></a>
                </div>
                <div class="col-md-2 col-xs-12 col-sm-6">
                    <a href="/calendarioExcluidos" type="button" title="Excluir días" class="btn btn-success"><span>Excluir días</span></a>
                </div>
            </div>
            
                    
    </div>
@endsection