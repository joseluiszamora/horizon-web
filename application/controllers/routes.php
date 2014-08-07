<?php
  class Routes extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Routes_Model');
      $this->load->model('Line_Model');
      $this->load->model('Volume_Model');
      $this->load->model('Linevolume_Model');
      $this->load->model('Product_Model');
      $this->load->model('User_Model');
      $this->load->model('Liquidation_Model');
      $this->load->model('City_Model');
      $this->load->model('Area_Model');

      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'city'))) {
        show_404();
      }
    }

    function index() {
      $data['routes'] = $this->Routes_Model->report();
      $data['category'] = 'routes';
      $data['page'] = 'index';
      $this->load->view('template/template_liquidation', $data);
    }

     function create() {
      $data['distributor'] = $this->Liquidation_Model->get_users_and_zones();
      $data['cities'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['linenoregular'] = $this->Line_Model->get_no_regular_lines();
      $areas = $this->Area_Model->report("1", 'zona.idZona');
      $area_list = $this->Area_Model->get_area_list("all", "1");
      $dropdown_list = array();
      foreach ($areas as $row){
        if ($row->Estado == "1" && $row->level == "0"){
          $dropdown = array();
          $dropdown[0] = 'Seleccione Ruta';
          foreach ($area_list as $row_area){
            if ($row_area->Estado == "1" && $row_area->level == "1" && $row_area->parent == $row->idZona){
              $dropdown[$row_area->idZona] = $row_area->Descripcion;
            }
          }
          $dropdown_list[$row->idZona] = $dropdown;
        }
      }
      $data['dropdown_list'] = $dropdown_list;


      $data['category'] = 'routes';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $this->load->view('template/template_liquidation', $data);
    }

    public function edit($id = "") {
      if ($id != "") {
        $data['idCity'] = $id;
        $city = $this->City_Model->get($id);
        if (empty($city)) {
            show_404();
        }
        $data['city'] = $city[0];
        $data['category'] = 'city';
        $data['action'] = 'edit';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);
      }
      else
        redirect('city');
    }

    function save() {
      $this->form_validation->set_rules('desc', 'Nombre de la ciudad', 'xss_clean|required');
        
      $this->form_validation->set_message('required', '%s es obligatorio.');        
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $data['action'] = 'new';
        }else {
          $data['action'] = 'edit';
        }
        
        $data['category'] = 'city';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);
      } else {
        $data_in['NombreCiudad'] = $this->input->post('desc');          

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          if ($this->City_Model->create($data_in) === TRUE) {
            redirect('city');
          } else {
            $data['category'] = 'city';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }else{
          $data_in['idCiudad'] = $this->input->post('idCity');
          if ($this->City_Model->update($data_in, $data_in['idCiudad']) === TRUE) {
            redirect('city');
          } else {
            $data['category'] = 'city';
            $data['action'] = 'edit';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }
      }
    }

    function delete($id) {
      $this->City_Model->delete($id);
      redirect('district');
    }
  }
?>