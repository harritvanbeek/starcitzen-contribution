boann.config(['$stateProvider', '$urlMatcherFactoryProvider', '$urlRouterProvider', '$locationProvider', 
    function($stateProvider, $urlMatcherFactoryProvider, $urlRouterProvider, $locationProvider){
        $stateProvider
            .state({
                name:"admin",
                url: "/admin/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/admin/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/dashboard.html?v="+controler.version,                        
                        controller  : "dashboardController",
                    },
                }
            })

            .state({
                name:"import",
                url: "/import/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/admin/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/import.html?v="+controler.version,                        
                        controller  : "importController",
                    },
                }
            })
            .state({
                name:"get_all_ships",
                url: "/get_all_ships/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/admin/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/get_all_ships.html?v="+controler.version,                        
                        controller  : "GetAllShipsController",
                    },
                }
            })

            .state({
                name:"update",
                url: "/update/:uuid/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/user/navbar.html?v="+controler.version,    
                        controller: "NavbarController",                 
                    },

                    "sidebar" : {
                        templateUrl : "./html/admin/sidebar.html?v="+controler.version,   
                        //controller: "SidebarController",                    
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/update.html?v="+controler.version,                        
                        controller  : "GetAllShipsController",
                    },
                }
            });        
}]);