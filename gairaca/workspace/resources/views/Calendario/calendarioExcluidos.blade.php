@extends('Layout.master')

@section('estilo')
<style type="text/css">
    .picker-day.picker-selected {
        background-color: #ded100!important;
        color: #000!important;
        
    }
    .picker-day.today.picker-selected, .picker-day.today:hover {
        color: #000!important;
    }

</style>

@section('contenido')
    <div class="container" ng-controller="calendarioExcluidosCtrl" ng-app="myApp">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                      <li><a href="/bandeja3">Inicio</a></li>
                      <li class="active">Días excluidos</li>
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
                    <multiple-date-picker disable-days-before="today"  week-days-off="[0,6]" ng-model="fechas"></multiple-date-picker>
                </div>  
            </div>
            <br/>
            <div class="row" style="text-align:center;">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <a href="" ng-click="agregarFecha()" type="button" title="Excluir días" class="btn btn-success"><span>Excluir días</span></a>
                </div>
            </div>
                    
    </div>
@endsection