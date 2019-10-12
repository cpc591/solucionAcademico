var app = angular.module("estudianteService", []);

app.factory("estudianteServi", ["$http", "$q", function ($http, $q) {

    return {
        
        datosSolicitud: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/datos_para_solicitud').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        listadoSolicitudes: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/listado_solicitudes_estudiantes').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        crearSolicitud: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/crear_solicitud_estudiante', data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        datosCrearNoticia: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/noticias/datoscrearnoticias').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
    }
}]);