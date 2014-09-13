<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Tipo</th>
      <th>Linea</th>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Producto Bonificación</th>
      <th>Cantidad Bonificación</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php
      //print_r($bonus);
     foreach ($bonus as $row) { ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->type; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->line; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->volume." - ".$row->nombreproduct; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->cantidad; ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $this->Product_model->get_name_by_code($row->idProduct_bonus); ?></strong></td>
        <td class="text-info districtDesc"><strong><?php echo $row->cantidad_bonus; ?></strong></td>
        <td>
          <div class="btnActionsForm">
            <?php
            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2')
              echo anchor('bonus/edit/'.$row->idbonus, 'Editar', array('class' => 'btn btn-info'));

            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2')
              echo anchor('bonus/delete/'.$row->idbonus, 'Eliminar', array('class' => 'btn btn-info'));
            ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>