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
});

var lineControllerObj = function ($scope){
  $scope.lineControllerObj = {
    lineTotalAmmount: 999,
    cargaExtraU: 0,
    visible: true
  };

  $scope.getAmmountLine = function (){
    return $scope.lineControllerObj.lineTotalAmmount;
  };  
};

var productControllerObj = function ($scope){
  $scope.productControllerObj = {
    cargaP: 0,
    cargaU: 0,
    cargaExtraP: 0,
    cargaExtraU: 0
  };

  $scope.getCargaP = function (){
    return parseInt($scope.productControllerObj.cargaP) + parseInt($scope.productControllerObj.cargaExtraP);
  };

  $scope.getCargaU = function (){
    return parseInt($scope.productControllerObj.cargaU) + parseInt($scope.productControllerObj.cargaExtraU);
  };

  $scope.getTotalPrice = function (product){
    numProducts = $scope.productControllerObj.cargaP + $scope.productControllerObj.cargaExtraP;

    //$scope.lineControllerObj.lineTotalAmmount = numProducts;

    return (numProducts * parseFloat(product.price));
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