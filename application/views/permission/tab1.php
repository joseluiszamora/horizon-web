<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Perfiles</th>
      <th>&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach ($profile as $row) { ?>
      <tr>
        <td class="text-info districtDesc"><strong><?php echo $row->Descripcion; ?></strong></td>        
        <td>
          <div class="btnActionsForm">
            <?php echo anchor('permission/edit/'.$row->idProfile, 'Editar', array('class' => 'btn btn-info')); ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table> 