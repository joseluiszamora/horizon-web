<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Nueva Carga</h3>
  </div>
</div>

<div class="row" >
  <div class="col-md-offset-1 col-md-9">
    <?php
      $attributes = array('class' => 'form-horizontal');
      echo form_open('liquidation/save', $attributes);
    ?>
      <fieldset>
        <div class="form-group">
          <label for="distributor" class="control-label col-xs-2">Ciudad</label>
          <div class="col-xs-7">
            <?php
              echo form_dropdown('city', $cities, '', 'class="chosen-select form-control" ');
            ?>
          </div>
        </div>

        <div class="form-group">
          <label for="distributor" class="control-label col-xs-2">Distribuidor</label>
          <div class="col-xs-7">
            <?php
              echo form_dropdown('distributor', $distributor, '', 'class="chosen-select form-control" ');
            ?>
          </div>
        </div>

        <div class="form-group">
          <label for="route" class="control-label col-xs-2">Ruta</label>
          <div class="col-xs-7">
            <select name="route" class="form-control">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
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
          <label for="desc" class="control-label col-xs-2">Observaciones</label>
          <div class="col-xs-7">
            <?php 
              echo form_textarea(array('name' => 'desc', 'class' => 'form-control', 'rows' => '3', 'cols' => '4'), set_value('desc'));
            ?>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-offset-2 col-xs-10">
            <div class="checkbox">
              <label>
                <?php 
                  $data = array(
                    'name'        => 'lastliquid',
                    'id'        => 'lastliquid',
                    'value'       => 'accept',
                    'checked'     => FALSE
                  );

                  echo form_checkbox($data);
                ?>
                <b>Desea cargar la ultima liquidación?</b>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-offset-2 col-xs-10">
            <div class="checkbox">
              <label>
                <?php 
                  $data2 = array(
                    'name'        => 'noregularproducts',
                    'id'        => 'noregularproducts',
                    'value'       => 'accept',
                    'checked'     => FALSE
                  );

                  echo form_checkbox($data2);
                ?>
                <b>Desea adicionar productos no regulares?</b>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-offset-2 col-xs-10">
            <input type="submit" value="Crear" name="submit" class="btn btn-primary">
            <a class="btnTitle btn btn-info" href="http://localhost/horizon/index.php/user">Cancelar</a>

          </div>
        </div>

      </fieldset>
    <?php echo form_close(); ?>
  </div>
</div>



<script type="text/javascript">
  // chosen selects
  //$(".chosen-select").chosen({no_results_text: "Ningún resultado encontrado :("}); 

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  }).on('changeDate', function(ev){
    $(this).datepicker('hide');
  });
</script>