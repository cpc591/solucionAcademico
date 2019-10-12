var app = angular.module("appEstudiante", ['estudianteService','ngMaterial','ngMessages','lfNgMdFileInput','angularUtils.directives.dirPagination','ng.ckeditor','ADM-dateTimePicker']);

app.directive('ngHtml', ['$compile', function($compile) {
       return function(scope, elem, attrs) {
           if(attrs.ngHtml){
               elem.html(scope.$eval(attrs.ngHtml));
               $compile(elem.contents())(scope);
           }
           scope.$watch(attrs.ngHtml, function(newValue, oldValue) {
               if (newValue && newValue !== oldValue) {
                   elem.html(newValue);
                   $compile(elem.contents())(scope);
               }
           });
       };
}]);

app.controller('listado_solicitudes_estudiantesCtrl', function($scope, estudianteServi) {
   
    $("#load2").removeClass("hidden");
    $scope.respondidas_estudiantes = [];
    $scope.respondidas_estudiantes.duracion = [];
    $scope.respondidas_estudiantes.accion_id = [];
    
    $scope.rechazadas = [];
    $scope.rechazadas.duracion = [];
    $scope.rechazadas.accion_id = [];
    var cont_res=0;
    var cont_res2=0;
    var cont_res3 = 0;
    estudianteServi.listadoSolicitudes()
    .then(function (response) {$scope.listado_solicitudes_estudiantes = [];
        $scope.acciones = response.acciones;
        $scope.tipos = response.tipos;
        $scope.asuntos = response.asuntos;
        $scope.dependencias = response.dependencias;
        for(var i=0;i<response.listaSoclicitudes.length;i++){
            /*
            response.data[i].duracion=response.data[i].duracion.replace("+", "");
            if(response.data[i].duracion2!=-500){
                response.data[i].duracion2=response.data[i].duracion2.replace("+", "");
                response.data[i].duracion2=parseInt(response.data[i].duracion2);
            }*/
            response.listaSoclicitudes[i].nombreAsunto = response.listaSoclicitudes[i].asunto_id == null ? response.listaSoclicitudes[i].asunto : response.listaSoclicitudes[i].asunto_nuevo.nombre;
            response.listaSoclicitudes[i].estado = response.listaSoclicitudes[i].acciones[0].accion;
            response.listaSoclicitudes[i].usuarioEstado = response.listaSoclicitudes[i].acciones[0].nombre;
            response.listaSoclicitudes[i].duracion=parseInt(response.listaSoclicitudes[i].duracion);
            if(response.listaSoclicitudes[i].acciones[0].id_acciones==7){
                $scope.respondidas_estudiantes.push(response.listaSoclicitudes[i]);
                
                $scope.respondidas_estudiantes[cont_res].accion_id=$scope.respondidas_estudiantes[cont_res].acciones[0].id_acciones;
                cont_res++;
            }else if(response.listaSoclicitudes[i].acciones[0].id_acciones==13){
                $scope.rechazadas.push(response.listaSoclicitudes[i]);
                
                $scope.rechazadas[cont_res3].accion_id=$scope.rechazadas[cont_res3].acciones[0].id_acciones;
                cont_res3++;
            }else{
                
                $scope.listado_solicitudes_estudiantes.push(response.listaSoclicitudes[i]);
                $scope.listado_solicitudes_estudiantes[cont_res2].accion_id=$scope.listado_solicitudes_estudiantes[cont_res2].acciones[0].id_acciones;
                cont_res2++;
            }
            
            
        }
        $("#load2").addClass("hidden");
    });
    
    $scope.buscar_descripcion=function(){
        for(var i=0; i<$scope.asuntos.length;i++){
            if($scope.asuntos[i].id==$scope.solicitud.asunto){
                $scope.descripcion_asunto = $scope.asuntos[i].descripcion;
                break;
            }
        }
    }
    $scope.crear_solicitud_estudiante=function(){

        if (!$scope.formCrear.$valid) {
            $scope.formCrear.$submitted = true;
            swal("Error", "Corriga los errores","error");
            return ;
        }
         var fd = new FormData();
         $scope.errores = null;
         
        var fd = new FormData();
        //pasar todo al formData
        for (nombre in $scope.solicitud) {



                if ($scope.solicitud[nombre] != null && $scope.solicitud[nombre] != "") {
                    fd.append(nombre, $scope.solicitud[nombre])
                }
            

        }

        if ($scope.galeria != null) {
            if($scope.galeria.length>3){
                swal("Error", "El limite son 3 archivos","error");
                return ;
            }
            for (k = 0; k < $scope.galeria.length; k++) {
                fd.append("Galeria[]", $scope.galeria[k].lfFile);
            }
        }
        if($scope.galeria == null || $scope.galeria.length == 0 || $scope.galeria == undefined){
            swal({
                title: "Crear solicitud",
                text: "¿Está seguro que desea crear la solicitud sin ningún archivo adjunto?",
                type: "warning",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function () {
                
                $scope.errores = null
                $("#load2").removeClass("hidden");
                estudianteServi.crearSolicitud(fd)
                
                
                
                .then(function (data) {
                    
                    if(data.success == true){
                    
                        //swal("Exito", "Corriga los errores", "success"),{
                        swal({
                          title: "Éxito",
                          text: "Solicitud creada satisfactoriamente",
                          type: "success",
                          confirmButtonText: "",
                        },
                        function(){
                          window.location.href="/bandeja2";
                        });
                        //window.location.href="/bandeja";
                    }else{
                            swal("Error", "La solicitud no se pudo realizar", "error");
                          $scope.errores = data.errores;
                    }
                    $("#load2").addClass("hidden");
                })
                .catch(function () {
                    $("#load2").addClass("hidden");
                    swal("Error", "Corriga los errores", "error");
                    
                });
        
                })
            }else{
                $scope.errores = null
                
                 $("#load2").removeClass("hidden");
                estudianteServi.crearSolicitud(fd)
                .then(function (data) {
                    
                    if(data.success == true){
                    
                        //swal("Exito", "Corriga los errores", "success"),{
                        swal({
                          title: "Éxito",
                          text: "Solicitud creada satisfactoriamente",
                          type: "success",
                          confirmButtonText: "",
                        },
                        function(){
                          window.location.href="/bandeja2";
                        });
                        //window.location.href="/bandeja";
                    }else{
                            swal("Error", "La solicitud no se pudo realizar", "error");
                          $scope.errores = data.errores;
                    }
                    $("#load2").addClass("hidden");
                })
                .catch(function () {
                    $("#load2").addClass("hidden");
                    swal("Error", "Corriga los errores", "error");
                    
                });
            }

            
            

         
    }
          
    $scope.detalle_solicitud=function(response){
        
        $scope.lista_acciones=response.acciones;
        $scope.lista_respuestas = response.respuestas;
        console.log(($scope.lista_respuestas));
    }
    
    $scope.aprobar_solicitud=function(solicitud){
        //console.log(solicitud);
        $http.post('/aprobar_solicitud', solicitud )
        .success(function (dato) {
           console.log(dato); 
           swal({
              title: "Éxito",
              text: "Solicitud aprobada satisfactoriamente",
              type: "success",
              confirmButtonText: "",
            },
            function(){
              window.location.href="/bandeja2";
            });
        })
    }
    $scope.ver_comentario=function(dato){
        $scope.comentario=dato.comentario;
        //$('#myModal2').modal().hide();
  
        $('#comentario').modal({
            show: 'true'
        });
    }
    $scope.cerrar_comentario=function(dato){
     
        $('#myModal').modal({
            show: 'true'
        });
    }
    
    $scope.ver_respuesta=function(){
  
        $('#respuesta').modal({
            show: 'true'
        });
    }
    $scope.cerrar_respuesta=function(){
     
        $('#myModal').modal({
            show: 'true'
        });
    }
    $scope.ver_pdf=function(ruta){
        $scope.ruta=ruta;
        $('#pdf').modal({
            show: 'true'
        });
    }
    $scope.cerrar_pdf=function(){
     
        $('#respuesta').modal({
            show: 'true'
        });
    }
    $scope.ver_comentario2=function(dato){
        $scope.comentario=dato.comentario;
        //$('#myModal2').modal().hide();
  
        $('#comentario2').modal({
            show: 'true'
        });
    }
    $scope.cerrar_comentario2=function(dato){
     
        $('#respondida_detalle').modal({
            show: 'true'
        });
    }
    $scope.ver_respuesta2=function(){
  
        $('#respuesta2').modal({
            show: 'true'
        });
    }
    $scope.cerrar_respuesta2=function(){
     
        $('#respondida_detalle').modal({
            show: 'true'
        });
    }
    $scope.ver_pdf2=function(ruta){
        $scope.ruta=ruta;
        $('#pdf2').modal({
            show: 'true'
        });
    }
    $scope.cerrar_pdf2=function(){
     
        $('#respuesta2').modal({
            show: 'true'
        });
    }
    
});