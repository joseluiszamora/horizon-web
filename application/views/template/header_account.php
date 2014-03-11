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
    
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <script type="text/javascript">
      var browser     = navigator.userAgent;
      var browserRegex  = /(Android|BlackBerry|IEMobile|Nokia|iP(ad|hone|od)|Opera M(obi|ini))/;
      var isMobile    = false;
      if(browser.match(browserRegex)) {
        isMobile      = true;
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){
          window.scrollTo(0,1);
        }
      }
    </script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/account.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>    
    <script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>      
  </head>

  <body>
    <div id="headerwrapper"> 
      <div class="topbar">
        <div class="header">
          <div class="container">
            <a title="" href="<?php echo base_url(); ?>" class="brand"><img width="144" src="<?php echo base_url(); ?>img/logo_horizon.png"></a>
          </div>
        </div>
      </div>
                       
    </div>
    <div id="bodywrapper">    
      <div id="bodycontainer" class="container">