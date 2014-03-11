<div class="row">
<?php echo form_open('client/search_tab'); ?>

 <div class="container formContainer logincontainer">
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
              <label class="control-label" for="name">Nombre del negocio</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'name', 'class' => 'span4'), set_value('name')); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="city">Ciudad</label>
              <div class="controls">
                <?php echo form_dropdown('city', $city); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="area">Zona</label>
              <div class="controls">
                <?php echo form_dropdown('area', $area); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="subarea">Sub Zona</label>
              <div class="controls">
                <?php echo form_dropdown('subarea', $subarea); ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="channel">Canal</label>
              <div class="controls">
                <?php echo form_dropdown('channel', $channel); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="commercetype">Tipo de Comercio</label>
              <div class="controls">
                <?php echo form_dropdown('commercetype', $commerce); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="datelasttransaction">Fecha ultima transaccion, hace:</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'datelasttransaction', 'class' => 'span2'), set_value('datelasttransaction')); ?> dias
              </div>
            </div>

            <div class="control-group" style="margin-left: 24px;">
              <label class="control-label" for="sort">Ordenar por</label>
              <div class="controls">
                 <?php 
                  $options = array(
                    'last_transaction.FechaHoraInicio'  => 'Fecha Ultima Transaccion',
                    'customer.idComercio'  => 'Tipo de Comercio',
                    'customer.idCiudad'  => 'Ciudad',
                    'zona.idZona'  => 'Zona',
                    'customer.NombreTienda'  => 'Nombre',
                    'customer.CodeCustomer'  => 'Codigo',
                    'customer.idChannel'  => 'Canal'
                  );
                  echo form_dropdown('orderSelect', $options); 
                ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Buscar" />
              <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >

              <div class="btnCSV">
                <?php echo form_close(); ?>
                <?php echo form_open('client/csv'); ?>
                <?php echo form_hidden('parameters', $search_parameters); ?>
                <?php echo form_submit('send', 'CSV'); ?>
                <?php echo form_close(); ?>
              </div>
              <div class="btnPDF">
                <?php echo form_close(); ?>
                <?php echo form_open('client/pdf'); ?>
                <?php echo form_hidden('parameters', $search_parameters); ?>
                <?php echo form_submit('send', 'PDF'); ?>
                <?php echo form_close(); ?>
              </div>
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>

<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Nombre del Negocio</th>
      <th>Direccion</th>
      <th>Barrio</th>
      <th>Zona</th>
      <th>Sub Zona</th>
      <th>Ciudad</th>
      <th>Fecha de Alta</th>
      <th>Fecha ultima transaccion</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($clients as $row) {
      if ( $row->Estado === '1') {
      ?>
      <tr>
        <td class="text-info"><strong><?php echo $row->CodeCustomer; ?></strong></td>
        <td><?php echo $row->NombreTienda; ?></td>
        <td class="grid_3"><?php echo $row->Direccion; ?></td>
        <td><?php echo $row->Barrio; ?></td>
        <td><?php echo $row->Zona; ?></td>
        <td><?php echo $row->idSubZona; ?></td>
        <td><?php echo $row->Ciudad; ?></td>
        <td><?php echo $row->FechaAlta; ?></td>
        <td><?php echo $row->ff; ?></td>
      </tr>
    <?php }  } ?>
  </tbody>
</table>