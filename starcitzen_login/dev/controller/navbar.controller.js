"use strict";
boann.controller('NavbarController', ['$scope', '$http', '$window', '$state', function($scope, $http, $window, $state) {
    
    console.log($state.$current.url.pattern.split("/")[1] + " = case name");
    console.log($state.router.globals.$current.views.mainpage.controller + "Controller is Loaded");

    $scope.sbar     = "open";
    
    $scope.home     =   function(){
        $state.go("dashboard");
    }

    $scope.history     =   function(){
         window.history.back();
    }

    $scope.sidebar     =   function(data){
        switch(data){
            case "open" :
                $(".sidebarcontainer_sidebarcontainer").hide();
                $(".Page-page").css("margin-left", "0px");
                $scope.sbar     = "close";
            break;

            case "close" :
                $(".sidebarcontainer_sidebarcontainer").show();
                $(".Page-page").css("margin-left", "240px");
                $scope.sbar     = "open";
            break;
        }
    }

    var URI     =   controler.view + "account/index.php";                              
    $http.get(URI, {params:{action:"me"}}).then(function(data){
        if(data.status = 200){
            if(data.data){
                $scope.me = data.data;                                            
            }           
        };
    });  
        
}]);