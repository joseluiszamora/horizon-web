<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">VER</h3>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <fieldset> 
      <div style="display:none;" id="idLiquidation"><?php echo $liquidation[0]->idLiquidacion;?></div>
      <div class="form-group col-md-2 col-xs-4">
        <label for="exampleInputEmail1">Distribuidor</label>
        <br>
        <?php echo $liquidation[0]->Nombre." ".$liquidation[0]->Apellido; ?>
      </div>

      <div class="form-group col-md-1 col-xs-4">
        <label for="exampleInputEmail1">Ruta</label>
        <br>
        <?php echo $liquidation[0]->Descripcion; ?>
      </div>

      <div class="form-group col-md-1 col-xs-4">
        <label for="exampleInputEmail1">Fecha</label>
        <br>
        <?php echo $liquidation[0]->fechaRegistro; ?>
      </div>

      <div class="form-group col-md-1 col-xs-4">
        <label for="exampleInputEmail1">Estado</label>
        <br>
        <div id="markLiquidation"><?php echo $liquidation[0]->mark; ?></div>
      </div>

      <div class="form-group col-md-4 col-xs-4">
        <label for="exampleInputEmail1">Observaciones</label>
        <br>
        <?php echo $liquidation[0]->detalle; ?>
      </div>
    </fieldset>
  </div>
</div>

<div id="liquidations" class="row" >
  <div class="col-lg-12">
      <div class="panel panel-default">
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
                            <th colspan="2" class="title">
                              <div class="main">C. EXTRA 1</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title">
                              <div class="main">C. EXTRA 2</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title">
                              <div class="main">C. EXTRA 3</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" >
                              <div class="main">TOTAL C.</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'completado'">
                              <div class="main">DEV</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'completado'">
                              <div class="main">PRES</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'completado'">
                              <div class="main">BON</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'completado'">
                              <div class="main">AJUSTE</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'completado'">
                              <div class="main">VENTA CALC.</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" ng-show="liquidation.mark === 'completado'">
                              <div class="main">VENTA ANDROID</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th class="title" ng-show="liquidation.mark === 'completado'">TOTAL (Bs)</th>
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
                            <td class="unity">{{ product.chargeExtraP1 }}</td>
                            <td class="unity">{{ product.chargeExtraU1 }}</td>

                            <!-- extra charge 2-->
                            <td class="unity">{{ product.chargeExtraP2 }}</td>
                            <td class="unity">{{ product.chargeExtraU2 }}</td>

                            <!-- extra charge 3-->
                            <td class="unity">{{ product.chargeExtraP3 }}</td>
                            <td class="unity">{{ product.chargeExtraU3 }}</td>

                            <!-- total charge -->
                            <td class="unity info">{{ getCargaP(product) }}</td>
                            <td class="unity info">{{ getCargaU(product) }}</td>

                            <!-- devolution charge -->
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ product.devolutionP }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ product.devolutionU }}</td>

                            <!-- devolution prestamos -->
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ product.prestamosP }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ product.prestamosU }}</td>

                            <!-- devolution bonificacion -->
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ product.bonosP }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ product.bonosU }}</td>

                            <!-- Ajuste -->
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ product.ajusteP }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ product.ajusteU }}</td>

                            <!-- TOTAL venta CALC -->
                            <td class="unity info" ng-show="liquidation.mark === 'completado'">{{ calculateSoldP(product) }}</td>
                            <td class="unity info" ng-show="liquidation.mark === 'completado'">{{ calculateSoldU(product) }}</td>

                            <!-- Venta Android -->
                            <td class="unity success" ng-show="liquidation.mark === 'completado'">0</td>
                            <td class="unity success" ng-show="liquidation.mark === 'completado'">0</td>

                            <!-- total venta -->
                            <!--<td class="unity">{{ getTotalAmmount(product) }}</td>-->
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ totalAmmountProduct(product) | number:2 }}</td>
                          </tr>
                        </tbody>
                        <tfooter>
                          <tr class="footer">
                            <td class="vol">&nbsp;</td>
                            <td class="productname">&nbsp;</td>
                            <td class="unity">{{ getCargaInicialPLine(line.products) }}</td>
                            <td class="unity">{{ getCargaInicialULine(line.products) }}</td>
                            <td class="unity">{{ getCargaPLine(line.products, line.lineUxp) }}</td>
                            <td class="unity">{{ getCargaULine(line.products, line.lineUxp) }}</td>

                            <td class="unity">{{ getCargaExtra1PLine(line.products, line.lineUxp) }}</td>
                            <td class="unity">{{ getCargaExtra1ULine(line.products, line.lineUxp) }}</td>

                            <td class="unity">{{ getCargaExtra2PLine(line.products, line.lineUxp) }}</td>
                            <td class="unity">{{ getCargaExtra2ULine(line.products, line.lineUxp) }}</td>

                            <td class="unity">{{ getCargaExtra3PLine(line.products, line.lineUxp) }}</td>
                            <td class="unity">{{ getCargaExtra3ULine(line.products, line.lineUxp) }}</td>

                            <td class="unity">{{ getTotalPLine(line.products, line.lineUxp) }}</td>
                            <td class="unity">{{ getTotalULine(line.products, line.lineUxp) }}</td>

                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ getDevolutionPLine(line.products, line.lineUxp) }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ getDevolutionULine(line.products, line.lineUxp) }}</td>

                            <td class="unity" ng-show="liquidation.mark === 'completado'">0</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">0</td>

                            <td class="unity" ng-show="liquidation.mark === 'completado'">0</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">0</td>

                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ getAjustePLine(line.products, line.lineUxp) }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ getAjusteULine(line.products, line.lineUxp) }}</td>

                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ getCalculatedPLine(line.products, line.lineUxp) }}</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">{{ getCalculatedULine(line.products, line.lineUxp) }}</td>

                            <td class="unity" ng-show="liquidation.mark === 'completado'">0</td>
                            <td class="unity" ng-show="liquidation.mark === 'completado'">0</td>

                            <td class="unity success" ng-show="liquidation.mark === 'completado'">{{ getAmmountLine(line.products) | number:2 }}</td>
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

