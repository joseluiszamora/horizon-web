<?php
  echo form_open('city/save');

  if ($action === "new"){
    echo form_hidden('form_action', "save");
    $pageTitle= "Nueva Ruta";
  }else{
    echo form_hidden('form_action', "edit");
    $pageTitle= "Editar Ruta";
  }

  if (isset($idRoute)) echo form_hidden('idRoute', $idRoute);
?>




<div class="row" >
  <div class="col-md-offset-1 col-md-9 form-horizontal">
      <fieldset>
        <div class="form-group">
          <label for="distributor" class="control-label col-xs-2">Distribuidor</label>
          <div class="col-xs-7">
            <?php echo $distributor; ?>
          </div>
        </div>

        <div class="form-group">
          <label for="route" class="control-label col-xs-2">Ruta</label>
          <div class="col-xs-7">
            <?php
              foreach ($dropdown_list as $key=>$zones){
                echo '<div id='.$key.' class="routedropdown">';
                echo form_dropdown('zone', $zones, '', 'class="chosen-select form-control"');
                echo "</div>";
              }
            ?>
          </div>
        </div>

        <div class="form-group">
          <label for="date" class="control-label col-xs-2">Fecha</label>
          <div class="col-xs-3">
            <?php
              echo form_input(array('name' => 'date', 'class' => 'datecontainer datepicker datemedium form-control'));
            ?>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-offset-2 col-xs-10">
            <input id="saveform" type="submit" value="Crear" name="submit" class="btn btn-primary">
            <a class="btnTitle btn btn-info" href="http://localhost/horizon/index.php/user">Cancelar</a>

          </div>
        </div>

      </fieldset>
  </div>
</div>
if (isset($idCity))
  echo form_input(array('name' => 'desc', 'class' => 'span3', 'value' => $city->NombreCiudad));
else
  echo form_input(array('name' => 'desc', 'class' => 'span3'), set_value('desc'));

echo form_error('desc');