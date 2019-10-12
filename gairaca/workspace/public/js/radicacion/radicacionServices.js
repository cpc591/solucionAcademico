var app = angular.module("radicacionService", []);

app.factory("radicacionServi", ["$http", "$q", function ($http, $q) {

    return {
        
        getSolicitudes: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/solicitudes_radicacion').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarConsecutivo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/guardar_consecutivo', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarConsecutivoRespuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/guardar_consecutivoRespuesta', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        rechazarRadicacion: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/rechazarRadicacion', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        rechazarRespuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/rechazarRadicacion', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);
