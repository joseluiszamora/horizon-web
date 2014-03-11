<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo de Transaccion</th>
      <th>Creado Por</th>
      <th>Cliente</th>
      <th>Codigo de Cliente</th>
      <th>Fecha</th>
      <th>Observaciones</th>
      <th>&nbsp;</th> 
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($transaction as $row) {
      if ( $row->Estado == '1' OR $row->Estado == '2') {
        $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
        $timeStart = "";
        $timeFinish = "";
        foreach ($Blog as $rowBlog){

          if($rowBlog->Operation == "creacion" || $rowBlog->Operation == "Preventa" || $rowBlog->Operation == "preventa"){
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
                
        <td class="text-info districtDesc"><?php echo $row->Observacion; ?></td>

        <td class="grid_4">
          <div class="btnActionsForm2">
            <?php echo anchor('transaction/edit/'.$row->idTransaction, 'Editar', array('class' => 'btn btn-info')); ?>
            <?php echo anchor('transaction/products/'.$row->idTransaction, 'Productos', array('class' => 'btn btn-info')); ?>

            <?php  if($this->Account_Model->get_profile() == "1" ){ ?>
            <!-- Button to trigger modal -->
            <a href="<?php echo '#modal-'.$row->idTransaction ?>" role="button" class="btn btn-primary" data-toggle="modal">Cancelar</a>
             
            <!-- Modal -->
            <div id="<?php echo 'modal-'.$row->idTransaction ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Cancelar Transaccion</h3>
              </div>
              <div class="modal-body">
                <p>Esta seguro que desea Cancelar esta transaccion ?</p>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
                <?php echo anchor('transaction/cancel/'.$row->idTransaction, 'Si', array('class' => 'btn btn-primary')); ?>
              </div>
            </div>
            <?php } ?>
          </div>
        </td>
      </tr>      
    <?php 
      }
    } ?>
  </tbody>
</table> 