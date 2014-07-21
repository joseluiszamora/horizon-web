<script src="http://d3js.org/d3.v3.min.js"></script>
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
  <div id="body">
    <div id="chart"></div>
  </div>

  <div id="barchart"></div>
</div>


<script src="<?php echo base_url(); ?>js/d3js/script.js"></script>
<script src="<?php echo base_url(); ?>js/d3js/barchart.js"></script>
