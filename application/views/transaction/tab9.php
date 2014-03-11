<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo anchor('transaction/index/idTransaction', 'Codigo de Transaccion' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('transaction/index/user', 'Creado Por' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('transaction/index/customer', 'Cliente' , array('class' => 'newLinkTables')); ?></th>
      <th>Codigo de Cliente</th>
      <th>Inicio</th>
      <th>Finalizacion</th>
      <th>Observaciones</th>     
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
          if($rowBlog->Operation == "creacion"){
            $timeStart = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          }
          if($rowBlog->Operation == "entregado"){
            $timeFinish = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          }
        }
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idTransaction; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->user; ?></strong></td>
        <td class="text-info districtDesc"><?php echo $row->customer; ?></td>
        <td class="text-info districtDesc"><?php echo $row->codecustomer; ?></td>
        <td class="text-info districtDesc"><?php echo $timeStart; ?></td>
        <td class="text-info districtDesc"><?php echo $timeFinish; ?></td>
        <td class="text-info districtDesc"><?php echo $row->Observacion; ?></td>
      </tr>      
    <?php 
      }
    } ?>
  </tbody>
</table> 