<!DOCTYPE html>
<html ng-app="myModule">

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

  <div id="wrapper">
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
    <!-- /.navbar-header -->



    <ul class="nav navbar-top-links navbar-right">
      <!--<li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-messages">
              <li>
                  <a href="#">
                      <div>
                          <strong>John Smith</strong>
                          <span class="pull-right text-muted">
                              <em>Yesterday</em>
                          </span>
                      </div>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <strong>John Smith</strong>
                          <span class="pull-right text-muted">
                              <em>Yesterday</em>
                          </span>
                      </div>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <strong>John Smith</strong>
                          <span class="pull-right text-muted">
                              <em>Yesterday</em>
                          </span>
                      </div>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a class="text-center" href="#">
                      <strong>Read All Messages</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
          </ul>
      </li>-->
      <!-- /.dropdown -->
      <!--<li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-tasks">
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Task 1</strong>
                              <span class="pull-right text-muted">40% Complete</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                  <span class="sr-only">40% Complete (success)</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Task 2</strong>
                              <span class="pull-right text-muted">20% Complete</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                  <span class="sr-only">20% Complete</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Task 3</strong>
                              <span class="pull-right text-muted">60% Complete</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                  <span class="sr-only">60% Complete (warning)</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Task 4</strong>
                              <span class="pull-right text-muted">80% Complete</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                  <span class="sr-only">80% Complete (danger)</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a class="text-center" href="#">
                      <strong>See All Tasks</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
          </ul>
      </li>-->
      <!-- /.dropdown -->
      <!-- <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-alerts">
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-comment fa-fw"></i> New Comment
                          <span class="pull-right text-muted small">4 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                          <span class="pull-right text-muted small">12 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-envelope fa-fw"></i> Message Sent
                          <span class="pull-right text-muted small">4 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-tasks fa-fw"></i> New Task
                          <span class="pull-right text-muted small">4 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-upload fa-fw"></i> Server Rebooted
                          <span class="pull-right text-muted small">4 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a class="text-center" href="#">
                      <strong>See All Alerts</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
          </ul>
      </li>-->
      <!-- /.dropdown -->

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

    <div class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
          <li>
            <?php 
              echo anchor('liquidation/create', '<i class="fa fa-pencil-square-o fa-fw"></i> Carga Nueva', array('')); 
            ?>
          </li>

          <li>
            <?php 
              echo anchor('liquidation/charge_list', '<i class="fa fa-pencil-square-o fa-fw"></i> Cargas Realizadas
              <span class="badge">'.$this->Liquidation_Model->count("all").'</span>', array('')); 
            ?>
          </li>

          <li>
            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Liquidaciones Pendientes<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li>
                <a href="#">Second Level Item</a>
              </li>
              <li>
                <a href="#">Second Level Item</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="page-wrapper">