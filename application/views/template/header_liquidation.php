<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Horizon Liquidaciones</title>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>css/normalize.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap-liquidations.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/angular/liquidation.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/fonts.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/datepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/chosen.css" rel="stylesheet">
</head>
<body>

  <div id="wrapper" ng-app="myModule">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Horizon Liquidaciones</a>
      </div>

      <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                  <i class="fa fa-user fa-fw"></i> <?php echo $this->session->userdata('email'); ?>
                </li>

                <li>
                  <?php echo anchor('user/edit/'.$this->Account_Model->get_user_id($this->session->userdata('email')), '<i class="fa fa-gear fa-fw"></i> Mi Perfil', array('')); ?>
                </li>

                <li class="divider"></li>

                <li><?php echo anchor('account/logout', '<i class="fa fa-sign-out fa-fw"></i> Logout', array('')); ?></li>
            </ul>
        </li>
      </ul>

    </nav>