<div class="row" ng-show="liquidation.mark === 'completado'" >
  <div class="col-lg-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        GASTOS
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered subTable" >
            <thead>
              <tr>
                <th class="vol">GASTO</th>
                <th class="productname">MONTO</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="expense in liquidation.expenses" ng-show="expense.ammount > 0">
                <td class="unity">{{ expense.title | uppercase }}</td>
                <td class="unity">{{ expense.ammount | uppercase }}</td>
              </tr>
            </tbody>
            <tfooter>
              <tr class="footer">
                <td class="unity">TOTAL GASTO</td>
                <td class="unity success" ng-controller="expenseController">{{ getTotalExpenses(liquidation.expenses) | number:2 }}</td>
              </tr>
            </tfooter>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        COBRANZAS
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered subTable">
            <thead>
              <tr>
                <th class="vol">RECIBO</th>
                <th class="productname">MONTO</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="unity">0</td>
                <td class="unity">0</td>
              </tr>
            </tbody>
            <tfooter>
              <tr class="footer">
                <td class="unity">TOTAL</td>
                <td class="unity success">0</td>
              </tr>
            </tfooter>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        TOTALES
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered subTable">
            <tbody>
              <tr>
                <td class="unity bold">TOTAL VENTAS</td>
                <td class="unity success">
                  {{ liquidation.getAmmountLineTotal() | number:2 }}
                </td>
              </tr>
              <tr>
                <td class="unity bold">+ COBRANZAS</td>
                <td class="unity success">
                  0
                </td>
              </tr>
              <tr>
                <td class="unity bold">- GASTOS</td>
                <td class="unity success" ng-controller="expenseController">
                  {{ getTotalExpenses(liquidation.expenses) | number:2 }}
                </td>
              </tr>
              <tr>
                <td class="unity bold">A ENTREGAR</td>
                <td class="unity success">
                  {{ liquidation.getTotalSendMoney() | number:2 }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>