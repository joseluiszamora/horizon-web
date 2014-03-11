<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Ciudad</th>    
      <th>Nombre del Barrio</th>
      <th>Pertenece a</th>
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($district as $row) { ?>
      <tr>
        <td><?php echo $row->ciudad; ?></td>
        <td class="text-info districtDesc"><strong><?php echo $row->Descripcion; ?></strong></td>
        <td><?php echo $row->Zona; ?></td>        
        <td>
          <div class="btnActionsForm">
            <?php 
            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2')
              echo anchor('district/edit/'.$row->idBarrio, 'Editar', array('class' => 'btn btn-info')); 
            ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table> 