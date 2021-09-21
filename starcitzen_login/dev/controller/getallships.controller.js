"use strict";
boann.controller('GetAllShipsController', ['$scope', '$http', '$window', '$state', '$timeout', '$stateParams', function($scope, $http, $window, $state, $timeout, $stateParams) {
    
    console.log($state.$current.url.pattern.split("/")[1] + " = case name");
    console.log($state.router.globals.$current.views.mainpage.controller + "Controller is Loaded");

    var URI     =   controler.view + "api/index.php";
    var URL     =   controler.view + "ships/index.php";
    var state   =   $state.$current.url.pattern.split("/")[1];  

    switch(state){
        case "update" :
            $scope.images = function(data){
                $http.get(URL, {params:{action:"shipImages", uuid:$stateParams.uuid}}).then(function(data){
                    if(data.status === 200){
                        $scope.shipImages = data.data; 
                        console.log(data.data);                   
                    }
                });
            }

            $http.get(URL, {params:{action:"shipDetails", uuid:$stateParams.uuid}}).then(function(data){
                if(data.status === 200){
                    $scope.ship = data.data;                    
                }
            });
        break;

        case "get_all_ships" :
            $http.get(URI, {params:{action:'get_ships'}}).then(function(data){
                if(data.status === 200){
                    $scope.ships = data.data;            
                }
            });
        break;
    }


}]);