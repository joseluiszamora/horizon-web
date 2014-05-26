(function(){
  var app = angular.module('liquidation', []);

  app.controller('LiquidationController', function(){
    this.lines = lineList;
  });

  var lineList = [
    {
      name: 'mix',
      totalAmmount = 0,
      products: [
        {
          vol: '3l',
          name: 'blueberry',
          previousDayP: 0,
          previousDayU: 0,
          chargeP: 0,
          chargeU: 0,
          chargeExtra: [
            {P: '2'},
            {C: '2'}
          ],
          devolutionsP: 0,
          devolutionsU: 0,
          prestamosP: 0,
          prestamosU: 0,
          bonosP: 0,
          bonosU: 0,
          totalSold: [
            {P: '2'},
            {C: '2'}
          ]    
        },
        {
          vol: '3l',
          name: 'berry',
          previousDayP: 0,
          previousDayU: 0,
          chargeP: 0,
          chargeU: 0,
          chargeExtra: [
            {P: '2'},
            {C: '2'}
          ],
          devolutionsP: 0,
          devolutionsU: 0,
          prestamosP: 0,
          prestamosU: 0,
          bonosP: 0,
          bonosU: 0,
          totalSold: [
            {P: '2'},
            {C: '2'}
          ]    
        },
        {
          vol: '3l',
          name: 'pina colada',
          previousDayP: 0,
          previousDayU: 0,
          chargeP: 0,
          chargeU: 0,
          chargeExtra: [
            {P: '2'},
            {C: '2'}
          ],
          devolutionsP: 0,
          devolutionsU: 0,
          prestamosP: 0,
          prestamosU: 0,
          bonosP: 0,
          bonosU: 0,
          totalSold: [
            {P: '2'},
            {C: '2'}
          ]    
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