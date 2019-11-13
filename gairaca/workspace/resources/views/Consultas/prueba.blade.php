@extends('Layout.master')
@section('Title','Listado de solicitudes')
@section('app','ng-app="appConsulta"')
@section('controller','ng-controller="consultageneralCtrl"')

@section('contenido')
    
    <div class="container">
        
    <a href id="descargarPivotTable" >
            <img src="/img/excel.png" class="icono" />
    </a>
        <div id="output" style="overflow: auto; margin: 30px;"></div>
    </div>
@endsection
@section('javascript')
    <!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script> -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi?autoload=  {'modules':[{'name':'visualization','version':'1.1','packages': ['corechart']}]}"></script> 

    <!-- external libs from cdnjs -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- PivotTable.js libs from ../dist -->
    <link rel="stylesheet" type="text/css" href="/css/pivot/pivot.css">
    <!-- <script type="text/javascript" src="https://pivottable.js.org/dist/pivot.js"></script> -->
    <script src="{{asset('/js/plugins/pivot/pivot.js')}}"></script>
    <script src="{{asset('/js/plugins/pivot/pivot.es.js')}}"></script>
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
    <script>
        
        $("#descargarPivotTable").on("click", function(){ 
            
            var htmls = "";
            //var uri = 'data:application/vnd.ms-excel;base64,';
            var uri = 'data:application/vnd.ms-excel;charset=UTF-8;base64,'
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };

            htmls = $(".pvtRendererArea").html();

            var ctx = { worksheet : 'Worksheet', table : htmls };

            var link = document.createElement("a");
            link.download = "Datos solicitudes"
            link.href = uri + base64(format(template, ctx));
            link.click();
        });
    </script>
    <script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
  	
    <script src="{{asset('/js/consultas/consultasGenerales.js')}}"></script>
    <script src="{{asset('/js/consultas/consultasGeneralesServices.js')}}"></script>

@endsection
