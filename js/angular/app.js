var url = "http://localhost/horizon/index.php/";
//var url = "https://mariani.bo/horizon-sc/index.php/";

idliquidation = $("#idLiquidation").html();
mark = $("#markLiquidation").html();

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
/*
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

*/

app.controller('LiquidationController', ['$http', function( $http ){
  $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
  var liquidation = this;
  liquidation.lines = [ ];
  liquidation.expenses = [ 
    { "title" : "refrigerios", "ammount" : 0 }, 
    { "title" : "gasolina", "ammount" : 0 }
  ];

  liquidation.mark = $("#markLiquidation").html();
  liquidation.idLiquidation = $("#idLiquidation").html();

  $http.get(url + 'liquidation/get_lines/' + liquidation.idLiquidation).success(function(data){
    liquidation.lines = data;
  });

  this.addExpense = function (val) {
    liquidation.expenses.push({ "title" : val.title, "ammount" : 0 });
  };
  this.saveAll = function () {
    var datasend = {
      lines: liquidation.lines,
      expenses: liquidation.expenses,
      liquidation: $("#idLiquidation").html(),
      mark: $("#markLiquidation").html()
    };
    //console.log(datasend.lines);
    $http.post(url + 'liquidation/save_lines', datasend).success(
      function (data, status, headers){
      //window.location = url + "liquidation/charge_list";
     console.log(data);
    });
  };

  this.getAmmountLineTotal = function (){
    $sum = 0;
    angular.forEach(liquidation.lines, function(line) {
      angular.forEach(line.products, function(product) {
        $sum += product.totalAmmount;
      });
    });

    return $sum;
  };

  this.getTotalSendMoney = function (){
    $sum = 0;
    angular.forEach(liquidation.lines, function(line) {
      angular.forEach(line.products, function(product) {
        $sum += product.totalAmmount;
      });
    });

    angular.forEach(liquidation.expenses, function(expense) {
      $sum -= expense.ammount;
    });
    
    return $sum;
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

  $scope.getAmmountLine = function (products){
    $sum = 0;
    angular.forEach(products, function(product) {

      //$scope.productControllerObj.cargaExtraP1

      //$sum += parseInt($scope.getVentaP(product) * product.uxp);
      //$sum += parseInt($scope.getVentaU(product));
      //$sum = Math.round(($sum * product.price) * 100)/100;;
      $sum += product.totalAmmount;
      //console.log(product.price+" - "+product.totalAmmount);
      /*
      //$sum += $scope.getTotalAmmount(product);
      $sum += parseInt($scope.getVentaP(product) * product.uxp);
      $sum += parseInt($scope.getVentaU(product));
      $sum = Math.round(($sum * product.price) * 100)/100;
      //product.totalAmmount = $sum;
      */
    });

    $sum = Math.round(($sum) * 100)/100;;
    return $sum;
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
  $scope.getCargaPLine = function (products, uxpline){
    $sumCargaPLine = 0;
    angular.forEach(products, function(value) {
      $sumCargaPLine += value.chargeP;
    });

    if (uxpline > 0) {
      $sumUlines = $scope.getCargaRealULine(products);
      $sumCargaPLine += parseInt(Math.floor($sumUlines / uxpline));
    }

    return $sumCargaPLine;
  };
  $scope.getCargaULine = function (products, uxpline){
    $sum = 0;
    $sum += $scope.getCargaRealULine(products);

    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };

    return $sum;
  };

  $scope.getCargaRealULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeU;
    });

    return $sum;
  };


  $scope.getCargaExtra1PLine = function (products, uxpline){
    $sumCargaExtraPLine = 0;
    angular.forEach(products, function(value) {
      $sumCargaExtraPLine += value.chargeExtraP1;
    });

    if (uxpline > 0) {
      $sumCargaExtraPLine += parseInt(Math.floor(($scope.getCargaExtra1RealULine(products)) / uxpline));
    }

    return $sumCargaExtraPLine;
  };
  $scope.getCargaExtra1ULine = function (products, uxpline){
    $sum = 0;
    $sum += $scope.getCargaExtra1RealULine(products);
    
    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };

    return $sum;
  };
  $scope.getCargaExtra1RealULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += parseInt(value.chargeExtraU1);
    });
    return $sum;
  };


  $scope.getCargaExtra2PLine = function (products, uxpline){
    $sumCargaExtra2PLine = 0;
    angular.forEach(products, function(value) {
      $sumCargaExtra2PLine += value.chargeExtraP2;
    });

    if (uxpline > 0) {
      $sumCargaExtra2PLine += parseInt(Math.floor(($scope.getCargaExtra2RealULine(products)) / uxpline));
    }

    return $sumCargaExtra2PLine;
  };
  $scope.getCargaExtra2ULine = function (products, uxpline){
    $sum = 0;
    $sum += $scope.getCargaExtra2RealULine(products);
    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };

    return $sum;
  };
  $scope.getCargaExtra2RealULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeExtraU2;
    });

    return $sum;
  };

  $scope.getCargaExtra3PLine = function (products, uxpline){
    $sumCargaExtra3PLine = 0;
    angular.forEach(products, function(value) {
      $sumCargaExtra3PLine += value.chargeExtraP3;
    });
    if (uxpline > 0) {
      $sumCargaExtra3PLine += parseInt(Math.floor(($scope.getCargaExtra3RealULine(products)) / uxpline));
    }
    return $sumCargaExtra3PLine;
  };
  $scope.getCargaExtra3ULine = function (products, uxpline){
    $sum = 0;
    $sum += $scope.getCargaExtra3RealULine(products);
    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };
    return $sum;
  };
  $scope.getCargaExtra3RealULine = function (products){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.chargeExtraU3;
    });
    return $sum;
  };
  $scope.getTotalPLine = function (products, uxpline){
    $sumTotalPLine = 0;
    $sumUlines = 0;
    $sumTotalPLine += $scope.getCargaInicialPLine(products);
    $sumTotalPLine += $scope.getCargaPLine(products);
    $sumTotalPLine += $scope.getCargaExtra1PLine(products);
    $sumTotalPLine += $scope.getCargaExtra2PLine(products);
    $sumTotalPLine += $scope.getCargaExtra3PLine(products);
    
    if (uxpline > 0) {
      $sumUlines = $scope.getCountTotalULine(products, uxpline);
      $sumTotalPLine += parseInt(Math.floor($sumUlines / uxpline));
    }

    return $sumTotalPLine;
  };
  $scope.getTotalULine = function (products, uxpline){
    $sum = 0;
    $sum += $scope.getCargaInicialULine(products);
    $sum += $scope.getCargaULine(products);
    $sum += $scope.getCargaExtra1ULine(products);
    $sum += $scope.getCargaExtra2ULine(products);
    $sum += $scope.getCargaExtra3ULine(products);
    
    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };
    return $sum;
  };

  $scope.getCountTotalULine = function (products, uxpline){
    $sumlocal = 0;
    $sumlocal += $scope.getCargaInicialULine(products);
    $sumlocal += $scope.getCargaULine(products);
    $sumlocal += $scope.getCargaExtra1ULine(products);
    $sumlocal += $scope.getCargaExtra2ULine(products);
    $sumlocal += $scope.getCargaExtra3ULine(products);
    
    return $sumlocal;
  };
  
  $scope.getDevolutionPLine = function (products, uxpline){
    $sum = 0;
    $sumU = 0;

    angular.forEach(products, function(value) {
      $sum += value.devolutionP;
      $sumU += value.devolutionU;
    });

    if (uxpline > 0) {
      $sum += parseInt(Math.floor($sumU / uxpline));
    }
    
    return $sum;
  };
  
  $scope.getDevolutionULine = function (products, uxpline){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.devolutionU;
    });

    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };

    return $sum;
  };

  $scope.getAjustePLine = function (products, uxpline){
    $sum = 0;
    $sumU = 0;

    angular.forEach(products, function(value) {
      $sum += value.ajusteP;
      $sumU += value.ajusteU;
    });

    if (uxpline > 0) {
      $sum += parseInt(Math.floor($sumU / uxpline));
    }
    
    return $sum;
  };
  
  $scope.getAjusteULine = function (products, uxpline){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.ajusteU;
    });

    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };

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
    ajusteP: 0,
    ajusteU: 0,
    calculatedP: 0,
    calculatedU: 0,
    ventaP: 0,
    ventaU: 0,
    totalAmmount: 0
  };

  $scope.getCargaP = function ($product){
    $sum = 0;
    $sum += parseInt($product.previousDayP);

    mark = $("#markLiquidation").html();
    //console.log(mark);
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

    mark = $("#markLiquidation").html();
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

  $scope.getCargaPTotal = function ($product){
    $partialsum = 0;
    $partialsum += parseInt($product.previousDayU);
    $partialsum += parseInt($product.chargeU);
    $partialsum += parseInt($product.chargeExtraU1);
    $partialsum += parseInt($product.chargeExtraU2);
    $partialsum += parseInt($product.chargeExtraU3);

    $sum = 0;
    $sum += parseInt(Math.floor($partialsum / $product.uxp));
    $sum += parseInt($product.previousDayP);
    $sum += parseInt($product.chargeP);
    $sum += parseInt($product.chargeExtraP1);
    $sum += parseInt($product.chargeExtraP2);
    $sum += parseInt($product.chargeExtraP3);
    return $sum;
  };

  $scope.getCargaUTotal = function ($product){
    $sum = 0;
    $sum += parseInt($product.previousDayU);
    $sum += parseInt($product.chargeU);
    $sum += parseInt($product.chargeExtraU1);
    $sum += parseInt($product.chargeExtraU2);
    $sum += parseInt($product.chargeExtraU3);
    
    $sum = parseInt(Math.round($sum % $product.uxp));

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
    /*
    var regexp = /^\d+$/;
    var val = $scope.productControllerObj.cargaP;
    if (regexp.test(val) && val.length > 0) {
      product.chargeP = $scope.productControllerObj.cargaP;
    }else{
      product.chargeP = 0;
    }
    */
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

  $scope.updateAjusteP = function (product) {
    $subtotal = product.previousDayP + product.chargeP + product.chargeExtraP1 + product.chargeExtraP2 + product.chargeExtraP3 - product.devolutionP - product.prestamosP - product.bonosP;

    //product.calculatedP = $scope.productControllerObj.calculatedP + $subtotal;
    product.calculatedP = $scope.productControllerObj.calculatedP;
    //$scope.productControllerObj.calculatedP = product.calculatedP;

    product.ajusteP = $scope.productControllerObj.calculatedP;

    //console.log($scope.productControllerObj.calculatedP);
  };

  $scope.updateAjusteU = function (product) {
    $subtotal = product.previousDayU + product.chargeU + product.chargeExtraU1 + product.chargeExtraU2 + product.chargeExtraU3 - product.devolutionU - product.prestamosU - product.bonosU;

    $subtotal += $scope.productControllerObj.calculatedU;

    //product.calculatedU = $subtotal;
    if ($subtotal >= product.uxp) {
      product.calculatedU = Math.round($subtotal % product.uxp);

      $subtotalP = product.previousDayP + product.chargeP + product.chargeExtraP1 + product.chargeExtraP2 + product.chargeExtraP3 - product.devolutionP - product.prestamosP - product.bonosP;

      $subtotalP += $scope.productControllerObj.calculatedP;

      product.calculatedP = $subtotalP + Math.floor($subtotal / product.uxp);

      product.totalAmmount = ((product.calculatedP + product.calculatedU)*product.price);
      //$scope.productControllerObj.calculatedP = product.calculatedP;
      //$scope.productControllerObj.calculatedU = product.calculatedU;
    }else{
      product.calculatedU = $subtotal;
    }

    //product.ajusteU = $scope.productControllerObj.ajusteU;

    // Change ajuste U
    $calculatedU = $scope.productControllerObj.calculatedU;
    product.calculatedU = Math.round($calculatedU % product.uxp);

    $scope.productControllerObj.calculatedU = Math.round($calculatedU % product.uxp);

    // Change ajuste P
    $calculatedP = Math.floor((product.calculatedP + $calculatedU) / product.uxp);
    console.log($calculatedP);
    product.calculatedP += $calculatedP;
    $scope.productControllerObj.calculatedP += $calculatedP;

    console.log(product);
  };

  $scope.updateDevolutionP = function (product) {
    product.devolutionP = $scope.productControllerObj.devolutionP;
    //console.log(product);
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
    //console.log(product.devolutionU);
  };
};

var expenseController = function ($scope){
  $scope.expenseController = {
    title: "",
    ammount: 0
  };

  $scope.updateAmmount = function ($expense){
    $sum = 0;
    //console.log($scope.expenseController.ammount);
    $expense.ammount = $scope.expenseController.ammount;
  };

  $scope.getTotalExpenses = function (expense){
    $sum = 0;
    angular.forEach(expense, function(expense) {
      $sum += expense.ammount;  
    });
    
    return $sum;
  };
};

app.directive('ngBlur', function() {
  return function( scope, elem, attrs ) {
    elem.bind('blur', function() {
      scope.$apply(attrs.ngBlur);
    });
  };
});


angular.module('numberFilter', []).controller('LiquidationController', ['$scope', function($scope) {
  $scope.val = 1234.56789;
}]);


/*
app.controller("ReviewController", function(){
  this.review = {}; 

  this.addReview = function(review) {
    console.log(review);
    this.review.push(review);
  };

});*/