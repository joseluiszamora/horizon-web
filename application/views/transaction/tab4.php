
<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio Unitario (Bs)</th>
      <th>Precio Total (Bs)</th>
      <th>Estado</th>
      <th>Observaciones</th>      
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php 
      $totalPrice = 0;
      foreach ($transdetail as $row) {

     // if ( $row->Estado == '1') {
        $partialPrice = ($row->Cantidad * $row->precio);

        $totalPrice += $partialPrice;
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->productName; ?></strong></td>
        <td class="text-info districtDesc" style="text-align:center;"><?php echo $row->Cantidad; ?></td>
        <td class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($row->precio, 2); ?></td>
        <td class="text-info districtDesc align-right"><?php echo $this->Transaction_Model->roundnumber($partialPrice, 2); ?></td>
        <td class="text-info districtDesc"><?php 
          if($row->Estado == "1")
            echo "Prevendido"; 
          if($row->Estado == "2")
            echo "<span style='color: green;'>Distribuido</span>"; 
          if($row->Estado == "3")
            echo "Venta Directa"; 
          if($row->Estado == "4")
            echo "<span style='color: red;'>Cancelado</span>";            
            
        ?></td>
        <td class="text-info districtDesc"><?php echo $row->Observacion; ?></td>
        <td>
          <div class="btnActionsForm">
            <?php 
              //if($row->Estado != "3")
              if(($this->Account_Model->get_profile() == "1") || ($conciliado == "1")){
                echo anchor('detailtransaction/delete/'.$row->idTransaction."/".$row->idProduct, 'Eliminar', array('class' => 'btn btn-info'));
              }
            ?>
          </div>
        </td>
      </tr>      
    <?php 
     // }
    } ?>
      <tr>
        <td colspan="3" class="text-info districtDesc" style="text-align:right;"><strong>PRECIO TOTAL Bs:</strong></td>
        <td class="text-info districtDesc align-right"><strong><?php echo $this->Transaction_Model->roundnumber($totalPrice, 2); ?></strong></td>
        <td colspan="2" class="text-info districtDesc">&nbsp;</td>
      </tr>
  </tbody>
</table> 