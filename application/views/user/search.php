<div class="row">
<?php echo form_open('user/search_tab'); ?>

 <div class="container fieldsClientForm logincontainer formContainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span4">Busqueda</h2>
      </div>
      <div class="block_content row">
          <fieldset>
            <div class="control-group selected_1">
              <label class="control-label" for="name">Fecha de Ingreso (desde):</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'dateStart', 'class' => 'span2 datepicker'), set_value('dateStart')); ?>
              </div>
            </div>
            
            <div class="control-group selected_1">
              <label class="control-label" for="name">Fecha de Ingreso (hasta):</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'dateFinish', 'class' => 'span2 datepicker'), set_value('dateFinish')); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="city">Ciudad</label>
              <div class="controls">
                <?php echo form_dropdown('city', $city); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="name">Nombre</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'name', 'class' => 'span4'), set_value('name')); ?>
              </div>  
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="area">Zona</label>
              <div class="controls">
                <?php echo form_dropdown('area', $area); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="usertype">Perfil</label>
              <div class="controls">
                <?php echo form_dropdown('profile', $profile); ?>
              </div>
            </div> 

            <div class="control-group selected_1">
              <label class="control-label" for="order">Ordenar Por:</label>
              <div class="controls">
                <?php
                  $options = array(
                    'users.Nombre' => 'Nombre',
                    'users.FechaIngreso'  => 'Fecha',
                    'users.idCiudadOpe'    => 'Ciudad',
                    'users.idZona'   => 'Zona',
                    'profile.idProfile'   => 'Perfil'                    
                  );

                  echo form_dropdown('order', $options, 'users.Nombre');
                ?>
              </div>
            </div> 

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Buscar" />
              <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >
            </div>              
          </fieldset>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>


<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo anchor('user/index/ci', 'C.I.' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('user/index/perfil', 'Perfil' , array('class' => 'newLinkTables')); ?></th>
      <th>Ciudad</th>
      <th>Zona</th>
      <th><?php echo anchor('user/index/Nombre', 'Nombres y Apellidos' , array('class' => 'newLinkTables')); ?></th>
      <th><?php echo anchor('user/index/Email', 'Email' , array('class' => 'newLinkTables')); ?></th>
      <th>Telefono</th>
      <th>Celular</th>
      <th><?php echo anchor('user/index/FechaIngreso', 'Fecha Ingreso' , array('class' => 'newLinkTables')); ?></th>
      <th>Observaciones</th>
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
        <td>
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
        </td>
      </tr>
    <?php
      }
    }
    ?>
  </tbody>
</table>