<?php
  class Diary extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      
      $this->load->model('Diary_Model');
      $this->load->model('User_Model');
      $this->load->model('Client_Model');
      
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      }/* else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'diary'))) {
        show_404();
      }*/
    }

    function index() {
      $data['diaries'] = $this->Diary_Model->get_diaries();
      $data['distributor'] = $this->User_Model->get_users_by_profile(4);
      $data['category'] = 'diary';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

     function create() {
      $data['distributor'] = $this->User_Model->get_users_by_profile(4);
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['action'] = 'new';
      $data['page'] = 'form';     
      $this->load->view('template/template', $data);
    }

    function save() {
      $data_in['FechaRegistro'] = date("y-m-d");
      $data_in['FechaTransaction'] = $this->input->post('date');
      $data_in['idUser'] = "1";
      $data_in['idUserSupervisor'] = "1";
      $data_in['idTransaction'] = "1";
      $data_in['NumVoucher'] = $this->input->post('voucher');
      $data_in['idCustomer'] = $this->input->post('client');
      $data_in['Type'] = "credito";
      $data_in['Monto'] = $this->input->post('ammount');
      $data_in['Estado'] = "activo";
      $data_in['Detalle'] = $this->input->post('detail');

      $this->Diary_Model->create($data_in);
    }
/*
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

    

    function delete($id) {
      $this->City_Model->delete($id);
      redirect('district');
    } 
*/

  }
?>