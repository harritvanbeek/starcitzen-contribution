"use strict";
boann.controller('my_accountController', ['$scope', '$http', '$window', '$state', function($scope, $http, $window, $state) {
    
    console.log($state.$current.url.pattern.split("/")[1] + " = case name");
    console.log($state.$current.name + "Controller is Loaded");

    var URI     =   controler.view + "account/index.php";
    $http.get(URI, {params:{action:"me"}}).then(function(data){
        if(data.status = 200){
            if(data.data){
                $scope.me = data.data;
                $(".loading").hide();
                $(".pages").fadeIn(1200);
            }           
        };
    });  
}]);