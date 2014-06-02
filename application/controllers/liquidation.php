<?php
	class Liquidation extends  CI_Controller {		
		public function __construct() {
			parent::__construct();
      
      $this->load->model('Line_Model');
      $this->load->model('Volume_Model');
      $this->load->model('Linevolume_Model');
      $this->load->model('Product_Model');
      $this->load->model('User_Model');
      $this->load->model('Liquidation_Model');

      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'city'))) {
        show_404();
      }
    }

		function index() {
      $data['category'] = 'liquidation';
      $data['page'] = 'index';
      $this->load->view('template/template_liquidation', $data);
		}

    function create() {
      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();

      $data['category'] = 'liquidation';
      $data['page'] = 'create';
      $this->load->view('template/template_liquidation', $data); 
    }

    function charges_made() {
      $data['line'] = $this->Line_Model->get_all_json();
      $data['volume'] = $this->Volume_Model->get_all_json();
      $data['linevolume'] = $this->Linevolume_Model->get_all_json();
      $data['product'] = $this->Product_Model->get_all_json();

      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();

      $data['category'] = 'liquidation';
      $data['page'] = 'create';
      $this->load->view('template/template_liquidation', $data);  
    }

    function liquidations_pending() {
      
    }

    function get_lines(){
      $mainArray = array();

      $line = $this->Line_Model->get_all_json();
      //echo json_encode($line);

      foreach ($line as $rowline) {
        $productsContainer = array();
        $volumes = $this->Linevolume_Model->get_volumes_from_line($rowline->idLine);

        foreach ($volumes as $rowlinevolume) { 
          $products = $this->Product_Model->get_by_linevolume($rowlinevolume->idLineVolume);

          foreach ($products as $rowproduct){
            $arrayProducts = array(
              'idProduct'     => $rowproduct->idProduct,
              'volume'        => $rowlinevolume->Descripcion,
              'Nombre'        => $rowproduct->Nombre,
              'price'        => $rowproduct->PrecioUnit,
              'previousDayP'  => 0,
              'previousDayU'  => 0,
              'chargeP'       => 2,
              'chargeU'       => 2,
              'chargeExtraP'  => 3,
              'chargeExtraU'  => 3,
              'chargeTotalP'  => 100,
              'chargeTotalU'  => 100,
              'devolutionsP'  => 0,
              'devolutionsU'  => 0,
              'prestamosP'    => 0,
              'prestamosU'    => 0,
              'bonosP'        => 0,
              'bonosU'        => 0,
              'ventaP'        => 0,
              'ventaU'        => 0, 
              'totalAmmount'  => 1000   
            );

            array_push($productsContainer, $arrayProducts);
          }

        }

        $line = array(
          'idLine'   => $rowline->idLine,
          'show'     => true,
          'nameLine' => $rowline->Descripcion,          
          'products' => $productsContainer
        ); 
        array_push($mainArray, $line);
      }

      echo json_encode($mainArray);
    }

    function save() {
    /*idLiquidacion
    fechaRegistro
    horaRegistro
    idUser
    ruta
    detalle
    fechaFin
    horaFin
    mark
    *******
    distributor
    route
    date
    desc
    */
      $this->form_validation->set_rules('distributor', 'Distribuidor', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('route', 'Ruta', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('date', 'Fecha', 'xss_clean|required');
      $this->form_validation->set_rules('desc', 'Zona', 'xss_clean|required');
      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_message('integer', 'Debe ser un valor numerico.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        $this->redirect_form('create');
      } else {
        $data_in['fechaRegistro'] = $this->input->post('date');
        $data_in['horaRegistro'] = mdate("%h:%i:%a");
        $data_in['idUser'] = $this->input->post('distributor');
        $data_in['ruta'] = $this->input->post('route');
        $data_in['detalle'] = $this->input->post('desc');
        $data_in['fechaFin'] = $this->input->post('date');
        $data_in['horaFin'] = mdate("%h:%i:%a");
        //$data_in['mark'] = $this->input->post('email');

        if ($this->Liquidation_Model->create($data_in) == TRUE) {
            redirect("liquidation");
          } else {
            $this->redirect_form('create');
          }
      }
    }

	}
?>