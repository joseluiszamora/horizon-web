<?php
  print_r(">>>> ".count($line));
  echo "<br><br><br><br>";
  print_r($line);

  print_r($volume);
  echo "<br><br><br><br>";
  print_r($linevolume);
  echo "<br><br><br><br>";
  print_r($product);
  
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">CARGA DE PRODUCTOS</h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading"> INPUT </div>

        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>LINEA</th>
                  <th>VOL</th>
                  <th>PRODUCTO</th>
                  <th>PRECIO (Bs.)</th>
                  <th>CARGA P</th>
                  <th>CARGA U</th>
                  <th>TOTAL</th>
                </tr>
              </thead>
            </table>
            <?php foreach ($line as $rowline) { ?>
              <table class="table table-bordered table-hover">
                <tbody>
                  <?php
                    print_r($rowline);
                    print_r("<br><br><br>");
                    $volumes = $this->Linevolume_Model->get_volumes_from_line($rowline->idLine);
                    //echo count($volumes);
                    print_r($volumes);
                  ?>
                  <?php foreach ($volumes as $rowvolumes) { ?>
                    <?php 
                      foreach ($this->Product_Model->get_by_linevolume($rowvolumes->idLineVolume) as $rowproduct) { 
                    ?>
                      <tr>
                        <td colspan="<?php echo count($this->Linevolume_Model->get_volumes_from_line($rowline->idLine))?>"><?php echo $rowline->Descripcion; ?></td>
                        <td><?php echo $rowvolumes->Descripcion; ?></td>
                        <td><?php echo $rowproduct->Nombre; ?></td>
                        <td><?php echo $rowproduct->PrecioUnit; ?></td>
                        <td><?php echo $rowproduct->idLine; ?></td>
                        <td><?php echo $rowproduct->idVolume; ?></td>
                        <td>qq</td>
                        <td>qq</td>
                      </tr>
                    <?php } ?>
                  <?php } ?>
                </tbody>
              </table>
            <?php } ?>
            
            <table class="table table-bordered table-hover">
              <tfoot>
                <tr>
                  <th colspan=4>&nbsp;</th>
                  <th>100</th>
                  <th>200</th>
                  <th>300</th>
                </tr>
              </tfoot>
            </table>

          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
    <div class="panel panel-default">
      <div class="panel-heading"> TOTALES</div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>VENTA</th>
                <th>COBRO</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>444.00</td>
                <td>999.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>