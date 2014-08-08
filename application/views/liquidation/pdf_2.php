<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Horizon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Horizon">
    <meta name="author" content="Jose Luis Zamora">

    <link href="<?php echo $base_url; ?>css/normalize.css" rel="stylesheet">
    <!--<link href="<?php //echo $base_url; ?>css/bootstrap.min.css" rel="stylesheet">-->
    <link href="<?php echo $base_url; ?>css/angular/liquidation.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>css/fonts.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <style>
      .topbar .header {
        padding: 0;
        float: left;
      }
      .container, .navbar-fixed-top .container, .navbar-fixed-bottom .container {
        width: 960px;
        position: relative;
      }
      #headerwrapper{
        width: 960px;
        float: left;
      }
      #headerwrapper .logo{
        float: left;
      }
      #headerwrapper .titles {
        text-align: center;
        color: #000000;
        width: 100%;
        float: left;
      }
      #headerwrapper .filters {
        color: #000000;
        width: 100%;
        float: right;
      }
      #headerwrapper .filters ul{
        list-style: none;
        color: #000000;
        float: left;
      }
      .info ul li, .filters ul li{
        color: #000000;
        float: left;
      }
      #bodywrapper{
        width: 960px;
        margin-top: 10px;
        float: left;
      }
      .container {
        color: #000000;
      }
      .container table {
        width: 960px;
      }
      .table th, .table td{
        border: 1px solid #000;
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
      .line.titlecontainer{
        position: relative;
        float: left;
        width: 50px;
      }
      .rotate {
        color: #000;
        position: relative;
        /* Safari */
        -webkit-transform: rotate(-90deg);
        /* Firefox */
        -moz-transform: rotate(-90deg);
        /* IE */
        -ms-transform: rotate(-90deg);
        /* Opera */
        -o-transform: rotate(-90deg);
        /* Internet Explorer */
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
      }
      .section{
        float: left;
        width: 50%;
      }
    </style>
</head>

<body class="container">
  <div id="headerwrapper">
    <img class="logo" alt="Horizon" src="<?php echo $base_url; ?>img/logo_horizon.png" width="100" style="margin: 10px 0 0 10px;" />
    <div class="titles">
      <h2 class="bold"><?php echo $title; ?></h2>
    </div>
    <div class="filters">
      <div class="infodesc"><span class="bold">DISTRIBUIDOR : </span> <?php echo $liquidation[0]->Nombre." ".$liquidation[0]->Apellido; ?></div>
      <div class="infodesc3"><span class="bold">RUTA : </span> <?php echo $liquidation[0]->Descripcion; ?></div>
      <div class="infodesc2"><span class="bold">FECHA : </span> <?php echo $liquidation[0]->fechaRegistro." ".$liquidation[0]->horaRegistro; ?></div>
    </div>
  </div>

  <div id="bodywrapper">
    <?php //print_r($lines); ?>
    <div id="liquidations" class="row" >
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <?php foreach ($lines as $line) {
                $previousP = 0;
                $previousU = 0;
                $chargeP = 0;
                $chargeU = 0;
                $chargeExtra1P = 0;
                $chargeExtra1U = 0;
                $chargeExtra2P = 0;
                $chargeExtra2U = 0;
                $chargeExtra3P = 0;
                $chargeExtra3U = 0;
                $totalP = 0;
                $totalU = 0;
                $devolutionP = 0;
                $devolutionU = 0;
                $prestamosP = 0;
                $prestamosU = 0;
                $bonosP = 0;
                $bonosU = 0;
                $ajusteP = 0;
                $ajusteU = 0;
                $calculateP = 0;
                $calculateU = 0;
                $androidP = 0;
                $androidU = 0;

                $totalAmmountLine = 0;
              ?>
                <table class="table table-bordered tableLine">
                  <tbody>
                    <tr>
                      <td class="line titlecontainer">
                        <span class=""><?php echo $line['nameLine'];?></span>
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
                            <?php foreach ($line['products'] as $product) {
                              $totalAmmountProduct = 0;
                              $previousP += $product['previousDayP'];
                              $previousU += $product['previousDayU'];
                              $chargeP += $product['chargeP'];
                              $chargeU += $product['chargeU'];
                              $chargeExtra1P += $product['chargeExtraP1'];
                              $chargeExtra1U += $product['chargeExtraU1'];
                              $chargeExtra2P += $product['chargeExtraP2'];
                              $chargeExtra2U += $product['chargeExtraU2'];
                              $chargeExtra3P += $product['chargeExtraP3'];
                              $chargeExtra3U += $product['chargeExtraU3'];
                              $totalP += $product['chargeTotalP'];
                              $totalU += $product['chargeTotalU'];
                              $devolutionP += $product['devolutionP'];
                              $devolutionU += $product['devolutionU'];
                              $prestamosP += $product['prestamosP'];
                              $prestamosU += $product['prestamosU'];
                              $bonosP += $product['bonosP'];
                              $bonosU += $product['bonosU'];
                              $ajusteP += $product['ajusteP'];
                              $ajusteU += $product['ajusteU'];
                              $calculateP += $product['calculatedP'];
                              $calculateU += $product['calculatedU'];
                              $androidP += 0;
                              $androidU += 0;

                              $totalAmmountProduct += $product['price'];
                              $totalAmmountLine += $product['totalAmmount'];
                            ?>
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
                                <td class="unity"><?php echo $totalAmmountProduct;?></td>
                              </tr>
                            <?php } ?>
                            <tr class="footer">
                              <td class="vol">&nbsp;</td>
                              <td class="productname">&nbsp;</td>
                              <!-- carga inicial -->
                              <td class="unity"><?php echo floor($previousP); ?></td>
                              <td class="unity"><?php echo floor($previousU); ?></td>
                              <!-- carga -->
                              <td class="unity"><?php echo floor($chargeP); ?></td>
                              <td class="unity"><?php echo floor($chargeU); ?></td>
                              <!-- carga extra1 -->
                              <td class="unity"><?php echo floor($chargeExtra1P); ?></td>
                              <td class="unity"><?php echo floor($chargeExtra1U); ?></td>
                              <!-- carga extra2 -->
                              <td class="unity"><?php echo floor($chargeExtra2P); ?></td>
                              <td class="unity"><?php echo floor($chargeExtra2U); ?></td>
                              <!-- carga extra3 -->
                              <td class="unity"><?php echo floor($chargeExtra3P); ?></td>
                              <td class="unity"><?php echo floor($chargeExtra3U); ?></td>
                              <!-- total -->
                              <td class="unity"><?php echo floor($totalP); ?></td>
                              <td class="unity"><?php echo floor($totalU); ?></td>
                              <!-- devoluciones -->
                              <td class="unity"><?php echo floor($devolutionP); ?></td>
                              <td class="unity"><?php echo floor($devolutionU); ?></td>
                              <!-- prestamos -->
                              <td class="unity"><?php echo floor($prestamosP); ?></td>
                              <td class="unity"><?php echo floor($prestamosU); ?></td>
                              <!-- bonos -->
                              <td class="unity"><?php echo floor($bonosP); ?></td>
                              <td class="unity"><?php echo floor($bonosU); ?></td>
                              <!-- ajuste -->
                              <td class="unity"><?php echo floor($ajusteP); ?></td>
                              <td class="unity"><?php echo floor($ajusteU); ?></td>
                              <!-- calculado -->
                              <td class="unity"><?php echo floor($calculateP); ?></td>
                              <td class="unity"><?php echo floor($calculateU); ?></td>
                              <!-- android -->
                              <td class="unity"><?php echo floor($androidP); ?></td>
                              <td class="unity"><?php echo floor($androidU); ?></td>

                              <td class="unity success"><?php echo floor($totalAmmountLine); ?></td>
                            </tr>
                          </tbody>
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