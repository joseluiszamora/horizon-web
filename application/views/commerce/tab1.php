<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Comercio</th>
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($commerce as $row) { ?>
      <tr>
        <td class="text-info commerceDesc"><strong><?php echo $row->Descripcion; ?></strong></td>
        <td>
          <div class="btnActionsForm">
            <?php
            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2'){
              echo anchor('commerce/edit/'.$row->idComercio, 'Editar', array('class' => 'btn btn-info'));
            }
            ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table> 