<?php
  print_r($liquidation);
  $line = $this->Line_Model->get_all_json();
/*
foreach ($line as $rowline) {
  $productsContainer = array();
  
  $products = $this->Liquidation_Model->get_detail_list($liquidation[0]->idLiquidacion, $rowline->idLine);
  
  foreach ($products as $rowproduct){
    $arrayProducts = array(
      'idDetalleLiquidacion'     => $rowproduct->idDetalleLiquidacion,
      'idProduct'     => $rowproduct->idProduct,
      'volume'        => $rowproduct->volume,
      'Nombre'        => $rowproduct->Nombre,
      'price'        => $rowproduct->price,
      'uxp'        => $rowproduct->uxp,
      'previousDayP'  => floor($rowproduct->previousDay / $rowproduct->uxp),
      'previousDayU'  => round(($rowproduct->previousDay % $rowproduct->uxp), 0),
      'chargeP'       => floor($rowproduct->charge / $rowproduct->uxp),
      'chargeU'       => round(($rowproduct->charge % $rowproduct->uxp), 0),
      'chargeExtraP1'  => floor($rowproduct->chargeExtra1 / $rowproduct->uxp),
      'chargeExtraU1'  => round(($rowproduct->chargeExtra1 % $rowproduct->uxp), 0),
      'chargeExtraP2'  => floor($rowproduct->chargeExtra2 / $rowproduct->uxp),
      'chargeExtraU2'  => round(($rowproduct->chargeExtra2 % $rowproduct->uxp), 0),
      
      'chargeExtraP3'  => floor($rowproduct->chargeExtra3 / $rowproduct->uxp),
      'chargeExtraU3'  => round(($rowproduct->chargeExtra3 % $rowproduct->uxp), 0),

      'chargeTotalP'  => 0,
      'chargeTotalU'  => 0,

      'devolutionP'  => floor($rowproduct->devolucion / $rowproduct->uxp),
      'devolutionU'  => round(($rowproduct->devolucion % $rowproduct->uxp), 0),
      
      'prestamosP'    => 0,
      'prestamosU'    => 0,
      
      'bonosP'        => 0,
      'bonosU'        => 0,
      
      'ventaP'        => 0,
      'ventaU'        => 0,

      'totalAmmount'  => 0
    );

    array_push($productsContainer, $arrayProducts);
  }

  $line = array(
    'idLine'   => $rowline->idLine,
    'show'     => true,
    'nameLine' => $rowline->Descripcion,          
    'products' => $productsContainer
  ); 
}
*/
?>


<div id="liquidations" class="row" >
  <div class="col-lg-12">
      <div class="panel panel-default" ng-controller="LiquidationController as liquidation">
        
        <div class="panel-body">
          <div class="table-responsive">
            <?php foreach ($line as $rowline){ ?>
              <table class="table table-bordered tableLine">
                <tbody>
                  <tr>
                    <td class="line">
                      <?php echo $rowline->Descripcion; ?>
                    </td>
                    
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
                              if ($liquidation[0]->mark === 'cargado' || $liquidation[0]->mark === 'cargaextra1' || $liquidation[0]->mark === 'cargaextra2' || $liquidation[0]->mark === 'cargaextra3') { ?>
                              <th colspan="2" class="title" >
                                <div class="main">CARGA EXTRA 1</div>
                                <div class="section">P</div>
                                <div class="section">U</div>
                              </th>
                            <?php } ?>

                            <?php 
                              if ($liquidation[0]->mark === 'cargaextra1' || $liquidation[0]->mark === 'cargaextra2' || $liquidation[0]->mark === 'cargaextra3') { ?>
                              <th colspan="2" class="title" >
                                <div class="main">CARGA EXTRA 2</div>
                                <div class="section">P</div>
                                <div class="section">U</div>
                              </th>
                            <?php } ?>
                            
                            <?php 
                              if ($liquidation[0]->mark === 'cargaextra2' || $liquidation[0]->mark === 'cargaextra3') { ?>
                              <th colspan="2" class="title" >
                                <div class="main">CARGA EXTRA 3</div>
                                <div class="section">P</div>
                                <div class="section">U</div>
                              </th>
                            <?php } ?>
                            
                            <th colspan="2" class="title" >
                              <div class="main">TOTAL CARGADO</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                          </tr>
                        </thead>
                       
                        
                      </table>
                    </td>




                  </tr>
                </tbody>
              </table>
            <?php } ?>
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