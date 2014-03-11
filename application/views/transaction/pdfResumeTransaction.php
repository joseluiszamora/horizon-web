<style type="text/css">
  strong{
    color: #000;
  }
</style>

<!--<h2>CLIENTES</h2>

<table class="tableHorizon table table-bordered table-striped" style="width:500px; margin: 0 auto;">
  <tbody>
    <tr>
      <td class="text-info districtDesc"><strong>TOTAL CLIENTES ZONA</strong></td>
      <td class="text-info districtDesc"><?php // echo $clients_by_area; ?></td>
    </tr>   
    <tr>
      <td class="text-info districtDesc"><strong>CLIENTES VISITADOS</strong></td>
      <td class="text-info districtDesc">652</td>
    </tr>

    <?php
      //foreach ($data_trans as $row){
    ?>
      <tr>
      <td class="text-info districtDesc" style="text-align:right;"><strong style="text-transform:uppercase;"><?php
     /* if($row->Estado == '1')
        echo 'Prevendido';
      if($row->Estado == '2')
        echo 'Conciliado';
      if($row->Estado == '3')
        echo 'Distribuido';
      if($row->Estado == '4')
        echo 'Cancelado';
      if($row->Estado == '5')
        echo 'Temporal';
      if($row->Estado == '6')
        echo 'Venta Directa';
      if($row->Estado == '7')
        echo 'Transaccion 0';*/

      ?></strong></td>
      <td class="text-info districtDesc"><?php //echo $row->co; ?></td>
    </tr>
    <?php
     // }
    ?>
  </tbody>
</table>
-->

<h2>PRODUCTOS</h2>

<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Nombre</th>
      <th>Linea Volumen</th>
      <th style="text-align:center;">Cantidad</th>
      <th style="text-align:center;">P.U.</th>
      <th style="text-align:center;">TOTAL</th>
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
        <td style="text-align:right;" class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($row->PrecioUnit, 2); ?></td>
        <td style="text-align:right;" class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber(($row->Total), 2); ?></td>
      </tr>
    <?php
      }
    ?>
      <tr>
        <td colspan="5" class="text-info districtDesc align-right"><strong style="float:right;">TOTAL Bs</strong></td>
        <td  style="text-align:right;" class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($sum_products[0]->Total, 2); ?></td>
      </tr>
  </tbody>
</table>



<h2>LINEAS</h2>

<table class="tableHorizon table table-bordered table-striped" style="width:800px; margin: 0 auto;">
  <thead>
    <tr>
      <th>Linea</th>
      <th>Volumen</th>
      <th style="text-align:center;">Cantidad</th>
      <th style="text-align:center;">TOTAL</th>
    </tr>
  </thead>
  <tbody>
     <?php
     //print_r($data_lines);
     // $price = 0;
     
      foreach ($data_lines as $row){
        //$partialprice = $row->cantidad * $row->precio;
        //$price += $partialprice;
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->line; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->volume; ?></td>
        <td class="text-info districtDesc" style="text-align:center;"><?php echo $row->TotalProd; ?></td>
        <td style="text-align:right;" class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($row->Total, 2); ?></td>
      </tr>
    <?php
      }
    ?>
      <tr>
        <td colspan="3" class="text-info districtDesc align-right"><strong style="float:right;">TOTAL Bs</strong></td>
        <td class="text-info districtDesc align-right" style="text-align:right;"><?php echo $this->Transaction_Model->roundnumber($sum_products[0]->Total, 2); ?></td>
      </tr>
  </tbody>
</table>