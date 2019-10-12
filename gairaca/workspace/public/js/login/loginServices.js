var app = angular.module("loginService", []);

app.factory("loginServi", ["$http", "$q", function ($http, $q) {

    return {
        
        listadoNoticias: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/noticias/noticias').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cambiarEstadoNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/cambiarestado', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        eliminarNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/eliminarnoticia', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        verNoticia: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/noticias/datosver/'+dato).success(function (data) {
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
        guardarNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/guardarnoticia', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);