<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Nueva Carga</h3>
  </div>
</div>

<div class="row" >
  <div class="col-md-offset-1 col-md-9 form-horizontal">
    <?php
      //$attributes = array('class' => 'form-horizontal');
      //echo form_open('liquidation/save', $attributes);
    ?>
      <fieldset>
        <!--<div class="form-group">
          <label for="distributor" class="col-xs-2 control-label">Ciudad</label>
          <div class="col-xs-7">
            <?php
              //echo form_dropdown('city', $cities, '', 'class="chosen-select form-control" ');
            ?>
          </div>
        </div>-->

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
            <input id="saveform" type="submit" value="Crear" name="submit" class="btn btn-primary">
            <a class="btnTitle btn btn-info" href="http://localhost/horizon/index.php/user">Cancelar</a>

          </div>
        </div>

      </fieldset>
    <?php //echo form_close(); ?>
  </div>
</div>



<script type="text/javascript">
  // chosen selects
  $(".chosen-select").chosen({no_results_text: "Ningún resultado encontrado :("}); 

  $(".routedropdown").hide();

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  }).on('changeDate', function(ev){
    $(this).datepicker('hide');
  });
  
  $('select[name="distributor"]').change(function(){
    $(".routedropdown").hide();
    $(".routedropdown").removeClass("selected");
    //$("#" + $(this).val()).show();
    //console.log($(this).attr("value"));
    //console.log($(this).attr("data-zone"));
    $zoneid = $('select[name="distributor"]').find('option[value='+$(this).val()+']').attr("data-zone");
    $(".routedropdown[id="+$zoneid+"]").show();
    $(".routedropdown[id="+$zoneid+"]").addClass("selected");


  });

  $("#saveform").click(function(){
    $flag = false;
    // check distrib
    $distrib = $('select[name="distributor"]');
    $distribval = $('select[name="distributor"]').val();
    if ($distribval == 0 || $distribval == "") {
      $flag = false;
      $distrib.addClass("has-error");
      $distrib.parents(".form-group").find("label").addClass("has-error");
      return false;
    }else{
      $flag = true;
      $distrib.removeClass("has-error");
      $distrib.parents(".form-group").find("label").removeClass("has-error");
    }

    // check Route
    $zone = $(".routedropdown.selected").find('select[name="zone"]');
    $zoneval = $zone.val();
    if ($zoneval == 0 || $zoneval == "") {
      $flag = false;
      $zone.parents(".form-group").find("label").addClass("has-error");
      return false;
    }else{
      $flag = true;
      $zone.parents(".form-group").find("label").removeClass("has-error");
    } 

    // check Date
    $date = $('input[name="date"]');
    $dateval = $('input[name="date"]').val();
    if ($dateval == 0 || $dateval == "") {
      $flag = false;
      $date.addClass("has-error");
      $date.parents(".form-group").find("label").addClass("has-error");
      return false;
    }else{
      $flag = true;
      $date.removeClass("has-error");
      $date.parents(".form-group").find("label").removeClass("has-error");
    }

    if ($flag) {
      console.log($distribval);
      console.log($zoneval);
      console.log($dateval);
      
      console.log($('textarea[name="desc"]').val());
      console.log($('#lastliquid').is( ":checked"));
      console.log($('#noregularproducts').is( ":checked"));
    };
  });
</script>

<style type="text/css">
  .chosen-single, .chosen-drop, .chosen-results{
    width: 400px !important;
  }
</style>