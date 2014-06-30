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
                            <?php
                              if ($liquidation[0]->mark == 'cargaextra1' || $liquidation[0]->mark == 'cargaextra2' || $liquidation[0]->mark == 'cargaextra3') {
                                echo '<th colspan="2" class="title">
                                  <div class="main">CARGA EXTRA 1</div>
                                  <div class="section">P</div>
                                  <div class="section">U</div>
                                </th>';
                              }
                              if ($liquidation[0]->mark == 'cargaextra2' || $liquidation[0]->mark == 'cargaextra3') {
                                echo '<th colspan="2" class="title">
                                  <div class="main">CARGA EXTRA 2</div>
                                  <div class="section">P</div>
                                  <div class="section">U</div>
                                </th>';
                              }
                              if ($liquidation[0]->mark == 'cargaextra3') {
                                echo '<th colspan="2" class="title">
                                  <div class="main">CARGA EXTRA 3</div>
                                  <div class="section">P</div>
                                  <div class="section">U</div>
                                </th>';
                              }
                            ?>
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

                              $cargainicialPline += $rowproducts["previousDayU"];
                              $cargainicialUline += $rowproducts["previousDayP"];
                              $cargaPline += $rowproducts["chargeP"];
                              $cargaUline += $rowproducts["chargeU"];
                              $cargaExtra1Pline += $rowproducts["chargeExtraP1"];
                              $cargaExtra1Uline += $rowproducts["chargeExtraU1"];
                              $cargaExtra2Pline += $rowproducts["chargeExtraP2"];
                              $cargaExtra2Uline += $rowproducts["chargeExtraU2"];
                              $cargaExtra3Pline += $rowproducts["chargeExtraP3"];
                              $cargaExtra3Uline += $rowproducts["chargeExtraU3"];
                              $totalPline += $totalchargep;
                              $totalUline += $totalchargeu;
                          ?>
                            <tr>
                              <td class="vol"><?php echo $rowproducts["volume"]; ?></td>
                              <td class="productname"><?php echo $rowproducts["Nombre"]; ?></td>
                              <!-- previous charge -->
                              <td class="unity"><?php echo $rowproducts["previousDayP"]; ?></td>
                              <td class="unity"><?php echo $rowproducts["previousDayU"]; ?></td>
                              
                              <!-- main charge -->
                              <td class="unity"><?php echo $rowproducts["chargeP"]; ?></td>
                              <td class="unity"><?php echo $rowproducts["chargeU"]; ?></td>

                              <?php
                                if ($liquidation[0]->mark == 'cargaextra1' || $liquidation[0]->mark == 'cargaextra2' || $liquidation[0]->mark == 'cargaextra3') {
                                  echo '<td class="unity">'.$rowproducts["chargeExtraP1"].'</td>';
                                  echo '<td class="unity">'.$rowproducts["chargeExtraU1"].'</td>';
                                }
                                if ($liquidation[0]->mark == 'cargaextra2' || $liquidation[0]->mark == 'cargaextra3') {
                                  echo '<td class="unity">'.$rowproducts["chargeExtraP2"].'</td>';
                                  echo '<td class="unity">'.$rowproducts["chargeExtraU2"].'</td>';
                                }
                                if ($liquidation[0]->mark == 'cargaextra3') {
                                  echo '<td class="unity">'.$rowproducts["chargeExtraP3"].'</td>';
                                  echo '<td class="unity">'.$rowproducts["chargeExtraU3"].'</td>';
                                }

                              ?>
                              <!-- total charge -->
                              <td class="unity info"><?php echo $totalchargep; ?></td>
                              <td class="unity info"><?php echo $totalchargeu; ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                        <!--<tfooter>
                          <tr class="footer">
                            <td class="vol">&nbsp;</td>
                            <td class="productname">&nbsp;</td>
                            <td class="unity"><?php //echo $cargainicialPline; ?></td>
                            <td class="unity"><?php //echo $cargainicialUline; ?></td>
                            <td class="unity"><?php //echo $cargaPline; ?></td>
                            <td class="unity"><?php //echo $cargaUline; ?></td>
                            <?php
                              //'chargeExtraP1'  => floor($rowproduct->chargeExtra1 / $rowproduct->uxp),
                              //'chargeExtraU1'  => round(($rowproduct->chargeExtra1 % $rowproduct->uxp), 0),
                              /*if ($liquidation[0]->mark == 'cargaextra1' || $liquidation[0]->mark == 'cargaextra2' || $liquidation[0]->mark == 'cargaextra3') {
                                echo '<td class="unity">'.$cargaExtra1Pline.'</td>';
                                echo '<td class="unity">'.$cargaExtra1Uline.'</td>';
                              }
                              if ($liquidation[0]->mark == 'cargaextra2' || $liquidation[0]->mark == 'cargaextra3') {
                                echo '<td class="unity">'.$cargaExtra2Pline.'</td>';
                                echo '<td class="unity">'.$cargaExtra2Uline.'</td>';
                              }
                              if ($liquidation[0]->mark == 'cargaextra3') {
                                echo '<td class="unity">'.$cargaExtra3Pline.'</td>';
                                echo '<td class="unity">'.$cargaExtra3Uline.'</td>';
                              }*/
                            ?>
                            <td class="unity"><?php //echo $totalPline; ?></td>
                            <td class="unity"><?php //echo $totalUline; ?></td>
                          </tr>
                        </tfooter>-->
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