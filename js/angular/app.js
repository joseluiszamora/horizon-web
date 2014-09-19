//var url = "http://localhost/horizon/index.php/";
var url = "https://mariani.bo/horizon-sc/index.php/";

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

  liquidation.mark = $("#markLiquidation").html();
  liquidation.idLiquidation = $("#idLiquidation").html();

  if (liquidation.mark == "completado") {
    $http.get(url + 'liquidation/get_expenses/' + liquidation.idLiquidation).success(function(data){
      liquidation.expenses = data;
    });
  }else{
    liquidation.expenses = [
      { "title" : "refrigerios", "ammount" : 0 },
      { "title" : "gasolina", "ammount" : 0 }
    ];
    liquidation.cobros = [];
  };


  if (liquidation.mark == "liquidation") {
    $http.get(url + 'liquidation/get_cobros/' + liquidation.idLiquidation).success(function(data){
      liquidation.cobros = data;
    });
  }else{
    liquidation.cobros = [];
  }
  /*liquidation.cobros = [
    { "recibo" : "1111", "ammount" : 20 },
    { "recibo" : "2222", "ammount" : 80 }
  ];*/

  $http.get(url + 'liquidation/get_lines/' + liquidation.idLiquidation).success(function(data){
    liquidation.lines = data;
  });

  this.addExpense = function (val) {
    liquidation.expenses.push({ "title" : val.title, "ammount" : 0 });
    $("#expenseFormTitle").val("");
  };

  function ckeckIfSave($mark, $lines){
    $flag = false;

    switch($mark) {
      case "creado":
        angular.forEach($lines, function(line) {
          angular.forEach(line.products, function(product) {
            if (product.chargeP > 0 && product.chargeU > 0)
              $flag = true;
          });
        });
        break;
      case "cargado":
        break;
      case "cargaextra1":
        break;
      case "cargaextra2":
        break;
      case "liquidation":
        break;
      default:
    }

    return $flag;
  }

  this.saveAll = function () {
    //console.log(liquidation.expenses);
    $mark = $("#markLiquidation").html();
    //console.log(ckeckIfSave($mark, liquidation.lines));
    $("#btnsave").prop( "disabled", true );
    var datasend = {
      lines: liquidation.lines,
      expenses: liquidation.expenses,
      liquidation: $("#idLiquidation").html(),
      mark: $("#markLiquidation").html()
    };
    //console.log(datasend.lines);
    $http.post(url + 'liquidation/save_lines', datasend).success(
      function (data, status, headers){
      window.location = url + "liquidation/charge_list";
      //console.log(data);
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
    angular.forEach(liquidation.cobros, function(expense) {
      $sum += expense.ammount;
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
      //$sumCargaExtra2PLine += parseInt(Math.floor(($scope.getCargaExtra2RealULine(products)) / uxpline));
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
    angular.forEach(products, function(product) {
      $sum += product.chargeExtraU2;
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
  // TOTAL CARGADO
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
  // TOTAL AJUSTADO
  $scope.getCalculatedPLine = function (products, uxpline){
    $sum = 0;
    $sum += calculatedTotal(products);

    if (uxpline > 0) {
      $sum = parseInt(Math.floor($sum / uxpline));
    };

    return $sum;
  };
  $scope.getCalculatedULine = function (products, uxpline){
    $sum = 0;
    $sum += calculatedTotal(products);

    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };

    return $sum;
  };

  function calculatedTotal($products){
    $sum = 0;
    angular.forEach($products, function(product) {
      $sum += parseInt(product.calculatedP * product.uxp);
      $sum += product.calculatedU;
    });

    return $sum;
  }

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

  $scope.getPrestamoPLine = function (products, uxpline){
    $sum = 0;
    $sumU = 0;

    angular.forEach(products, function(value) {
      $sum += value.prestamosP;
      $sumU += value.prestamosU;
    });

    if (uxpline > 0) {
      $sum += parseInt(Math.floor($sumU / uxpline));
    }
    
    return $sum;
  };
  
  $scope.getPrestamoULine = function (products, uxpline){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += value.prestamosU;
    });

    if (uxpline > 0) {
      $sum = parseInt(Math.round($sum % uxpline));
    };

    return $sum;
  };

  $scope.getBonoPLine = function (products, uxpline){
    $sum = 0;
    $sumU = 0;

    angular.forEach(products, function(value) {
      $sum += parseInt(value.bonosP);
      $sumU += parseInt(value.bonosU);
    });

    if (uxpline > 0) {
      $sum += parseInt(Math.floor($sumU / uxpline));
    }
    
    return $sum;
  };
  
  $scope.getBonoULine = function (products, uxpline){
    $sum = 0;
    angular.forEach(products, function(value) {
      $sum += parseInt(value.bonosU);
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
    androidP: 0,
    androidU: 0,
    ventaP: 0,
    ventaU: 0,
    totalAmmount: 0
  };

  $scope.getCargaP = function ($product){
    $sum = getTotalP($product, $scope.productControllerObj);
    $sum += parseInt(Math.floor(getTotalU($product, $scope.productControllerObj) / $product.uxp));

    return $sum;
  };

  $scope.getCargaU = function ($product){
    $sum = getTotalU($product, $scope.productControllerObj);
    $sum = parseInt(Math.round($sum % $product.uxp));
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

  $scope.updateCargaExtra1 = function (product) {
    if ($scope.productControllerObj.cargaExtraU1 >= product.uxp) {
      product.chargeExtraU1 = Math.round($scope.productControllerObj.cargaExtraU1 % product.uxp);
      
      product.chargeExtraP1 = $scope.productControllerObj.cargaExtraP1 + Math.floor($scope.productControllerObj.cargaExtraU1 / product.uxp);

      $scope.productControllerObj.cargaExtraP1 = product.chargeExtraP1;
      $scope.productControllerObj.cargaExtraU1 = product.chargeExtraU1;
    }else{
      product.chargeExtraU1 = $scope.productControllerObj.cargaExtraU1;
      product.chargeExtraP1 = $scope.productControllerObj.cargaExtraP1;
    }
  };

  $scope.updateCargaExtra2 = function (product) {
    if ($scope.productControllerObj.cargaExtraU2 >= product.uxp) {
      product.chargeExtraU2 = Math.round($scope.productControllerObj.cargaExtraU2 % product.uxp);

      product.chargeExtraP2 = $scope.productControllerObj.cargaExtraP2 + Math.floor($scope.productControllerObj.cargaExtraU2 / product.uxp);

      $scope.productControllerObj.cargaExtraP2 = product.chargeExtraP2;
      $scope.productControllerObj.cargaExtraU2 = product.chargeExtraU2;
    }else{
      product.chargeExtraU2 = $scope.productControllerObj.cargaExtraU2;
      product.chargeExtraP2 = $scope.productControllerObj.cargaExtraP2;
    }
  };

  $scope.updateCargaExtra3 = function (product) {
    if ($scope.productControllerObj.cargaExtraU3 >= product.uxp) {
      product.chargeExtraU3 = Math.round($scope.productControllerObj.cargaExtraU3 % product.uxp);

      product.chargeExtraP3 = $scope.productControllerObj.cargaExtraP3 + Math.floor($scope.productControllerObj.cargaExtraU3 / product.uxp);

      $scope.productControllerObj.cargaExtraP3 = product.chargeExtraP3;
      $scope.productControllerObj.cargaExtraU3 = product.chargeExtraU3;
    }else{
      product.chargeExtraU3 = $scope.productControllerObj.cargaExtraU3;
      product.chargeExtraP3 = $scope.productControllerObj.cargaExtraP3;
    }
  };

  // venta calculada
  /*
  // adjust ammount
  product.totalAmmount = ((product.ajusteP * product.uxp) + product.ajusteU);
  */
  $scope.calculateSoldP = function ($product) {
    $sum = calculateSold($product, $scope.productControllerObj);
    $sum = parseInt(Math.floor($sum / $product.uxp));
    // set ammount
    $product.calculatedP = $sum;

    return $sum;
  };

  $scope.calculateSoldU = function ($product) {
    $sum = calculateSold($product, $scope.productControllerObj);
    $sum = parseInt(Math.round($sum % $product.uxp));
    // set ammount
    $product.calculatedU = $sum;

    return $sum;
  };

  function calculateSold($product, $objProductScope){
    $sum = 0;
    // sum
    $sum += (getTotalP($product, $objProductScope) * $product.uxp);
    $sum += getTotalU($product, $objProductScope);
    $sum += ($product.ajusteP * $product.uxp);
    $sum += $product.ajusteU;
    // rest
    $sum -= ($product.devolutionP * $product.uxp);
    $sum -= $product.devolutionU;
    $sum -= ($product.prestamosP * $product.uxp);
    $sum -= $product.prestamosU;
    $sum -= ($product.bonosP * $product.uxp);
    $sum -= $product.bonosU;

    return $sum;
  }


  // MONTO TOTAL
  $scope.totalAmmountProduct = function ($product) {
    $total = 0;
    $total += parseInt($product.calculatedP * $product.uxp);
    $total += parseInt($product.calculatedU);
    $total = ($total * parseFloat($product.price));

    $product.totalAmmount = $total;
    return ($total);
  };


  $scope.updateAjuste = function (product){
    if ($scope.productControllerObj.ajusteU >= product.uxp){
      $scope.productControllerObj.ajusteP += parseInt(Math.floor($scope.productControllerObj.ajusteU / product.uxp));

      $scope.productControllerObj.ajusteU = parseInt(Math.round($scope.productControllerObj.ajusteU % product.uxp));
    }
    product.ajusteU = $scope.productControllerObj.ajusteU;
    product.ajusteP = $scope.productControllerObj.ajusteP;
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
  };
};

var expenseController = function ($scope){
  $scope.expenseController = {
    title: "",
    ammount: 0
  };

  $scope.updateAmmount = function ($expense){
    $sum = 0;
    if (!isNaN(parseFloat($expense.ammount)) && isFinite($expense.ammount)){
      $expense.ammount = parseFloat($scope.expenseController.ammount);
    }else{
      $expense.ammount = 0;
    }
  };

  $scope.getTotalExpenses = function (expense){
    $sum = 0;
    angular.forEach(expense, function(expense) {
      $sum += parseFloat(expense.ammount);
    });
    return $sum;
  };

  $scope.getTotalCobros = function (cobro){
    $sum = 0;
    angular.forEach(cobro, function(cobro) {
      $sum += parseFloat(cobro.ammount);
    });
    return $sum;
  };

  $scope.deleteExpense = function (expense){
    console.log(expense);

    var index = $scope.liquidation.expenses.indexOf(expense);
    if (index != -1) {
      $scope.liquidation.expenses.splice(index, 1);
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


angular.module('numberFilter', []).controller('LiquidationController', ['$scope', function($scope) {
  $scope.val = 1234.56789;
}]);


function getTotalU($objProduct, $objProductScope){
  $sum = 0;
  $sum += parseInt($objProduct.previousDayU);

  mark = $("#markLiquidation").html();
  switch(mark) {
  case "creado":
    $sum += parseInt($objProductScope.cargaU);
    break;
  case "cargado":
    $sum += parseInt($objProduct.chargeU);
    $sum += parseInt($objProductScope.cargaExtraU1);
    break;
  case "cargaextra1":
    $sum += parseInt($objProduct.chargeU);
    $sum += parseInt($objProduct.chargeExtraU1);
    $sum += parseInt($objProductScope.cargaExtraU2);
    break;
  case "cargaextra2":
    $sum += parseInt($objProduct.chargeU);
    $sum += parseInt($objProduct.chargeExtraU1);
    $sum += parseInt($objProduct.chargeExtraU3);
    $sum += parseInt($objProductScope.cargaExtraU3);
    break;
  case "liquidation":
    $sum += parseInt($objProduct.chargeU);
    $sum += parseInt($objProduct.chargeExtraU1);
    $sum += parseInt($objProduct.chargeExtraU2);
    $sum += parseInt($objProduct.chargeExtraU3);
    break;
  default:
    $sum += parseInt($objProduct.chargeU);
    $sum += parseInt($objProduct.chargeExtraU1);
    $sum += parseInt($objProduct.chargeExtraU2);
    $sum += parseInt($objProduct.chargeExtraU3);

    $sum += parseInt($objProductScope.cargaU);
    $sum += parseInt($objProductScope.cargaExtraU1);
    $sum += parseInt($objProductScope.cargaExtraU2);
    $sum += parseInt($objProductScope.cargaExtraU3);
  }

  return $sum;
}

function getTotalP($objProduct, $objProductScope){
  $sum = 0;
  $sum += parseInt($objProduct.previousDayP);
  mark = $("#markLiquidation").html();
  switch(mark) {
  case "creado":
    $sum += parseInt($objProductScope.cargaP);
    break;
  case "cargado":
    $sum += parseInt($objProduct.chargeP);
    $sum += parseInt($objProductScope.cargaExtraP1);
    break;
  case "cargaextra1":
    $sum += parseInt($objProduct.chargeP);
    $sum += parseInt($objProduct.chargeExtraP1);
    $sum += parseInt($objProductScope.cargaExtraP2);
    break;
  case "cargaextra2":
    $sum += parseInt($objProduct.chargeP);
    $sum += parseInt($objProduct.chargeExtraP1);
    $sum += parseInt($objProduct.chargeExtraP3);
    $sum += parseInt($objProductScope.cargaExtraP3);
    break;
  case "liquidation":
    $sum += parseInt($objProduct.chargeP);
    $sum += parseInt($objProduct.chargeExtraP1);
    $sum += parseInt($objProduct.chargeExtraP2);
    $sum += parseInt($objProduct.chargeExtraP3);
    break;
  default:
    $sum += parseInt($objProduct.chargeP);
    $sum += parseInt($objProduct.chargeExtraP1);
    $sum += parseInt($objProduct.chargeExtraP2);
    $sum += parseInt($objProduct.chargeExtraP3);

    $sum += parseInt($objProductScope.cargaP);
    $sum += parseInt($objProductScope.cargaExtraP1);
    $sum += parseInt($objProductScope.cargaExtraP2);
    $sum += parseInt($objProductScope.cargaExtraP3);
  }
  return $sum;
}


/*
app.controller("ReviewController", function(){
  this.review = {}; 

  this.addReview = function(review) {
    console.log(review);
    this.review.push(review);
  };

});*/