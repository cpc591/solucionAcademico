var app = angular.module("consultaService", []);

app.factory("consultaServi", ["$http", "$q", function($http, $q) {

    return {

        getConsultasGenerales: function() {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/getConsultasGenerales').success(function(data) {
                defered.resolve(data);
            }).error(function(err) {
                defered.reject(err);
            })
            return promise;
        },

    }
}]);