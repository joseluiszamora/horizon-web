<div class="container">

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Productos</h1>
    </div>

    <div class="span12">
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="tab1"><?php echo anchor('product/activos', 'Activos'); ?></li>
          <li class="tab2"><?php echo anchor('product/inactivos', 'Inactivos'); ?></li>
          <li><?php 
            if($this->Account_Model->get_profile() == '1')
              echo anchor('product/create', 'Nuevo Producto', array('class' => 'btnAdd btnTitle btn btn-primary')); 
          ?></li>
          <li class="search"><?php echo anchor('product/search', 's', array('class' => 'btnSearch bs-icon')); ?></li>
        </ul>

        <div id="">
          <?php
            $this->load->view('product/'.$mark);
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
    mark = "tab1";

  $("." + mark).addClass('active');

</script>