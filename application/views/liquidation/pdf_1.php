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
        <div class="panel-heading"> Lineas </div>

        <div class="panel-body">
          <div class="table-responsive">
            <?php
              foreach ($lines as $rowline) {
                $cargainicialPline = 0;
                $cargainicialUline = 0;
                $cargaPline = 0;
                $cargaUline = 0;
                $cargaExtra1Pline = 0;
                $cargaExtra1Uline = 0;
                $cargaExtra2Pline = 0;
                $cargaExtra2Uline = 0;
                $cargaExtra3Pline = 0;
                $cargaExtra3Uline = 0;
                $totalPline = 0;
                $totalUline = 0;
            ?>
              <table class="table table-bordered tableLine">
                <tbody>
                  <tr>
                    <td class="line"><?php echo $rowline["nameLine"]; ?></td>
                    <td colspan="3" class="subTableContainer" >
                      <table class="table table-bordered subTable">
                        <thead>
                          <tr>
                            <th class="vol">CODIGO</th>
                            <th class="productname">PRODUCTO</th>
                            <th colspan="2" class="title" >
                              <div class="main">TOTAL CARGADO</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            foreach ($rowline["products"] as $rowproducts){
                              $totalchargeu = $rowproducts["previousDayU"] + $rowproducts["chargeU"]+ $rowproducts["chargeExtraU1"]+ $rowproducts["chargeExtraU2"]+ $rowproducts["chargeExtraU3"];
                              $totalchargep = $rowproducts["previousDayP"] + $rowproducts["chargeP"]+ $rowproducts["chargeExtraP1"]+ $rowproducts["chargeExtraP2"]+ $rowproducts["chargeExtraP3"];
                              $totalPline += $totalchargep;
                              $totalUline += $totalchargeu;
                          ?>
                            <tr>
                              <td class="vol"><?php echo $rowproducts["idProduct"]; ?></td>
                              <td class="productname"><?php echo $rowproducts["Nombre"]; ?></td>
                              <!-- total charge -->
                              <td class="unity info"><?php echo $totalchargep; ?></td>
                              <td class="unity info"><?php echo $totalchargeu; ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
</div>