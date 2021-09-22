"use strict";
boann.controller('usersController', ['$scope', '$http', '$window', '$state', function($scope, $http, $window, $state) {
    
    console.log($state.$current.url.pattern.split("/")[1] + " = case name");
    console.log($state.router.globals.$current.views.mainpage.controller + "Controller is Loaded");

    var URI     =   controler.view + "users/index.php";
    var state   =   $state.$current.url.pattern.split("/")[1];  

    switch(state){
        case "users" :

            $scope.updateUser = function(data){
                if(data){   
                    var VALUES = [{data:data}];
                    $http.post(URI, VALUES, {params:{action:'updateUser'}}).then(function(data){
                        console.log(data.data);
                        if(data.status === 200){
                            switch(data.data.data){
                                case "success" :
                                    swal({
                                        title: "Well done!!",
                                        text: data.data.dataMessinger,
                                        icon: "success",                            
                                    });
                                    $('#basicExampleModal').modal('hide'); 
                                    GetUsers();                       
                                break;
                                
                                case "error" :
                                    swal("Oeps!", data.data.dataError, "error"); 
                                break;
                            }
                        }
                    });
                };
            }

            $scope.edit = function(item){
                $http.get(URI, {params:{action:'GetPremission'}}).then(function(data){
                    if(data.data){
                        $scope.premissions = data.data;
                        $scope.user = item; 
                    }; 
                });               
            }
            GetUsers();
        break;
    }

    function GetUsers(){
        $http.get(URI, {params:{action:'GetUsers'}}).then(function(data){
            if(data.data){
                $scope.users = data.data;
            }; 
        });            
    }


}]);