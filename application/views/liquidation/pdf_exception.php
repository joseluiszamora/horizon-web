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
              <?php foreach ($lines as $line) { ?>
                <table class="table table-bordered tableLine">
                  <tbody>
                    <tr>
                      <td class="line titlecontainer">
                        <span class=""><?php echo $line->Descripcion;?></span>
                      </td>
                      <td colspan="3" class="subTableContainer" >
                        <table class="table table-bordered subTable" ng-show="getVisible(line)">
                          <thead>
                            <tr>
                              <th class="vol">VOLUMEN</th>
                              <th class="productname">PRODUCTO</th>
                              <th class="title">
                                <div class="main">PAQUETES</div>
                              </th>
                              <th class="title">
                                <div class="main">UNIDADES</div>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $products = $this->Liquidation_Model->get_detail_list($liquidationid, $line->idLine, 1);
                            print_r($products);
                            foreach ($products as $product) {
                              
                              $devolutionP = $product->devolutionP;
                              $devolutionU = $product->devolutionU;
                            ?>
                              <tr>
                                <td class="vol"><?php echo $product['volume'];?></td>
                                <td class="productname"><?php echo $product['Nombre'];?></td>

                                <!-- devolution charge -->
                                <td class="unity"><?php echo $product['devolutionP'];?></td>
                                <td class="unity"><?php echo $product['devolutionU'];?></td>
                              </tr>
                            <?php } ?>
                            <tr class="footer">
                              <td class="vol" colspan="2"><span style="float: right; font-weight: bold;">TOTAL: &nbsp;&nbsp;&nbsp;&nbsp; </span></td>
                              <!-- devoluciones -->
                              <td class="unity"><?php echo floor($devolutionP); ?></td>
                              <td class="unity"><?php echo floor($devolutionU); ?></td>
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