<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Tipos de Comercio</h1>
  </div>
  
<?php
  echo form_open('commerce/save');

  if ($action === "new"){ 
    echo form_hidden('form_action', "save");
    $pageTitle= "Nuevo Tipo de commercio en HORIZON";
  }else{  
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Tipo de commercio";
  }

  if (isset($idcommerce)) echo form_hidden('idcommerce', $idcommerce);
?>


 <div class="container logincontainer">
    <div class="span9 offset1">
      <div class="block_head row">
        <h2 class="span6"><?php echo $pageTitle; ?></h2>
      </div>
      <div class="block_content row">     
        <?php echo form_open('commerce/save'); ?>
          <fieldset>                        
            <div class="control-group">
              <label class="control-label" for="desc">Descripcion del Comercio</label>
              <div class="controls">
                <?php
                  if (isset($idcommerce))
                    echo form_textarea(array('name' => 'desc', 'class' => 'span8', 'rows' => '1', 'cols' => '0', 'value' => $commerce->Descripcion));                    
                  else
                    echo form_textarea(array('name' => 'desc', 'class' => 'span8', 'rows' => '1', 'cols' => '0'), set_value('desc'));

                  echo form_error('desc');
                ?>                
              </div>
            </div>            
            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Guardar" />
              <?php echo anchor('commerce', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
            </div>              
          </fieldset>
      </div>
    </div>
  </div>
</div>
