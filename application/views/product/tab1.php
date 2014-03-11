<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo anchor('product/index/idProduct', 'Codigo de Producto' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('product/index/Nombre', 'Nombre' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('product/index/lineDescription', 'Linea Volumen' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('product/index/PrecioUnit', 'Precio Unitario' , array('class' => 'newLinkTables')); ?></th>
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
        <td><?php echo $row->Descripcion; ?></td>
        <td>

          <?php if($this->Account_Model->get_profile() == '1'){ ?>
          
          <div class="btnActionsForm">
            <?php echo anchor('product/edit/'.$row->idProduct, 'Editar', array('class' => 'btn btn-info')); ?>

            <!-- Button to trigger modal -->
            <a href="<?php echo '#modal-'.$row->idProduct ?>" role="button" class="btn btn-primary" data-toggle="modal">Desactivar</a>

            <!-- Modal -->
            <div id="<?php echo 'modal-'.$row->idProduct ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Desactivar Producto</h3>
              </div>
              <div class="modal-body">
                <p>Esta seguro que desea desactivar este producto ?</p>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <?php echo anchor('product/deactive/'.$row->idProduct, 'Desactivar Producto', array('class' => 'btn btn-primary')); ?>
              </div>
            </div>
          </div>
          <?php } ?>

        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>