var app = angular.module("solicitudConceptoService", []);

app.factory("solicitudConceptoServi", ["$http", "$q", function ($http, $q) {

    return {
        
        obtenerSolicitudResponder: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/datos_solicitud_concepto/'+id).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        crearRespuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/crear_respuesta_concepto', data, {
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