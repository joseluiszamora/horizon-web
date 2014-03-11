<?php
  class Track extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Track_Model');
      $this->load->model('User_Model');

      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Account_Model->get_profile() == "1")) {
        show_404();
      }
    }

    function index() {
      $data['user'] = $this->User_Model->get_users_by_city_mail($this->Account_Model->get_city());
      //$data['track'] = $this->Track_Model->report();
      $data['track'] = array();
      $data['category'] = 'track';
      $data['page'] = 'index';
      //$this->load->view('template/template', $data);
      $this->load->view('template/header_simple', $data);
      $this->load->view('track/index', $data);
      $this->load->view('template/footer', $data);
    }

    function search() {
      $this->form_validation->set_rules('dateStart', 'dateStart', 'xss_clean');
      $this->form_validation->set_rules('startHour', 'startHour', 'xss_clean');
      $this->form_validation->set_rules('startFinish', 'startFinish', 'xss_clean');
      $this->form_validation->set_rules('searchuser', 'searchuser', 'xss_clean');
      $this->form_validation->set_message('xss_clean', 'security: danger value.');
	
	if ($this->form_validation->run() == FALSE){
		$data['user'] = $this->User_Model->get_users_by_city_mail($this->Account_Model->get_city());
		$data['track'] = $this->Track_Model->report();
		$data['category'] = 'track';
		$data['page'] = 'index';
		$this->load->view('template/template', $data);
	      }else{
		$data_in['dateStart'] = $this->input->post('dateStart');
		$data_in['startHour'] = $this->input->post('startHour');
		$data_in['startFinish'] = $this->input->post('startFinish');
		$data_in['searchuser'] = $this->input->post('searchuser');
		$data['user'] = $this->User_Model->get_users_by_city_mail($this->Account_Model->get_city());
		
		$data['track'] = $this->Track_Model->search($data_in);
		//$data['track'] = Array();
		
		//print_r("<br>:):):):):):):):):):):):)<br>");
		//print_r($data['track']);

		$data['category'] = 'track';
		$data['page'] = 'index';
		//$this->load->view('template/template', $data);
		$this->load->view('template/header_simple', $data);
		$this->load->view('track/index', $data);
		$this->load->view('template/footer', $data);
	      }	
    }

    function last() {
      $this->form_validation->set_rules('searchuser', 'searchuser', 'xss_clean');
      $this->form_validation->set_message('xss_clean', 'security: danger value.');

      if ($this->form_validation->run() == FALSE){
        $data['user'] = $this->User_Model->get_users_by_city_mail($this->Account_Model->get_city());
        $data['track'] = $this->Track_Model->report();
        $data['category'] = 'track';
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }else{
        $data_in['searchuser'] = $this->input->post('searchuser');

        $data['user'] = $this->User_Model->get_users_by_city_mail($this->Account_Model->get_city());
        $data['track'] = $this->Track_Model->last($data_in);
        $data['category'] = 'track';
        $data['page'] = 'index';
        //$this->load->view('template/template', $data);
        $this->load->view('template/header_simple', $data);
        $this->load->view('track/index', $data);
        $this->load->view('template/footer', $data);
      }
    }
  }
?>
