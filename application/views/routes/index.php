<br>
<div class="container">

  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">Rutas</h3>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      
      <ul class="nav nav-tabs"  role="tablist">
        <li class="active">
          <a href="#home" data-toggle="tab">Todos</a>
        </li>
        <li>
          <?php echo anchor('routes/create', 'Nueva Ruta', array('class' => '')); ?>
        </li>
      </ul>
      <div class="tab-content">
        <div id="home" class="row tab-pane active">
          <?php
            $data['category'] = 'routes';
            $this->load->view('routes/calendar', $data);
          ?>
        </div>
      </div>
    </div>
  </div>

</div>