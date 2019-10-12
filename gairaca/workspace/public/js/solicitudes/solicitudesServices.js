var app = angular.module("solicitudService", []);

app.factory("solicitudServi", ["$http", "$q", function ($http, $q) {

    return {
        
        verMasSolicitud: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ver_mas_solicitud/'+id).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        obtenerSolicitudResponder: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/obtener_solicitud/'+id).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        crearRespuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/crear_respuesta', data, {
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
        crearBorrador: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/crear_borrador', data, {
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
        crearNovedad: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/crear_novedad', data, {
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
        reenviarSolicitud: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/reenviar_solicitud', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        eliminarSoporteRespuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/eliminar_soporteRespuesta', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);