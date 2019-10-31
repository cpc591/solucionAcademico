var app = angular.module("appConsulta", ['consultaService']);

app.directive('ngHtml', ['$compile', function($compile) {
    return function(scope, elem, attrs) {
        if (attrs.ngHtml) {
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

app.controller('consultageneralCtrl', function($scope, consultaServi) {
    //$scope.options = { renderers: $.extend($.pivotUtilities.renderers, $.pivotUtilities.c3_renderers) }
    google.charts.load('current', {
        'packages': ['corechart', 'charteditor']
    });
    $scope.solicitudes = [];
    $scope.errores = null;
    $scope.consultar = {
        fechaInicio: null,
        fechaFin: null
    };

    consultaServi.getConsultasGenerales($scope.consultar).then(function(dato) {
        if (dato.success) {
            $scope.solicitudes = dato.solicitudes;
            if ($scope.solicitudes.length > 0) {
                //$(function() {
                var derivers = $.pivotUtilities.derivers;
                var renderers = $.extend($.pivotUtilities.renderers,
                    $.pivotUtilities.gchart_renderers);
                $("#output").pivotUI($scope.solicitudes, {
                    renderers: renderers,
                    rendererName: "Area Chart",
                    rendererOptions: { gchart: { width: 800, height: 600 } }
                });
                //});
            }
        } else {
            $scope.errores = dato.errores;
        }

        $("#load2").addClass("hidden");

    }).catch(function() {
        $("#load2").addClass("hidden");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });

    $scope.consultar = function() {
        $("#load2").removeClass("hidden");
        consultaServi.getConsultasGenerales($scope.consultar).then(function(dato) {
            if (dato.success) {
                $scope.solicitudes = dato.solicitudes;
                if ($scope.solicitudes.length > 0) {
                    //$(function() {
                    var derivers = $.pivotUtilities.derivers;
                    var renderers = $.extend($.pivotUtilities.renderers,
                        $.pivotUtilities.gchart_renderers);
                    $("#output").pivot($scope.solicitudes, {
                        renderers: renderers,
                        rendererName: "Area Chart",
                        rendererOptions: { gchart: { width: 800, height: 600 } }
                    });
                    //});
                }
            } else {
                $scope.errores = dato.errores;
            }

            $("#load2").addClass("hidden");

        }).catch(function() {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }
});