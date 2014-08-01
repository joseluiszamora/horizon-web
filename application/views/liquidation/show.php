<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">VER</h3>
  </div>
</div>

<div class="row">
  <div class="col-md-offset-1 col-md-9">
    <fieldset> 
      <div style="display:none;" id="idLiquidation"><?php echo $liquidation[0]->idLiquidacion;?></div>
      <div class="form-group col-md-4 col-xs-4">
        <label for="exampleInputEmail1">Distribuidor</label>
        <?php echo $liquidation[0]->Nombre." ".$liquidation[0]->Apellido; ?>
      </div>

      <div class="form-group col-md-4 col-xs-4">
        <label for="exampleInputEmail1">Ruta</label>
        <?php echo $liquidation[0]->Descripcion; ?>
      </div>

      <div class="form-group col-md-4 col-xs-4">
        <label for="exampleInputEmail1">Fecha</label>
        <?php echo $liquidation[0]->fechaRegistro; ?>
      </div>

      <div class="form-group col-md-4 col-xs-4">
        <label for="exampleInputEmail1">Observaciones</label>
        <?php echo $liquidation[0]->detalle; ?>
      </div>
      
      <div class="form-group col-md-4 col-xs-4">
        <label for="exampleInputEmail1">Estado</label>
        <div id="markLiquidation"><?php echo $liquidation[0]->mark; ?></div>
      </div>
    </fieldset>
  </div>
</div>

<div id="liquidations" class="row" >
  <div class="col-lg-12">
      <div class="panel panel-default" ng-controller="LiquidationController as liquidation">
        <div class="panel-heading">
          <ul class="selectorCheck">
            <li ng-repeat="lineName in liquidation.lines | orderBy: 'name'">
              <label for="{{ lineName.idLine }}">{{ lineName.nameLine }}</label>
              <input type="checkbox" id="{{ lineName.idLine }}" ng-model="lineName.show">
            </li>            
          </ul>
        </div>

        <div class="panel-body">
          <div class="table-responsive">
            
            <div ng-repeat="line in liquidation.lines | orderBy: 'name'" ng-controller="lineControllerObj">

              <table class="table table-bordered tableLine">
                <tbody>
                  <tr>
                    <td class="line">
                      {{ line.nameLine}}
                    </td>
                    <td colspan="3" class="subTableContainer" >
                      <table class="table table-bordered subTable" ng-show="getVisible(line)">
                        <thead>
                          <tr>
                            <th class="vol">VOLUMEN</th>
                            <th class="productname">PRODUCTO</th>
                            <th colspan="2" class="title">
                              <div class="main">DIA ANTERIOR</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title">
                              <div class="main">CARGA</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'cargaextra1' || liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'" >
                              <div class="main">CARGA EXTRA 1</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">
                              <div class="main">CARGA EXTRA 2</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'cargaextra3'">
                              <div class="main">CARGA EXTRA 3</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" >
                              <div class="main">TOTAL CARGADO</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-repeat="product in line.products" ng-controller="productControllerObj">
                            <td class="vol">{{ product.volume | uppercase }}</td>
                            <td class="productname">{{ product.Nombre | uppercase }}</td>
                            <!-- previous charge -->
                            <td class="unity">{{ product.previousDayP }}</td>
                            <td class="unity">{{ product.previousDayU }}</td>
                            
                            <!-- main charge -->
                            <td class="unity">{{ product.chargeP }} </td>
                            <td class="unity"> {{ product.chargeU }} </td>

                            <!-- extra charge 1-->
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra1' || liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">{{ product.chargeExtraP1 }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra1' || liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">{{ product.chargeExtraU1 }}</td>

                            <!-- extra charge 2-->
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">{{ product.chargeExtraP2 }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">{{ product.chargeExtraU2 }}</td>

                            <!-- extra charge 3-->
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra3'">{{ product.chargeExtraP3 }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra3'">{{ product.chargeExtraU3 }}</td>

                            <!-- total charge -->
                            <td class="unity info">{{ getCargaP(product) }}</td>
                            <td class="unity info">{{ getCargaU(product) }}</td>
                          </tr>

                        </tbody>
                        <tfooter>
                          <tr class="footer">
                            <td class="vol">&nbsp;</td>
                            <td class="productname">&nbsp;</td>
                            <td class="unity">{{ getCargaInicialPLine(line.products) }}</td>
                            <td class="unity">{{ getCargaInicialULine(line.products) }}</td>
                            <td class="unity">{{ getCargaPLine(line.products) }}</td>
                            <td class="unity">{{ getCargaULine(line.products) }}</td>

                            <td class="unity" ng-show="liquidation.mark === 'cargaextra1' || liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">{{ getCargaExtra1PLine(line.products) }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra1' || liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">{{ getCargaExtra1ULine(line.products) }}</td>

                            <td class="unity" ng-show="liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">{{ getCargaExtra2PLine(line.products) }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra2' || liquidation.mark === 'cargaextra3'">{{ getCargaExtra2ULine(line.products) }}</td>

                            <td class="unity" ng-show="liquidation.mark === 'cargaextra3'">{{ getCargaExtra3PLine(line.products) }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'cargaextra3'">{{ getCargaExtra3ULine(line.products) }}</td>

                            <td class="unity">{{ getTotalPLine(line.products) }}</td>
                            <td class="unity">{{ getTotalULine(line.products) }}</td>
                          </tr>
                        </tfooter>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>