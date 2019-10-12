var app = angular.module("appRadicacion", ['radicacionService','ngMaterial','ngMessages','angularUtils.directives.dirPagination','ADM-dateTimePicker']);

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

app.config(['ADMdtpProvider', function(ADMdtp) {
    ADMdtp.setOptions({
        calType: 'gregorian',
        format: 'YYYY/MM/DD',
        multiple:true,
        default: 'today',
        zIndex:1160,
        disabled:['i+6','i+7'],
        gregorianDic: {
            title: 'Grégorien',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Miér', 'Juev', 'Vier', 'Sab'],
            
        },
        
    });
}]);

app.controller('vista_consecutivosCtrl', function($scope, radicacionServi) {
    $("#load2").removeClass("hidden");
    radicacionServi.getSolicitudes($scope.id).then(function (data) {
        $scope.solicitudes = data.lista;
        $scope.solicitudesConRadicacion = data.solicitudesConRadicacion;
        $scope.resRadicadas = data.resRadicadas;
        $scope.resSinRadicar = data.resSinRadicar;
        $scope.solicitudesRechazadas = data.solicitudesRechazadas;
       
        $("#load2").addClass("hidden");
        
    }).catch(function () {
        $("#load2").addClass("hidden");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });
    
    $scope.consecutivo = {solicitud:null};
    $scope.crear_consecutivo=function(solicitud){
        $scope.consecutivo = {};
        $scope.solicitudConsecutivo = solicitud;
        $scope.consecutivo.solicitud = solicitud.id;
        $scope.formConsecutivo.$setPristine();
        $scope.formConsecutivo.$setUntouched();
        $scope.formConsecutivo.$submitted = false;
        $('#modal_consecutivo').modal({
            show: 'true'
        });
    }
    $scope.guardar_consecutivo=function(){
        $("#load2").removeClass("hidden");
        radicacionServi.guardarConsecutivo($scope.consecutivo).then(function (data) {
               
               $("#load2").addClass("hidden");
               if(data.success == true){
                   $scope.solicitudes[$scope.solicitudes.indexOf($scope.solicitudConsecutivo)].consecutivo = $scope.consecutivo.consecutivo;
                   $scope.solicitudesConRadicacion.push($scope.solicitudes[$scope.solicitudes.indexOf($scope.solicitudConsecutivo)]);
                   $scope.solicitudes.splice($scope.solicitudes.indexOf($scope.solicitudConsecutivo),1);
                   swal({
                      title: "Éxito",
                      text: "Consecutivo creado satisfactoriamente",
                      type: "success",
                      confirmButtonText: "",
                    },
                    function(){
                        $('#modal_consecutivo').modal('hide');
                      //window.location.href="/vista_consecutivos";
                    });
               }else{
                        $scope.errores = data.errores;
                        swal("Error", "Corriga los errores", "error");
                   
               }
            
        }).catch(function () {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
            
    }
    $scope.crear_consecutivoRespuesta=function(solicitud){
      $scope.consecutivo = {};
      $scope.solicitudConsecutivo = solicitud;
      $scope.consecutivo.respuesta = solicitud.id;
      $scope.formConsecutivo.$setPristine();
        $scope.formConsecutivo.$setUntouched();
        $scope.formConsecutivo.$submitted = false;
        $('#modal_consecutivoRespuesta').modal({
            show: 'true'
        });
    }
    $scope.guardar_consecutivoRespuesta=function(){
        
        $("#load2").removeClass("hidden");
        radicacionServi.guardarConsecutivoRespuesta($scope.consecutivo).then(function (dato) {
            $("#load2").addClass("hidden");
           if(dato.success == true){
               $scope.resSinRadicar[$scope.resSinRadicar.indexOf($scope.solicitudConsecutivo)].consecutivo = $scope.consecutivo.consecutivo;
               $scope.resSinRadicar[$scope.resSinRadicar.indexOf($scope.solicitudConsecutivo)].fecha_radicado = $scope.consecutivo.fecha;
               $scope.resRadicadas.push($scope.resSinRadicar[$scope.resSinRadicar.indexOf($scope.solicitudConsecutivo)]);
               $scope.resSinRadicar.splice($scope.resSinRadicar.indexOf($scope.solicitudConsecutivo),1);
               
               
               swal({
                  title: "Éxito",
                  text: "Consecutivo creado satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                    $('#modal_consecutivoRespuesta').modal('hide');
                  //window.location.href="/vista_consecutivos";
                });
           }else{
                    $scope.errores = dato.errores;
                    swal("Error", "Corriga los errores", "error");
               
           }
            
        }).catch(function () {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        }); 
            
    }
    $scope.editar_consecutivo2=function(consecutivo){
      $scope.editar_consecutivo = angular.copy(consecutivo);
      console.log($scope.editar_consecutivo);
      $scope.formConsecutivo.$setPristine();
        $scope.formConsecutivo.$setUntouched();
        $scope.formConsecutivo.$submitted = false;
        $('#modal_editar_consecutivo').modal({
            show: 'true'
        });
    }
    $scope.modificar_consecutivo=function(){
        $("#load2").removeClass("hidden");
        radicacionServi.guardarConsecutivo($scope.editar_consecutivo).then(function (dato) {
            if(dato.success == true){
                $("#load2").addClass("hidden");
               swal({
                  title: "Éxito",
                  text: "Consecutivo editado satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                  window.location.href="/vista_consecutivos";
                });
           }else{
                    $scope.errores = dato.errores;
                    swal("Error", "Corriga los errores", "error");
               
           }
               
            
        }).catch(function () {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        }); 
            
    }
    
    $scope.rechazarRadicacionModal=function(solicitud){
        swal({
          title: "¿Rechazar radicación?",
          text: "¿Realmente desea no asignar radicación a la solicitud seleccionada?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si",
          closeOnConfirm: false
        },
        function(){
            $scope.errores = null;
            $scope.rechazo = {};
              $scope.rechazo.comentario = $scope.comentario;
              $scope.rechazo.idSolicitud = solicitud.id;
              $scope.solicitudRechazo = solicitud;
              $scope.formRechazoRadicacion.$setPristine();
                $scope.formRechazoRadicacion.$setUntouched();
                $scope.formRechazoRadicacion.$submitted = false;
                
                swal.close();
                
                $('#rechazoRadicacion').modal({
                    show: 'true'
                });
        })
    }
    $scope.rechazarRadicacion=function(){
        if (!$scope.formRechazoRadicacion.$valid || $scope.rechazo.comentario==null || $scope.rechazo.comentario=="" ) {
             $scope.formRechazoRadicacion.$submitted = true;
             swal("Error", "La respuesta es obligatoria","error");
             return ;
         }
         
        $("#load2").removeClass("hidden");
        radicacionServi.rechazarRadicacion($scope.rechazo).then(function (dato) {
            if(dato.success == true){
               $scope.solicitudesRechazadas.push($scope.solicitudes[$scope.solicitudes.indexOf($scope.solicitudRechazo)]);
               $scope.solicitudes.splice($scope.solicitudes.indexOf($scope.solicitudRechazo),1);
               $("#load2").addClass("hidden");
               swal({
                  title: "Éxito",
                  text: "Solicitud rechazada",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                  $('#rechazoRadicacion').modal('hide');
                });
           }else{
                $scope.errores = data.errores;
                swal("Error", "Corriga los errores", "error");
               
           }
               
            
        }).catch(function () {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }
    
    $scope.rechazarRespuestaModal=function(solicitud){
        swal({
          title: "¿Rechazar respuesta?",
          text: "¿Realmente desea no asignar radicación a la respuesta seleccionada?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si",
          closeOnConfirm: false
        },
        function(){
            $scope.errores = null;
            $scope.rechazo = {};
              $scope.rechazo.comentario = $scope.comentario;
              $scope.rechazo.idSolicitud = solicitud.estudiante.idSolicitud;
              $scope.rechazo.idRespuesta = solicitud.id;
              $scope.respuestaRechazo = solicitud;
              $scope.formRechazoRespuesta.$setPristine();
                $scope.formRechazoRespuesta.$setUntouched();
                $scope.formRechazoRespuesta.$submitted = false;
                
                swal.close();
                
                $('#rechazoRespuesta').modal({
                    show: 'true'
                });
        })
    }
    $scope.rechazarRespuesta=function(){
        if (!$scope.formRechazoRespuesta.$valid || $scope.rechazo.comentario==null || $scope.rechazo.comentario=="" ) {
             $scope.formRechazoRespuesta.$submitted = true;
             swal("Error", "El comentario es obligatorio","error");
             return ;
         }
         
        $("#load2").removeClass("hidden");
        radicacionServi.rechazarRespuesta($scope.rechazo).then(function (dato) {
            if(dato.success == true){
               $scope.resSinRadicar.splice($scope.resSinRadicar.indexOf($scope.respuestaRechazo),1);
           swal({
              title: "Éxito",
              text: "Respuesta rechazada",
              type: "success",
              confirmButtonText: "",
            },
            function(){
              $('#rechazoRespuesta').modal('hide');
            });
           }else{
                $scope.errores = dato.errores;
                swal("Error", "Corriga los errores", "error");
               
           }
               
            
        }).catch(function () {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }
    
});