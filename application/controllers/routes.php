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

    public function calendar($id = "") {
      $clients = array();
      //$dates = $this->Routes_Model->get_dates_and_zones($id);
      $dates = $this->Routes_Model->get_dates_and_zones();
      // looping through each album
      foreach ($dates as $row) {
        $tmp = array();
        $tmp["id"] = $row->idprogrutas;
        $tmp["title"] = $row->Descripcion;
        $tmp["start"] = $row->fecha;
        $tmp["end"] = $row->fecha;
        // push album
        array_push($clients, $tmp);
      }
      // printing json
      //echo json_encode($clients);

      //$data['distributor'] = $this->Routes_Model->get($id);
      //$data['dates'] = $this->Routes_Model->get_dates_and_zones($id);
      $data['dates'] = json_encode($clients);
      $data['category'] = 'routes';
      $data['page'] = 'calendar';
      $this->load->view('template/template_liquidation', $data);
    }

    public function get_calendar($id = "") {
      $clients = array();
      //$dates = $this->Routes_Model->get_dates_and_zones($id);
      $dates = $this->Routes_Model->get_dates_and_zones();
      // looping through each album
      foreach ($dates as $row) {
        $tmp = array();
        $tmp["id"] = $row->idprogrutas;
        $tmp["title"] = $row->Nombre." ".$row->Apellido." - ".$row->Descripcion;
        $tmp["start"] = $row->fecha;
        $tmp["end"] = $row->fecha;
        // push album
        array_push($clients, $tmp);
      }
      // printing json
      echo json_encode($clients);
    }

    public function edit($id = "") {
      if ($id != "") {
        $data['idRoute'] = $id;
        $route = $this->Routes_Model->get($id);
        if (empty($route)) {
            show_404();
        }
        $data['route'] = $route[0];
        $data['category'] = 'routes';
        $data['action'] = 'edit';
        $data['page'] = 'form';
        $this->load->view('template/template_liquidation', $data);
      }
      else
        redirect('route');
    }

    function save() {
      $data_in['idUser'] = $this->input->post('distributor');
      $data_in['fecha'] = $this->input->post('date');
      $data_in['idZona'] = $this->input->post('route');

      if ($this->Routes_Model->create($data_in) === TRUE) {
        echo TRUE;
      } else {
        echo FALSE;
      }
    }

    function delete($id) {
      $this->City_Model->delete($id);
      redirect('district');
    }
  }
?>