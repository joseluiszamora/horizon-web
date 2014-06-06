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

  this.saveAll = function () {
    var data = liquidation.lines;
    $http.post(url + 'liquidation/save', data).success(function (data, status, headers){
      console.log("loool");
    });
  };

/*
this.saveAll = function () {
    var serverResource = $resource(url + 'liquidation/get_lines',
    {
      param1: "param1 default",
      param2: "param2 default"
    });

    var getConfig = {};

    if ($scope.getParam1 !== undefined && $scope.getParam1 != "") {
      getConfig.param1 = $scope.getParam1;
    }

    if ($scope.getParam2 !== undefined && $scope.getParam2 != "") {
      getConfig.param2 = $scope.getParam2;
    }

    serverResource.get(getConfig,
      // Success handler
      function (value, responseHeaders) {
        $scope.getWithParamsResult = "GET SUCCESS\n\n" +
          "value: " + jsonFilter(value) + "\n\n" +
          "responseHeaders: " + jsonFilter(responseHeaders());
      },
      // Failure handler
      function (httpResponse) {
        $scope.getWithParamsResult = "GET ERROR\n\n" +
          "httpResponse: " + jsonFilter(httpResponse);
      }
    );
  };
*/



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
    if ($scope.productControllerObj.cargaU >= product.uxp) {
      product.chargeU = parseInt(Math.round($scope.productControllerObj.cargaU % product.uxp));

      product.chargeP = $scope.productControllerObj.cargaP + parseInt(Math.round($scope.productControllerObj.cargaU / product.uxp));

      $scope.productControllerObj.cargaP = product.chargeP;
      $scope.productControllerObj.cargaU = product.chargeU;
    }else{
      product.chargeU = $scope.productControllerObj.cargaU;
    }
  };
};

app.directive('ngBlur', function() {
  return function( scope, elem, attrs ) {
    elem.bind('blur', function() {
      scope.$apply(attrs.ngBlur);
    });
  };
});