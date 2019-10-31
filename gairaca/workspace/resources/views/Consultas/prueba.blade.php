@extends('Layout.master')
@section('Title','Listado de solicitudes')
@section('app','ng-app="appConsulta"')
@section('controller','ng-controller="consultageneralCtrl"')

@section('contenido')
    <div class="container">
        
       
        <div id="output" style="overflow: auto; margin: 30px;"></div>
    </div>
@endsection
@section('javascript')
    <!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script> -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- external libs from cdnjs -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- PivotTable.js libs from ../dist -->
    <link rel="stylesheet" type="text/css" href="/css/pivot/pivot.css">
    <!-- <script type="text/javascript" src="https://pivottable.js.org/dist/pivot.js"></script> -->
    <script src="{{asset('/js/plugins/pivot/pivot.js')}}"></script>
    <script src="{{asset('/js/plugins/pivot/gchart_renderers.js')}}"></script>
    
    <!-- <script type="text/javascript" src="https://pivottable.js.org/dist/gchart_renderers.js"></script> -->
    <style>
        body {font-family: Verdana;}
    </style>

    <!-- optional: mobile support with jqueryui-touch-punch -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>


    <script type="text/javascript">
    // This example adds Google Chart renderers.

    
        </script>
    <script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
  	
    <script src="{{asset('/js/consultas/consultasGenerales.js')}}"></script>
    <script src="{{asset('/js/consultas/consultasGeneralesServices.js')}}"></script>
@endsection
