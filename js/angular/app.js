var url = "http://localhost/horizon/index.php/";
//var url = "https://mariani.bo/horizon-sc/index.php/";

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


// lateral Menu Controller
app.controller('PanelController', function(){
  this.tab = 1;
  this.selectTab = function(setTab){
    this.tab = setTab;
  };
  this.isSelected = function (checkTab) {
    return this.tab === checkTab;
  }
});

app.directive('chargeNew', function(){
  return{
    restrict: 'E',
    templateUrl: 'create/'
  };
});

app.directive('chargeList', function(){
  return{
    restrict: 'E',
    templateUrl: 'charge_list/'
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
      window.location = url + "liquidation/charge_list";
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
  
  $scope.getDevolutionPLine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.devolutionP;
    });
    return $sum;
  };
  
  $scope.getDevolutionULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.devolutionU;
    });
    return $sum;
  };
  
  $scope.getAmmountLine = function (products){
    $sum = 0;
    angular.forEach(products, function(product) {
      //$sum += $scope.getTotalAmmount(product);
    });
    $sum = Math.round(($sum) * 100)/100;;
    return $sum;
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
    devolutionP: 0,
    devolutionU: 0,
    prestamosP: 0,
    prestamosU: 0,
    bonosP: 0,
    bonosU: 0,
    ventaP: 0,
    ventaU: 0,
    totalAmmount: 0
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
    case "liquidation":
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
    case "liquidation":
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

  $scope.getVentaP = function (product){
    $sum = 0;
    $sum += $scope.getCargaP(product);
    $sum -= parseInt(Math.floor($scope.getTotalSold(product) / product.uxp));
    //product.ventaP = $sum;
    //$scope.productControllerObj.ventaP = $sum;
    return $sum;
  };
  $scope.getVentaU = function (product){
    $sum = 0;
    $sum += parseInt($scope.getCargaP(product) * product.uxp);
    $sum += $scope.getCargaU(product);
    $sum -= $scope.getTotalSold(product);
    $sum = parseInt(Math.round($sum % product.uxp));
    //$scope.productControllerObj.ventaU = $sum;
    //product.ventaU = $sum;
    return $sum;
  };

  $scope.getTotalAmmount = function (product){
    $sum = 0;
    $sum += parseInt($scope.getVentaP(product) * product.uxp);
    $sum += parseInt($scope.getVentaU(product));
    $sum = Math.round(($sum * product.price) * 100)/100;;
    //product.totalAmmount = $sum;
    return $sum;
  };

  $scope.getTotalSold = function (product){
    $sum = 0;
    $sum += parseInt(product.devolutionP * product.uxp);
    $sum += parseInt(product.devolutionU);
    $sum += parseInt(product.prestamosP * product.uxp);
    $sum += parseInt(product.prestamosU);
    $sum += parseInt(product.bonosP * product.uxp);
    $sum += parseInt(product.bonosU);
    $sum += parseInt(product.ventaP * product.uxp);
    $sum += parseInt(product.ventaU);
    return $sum;
  }  

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







  $scope.updateDevolutionP = function (product) {
    product.devolutionP = $scope.productControllerObj.devolutionP;
  };
  $scope.updateDevolutionU = function (product) {
    if ($scope.productControllerObj.devolutionU >= product.uxp) {
      product.devolutionU = Math.round($scope.productControllerObj.devolutionU % product.uxp);

      product.devolutionP = $scope.productControllerObj.devolutionP + Math.floor($scope.productControllerObj.devolutionU / product.uxp);

      $scope.productControllerObj.devolutionP = product.devolutionP;
      $scope.productControllerObj.devolutionU = product.devolutionU;
    }else{
      product.devolutionU = $scope.productControllerObj.devolutionU;
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