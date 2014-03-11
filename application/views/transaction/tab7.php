<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo de Transaccion</th>
      <th>Creado Por</th>
      <th>Asignar a:</th>
      <th>Fecha</th>
      <th>Observaciones</th>
      <th>&nbsp;</th> 
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($transaction as $row) { 
      //print_r($transaction);
      if ( $row->Estado == '5') {    
        $Blog = $this->Blog_Model->get_by_transaction($row->idTransaction);
          //print_r($Blog);
          $timeStart = "";
          $timeFinish = "";
          foreach ($Blog as $rowBlog){
          if($rowBlog->Operation == "Venta Directa" || $rowBlog->Operation == "Preventa" || $rowBlog->Operation == "Transaccion 0" || $rowBlog->Operation == "venta_directa" || $rowBlog->Operation == "preventa" || $rowBlog->Operation == "transaccion_0"){
            $timeStart = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          }
          if($rowBlog->Operation == "transaccion_entregada" || $rowBlog->Operation == "Transaccion 0" || $rowBlog->Operation == "transaccion entregada" || $rowBlog->Operation == "transaccion_0"){
            $timeFinish = "De: ".$rowBlog->FechaHoraInicio."<br> Hasta: ".$rowBlog->FechaHoraFin;
          }
        }  
    ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->idTransaction; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->user; ?></strong></td>
        <td class="text-info districtDesc asignementFormContainer">
          <?php
            echo form_open('transaction/asignTo');

            echo form_input(array('name' => 'customerCode', 'class' => 'span2'));
            echo form_hidden('id_transaction', $row->idTransaction);
            echo form_hidden('transactionType', $row->Observacion);
          ?>
          <input class="btn btn-primary" type="submit" name="submit" value="Asignar" />
          <?php 
            echo form_error('customerCode');
            echo form_close();
          ?>
          
        </td>
        <td class="text-info districtDesc"><?php echo $timeStart; ?></td>
        <td class="text-info districtDesc"><?php echo $row->Observacion; ?></td>

        <td class="grid_4">
          <div class="btnActionsForm2">           
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
                <?php echo anchor('transaction/cancel/'.$row->idTransaction, 'Cancelar', array('class' => 'btn btn-primary')); ?>
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



<style type="text/css">
.asignementFormContainer{
  margin: 0 auto;
  width: 300px;
}
.asignementFormContainer input[type='submit']{
  margin-top: -10px;
}
</style>