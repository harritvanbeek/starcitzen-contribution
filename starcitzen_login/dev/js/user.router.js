boann.config(['$stateProvider', '$urlMatcherFactoryProvider', '$urlRouterProvider', '$locationProvider', 
    function($stateProvider, $urlMatcherFactoryProvider, $urlRouterProvider, $locationProvider){
        $urlRouterProvider.otherwise("/dashboard/");
        $urlMatcherFactoryProvider.caseInsensitive(true);
        
        $stateProvider
            .state({
                name:"dashboard",
                url: "/dashboard/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/dashboard.html?v="+controler.version,                        
                        controller  : "dashboardController",
                    },
                }
            })

            .state({
                name:"my_account",
                url: "/my_account/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/my_account.html?v="+controler.version,                        
                        controller  : "my_accountController",
                    },
                }
            })

            .state({
                name:"sercurity",
                url: "/sercurity/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/sercurity.html?v="+controler.version,                        
                        controller  : "sercurityController",
                    },
                }
            })

            .state({
                name:"my_ships",
                url: "/my-ships/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/my_ships.html?v="+controler.version,                        
                        controller  : "shipsController",
                    },
                }
            })

            .state({
                name:"save_ships",
                url: "/save-ships/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/ships.html?v="+controler.version,                        
                        controller  : "shipsController",
                    },
                }
            })

            .state({
                name:"addships",
                url: "/addships/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/addships.html?v="+controler.version,                        
                        controller  : "shipsController",
                    },
                }
            })

            .state({
                name:"addloadout",
                url: "/addloadout/:uuid/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/addloadout.html?v="+controler.version,                        
                        controller  : "shipsController",
                    },
                }
            })
            .state({
                name:"ship_catalogus",
                url: "/ship-catalogus/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/ship_catalogus.html?v="+controler.version,                        
                        controller  : "shipsController",
                    },
                }
            })
            .state({
                name:"ship_details",
                url: "/ship_details/:uuid/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/user/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/user/ship_details.html?v="+controler.version,                        
                        controller  : "shipsController",
                    },
                }
            });        
}]);