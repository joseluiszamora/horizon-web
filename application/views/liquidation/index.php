<script src="<?php echo base_url(); ?>js/highcharts/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/highcharts/exporting.js"></script>

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Estadísticas</h3>
  </div>
</div>

<div class="no-gutter row">
  <!-- left side column -->
  <div class="col-md-2">
    <div class="panel panel-default" id="sidebar">
      <div class="panel-heading"><b>Tipos de Grafico</b></div> 
      <div class="panel-body">
        <ul class="nav nav-stacked">
          <li><b>Ventas</b></li>
          <li><a href="#">Ventas por Producto</a></li>
          <li><a href="#">Ventas por Distribuidor</a></li>
          <li><a href="#">Ventas por Linea</a></li>
          <li><a href="#">Ventas por Ruta</a></li>
          <li><b>Bonificaciones</b></li>
          <li><b>Excepciones</b></li>
          <li><b>Liquidaciones</b></li>
        </ul>
      </div><!--/panel body-->
    </div><!--/panel-->
  </div><!--/end left column-->
            
  <!--mid column-->
  <div class="col-md-10">
    <div class="panel panel-default" id="midCol">
      <div class="panel-heading"><b>Ventas por Producto</b></div> 
      <div class="panel-body">
        qwerty
      </div> 
    </div><!--/panel-->
  </div><!--/end mid column-->
  
  <!-- right content column-->
  <div class="col-md-10" id="content">
    <div class="panel panel-default">
      <div class="panel-heading"><b>Grafico</b></div>
      <div class="panel-body">
        <div id="charter" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      </div>
    </div>
  </div> 
</div>


<script type="text/javascript">
  $(function () {
    $('#charter').highcharts({
        title: {
            text: 'Monthly Average Temperature',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: WorldClimate.com',
            x: -20
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
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
            name: 'Tokyo',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
            name: 'New York',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }, {
            name: 'Berlin',
            data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
        }, {
            name: 'London',
            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        }]
    });
});
</script>