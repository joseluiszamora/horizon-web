<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo de Producto</th>
      <th>Nombre</th>
      <th>Vindea Volumen</th>
      <th>Precio Unitario</th>
      <th>Descripcion</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $row) { ?>
      <tr>
        <td class="text-info"><strong><?php echo $row->idProduct; ?></strong></td>
        <td><?php echo $row->Nombre; ?></td>
        <td><?php echo $row->lineDescription." - ".$row->volumeDescription; ?></td>
        <td class="align-right"><?php echo $this->Transaction_Model->roundnumber($row->PrecioUnit, 2); ?></td>
        <td class="grid_3"><?php echo $row->Descripcion; ?></td>
        <td>
          <?php 
            if($this->Account_Model->get_profile() == '1'){
          ?>
          <div class="btnActionsForm">
            <?php echo anchor('product/active/'.$row->idProduct, 'Activar', array('class' => 'btn btn-info')); ?>

          <!-- Button to trigger modal -->
          <a href="<?php echo '#modal-'.$row->idProduct ?>" role="button" class="btn btn-primary" data-toggle="modal">Eliminar</a>

          <!-- Modal -->
          <div id="<?php echo 'modal-'.$row->idProduct ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel">Eliminar Producto</h3>
            </div>
            <div class="modal-body">
              <p>Esta seguro que desea eliminar este producto ?</p>
            </div>
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
              <?php echo anchor('product/delete/'.$row->idProduct, 'Eliminar Producto', array('class' => 'btn btn-primary')); ?>
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