<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo anchor('user/index/ci', 'C.I.' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('user/index/perfil', 'Perfil' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('user/index/idCiudadOpe', 'Ciudad' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('user/index/idZona', 'Zona' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('user/index/Nombre', 'Nombres y Apellidos' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('user/index/users.Email', 'Email' , array('class' => 'newLinkTables')); ?></th>
      <th>Telefono</th>
      <th>Celular</th>
      <th><?php echo anchor('user/index/FechaIngreso', 'Fecha Ingreso' , array('class' => 'newLinkTables')); ?></th>
      <th>Observaciones</th>
      <th>Acceso Web</th>
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($users as $row) {
      if ( $row->Enable === '1') {
    ?>
      <tr>
        <td class="text-info"><strong><?php echo $row->ci; ?></strong></td>
        <td><?php echo $row->perfil; ?></td>
        <td><?php echo $this->City_Model->get_city($row->idCiudadOpe); ?></td>
        <td><?php echo $this->Area_Model->get_area_name($row->idZona); ?></td>
        <td><?php echo $row->Nombre." ".$row->Apellido; ?></td>
        <td><?php echo $row->Email; ?></td>
        <td><?php echo $row->Telefono; ?></td>
        <td><?php echo $row->TelfCelular; ?></td>
        <td><?php echo $row->FechaIngreso; ?></td>
        <td class="grid_3"><?php echo $row->Observacion; ?></td>
        <td><?php 
          if($row->Web == "1")
            echo "Si"; 
        ?></td>
        <td>
           <?php 
            if($this->Account_Model->get_profile() == '1'){
          ?>
          <div class="btnActionsForm">
            <?php echo anchor('user/edit/'.$row->idUser, 'Editar', array('class' => 'btn btn-info')); ?>
          
            <!-- Button to trigger modal -->
            <a href="<?php echo '#modal-'.$row->idUser ?>" role="button" class="btn btn-primary" data-toggle="modal">Desactivar</a>
             
            <!-- Modal -->
            <div id="<?php echo 'modal-'.$row->idUser ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Desactivar Usuario</h3>
              </div>
              <div class="modal-body">
                <p>Esta seguro que desea desactivar este usuario ?</p>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <?php echo anchor('user/deactive/'.$row->idUser, 'Desactivar Usuario', array('class' => 'btn btn-primary')); ?>
              </div>
            </div>
          </div>
           <?php            
          }
          ?> 
        </td>
      </tr>
    <?php
      }
    }
    ?>
  </tbody>
</table> 