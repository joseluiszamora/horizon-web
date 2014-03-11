<?php
  class Linevolume extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Line_Model');
      $this->load->model('Volume_Model');
      $this->load->model('Linevolume_Model');
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      }
    }

    function index() {
      redirect('lines');
    }

    // send Client list for android client
    function report_android(){

      $clients = array();

      $client_list  = $this->Client_Model->report_android();
      // looping through each album
      foreach ($client_list as $row) {
        $tmp = array();

        $tmp["CodeCustomer"] = $row->CodeCustomer;
        $tmp["NombreTienda"] = $row->NombreTienda;
        $tmp["NombreContacto"] = $row->NombreContacto;
        $tmp["Direccion"] = $row->Direccion;
        $tmp["Telefono"] = $row->Telefono;
        $tmp["TelfCelular"] = $row->TelfCelular;

        // push album
        array_push($clients, $tmp);
      }

      // printing json
      echo json_encode($clients);

      /*$Clients = json_encode($this->Client_Model->report_android());

      foreach ($Clients as $row){
        $row->NombreTienda;
      }
      echo $Clients;
      */
    }

    //revisar
    function create() {
      $data['category'] = 'line';
      $data['action'] = 'new';
      $data['page'] = 'form';

      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($id != "") {
        $data['idLineVolume'] = $id;
        $linevolume = $this->Linevolume_Model->get($id);
        $data['lines'] = $this->Linevolume_Model->get_lines();
        $data['volumes'] = $this->Linevolume_Model->get_volumes();
        if (empty($linevolume)) {
            show_404();
        }
        $data['linevolume'] = $linevolume[0];
        $data['category'] = 'linevolume';
        $data['action'] = 'edit';
        $data['page'] = 'form';

        $this->load->view('template/template', $data);
      }
      else
        redirect('line');
    }

    public function volumes($id = "") {
      if ($id != "") {
        $data['idLine'] = $id;
        $line = $this->Line_Model->get($id);
        $volumes = $this->Line_Model->get_volumes($id);
        if (empty($line)) {
            show_404();
        }
        $data['line'] = $line[0];
        $data['volumes'] = $volumes;
        $data['category'] = 'line';
        $data['action'] = 'volumes';
        $data['page'] = 'volumes';

        $this->load->view('template/template', $data);
      }
      else
        redirect('line');
    }

    function save() {
      $this->form_validation->set_rules('idLine', 'Línea', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('idVolume', 'Volumen', 'xss_clean|required|greater_than[0]');

      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "add_volume") {
          $data['idLine'] = $this->input->post('idLine');
          $data['action'] = 'add_volume';
        } else if($this->input->post('form_action') == "save") {
          $data['lines'] = $this->Linevolume_Model->get_lines();
          $data['action'] = 'new';
        } else {
          $data['lines'] = $this->Linevolume_Model->get_lines();
          $data['action'] = 'edit';
        }
        $data['volumes'] = $this->Linevolume_Model->get_volumes();
        $data['category'] = 'linevolume';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);

      } else {
        $data_in['idLine'] = $this->input->post('idLine');
        $data_in['idVolume'] = $this->input->post('idVolume');

        // generate customer code
       // $zone_code = $this->District_Model->get_area_code($this->input->post('district'));
        //$data_in['CodeCustomer'] = '0';

        // Check if Save or Edit
        if(($this->input->post('form_action') == "save") || ($this->input->post('form_action') == "add_volume")) {
          if ($this->Linevolume_Model->create($data_in) == TRUE) {
            redirect('line');
          } else {
            $data['category'] = 'linevolume';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }else{
          if ($this->Linevolume_Model->update($data_in, $this->input->post('idLineVolume')) === TRUE) {
            redirect('line');
          } else {
            $data['category'] = 'linevolume';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }
      }
    }

    // desactivar usuario
    function deactive($cli) {
      $this->Client_Model->set_client_status($cli, '0');
      redirect('client');
    }

    // activar usuario
    function active($cli) {
      $this->Client_Model->set_client_status($cli, '1');
      redirect('client');
    }

    // eliminar usuario
    function delete($cli) {
      $this->Client_Model->set_client_status($cli, '2');
      redirect('client');
    }

  }
?>