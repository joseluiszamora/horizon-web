<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Sub Zonas</h1>
  </div>
  
<?php
  echo form_open('area/sub_area');

  if ($action === "new"){ 
    echo form_hidden('form_action', "save");
    $pageTitle= "Nueva Sub Zona en HORIZON";
  }else{  
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Sub Zona";
  }

  echo form_hidden('level', '1');

  if (isset($idarea)) echo form_hidden('idarea', $idarea);
?>


 <div class="container logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span6"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">
          <fieldset>  

            <div class="control-group selected_1">
              <label class="control-label" for="name">Nombre de la Sub Zona</label>
              <div class="controls">
                <?php
                  if (isset($idarea))
                    echo form_input(array('name' => 'desc', 'class' => 'span3', 'value' => $area->Descripcion));
                  else
                    echo form_input(array('name' => 'desc', 'class' => 'span3'), set_value('desc'));   

                  echo form_error('desc');
                ?>
                
              </div>  
            </div>


            <div class="control-group">
              <label class="control-label" for="idArea">Pertenece a:</label>
              <div class="controls">
                <?php
                  if (isset($idarea))
                    echo form_dropdown('area', $area_parent, $area->parent);
                  else
                    echo form_dropdown('area', $area_parent);

                  echo form_error('area');
                ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('area', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>              
          </fieldset>
      </div>
    </div>
  </div>
</div>
