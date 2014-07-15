<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">DEVOLUCIÓN DE PRODUCTOS</h3>
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

      <div class="form-group col-md-2 col-xs-4">
        <label for="exampleInputEmail1">Observaciones</label>
        <br>
        <?php echo $liquidation[0]->detalle; ?>
      </div>

      <div class="form-group col-md-2 col-xs-4">
        <div style="float:right;">
            <!-- Button trigger modal -->
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Guardar</button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Guardar</h4>
                  </div>
                  <div class="modal-body">
                    <p>Atención!!! los cambios guardados no se podran modificar</p>
                    <p>Esta seguro???</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button ng-click="liquidation.saveAll()" type="button" class="btn btn-primary">Guardar cambios</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="form-group col-md-2 col-xs-4">
        <div style="float:right;">
            <!-- Button trigger modal -->
            <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#myModalIrregular">Producto Irregular</button>

            <!-- Modal -->
            <div class="modal fade" id="myModalIrregular" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content"> 
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar productos no Regulares</h4>
                  </div>
                  <div class="modal-body">
                    <p>
                      <?php
                        echo "<div style='display:none;' id='idLiquidacion'>".$liquidation[0]->idLiquidacion."</div>";
                        echo form_dropdown('noregular', $irregularlines, '', 'id="noregulardropdown" data-placeholder="Linea de productos no regulares..." class="chosen-select" multiple style="width:400px;"');
                      ?>
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" id="add_no_regular">Agregar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
                            <th colspan="2" class="title" >
                              <div class="main">DEVOLUCIONES</div>
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
                            <td class="unity">{{ product.chargeExtraP1 }}</td>
                            <td class="unity">{{ product.chargeExtraU1 }}</td>

                            <!-- extra charge 2-->
                            <td class="unity">{{ product.chargeExtraP2 }}</td>
                            <td class="unity">{{ product.chargeExtraU2 }}</td>

                            <!-- extra charge 3-->
                            <td class="unity">{{ product.chargeExtraP3 }}</td>
                            <td class="unity">{{ product.chargeExtraU3 }}</td>

                            <!-- total charge -->
                            <td class="unity info">{{ getCargaPTotal(product) }}</td>
                            <td class="unity info">{{ getCargaUTotal(product) }}</td>

                            <!-- total charge -->
                            <td class="unity success">
                              <input name="cargap" ng-model="productControllerObj.devolutionP" type="number" min="0" class="inputSmall" ng-blur="updateDevolutionP(product)" ng-change="updateDevolutionP(product)" ng-keyup="updateDevolutionP(product)" />
                            </td>
                            <td class="unity success">
                              <input name="cargau" ng-model="productControllerObj.devolutionU" type="number" min="0" class="inputSmall" ng-blur="updateDevolutionU(product)" ng-change="updateDevolutionU(product)" ng-keyup="updateDevolutionU(product)" />
                            </td>  
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

                            <td class="unity">{{ getDevolutionPLine(line.products, line.lineUxp) }}</td>
                            <td class="unity">{{ getDevolutionULine(line.products, line.lineUxp) }}</td>
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

<script type="text/javascript">
  // chosen selects
  $(".chosen-select").chosen({no_results_text: "Ningún resultado encontrado :("}); 
  $("#add_no_regular").click(function(){
    // check no regular products
    var idliquid = $("#idLiquidacion").html();
    var noregulararray = "";
    $('#noregulardropdown :selected').each(function(i, selected){ 
      noregulararray += $(selected).val() + "***";
    });

    //var url = "http://localhost/horizon/index.php/";
    var url = "https://mariani.bo/horizon-sc/index.php/";
    $.ajax({
      type: "POST",
      url: url+'liquidation/add_irregular_products/',
      data: 'idliquid='+idliquid+'&noregular='+noregulararray,
      
      async: false,
      cache: false
    }).done(function( data ) {
      //$("#modalConfirmSave").modal("show");
      //console.log(url + "liquidation/charge_list/" + data);
      window.location.reload();
    });
  });
</script>

<style type="text/css">
  .chosen-single, .chosen-drop, .chosen-results, #noregulardropdown_chosen{
    width: 400px !important;
  }
  .chosen-choices .search-field input{
    height: 30px !important;
  }
</style>