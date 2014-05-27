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



var secondController = function ($scope){
  // Initialize the model variables
  $scope.firstName = "Bob";
  $scope.middleName = "Al";
  $scope.lastName = "Smith";

  // Define utility functions
  $scope.getFullName = function ()
  {
    return $scope.firstName + " " + $scope.middleName + " " + $scope.lastName;
  };
};


function ControllerZero($scope, sharedService) {
    $scope.handleClick = function(msg) {
        sharedService.prepForBroadcast(msg);
    };
        
    $scope.$on('handleBroadcast', function() {
        $scope.message = sharedService.message;
    });        
}

function ControllerOne($scope, sharedService) {
    $scope.$on('handleBroadcast', function() {
        $scope.message = 'ONE: ' + sharedService.message;
    });        
}

function ControllerTwo($scope, sharedService) {
    $scope.$on('handleBroadcast', function() {
        $scope.message = 'TWO: ' + sharedService.message;
    });
}

ControllerZero.$inject = ['$scope', 'mySharedService'];        
        
ControllerOne.$inject = ['$scope', 'mySharedService'];

ControllerTwo.$inject = ['$scope', 'mySharedService'];



var lineList = [
  {
    name: 'mix',
    totalAmmount: 0,
    products: [
      {
        vol: '3l',
        name: 'blueberry',
        price: 5.5,
        previousDayP: 1,
        previousDayU: 1,
        chargeP: 2,
        chargeU: 2,
        chargeExtraP: 3,
        chargeExtraU: 3,
        chargeTotalP: 100,
        chargeTotalU: 100,
        devolutionsP: 0,
        devolutionsU: 0,
        prestamosP: 0,
        prestamosU: 0,
        bonosP: 0,
        bonosU: 0,
        ventaP: 0,
        ventaU: 0, 
        totalAmmount: 1000   
      },
      {
        vol: '3l',
        name: 'berry',
        price: 10.5,
        previousDayP: 0,
        previousDayU: 0,
        chargeP: 0,
        chargeU: 0,
        chargeExtraP: 0,
        chargeExtraU: 0,
        chargeTotalP: 100,
        chargeTotalU: 100,
        devolutionsP: 0,
        devolutionsU: 0,
        prestamosP: 0,
        prestamosU: 0,
        bonosP: 0,
        bonosU: 0,
        ventaP: 0,
        ventaU: 0, 
        totalAmmount: 1000   
      },
      {
        vol: '3l',
        name: 'pina colada',
        price: 15.5,
        previousDayP: 0,
        previousDayU: 0,
        chargeP: 0,
        chargeU: 0,
        chargeExtraP: 0,
        chargeExtraU: 0,
        chargeTotalP: 100,
        chargeTotalU: 100,
        devolutionsP: 0,
        devolutionsU: 0,
        prestamosP: 0,
        prestamosU: 0,
        bonosP: 0,
        bonosU: 0,
        ventaP: 0,
        ventaU: 0, 
        totalAmmount: 1000   
      }
    ]
  },
]










/* Nested */

/*
var firstControllerScope = function ($scope){
  // Initialize the model variables
  $scope.firstName = "John";
};

var secondControllerScope = function ($scope){
  // Initialize the model variables
  $scope.lastName = "Doe";
  // Define utility functions
  $scope.getFullName = function (){
    return $scope.firstName + " " + $scope.lastName;
  };
};

var thirdControllerScope = function ($scope){
  // Initialize the model variables
  $scope.middleName = "Al";
  $scope.lastName = "Smith";

  // Define utility functions
  $scope.getFullName = function (){
    return $scope.firstName + " " + $scope.middleName + " " + $scope.lastName;
  };
};

*/

var firstControllerObj = function ($scope){
  // Initialize the model object
  $scope.firstModelObj = {
    firstName: "John"
  };
};

var secondControllerObj = function ($scope)
{
  // Initialize the model object
  $scope.secondModelObj = {
    lastName: "Doe"
  };

  // Define utility functions
  $scope.getFullName = function ()
  {
    return $scope.firstModelObj.firstName + " " +
      $scope.secondModelObj.lastName;
  };
};

var thirdControllerObj = function ($scope)
{
  // Initialize the model object
  $scope.thirdModelObj = {
    middleName: "Al",
    lastName: "Smith"
  };

  // Define utility functions
  $scope.getFullName = function ()
  {
    return $scope.firstModelObj.firstName + " " +
      $scope.thirdModelObj.middleName + " " +
      $scope.thirdModelObj.lastName;
  };
};