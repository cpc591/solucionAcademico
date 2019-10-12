var app = angular.module("appDependencia", ['dependenciaService', 'ngMaterial', 'ngMessages', 'angularUtils.directives.dirPagination', 'ADM-dateTimePicker', 'lfNgMdFileInput']);

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

app.controller('listado_solicitudes_dependenciasCtrl', function($scope, dependenciaServi) {
    $scope.duracionSolicitud = 15;

    $scope.respondidas_dependencias = [];
    $scope.respondidas_dependencias.duracion = [];
    $scope.respondidas_dependencias.accion_id = [];
    var cont_res = 0;
    var cont_res2 = 0;
    $scope.listado_solicitudes_dependencias = [];
    $("#load2").removeClass("hidden");

    dependenciaServi.getSolicitudes().then(function(dato) {
        $scope.lista_novedades = dato.novedades;
        $scope.dependencias = dato.dependencias;
        $scope.solicitudesConceptos = dato.solicitudesConceptos;
        for (var i = 0; i < dato.lista_solicitudes.length; i++) {

            dato.lista_solicitudes[i].duracion = parseInt(dato.lista_solicitudes[i].duracion);
            if ((dato.lista_solicitudes[i].acciones[0].id_acciones == 8 || dato.lista_solicitudes[i].acciones[0].id_acciones == 7)) {
                $scope.respondidas_dependencias.push(dato.lista_solicitudes[i]);

                $scope.respondidas_dependencias[cont_res].accion_id = $scope.respondidas_dependencias[cont_res].acciones[0].id_acciones;
                $scope.respondidas_dependencias[cont_res].accion_nombre = $scope.respondidas_dependencias[cont_res].acciones[0].accion;
                $scope.respondidas_dependencias[cont_res].encargado = $scope.respondidas_dependencias[cont_res].encargado == null ? '' : $scope.respondidas_dependencias[cont_res].encargado;
                cont_res++;

            } else {
                if (dato.lista_solicitudes[i].consecutivo != null) {
                    $scope.listado_solicitudes_dependencias.push(dato.lista_solicitudes[i]);
                    $scope.listado_solicitudes_dependencias[cont_res2].accion_id = $scope.listado_solicitudes_dependencias[cont_res2].acciones[0].id_acciones;
                    $scope.listado_solicitudes_dependencias[cont_res2].accion_nombre = $scope.listado_solicitudes_dependencias[cont_res2].acciones[0].accion;
                    $scope.listado_solicitudes_dependencias[cont_res2].encargado = $scope.listado_solicitudes_dependencias[cont_res2].encargado == null ? '' : $scope.listado_solicitudes_dependencias[cont_res2].encargado;
                    cont_res2++;
                }
            }


        }

        $("#load2").addClass("hidden");

    }).catch(function() {
        $("#load2").addClass("hidden");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });

    $scope.soporte_novedad = function(ruta) {
        $scope.ruta = ruta;
        //$('#myModal2').modal().hide();

        $('#pdf_nove').modal({
            show: 'true'
        });
    }
    $scope.detalle_solicitud = function(response) {

        $scope.lista_acciones = response.acciones;
        $scope.lista_respuestas = response.respuestas;
        //$scope.cant_multimedia_respuesta =response.respuestas.multimedias_respuestas.length;
    }

    $scope.ver_comentario = function(dato) {
        $scope.comentario = dato.comentario;
        //$('#myModal2').modal().hide();

        $('#comentario').modal({
            show: 'true'
        });
    }
    $scope.cerrar_comentario = function(dato) {

        $('#myModal').modal({
            show: 'true'
        });
    }
    $scope.ver_respuesta = function() {

        $('#respuesta').modal({
            show: 'true'
        });
    }
    $scope.cerrar_respuesta = function() {

        $('#myModal').modal({
            show: 'true'
        });
    }
    $scope.ver_pdf = function(ruta) {
        $scope.ruta = ruta;
        $('#pdf').modal({
            show: 'true'
        });
    }
    $scope.cerrar_pdf = function() {

        $('#respuesta').modal({
            show: 'true'
        });
    }
    $scope.ver_comentario2 = function(dato) {
        $scope.comentario = dato.comentario;
        //$('#myModal2').modal().hide();

        $('#comentario2').modal({
            show: 'true'
        });
    }
    $scope.cerrar_comentario2 = function(dato) {

        $('#respondida_detalle').modal({
            show: 'true'
        });
    }
    $scope.ver_respuesta2 = function() {

        $('#respuesta2').modal({
            show: 'true'
        });
    }
    $scope.cerrar_respuesta2 = function() {

        $('#respondida_detalle').modal({
            show: 'true'
        });
    }
    $scope.ver_pdf2 = function(ruta) {
        $scope.ruta = ruta;
        $('#pdf2').modal({
            show: 'true'
        });
    }
    $scope.cerrar_pdf2 = function() {

        $('#respuesta2').modal({
            show: 'true'
        });
    }
    $scope.asignar_limite2 = function(solicitud) {
        $scope.dato_limite = solicitud;
        $scope.limite_fecha = null;
        $scope.errores = null;
        $('#limite').modal({
            show: 'true'
        });
    }
    $scope.crear_novedad_modal = function(solicitud) {
        $scope.formNovedad.$setPristine();
        $scope.formNovedad.$setUntouched();
        $scope.formNovedad.$submitted = false;
        $scope.novedad = {};
        $scope.errores = null;
        $scope.galeria_novedad = [];
        $scope.novedad.solicitude_id = solicitud;
        $('#novedad').modal({
            show: 'true'
        });
    }
    $scope.guardarEncargado_modal = function(solicitud) {
        $scope.solicitudEncargado = solicitud;
        $scope.formEncargado.$setPristine();
        $scope.formEncargado.$setUntouched();
        $scope.formEncargado.$submitted = false;
        $scope.encargado = {};
        $scope.encargado.idSolicitud = solicitud.id;
        $scope.errores = null;
        $('#encargadoModal').modal({
            show: 'true'
        });

    }
    $scope.guardarEncargado = function(solicitud) {
        if (!$scope.formEncargado.$valid) {
            $scope.formEncargado.$submitted = true;
            swal("Error", "Corriga los errores", "error");
            return;
        }

        $("#load2").removeClass("hidden");
        dependenciaServi.guardarEncargado($scope.encargado).then(function(data) {
            if (data.success == true) {
                $scope.listado_solicitudes_dependencias[$scope.listado_solicitudes_dependencias.indexOf($scope.solicitudEncargado)].encargado = $scope.encargado.encargado;
                swal({
                        title: "Éxito",
                        text: "Encargado registrado satisfactoriamente",
                        type: "success",
                        confirmButtonText: "",
                    },
                    function() {
                        $('#encargadoModal').modal('hide');

                    });
                //window.location.href="/bandeja";

            } else {
                swal("Error", "No se pudo efectuar el registro del encargado", "error");
                $scope.errores = data.errores;

            }

            $("#load2").addClass("hidden");

        }).catch(function() {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }
    $scope.crear_solicitudConcepto_modal = function(solicitud) {
        $scope.formSolicitudConcepto.$setPristine();
        $scope.formSolicitudConcepto.$setUntouched();
        $scope.formSolicitudConcepto.$submitted = false;
        $scope.solicitudConcepto = {};
        $scope.errores = null;
        $scope.galeria_solicitudConcepto = [];
        $scope.solicitudConcepto.solicitudId = solicitud;
        $('#solicitudConcepto').modal({
            show: 'true'
        });
    }
    $scope.crear_novedad = function(dato) {

        if (!$scope.formNovedad.$valid) {
            $scope.formNovedad.$submitted = true;
            swal("Error", "Corriga los errores", "error");
            return;
        }
        var fd = new FormData();
        $scope.errores = null
        $("body").attr("class", "cbp-spmenu-push charging");

        for (nombre in $scope.novedad) {
            if ($scope.novedad[nombre] != null && $scope.novedad[nombre] != "") {
                fd.append(nombre, $scope.novedad[nombre])
            }


        }
        if ($scope.galeria_novedad != null || $scope.galeria_novedad != []) {
            if ($scope.galeria_novedad.length > 3) {
                swal("Error", "El limite son 3 archivos", "error");
                return;
            }
            for (k = 0; k < $scope.galeria_novedad.length; k++) {
                fd.append("Galeria[]", $scope.galeria_novedad[k].lfFile);
            }
        }


        $scope.errores = null;

        $("#load2").removeClass("hidden");
        dependenciaServi.crearNovedad(fd).then(function(data) {
            $("#load2").addClass("hidden");
            if (data.success == true) {
                $scope.lista_novedades.push(data.novedad);
                swal({
                        title: "Éxito",
                        text: "Novedad creada satisfactoriamente",
                        type: "success",
                        confirmButtonText: "",
                    },
                    function() {
                        $('#novedad').modal('hide');

                    });
                //window.location.href="/bandeja";

            } else {
                swal("Error", "la novedad no se pudo realizar", "error");
                $scope.errores = data.errores;

            }


        }).catch(function() {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }

    $scope.crear_solicitudConcepto = function() {


        if (!$scope.formSolicitudConcepto.$valid) {
            $scope.formSolicitudConcepto.$submitted = true;
            swal("Error", "Corriga los errores", "error");
            return;
        }
        var fd = new FormData();
        $scope.errores = null
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.solicitudConcepto.idSolicitud = $scope.id_solicitud;
        for (item in $scope.solicitudConcepto) {
            if ($scope.solicitudConcepto[item] != null && $scope.solicitudConcepto[item] != "") {
                fd.append(item, $scope.solicitudConcepto[item])
            }
        }
        if ($scope.galeria_solicitudConcepto != null) {
            if ($scope.galeria_solicitudConcepto.length > 1) {
                swal("Error", "Solo puede adjuntar un archivo", "error");
                return;
            }
            for (k = 0; k < $scope.galeria_solicitudConcepto.length; k++) {
                fd.append("Galeria[]", $scope.galeria_solicitudConcepto[k].lfFile);
            }

        }
        $("#load2").removeClass("hidden");
        dependenciaServi.crearSolicitudConcepto(fd).then(function(data) {
            $("#load2").addClass("hidden");
            if (data.success == true) {
                swal({
                        title: "Éxito",
                        text: "Solicitud de concepto creada satisfactoriamente",
                        type: "success",
                        confirmButtonText: "",
                    },
                    function() {
                        //window.location.href="javascript:history.back(-1);";
                        if (parseInt($scope.idUsuario_sesion) == 9) {
                            window.location.href = "/bandeja";
                        } else {
                            window.location.href = "/bandeja3";
                        }
                    });
                //window.location.href="/bandeja";

            } else {
                swal("Error", "la solicitud no se pudo realizar", "error");
                $scope.errores = data.errores;

            }


        }).catch(function() {
            $("#load2").addClass("hidden");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }

});