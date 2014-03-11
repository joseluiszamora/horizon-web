<div class="container">     

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Clientes</h1>
    </div>

    <div class="span12">      
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="tab1"><?php echo anchor('client/activos', 'Activos', array('class' => '')); ?></li>
          <li class="tab2"><?php echo anchor('client/inactivos', 'Inactivos', array('class' => '')); ?></li>
          <li ><?php 
            if($this->Account_Model->get_profile() == '1' || $this->Account_Model->get_profile() == '2' || $this->Account_Model->get_profile() == '3')
              echo anchor('client/create', 'Nuevo Cliente', array('class' => 'btnAdd btnTitle btn btn-primary')); 
            ?></li>
          <li class="search"><?php echo anchor('client/search', 's', array('class' => 'btnSearch bs-icon')); ?></li>
        </ul>
        <div class="tab-content">
          <div id="">
            <?php
              $data['category'] = 'client';
              $this->load->view('client/'.$mark, $data);
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
  if(mark == null)
    mark = "t_1";
    
  $("." + mark).addClass('active');

</script>