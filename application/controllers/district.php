<?php
  class District extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      $this->load->model('Area_Model');
      $this->load->model('District_Model');
      $this->load->model('City_Model');      
    }

    function index() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'district'))) {
        show_404();
      }
      $data['district'] = $this->District_Model->report();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['area'] = array($dropdown[""] = 'Seleccione Zona');
      $data['category'] = 'district';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }
  
    function create() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'district'))) {
        show_404();
      }
      $data['category'] = 'district';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'district'))) {
        show_404();
      }
      if ($this->Account_Model->logged_in() === TRUE) {
        if ($id != "") {
          $data['iddistrict'] = $id;
          $district = $this->District_Model->get($id);
          if (empty($district)) {
              show_404();
          }
          $data['district'] = $district[0];
          $data['category'] = 'district';
          $data['action'] = 'edit';
          $data['page'] = 'form';
          $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
          $data['area'] = $this->Area_Model->get_area();
          $this->load->view('template/template', $data);
        }
        else
          redirect('district');
      } else {
        redirect('account/login');
      }
    }

    function search_district(){
      $this->form_validation->set_rules('city', 'city', 'xss_clean');
      $this->form_validation->set_rules('area', 'area', 'xss_clean');

      $this->form_validation->set_message('xss_clean', 'security: danger value.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE){
        redirect("district");
      }else{
        $data_in['city'] = $this->input->post('city');
        $data_in['area'] = $this->input->post('area');
        $data_view = $this->District_Model->search($data_in);
        
        $data['district'] = $data_view;

        //$data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());



        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] > 0){
          $data['area'] = $this->Area_Model->get_area_for_city($data_in['city']);
        }else{
          $data['area'] = array($dropdown[""] = 'Seleccione Zona');
        }




        $data['category'] = 'district';
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }
    }

    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('desc', 'Descripcion', 'xss_clean|required');
        $this->form_validation->set_rules('city', 'Ciudad', 'xss_clean|required|greater_than[0]');
        $this->form_validation->set_rules('area', 'Zona', 'xss_clean|required|greater_than[0]');
        
        $this->form_validation->set_message('required', '%s es obligatorio.');    
        $this->form_validation->set_message('greater_than', '%s es obligatorio.');    
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          if($this->input->post('form_action') == "save") {
            $data['action'] = 'new';
          }else {
            $data['action'] = 'edit';
          }

          $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());    
          $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
          $data['category'] = 'district';
          $data['page'] = 'form';
          $data['area'] = $this->Area_Model->get_area();
          $this->load->view('template/template', $data);
        } else {
          $data_in['Descripcion'] = $this->input->post('desc');
          $data_in['idZona'] = $this->input->post('area');

          // Check if Save or Edit
          if($this->input->post('form_action') == "save") {
            if ($this->District_Model->create($data_in) === TRUE) {
              redirect('district');
            } else {
              $data['category'] = 'district';
              $data['action'] = 'new';
              $data['page'] = 'form';
              $this->load->view('template/template', $data);
            }
          }else{
            $data_in['idBarrio'] = $this->input->post('iddistrict');
            if ($this->District_Model->update($data_in, $data_in['idBarrio']) === TRUE) {
              redirect('district');
            } else {
              $data['category'] = 'district';
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
      $this->District_Model->delete($id);
      redirect('district');
    }

    public function get_districts_for_city($idCity=-1) {
      echo(json_encode($this->District_Model->get_disctricts_for_city($idCity)));
    }
  }
?>