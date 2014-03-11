<div class="container">     

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Barrios</h1>
    </div>

    <div class="span8 smallTableCenter">      
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">Activos</a></li>
          <li><?php 
            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2')
              echo anchor('district/create', 'Nuevo Barrio', array('class' => ' btnAdd btnTitle btn btn-primary'));
          ?></li>
        </ul>



      <div class="row">
      <?php echo form_open('district/search_district'); ?>

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
                    </div>
                  </div>

                  <div class="selected_2" style="float:left;">
                    <div class="control-group">
                      <label class="control-label span1" for="name">Zona:</label>
                      <div class="controls span3">
                        <?php echo form_dropdown('area', $area); ?>
                      </div>


                      <div class="form-actions span4">
                        <input class="btn btn-primary" type="submit" name="submit" value="Ver" />
                        <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >
                      </div>
                    </div>
                  </div>
                </fieldset>
            </div>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?>



        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <?php
              $data['category'] = 'client';
              $this->load->view('district/tab1', $data);
            ?>
          </div>
          <div class="tab-pane" id="tab2">
            <?php
              $data['category'] = 'district';
              //$this->load->view('district/tab3', $data);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>