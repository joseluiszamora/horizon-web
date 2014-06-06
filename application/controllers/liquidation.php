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
      $data['charges'] = $this->Liquidation_Model->report("active", "creado");
      $data['category'] = 'liquidation';
      $data['page'] = 'charge_list';
      $this->load->view('template/template_liquidation', $data); 
    }

    function add_products() {
      $data['line'] = $this->Line_Model->get_all_json();
      $data['volume'] = $this->Volume_Model->get_all_json();
      $data['linevolume'] = $this->Linevolume_Model->get_all_json();
      $data['product'] = $this->Product_Model->get_all_json();

      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();

      $data['category'] = 'liquidation';
      $data['page'] = 'add_products';
      $this->load->view('template/template_liquidation', $data);  
    }
    /*function charges_made() {
      $data['line'] = $this->Line_Model->get_all_json();
      $data['volume'] = $this->Volume_Model->get_all_json();
      $data['linevolume'] = $this->Linevolume_Model->get_all_json();
      $data['product'] = $this->Product_Model->get_all_json();

      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();

      $data['category'] = 'liquidation';
      $data['page'] = 'create';
      $this->load->view('template/template_liquidation', $data);  
    }*/

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
              'uxp'        => $rowproduct->uxp,
              'previousDayP'  => 0,
              'previousDayU'  => 0,
              'chargeP'       => 0,
              'chargeU'       => 0,
              'chargeExtraP'  => 0,
              'chargeExtraU'  => 0,
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
      //print_r($data);

      foreach($data['lines'] as $rowLine) {
        print $rowLine['nameLine']."\n";
        //print $rowLine['nameLine'];
        //print "$key => $value\n";
        foreach($rowLine['products'] as $rowProduct) {
          print $rowProduct['Nombre']." -- ".$rowProduct['chargeP']."\n";
          //print_r($value2."<br>");
        }
        /*foreach($rowLine['nameLine'] as $rowProduct) {
          print $rowLine['Nombre']."\n";
        }*/
      }

       /*foreach ($data as $row){
        print_r($row[0]);
      }*/
      /*if ($_SERVER["REQUEST_METHOD"] === "GET"){
        //$code =$this->input->post('lines');
        echo "----";
      }else{
        //$code =$this->input->server('lines');
        echo "******";
      }*/
      //$JSON_decode = json_decode($code);
      
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
        $data_in['status'] = "active";
        $data_in['mark'] = "creado";

        if ($this->Liquidation_Model->create($data_in) == TRUE) {
            redirect("liquidation");
          } else {
            $this->redirect_form('create');
          }
      }
    }

  }
?>