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
      $data_in['Days'] = $this->input->post('ammount');

      $this->Rank_Model->create($data_in);
      redirect('rank');
    }

    //edit
    public function edit() {
      $id = $this->input->post('idrank');
      $data['Days'] = $this->input->post('ammount');

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
  }
?>