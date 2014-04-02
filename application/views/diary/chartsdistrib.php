<script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/data.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>




<script type="text/javascript">
  $(function () {
       $('#containerchart').highcharts({
          title: {
            text: 'Prestamos por distribuidor',
            x: -20 //center
          },
          subtitle: {
            text: 'ultimos 12 meses',
            x: -20
          },
          xAxis: {
            categories: ['Ago', 'Sep', 'Oct', 'Nov', 'Dic', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul']
          },
          yAxis: {
            title: {
                text: 'Monto (Bs.)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
          },
          tooltip: {
            valueSuffix: '°C'
          },
          legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
          },
          series: [{
            name: 'erivero',
            data: [705.0, 605.9, 905.5, 1405.5, 1805.2, 2105.5, 2505.2, 2605.5, 2305.3, 1805.3, 1305.9, 96]
          }, {
            name: 'esantacruz',
            data: [130.2, 130.8, 135.7, 1131.3, 1137.0, 2132.0, 2134.8, 2134.1, 2130.1, 1134.1, 138.6, 2.5]
          }, {
            name: 'fmarquez',
            data: [1260.9, 1260.6, 1263.5, 1268.4, 1613.5, 1287.0, 1218.6, 1267.9, 1214.3, 1269.0, 1263.9, 1888.0]
          }, {
            name: 'jpozo',
            data: [3368.9, 3390.2, 2080.7, 2050.5, 2000.9, 1800.2, 1900.0, 2000.6, 2939.2, 3000.3, 3030.6, 2900.8]
          }, {
            name: 'melias',
            data: [2230.9, 2530.2, 2260.7, 2030.5, 2330.9, 2330.2, 2330.0, 2930.6, 2330.2, 2330.3, 2330.6, 2340.8]
          }, {
            name: 'itinini',
            data: [1567.9, 1543.2, 1948.7, 1968.5, 1284.9, 1940.2, 1000.0]
          }, {
            name: 'vsossa',
            data: [2359.9, 2958.2, 2038.7, 2929.5, 2095.9, 2020.2, 2492.0, 2458.6, 2929.2, 2847.3, 2282.6, 2295.8]
          }, {
            name: 'rcoria',
            data: [1045.9, 1491.7, 1232.7, 1403.5, 1009.9, 1003.2, 1029.0]
          }]
        });
    });
    

</script>

<div class="row" style="overflow:hidden;">
  <div class="container formContainer logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4">Diario</h2>
      </div>
    </div>
  </div>

  <div class="container formContainer">
    <div class="span10 offset1">
      <div class="block_content row">
        <div id="containerchart" style="min-width: 500px; height: 500px; margin: 0 auto"></div>    
      </div>
    </div>
  </div>

</div>