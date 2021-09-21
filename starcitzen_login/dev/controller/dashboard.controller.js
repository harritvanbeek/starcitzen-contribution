"use strict";
boann.controller('dashboardController', ['$scope', '$http', '$window', '$state', function($scope, $http, $window, $state) {
    
    console.log($state.$current.url.pattern.split("/")[1] + " = case name");
    console.log($state.router.globals.$current.views.mainpage.controller + "Controller is Loaded");

    var URI     =   controler.view + "dashboard/index.php";
    var state   =   $state.$current.url.pattern.split("/")[1];  

    get_aUEC();
    get_currentbank();
    get_ShipsToBuy();

    $scope.submit_aUEC  =   function(data){
        if(data){
            var VALUES  =   [{data:true, data:data}];    
            $http.post(URI, VALUES, {params:{action:"post_aUEC"}}).then(function(data){
                if(data.status = 200){            
                    if(data.data){
                        switch(data.data.data){
                            case "success" :
                                swal("Well done!!", data.data.dataContent, "success"); 
                                get_aUEC();
                                get_currentbank();
                            break;
                            
                            case "error" :
                                swal("Oeps!", data.data.dataContent, "error"); 
                                get_aUEC();
                            break;
                        }
                    }           
                };
            });          
        }
    }

    $scope.DonateThisShip = function(data){
        if(data){
            
            var VALUES  =   [{data:true, data:data}];  
            $http.post(URI, VALUES, {params:{action:"donate_saving_ship"}}).then(function(data){
                if(data.status = 200){
                    switch(data.data.data){
                        case "success" :
                            swal("Well done!!", data.data.dataContent, "success"); 
                            get_ShipsToBuy();
                            get_currentbank();
                        break;
                        
                        case "error" :
                            swal("Oeps!", data.data.dataContent, "error");                             
                        break;
                    }
                        $('#donating_save_ship').modal('hide');
                }
            });
        }
    }


    $scope.reset_contribution  =   function(data){
        if(data){
            swal({
                title: "You Sure to reset your contribution",
                text: "",
                buttons: true,
                closeOnClickOutside: false,
                closeOnEsc: false,
                icon: "info",                            
            }).then(function(input){
                if(input){
                    var VALUES  =   [{data:true, data:"reset"}];
                    $http.post(URI, VALUES, {params:{action:"reset_contribution"}})
                        .then(function(data){
                            swal({
                                title: "Well done!!",
                                text: data.data.dataContent,
                                icon: "success",                            
                            });
                            get_currentbank();
                        });
                }
            });

        }
    }

    $scope.deleteShipDonation  = function(item){
       if(item){
            swal({
                title: "You Sure to delete",
                text: "",
                buttons: true,
                closeOnClickOutside: false,
                closeOnEsc: false,
                icon: "info",                            
            }).then(function(input){
                if(input){                            
                    var VALUES  =   [{data:true, data:item}];
                    $http.post(URI, VALUES, {params:{action:"deleteShipDonation"}}).then(function(data){
                        if(data.status = 200){            
                            if(data.data){
                                swal({
                                    title: "Well done!!",
                                    text: data.data.dataContent,
                                    icon: "success",                            
                                });
                                get_ShipsToBuy();
                                get_currentbank();
                                $('#show_modal_list').modal('hide'); 
                                get_DonadedShips(item);
                            }           
                        };
                    });       
                }
            });
       } 
    }

    $scope.show_modal_list  =   function(data){
        $('#show_modal_list').modal('show'); 
        $scope.thisShip = data;
        get_DonadedShips(data);
    }

    $scope.show_modal_save_ship = function(data){
        $scope.thisShip = data;
        $('#donating_save_ship').modal('show'); 
    }
    
    function get_DonadedShips(data){
        if(data){

            var VALUES  =   [{data:true, data:data}]; 
            $http.post(URI, VALUES, {params:{action:"get_DonadedShips"}}).then(function(data){
                if(data.status = 200){  
                    console.log(data.data);          
                    if(data.data){
                        $scope.donateships = data.data; 
                    }           
                };
            });
        }
    }

    function get_ShipsToBuy(){
        $http.get(URI, {params:{action:"get_ShipsToBuy"}}).then(function(data){
            if(data.status = 200){            
                if(data.data){
                    $scope.ships = data.data; 
                    $(".loading").fadeOut();
                    $(".pages").fadeIn(1200);
                }           
            };
        });
    }

    function get_currentbank(){
        $http.get(URI, {params:{action:"get_currentbank"}}).then(function(data){
            if(data.status = 200){            
                if(data.data){
                    $scope.users = data.data; 
                     $(".loading").fadeOut();
                     $(".pages").fadeIn(1200);
                }           
            };
        }); 
    }

    function get_aUEC(){
        $http.get(URI, {params:{action:"get_aUEC"}}).then(function(data){
            if(data.status = 200){            
                if(data.data){
                    $scope.bank = data.data; 
                }           
            };
        });  
    }



/*
//Chart settings
var CompanyCapitalChartOptions = {
    chart:{
        id: 'CompanyCapitalChart',
        type: 'pie',
        fontFamily: 'roboto'
    },

    dataLabels:{
        style:{colors:['#383C42']}
    },

    tooltip:{
        style:{fontFamily: 'roboto'}
    },

    title:{
        text: 'Total',
        align: 'left',
        style:{
            fontFamily: 'roboto',
            color: '#FFFFFF',
        }
    },

    plotOptions:{
        pie: {expandOnClick: false}
    },

    stroke: {show: false},
    colors: ['#FAF33E', '#FFFFFF', '#383C42'],
    series: getTotalMoney(),
    labels: ['Total Money', 'Current Contributions'],
    legend: {show: true},
}

var CompanyEarings14DaysOptions = {
    chart:{
        id: 'CompanyEarings14Days',
        type: 'area',
        fontFamily: 'roboto',
        zoom: {enabled: false},
        height: 230
    },

    grid: {
        borderColor: "#555",
        clipMarkers: false,
        yaxis: {
          lines: {
            show: false
          }
        }
    },

    series:[{
        name: 'Company earnings',
        data: getLast14Days()
    }],

    dataLabels: {
        enabled: false
    },

    tooltip:{
        style:{fontFamily: 'roboto'}
    },

    title:{
        text: 'Earings last 14 days',
        align: 'left',
        style:{
            fontFamily: 'roboto',
            color: '#FFFFFF',
        }
    },

    markers: {
        size: 5,
        colors: ["#383C42"],
        strokeColor: "#FAF33E",
        strokeWidth: 3,
    },

    tooltip: {theme: "dark"},
    stroke: {curve: 'straight'},
    colors: ['#FAF33E', '#FFFFFF', '#383C42'],
    legend: {show: false},    
}

function getTotalMoney(){
    return [1,1];    
}

function getLast14Days(){
    return [200,100,700,-100,0,1000,10,200,100,700,-100,0,1000,10];
}

//Chart creation
var CompanyCapitalChart     = new ApexCharts(document.querySelector("#CompanyCapitalChart"), CompanyCapitalChartOptions);
var CompanyEarings14Days    = new ApexCharts(document.querySelector("#CompanyEarings14Days"), CompanyEarings14DaysOptions);

window.onload = function(){
    CompanyCapitalChart.render();
    CompanyEarings14Days.render();    
}; */


}]);