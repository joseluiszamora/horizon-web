<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Cargas Realizadas</h3>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th class="center">Distribuidor</th>
          <th class="center">Fecha</th>
          <th class="center">Ruta</th>
          <th class="center">Estado</th>
          <th class="center">Detalle</th>
          <th class="center">&nbsp;</th>
          <th class="center">&nbsp;</th>
          <th class="center">&nbsp;</th>
        </tr>
      </thead>
      <tbody id="diaryTable">
         <?php foreach ($charges as $row) { ?>
          <tr class="even gradeX">
            <td class="center"><?php echo $row->idUser; ?></td>
            <td class="center"><?php echo $row->fechaRegistro; ?></td>
            <td class="center"><?php echo $row->ruta; ?></td>
            <td class="center"><?php echo $row->mark; ?></td>
            <td class="center"><?php echo $row->detalle; ?></td>
            <td class="center">
              <?php echo anchor('liquidation/complete_charge/'.$row->idLiquidacion, 'Carga Completa', array('class' => 'btn btn-primary')); ?>
            </td>
            <td class="center">
              <?php 
                if ( $row->mark == "creado" || $row->mark == "cargado" || $row->mark == "cargaextra1" || $row->mark == "cargaextra2" || $row->mark == "cargaextra3" ) {
                  echo anchor('liquidation/add_products/'.$row->idLiquidacion, 'Ver', array('class' => 'btn btn-primary'));
                }
                if ($row->mark == "devolution") {
                  echo anchor('liquidation/devolution/'.$row->idLiquidacion, 'Devoluciones', array('class' => 'btn btn-primary')); 
                }
              ?>
            </td>
            <td class="center">
              <?php echo anchor('liquidation/deactive/'.$row->idLiquidacion, 'Eliminar', array('class' => 'btn btn-primary')); ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>