var url = "http://localhost/horizon/index.php/";

var app = angular.module('myModule', []);
app.factory('mySharedService', function($rootScope) {
    var sharedService = {};
    
    sharedService.message = '';

    sharedService.prepForBroadcast = function(msg) {
        this.message = msg;
        this.broadcastItem();
    };

    sharedService.broadcastItem = function() {
        $rootScope.$broadcast('handleBroadcast');
    };

    return sharedService;
});


app.controller('LiquidationController', ['$http', function( $http ){
  var liquidation = this;
  
  liquidation.lines = [ ];
  
  $http.get(url + 'liquidation/get_lines').success(function(data){
    liquidation.lines = data;
  });    
}]);

app.controller('ProductController', function(){
  this.product = {};
  this.productChange = function(product){
    product = this.product;
  }

  this.sum = function(){
    
  }
});


var productControllerObj = function ($scope){
  $scope.productControllerObj = {
    firstName: "Joseph",
    middleName: "Z",
    lastName: "Smith",
    trustName: "Doelo"
  };

  $scope.getFullName = function () {
    return $scope.productControllerObj.firstName + " " +
      $scope.productControllerObj.lastName;
  };

  $scope.getFullNamePlus = function (){
    return $scope.productControllerObj.trustName + " " + $scope.productControllerObj.lastName;
  };
  /*$scope.getFullName = function (){
    return $scope.firstName;
  };*/
  /*
  $scope.getProductName = function (product){
    return product.Nombre;
  };

  $scope.getCargaP = function (){
    return $scope.cargaP;
  };

  $scope.getCargaU = function (){
    return $scope.cargaU;
  };

  $scope.getCargaSum = function (){
    return $scope.cargaP + $scope.cargaP;
  };*/
};