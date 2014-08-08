<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Horizon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Horizon">
    <meta name="author" content="Jose Luis Zamora">

    <link href="<?php echo base_url(); ?>css/normalize.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap-liquidations.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/angular/liquidation.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/fonts.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <style>
      .topbar .header {
        padding: 0;
      }
        .info {
          position: absolute;
          right: 10px;
          text-align: right;
          top: 0px;
          width: 200px;
        }
        .info ul, .filters ul {
          list-style: none;
          color: #000000;
        }
        .info ul li, .filters ul li{
          color: #000000;
        }
        .titles {
          text-align: center;
          color: #000000;
        }
        #headerwrapper{
          width: 960px;
        }
        .container, .navbar-fixed-top .container, .navbar-fixed-bottom .container {
          width: 960px;
          position: relative;
        }
        #bodycontainer {
          margin-top: 10px;
        }
        .container {
          color: #000000;
        }
        .container table {
          width: 960px;
        }
        .topbar {
          position: inherit;
          height: auto;
        }
        th, td {
          text-align: center;
          color: #000000;
          font-size: 10px;
        }
        #footerwrapper-bottom {
          background: none;
        }
        .infodesc{
          float: left;
          text-decoration: underline;
        }
        .infodesc2{
          float: right;
          text-decoration: underline;
          margin-right: 30px;
        }
        .infodesc3{
          float: right;
          text-decoration: underline;
        }
    </style>
  </head>

  <body>
    <div id="headerwrapper">
      <div class="topbar">
        <div class="header">
          <div class="container">
            <img class="logo" alt="Horizon" src="<?php echo $base_url; ?>img/logo_horizon.png" width="100" style="margin: 10px 0 0 10px;" />
            <div class="titles">
              <h2 class="bold"><?php echo $title; ?></h2>
            </div>
            <div class="filters">
              <ul>
                <li class="infodesc"><span class="bold">DISTRIBUIDOR : </span> <?php echo $liquidation[0]->Nombre." ".$liquidation[0]->Apellido; ?></li>
                <li class="infodesc3"><span class="bold">RUTA : </span> <?php echo $liquidation[0]->Descripcion; ?></li>
                <li class="infodesc2"><span class="bold">FECHA : </span> <?php echo $liquidation[0]->fechaRegistro." ".$liquidation[0]->horaRegistro; ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="bodywrapper">
      <div class="container">
      <?php //print_r($lines); ?>

      <div id="liquidations" class="row" >
  <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <?php foreach ($lines as $line) {?>
              <table class="table table-bordered tableLine">
                <tbody>
                  <tr>
                    <td class="line"><?php echo $line['nameLine'];?></td>
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
                              <div class="main">DEV</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" >
                              <div class="main">PRES</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" >
                              <div class="main">BON</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" >
                              <div class="main">AJUSTE</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" >
                              <div class="main">VENTA CALC.</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th colspan="2" class="title" >
                              <div class="main">VENTA ANDROID</div>
                              <div class="section">P</div>
                              <div class="section">U</div>
                            </th>
                            <th class="title">TOTAL (Bs)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($line['products'] as $product) { ?>
/*[price] => 23.75 
[uxp] => 5 
[ventaP] => 0 
[ventaU] => 0*/
                            <tr>
                              <td class="vol"><?php echo $product['volume'];?></td>
                              <td class="productname"><?php echo $product['Nombre'];?></td>
                              <!-- previous charge -->
                              <td class="unity"><?php echo $product['previousDayP'];?></td>
                              <td class="unity"><?php echo $product['previousDayU'];?></td>

                              <!-- main charge -->
                              <td class="unity"><?php echo $product['chargeP'];?></td>
                              <td class="unity"><?php echo $product['chargeU'];?></td>

                              <!-- extra charge 1-->
                              <td class="unity"><?php echo $product['chargeExtraP1'];?></td>
                              <td class="unity"><?php echo $product['chargeExtraU1'];?></td>

                              <!-- extra charge 2-->
                              <td class="unity"><?php echo $product['chargeExtraP2'];?></td>
                              <td class="unity"><?php echo $product['chargeExtraU2'];?></td>

                              <!-- extra charge 3-->
                              <td class="unity"><?php echo $product['chargeExtraP3'];?></td>
                              <td class="unity"><?php echo $product['chargeExtraU3'];?></td>

                              <!-- total charge -->
                              <td class="unity"><?php echo $product['chargeTotalP'];?></td>
                              <td class="unity"><?php echo $product['chargeTotalU'];?></td>

                              <!-- devolution charge -->
                              <td class="unity"><?php echo $product['devolutionP'];?></td>
                              <td class="unity"><?php echo $product['devolutionU'];?></td>

                              <!-- devolution prestamos -->
                              <td class="unity"><?php echo $product['prestamosP'];?></td>
                              <td class="unity"><?php echo $product['prestamosU'];?></td>

                              <!-- devolution bonificacion -->
                              <td class="unity"><?php echo $product['bonosP'];?></td>
                              <td class="unity"><?php echo $product['bonosU'];?></td>

                              <!-- Ajuste -->
                              <td class="unity"><?php echo $product['ajusteP'];?></td>
                              <td class="unity"><?php echo $product['ajusteU'];?></td>

                              <!-- TOTAL venta CALC -->
                              <td class="unity"><?php echo $product['calculatedP'];?></td>
                              <td class="unity"><?php echo $product['calculatedU'];?></td>

                              <!-- Venta Android -->
                              <td class="unity success">0</td>
                              <td class="unity success">0</td>

                              <!-- total venta -->
                              <td class="unity"><?php echo $product['totalAmmount'];?></td>
                            </tr>
                          <?php } ?>
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

                            <td class="unity">0</td>
                            <td class="unity">0</td>

                            <td class="unity">0</td>
                            <td class="unity">0</td>

                            <td class="unity">0</td>
                            <td class="unity">0</td>

                            <td class="unity">{{ getAjustePLine(line.products, line.lineUxp) }}</td>
                            <td class="unity">{{ getAjusteULine(line.products, line.lineUxp) }}</td>

                            <td class="unity">0</td>
                            <td class="unity">0</td>

                            <td class="unity success">{{ getAmmountLine(line.products) | number:2 }}</td>
                          </tr>
                        </tfooter>
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
</div>

