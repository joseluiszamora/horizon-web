<?php
  class Home extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      }
    }

    function index() {
      //$data['category'] = 'home';
      //$data['page'] = 'index';
      $this->load->view('template/header_blank');
      $this->load->view('home/index');
    }
  }
?>


<style type="text/css">
  body{
    background-color: #FAFAFA !important;
  }
  .link_home{
    color: #333333;
  }
  .link_home:hover{
    text-decoration: none;
    color: #333333; 
  }
  .services-box {
    border: 1px solid #EEEEEE;
    margin-bottom: 10px;
    padding: 15px 10px;
    text-align: center;
  }
  .services-box i {
    border: 2px solid #0FAF97;
    border-radius: 50%;
    color: #0FAF97;
    font-size: 24px;
    height: 70px;
    line-height: 70px;
    margin-bottom: 15px;
    text-align: center;
    transition: all 200ms ease-in 0s;
    width: 70px;
  }
  .services-box h1 {
    font-size: 17px;
    text-decoration: none;
    margin-bottom: 0;
  }
  .services-box:hover i {
    background-color: #0FAF97;
    border-color: #0FAF97;
    color: #FFFFFF;
  }
  .services-icon i {
    background-color: #FFFFFF;
    border-radius: 50%;
    color: #0FAF97;
    font-size: 34px;
    height: 80px;
    line-height: 80px;
    text-align: center;
    width: 80px;
  }
  .services-text h4 {
    color: #FFFFFF;
    margin-bottom: 15px;
  }
</style>