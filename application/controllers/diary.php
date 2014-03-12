<?php
  class Diary extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      
      $this->load->model('Diary_Model');
      
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      }/* else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'diary'))) {
        show_404();
      }*/
    }

    function index() {
      //$data['diary'] = $this->Diary_Model->report();
      $data['category'] = 'diary';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

     function create() {
      $data['category'] = 'diary';
      $data['action'] = 'new';
      $data['page'] = 'form';     
      $this->load->view('template/template', $data);
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
*/

  }
?>