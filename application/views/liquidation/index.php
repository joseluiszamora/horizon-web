<script src="<?php echo base_url(); ?>js/d3js/d3.min.js"></script>
<script src="<?php echo base_url(); ?>js/d3js/RadarChart.js"></script>
<style>

.bar {
  fill: steelblue;
}

.bar:hover {
  fill: brown;
}

.axis {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.x.axis path {
  display: none;
}

</style>

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Estadísticas</h3>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="form-inline" role="form">
      <div class="form-group col-sm-2">
        <label>Fecha</label>
        <input type="text" name="desde" id="lt-desde" placeholder="Desde" class="" value="01/07/2014"/>
      </div>
      <div class="form-group col-sm-2">
        <input type="text" name="hasta" id="lt-hasta" placeholder="Hasta" class="" value="31/07/2014"/>
      </div>
      <div class="form-group col-sm-2">
        <label>Usuario</label>
        <select class="">
          <option>Usuario 1</option>
          <option>Usuario 2</option>
          <option>Usuario 3</option>
          <option>Usuario 4</option>
        </select>
      </div>
      <div class="form-group col-sm-2">
        <label>Funcionario</label>
        <select class="">
          <option>Funcionario 1</option>
          <option>Funcionario 2</option>
          <option>Funcionario 3</option>
          <option>Funcionario 4</option>
        </select>
      </div>
      <button type="submit" class="">Graficar</button>
    </div>
  </div>

  <div class="col-sm-12">
    <div id="barchart"></div>
  </div>
</div>


<script src="<?php echo base_url(); ?>js/d3js/script.js"></script>
<script src="<?php echo base_url(); ?>js/d3js/barchart.js"></script>
