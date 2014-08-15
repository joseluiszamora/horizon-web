<div class="container">

  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">Nueva Ruta</h3>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="tab-content">
        <div id="home" class="row tab-pane active">
          <?php
            echo form_open('routes/save');

            if ($action === "new"){
              echo form_hidden('form_action', "save");
              $pageTitle= "Nueva Ruta";
            }else{
              echo form_hidden('form_action', "edit");
              $pageTitle= "Editar Ruta";
            }

            if (isset($idRoute)) echo form_hidden('idRoute', $idRoute);
          ?>
          <br><br>
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
                  <label for="date" class="control-label col-xs-2">Fecha</label>
                  <div class="col-xs-3">
                    <?php
                      echo form_input(array('name' => 'date', 'class' => 'datecontainer datepicker datemedium form-control'));
                    ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="route" class="control-label col-xs-2">Ruta</label>
                  <div class="col-xs-7">
                    <?php
                      foreach ($dropdown_list as $key=>$zones){
                        echo '<div id='.$key.' class="routedropdown">';
                        echo form_dropdown('zone', $zones, '', 'class="form-control chosen-select"');
                        echo "</div>";
                      }
                    ?>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-offset-2 col-xs-10">
                    <div id="saveformroute" class="btn btn-primary">Crear</div>
                    <?php echo anchor('routes', 'Cancelar', array('class' => 'btnTitle btn btn-info')); ?>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>