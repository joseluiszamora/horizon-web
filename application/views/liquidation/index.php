<section class="tab" ng-controller="PanelController as tab">
  <div class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav" id="side-menu">
        <li ng-class="{active: tab.isSelected(1)}">
          <a href ng-click="tab.selectTab(1)" ><i class="fa fa-pencil-square-o fa-fw"></i> Estadisticas</a>
        </li>

        <li ng-class="{active: tab.isSelected(2)}">
          <a href ng-click="tab.selectTab(2)" ><i class="fa fa-pencil-square-o fa-fw"></i> Carga Nueva</a>
        </li>

        <li ng-class="{active: tab.isSelected(3)}">
          <a href ng-click="tab.selectTab(3)"><i class="fa fa-pencil-square-o fa-fw"></i> Cargas Realizadas</a>
        </li>

        <li ng-class="{active: tab.isSelected(4)}">
          <a href ng-click="tab.selectTab(4)"><i class="fa fa-pencil-square-o fa-fw"></i> Liquidaciones Pendientes</a>
        </li>
      </ul>
    </div>
  </div>


  <div id="page-wrapper">
    <div ng-show="tab.isSelected(1)">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header">Estadisticas</h3>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <h4>Proximamente</h4>
        </div>
      </div>
    </div>
    
    <div ng-show="tab.isSelected(2)">
      <charge-new></charge-new>
    </div>
    
    <div ng-show="tab.isSelected(3)">
      <charge-list></charge-list>
    </div>

    <div ng-show="tab.isSelected(4)">
      <h4>ooooooooooooooo</h4>
    </div>
  </div>

</section>