<?php
  class Line extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Line_Model');
      $this->load->model('Volume_Model');
      $this->load->model('Linevolume_Model');
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'line'))) {
        show_404();
      }
    }

    function index() {
      $data['lines'] = $this->Line_Model->report();
      $volumes = $this->Volume_Model->report_from_lines();

      $line_volumes = array();
      foreach ($data['lines'] as $line) {
        $line_volumes[$line->idLine]=array();
      }

      //foreach ($volumes as $volume) {
      //  array_push($line_volumes[$volume->idVolume], $volume);
      //}
      $data['volumes'] = $line_volumes;

      $data['category'] = 'line';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
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
    }

    function create() {
      $data['category'] = 'line';
      $data['action'] = 'new';
      $data['page'] = 'form';

      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($id != "") {
        $data['idLine'] = $id;
        $line = $this->Line_Model->get($id);
        if (empty($line)) {
            show_404();
        }
        $data['line'] = $line[0];
        $data['category'] = 'line';
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
      $this->form_validation->set_rules('desc', 'Descripcion', 'xss_clean|required');

      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $data['action'] = 'new';
        }else {
          $data['action'] = 'edit';
        }
        $data['category'] = 'line';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);

      } else {
        $data_in['Descripcion'] = $this->input->post('desc');
        $data_in['uxplinea'] = $this->input->post('uxplinea');
        $data_in['regular'] = $this->input->post('regular');

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          if ($this->Line_Model->create($data_in) == TRUE) {
            redirect('line');
          } else {
            $data['category'] = 'line';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }else{
          if ($this->Line_Model->update($data_in, $this->input->post('idLine')) === TRUE) {
            redirect('line');
          } else {
            $data['category'] = 'line';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }
      }
    }

    function add_volume($id) {
      if ($id != "") {
        $data['idLine'] = $id;
        $line = $this->Line_Model->get($id);
        $data['line'] = $line[0];
        if (empty($line)) {
            show_404();
        }
        $data['volumes'] = $this->Linevolume_Model->get_volumes();
        $data['category'] = 'linevolume';
        $data['action'] = 'add_volume';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);
      }
      else
        redirect('line');
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