var app = angular.module("appSolicitud", ['solicitudService','ngMaterial','ngMessages','lfNgMdFileInput','ng.ckeditor']);

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

app.controller('ver_masCtrl', function($scope, solicitudServi) {
    $scope.id = null;
    $scope.$watch('id', function() {
        if($scope.id){
            
            $("#load2").removeClass("hidden");
    
            solicitudServi.verMasSolicitud($scope.id).then(function (dato) {
                $scope.datos_solicitud = dato.datos_solicitud;
                $scope.novedades = dato.novedades;
                $scope.solicitudesConceptos = dato.solicitudesConceptos;
                   for( var i=0; i<$scope.datos_solicitud.length; i++){
                       if($scope.datos_solicitud[i].solicitude_user.respuestas.length>0){
                           for(var j=0;j<$scope.datos_solicitud[i].solicitude_user.respuestas.length;j++){
                               if($scope.datos_solicitud[i].solicitude_user.respuestas[j].multimedias_respuestas.length > 0){
                                   $scope.datos_solicitud[i].multimedia = $scope.datos_solicitud[i].solicitude_user.respuestas[j].multimedias_respuestas;
                                   break;
                               }
                           }
                       }
                   }
               
                $scope.solicitud = dato["datos_solicitud"][0].solicitude_user.solicitude;
                $scope.m_solicitud = $scope.solicitud.multimedias_solicitudes;
                if($scope.solicitud.asunto_id!=null){
                    $scope.solicitud.asunto = $scope.solicitud.asunto_nuevo.nombre;
                }
               
                $("#load2").addClass("hidden");
                
            }).catch(function () {
                $("#load2").addClass("hidden");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });
        }
    
    });
    
    
    $scope.volverPagina=function(){
        if(parseInt($scope.rol)==1 || parseInt($scope.rol)==6){
            window.location.href="/bandeja3";
        }else if(parseInt($scope.rol)==2 || parseInt($scope.rol)==3){
            window.location.href="/bandeja2";
        }
        else if(parseInt($scope.rol)==4){
            window.location.href="/directorAcademico";
        }else if(parseInt($scope.rol)==5){
            window.location.href="/vista_consecutivos";
        }
    }
   
    $(document).on('click', '.signo', function () {
        
      if($(this).find('.glyphicon-plus').css("display")=='inline-block'){
          $('.glyphicon-minus').css("display","none");
        $('.glyphicon-plus').css("display","inline-block");
          $(this).find('.glyphicon-plus').css("display","none");
          $(this).find('.glyphicon-minus').css("display","inline-block");
      }else{
          $(this).find('.glyphicon-plus').css("display","inline-block");
          $(this).find('.glyphicon-minus').css("display","none");
      }
    });
});

