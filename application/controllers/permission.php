<?php
  class Permission extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      $this->load->model('Profile_Model');
    }

    function index() {
      if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'permisos_de_acceso')){
        if ($this->Account_Model->logged_in() === TRUE) {        
          $data['profile'] = $this->Profile_Model->report();
          $data['category'] = 'permission';
          $data['page'] = 'index';
          $this->load->view('template/template', $data);
        } else {
          redirect('account/login');
        }
      }else{
        show_404();
      }
    }

    public function edit($id = "") {
      if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'permisos_de_acceso')){
        if ($this->Account_Model->logged_in() === TRUE) {        
          if ($id != "") {
            $profile = $this->Profile_Model->get($id);

            if (empty($profile)) {
              show_404();
            }
            $data['profile'] = $profile;
            $data['modules'] = $this->Permission_Model->report_modules();
            
            $data['category'] = 'permission';
            $data['page'] = 'edit';
            $this->load->view('template/template', $data);
          }
          else
            redirect('permission');    
        } else {
          redirect('account/login');
        }
      }else{
        show_404();
      }
    }


    // activate permission
    public function activate() {
      $profile = $this->input->post('profile');
      $module = $this->input->post('module');
      $this->Permission_Model->activate($profile, $module);
    }

    // deactivate permission
    public function deactivate() {
      $profile = $this->input->post('profile');
      $module = $this->input->post('module');
      $this->Permission_Model->deactivate($profile, $module);
    }
  }
?>