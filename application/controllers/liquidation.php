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
      $data['line'] = $this->Line_Model->get_all_json();
      $data['volume'] = $this->Volume_Model->get_all_json();
      $data['linevolume'] = $this->Linevolume_Model->get_all_json();
      $data['product'] = $this->Product_Model->get_all_json();

      $data['category'] = 'liquidation';
      $data['page'] = 'add';
      $this->load->view('template/template_liquidation', $data);
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

	}
?>