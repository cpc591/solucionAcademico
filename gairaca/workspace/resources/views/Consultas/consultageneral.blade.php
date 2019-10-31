@extends('Layout.master')
@section('Title','Consulta general')
@section('app','ng-app="appConsulta"')
@section('controller','ng-controller="consultageneralCtrl"')


@section('contenido')


	

	<!-- new added graphs chart js-->


    
<div style="overflow: auto;" ng-pivot="solicitudes"></div>

@endsection
@section('javascript')
    
<link rel="stylesheet" href="http://smartcities.softsimulation.com/pivot.css">
<link rel="stylesheet" href="http://smartcities.softsimulation.com/jquery-ui.min.css">

 <!-- js-->
<script src="http://smartcities.softsimulation.com/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
<script src="http://smartcities.softsimulation.com/js/modernizr.custom.js"></script>
<link rel="stylesheet" href="http://smartcities.softsimulation.com/css/ol.css" type="text/css">

<!-- chart -->
<script src="http://smartcities.softsimulation.com/svg-pan-zoom.js"></script>
<script src="http://smartcities.softsimulation.com/Chart.min.js"></script>
<script src="http://smartcities.softsimulation.com/pivot.min.js"></script>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="http://smartcities.softsimulation.com/angular.min.js"></script>
<script src="http://smartcities.softsimulation.com/angular-sanitize.js"></script>
<script src="http://smartcities.softsimulation.com/angular-chart.min.js"></script>
<script src="http://smartcities.softsimulation.com/angular-pivot.min.js"></script>
<script src="http://smartcities.softsimulation.com/select.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://smartcities.softsimulation.com/c3_renderers.js"></script>

<!-- //chart -->

<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
<script src="http://smartcities.softsimulation.com/js/pie-chart.js" type="text/javascript"></script>

<!-- new added graphs chart js-->
	
<script src="http://smartcities.softsimulation.com/js/Chart.bundle.js"></script>
    <script src="http://smartcities.softsimulation.com/js/utils.js"></script>
    <script src="{{asset('/js/plugins/angular-material/angular-animate.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-material/angular-aria.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-material/angular-messages.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-material/angular-material.min.js')}}"></script>
    <script src="{{asset('/js/plugins/material.min.js')}}"></script>
    
   
  	<script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    
  	<script src="{{asset('/js/consultas/consultasGenerales.js')}}"></script>
    <script src="{{asset('/js/consultas/consultasGeneralesServices.js')}}"></script>

@endsection