"use strict";
boann.controller('LoginController', ['$scope', '$http', '$window', function($scope, $http, $window) {
    var URI     =   controler.view + "login/index.php";
    $scope.submit =  function(data){
        if(data){
             var VALUES  =   [{data:true, data:data}];
            $http.post(URI, VALUES, {params:{action:"login"}}).then(function(data){
                if(data.status === 200){
                    switch(data.data.data){
                        case "success" :
                            location.href = data.data.location;
                        break;
                        
                        case "error" :
                            swal("Oeps!", data.data.dataError, "error"); 
                        break;
                    }
                }
            });
        }else{
            swal("Oeps!", "Je hebt niets opgegeven!", "error");
        }
    }     
}]);