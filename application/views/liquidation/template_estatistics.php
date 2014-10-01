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
  
  <?php
    $this->load->view("liquidation/".$section);
  ?>
</div>