<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Horizon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Horizon">
    <meta name="author" content="Jose Luis Zamora">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>css/layout.css">-->
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
            <div class="info">
              <?php
                  /*date_default_timezone_set("America/La_Paz");
                  $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
                  $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                  $year_now = date ("Y");
                  $month_now = date ("n");
                  $day_now = date ("j");
                  $week_day_now = date ("w");
                  $date = $day_now . " de " . $months[$month_now] . " de " . $year_now;*/
              ?>
              <ul>
                <li><?php //echo $user_name; ?></li>
                <li><?php //echo $date; ?></li>
                <li><?php //echo "Hrs. ".date('H:i'); ?></li>
              </ul>
            </div>
            <div class="titles">
              <h2><?php echo $title; ?></h2>
              <div><?php //print_r($parameters); ?></div>
              <?php if(!isset($parameters['dateFinish']) || $parameters['dateFinish']=='' ) {
                $parameters['dateFinish'] = date('Y-m-d');
              }
              ?>
              <h3><?php if (isset($parameters['dateStart']) && ($parameters['dateStart']!="")) echo "DEL " . $parameters['dateStart']; ?> AL <?php echo $parameters['dateFinish']; ?></h3>
            </div>
            <div class="filters">
              <ul>
                <?php if (isset($parameters['status']) && ($parameters['status']!="") && ($parameters['status']!="0")): ?>
                  <li>Estado: <?php echo $parameters['status']; ?></li>
                <?php endif; ?>
                <?php if (isset($parameters['name']) && ($parameters['name']!="")): ?>
                  <li>Nombre: <?php echo $parameters['name']; ?></li>
                <?php endif; ?>
                <?php if (isset($parameters['city']) && ($parameters['city']!="") && ($parameters['city']!="0")): ?>
                  <li>Ciudad: <?php echo $parameters['city']; ?></li>
                <?php endif; ?>
                <?php if (isset($parameters['disctrict']) && ($parameters['disctrict']!="") && ($parameters['disctrict']!="0")): ?>
                  <li>Barrio: <?php echo $parameters['disctrict']; ?></li>
                <?php endif; ?>
                <?php if (isset($parameters['area']) && ($parameters['area']!="") && ($parameters['area']!="0")): ?>
                  <li>Zona: <?php echo $parameters['area']; ?></li>
                <?php endif; ?>
                <?php if (isset($parameters['subarea']) && ($parameters['subarea']!="") && ($parameters['subarea']!="0")): ?>
                  <li>Sub Zona: <?php echo $parameters['subarea']; ?></li>
                <?php endif; ?>
                <?php if (isset($parameters['commercetype']) && ($parameters['commercetype']!="") && ($parameters['commercetype']!="0")): ?>
                  <li>Tipo de Comercio: <?php echo $parameters['commercetype']; ?></li>
                <?php endif; ?>
                <?php if (isset($parameters['channel']) && ($parameters['channel']!="") && ($parameters['channel']!="0")): ?>
                  <li>Canal: <?php echo $parameters['channel']; ?></li>
                <?php endif; ?>

                <?php if (isset($parameters['line']) && ($parameters['line']!="") && ($parameters['line']!="0")): ?>
                  <li>Linea: <?php echo $parameters['line']; ?></li>
                <?php endif; ?>
                <?php if (isset($parameters['volume']) && ($parameters['volume']!="") && ($parameters['volume']!="0")): ?>
                  <li>Volumen: <?php echo $parameters['volume']; ?></li>
                <?php endif; ?>

                <?php if (isset($parameters['user']) && ($parameters['user']!="")): ?>
                  <li>Usuario: <?php echo $parameters['user']; ?></li>
                <?php endif; ?>

                <?php if (isset($parameters['datelast']) && ($parameters['datelast']!="")): ?>
                  <li>Transacciones desde: <?php echo $parameters['datelast']; ?></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="bodywrapper">
      <div id="bodycontainer" class="container">