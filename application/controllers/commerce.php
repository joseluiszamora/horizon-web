<?php
  class Commerce extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      $this->load->model('Commerce_Model');
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'commerce'))) {
        show_404();
      }
    }

    function index() {
      $data['commerce'] = $this->Commerce_Model->report();
      $data['category'] = 'commerce';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function create() {
      $data['category'] = 'commerce';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($this->Account_Model->logged_in() === TRUE) {
        if ($id != "") {
          $data['idcommerce'] = $id;
          $commerce = $this->Commerce_Model->get($id);
          if (empty($commerce)) {
              show_404();
          }
          $data['commerce'] = $commerce[0];
          $data['category'] = 'commerce';
          $data['action'] = 'edit';
          $data['page'] = 'form';
          $this->load->view('template/template', $data);
        }
        else
          redirect('commerce');
      } else {
        redirect('account/login');
      }
    }

    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('desc', 'Tipo de Comercio', 'xss_clean|required');
        
        $this->form_validation->set_message('required', '%s es obligatorio.');        
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          if($this->input->post('form_action') == "save") {
            $data['action'] = 'new';
          }else {
            $data['action'] = 'edit';
          }
          $data['category'] = 'commerce';          
          $data['page'] = 'form';
          $this->load->view('template/template', $data);
        } else {
          $data_in['idComercio'] = $this->input->post('idcommerce');
          $data_in['Descripcion'] = $this->input->post('desc');

          // Check if Save or Edit
          if($this->input->post('form_action') == "save") {
            if ($this->Commerce_Model->create($data_in) === TRUE) {
              redirect('commerce');
            } else {
              $data['category'] = 'commerce';
              $data['action'] = 'new';
              $data['page'] = 'form';
              $this->load->view('template/template', $data);
            }
          }else{
            if ($this->Commerce_Model->update($data_in, $data_in['idComercio']) === TRUE) {
              redirect('commerce');
            } else {
              $data['category'] = 'commerce';
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
      $this->Commerce_Model->delete($id);
      redirect('commerce');
    }  

  }
?>