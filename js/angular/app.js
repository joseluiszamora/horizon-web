(function(){
  var app = angular.module('liquidation', []);

  app.controller('LiquidationController', function(){
    this.lines = lineList;
    this.name = 'qwerty';
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


  var productsList= [
    {
      line: 'mix',
      vol: '3l',
      name: 'blueberry',
      previousDay: [
        {P: '1'},
        {C: '1'}
      ],
      charge: [
        {P: '2'},
        {C: '2'}
      ],
      chargeExtra: [
        {P: '2'},
        {C: '2'}
      ],
      devolutions: [
        {P: '2'},
        {C: '2'}
      ],
      prestamos: [
        {P: '2'},
        {C: '2'}
      ],
      bonos: [
        {P: '2'},
        {C: '2'}
      ],
      totalSold: [
        {P: '2'},
        {C: '2'}
      ],
    },
    {
      line: 'mix',
      vol: '3l',
      name: 'blueberry',
      previousDay: [
        {P: '1'},
        {C: '1'}
      ],
      charge: [
        {P: '2'},
        {C: '2'}
      ],
      chargeExtra: [
        {P: '2'},
        {C: '2'}
      ],
      devolutions: [
        {P: '2'},
        {C: '2'}
      ],
      prestamos: [
        {P: '2'},
        {C: '2'}
      ],
      bonos: [
        {P: '2'},
        {C: '2'}
      ],
      totalSold: [
        {P: '2'},
        {C: '2'}
      ],
    },
    {
      line: 'mix',
      vol: '3l',
      name: 'blueberry',
      previousDay: [
        {P: '1'},
        {C: '1'}
      ],
      charge: [
        {P: '2'},
        {C: '2'}
      ],
      chargeExtra: [
        {P: '2'},
        {C: '2'}
      ],
      devolutions: [
        {P: '2'},
        {C: '2'}
      ],
      prestamos: [
        {P: '2'},
        {C: '2'}
      ],
      bonos: [
        {P: '2'},
        {C: '2'}
      ],
      totalSold: [
        {P: '2'},
        {C: '2'}
      ],
    }
  ]
})();