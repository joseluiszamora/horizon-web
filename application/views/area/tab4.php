<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Ciudad</th>
      <th>Zona</th>
      <th>Sub Zonas</th>
    </tr>
  </thead>  
  <tbody>
    <?php 
      foreach ($area as $row) {
      if ($row->Estado == "1" && $row->level == "0") {?>
      <tr>
        <td class="text-info areaDesc"><strong><?php echo $row->ciudad; ?></strong></td>
        <td class="text-info areaDesc"><strong><?php echo $row->Descripcion; ?></strong></td>
        <td>
          <ul class="subAreaList">
            <?php foreach ($area_list as $row_area) { 
              if ($row_area->Estado == "0" && $row_area->level == "1" && $row_area->parent == $row->idZona){
                echo "<li>
                  <div class='desc'>".$row_area->Descripcion."</div>";
            ?>
            <?php  if($this->Account_Model->get_profile() == "1" ){ ?>
                <!-- Button to trigger modal -->
                <a href="<?php echo '#modal-'.$row_area->idZona ?>" title="Activar Zona" role="button" class="bs-icon active" data-toggle="modal">&nbsp;</a>
                <!-- Modal -->
                <div id="<?php echo 'modal-'.$row_area->idZona ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Activar Sub Zona</h3>
                  </div>
                  <div class="modal-body">
                    <p>Esta seguro que desea Activar esta Sub Zona ?</p>
                  </div>
                  <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <?php echo anchor('area/active_sub/'.$row_area->idZona, 'Activar Sub Zona', array('class' => 'btn btn-primary')); ?>
                  </div>
                </div>
            <?php } ?>
            <?php
                //echo anchor('area/edit/'.$row->idZona, 'Editar', array('class' => 'bs-icon close'));
                echo "</li>";
              }
            }?>
          </ul>         
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table> 