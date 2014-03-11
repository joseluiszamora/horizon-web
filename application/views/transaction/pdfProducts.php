<style type="text/css">
  strong{
    color: #000;
  }
  table{
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-collapse: separate;
    border-color: #DDDDDD #DDDDDD #DDDDDD -moz-use-text-color;
    border-radius: 4px 4px 4px 4px;
    border-style: solid solid solid none;
    border-width: 1px 1px 1px 0;   
  }
  .tablebig{

  }

  .maintable tbody tr th {

    background-color: #F9F9F9;
    border-bottom: 1px solid #DDDDDD;
  }
  .maintable tbody tr td{

    background-color: #FFFFFF;
    border-bottom: 1px solid #DDDDDD;
  }
  
  .headerTitle{
    
   }
    .el1{
      width: 100px;  
    }
    .el2{
      width: 100px;  
    }
    .el3{
      width: 100px;  
    }
    .el4{
      width: 140px;  
    }


    .t_1{
      width: 50px;  
      float: left;
    }
    .t_2{
      width: 50px;  
      float: left;
    }
    .t_3{
      width: 50px;  
      float: left;
    }
    .t_4{
      width: 50px;  
      float: left;
    }

.trix{
  width: 500px;
  background-color: #000;
}
.align-right{
  text-align: right !important;
}
</style>

<table class="maintable" style="width: 960px !important;">
  <thead>
    <tr>
      <th># Trans.</th>
      <th>Usuario</th>
      <th>Fechas</th>
      <th>Cod Cli</th>
      <th>Nombre</th>
      <th>Subzona</th>
      <th >Producto</th>
      <th >Cantidad</th>
    
      <th >Importe</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $totalTransactionPrice = 0;
    foreach ($transactions as $row) { 
    ?>
      <tr style="border-bottom: 1px solid #DDDDDD !important;">
        <td class="text-info el1"><strong><?php echo $row->idTransaction; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $this->Account_Model->get_initials_by_email($row->user); ?></td>
        <td class="text-info el2">
          <?php
            $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
            foreach ($Blog as $rowBlog){
              echo "<strong>Inicio: </strong>".$rowBlog->FechaHoraInicio."<br>";
              echo "<strong>Finalizacion: </strong>".$rowBlog->FechaHoraFin."<br>";
              echo "<strong>Duracion: </strong>".$this->Transaction_Model->dateDiff($rowBlog->FechaHoraInicio, $rowBlog->FechaHoraFin)."<br>";

              $FechaHoraInicio = $rowBlog->FechaHoraInicio;
              $FechaHoraFin = $rowBlog->FechaHoraFin;
              $codeBlog = $rowBlog->idBlog;

              $coordinateStart = explode(";", $rowBlog->CoordenadaInicio);
              $coordinateFinish = explode(";", $rowBlog->CoordenadaFin);
            }
          ?>
        </td>
        <td class="text-info el3"><?php echo $row->codecustomer; ?></td>
        <td class="text-info el4"><?php echo $row->customer; ?></td>
        <td class="text-info el5"><?php echo $this->Area_Model->get_area_name($row->idSubZona); ?></td>
        
        <td colspan="4">
          <div class="">


            <table class="subTable" style="width: 320px !important;border:0 !important;">
              <tbody>
                <?php     
                  $transdetail = $this->Detailtransaction_Model->get_actives($row->idTransaction);
                  $totalPrice = 0;
                  foreach ($transdetail as $row_product) {
                    $partialPrice = ($row_product->Cantidad * $row_product->precio);
                    $totalPrice += $partialPrice;
                    $totalTransactionPrice+= $partialPrice;
                ?>  


                  <tr>
                    <td  class=""><?php echo $row_product->productName; ?></td>
                    <td  class=" align-right"><?php echo $row_product->Cantidad; ?></td>

                   
                    <td  class=" align-right"><?php echo $this->Transaction_Model->roundnumber($partialPrice, 2); ?></td>
                  </tr>
                <?php }
                  if($totalPrice > 0){
                ?>
                  <tr>
                    <td style="border:0; background-color: #DDD;text-align:right;border:0;" colspan="2"><strong>PRECIO TOTAL Bs:</strong></td>
                    <td style="border:0; background-color: #DDD;color: #000;border:0;border:0;" class="text-info align-right"><strong><?php echo $this->Transaction_Model->roundnumber($totalPrice, 2); ?></strong></td>
                  </tr>
                <?php
                  }
                 ?>



              </tbody>
            </table>


          </div>
        </td>
      </tr>
    <?php } ?>

    <tr style="margin-top:50px;">
      <td style="border:0; background-color: #DDD;text-align:right;border:0;" colspan="9"><strong>TOTAL TRANSACCIONES:</strong></td>
      <td style="border:0; background-color: #DDD;color: #000;border:0;border:0;" class="text-info align-right"><strong><?php echo count($transactions); ?></strong></td>
    </tr>

    <tr>
      <td style="border:0; background-color: #DDD;text-align:right;border:0;" colspan="9"><strong>TOTAL IMPORTE Bs:</strong></td>
      <td style="border:0; background-color: #DDD;color: #000;border:0;border:0;" class="text-info align-right"><strong><?php echo $this->Transaction_Model->roundnumber($totalTransactionPrice, 2); ?></strong></td>
    </tr>
  </tbody>
</table>


<h2>PRODUCTOS</h2>

<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Nombre</th>
      <th>Linea Volumen</th>
      <th style="text-align:center;">Cantidad</th>
      <th>P.U.</th>
      <th>TOTAL</th>
    </tr>
  </thead>
  <tbody>
    <?php
      //print_r($sum_products);
      //$sum_products->Total
      //$price = 0;
      foreach ($data_products as $row){
        //$partialprice = $row->Cantidad * $row->Total;
        //$price += $partialprice;
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idProduct; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->Nombre; ?></td>
        <td class="text-info districtDesc"><?php echo $row->line." - ".$row->volume; ?></td>
        <td class="text-info districtDesc" style="text-align:center;"><?php echo $row->Cantidad; ?></td>
        <td class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($row->PrecioUnit, 2); ?></td>
        <td class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber(($row->Total), 2); ?></td>
      </tr>
    <?php
      }
    ?>
      <tr>
        <td colspan="5" class="text-info districtDesc align-right"><strong style="float:right;">TOTAL Bs</strong></td>
        <td class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($sum_products[0]->Total, 2); ?></td>
      </tr>
  </tbody>
</table>
