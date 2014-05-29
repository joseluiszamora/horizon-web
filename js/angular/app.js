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

app.service('sharedProperties', function () {
  var property = 'First';
  return {
    getProperty: function () {
      return property;
    },
    setProperty: function(value) {
      property = value;
    }
  };
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

var lineControllerObj = function ($scope, sharedProperties){
  $scope.lineControllerObj = {
    cargaP: 0,
    cargaU: 0,
    cargaExtraP: 0,
    cargaExtraU: 0,
    totalP: 0,
    totalU: 0,
    lineTotalAmmount: 0,
    visible: true
  };

  $scope.getCargaPLine = function (){
    return $scope.lineControllerObj.cargaP;
  };
  $scope.getCargaULine = function (){
    return $scope.lineControllerObj.cargaU;
  };
  $scope.getCargaExtraPLine = function (){
    return $scope.lineControllerObj.cargaExtraP;
  };
  $scope.getCargaExtraULine = function (){
    return $scope.lineControllerObj.cargaExtraU;
  };
  $scope.getTotalPLine = function (){
    return $scope.lineControllerObj.totalP;
  };
  $scope.getTotalULine = function (){
    return $scope.lineControllerObj.totalU;
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
    return (numProducts * parseFloat(product.price));
  };

  $scope.addProduct = function(product){
    $scope.lineControllerObj.cargaP += parseInt($scope.getCargaP());
    $scope.lineControllerObj.cargaU += parseInt($scope.getCargaU());
    /*
    $scope.lineControllerObj.cargaExtraP
    $scope.lineControllerObj.cargaExtraU
    $scope.lineControllerObj.totalP
    $scope.lineControllerObj.totalU*/
    $scope.lineControllerObj.lineTotalAmmount += parseFloat($scope.getTotalPrice(product));
  };  

};