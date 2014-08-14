<?php
	class Bonus extends  CI_Controller {		
		public function __construct() {
			parent::__construct();
      $this->load->model('Bonus_model');
      $this->load->model('Product_model');
      $this->load->model('Linevolume_Model');
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'city'))) {
        show_404();
      }
    }

		function index() {
			$data['bonus'] = $this->Bonus_model->report(array());
      $data['category'] = 'bonus';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
		}

		 function create() {
      $data['lines'] = $this->Linevolume_Model->get_lines();
      $data['volumes'] = $this->Linevolume_Model->get_volumes();
      $data['category'] = 'bonus';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($id != "") {
        $data['lines'] = $this->Linevolume_Model->get_lines();
        $data['volumes'] = $this->Linevolume_Model->get_volumes();
        $data['idBonus'] = $id;
        $bonus = $this->Bonus_Model->get($id);
        if (empty($bonus)) {
            show_404();
        }
        $data['bonus'] = $bonus[0];
        $data['lines'] = $this->Linevolume_Model->get_lines();
        $data['volumes'] = $this->Linevolume_Model->get_volumes();
        $data['category'] = 'bonus';
        $data['action'] = 'edit';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);
      }
      else
        redirect('bonus');
    }

    function save() {
      $this->form_validation->set_rules('idLineFrom', 'Nombre de la ciudad', 'xss_clean|required');
      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $data['action'] = 'new';
        }else {
          $data['action'] = 'edit';
        }
        $data['lines'] = $this->Linevolume_Model->get_lines();
        $data['volumes'] = $this->Linevolume_Model->get_volumes();
        $data['category'] = 'bonus';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);
      } else {
        // idLineFrom  idProductFrom   quantityfrom   idLineTo  idProductTo  quantityto

        if ($this->input->post('idProductFrom') != 0) {
          $data_in['type'] = "P";
        } else {
          $data_in['type'] = "L";
        }
        $data_in['idLine'] = $this->input->post('idLineFrom');
        $data_in['idProduct'] = $this->input->post('idProductFrom');
        $data_in['cantidad'] = $this->input->post('quantityfrom');
        $data_in['idProduct_bonus'] = $this->input->post('idProductTo');
        $data_in['cantidad_bonus'] = $this->input->post('quantityto');
        $data_in['status'] = "1";

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          if ($this->Bonus_model->create($data_in) === TRUE) {
            redirect('bonus');
          } else {
            $data['lines'] = $this->Linevolume_Model->get_lines();
            $data['volumes'] = $this->Linevolume_Model->get_volumes();
            $data['category'] = 'bonus';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }else{
          $data_in['idbonus'] = $this->input->post('idBonus');
          if ($this->Bonus_Model->update($data_in, $data_in['idbonus']) === TRUE) {
            redirect('bonus');
          } else {
            $data['lines'] = $this->Linevolume_Model->get_lines();
            $data['volumes'] = $this->Linevolume_Model->get_volumes();
            $data['category'] = 'bonus';
            $data['action'] = 'edit';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }
      }
    }
    function delete($id) {
      $this->Bonus_model->delete($id);
      redirect('bonus');
    }
	}
?>