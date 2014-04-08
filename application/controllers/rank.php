<?php
  class Rank extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Rank_Model');
      $this->load->model('Diary_Model');
    }

    function index() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'volume'))) {
        show_404();
      }
      $data['ranks'] = $this->Rank_Model->report();
      $data['category'] = 'rank';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    //guardar
    function save() {
      $data_in['Limit'] = $this->input->post('ammount');

      $this->Rank_Model->create($data_in);
      redirect('rank');
    }

    //edit
    public function edit() {
      $id = $this->input->post('idrank');
      $data['Limit'] = $this->input->post('ammount');

      if ($this->Rank_Model->update($data, $id)) {
        // Save log for this action
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '51';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
      }
      redirect('rank');

    }

    // eliminar
    function delete($id) {
      $this->Rank_Model->delete($id);
      redirect('rank');
    }
/*

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

    function get_volumes_by_line($idLine=-1) {
      echo(json_encode($this->Linevolume_Model->get_linesvolumes($idLine)));
      //echo $this->Linevolume_Model->get_linesvolumes($idLine);
    }
    */

  }
?>