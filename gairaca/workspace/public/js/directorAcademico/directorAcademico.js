var app = angular.module("appDirectorAcademico", ['directorAcademicoService','ngMaterial','ngMessages','angularUtils.directives.dirPagination','ADM-dateTimePicker','lfNgMdFileInput']);

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

app.controller('listado_solicitudes_directorAcademicoCtrl', function($scope, directorAcademicoServi) {
    $scope.duracionSolicitud = 15;
    //$scope.today = moment();
    
    $scope.respondidas_dependencias = [];
    $scope.respondidas_dependencias.duracion = [];
    $scope.respondidas_dependencias.accion_id = [];
    var cont_res=0;
    var cont_res2=0;
    
    $("#load2").removeClass("hidden");
    directorAcademicoServi.getSolicitudes().then(function (dato) {
        for(var i=0;i<dato.lista_solicitudes.length;i++){
            
            dato.lista_solicitudes[i].duracion=parseInt(dato.lista_solicitudes[i].duracion);
            if(dato.lista_solicitudes[i].acciones[0].id_acciones!=8){
                $scope.respondidas_dependencias.push(dato.lista_solicitudes[i]);
                
                $scope.respondidas_dependencias[cont_res].accion_id=$scope.respondidas_dependencias[cont_res].acciones[0].id_acciones;
                 $scope.respondidas_dependencias[cont_res2].accion_nombre = $scope.respondidas_dependencias[cont_res2].acciones[0].accion;
                cont_res++;
            }else{
                $scope.listado_solicitudes_directorAcademico.push(dato.lista_solicitudes[i]);
                $scope.listado_solicitudes_directorAcademico[cont_res2].accion_id=$scope.listado_solicitudes_directorAcademico[cont_res2].acciones[0].id_acciones;
                 $scope.listado_solicitudes_directorAcademico[cont_res2].accion_nombre = $scope.listado_solicitudes_directorAcademico[cont_res2].acciones[0].accion;
                    
                cont_res2++;
            }
            
            
        }
       
        $("#load2").addClass("hidden");
        
    }).catch(function () {
        $("#load2").addClass("hidden");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });
    
    $scope.detalle_solicitud=function(response){
        
        $scope.lista_acciones=response.acciones;
        $scope.lista_respuestas = response.respuestas;
        console.log(($scope.lista_respuestas));
    }
    
    
});