<?php
  class Area extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      $this->load->model('Area_Model');
      $this->load->model('City_Model');
      $this->load->model('District_Model');
      $this->load->library(array('session'));
    }

    function index() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'area'))) {
        show_404();
      }
      $this->activos();
    }

    function create() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'area'))) {
        show_404();
      }
      if ($this->session->userdata('profile') === "1") {
        $this->redirect_form_admin('new');
      } else {
        $this->redirect_form('new');
      }
      echo $this->session->userdata('profile');
    }

    function new_sub_area() {
      $this->redirect_form_sub_area('new');
    }

    public function edit($id = "") {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'area'))) {
        show_404();
      }
      if ($id != "") {
        $data['idarea'] = $id;
        $area = $this->Area_Model->get($id);
        if (empty($area)) {
            show_404();
        }
        $data['area'] = $area[0];
        $data['cities'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        $data['category'] = 'area';
        $data['action'] = 'edit';
        $data['mark'] = 't_1';
        $data['page'] = 'form_admin';
        $this->load->view('template/template', $data);
      }
      else
        redirect('area');
    }

    public function search_area(){
      $city = $this->input->post('city');
      if (isset($city) && $city !="" && $city !="0"){
        $data['area'] = $this->Area_Model->report($this->input->post('city'), 'zona.idZona');
        $data['area_list'] = $this->Area_Model->get_area_list($this->input->post('city'), "1");
        $data['district'] = $this->District_Model->get_disctrict_list();
        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        $data['category'] = 'area';
        $data['mark'] = $this->input->post('tab');
        $data['page'] = 'index';
        //print_r($data);
        $this->load->view('template/template', $data);
      }else{
        $this->activos();
      }
    }

    public function edit_sub_area($id = "") {
      if ($id != "") {
        $data['idarea'] = $id;
        $area = $this->Area_Model->get($id);
        if (empty($area)) {
            show_404();
        }
        $data['area'] = $area[0];
        $data['category'] = 'area';
        $data['action'] = 'edit';
        $data['area_parent'] = $this->Area_Model->get_area($this->session->userdata('city'));
        $data['page'] = 'form_sub_area';
        $this->load->view('template/template', $data);
      }
      else
        $this->redirect_tab('tab3','idZona');
    }

    function save() {
      $this->form_validation->set_rules('desc', 'Tipo de Comercio', 'xss_clean|required');
        
      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $this->redirect_form('new');
        }else {
          $this->redirect_form('edit');
        }
      } else {
        $data_in['Descripcion'] = $this->input->post('desc');
        $data_in['idCiudad'] = $this->session->userdata('city');

        $idarea = $this->input->post('idarea');

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          if ($this->Area_Model->create($data_in) === TRUE) {
            redirect('area');
          } else {
            $this->redirect_form('new');
          }
        }else{
          if ($this->Area_Model->update($data_in, $idarea) === TRUE) {
            redirect('area');
          } else {
            $this->redirect_form('edit');
          }
        }
      }
    }


    function save_admin() {
      $this->form_validation->set_rules('desc', 'Descripcion', 'xss_clean|required');
      $this->form_validation->set_rules('city', 'Ciudad', 'xss_clean|required|greater_than[0]');
      
      $this->form_validation->set_message('required', '%s es obligatorio.');
       $this->form_validation->set_message('greater_than', '%s es obligatorio.');    
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $this->redirect_form_admin('new');
        }else {
          $this->redirect_form_admin('edit');
        }
      } else {
        $data_in['Descripcion'] = $this->input->post('desc');
        $data_in['idCiudad'] = $this->input->post('city');

        $idarea = $this->input->post('idarea');

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          if ($this->Area_Model->create($data_in) === TRUE) {
            redirect('area');
          } else {
            $this->redirect_form_admin('new');
          }
        }else{
          if ($this->Area_Model->update($data_in, $idarea) === TRUE) {
            redirect('area');
          } else {
            $this->redirect_form_admin('edit');
          }
        }
      }
    }


    function sub_area() {
      $this->form_validation->set_rules('desc', 'Nombre Sub Zona', 'xss_clean|required');
      $this->form_validation->set_rules('area', 'Zona', 'xss_clean|required|greater_than[0]');

      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $this->redirect_form_sub_area('new');
        }else {
          $this->redirect_form_sub_area('edit');
        }
      } else {
        $data_in['Descripcion'] = $this->input->post('desc');
        $data_in['idCiudad'] = $this->session->userdata('city');
        $data_in['level'] = $this->input->post('level');
        $data_in['parent'] = $this->input->post('area');
        $data_in['Estado'] = "1";

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          if ($this->Area_Model->create($data_in) === TRUE) {
            redirect('area');
          } else {
            $this->redirect_form_sub_area('new');
          }
        }else{
          $idarea = $this->input->post('idarea');
          if ($this->Area_Model->update($data_in, $idarea) === TRUE) {
            $this->redirect_tab('tab3', 'idZona');
          } else {
            $this->redirect_form_sub_area('edit');
          }
        }
      }
    }

    function redirect_form($action){
      $data['category'] = 'area';
      $data['action'] = $action;
      $data['page'] = 'form';
      $this->load->view('template/template', $data);
    }

    function redirect_form_admin($action){
      $data['category'] = 'area';
      $data['action'] = $action;
      $data['cities'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['page'] = 'form_admin';
      $this->load->view('template/template', $data);
    }

    function redirect_form_sub_area($action){
      $data['category'] = 'area';
      $data['action'] = $action;
      $data['area_parent'] = $this->Area_Model->get_area($this->session->userdata('city'));
      $data['page'] = 'form_sub_area';
      $this->load->view('template/template', $data);
    }

    function redirect_tab($tab, $order="idZona"){
      $data['area'] = $this->Area_Model->report($this->session->userdata('city'), $order);
      $data['area_list'] = $this->Area_Model->get_area_list($this->session->userdata('city'), "1");
      $data['district'] = $this->District_Model->get_disctrict_list();    
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['category'] = 'area';
      $data['mark'] = $tab;
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    // desactivar zona
    function deactive($cli) {
      $this->Area_Model->set_status($cli, '0');

      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '35';
      $data['idReferencia'] = $cli;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);


      $this->redirect_tab('tab1', 'idZona');
    }

    // activar zona
    function active($cli) {
      $this->Area_Model->set_status($cli, '1');

      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '34';
      $data['idReferencia'] = $cli;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);

      $this->redirect_tab('tab1', 'idZona');
    }

    // desactivar sub zona
    function deactive_sub($cli) {
      $this->Area_Model->set_status($cli, '0');

      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '39';
      $data['idReferencia'] = $cli;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);

      $this->redirect_tab('tab3', 'idZona');
    }

    // activar sub zona
    function active_sub($cli) {
      $this->Area_Model->set_status($cli, '1');

      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '38';
      $data['idReferencia'] = $cli;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);

      $this->redirect_tab('tab3', 'idZona');
    }

    function delete($id) {
      $this->Area_Model->delete($id);
      redirect('area');
    }

    function get_area_for_district($idDistrict=-1) {
      echo(json_encode($this->Area_Model->get_area_for_district($idDistrict)));
    }

    function get_area_for_city($idCity=-1) {
      echo(json_encode($this->Area_Model->get_area_for_city($idCity)));
    }

    function get_subarea_for_area($idArea=-1) {
      echo(json_encode($this->Area_Model->get_subarea_for_area($idArea)));
    }


    function activos(){
      $this->redirect_tab('tab1', 'idZona');  
    }
    function inactivos(){
      $this->redirect_tab('tab2', 'idZona');  
    }
    function subactivos(){
      $this->redirect_tab('tab3', 'idZona');  
    }
    function subinactivos(){
      $this->redirect_tab('tab4', 'idZona');  
    }
  }
?>