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
      $this->load->model('Routes_Model');
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

    function history_list() {
      $data['distributor'] = $this->Liquidation_Model->get_users_and_zones_clear();
      $data['charges'] = $this->Liquidation_Model->report("active", "completado");
      $data['category'] = 'liquidation';
      $data['page'] = 'history_list';
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
      // update extras
      $this->charge_liquidation_extras($liquidation, $data['liquidation'][0]->idUser, $data['liquidation'][0]->fechaRegistro);

      $data['category'] = 'liquidation';
      $data['page'] = 'liquidation';
      $this->load->view('template/template_liquidation', $data);
    }

    function charge_liquidation_extras($liquidation, $user, $date){
      // CHARGE BONUS
      $result = $this->Liquidation_Model->charge_liquidation_bonus($user, $date);
      foreach ($result as $r){
        $data['bonificacion'] = $r->Cantidad;
        $this->Liquidation_Model->update_detail_liquidations_by_product($data, $liquidation, $r->idProduct);
      }
      /*
      // CHARGE VENTA ANDROID
      $result = $this->Liquidation_Model->charge_liquidation_android($user, $date);
      foreach ($result as $r){
        $data['prestamo'] = $r->Cantidad;
        $this->Liquidation_Model->update_detail_liquidations_by_product($data, $liquidation, $r->idProduct);
      }*/

      // CHARGE PRESTAMOS
      $result = $this->Liquidation_Model->charge_liquidation_prestamos($user, $date);
      foreach ($result as $r){
        $data['prestamo'] = $r->Cantidad;
        $this->Liquidation_Model->update_detail_liquidations_by_product($data, $liquidation, $r->idProduct);
      }
    }

    function complete_charge($liquidation) {
      $data['mark'] = "cargafinal";
      $this->Liquidation_Model->update($data, $liquidation);

      redirect("liquidation/charge_list");
    }

    function get_products_exception(){
      $idLiquidation = $this->input->post('liquidation');
      $res = "";
      $line = $this->Liquidation_Model->get_lines_actives($idLiquidation, 1);
      foreach ($line as $rowline){
        $products = $this->Liquidation_Model->get_detail_list($idLiquidation, $rowline->idLine, 1);
        $res .= '<li class="list-group-item" style="background-color:  #428BCA; color: #FFF;">';
        $res .= "LINEA ".$rowline->Descripcion;
        $res .= '</li>';
        foreach ($products as $rowproduct){
          $res .= '<li class="list-group-item">';
          $res .= '<span class="badge">'.$rowproduct->devolucion.'</span>';
          $res .= $rowproduct->Nombre;
          $res .= '</li>';
        }
      }
      echo $res;
    }

    function get_products_exception_count(){
      $idLiquidation = $this->input->post('liquidation');
      $res = 0;
      $line = $this->Liquidation_Model->get_lines_actives($idLiquidation, 1);
      foreach ($line as $rowline){
        $products = $this->Liquidation_Model->get_detail_list($idLiquidation, $rowline->idLine, 1);
        foreach ($products as $rowproduct){
          $res++;
        }
      }
      echo $res;
    }

    function get_lines($idLiquidation){
      $mainArray = array();
      $line = $this->Liquidation_Model->get_lines_actives($idLiquidation, 0);

      foreach ($line as $rowline) {
        $productsContainer = array();
        $products = $this->Liquidation_Model->get_detail_list($idLiquidation, $rowline->idLine, 0);
        foreach ($products as $rowproduct){
          $partialcharge = $rowproduct->previousDay + $rowproduct->charge + $rowproduct->chargeExtra1 + $rowproduct->chargeExtra2 + $rowproduct->chargeExtra3;
          $arrayProducts = array(
            'idDetalleLiquidacion'     => $rowproduct->idDetalleLiquidacion,
            'idProduct'     => $rowproduct->idProduct,
            'volume'        => $rowproduct->volume,
            'Nombre'        => $rowproduct->Nombre,
            'price'         => $rowproduct->price,
            'uxp'           => $rowproduct->uxp,
            'previousDayP'  => floor($rowproduct->previousDay / $rowproduct->uxp),
            'previousDayU'  => round(($rowproduct->previousDay % $rowproduct->uxp), 0),
            'chargeP'       => floor($rowproduct->charge / $rowproduct->uxp),
            'chargeU'       => round(($rowproduct->charge % $rowproduct->uxp), 0),
            'chargeExtraP1' => floor($rowproduct->chargeExtra1 / $rowproduct->uxp),
            'chargeExtraU1' => round(($rowproduct->chargeExtra1 % $rowproduct->uxp), 0),
            'chargeExtraP2' => floor($rowproduct->chargeExtra2 / $rowproduct->uxp),
            'chargeExtraU2' => round(($rowproduct->chargeExtra2 % $rowproduct->uxp), 0),

            'chargeExtraP3' => floor($rowproduct->chargeExtra3 / $rowproduct->uxp),
            'chargeExtraU3' => round(($rowproduct->chargeExtra3 % $rowproduct->uxp), 0),

            'chargeTotalP'  => floor(($partialcharge) / $rowproduct->uxp),
            'chargeTotalU'  => round((($partialcharge) % $rowproduct->uxp), 0),

            'devolutionP'   => floor($rowproduct->devolucion / $rowproduct->uxp),
            'devolutionU'   => round(($rowproduct->devolucion % $rowproduct->uxp), 0),

            'prestamosP'    => floor($rowproduct->prestamo / $rowproduct->uxp),
            'prestamosU'    => round(($rowproduct->prestamo % $rowproduct->uxp), 0),

            'bonosP'        => floor($rowproduct->bonificacion / $rowproduct->uxp),
            'bonosU'        => round(($rowproduct->bonificacion % $rowproduct->uxp), 0),

            'ajusteP'       => floor($rowproduct->ajuste / $rowproduct->uxp),
            'ajusteU'       => round(($rowproduct->ajuste % $rowproduct->uxp), 0),

            //'calculatedP' => floor(($partialcharge - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion) / $rowproduct->uxp),

            //'calculatedU' => round((($partialcharge - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion) % $rowproduct->uxp), 0),
            'calculatedP'   => 0,
            'calculatedU'   => 0,

            'androidP'      => floor($rowproduct->android / $rowproduct->uxp),
            'androidU'      => round(($rowproduct->android % $rowproduct->uxp), 0),

            'ventaP'         => 0,
            'ventaU'         => 0,

            //'totalAmmount'   => (($partialcharge - $rowproduct->devolucion - $rowproduct->prestamo - $rowproduct->bonificacion) * $rowproduct->price)
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

      echo json_encode($mainArray);
    }


    function get_expenses($idLiquidation){
      $mainArray = array();
      $line = $this->Liquidation_Model->get_expenses($idLiquidation, 0);

      foreach ($line as $rowline) {
        $line = array(
          'ammount'   => $rowline->Monto,
          'title'   => $rowline->Detalle
        );
        array_push($mainArray, $line);
      }

      echo json_encode($mainArray);
    }




    function get_lines_view($idLiquidation){
      $mainArray = array();
      $line = $this->Liquidation_Model->get_lines_actives($idLiquidation, 0);

      foreach ($line as $rowline) {
        $productsContainer = array();
        $products = $this->Liquidation_Model->get_detail_list($idLiquidation, $rowline->idLine, 0);
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

            'ajusteP'    => floor($rowproduct->ajuste / $rowproduct->uxp),
            'ajusteU'    => round(($rowproduct->ajuste % $rowproduct->uxp), 0),

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
          $data_in['ajuste'] = $rowProduct['ajusteU'] + ( $rowProduct['ajusteP'] * $rowProduct['uxp'] );
          $data_in['total'] = ((($data_in['carga1'] + $data_in['carga2'] + $data_in['carga3'] + $data_in['carga4'] + $data_in['ajuste']) - ($data_in['devolucion'])) * $rowProduct['price']);

          if (intval($data_in['carga1']) <= 0 && intval($data_in['carga2']) <= 0 && intval($data_in['carga3']) <= 0 && intval($data_in['carga4']) <= 0 && intval($data_in['devolucion']) > 0 ) {
            $data_in['excepcion'] = 1;
          }else{
            $data_in['excepcion'] = 0;
          }
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
      }elseif ($data['mark'] == "cargafinal") {
        $data_liq['mark'] = "liquidation";
        $this->Liquidation_Model->clean_products_without_charges($data['liquidation']);
      }elseif ($data['mark'] == "liquidation"){
        $data_liq['mark'] = "completado";
      }else{
        $data_liq['mark'] = "liquidation";
      }

      $this->Liquidation_Model->update($data_liq, $data['liquidation']);

      $data_exp['idliquidacion'] = $data['liquidation'];
      foreach($data['expenses'] as $rowExpense){
        $data_exp['Detalle'] = strtoupper($rowExpense['title']);

        if (floatval($rowExpense['ammount']) > 0) {
          $data_exp['Monto'] = floatval($rowExpense['ammount']);
          $this->Liquidation_Model->create_expense($data_exp);
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
        redirect("liquidation/index");
      }
    }

    function saved() {
      $data_in['fechaRegistro'] = $this->input->post('date');
      $data_in['horaRegistro'] = mdate("%h:%i:%a");
      $data_in['idUser'] = $this->input->post('distributor');
      // check if exist route
      //$data_in['ruta'] = $this->input->post('route');
      $data_in['ruta'] = $this->Routes_Model->get_route($this->input->post('distributor'), $this->input->post('date'));

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
        if (!($this->input->post('lastliquid') == "true")){
          $data_pro['carga0'] = $this->Liquidation_Model->charge_last_devolutions($rowproduct->idProduct, $this->input->post('distributor'), $this->input->post('date'));
        }

        $this->Liquidation_Model->create_detail($data_pro);

        //print_r($this->Liquidation_Model->charge_last_devolutions($rowproduct->idProduct, $this->input->post('distributor'), $this->input->post('date')));
      }
      // add NO regular products
      $lines = explode("***", $this->input->post('noregular'));
      foreach ($lines as $line) {
        $productsnoregular = $this->Product_Model->get_products_by_line($line);
        foreach ($productsnoregular as $rowproduct){
          $data_pro['idLiquidacion'] = $idLiquidacion;
          $data_pro['idProduct'] = $rowproduct->idProduct;
          if (!($this->input->post('lastliquid') == "true")){
            $data_pro['carga0'] = $this->Liquidation_Model->charge_last_devolutions($rowproduct->idProduct, $this->input->post('distributor'), $this->input->post('date'));
          }
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

    function pdf_complet($liquidation) {
      $this->load->helper('pdfexport_helper.php');
      $data['title'] = 'PLANILLA DE LIQUIDACIÓN';
      $data['liquidation'] = $this->Liquidation_Model->get($liquidation);
      $data['lines'] = $this->get_lines_view($liquidation);
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('liquidation/pdf_2', $data);
      $templateView = $this->load->view('liquidation/pdf_2', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
    }




    function exception_pdf($liquidation){
      $excepcion = array();
      $res = "";
      $line = $this->Liquidation_Model->get_lines_actives($liquidation, 1);
      foreach ($line as $rowline){
        $products = $this->Liquidation_Model->get_detail_list($liquidation, $rowline->idLine, 1);

        $res .= '<table class="table table-bordered tableLine">';
        $res .= '<tbody>';
        $res .= '<tr>';
        $res .= ' <td colspan="3" class="subTableContainer" >';
        $res .= '<table>';
        $res .= '<thead>';
        $res .= '   <tr>';
        $res .= '     <th>PRODUCTO</th>';
        $res .= '     <th>TOTAL</th>';
        $res .= '   </tr>';
        $res .= '</thead>';
        $res .= '<tbody>';
        $res .= '   <tr>';
        $res .= '     <td class="linea nameline">'.$rowline->Descripcion.'</td>';
        $res .= '     <td class="pieza linea">U</td>';
        $res .= '   </tr>';
        foreach ($products as $rowproduct){
          $res .= ' <tr>';
          $res .= '   <td class="producto">'.$rowproduct->Nombre.'</td>';
          $res .= '   <td class="unidad">'.$rowproduct->devolucion.'</td>';
          $res .= ' </tr>';
        }
        $res .= '</tbody>';
        $res .= '</td>';
        $res .= '</tr>';
        $res .= '</tbody>';
        $res .= '</table>';
      }
      //echo $res;

      $this->load->helper('pdfexport_helper.php');
      //$data['title'] = 'EXCEPCIONES';
      $data['liquidationid'] = $liquidation;
      $data['liquidation'] = $this->Liquidation_Model->get($liquidation);
      $data['temp'] = $res;
      $data['lines'] = $this->Liquidation_Model->get_lines_actives($liquidation, 0);
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('liquidation/pdf_exception', $data);
      $templateView = $this->load->view('liquidation/pdf_exception', $data, TRUE);
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


    function search(){
      $this->form_validation->set_rules('distributor', 'distributor', 'xss_clean');
      $this->form_validation->set_message('xss_clean', 'security: danger value.');

      $data_in['distributor'] = $this->input->post('distributor');
      $data_in['status'] = $this->input->post('status');
      $data_in['dateStart'] = $this->input->post('dateStart');
      $data_in['dateFinish'] = $this->input->post('dateFinish');

      $data['parameters'] = $data_in;
      $data['distributor'] = $this->Liquidation_Model->get_users_and_zones_clear();
      $data['charges'] = $this->Liquidation_Model->search($data_in);
      $data['category'] = 'liquidation';
      $data['page'] = 'history_list';
      $this->load->view('template/template_liquidation', $data);
    }
  }
?>