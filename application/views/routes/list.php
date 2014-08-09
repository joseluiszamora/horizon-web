<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Distribuidor</th>
      <th>Fecha</th>
      <th>Zona</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($routes as $row) { ?>
      <tr>
        <td class="text-info"><strong><?php echo $row->Nombre."".$row->Apellido; ?></strong></td>
        <td class="text-info"><strong><?php echo $row->fecha; ?></strong></td>
        <td class="text-info"><strong><?php echo $row->Descripcion; ?></strong></td>
        <td>
          <div class="btnActionsForm">
            <?php
              //echo anchor('routes/edit/'.$row->idprogrutas, 'Editar', array('class' => 'btn btn-info'));
              echo anchor('routes/calendar/'.$row->idUser, 'Calendario', array('class' => 'btn btn-info'));
            ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>