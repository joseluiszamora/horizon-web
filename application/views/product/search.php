<div class="row">
  <?php echo form_open('product/search_tab'); ?>

  <div class="container formContainer logincontainer">
      <div class="span10 offset1">
        <div class="block_content row">
            <fieldset>
              <div class="control-group selected_1">
              <label class="control-label" for="line">Linea</label>
              <div class="controls">
                <?php
                  echo form_dropdown('line', $linea);  
                
                  echo form_error('line');
                ?>
                
              </div>  
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="volume">Volumen</label>
              <div class="controls">
                <?php
                  echo form_dropdown('volume', $volumen);  
                
                  echo form_error('volume');
                ?>
                
              </div>  
            </div>

              <div class="control-group selected_2">
                <h3>Ver Productos mas Vendidos</h3>
              </div>

              <div class="control-group selected_1">
                <label class="control-label" for="name">Fecha Inicio (desde):</label>
                <div class="controls">
                  <?php echo form_input(array('name' => 'dateStart', 'class' => 'span2 datepicker'), set_value('dateStart')); ?>
                </div>
              </div>

              <div class="control-group selected_1">
                <label class="control-label" for="name">Fecha Final (hasta):</label>
                <div class="controls">
                  <?php echo form_input(array('name' => 'dateFinish', 'class' => 'span2 datepicker'), set_value('dateFinish')); ?>
                </div>
              </div>

              <div class="selected_2" style="float:left;">
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
              </div>

              <div class="form-actions span7">
                <input class="btn btn-primary" type="submit" name="submit" value="Ver" />
                <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >

                <div class="btnCSV">
                  <?php echo form_close(); ?>
                  <?php echo form_open('product/csv'); ?>
                  <?php echo form_hidden('parameters', $search_parameters); ?>
                  <?php echo form_submit('send', 'CSV'); ?>
                  <?php echo form_close(); ?>
                </div>
                <div class="btnPDF">
                  <?php echo form_close(); ?>
                  <?php echo form_open('product/pdf'); ?>
                  <?php echo form_hidden('parameters', $search_parameters); ?>
                  <?php echo form_submit('send', 'PDF'); ?>
                  <?php echo form_close(); ?>
                </div>
              </div>
            </fieldset>
        </div>
      </div>
  </div>
  <?php echo form_close(); ?>
</div>

<table class="tableHorizon table table-bordered table-striped">
  <thead>
    <tr>
      <th>Codigo de Producto</th>
      <th>Nombre</th>
      <th>Linea Volumen</th>
      <th>Precio Unitario</th>
      <th>Descripcion</th>
      <th>Unidades Vendidas</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $row) {?>
      <tr>
        <td class="text-info"><strong><?php echo $row->idProduct; ?></strong></td>
        <td><?php echo $row->Nombre; ?></td>
        <td><?php echo $row->lineDescription." - ".$row->volumeDescription; ?></td>
        <td class="align-right"><?php echo $this->Transaction_Model->roundnumber($row->PrecioUnit, 2); ?></td>
        <td><?php echo $row->Descripcion." "; ?></td>
        <td class="align-right"><?php echo $row->sum; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
