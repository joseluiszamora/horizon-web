<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Ciudad</h1>
  </div>
</div>

<?php
  echo form_open('bonus/save');

  if ($action === "new"){
    echo form_hidden('form_action', "save");
    $pageTitle= "Agregar Bono";
  }else{
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Bono";
  }

  if (isset($idBonus)) echo form_hidden('idBonus', $idBonus);
?>
 <div class="container logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span6"><?php echo $pageTitle; ?></h2>
      </div>

      <div class="block_content row">
          <div>
            <fieldset>
              <div class="span4">
                <label class="control-label" for="name">Linea</label>
                <div class="controls">
                  <?php
                    $js = 'id="idLineFrom" onChange="updateProductDropdown(idLineFrom, idProductFrom);"';
                    if (isset($idBonus))
                      echo form_dropdown('idLineFrom', $lines, $lines->idLine, $js);
                    else
                      echo form_dropdown('idLineFrom', $lines, "", $js);

                    echo form_error('idLineFrom');
                  ?>
                </div>

                <label class="control-label" for="name">Producto</label>
                <div class="controls">
                  <?php
                    $js = 'id="idProductFrom"';

                    if (isset($idBonus))
                      echo form_dropdown('idProductFrom', $volumes, $volumes->idLine, $js);
                    else
                      echo form_dropdown('idProductFrom', $volumes,"", $js);

                    echo form_error('idProductFrom');
                  ?>
                </div>

                <label class="control-label" for="name">Unidades</label>
                <div class="controls">
                  <?php
                    if (isset($idBonus))
                      echo form_input(array('name' => 'quantityfrom', 'class' => '', 'value' => "" ));
                    else
                      echo form_input(array('name' => 'quantityfrom', 'class' => '', 'value' => "" ));

                    echo form_error('quantityfrom');
                  ?>
                </div>
              </div>
              <div class="span3">
                <label class="control-label" for="name">Linea</label>
                <div class="controls">
                  <?php
                    $js = 'id="idLineTo" onChange="updateProductDropdown(idLineTo, idProductTo);"';
                    if (isset($idBonus))
                      echo form_dropdown('idLineTo', $lines, $lines->idLine, $js);
                    else
                      echo form_dropdown('idLineTo', $lines, "", $js);

                    echo form_error('idLineTo');
                  ?>
                </div>

                <label class="control-label" for="name">Producto</label>
                <div class="controls">
                  <?php
                    $js = 'id="idProductTo"';
                    if (isset($idBonus))
                      echo form_dropdown('idProductTo', $volumes, $volumes->idLine, $js);
                    else
                      echo form_dropdown('idProductTo', $volumes, "", $js);

                    echo form_error('idProductTo');
                  ?>
                </div>

                <label class="control-label" for="name">Unidades</label>
                <div class="controls">
                  <?php
                    if (isset($idBonus))
                      echo form_input(array('name' => 'quantityto', 'class' => '', 'value' => "" ));
                    else
                      echo form_input(array('name' => 'quantityto', 'class' => '', 'value' => "" ));

                    echo form_error('quantityto');
                  ?>
                </div>
              </div>

              <div class="form-actions span7">
                <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
                <?php echo anchor('bonus', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
              </div>
            </fieldset>
          </div>
      </div>
    </div>
  </div>
</div>
