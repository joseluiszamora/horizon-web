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

  $scope.getCargaInicialPLine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.previousDayP;
    });
    return $sum;
  };
  $scope.getCargaInicialULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.previousDayU;
    });
    return $sum;
  };
  $scope.getCargaPLine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeP;
    });
    return $sum;
  };
  $scope.getCargaULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeU;
    });
    return $sum;
  };
  $scope.getTotalPLine = function (products){
    return $scope.getCargaInicialPLine(products) + $scope.getCargaPLine(products);
  };
  $scope.getTotalULine = function (products){
    return $scope.getCargaInicialULine(products) + $scope.getCargaULine(products);
  };
  $scope.getAmmountLine = function (){
    return $scope.lineControllerObj.lineTotalAmmount;
  };
  $scope.getVisible = function (line){
    return line.show;
  };   
};

var productControllerObj = function ($scope){
  $scope.productControllerObj = {
    cargaInicialP: 0,
    cargaInicialU: 0,
    cargaP: 0,
    cargaU: 0,
    cargaExtraP: 0,
    cargaExtraU: 0
  };

  $scope.getCargaP = function ($product){
    return parseInt($product.previousDayP) + parseInt($scope.productControllerObj.cargaInicialP) + parseInt($scope.productControllerObj.cargaP);
  };

  $scope.getCargaU = function ($product){
    return parseInt($product.previousDayU) + parseInt($scope.productControllerObj.cargaInicialU) + parseInt($scope.productControllerObj.cargaU);
  };

  $scope.getTotalPrice = function (product){
    numProducts = $scope.productControllerObj.cargaP + $scope.productControllerObj.cargaExtraP;
    return (numProducts * parseFloat(product.price));
  };

  $scope.updateCargaP = function (product) {
    product.chargeP = $scope.productControllerObj.cargaP;
  };
  $scope.updateCargaU = function (product) {
    product.chargeU = $scope.productControllerObj.cargaU;
  };
};

app.directive('ngBlur', function() {
  return function( scope, elem, attrs ) {
    elem.bind('blur', function() {
      scope.$apply(attrs.ngBlur);
    });
  };
});