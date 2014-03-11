<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Línea - Volumen</h1>
  </div>

<?php
  echo form_open('linevolume/save');

  if ($action === "add_volume"){
    echo form_hidden('form_action', "add_volume");
    $objLine = $this->Line_Model->get($idLine);
    //echo $objLine[0]->Descripcion;
    $pageTitle= "Agregar Volumen a Línea ".$objLine[0]->Descripcion;
  } else if ($action === "new"){
    echo form_hidden('form_action', "save");
    $pageTitle= "Nuevo Línea-Volumen en HORIZON";
  }else{
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Línea-Volumen";
  }

  if (isset($idLineVolume)) echo form_hidden('idLineVolume', $idLineVolume);
?>


 <div class="container logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span9"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">
          <fieldset>
            <?php if ($action === "add_volume"): ?>
              <?php echo form_hidden('idLine', $idLine); ?>
            <?php else: ?>
              <div class="control-group selected_1">
                <label class="control-label" for="idLine">Línea</label>
                <div class="controls">
                  <?php
                    if (isset($idLineVolume))
                      echo form_dropdown('idLine', $lines, $linevolume->idLine);
                    else
                      echo form_dropdown('idLine', $lines);

                    echo form_error('idLine');
                  ?>
                </div>
              </div>
            <?php endif; ?>

            <div class="control-group selected_1">
              <label class="control-label" for="idVolume">Volumen</label>
              <div class="controls">
                <?php
                  if (isset($idLineVolume))
                    echo form_dropdown('idVolume', $volumes, $linevolume->idVolume);
                  else
                    echo form_dropdown('idVolume', $volumes);

                  echo form_error('idVolume');
                ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php 
                if (isset($idLineVolume))
                  echo anchor('line/volumes/'.$idLineVolume, 'Cancelar', array('class' => 'btnTitle btn btn-primary'));
                else
                  echo anchor('line/volumes/'.$idLine, 'Cancelar', array('class' => 'btnTitle btn btn-primary'));
              ?>
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>
