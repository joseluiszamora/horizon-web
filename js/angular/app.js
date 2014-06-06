//var url = "http://localhost/horizon/index.php/";
var url = "https://mariani.bo/horizon-sc/index.php/";

var idliquidation = $("#idLiquidation").html();
var mark = $("#markLiquidation").html();

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
  $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
  var liquidation = this;
  
  liquidation.lines = [ ];

  liquidation.mark = mark;
  
  $http.get(url + 'liquidation/get_lines/' + idliquidation).success(function(data){
    liquidation.lines = data;
  });

  this.saveAll = function () {
    var datasend = {  
      lines: liquidation.lines,
      liquidation: idliquidation,
      mark: mark
    };
    $http.post(url + 'liquidation/save_lines', datasend).success(function (data, status, headers){
      //console.log("loool");
    });
  };
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
  $scope.getCargaExtra1PLine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeExtraP1;
    });
    return $sum;
  };
  $scope.getCargaExtra1ULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += parseInt(value.chargeExtraU1);
    });
    return $sum;
  };
  $scope.getCargaExtra2PLine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeExtraP2;
    });
    return $sum;
  };
  $scope.getCargaExtra2ULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeExtraU2;
    });
    return $sum;
  };
  $scope.getCargaExtra3PLine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeExtraP3;
    });
    return $sum;
  };
  $scope.getCargaExtra3ULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeExtraU3;
    });
    return $sum;
  };
  $scope.getTotalPLine = function (products){
    $sum = 0;
    $sum += $scope.getCargaInicialPLine(products);
    $sum += $scope.getCargaPLine(products);
    $sum += $scope.getCargaExtra1PLine(products);
    $sum += $scope.getCargaExtra2PLine(products);
    $sum += $scope.getCargaExtra3PLine(products);
    return $sum;
  };
  $scope.getTotalULine = function (products){
    $sum = 0;
    $sum += $scope.getCargaInicialULine(products);
    $sum += $scope.getCargaULine(products);
    $sum += $scope.getCargaExtra1ULine(products);
    $sum += $scope.getCargaExtra2ULine(products);
    $sum += $scope.getCargaExtra3ULine(products);
    return $sum;
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
    cargaExtraP1: 0,
    cargaExtraU1: 0,
    cargaExtraP2: 0,
    cargaExtraU2: 0,
    cargaExtraP3: 0,
    cargaExtraU3: 0,
  };

  $scope.getCargaP = function ($product){
    $sum = 0;
    $sum += parseInt($product.previousDayP);

    switch(mark) {
    case "creado":
      $sum += parseInt($scope.productControllerObj.cargaP);
      break;
    case "cargado":
      $sum += parseInt($product.chargeP);
      $sum += parseInt($scope.productControllerObj.cargaExtraP1);
      break;
    case "cargaextra1":
      $sum += parseInt($product.chargeP);
      $sum += parseInt($product.chargeExtraP1);
      $sum += parseInt($scope.productControllerObj.cargaExtraP2);
      break;
    case "cargaextra2":
      $sum += parseInt($product.chargeP);
      $sum += parseInt($product.chargeExtraP1);
      $sum += parseInt($product.chargeExtraP3);
      $sum += parseInt($scope.productControllerObj.cargaExtraP3);
      break;
    default:
      return 0;
    }

    return $sum;
  };

  $scope.getCargaU = function ($product){
    $sum = 0;
    $sum += parseInt($product.previousDayU);

    switch(mark) {
    case "creado":
      $sum += parseInt($scope.productControllerObj.cargaU);
      break;
    case "cargado":
      $sum += parseInt($product.chargeU);
      $sum += parseInt($scope.productControllerObj.cargaExtraU1);
      break;
    case "cargaextra1":
      $sum += parseInt($product.chargeU);
      $sum += parseInt($product.chargeExtraU1);
      $sum += parseInt($scope.productControllerObj.cargaExtraU2);
      break;
    case "cargaextra2":
      $sum += parseInt($product.chargeU);
      $sum += parseInt($product.chargeExtraU1);
      $sum += parseInt($product.chargeExtraU3);
      $sum += parseInt($scope.productControllerObj.cargaExtraU3);
      break;
    default:
      return 0;
    }

    return $sum;
  };

  $scope.getTotalPrice = function (product){
    numProducts = $scope.productControllerObj.cargaP + $scope.productControllerObj.cargaExtraP1;
    return (numProducts * parseFloat(product.price));
  };

  $scope.updateCargaP = function (product) {
    product.chargeP = $scope.productControllerObj.cargaP;
  };
  $scope.updateCargaU = function (product) {
    if ($scope.productControllerObj.cargaU >= product.uxp) {
      product.chargeU = parseInt(Math.round($scope.productControllerObj.cargaU % product.uxp));

      product.chargeP = $scope.productControllerObj.cargaP + parseInt(Math.floor($scope.productControllerObj.cargaU / product.uxp));

      $scope.productControllerObj.cargaP = product.chargeP;
      $scope.productControllerObj.cargaU = product.chargeU;
    }else{
      product.chargeU = $scope.productControllerObj.cargaU;
    }
  };

  $scope.updateCargaExtraP1 = function (product) {
    product.chargeExtraP1 = $scope.productControllerObj.cargaExtraP1;
  };
  $scope.updateCargaExtraU1 = function (product) {
    if ($scope.productControllerObj.cargaExtraU1 >= product.uxp) {
      product.chargeExtraU1 = Math.round($scope.productControllerObj.cargaExtraU1 % product.uxp);
      
      product.chargeExtraP1 = $scope.productControllerObj.cargaExtraP1 + Math.floor($scope.productControllerObj.cargaExtraU1 / product.uxp);

      $scope.productControllerObj.cargaExtraP1 = product.chargeExtraP1;
      $scope.productControllerObj.cargaExtraU1 = product.chargeExtraU1;
    }else{
      product.chargeExtraU1 = $scope.productControllerObj.cargaExtraU1;
    }
  };

  $scope.updateCargaExtraP2 = function (product) {
    product.chargeExtraP2 = $scope.productControllerObj.cargaExtraP2;
  };
  $scope.updateCargaExtraU2 = function (product) {
    if ($scope.productControllerObj.cargaExtraU2 >= product.uxp) {
      product.chargeExtraU2 = Math.round($scope.productControllerObj.cargaExtraU2 % product.uxp);

      product.chargeExtraP2 = $scope.productControllerObj.cargaExtraP2 + Math.floor($scope.productControllerObj.cargaExtraU2 / product.uxp);

      $scope.productControllerObj.cargaExtraP2 = product.chargeExtraP2;
      $scope.productControllerObj.cargaExtraU2 = product.chargeExtraU2;
    }else{
      product.chargeExtraU2 = $scope.productControllerObj.cargaExtraU2;
    }
  };

  $scope.updateCargaExtraP3 = function (product) {
    product.chargeExtraP3 = $scope.productControllerObj.cargaExtraP3;
  };
  $scope.updateCargaExtraU3 = function (product) {
    if ($scope.productControllerObj.cargaExtraU3 >= product.uxp) {
      product.chargeExtraU3 = Math.round($scope.productControllerObj.cargaExtraU3 % product.uxp);

      product.chargeExtraP3 = $scope.productControllerObj.cargaExtraP3 + Math.floor($scope.productControllerObj.cargaExtraU3 / product.uxp);

      $scope.productControllerObj.cargaExtraP3 = product.chargeExtraP3;
      $scope.productControllerObj.cargaExtraU3 = product.chargeExtraU3;
    }else{
      product.chargeExtraU3 = $scope.productControllerObj.cargaExtraU3;
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