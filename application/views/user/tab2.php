<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>C. I.</th>
      <th>Perfil</th>
      <th>Ciudad</th>
      <th>Zona</th>
      <th>Nombres y Apellidos</th>
      <th>Email</th>
      <th>Telefono</th>
      <th>Celular</th>
      <th>Fecha Ingreso</th>
      <th>Observaciones</th>
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($users as $row) {
      if ( $row->Enable === '0') {
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
        <td>
          <?php 
            if($this->Account_Model->get_profile() == '1'){
          ?>
          <?php echo anchor('user/active/'.$row->idUser, 'Activar', array('class' => 'btn btn-info')); ?>
          
          <!-- Button to trigger modal -->
          <!--<a href="<?php //echo '#modal-'.$row->idUser ?>" role="button" class="btn btn-primary" data-toggle="modal">Eliminar</a>-->
           
          <!-- Modal -->
          <div id="<?php echo 'modal-'.$row->idUser ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel">Eliminar Usuario</h3>
            </div>
            <div class="modal-body">
              <p>Esta seguro que desea eliminar este usuario ?</p>
            </div>
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
              <?php echo anchor('user/delete/'.$row->idUser, 'Eliminar Usuario', array('class' => 'btn btn-primary')); ?>
            </div>
          </div>
        </td>
         <?php            
          }
          ?> 
      </tr>
    <?php
      }
    }
    ?>
  </tbody>
</table> 