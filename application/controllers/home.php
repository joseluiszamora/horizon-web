<?php
  class Home extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      }
    }

    function index() {
      $data['category'] = 'template';
      $data['page'] = 'home';
      $this->load->view('template/template', $data);
    }
  }
?>