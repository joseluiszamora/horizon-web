<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Horizon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Horizon">
    <meta name="author" content="Jose Luis Zamora">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.ico">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datepicker.css">
    
    <script src="<?php echo base_url(); ?>js/jquery-1.9.1.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>js/selectJson.js"></script>
    
  </head>

  <body>
    <div id="headerwrapper">
      <div class="topbar">
        <div class="header">
          <div class="container">
    
            <a title="Effortless vehicle &amp; fleet management" href="<?php echo base_url(); ?>" class="brand"><img width="135" src="<?php echo base_url(); ?>img/logo_horizon.png" alt="Fleetio Logo"></a>

            <ul class="nav nav-pills" style="margin-top:15px;">
              <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'usuarios')){
                echo anchor('user', 'Usuarios', array('class'=>'')); }?></li>
              <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'productos')){
                echo anchor('product', 'Productos', array('class'=>'')); }?></li>
              <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'customer')){
                echo anchor('client', 'Clientes', array('class'=>'')); }?></li>
              <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'transaction')){
                echo anchor('transaction', 'Transacciones', array('class'=>'')); }?></li>
              <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'commerce')){
                echo anchor('commerce', 'Comercio', array('class'=>'')); }?></li>
              <li><?php if ($this->Account_Model->get_profile() == "1"){
                echo anchor('track', 'Tracker', array('class'=>'')); }?></li>
              <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'diary')){
                echo anchor('diary', 'Diario', array('class'=>'')); }?></li>
              

              <li class="dropdown">
                <a href="#" data-toggle="dropdown" role="button" id="drop5" class="dropdown-toggle">Configuracion<b class="caret"></b></a>
                <ul aria-labelledby="drop5" role="menu" class="dropdown-menu" id="menu2">
                  <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'city')){
                    echo anchor('city', 'Ciudad', array('class'=>'')); }?></li>
                  <li class="divider" role="presentation"></li>  
                  <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'district')){
                echo anchor('district', 'Barrios', array('class'=>'')); }?></li>
                  <li class="divider" role="presentation"></li>
                  <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'area')){
                    echo anchor('area', 'Zonas', array('class'=>'')); }?></li>
                  <li class="divider" role="presentation"></li>
                  <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'line')){
                    echo anchor('line', 'Linea', array('class'=>'')); }?></li>
                  <li class="divider" role="presentation"></li>
                  <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'volume')){
                    echo anchor('volume', 'Volumen', array('class'=>'')); }?></li>
                  <li class="divider" role="presentation"></li>
                  <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'permisos_de_acceso')){
                    echo anchor('permission', 'Permisos', array('class'=>'')); }?></li>
                  <li class="divider" role="presentation"></li>
                  <li><?php if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'rank')){
                    echo anchor('rank', 'Rangos de Prestamo', array('class'=>'')); }?></li>
                </ul>
              </li>

              <li>
                <div class="btn-group">
                  <button class="btn"><?php echo $this->session->userdata('email'); ?></button>
                  <button class="btn dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><?php echo anchor('user/edit/'.$this->Account_Model->get_user_id($this->session->userdata('email')), 'Mi perfil', array('')); ?></li>
                    <li><?php echo anchor('account/logout', 'Salir', array('')); ?></li>
                  </ul>
                </div>
              </li>
            </ul>
            </div>
          </div>
        </div>
      </div>