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
      $this->load->model('City_Model');
      $this->load->model('Area_Model');

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
      $data['distributor'] = $this->Liquidation_Model->get_enabled_users_and_zones();
      $data['cities'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['linenoregular'] = $this->Line_Model->get_no_regular_lines();
      $areas = $this->Area_Model->report("1", 'zona.idZona');
      $area_list = $this->Area_Model->get_area_list("all", "1");
      $dropdown_list = array();
      foreach ($areas as $row){
        if ($row->Estado == "1" && $row->level == "0"){
          $dropdown = array();
          $dropdown[0] = 'Seleccione Ruta';
          foreach ($area_list as $row_area){
            if ($row_area->Estado == "1" && $row_area->level == "1" && $row_area->parent == $row->idZona){
              $dropdown[$row_area->idZona] = $row_area->Descripcion;
            }
          }
          $dropdown_list[$row->idZona] = $dropdown;
        }
      }
      $data['dropdown_list'] = $dropdown_list;


      $data['category'] = 'liquidation';
      $data['page'] = 'create';
      $this->load->view('template/template_liquidation', $data);
    }

    function charge_list() {
      // creado, cargado, cargaextra1, cargaextra2, cargaextra3, cargafinal
      $data['charges'] = $this->Liquidation_Model->report("active", "charges");
      $data['category'] = 'liquidation';
      $data['page'] = 'charge_list';
      $this->load->view('template/template_liquidation', $data);
    }

    function devolutions() {
      $data['charges'] = $this->Liquidation_Model->report("active", "devolutions");
      $data['category'] = 'liquidation';
      $data['page'] = 'devolution_list';
      $this->load->view('template/template_liquidation', $data);
    }

    function liquidation_list() {
      $data['charges'] = $this->Liquidation_Model->report("active", "liquidation");
      $data['category'] = 'liquidation';
      $data['page'] = 'liquidation_list';
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
      //print_r($data);
    }

    function add_irregular_products(){
      $idliquid = $this->input->post('idliquid');

      //add NO regular products
      $lines = explode("***", $this->input->post('noregular'));
      foreach ($lines as $line) {
        $productsnoregular = $this->Product_Model->get_products_by_line($line);
        foreach ($productsnoregular as $rowproduct){
          $data_pro['idLiquidacion'] = $idliquid;
          $data_pro['idProduct'] = $rowproduct->idProduct;
          $this->Liquidation_Model->create_detail($data_pro);
        }
      }
      redirect("liquidation/charge_list");
    }

    function show($liquidation) {
      $data['liquidation'] = $this->Liquidation_Model->get($liquidation);
      $data['category'] = 'liquidation';
      $data['page'] = 'show';
      $this->load->view('template/template_liquidation', $data);
    }

    function devolution($liquidation) {
      $data['liquidation'] = $this->Liquidation_Model->get($liquidation);
      $data['irregularlines'] = $this->Liquidation_Model->get_no_regular_lines($liquidation);
      $data['category'] = 'liquidation';
      $data['page'] = 'devolution';
      $this->load->view('template/template_liquidation', $data);  
    }

    function liquidation_mod($liquidation) {
      $data['liquidation'] = $this->Liquidation_Model->get($liquidation);
      $data['category'] = 'liquidation';
      $data['page'] = 'liquidation';
      $this->load->view('template/template_liquidation', $data);
    }

    function complete_charge($liquidation) {
      $this->Liquidation_Model->clean_products_without_charges($liquidation);
      $data['mark'] = "cargafinal";
      $this->Liquidation_Model->update($data, $liquidation);

      redirect("liquidation/charge_list");
    }

    function get_lines($idLiquidation){
      $mainArray = array();
      $line = $this->Liquidation_Model->get_lines_actives($idLiquidation);

      foreach ($line as $rowline) {
        $productsContainer = array();
        $products = $this->Liquidation_Model->get_detail_list($idLiquidation, $rowline->idLine);
        foreach ($products as $rowproduct){
          $partialcharge = $rowproduct->previousDay + $rowproduct->charge + $rowproduct->chargeExtra1 + $rowproduct->chargeExtra2 + $rowproduct->chargeExtra3;
          $arrayProducts = array(
            'idDetalleLiquidacion'     => $rowproduct->idDetalleLiquidacion,
            'idProduct'     => $rowproduct->idProduct,
            'volume'        => $rowproduct->volume,
            'Nombre'        => $rowproduct->Nombre,
            'price'        => $rowproduct->price,
            'uxp'        => $rowproduct->uxp,
            'previousDayP'  => floor($rowproduct->previousDay / $rowproduct->uxp),
            'previousDayU'  => round(($rowproduct->previousDay % $rowproduct->uxp), 0),
            'chargeP'       => floor($rowproduct->charge / $rowproduct->uxp),
            'chargeU'       => round(($rowproduct->charge % $rowproduct->uxp), 0),
            'chargeExtraP1'  => floor($rowproduct->chargeExtra1 / $rowproduct->uxp),
            'chargeExtraU1'  => round(($rowproduct->chargeExtra1 % $rowproduct->uxp), 0),
            'chargeExtraP2'  => floor($rowproduct->chargeExtra2 / $rowproduct->uxp),
            'chargeExtraU2'  => round(($rowproduct->chargeExtra2 % $rowproduct->uxp), 0),

            'chargeExtraP3'  => floor($rowproduct->chargeExtra3 / $rowproduct->uxp),
            'chargeExtraU3'  => round(($rowproduct->chargeExtra3 % $rowproduct->uxp), 0),

            'chargeTotalP'   => floor(($partialcharge) / $rowproduct->uxp),
            'chargeTotalU'   => round((($partialcharge) % $rowproduct->uxp), 0),

            'devolutionP'    => floor($rowproduct->devolucion / $rowproduct->uxp),
            'devolutionU'    => round(($rowproduct->devolucion % $rowproduct->uxp), 0),

            'prestamosP'     => 0,
            'prestamosU'     => 0,

            'bonosP'         => 0,
            'bonosU'         => 0,

            'ajusteP'     => 0,
            'ajusteU'     => 0,

            'calculatedP' => floor(($partialcharge - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion) / $rowproduct->uxp),

            'calculatedU' => round((($partialcharge - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion) % $rowproduct->uxp), 0),

            'ventaP'         => 0,
            'ventaU'         => 0,

            'totalAmmount'   => (($partialcharge - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion) * $rowproduct->price)
            //'totalAmmount'   => $partialcharge - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion
          );

          array_push($productsContainer, $arrayProducts);
        }

        $line = array(
          'idLine'   => $rowline->idLine,
          'show'     => true,
          'nameLine' => $rowline->Descripcion,
          'lineUxp' => $rowline->uxplinea,
          'products' => $productsContainer
        );
        array_push($mainArray, $line);
      }

      echo json_encode($mainArray);
    }

    function get_lines_view($idLiquidation){
      $mainArray = array();
      $line = $this->Liquidation_Model->get_lines_actives($idLiquidation);

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
            'previousDayP'  => floor($rowproduct->previousDay / $rowproduct->uxp),
            'previousDayU'  => round(($rowproduct->previousDay % $rowproduct->uxp), 0),
            'chargeP'       => floor($rowproduct->charge / $rowproduct->uxp),
            'chargeU'       => round(($rowproduct->charge % $rowproduct->uxp), 0),
            'chargeExtraP1'  => floor($rowproduct->chargeExtra1 / $rowproduct->uxp),
            'chargeExtraU1'  => round(($rowproduct->chargeExtra1 % $rowproduct->uxp), 0),
            'chargeExtraP2'  => floor($rowproduct->chargeExtra2 / $rowproduct->uxp),
            'chargeExtraU2'  => round(($rowproduct->chargeExtra2 % $rowproduct->uxp), 0),

            'chargeExtraP3'  => floor($rowproduct->chargeExtra3 / $rowproduct->uxp),
            'chargeExtraU3'  => round(($rowproduct->chargeExtra3 % $rowproduct->uxp), 0),

            'chargeTotalP'   => 0,
            'chargeTotalU'   => 0,

            'devolutionP'    => floor($rowproduct->devolucion / $rowproduct->uxp),
            'devolutionU'    => round(($rowproduct->devolucion % $rowproduct->uxp), 0),

            'prestamosP'     => 0,
            'prestamosU'     => 0,

            'bonosP'         => 0,
            'bonosU'         => 0,

            'ajusteP'     => 0,
            'ajusteU'     => 0,

            'calculatedP' => floor(($rowproduct->previousDay + $rowproduct->charge + $rowproduct->chargeExtra1 + $rowproduct->chargeExtra2 + $rowproduct->chargeExtra3 - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion) / $rowproduct->uxp),

            'calculatedU' => round((($rowproduct->previousDay + $rowproduct->charge + $rowproduct->chargeExtra1 + $rowproduct->chargeExtra2 + $rowproduct->chargeExtra3 - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion) % $rowproduct->uxp), 0),

            'ventaP'         => 0,
            'ventaU'         => 0,

            'totalAmmount'   => 0
          );

          array_push($productsContainer, $arrayProducts);
        }

        $line = array(
          'idLine'   => $rowline->idLine,
          'show'     => true,
          'nameLine' => $rowline->Descripcion,
          'lineUxp' => $rowline->uxplinea,
          'products' => $productsContainer
        );
        array_push($mainArray, $line);
      }

      return $mainArray;
    }

    function save_lines(){
      $data = json_decode(file_get_contents('php://input'), TRUE);
      
      foreach($data['lines'] as $rowLine) {
        foreach($rowLine['products'] as $rowProduct) {
          $data_in['carga1'] = $rowProduct['chargeU'] + ( $rowProduct['chargeP'] * $rowProduct['uxp'] );
          $data_in['carga2'] = $rowProduct['chargeExtraU1'] + ( $rowProduct['chargeExtraP1'] * $rowProduct['uxp'] );
          $data_in['carga3'] = $rowProduct['chargeExtraU2'] + ( $rowProduct['chargeExtraP2'] * $rowProduct['uxp'] );
          $data_in['carga4'] = $rowProduct['chargeExtraU3'] + ( $rowProduct['chargeExtraP3'] * $rowProduct['uxp'] );
          $data_in['devolucion'] = $rowProduct['devolutionU'] + ( $rowProduct['devolutionP'] * $rowProduct['uxp'] );

          $this->Liquidation_Model->update_detail($data_in, $rowProduct['idDetalleLiquidacion']);
        }
      }

      if ($data['mark'] == "creado" ) {
        $data_liq['mark'] = "cargado";
      }elseif ($data['mark'] == "cargado") {
        $data_liq['mark'] = "cargaextra1";
      }elseif ($data['mark'] == "cargaextra1") {
        $data_liq['mark'] = "cargaextra2";
      }elseif ($data['mark'] == "cargaextra2") {
        $data_liq['mark'] = "cargafinal";
      }else{
        $data_liq['mark'] = "liquidation";
      }
      
      $this->Liquidation_Model->update($data_liq, $data['liquidation']);
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
        redirect("liquidation/index");
      }
    }

    function saved() {
      $data_in['fechaRegistro'] = $this->input->post('date');
      $data_in['horaRegistro'] = mdate("%h:%i:%a");
      $data_in['idUser'] = $this->input->post('distributor');
      $data_in['ruta'] = $this->input->post('route');
      $data_in['detalle'] = $this->input->post('desc');
      $data_in['fechaFin'] = $this->input->post('date');
      $data_in['horaFin'] = mdate("%h:%i:%a");
      $data_in['status'] = "active";
      $data_in['mark'] = "creado";
      //$data_in['lastliquid'] = $this->input->post('lastliquid');

      $idLiquidacion = $this->Liquidation_Model->create($data_in);
      // add regular products
      $products = $this->Product_Model->get_regular_products();
      foreach ($products as $rowproduct){
        $data_pro['idLiquidacion'] = $idLiquidacion;
        $data_pro['idProduct'] = $rowproduct->idProduct;
        $this->Liquidation_Model->create_detail($data_pro);
      }

      //add NO regular products
      $lines = explode("***", $this->input->post('noregular'));
      foreach ($lines as $line) {
        $productsnoregular = $this->Product_Model->get_products_by_line($line);
        foreach ($productsnoregular as $rowproduct){
          $data_pro['idLiquidacion'] = $idLiquidacion;
          $data_pro['idProduct'] = $rowproduct->idProduct;
          $this->Liquidation_Model->create_detail($data_pro);
        }
      }
      echo $idLiquidacion;
    }


    function pdf($liquidation) {
      $this->load->helper('pdfexport_helper.php');
      $data['title'] = 'PLANILLA DE CARGA DE PRODUCTOS';
      $data['liquidation'] = $this->Liquidation_Model->get($liquidation);
      $data['lines'] = $this->get_lines_view($liquidation);
      $data['category'] = 'liquidation';
      $data['page'] = 'pdf_1';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('liquidation/template_pdf_1', $data);
      $templateView = $this->load->view('liquidation/pdf_1', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
    }

    function deactive($liquidation) {
      // desactivar liquidacion
      $data_liq['status'] = "deactive";
      $this->Liquidation_Model->update($data_liq, $liquidation);
      // desactivar todos detalle liquidation
      $this->Liquidation_Model->update_detail_liquidations($data_liq, $liquidation);
      redirect("liquidation/charge_list");
    }
    /*function pdf($liquidation) {
      $this->load->helper('pdfexport_helper.php');

      $user_email = $this->Account_Model->get_email();
      $user = $this->Account_Model->get_user_by_email($user_email);

      $data['title'] = 'PRODUCTOS';
      $data['products'] = $products;
      $data['category'] = 'liquidation';
      $data['page'] = 'pdf_1';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      $templateView = $this->load->view('liquidation/template_pdf_1', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
    }*/

  }
?>