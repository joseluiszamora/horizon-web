<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Historico</h3>
  </div>
</div>

<div class="row">
  <div class="col-md-11 form-horizontal">
    <div class="span9 offset1">
      <div class="block_content row jumbotron">
          <?php echo form_open('liquidation/search'); ?>
          <fieldset>
            <div class="form-group">
              <label for="distributor" class="control-label col-xs-2">Distribuidor</label>
              <div class="col-xs-4">
                <?php echo $distributor; ?>
              </div>

              <label for="distributor" class="control-label col-xs-1">Estado</label>
              <div class="col-xs-3">
                <?php
                  $options = array(
                    'creado' => 'Creado',
                    'cargado' => 'Carga Inicial',
                    'cargaextra1' => 'Carga Extra 1',
                    'cargaextra2' => 'Carga Extra 2',
                    'cargaextra3' => 'Carga Extra 3',
                    'cargafinal' => 'Carga Completa',
                    'liquidation' => 'Liquidación',
                    'completado' => 'Finalizado'
                  );

                  if (isset($parameters['status'])) {
                    echo form_dropdown('status', $options, $parameters['status'], 'class="chosen-select" ');
                  }else{
                    echo form_dropdown('status', $options, '', 'class="form-control chosen-select" ');
                  }
                ?>
              </div>
            </div>

            <div class="form-group">
              <label for="distributor" class="control-label col-xs-2">Desde </label>
              <div class="col-xs-3">
                <?php
                  if (isset($parameters['dateStart'])) {
                    echo form_input(array('name' => 'dateStart', 'class' => 'datecontainer datepicker datemedium', 'value' => $parameters['dateStart']));
                  }else{
                    echo form_input(array('name' => 'dateStart', 'class' => 'datecontainer datepicker datemedium'));
                  }
                ?>
              </div>
              <label for="distributor" class="control-label col-xs-2">Hasta </label>
              <div class="col-xs-3">
                <?php
                  if (isset($parameters['dateFinish'])) {
                    echo form_input(array('name' => 'dateFinish', 'class' => 'datecontainer datepicker datemedium', 'value' => $parameters['dateFinish']));
                  }else{
                    echo form_input(array('name' => 'dateFinish', 'class' => 'datecontainer datepicker datemedium'));
                  }
                ?>
              </div>
            </div>

            <div class="form-group">
              <div class="col-xs-offset-5 col-xs-5">
                <input id="saveform" type="submit" value="Buscar" name="submit" class="btn btn-primary">
                <a class="btnTitle btn btn-info" href="http://localhost/horizon/index.php/user">Cancelar</a>

              </div>
            </div>

        </fieldset>
      </div>
    </div>
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
        </tr>
      </thead>
      <tbody id="diaryTable">
         <?php foreach ($charges as $row) { ?>
          <tr class="even gradeX">
            <td class="center"><?php echo $row->Nombre." ".$row->Apellido; ?></td>
            <td class="center"><?php echo $row->fechaRegistro; ?></td>
            <td class="center"><?php echo $row->Descripcion; ?></td>
            <td class="center"><?php echo $row->mark; ?></td>
            <td class="center"><?php echo $row->detalle; ?></td>
            <td class="center">
              <?php echo anchor('liquidation/show/'.$row->idLiquidacion, '<span class="glyphicon glyphicon-th-large"></span> Ver', array('class' => 'btn btn-info')); ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>