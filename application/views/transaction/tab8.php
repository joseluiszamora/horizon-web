<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo anchor('transaction/index/idTransaction', 'Codigo de Transaccion' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('transaction/index/user', 'Creado Por' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('transaction/index/customer', 'Cliente' , array('class' => 'newLinkTables')); ?></th>
      <th>Codigo de Cliente</th>
      <th>Fecha</th>
      <th>Observaciones</th>
      <th>&nbsp;</th> 
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($transaction as $row) { 
      if ( $row->Estado == '7') {

        // get datetime coordinate
        $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
        $timeStart = "";
        $timeFinish = "";
        foreach ($Blog as $rowBlog){
          if($rowBlog->Operation == "Venta Directa" || $rowBlog->Operation == "Preventa" || $rowBlog->Operation == "Transaccion 0" || $rowBlog->Operation == "venta_directa" || $rowBlog->Operation == "preventa" || $rowBlog->Operation == "transaccion_0"){
            $timeStart = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          }
          //if($rowBlog->Operation == "transaccion_entregada" || $rowBlog->Operation == "Transaccion 0" || $rowBlog->Operation == "transaccion entregada" || $rowBlog->Operation == "transaccion_0"){
          //  $timeFinish = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          //}
        }
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idTransaction; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->user; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->customer; ?></td>
        <td class="text-info districtDesc"><?php echo $row->codecustomer; ?></td>
        <td class="text-info districtDesc"><?php echo $timeStart; ?></td>
        <td class="text-info districtDesc"><?php $row->Observacion; ?></td>

        <td class="grid_4">
          <div class="btnActionsForm2">
            <?php echo anchor('transaction/products/'.$row->idTransaction, 'Ver', array('class' => 'btn btn-info')); ?>
          </div>
        </td>
      </tr>      
    <?php 
      }
    } ?>
  </tbody>
</table> 