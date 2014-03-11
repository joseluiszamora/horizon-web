<?php
  class Permission extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      $this->load->model('Account_Model');
      $this->load->model('Permission_Model');
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
      if ($this->Account_Model->logged_in() === TRUE) {
        if ($id != "") {
         // $data['idpermission'] = $id;
          $profile = $this->Profile_Model->get($id);
          //$profileTitle = $this->Profile_Model->get_name($id);

          if (empty($profile)) {
            show_404();
          }
          $data['profile'] = $profile;
          $data['modules'] = $this->Permission_Model->report_modules();
          //$data['profile'] = $this->Profile_Model->report();
          
          $data['category'] = 'permission';
          $data['page'] = 'edit';
          $this->load->view('template/template', $data);
        }
        else
          redirect('permission');
      } else {
        redirect('account/login');
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

    /*function create() {
      $data['category'] = 'permission';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $this->load->view('template/template', $data);
    }

    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('desc', 'Tipo de Comercio', 'xss_clean|required');
        
        $this->form_validation->set_message('required', '%s es obligatorio.');        
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          if($this->input->post('form_action') == "save") {
            $data['action'] = 'new';
          }else {
            $data['action'] = 'edit';
          }
          $data['category'] = 'permission';          
          $data['page'] = 'form';
          $this->load->view('template/template', $data);
        } else {
          $data_in['Descripcion'] = $this->input->post('desc');
          $idpermission = $this->input->post('idpermission');

          // Check if Save or Edit
          if($this->input->post('form_action') == "save") {
            if ($this->Permission_Model->create($data_in) === TRUE) {
              redirect('permission');
            } else {
              $data['category'] = 'permission';
              $data['action'] = 'new';
              $data['page'] = 'form';
              $this->load->view('template/template', $data);
            }
          }else{
            if ($this->Permission_Model->update($data_in, $idpermission) === TRUE) {
              redirect('permission');
            } else {
              $data['category'] = 'permission';
              $data['action'] = 'edit';
              $data['page'] = 'form';
              $this->load->view('template/template', $data);
            }
          }
        }
      } else {
        redirect('account/login');
      }
    }

    function delete($id) {
      $this->Permission_Model->delete($id);
      redirect('permission');
    } */ 

  }
?>