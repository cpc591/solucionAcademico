var app = angular.module("dependenciaService", []);

app.factory("dependenciaServi", ["$http", "$q", function ($http, $q) {

    return {
        
        getSolicitudes: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/listado_solicitudes_dependencias').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        datosSolicitud: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/datos_para_solicitud').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getNovedades: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/listado_novedades').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarEncargado: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/guardarEncargado', data)
            .success(function (data) {
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
        crearSolicitudConcepto: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/crear_solicitud_concepto', data, {
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
        
    }
}]);