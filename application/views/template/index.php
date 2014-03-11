<div class="container">     

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Productos</h1>
      <?php echo anchor('product/create', 'Nuevo Producto', array('class' => 'btnTitle btn btn-primary')); ?>
    </div>

    <div class="span12">      
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">Activos</a></li>
          <li><a href="#tab2" data-toggle="tab">Inactivos</a></li>
          <li><a href="#tab4" class="btnSearch" data-toggle="tab"><img src="<?php echo base_url(); ?>img/glyphicons/glyphicons_027_search.png" class="bs-icon"></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <?php
              $data['category'] = 'product';
              $this->load->view('product/tab1', $data);
            ?>
          </div>
          <div class="tab-pane" id="tab2">
            <?php
              $data['category'] = 'product';
              $this->load->view('product/tab2', $data);
            ?>
          </div>
          <div class="tab-pane" id="tab4">
            <?php
              $data['category'] = 'product';
              //$this->load->view('product/tab3', $data);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>