<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Monto</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ranks as $row) { ?>
      <tr>
        <td class="text-info areaDesc"><strong><?php echo $this->Diary_Model->roundnumber($row->Limit, 2); ?></strong></td>
        <td>
          <?php 
            if($this->Account_Model->get_profile() == '1'){
          ?>
          <div class="btnActionsForm">
            <!-- Button to trigger modal -->
            <a href="<?php echo '#modal-'.$row->idrank ?>" role="button" class="btn btn-primary" data-toggle="modal">Eliminar</a>

            <!-- Modal -->
            <div id="<?php echo 'modal-'.$row->idrank ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Eliminar Rango</h3>
              </div>
              <div class="modal-body">
                <p>Esta seguro que desea Eliminar este Rango?</p>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <?php echo anchor('rank/delete/'.$row->idrank, 'Eliminar', array('class' => 'btn btn-primary')); ?>
              </div>
            </div>

          </div>
          <?php            
          }
          ?> 
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>