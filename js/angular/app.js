(function(){
  var url = "http://localhost/horizon/index.php/";

  var app = angular.module('liquidation', []);

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

})();