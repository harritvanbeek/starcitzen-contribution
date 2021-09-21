"use strict";
boann.controller('importController', ['$scope', '$http', '$window', '$state', '$timeout', function($scope, $http, $window, $state, $timeout) {
    
    console.log($state.$current.url.pattern.split("/")[1] + " = case name");
    console.log($state.router.globals.$current.views.mainpage.controller + "Controller is Loaded");

    var URI     =   controler.view + "api/index.php";
    var state   =   $state.$current.url.pattern.split("/")[1];  

    $scope.loading = false;
    $(".table").hide();                        

    $scope.import = function(){
       setProgress();
       $http.get(URI, {params:{action:'import_ships'}}).then(function(data){
            if(data.status === 200){
                if(data.xhrStatus === 'complete'){
                    $scope.ships = data.data;                                       
                    $timeout(function(){
                        $(".bar").fadeOut();  
                        $(".btn").fadeOut();  
                        $(".table").fadeIn();                      
                    },15000);
                }                
            };
       });
    }

    function setProgress(){
        $scope.loading = true;
        var i = 4;
        if (i == 4) {
            i = 5;
            var elem = document.getElementsByClassName("bar_fill")[0];  
            var width = 5;
            var id = setInterval(frame, 150);            
        }                    
            function frame() {
                if (width >= 100) {
                    clearInterval(id);
                    i = 4;  
                } else {
                    width++;
                    elem.style.width = width + "%";
                    $('.bar_fill_text').text(width+"%");
                }
            }
    }


}]);