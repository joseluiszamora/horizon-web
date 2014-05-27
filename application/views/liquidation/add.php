<!--<div ng-controller="firstControllerScope">
  <h3>First controller</h3>
  <strong>First name:</strong> {{firstName}}<br />
  <label>Set the first name: <input type="text" ng-model="firstName"/></label><br />
  <br />
  <div ng-controller="secondControllerScope">
    <h3>Second controller (inside First)</h3>
    <strong>First name (from First):</strong> {{firstName}}<br />
    <strong>Last name (new variable):</strong> {{lastName}}<br />
    <strong>Full name:</strong> {{getFullName()}}<br />
    <br />
    <label>Set the first name: <input type="text" ng-model="firstName"/></label><br />
    <label>Set the last name: <input type="text" ng-model="lastName"/></label><br />
    <br />
    <div ng-controller="thirdControllerScope">
      <h3>Third controller (inside Second and First)</h3>
      <strong>First name (from First):</strong> {{firstName}}<br />
      <strong>Middle name (new variable):</strong> {{middleName}}<br />
      <strong>Last name (from Second):</strong> {{$parent.lastName}}<br />
      <strong>Last name (redefined in Third):</strong> {{lastName}}<br />
      <strong>Full name (redefined in Third):</strong> {{getFullName()}}<br />
      <br />
      <label>Set the first name: <input type="text" ng-model="firstName"/></label><br />
      <label>Set the middle name: <input type="text" ng-model="middleName"/></label><br />
      <label>Set the last name: <input type="text" ng-model="lastName"/></label>
    </div>
  </div>
</div>
-->
<div ng-controller="firstControllerObj">
  <h3>First controller</h3>
  <strong>First name:</strong> {{firstModelObj.firstName}}<br />
  <br />
  <label>Set the first name: <input type="text" ng-model="firstModelObj.firstName"/></label><br />
  <br />
  <div ng-controller="secondControllerObj">
    <h3>Second controller (inside First)</h3>
    <strong>First name (from First):</strong> {{firstModelObj.firstName}}<br />
    <strong>Last name (from Second):</strong> {{secondModelObj.lastName}}<br />
    <strong>Full name:</strong> {{getFullName()}}<br />
    <br />
    <label>Set the first name: <input type="text" ng-model="firstModelObj.firstName"/></label><br />
    <label>Set the last name: <input type="text" ng-model="secondModelObj.lastName"/></label><br />
    <br />
    <div ng-controller="thirdControllerObj">
      <h3>Third controller (inside Second and First)</h3>
      <strong>First name (from First):</strong> {{firstModelObj.firstName}}<br />
      <strong>Middle name (from Third):</strong> {{thirdModelObj.middleName}}<br />
      <strong>Last name (from Second):</strong> {{secondModelObj.lastName}}<br />
      <strong>Last name (from Third):</strong> {{thirdModelObj.lastName}}<br />
      <strong>Full name (redefined in Third):</strong> {{getFullName()}}<br />
      <br />
      <label>Set the first name: <input type="text" ng-model="firstModelObj.firstName"/></label><br />
      <label>Set the middle name: <input type="text" ng-model="thirdModelObj.middleName"/></label><br />
      <label>Set the last name: <input type="text" ng-model="thirdModelObj.lastName"/></label>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">CARGA DE PRODUCTOS</h3>
  </div>
</div>


<div class="row">
  <div ng-controller="ControllerZero">
    <input ng-model="message" >
    <button ng-click="handleClick(message);">LOG</button>
  </div>

  <div ng-controller="ControllerOne">
    <input ng-model="message" >
  </div>

  <div ng-controller="ControllerTwo">
    <input ng-model="message" >
  </div>
</div>

<div class="row" ng-controller="secondController">
  <h2>Model managed by the second controller</h2>
  <strong>First name:</strong> {{firstName}}<br />
  <strong>Middle name:</strong> {{middleName}}<br />
  <strong>Last name:</strong> <span ng-bind="lastName"></span><br />
  <strong>Full name:</strong> {{getFullName()}}<br />
  <br />
  <label>Set the first name: <input type="text" ng-model="firstName"/></label><br />
  <label>Set the middle name: <input type="text" ng-model="middleName"/></label><br />
  <label>Set the last name: <input type="text" ng-model="lastName"/></label>
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

            <table class="table table-bordered tableLine" ng-repeat="line in liquidation.lines | orderBy: 'name'">
              <tbody>
                <tr>
                  <td class="line">
                    <div class="rotate">{{ line.nameLine | uppercase }}</div>
                  </td>
                  <td class="subTableContainer">
                    <table class="table table-bordered subTable">
                      <tbody>

                      <div ng-controller="thirdControllerObj">
                        <h3>Third controller (inside Second and First)</h3>
                        <strong>First name (from First):</strong> {{firstModelObj.firstName}}<br />
                        <strong>Middle name (from Third):</strong> {{thirdModelObj.middleName}}<br />
                        <strong>Last name (from Second):</strong> {{secondModelObj.lastName}}<br />
                        <strong>Last name (from Third):</strong> {{thirdModelObj.lastName}}<br />
                        <strong>Full name (redefined in Third):</strong> {{getFullName()}}<br />
                        <br />
                        <label>Set the first name: <input type="text" ng-model="firstModelObj.firstName"/></label><br />
                        <label>Set the middle name: <input type="text" ng-model="thirdModelObj.middleName"/></label><br />
                        <label>Set the last name: <input type="text" ng-model="thirdModelObj.lastName"/></label>
                      </div>
                      
                        <tr ng-repeat="product in line.products">
                          <td class="vol">{{ product.volume | uppercase }}</td>
                          <td class="productname">{{ product.Nombre | uppercase }}</td>
                          <!-- previous charge -->
                          <td class="unity">{{ product.previousDayP }}</td>
                          <td class="unity">{{ product.previousDayU }}</td>
                          <!-- charge -->
                          <td class="unity"> 
                            <input ng-model="productCtrl.product.chargeP" type="number" class="inputSmall" />
                          </td>
                          <td class="unity">
                            <input ng-model="productCtrl.product.chargeU" type="number" class="inputSmall" />
                          </td>
                          <!-- extra charge -->
                          <td class="unity">{{ product.chargeExtraP }}</td>
                          <td class="unity">{{ product.chargeExtraU }}</td>
                          <!-- total charge -->
                          <td class="unity info">{{ productCtrl.product.chargeP + productCtrl.product.chargeU }}</td>
                          <td class="unity info">{{ product.chargeTotalU }}</td>
                          <td class="total">{{ product.totalAmmount | currency }}</td>
                          <td><input type="submit" class="btn btn-primary pull-right" value="Ok" /></td>
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
                  <td>{{ line.totalAmmount }}</td>
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