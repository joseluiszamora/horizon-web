<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">CARGA DE PRODUCTOS</h3>
  </div>
</div>

<div id="liquidations" class="row" >
  <div class="col-lg-12">
      <div class="panel panel-default" ng-controller="LiquidationController as liquidation">
        <div class="panel-heading">
          <ul class="selectorCheck">
            <li ng-repeat="lineName in liquidation.lines | orderBy: 'name'" ng-controller="Controller">
              <label for="check1">{{ lineName.nameLine }}</label>
              <input type="checkbox" id="check1" ng-model="confirmed" ng-true-value="settrue()" ng-false-value="setfalse()" ng-change="changed(lineName)">
            </li>            
          </ul>

        </div>




<script>
  function Ctrl($scope) {
    $scope.list = [];
    $scope.text = 'hello';
    $scope.submiting = function() {
      if ($scope.text) {
        console.log("QQQ");
        $scope.list.push(this.text);
        $scope.text = '';
      }
    };
  }
</script>
<form ng-submit="submiting()" ng-controller="Ctrl">
                            Enter text and hit enter:
                            <input type="text" ng-model="text" name="text" />
                            <input type="submit" id="submit" value="Submit" />
                            <pre>list={{list}}</pre>
                          </form>



        <div class="panel-body">
          <div class="table-responsive">
            
            <div ng-repeat="line in liquidation.lines | orderBy: 'name'" ng-controller="lineControllerObj">

              <table class="table table-bordered tableLine">
                <tbody>
                  <tr>
                    <td class="line">
                      {{ line.nameLine}} <input type="checkbox" ng-model="lineControllerObj.visible">
                    </td>
                    <td colspan="3" class="subTableContainer" >
                      <table class="table table-bordered subTable" ng-show="lineControllerObj.visible">
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
                            <th colspan="2" class="title">
                              <div class="main">TOTAL CARGADO</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                         <tr ng-repeat="product in line.products" ng-controller="productControllerObj">
                          
                          <form novalidate name="productForm" ng-submit="lineControllerObj.xcc()">
                              <td class="vol">{{ product.volume | uppercase }}</td>
                              <td class="productname">{{ product.Nombre | uppercase }}</td>
                              <!-- previous charge -->
                              <td class="unity">{{ product.previousDayP }}</td>
                              <td class="unity">{{ product.previousDayU }}</td>
                              <!-- charge -->
                              <td class="unity"> 
                                <input name="cargap" ng-model="productControllerObj.cargaP" type="number" class="inputSmall"/>
                              </td>
                              <td class="unity">
                                <input name="cargau" ng-model="productControllerObj.cargaU" type="number" class="inputSmall"/>
                              </td>
                              <!-- total charge -->
                              <td class="unity info">{{ getCargaP() }}</td>
                              <td class="unity info">{{ getCargaU() }}</td>
                              <td><input type="submit" id="submit" value="Submit" /></td>
                            </form>
                          </tr>

                        </tbody>
                        <tfooter> 
                          <tr class="footer">
                            <td class="vol">&nbsp;</td>
                            <td class="productname">&nbsp;</td>
                            <td class="unity">0</td>
                            <td class="unity">0</td>
                            <td class="unity">{{ getCargaPLine() }}</td>
                            <td class="unity">{{ getCargaULine() }}</td>
                            <td class="unity">{{ getTotalPLine() }}</td>
                            <td class="unity">{{ getTotalULine() }}</td>
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

    <div class="col-lg-4">
    <div class="panel panel-default">
      <div class="panel-heading"> TOTALES</div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>VENTA</th>
                <th>COBRO</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>444.00</td>
                <td>999.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>