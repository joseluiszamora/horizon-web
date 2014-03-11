<div class="container">

  <!-- Portfolio row of columns -->
  <div id="productList" class="row">
    <div class="span12 titleTop">
      <h1 class="floatLeft">Transacciones</h1>
      <?php echo anchor('transaction/create', 'Nueva Transaccion', array('class' => 'btnTitle btn btn-primary')); ?>
    </div>

    <div class="span8 smallTableCenter">
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">Transacciones diarias</a></li>
          <li><a href="#tab2" data-toggle="tab">Transacciones sin cerrar</a></li>
          <li><a href="#tab3" class="tab_transactions" data-toggle="tab">Transacciones concluidas</a></li>
          <li><a href="#tab4" class="tab_clients" data-toggle="tab">Clientes</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <?php
              $data['category'] = 'report';
              //$this->load->view('report/transaction', $data);
            ?>
          </div>
          <div class="tab-pane active" id="tab2">
            <?php
              $data['category'] = 'transaction';
              $this->load->view('report/transaction_open', $data);
            ?>
          </div>
          <div class="tab-pane" id="tab3">
            <?php
              $data['category'] = 'report';
              $this->load->view('report/transaction', $data);
            ?>
          </div>
          <div class="tab-pane" id="tab4">
            <?php
              $data['category'] = 'report';
              $this->load->view('report/client', $data);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>