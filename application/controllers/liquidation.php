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

    function charge_list() {
      // creado, cargado, cargaextra1, cargaextra2, cargaextra3, cargafinal
      $data['charges'] = $this->Liquidation_Model->report("active", "all");
      $data['category'] = 'liquidation';
      $data['page'] = 'charge_list';
      $this->load->view('template/template_liquidation', $data); 
    }

    function add_products($liquidation) {
      $data['liquidation'] = $this->Liquidation_Model->get($liquidation);
      /*$data['line'] = $this->Line_Model->get_all_json();
      $data['volume'] = $this->Volume_Model->get_all_json();
      $data['linevolume'] = $this->Linevolume_Model->get_all_json();
      $data['product'] = $this->Product_Model->get_all_json();
      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();
      */
      $data['category'] = 'liquidation';
      $data['page'] = 'add_products';
      $this->load->view('template/template_liquidation', $data);  
    }
    function liquidations_pending() {
      
    }

    function get_lines($idLiquidation){
      $mainArray = array();
      $line = $this->Line_Model->get_all_json();

      foreach ($line as $rowline) {
        $productsContainer = array();
        
        $products = $this->Liquidation_Model->get_detail_list($idLiquidation, $rowline->idLine);
        
        foreach ($products as $rowproduct){
          $arrayProducts = array(
            'idDetalleLiquidacion'     => $rowproduct->idDetalleLiquidacion,
            'idProduct'     => $rowproduct->idProduct,
            'volume'        => $rowproduct->volume,
            'Nombre'        => $rowproduct->Nombre,
            'price'        => $rowproduct->price,
            'uxp'        => $rowproduct->uxp,
            'previousDayP'  => round(($rowproduct->previousDay / $rowproduct->uxp), 0),
            'previousDayU'  => round(($rowproduct->previousDay % $rowproduct->uxp), 0),
            'chargeP'       => round(($rowproduct->charge / $rowproduct->uxp), 0),
            'chargeU'       => round(($rowproduct->charge % $rowproduct->uxp), 0),
            'chargeExtraP1'  => round(($rowproduct->chargeExtra1 / $rowproduct->uxp), 0),
            'chargeExtraU1'  => round(($rowproduct->chargeExtra1 % $rowproduct->uxp), 0),
            'chargeExtraP2'  => round(($rowproduct->chargeExtra2 / $rowproduct->uxp), 0),
            'chargeExtraU2'  => round(($rowproduct->chargeExtra2 % $rowproduct->uxp), 0),
            'chargeExtraP3'  => round(($rowproduct->chargeExtra3 / $rowproduct->uxp), 0),
            'chargeExtraU3'  => round(($rowproduct->chargeExtra3 % $rowproduct->uxp), 0),

            'chargeTotalP'  => 0,
            'chargeTotalU'  => 0,
            'devolutionsP'  => 0,
            'devolutionsU'  => 0,
            'prestamosP'    => 0,
            'prestamosU'    => 0,
            'bonosP'        => 0,
            'bonosU'        => 0,
            'ventaP'        => 0,
            'ventaU'        => 0
          );

          array_push($productsContainer, $arrayProducts);
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

    function save_lines(){
      $data = json_decode(file_get_contents('php://input'), TRUE);
      
      foreach($data['lines'] as $rowLine) {
        foreach($rowLine['products'] as $rowProduct) {
          //print_r($rowProduct['idDetalleLiquidacion']."\n");
          //$data_in['idLiquidacion'] = $data['liquidation'];
          //$data_in['idProduct'] = $rowProduct['idProduct'];
          $data_in['carga1'] = $rowProduct['chargeU'] + ( $rowProduct['chargeP'] * $rowProduct['uxp'] );

          if ($this->Liquidation_Model->update_detail($data_in, $rowProduct['idDetalleLiquidacion'])) {
            $data_liq['mark'] = "cargado";
            $this->Liquidation_Model->update($data_liq, $data['liquidation']);
          }
        }
      }      
    }

    function save() {
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
        $data_in['status'] = "active";
        $data_in['mark'] = "creado";

        //save liquidation
        $idLiquidacion = $this->Liquidation_Model->create($data_in);
        $products = $this->Product_Model->report_android();
        foreach ($products as $rowproduct){
          // create liquidation detail for each product
          $data_pro['idLiquidacion'] = $idLiquidacion;
          $data_pro['idProduct'] = $rowproduct->idProduct;
          $this->Liquidation_Model->create_detail($data_pro);
        }
        redirect("liquidation/charge_list");
      }
    }

  }
?>