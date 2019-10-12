var app = angular.module("directorAcademicoService", []);

app.factory("directorAcademicoServi", ["$http", "$q", function ($http, $q) {

    return {
        
        getSolicitudes: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/listado_solicitudes_directorAcademico').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
    }
}]);