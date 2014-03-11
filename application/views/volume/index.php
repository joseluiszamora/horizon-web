<div class="container">

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Volúmenes</h1>
    </div>

    <div class="span8 smallTableCenter">
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">Activos</a></li>
          <li><?php 
          if($this->Account_Model->get_profile() == '1')
            echo anchor('volume/create', 'Nuevo Volumen', array('class' => 'btnAdd btnTitle btn btn-primary'));
          ?></li>          
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <?php
              $data['category'] = 'client';
              $this->load->view('volume/tab1', $data);
            ?>
          </div>
          <div class="tab-pane" id="tab2">
            <?php
              $data['category'] = 'volume';
              //$this->load->view('area/tab3', $data);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>