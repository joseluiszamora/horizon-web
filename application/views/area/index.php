
<div class="container">

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Zonas</h1>
    </div>

    <div class="span8 smallTableCenter">      
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="tab1"><?php echo anchor('area/activos', 'Zonas Activas'); ?></li>
          <li class="tab2"><?php echo anchor('area/inactivos', 'Zonas Inactivas'); ?></li>
          <li class="tab3"><?php echo anchor('area/subactivos', 'Sub Zonas Activas'); ?></li>
          <li class="tab4"><?php echo anchor('area/subinactivos', 'Sub Zonas Inactivas'); ?></li>
          
          <li><?php 
          if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2')
            echo anchor('area/create', 'Nueva Zona', array('class' => 'btnAdd btnTitle btn btn-primary'));
          ?></li>
          <li><?php 
          if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2')
            echo anchor('area/new_sub_area', 'Nueva Sub Zona', array('class' => 'btnAdd btnTitle btn btn-primary'));
          ?></li>
        </ul>

        






<div class="row">
<?php echo form_open('area/search_area');
   echo form_hidden('tab', $mark);
 ?>

 <div class="container formContainer logincontainer">
    <div class="span6 offset1">
      <div class="block_content row">
          <fieldset>
            <div class="selected_2" style="float:left;">
              <div class="control-group">
                <label class="control-label span1" for="name">Ciudad:</label>
                <div class="controls span3">
                  <?php echo form_dropdown('city', $city); ?>
                </div>
                <div class="controls span2" style="width:46px;">
                  <input class="btn btn-primary" type="submit" name="submit" value="Ver" />
                </div>
              </div>
            </div>
          </fieldset>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>











        <div id="">
          <?php
            $this->load->view('area/'.$mark);
          ?>
        </div>


      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  // remove all active class
  $('.nav-tabs li').removeClass('active');
  $('.tab-content tab-pane').removeClass('active');

  mark = "<?php echo $mark; ?>";
  if(mark == null)
    mark = "t_1";
    
  $("." + mark).addClass('active');

</script>