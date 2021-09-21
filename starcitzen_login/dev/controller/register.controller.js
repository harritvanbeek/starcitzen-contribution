"use strict";
boann.controller('RegisterController', ['$scope', '$http', '$window', function($scope, $http, $window) {
    var URI     =   controler.view + "login/index.php";
    $scope.submit =  function(data){
        if(data){
            var VALUES  =   [{data:true, data:data}];
            $http.post(URI, VALUES, {params:{action:"register"}}).then(function(data){
                if(data.status === 200){
                    switch(data.data.data){
                        case "success" :
                            swal({
                                title: "Well done!!",
                                text: data.data.dataMessinger,
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                                icon: "success",                            
                            }).then(function(input){
                                if(input){
                                    location.href = data.data.location;     
                                };
                            });                         
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