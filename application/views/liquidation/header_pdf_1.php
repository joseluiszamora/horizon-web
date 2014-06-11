<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Horizon Liquidaciones</title>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>css/normalize.css" rel="stylesheet">
    <!--<link href="<?php //echo base_url(); ?>css/bootstrap-liquidations.css" rel="stylesheet">
    <link href="<?php //echo base_url(); ?>css/angular/liquidation.css" rel="stylesheet">
    <link href="<?php //echo base_url(); ?>css/fonts.css" rel="stylesheet">
    <link href="<?php //echo base_url(); ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php //echo base_url(); ?>css/sb-admin.css" rel="stylesheet">-->

    <!-- Core Scripts  -->
    <script src="<?php echo base_url(); ?>js/jquery-1.11.0.min.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

    <!-- ANGULAR -->
    <script src="<?php echo base_url(); ?>js/angular/angular.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/angular/app.js" type="text/javascript"></script>

    <style>
      .topbar .header {
        background-color: #F8F8F8;
        border-bottom: 1px solid #E0E0E0;
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
          .titles h2{
            color: #000000;   
            font-size: 16px;
            line-height: 20px;
            margin-top: -20px;
          }
          .titles h3{
            font-size: 13px;
            line-height: 10px;
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
    </style>
</head>
<body>
  <div id="headerwrapper">
      <div class="topbar">
        <div class="header">
          <div class="container">
            <img class="logo" alt="Horizon" src="<?php echo $base_url; ?>img/logo_horizon.png" width="100" style="margin: 10px 0 0 10px;" />
            <div class="titles">
              <h2><?php echo $title; ?></h2>
            </div>
            <div class="filters">
              <ul>
                <li class="form-group col-md-4"><b>Distribuidor: </b> <?php echo $liquidation[0]->idUser; ?></li>
                <li  class="form-group col-md-4"><b>Ruta: </b> <?php echo $liquidation[0]->ruta; ?></li>
                <li  class="form-group col-md-4"><b>Fecha: </b> <?php echo $liquidation[0]->fechaRegistro; ?></li>
                <li  class="form-group col-md-4"><b>Observaciones: </b> <?php echo $liquidation[0]->detalle; ?></li>
                <li  class="form-group col-md-4"><b>Estado: </b> <?php echo $liquidation[0]->mark; ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div id="wrapper" ng-app="myModule">