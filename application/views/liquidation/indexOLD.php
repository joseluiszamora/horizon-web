<?php
/*
  print_r(">>>> ".count($line));
  echo "<br><br><br><br>";
  print_r($line);

  print_r($volume);
  echo "<br><br><br><br>";
  print_r($linevolume);
  echo "<br><br><br><br>";
  print_r($product);
*/
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">CARGA DE PRODUCTOS</h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading"> 
          INPUT

          <?php foreach ($line as $rowlinecheck) { 
            //print_r($rowlinecheck);
          ?>
            <label class="checkbox-inline">
              <input type="checkbox" id="<?php echo $rowlinecheck->idLine;?>" value="<?php echo $rowlinecheck->Descripcion;?>"> <?php echo $rowlinecheck->Descripcion;?>
            </label>
          <?php } ?>
          
        </div>

        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th class="t1">LINEA</th>
                  <th class="t2">VOL</th>
                  <th class="t3">PRODUCTO</th>
                  <th class="t4">PRECIO (Bs.)</th>
                  <th class="t5">CARGA P</th>
                  <th class="t6">CARGA U</th>
                  <th class="t7">TOTAL</th>
                </tr>
              </thead>
            </table>
            <?php foreach ($line as $rowline) { ?>
              <table class="table table-bordered table-hover">
                <tbody>
                  <?php
                    //print_r($rowline);
                    //print_r("<br><br><br>");
                    $volumes = $this->Linevolume_Model->get_volumes_from_line($rowline->idLine);
                    //echo count($volumes);
                    //print_r($volumes);
                  ?>
                  <?php foreach ($volumes as $rowvolumes) { ?>
                    <?php 
                      foreach ($this->Product_Model->get_by_linevolume($rowvolumes->idLineVolume) as $rowproduct) { 
                    ?>
                      <tr>
                        <td class="t1" colspan="<?php echo count($this->Linevolume_Model->get_volumes_from_line($rowline->idLine))?>"><?php echo $rowline->Descripcion; ?></td>
                        <td class="t2"><?php echo $rowvolumes->Descripcion; ?></td>
                        <td class="t3"><?php echo $rowproduct->Nombre; ?></td>
                        <td class="t4"><?php echo $rowproduct->PrecioUnit; ?></td>
                        <td class="t5"><?php echo $rowproduct->idLine; ?></td>
                        <td class="t6"><?php echo $rowproduct->idVolume; ?></td>
                        <td class="t7">qq</td>
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

<style type="text/css">
  .t1{
    width: 120px;  
    float: left;
  }
  .t2{
    width: 80px;  
    float: left;
  }
  .t3{
    width: 255px;  
    float: left;
  }
  .t4{
    width: 110px;  
    float: left;
  }
  .t5{
    width: 110px;  
    float: left;
  }
  .t6{
    width: 110px;  
    float: left;
  }
  .t7{
    width: 88px;  
    float: left;
  }
</style>
<script type="text/javascript">
  var total = 0;
</script>