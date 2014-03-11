<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Ciudad</th>
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>    
    <?php foreach ($city as $row) { ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->NombreCiudad; ?></strong></td>
        <td>
          <div class="btnActionsForm">
            <?php 
            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2')
              echo anchor('city/edit/'.$row->idCiudad, 'Editar', array('class' => 'btn btn-info'));
            ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table> 