app.controller('responderCtrl', function($scope, solicitudServi) {
    
    $scope.$watch('idSolicitud', function() {
        if($scope.idSolicitud){
            
            $("#load2").removeClass("hidden");
            solicitudServi.obtenerSolicitudResponder($scope.idSolicitud).then(function (dato) {
                $scope.solicitud = dato.solicitud;
                $scope.user = dato.user;
                $scope.multimedias = dato.multimedias;
                $scope.datos = dato.datos;
                $scope.respuesta2 = dato.respuesta;
                $scope.respuesta = {};
                $scope.respuesta.contenido = $scope.respuesta2 != null ? $scope.respuesta2.mensaje : "";
                $scope.multimedias_respuesta = dato.multimedias_respuesta;
                $scope.dependencias = dato.dependencias;
                $("#load2").addClass("hidden");
                
            }).catch(function () {
                $("#load2").addClass("hidden");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });
    
        }
    
    });
    
    var fecha_actual = new Date();
    var fecha_entrega = new Date();
     fecha_entrega = fecha_actual.getTime()+(15*24*60*60*1000);
    
    $scope.fecha_actual =   fecha_actual.getFullYear()+ "/" + (fecha_actual.getMonth() +1) + "/" +fecha_actual.getDate();
    $scope.fecha_entrega =  new Date(fecha_entrega);
    $scope.fecha_entrega =   $scope.fecha_entrega.getFullYear()+ "/" + ($scope.fecha_entrega.getMonth() +1) + "/" +$scope.fecha_entrega.getDate();
    
    $('.view-pdf').on('click',function(){
        var pdf_link = $(this).attr('href');
        //var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
        //var iframe = '<object data="'+pdf_link+'" type="application/pdf"><embed src="'+pdf_link+'" type="application/pdf" /></object>'        
        var iframe = '<object type="application/pdf" data="'+pdf_link+'" width="100%" height="500">No Support</object>'
        $.createModal({
            title:'My Title',
            message: iframe,
            closeButton:true,
            scrollable:false
        });
        return false;        
    }); 
    $scope.crear_respuesta=function(dato){
        
      if (!$scope.formRespuesta.$valid || $scope.respuesta.contenido==null || $scope.respuesta.contenido=="" ) {
             $scope.formRespuesta.$submitted = true;
             swal("Error", "La respuesta es obligatoria","error");
             return ;
         }
         var fd = new FormData();
         $scope.errores = null
    
            var fd = new FormData();
            //pasar todo al formData
            $scope.respuesta.solicitud = $scope.idSolicitud; 
            for (contenido in $scope.respuesta) {



                    if ($scope.respuesta[contenido] != null && $scope.respuesta[contenido] != "") {
                        fd.append(contenido, $scope.respuesta[contenido])
                        
                    }
                

            }
            
            if ($scope.galeria != null) {
                if(($scope.numero_mult + $scope.galeria.length)>3){
                    swal("Error", "El limite son 3 archivos","error");
                    return;
                }
                for (k = 0; k < $scope.galeria.length; k++) {
                    fd.append("Galeria[]", $scope.galeria[k].lfFile);
                }
            }
            
            $("#load2").removeClass("hidden");
            solicitudServi.crearRespuesta(fd).then(function (dato) {
                $("#load2").addClass("hidden");
                if(dato.success == true){
                    swal({
                      title: "Éxito",
                      text: "Respuesta creada satisfactoriamente",
                      type: "success",
                      confirmButtonText: "",
                    },
                    function(){
                        if(parseInt($scope.idUsuario_sesion)==9){
                            window.location.href="/bandeja";
                        }else{
                            window.location.href="/bandeja3";
                        }
                      //window.location.href="javascript:history.back(-1);";
                    });
                    //window.location.href="/bandeja";
                    
                }else{
                      swal("Error", "la respuesta no se pudo realizar", "error");
                      $scope.errores = dato.errores;
                      
                }
                
            }).catch(function () {
                $("#load2").addClass("hidden");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });
    }
    $scope.crear_borrador=function(dato){
        $scope.respuesta.solicitud = $scope.idSolicitud;
         var fd = new FormData();
         $scope.errores = null
         $("body").attr("class", "cbp-spmenu-push charging");






            var fd = new FormData();
            //pasar todo al formData
            for (contenido in $scope.respuesta) {



                    if ($scope.respuesta[contenido] != null && $scope.respuesta[contenido] != "") {
                        fd.append(contenido, $scope.respuesta[contenido])
                        
                    }
                

            }
            
            if ($scope.galeria != null) {
                if(($scope.numero_mult + $scope.galeria.length)>3){
                    swal("Error", "El limite son 3 archivos","error");
                    return;
                }
                for (var k = 0; k < $scope.galeria.length; k++) {
                    fd.append("Galeria[]", $scope.galeria[k].lfFile);
                }
            }
            
            $("#load2").removeClass("hidden");
            solicitudServi.crearBorrador(fd).then(function (dato) {
                $("#load2").addClass("hidden");
                if(dato.success == true){
                    swal({
                      title: "Éxito",
                      text: "Borrador creado satisfactoriamente",
                      type: "success",
                      confirmButtonText: "",
                    },
                    function(){
                      location.reload();
                    });
                    //window.location.href="/bandeja";
                    
                }else{
                      swal("Error", "El borrador no se pudo realizar", "error");
                      $scope.errores = dato.errores;
                      
                }
                
            }).catch(function () {
                $("#load2").addClass("hidden");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });
    } 
        
    $scope.crear_novedad=function(dato){
        $scope.formNovedad.$setPristine();
       $scope.formNovedad.$setUntouched();
       $scope.formNovedad.$submitted = false;
       

      if (!$scope.formNovedad.$valid) {
             $scope.formNovedad.$submitted = true;
             swal("Error", "Corriga los errores","error");
             return ;
         }
         var fd = new FormData();
         $scope.errores = null;
         $("body").attr("class", "cbp-spmenu-push charging");


        if ($scope.novedad != null && $scope.novedad != "") {
            fd.append("novedad", $scope.novedad)
            
        }
        if ($scope.permiso != null && $scope.permiso != "") {
            fd.append("permiso", $scope.permiso)
            
        }
        if ($scope.respuesta.solicitud != null && $scope.respuesta.solicitud != "") {
            
            fd.append("solicitude_id", $scope.respuesta.solicitud);
        }
            if ($scope.galeria != null) {
                if( $scope.galeria.length>3){
                    swal("Error", "El limite son 3 archivos","error");
                    return;
                }
                for (var k = 0; k < $scope.galeria.length; k++) {
                    fd.append("Galeria[]", $scope.galeria[k].lfFile);
                }
            }
            
        $("#load2").removeClass("hidden");
        solicitudServi.crearNovedad(fd).then(function (dato) {
            $("#load2").addClass("hidden");
            if(data.success == true){
                swal({
                  title: "Éxito",
                  text: "Novedad creada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                  //window.location.href="javascript:history.back(-1);";
                  if(parseInt($scope.idUsuario_sesion)==9){
                        window.location.href="/bandeja";
                    }else{
                        window.location.href="/bandeja3";
                    }
                });
                //window.location.href="/bandeja";
                
            }else{
                  swal("Error", "la novedad no se pudo realizar", "error");
                  $scope.errores = data.errores;
                  
            }
            
        }).catch(function () {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    } 
    
    $scope.reenviar_sol=function(dependencia){
        if(dependencia!=null){
            $("#load2").removeClass("hidden");
            solicitudServi.reenviarSolicitud($scope.reenviar).then(function (dato) {
                $("#load2").addClass("hidden");
                if(dato.success == true){
                    swal({
                      title: "Éxito",
                      text: "Solicitud reenviada satisfactoriamente",
                      type: "success",
                      confirmButtonText: "",
                    },
                    function(){
                      //window.location.href="javascript:history.back(-1);";
                      if(parseInt($scope.idUsuario_sesion)==9){
                            window.location.href="/bandeja";
                        }else{
                            window.location.href="/bandeja3";
                        }
                    });
                    //window.location.href="/bandeja";
                    
                }else{
                      swal("Error", "la novedad no se pudo realizar", "error");
                      $scope.errores = dato.errores;
                      
                }
                
            }).catch(function () {
                $("#load2").addClass("hidden");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });
          }else{
              swal("Error", "Llenar campo de dependencia", "error");
          }
      }
          $scope.ver_pdf=function(ruta){
                $scope.ruta=ruta;
                $('#pdf').modal({
                    show: 'true'
                });
            }
        $scope.eliminar_soporteRespuesta=function(id){
            swal({
              title: "¿Eliminar soporte?",
              text: "Realmente desea eliminar el soporte seleccionado",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, eliminar",
              closeOnConfirm: false
            },
            function(){
                $("#load2").removeClass("hidden");
                solicitudServi.eliminarSoporteRespuesta(id).then(function (dato) {
                    $("#load2").addClass("hidden");
                    if(dato.success == true){
                        swal({
                          title: "Eliminado!",
                          text: "Soporte eliminado satisfactoriamente.",
                          type: "success",
                
                          confirmButtonText: "Ok",
                        },
                        function(){
                       
                           location.reload();
                           
                        })
                        
                    }else{
                          swal("Error", "la novedad no se pudo realizar", "error");
                          $scope.errores = dato.errores;
                          
                    }
                    
                }).catch(function () {
                    $("#load2").addClass("hidden");
                    swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
                });
            })
        }

});