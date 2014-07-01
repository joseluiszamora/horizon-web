<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Líneas</h1>
  </div>

<?php
  echo form_open('line/save');

  if ($action === "new"){
    echo form_hidden('form_action', "save");
    $pageTitle= "Nueva Línea en HORIZON";
  }else{
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Línea";
  }

  if (isset($line)) echo form_hidden('idLine', $line->idLine);
?>


 <div class="container logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span6"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">
          <fieldset>
            <div class="control-group selected_2">
              <label class="control-label" for="name">Nombre de la Línea</label>
              <div class="controls">
                <?php
                  if (isset($line))
                    echo form_input(array('name' => 'desc', 'class' => 'span3', 'value' => $line->Descripcion));
                  else
                    echo form_input(array('name' => 'desc', 'class' => 'span3'), set_value('desc'));

                  echo form_error('desc');
                ?>
              </div>
            </div>
            <div class="control-group selected_2">
              <label class="control-label" for="name">Unidades por Paquete</label>
              <div class="controls">
                <?php
                  if (isset($line))
                    echo form_input(array('name' => 'uxplinea', 'class' => 'span3', 'value' => $line->uxplinea));
                  else
                    echo form_input(array('name' => 'uxplinea', 'class' => 'span3'), set_value('uxplinea'));

                  echo form_error('uxplinea');
                ?>
              </div>
            </div>

            <div class="control-group selected_2">
              <label class="control-label" for="name">Es regular?</label>
              <div class="controls">
                <?php
                  if (isset($line)){
                    if ($line->regular == "si") {
                      echo '<input type="radio" name="regular" value="si" checked>Si   ';
                      echo '<input type="radio" name="regular" value="no">No';
                    }else{
                      echo '<input type="radio" name="regular" value="si">Si   ';
                      echo '<input type="radio" name="regular" value="no" checked>No';
                    }
                  }else{
                    echo '<input type="radio" name="regular" value="si" checked>Si   ';
                    echo '<input type="radio" name="regular" value="no">No';
                
                  }
                ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('line', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>
