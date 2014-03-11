<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Ciudad</th>
      <th>Nombre de la Zona</th>
      <th>Barrios</th>
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($area as $row) {      
      if ($row->Estado == "1" && $row->level == "0") {?>
      <tr>
        <td class="text-info areaDesc"><strong><?php echo $row->ciudad; ?></strong></td>
        <td class="text-info areaDesc"><strong><?php echo $row->Descripcion; ?></strong></td>
        <td>
          <ul>
            <?php foreach ($district as $row_district) { 
              if ($row_district->idZona == $row->idZona) {
                echo "<li>".$row_district->Descripcion."</li>";
              }
            }?>
          </ul>         
        </td>
        <td>
          <?php if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2'){ ?>
          <div class="btnActionsForm">
            <?php echo anchor('area/edit/'.$row->idZona, 'Editar', array('class' => 'btn btn-info')); ?>
           
            <!-- Button to trigger modal -->
            <a href="<?php echo '#modal-'.$row->idZona ?>" role="button" class="btn btn-primary" data-toggle="modal">Desactivar</a>
             
            <!-- Modal -->
            <div id="<?php echo 'modal-'.$row->idZona ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Desactivar Zona</h3>
              </div>
              <div class="modal-body">
                <p>Esta seguro que desea desactivar esta zona ?</p>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <?php echo anchor('area/deactive/'.$row->idZona, 'Desactivar Zona', array('class' => 'btn btn-primary')); ?>
              </div>
            </div>
          </div>
          <?php } ?>
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table> 