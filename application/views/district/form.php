<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Barrios</h1>
  </div>
  
<?php
  echo form_open('district/save');

  if ($action === "new"){ 
    echo form_hidden('form_action', "save");
    $pageTitle= "Nuevo Barrio en HORIZON";
  }else{  
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Barrio";
  }

  if (isset($iddistrict)) echo form_hidden('iddistrict', $iddistrict);
?>


 <div class="container logincontainer formContainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span6"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">
          <fieldset>  

            <div class="control-group selected_2">
              <label class="control-label" for="name">Nombre del Barrio</label>
              <div class="controls">
                <?php
                  if (isset($iddistrict))
                    echo form_input(array('name' => 'desc', 'class' => 'span3', 'value' => $district->Descripcion));                    
                  else
                    echo form_input(array('name' => 'desc', 'class' => 'span3'), set_value('desc'));   

                  echo form_error('desc');
                ?>
                
              </div>  
            </div>     

            <div class="control-group selected_1">
              <label class="control-label" for="city">Ciudad</label>
              <div class="controls">
                <?php
                  if (isset($iddistrict))
                    echo form_dropdown('city', $city, $this->Area_Model->get_City($district->idZona));
                  else
                    echo form_dropdown('city', $city);

                  echo form_error('city');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="area">Zona</label>
              <div class="controls">
                <?php
                  if (isset($iddistrict))
                    echo form_dropdown('area', $area, $district->idZona);
                  else
                    echo form_dropdown('area', $area);

                  echo form_error('area');
                ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('district', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>              
          </fieldset>
      </div>
    </div>
  </div>
</div>
