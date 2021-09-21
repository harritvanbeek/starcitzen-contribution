"use strict";
boann.controller('sercurityController', ['$scope', '$http', '$window', '$state', function($scope, $http, $window, $state) {
    
    console.log($state.$current.url.pattern.split("/")[1] + " = case name");
    console.log($state.router.globals.$current.views.mainpage.controller + "Controller is Loaded");

    var URI     =   controler.view + "account/index.php";
    $scope.tab  =   "";

    $scope.updateUsername   = function(data){
        if(data){
            var VALUES  =   [{data:true, data:data}];
            $http.post(URI, VALUES, {params:{action:"updateUsername"}}).then(function(data){
                switch(data.data.data){
                    case "success" :
                        swal({
                            title: "Well done!!",
                            text: data.data.dataContent,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            icon: "success",                            
                        }).then(function(input){
                            if(input){
                                $window.location.reload();      
                            };
                        });         
                    break;

                    case "error" :
                        swal("Oeps!", data.data.dataContent, "error");                                                
                    break;
                }
            });
        }else{
            //error;
            swal("Oeps!", "Star citzen naam is een verplichte veld", "error");
        }
    }

    $scope.updatePassword   = function(data){
        if(data){
            var VALUES  =   [{data:true, data:data}];
            $http.post(URI, VALUES, {params:{action:"updatePassword"}}).then(function(data){
                switch(data.data.data){
                    case "success" :
                        swal({
                            title: "Well done!!",
                            text: data.data.dataContent,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            icon: "success",                            
                        }).then(function(input){
                            if(input){
                                $window.location.reload();      
                            };
                        });                        
                    break;

                    case "error" :
                        swal("Oeps!", data.data.dataContent, "error");                                                
                    break;
                }
            });
        }else{
            //error;
            swal("Oeps!", "Wachtwoorden zijn een verplichte velden", "error");   
        }
    }

    $scope.updateEmail      = function(data){
        if(data){
            var VALUES  =   [{data:true, data:data}];
            $http.post(URI, VALUES, {params:{action:"updateEmail"}}).then(function(data){
                console.log(data.data);
                switch(data.data.data){
                    case "success" :
                        swal({
                            title: "Well done!!",
                            text: data.data.dataContent,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            icon: "success",                            
                        }).then(function(input){
                            if(input){
                                $window.location.reload();      
                            };
                        });                        
                    break;
    
                        case "error" :
                            swal("Oeps!", data.data.dataContent, "error");                                                
                        break;
                    }
            });        
        }else{
            //error;
            swal("Oeps!", "Email zijn een verplichte velden", "error");   
        }
    }

    
    $scope.editCancel = function(data){
        switch(data){
            case "username" :
                $("#username").show();
                $("#password").show(); 
                $("#email").show();               
            break;

            case "password" :
                $("#username").show();
                $("#password").show(); 
                $("#email").show();               
            break;

            case "email" :
                $("#username").show();
                $("#password").show();
                $("#email").show();                
            break;
        }
        $scope.tab = "";
    }

    $scope.edit = function(data){
        switch(data){
            case "username" :
                $("#username").hide();
                $("#password").show(); 
                $("#email").show();               
            break;

            case "password" :
                $("#username").show();
                $("#password").hide(); 
                $("#email").show();               
            break;

            case "email" :
                $("#username").show();
                $("#password").show();
                $("#email").hide();                
            break;
        }
        
        $scope.tab = data;        
    }

    $http.get(URI, {params:{action:"me"}}).then(function(data){
        if(data.status = 200){
            if(data.data){
                $scope.me = data.data;
                $(".loading").fadeOut();
                $(".pages").fadeIn(1200);
            }           
        };
    });  
}]);