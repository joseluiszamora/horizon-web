<div class="navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
      <li>
        <?php 
          echo anchor('liquidation/create', '<i class="fa fa-pencil-square-o fa-fw"></i> Carga Nueva', array('')); 
        ?>
      </li>

      <li>
        <?php 
          echo anchor('liquidation/charge_list', '<i class="fa fa-pencil-square-o fa-fw"></i> Cargas Realizadas
          <span class="badge">'.$this->Liquidation_Model->count("all").'</span>', array('')); 
        ?>
      </li>

      <li>
        <?php 
          echo anchor('liquidation/liquidation_list', '<i class="fa fa-pencil-square-o fa-fw"></i> Liquidaciones Pendientes
          <span class="badge">'.$this->Liquidation_Model->count("liquidation").'</span>', array('')); 
        ?>
      </li>
    </ul>
  </div>
</div>

<div id="page-wrapper">

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Estadisticas</h3>
  </div>
</div>

</div>