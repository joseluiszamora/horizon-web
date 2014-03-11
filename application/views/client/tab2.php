<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo de Cliente</th>
      <th>Nombre</th>
      <th>Tipo de Comercio</th>
      <th>Direccion</th>
      <th>Barrio</th>
      <th>Ciudad</th>
      <th>Encargado</th>
      <th>Telefono</th>
      <th>Fecha de Alta</th>
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($clients as $row) {
      if ( $row->Estado === '0') {
    ?>
      <tr>
        <td class="text-info"><strong><?php echo $row->CodeCustomer; ?></strong></td>
        <td><?php echo $row->NombreTienda; ?></td>
        <td><?php echo $row->comercio; ?></td>
        <td><?php echo $row->Direccion; ?></td>
        <td><?php echo $row->Barrio; ?></td>
        <td><?php echo $row->Ciudad; ?></td>
        <td><?php echo $row->NombreContacto; ?></td>
        <td><?php echo $row->Telefono; ?></td>
        <td><?php echo $row->FechaAlta; ?></td>        
        <td>
          <div class="btnActionsForm">
            <?php  
            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2' || $this->Account_Model->get_profile() == '3'){ 
              echo anchor('client/active/'.$row->idCustomer, 'Activar', array('class' => 'btn btn-info')); 
            } ?>

            <!-- Button to trigger modal -->
            <!--<a href="<?php //echo '#modal-'.$row->idCustomer ?>" role="button" class="btn btn-primary" data-toggle="modal">Eliminar</a> -->
             
            <!-- Modal -->
            <div id="<?php echo 'modal-'.$row->idCustomer ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Desactivar Cliente</h3>
              </div>
              <div class="modal-body">
                <p>Esta seguro que desea desactivar este cliente ?</p>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <?php echo anchor('client/delete/'.$row->idCustomer, 'Desactivar Cliente', array('class' => 'btn btn-primary')); ?>
              </div>
            </div>

          </div>
        </td>
      </tr>
    <?php
      }
    }
    ?>
  </tbody>
</table> 