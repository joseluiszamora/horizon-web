<div class="container">
  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Transacciones</h1>
    </div>

    <div class="span12">      
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="tab1"><?php echo anchor('transaction/Todas', 'Todas', array('class' => '')); ?></li>
          <li class="tab2"><?php echo anchor('transaction/Pendientes', 'Preventas', array('class' => '')); ?></li>
          <li class="tab3"><?php echo anchor('transaction/Distribuidas', 'Distribuidas', array('class' => '')); ?></li>
          <li class="tab5"><?php echo anchor('transaction/Canceladas', 'Canceladas', array('class' => '')); ?></li>
          <li class="tab7"><?php echo anchor('transaction/Transaccion_Temporal', 'Transaccion Temporal', array('class' => '')); ?></li>
          <li class="tab6"><?php echo anchor('transaction/Venta_Directa', 'Venta Directa', array('class' => '')); ?></li>
          <li class="tab8"><?php echo anchor('transaction/Transaccion_0', 'Transaccion 0', array('class' => '')); ?></li>
          <li class="tab9"><?php echo anchor('transaction/create', 'Nueva Transaccion', array('class' => 'btnAdd btnTitle btn btn-primary')); ?></li>
          <li class="search"><?php echo anchor('transaction/search', 's', array('class' => 'btnSearch bs-icon')); ?></li>
          <li class="productsTransaction"><?php 
          if($this->Account_Model->get_profile() != '5')
            echo anchor('transaction/reporte1', 'Reportes', array('class' => '')); 
          ?></li>
          <li class="productsTransaction2"><?php 
          if($this->Account_Model->get_profile() != '5')
            echo anchor('transaction/reporte2', 'Reportes 2', array('class' => ''));
          ?></li>
        </ul>
        <div class="tab-content">


<?php 
  if($mark != 'search' && $mark != 'productsTransaction' && $mark != 'productsTransaction2'){
    echo form_open('transaction/search_tab_simple');
    echo form_hidden('tab', $mark);
?>
<div class="row">
  <div class="container fieldsClientForm logincontainer formContainer">
    <div class="span10 offset1">
      <div class="block_content row">
          <fieldset>
            <div class="control-group selected_1">
              <label class="control-label" for="dateStart">Desde:</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'dateStart', 'class' => 'span2 datepicker'), set_value('dateStart')); ?>
              </div>
            </div>
            
            <div class="control-group selected_1">
              <label class="control-label" for="dateFinish">Hasta:</label>
              <div class="controls">
                <?php echo form_input(array('name' => 'dateFinish', 'class' => 'span2 datepicker'), set_value('dateFinish')); ?>
              </div>          
            </div>

            <div class="control-group selected_1">
            <label class="control-label" for="status">Estado:</label>          
              <div class="controls">
                <?php 
                  if($mark == 'tab1'){
                    $options = array(
                      ''  => 'Seleccione Estado',
                      '1'  => 'Prevendido',
                      '3'  => 'Distribuido',
                      '4'  => 'Cancelado',
                      '5'  => 'Transaccion Temporal',
                      '6'  => 'Venta Directa',
                      '7'  => 'Transaccion 0',
                    );
                    echo form_dropdown('status', $options); 
                  }
                  if($mark == 'tab2'){
                    $options = array('1'  => 'Prevendido');
                    echo form_dropdown('status', $options, '1'); 
                  }
                  if($mark == 'tab3'){
                    $options = array('3'  => 'Distribuido');
                    echo form_dropdown('status', $options, '1'); 
                  }
                  if($mark == 'tab5'){
                    $options = array('4'  => 'Cancelado');
                    echo form_dropdown('status', $options, '4'); 
                  }
                  if($mark == 'tab7'){
                    $options = array('5'  => 'Transaccion Temporal');
                    echo form_dropdown('status', $options, '1'); 
                  }
                  if($mark == 'tab6'){
                    $options = array('6'  => 'Venta Directa');
                    echo form_dropdown('status', $options, '1'); 
                  }
                  if($mark == 'tab8'){
                    $options = array('7'  => 'Transaccion 0');
                    echo form_dropdown('status', $options, '1'); 
                  }
                ?>
              </div>
            </div>   

            <div class="control-group selected_1">
              <label class="control-label" for="channel">Usuario</label>
              <div class="controls">
                <?php echo form_dropdown('filter_tab1_user', $user); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="commercetype">Tipo de Comercio</label>
              <div class="controls">
                <?php echo form_dropdown('filter_tab1_commerce', $commerce); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="channel">Canal</label>
              <div class="controls">
                <?php echo form_dropdown('filter_tab1_channel', $channel); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="name">Nombre del negocio:</label>
              <div class="controls">
                <?php 
                echo form_input(array('name' => 'namecommerce', 'class' => 'span4'), set_value('namecommerce'));
                echo form_error('namecommerce');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="code">Codigo:</label>
              <div class="controls">
                <?php 
                echo form_input(array('name' => 'code', 'class' => 'span3'), set_value('code'));
                echo form_error('code');
                ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="city">Ciudad</label>
              <div class="controls">
                <?php echo form_dropdown('city', $city); ?>
              </div>
            </div>

            <div class="control-group selected_1">
              <label class="control-label" for="area">Zona</label>
              <div class="controls">
                <?php echo form_dropdown('area', $area); ?>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="subarea">Sub Zona</label>
              <div class="controls">
                <?php echo form_dropdown('subarea', $subarea); ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="channel">Ordenar por</label>
              <div class="controls">
                 <?php 
                 if($mark == 'tab7'){
                    $options = array(                    
                      'transaction.idTransaction'  => 'Codigo de transaccion',
                      'users.idUser'  => 'Creado por'
                    );
                  }else{
                    $options = array(                    
                      'transaction.idTransaction'  => 'Codigo de transaccion',
                      'users.idUser'  => 'Creado por',
                      'customer.idCustomer'  => 'Cliente',
                      'customer.CodeCustomer'  => 'Codigo de Cliente',
                      'transaction.Estado'  => 'Estado',
                      'blog.FechaHoraInicio'  => 'Fecha'
                    );
                  }
                  echo form_dropdown('orderSelect', $options); 
                ?>
              </div>
            </div>

            <div class="form-actions span7">
              <input class="btn btn-primary" type="submit" name="submit" value="Buscar" />
              <input id="btn_clean" class="btn btn-primary" type="reset" value="Limpiar" >
            </div>

          </fieldset>
      </div>
    </div>
  </div>
</div>
<?php 
    echo form_close();
  }
?>

          <div id="">
            <?php
              $data['category'] = 'transaction';
              $this->load->view('transaction/'.$mark, $data);
            ?>
          </div>
          
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

  console.log(mark+"-----");
  if(mark == null)
    mark = "t_1";
    
  $("." + mark).addClass('active');

</script>

