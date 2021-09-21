"use strict";
boann.controller('shipsController', ['$scope', '$http', '$window', '$state', '$stateParams', function($scope, $http, $window, $state, $stateParams) {
    
    console.log($state.$current.url.pattern.split("/")[1] + " = case name");
    console.log($state.router.globals.$current.views.navbar.controller + "Controller is Loaded");

    var URI     =   controler.view + "ships/index.php";
    var state   =   $state.$current.url.pattern.split("/")[1];   

    switch(state){
        case "ship_details" :
            $http.get(URI, {params:{action:"shipDetails", uuid:$stateParams.uuid}}).then(function(data){
                if(data.status === 200){
                    $scope.ship = data.data;
                    //$scope.details = data.data["1"];
                }
            });

            

            $scope.bookmark = function(data){
                bookmark_btn(data);                    
            };            

        break;

        case "ship-catalogus" :
            $scope.filter = false;
            $(".boann_filter").hide();
            $scope.set_filter = function(data){
                console.log(data);
                switch(data){
                    case true :
                        $scope.filter = false;
                        $(".col-animated").removeClass('col-lg-9 col-xxl-10');
                        $(".boann_filter").hide();
                    
                    break;

                    case false :
                        $scope.filter = true;
                        $(".col-animated").addClass('col-lg-9 col-xxl-10');
                        $(".boann_filter").fadeIn();
                    break;
                }                
            }

            $scope.bookmark = function(data){
                bookmark_btn(data);                    
            };
            
            //console.log(URI);
            $http.get(URI, {params:{action:"ShipCatalogus"}}).then(function(data){
                if(data.status === 200){
                    //console.log(data.data);
                    $scope.ships = data.data;
                }
            });
        break;
        
        case "my-ships" :
            get_my_ships();   
            
            $scope.restore = function(data){
                if(data){
                    var VALUES  =   [{data:true, data:data}];
                    $http.post(URI, VALUES, {params:{action:"restore"}}).then(function(data){
                        if(data.status === 200){
                            //console.log(data.data);
                            switch(data.data.data){
                                case "success" :
                                    swal({
                                        title: "Well done!!",
                                        text: data.data.dataContent,
                                        icon: "success",                            
                                    });
                                        get_my_ships();                                                  
                                break;
                                
                                case "error" :
                                    swal("Oeps!", data.data.dataError, "error"); 
                                break;
                            }
                        }
                    });
                }
            }
        break;

        case "save-ships" :
            //get all ships;
            get_ship();   

            $scope.buyit = function(data){
                if(data){
                    var VALUES  =   [{data:true, data:data}];
                    $http.post(URI, VALUES, {params:{action:"buyit"}}).then(function(data){
                        if(data.status === 200){
                            console.log(data.data);
                            switch(data.data.data){
                                case "success" :
                                    swal({
                                        title: "Well done!!",
                                        text: data.data.dataContent,
                                        icon: "success",                            
                                    });
                                        get_ship();                                                  
                                break;
                                
                                case "error" :
                                    swal("Oeps!", data.data.dataError, "error"); 
                                break;
                            }
                        }
                    });
                }
            }

            $scope.depostit = function(data){
                if(data){
                    var VALUES  =   [{data:true, data:data}];
                    $http.post(URI, VALUES, {params:{action:"depostit"}}).then(function(data){
                        if(data.status === 200){
                            switch(data.data.data){
                                case "success" :
                                    swal({
                                        title: "Well done!!",
                                        text: data.data.dataContent,
                                        icon: "success",                            
                                    });
                                    get_ship();                                                  
                                break;
                                
                                case "error" :
                                    swal("Oeps!", data.data.dataError, "error"); 
                                break;
                            }
                        }
                    });
                }
            }

            $scope.trash = function(data){
                if(data){
                    swal({
                        title: "You Sure to delete",
                        text: "",
                        buttons: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        icon: "info",                            
                    }).then(function(input){
                        if(input){
                            var VALUES  =   [{data:true, data:data}];
                            $http.post(URI, VALUES, {params:{action:"trashship"}}).then(function(data){
                                if(data.status === 200){
                                    //console.log(data.data);
                                    //get_ship();
                                    switch(data.data.data){
                                        case "success" :
                                            swal("Well done!!", data.data.dataContent, "success"); 
                                            get_ship();
                                        break;
                                        
                                        case "error" :
                                            swal("Oeps!", data.data.dataContent, "error"); 
                                            get_ship();
                                        break;
                                    }
                                }
                            });
                            
                        };
                    });
                }
            }      
        break;

        case "addships" :
            $scope.getShips = function(data) {
                return $http.get(URI, {params:{data:data, action:'searchShip'}}).then(function(response){
                    return response.data.map(function(item){
                        return item.ship_name;
                    })
                });              
            };


            $scope.addship = function(data) {
                if(data){
                    var VALUES  =   [{data:true, data:data}];
                    $http.post(URI, VALUES, {params:{action:"addship"}}).then(function(data){
                        if(data.status === 200){
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
                                            $state.go("save_ships");                                                  
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

                }                
            }
        break;
    }




    function bookmark_btn(data){
        if(data){
            var VALUES  =   [{data:true, data:data}];
            $http.post(URI, VALUES, {params:{action:"bookmark"}}).then(function(data){
                if(data.status === 200){
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
                                    $state.go("save_ships");                                                  
                                };
                            });
                        break;
                        
                        case "error" :
                            swal("Oeps!", data.data.dataError, "error"); 
                        break;
                    }                    
                }
            });
        }
    }

    function get_my_ships(){
        $http.get(URI, {params:{action:"getmyships"}}).then(function(data){
            if(data.status === 200){
                $scope.ships = data.data;
                console.log(data.data)
                $(".loading").hide();
                $(".pages").fadeIn(1200);
            }
        });
    }

    function get_ship(){
        $http.get(URI, {params:{action:"getship"}}).then(function(data){
            if(data.status === 200){
                console.log(data.data);
                $scope.ships = data.data;
                $(".loading").hide();
                $(".pages").fadeIn(1200);
            }
        });
    }
}]);