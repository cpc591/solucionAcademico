var app = angular.module("appSolicitudConcepto", ['solicitudConceptoService','ngMaterial','ngMessages','lfNgMdFileInput','ng.ckeditor']);

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

app.controller('responder_conceptoCtrl', function($scope, solicitudConceptoServi) {
    $scope.$watch($scope.idConcepto, function() {
        
        $("#load2").removeClass("hidden");
        solicitudConceptoServi.obtenerSolicitudResponder($scope.idConcepto).then(function (dato) {
            $scope.solicitudConcepto = dato.solicitudConcepto;
            $scope.multimediasConcepto = dato.multimediasConcepto;
            $("#load2").addClass("hidden");
            
        }).catch(function () {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
  });
  $scope.volverPagina=function(){
        if(parseInt($scope.id)==9){
            window.location.href="/bandeja";
        }else{
            window.location.href="/bandeja3";
        }
    }
  $scope.crear_respuesta=function(){

      if (!$scope.formRespuesta.$valid || $scope.respuesta.contenido==null || $scope.respuesta.contenido=="" ) {
             
             swal("Error", "La respuesta es obligatoria","error");
             return ;
         }
         var fd = new FormData();
         $scope.errores = null;
         $scope.respuesta.solicitudConcepto = $scope.idConcepto;
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
                for (k = 0; k < $scope.galeria.length; k++) {
                    fd.append("Galeria[]", $scope.galeria[k].lfFile);
                }
            }
            
        $("#load2").removeClass("hidden");
        solicitudConceptoServi.crearRespuesta(fd).then(function (dato) {
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
});