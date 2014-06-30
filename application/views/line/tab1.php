<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Descripción</th>
      <th>Unidades por Paquete</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lines as $row) { ?>
      <tr>
        <td class="text-info areaDesc"><strong><?php echo $row->Descripcion; ?></strong></td>
        <td class="text-info areaDesc"><strong><?php echo $row->uxplinea; ?></strong></td>
        <td>
          <div class="btnActionsForm2">
            <?php 
            if($this->Account_Model->get_profile() == '1')
              echo anchor('line/edit/'.$row->idLine, 'Editar', array('class' => 'btn btn-info'));
            ?>
            <?php echo anchor('line/volumes/'.$row->idLine, 'Volumenes', array('class' => 'btn btn-primary')); ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>