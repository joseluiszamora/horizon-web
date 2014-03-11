<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo de Transaccion</th>
      <th>Creado Por</th>
      <th>Cliente</th>
      <th>Codigo de Cliente</th>
      <th>Fecha</th>
      <th>Estado</th>
      <th>Observaciones</th>
      <th>&nbsp;</th> 
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($transaction as $row) {
     // print_r($row);
        // get datetime coordinate
        $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
        //print_r($Blog);
        $timeStart = "";
        $timeFinish = "";
        foreach ($Blog as $rowBlog){
          if($rowBlog->Operation == "Venta Directa" || $rowBlog->Operation == "Preventa" || $rowBlog->Operation == "Transaccion 0" || $rowBlog->Operation == "venta_directa" || $rowBlog->Operation == "preventa" || $rowBlog->Operation == "transaccion_0"){
            $timeStart = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          }
        }
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idTransaction; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->user; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->customer; ?></td>
        <td class="text-info districtDesc"><?php echo $row->codecustomer; ?></td>

        <td class="text-info districtDesc"><?php echo $timeStart; ?></td>
        
        <td class="text-info districtDesc"><?php 
          if($row->Estado == "1")
            echo "Preventa";
          //if($row->Estado == "2")
          //  echo "Conciliado"; 
          if($row->Estado == "3")
            echo "Distribuidas"; 
          if($row->Estado == "4")
            echo "Canceladas"; 
          if($row->Estado == "5")
            echo "Transaccion Temporal";
          if($row->Estado == "6")
            echo "Venta Directa";
          if($row->Estado == "7")
            echo "Transaccion0";
        ?></td>

         <td class="text-info districtDesc"><?php 
         echo $row->Observacion;
         //echo date('Y-m-d', strtotime($row->FechaHoraInicio));

        // echo date("Y", $row->FechaHoraInicio); 
        //echo $row->FechaHoraInicio; 
        //echo $row->FechaHoraFin; 
         ?></td>

        <td class="grid_4">
          <div class="btnActionsForm2">
            <?php echo anchor('transaction/products/'.$row->idTransaction, 'Productos', array('class' => 'btn btn-info')); ?>
          </div>
        </td>
      </tr>      
    <?php } ?>
  </tbody>
</table> 