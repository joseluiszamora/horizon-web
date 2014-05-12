<?php
	class Liquidation extends  CI_Controller {		
		public function __construct() {
			parent::__construct();
      
      $this->load->model('Line_Model');
      $this->load->model('Volume_Model');
      $this->load->model('Linevolume_Model');
      $this->load->model('Product_Model');

      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'city'))) {
        show_404();
      }
    }

		function index() {
      $data['line'] = json_encode($this->Line_Model->get_all_json());
      $data['volume'] = json_encode($this->Volume_Model->get_all_json());
      $data['linevolume'] = json_encode($this->Linevolume_Model->get_all_json());
      $data['product'] = json_encode($this->Product_Model->get_all_json());
      
      $data['category'] = 'liquidation';
      $data['page'] = 'index';
      $this->load->view('template/template_liquidation', $data);
		}

	}
?>