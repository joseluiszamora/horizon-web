<?php
  class Volume extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Volume_Model');
      $this->load->model('Linevolume_Model');      
    }

    function index() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'volume'))) {
        show_404();
      }
      $data['volumes'] = $this->Volume_Model->report();
      $data['category'] = 'volume';
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

      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'volume'))) {
        show_404();
      }
      $data['category'] = 'volume';
      $data['action'] = 'new';
      $data['page'] = 'form';

      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($id != "") {
        $data['idVolume'] = $id;
        $volume = $this->Volume_Model->get($id);
        if (empty($volume)) {
            show_404();
        }
        $data['volume'] = $volume[0];
        $data['category'] = 'volume';
        $data['action'] = 'edit';
        $data['page'] = 'form';

        $this->load->view('template/template', $data);
      }
      else
        redirect('volume');
    }

    function save() {
      $this->form_validation->set_rules('desc', 'Descripcion', 'xss_clean|required|is_unique[volume.Descripcion]');

      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_message('is_unique', 'este volumen ya existe.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $data['action'] = 'new';
        }else {
          $data['action'] = 'edit';
        }
        $data['category'] = 'volume';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);

      } else {
        $data_in['Descripcion'] = $this->input->post('desc');        

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          if ($this->Volume_Model->create($data_in) == TRUE) {
            redirect('volume');
          } else {
            $data['category'] = 'volume';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }else{
          if ($this->Volume_Model->update($data_in, $this->input->post('idVolume')) === TRUE) {
            redirect('volume');
          } else {
            $data['category'] = 'volume';
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

    function get_volumes_by_line($idLine=-1) {
      echo(json_encode($this->Linevolume_Model->get_linesvolumes($idLine)));
      //echo $this->Linevolume_Model->get_linesvolumes($idLine);
    }

  }
?>