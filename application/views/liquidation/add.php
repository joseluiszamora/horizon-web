<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">CARGA DE PRODUCTOS</h3>
  </div>
</div>

<div id="liquidations" class="row" >
  <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"> INPUT </div>

        <div class="panel-body">
          <div class="table-responsive" ng-controller="LiquidationController as liquidation">
            
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="line">LINEA</th>
                  <th class="vol">VOL</th>
                  <th class="productname">PRODUCTO</th>
                  <th colspan="4" class="subTableContainer">
                    <table class="table table-bordered subTable">
                      <tbody>
                        <tr>
                          <th colspan="18">DIARIO</th>
                        </tr>
                        <tr>
                          <th colspan="2">DIA ANT.</th>
                          <th colspan="2">CARGA</th>
                          <th colspan="2">CARGA EXTRA</th>
                          <th colspan="2">TOTAL C.</th>
                          <th rowspan="2" class="total">TOTAL</th>
                          <th rowspan="2">&nbsp;</th>
                        </tr>
                        <tr>
                          <th class="unity">P</th>
                          <th class="unity">U</th>
                          <th class="unity">P</th>
                          <th class="unity">U</th>
                          <th class="unity">P</th>
                          <th class="unity">U</th>
                          <th class="unity">P</th>
                          <th class="unity">U</th>
                        </tr>
                      </tbody>
                    </table>
                  </th>
                </tr>
              </thead>
            </table>

            <table class="table table-bordered tableLine" ng-repeat="line in liquidation.lines | orderBy: 'name'" ng-controller="lineControllerObj">
              <tbody>
                <tr>
                  <td class="line">
                    <form name="myForm">
                      {{ line.nameLine}} <input type="checkbox" ng-model="lineControllerObj.visible"> <br/>
                      <tt>value1 = {{lineControllerObj.visible}}</tt><br/>
                    </form>
                    <!--<div class="rotate">{{ line.nameLine | uppercase }}</div>-->
                  </td>
                  <td class="subTableContainer">
                    <table class="table table-bordered subTable">
                      <tbody>
                       <tr ng-repeat="product in line.products" ng-controller="productControllerObj">
                          <td class="vol">{{ product.volume | uppercase }}</td>
                          <td class="productname">{{ product.Nombre | uppercase }}</td>
                          <!-- previous charge -->
                          <td class="unity">{{ product.previousDayP }}</td>
                          <td class="unity">{{ product.previousDayU }}</td>
                          <!-- charge -->
                          <td class="unity"> 
                            <input ng-model="productControllerObj.cargaP" type="number" class="inputSmall"/>
                          </td>
                          <td class="unity">
                            <input ng-model="productControllerObj.cargaU" type="number" class="inputSmall"/>
                          </td>
                          <!-- extra charge -->
                          <td class="unity"> 
                            <input ng-model="productControllerObj.cargaExtraP" type="number" class="inputSmall"/>
                          </td>
                          <td class="unity">
                            <input ng-model="productControllerObj.cargaExtraU" type="number" class="inputSmall"/>
                          </td>
                          <!-- total charge -->
                          <td class="unity info">{{ getCargaP() }}</td>
                          <td class="unity info">{{ getCargaU() }}</td>
                          <td class="total">{{ getTotalPrice(product) | currency}}</td>
                        </tr>

                      </tbody>
                      <tfooter> 
                        <tr class="footer">
                          <td class="vol">&nbsp;</td>
                          <td class="productname">&nbsp;</td>
                          <td class="unity">daP</td>
                          <td class="unity">daU</td>
                          <td class="unity">cP</td>
                          <td class="unity">cU</td>
                          <td class="unity">ceP</td>
                          <td class="unity">ceU</td>
                          <td class="total">&nbsp;</td>
                        </tr>
                      </tfooter>
                    </table>
                  </td>
                  <td>{{ getAmmountLine() }}</td>
                </tr>
              </tbody>
            </table>

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