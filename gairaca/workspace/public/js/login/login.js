var app = angular.module("appLogin", ["loginService"]);
app.controller('loginCtrl', function($scope, loginServi) {
    $scope.login = function(){
       $scope.log =0;
        if($scope.userName==null){
            $scope.log =1;
        }else{
            $http.post('/logindependencia', {'password':$scope.password,'userName':$scope.userName} )
            .success(function (dato) {
                console.log(dato);
            })
        }
    };
});