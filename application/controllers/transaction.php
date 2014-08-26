<?php
  class Transaction extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Transaction_Model');
      $this->load->model('Detailtransaction_Model');
      $this->load->model('Profile_Model');
      $this->load->model('Client_Model');
      $this->load->model('Product_Model');
      $this->load->model('Blog_Model');
      $this->load->model('User_Model');
      $this->load->model('Commerce_Model');
      $this->load->model('City_Model');
      $this->load->model('Area_Model');
      $this->load->model('District_Model');
      $this->load->model('Channel_Model');
      $this->load->model('Client_Model');
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'transaction'))) {
        show_404();
      }
    }

    function index($order="idTransaction") {
      //$data_view = $this->Transaction_Model->report();
      //$this->redirect_tab("tab1", $data_view);
      $this->Todas();
    }

    // redirect tab
    function redirect_tab($tab, $viewx, $search_parameters=Array()){
      $data['commerce'] = $this->Commerce_Model->get_commerce();
      //$data['city'] = array($dropdown[""] = 'Seleccione Ciudad');
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
      //$data['district'] = $this->District_Model->get_disctricts();
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['area'] = array($dropdown[""] = 'Seleccione Area');
      //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
      $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Area');
      //$data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
      $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
      $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());

      if($tab == 'productsTransaction'){
        $data['sum_products'] = $this->Transaction_Model->get_sum_products($search_parameters);
        $data['data_products'] = $this->Transaction_Model->report_products($search_parameters);
      }

      $data['search'] = $viewx;
      $data['transaction'] = $viewx;
      $data['search_parameters'] = $search_parameters;
      $data['category'] = 'transaction';
      $data['mark'] = $tab;
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function search_tab (){
      $this->form_validation->set_rules('dateStart', 'dateStart', 'xss_clean');
      $this->form_validation->set_rules('dateFinish', 'dateFinish', 'xss_clean');
      $this->form_validation->set_rules('status', 'name', 'xss_clean');
      $this->form_validation->set_rules('searchuser', 'code', 'xss_clean');

      $this->form_validation->set_rules('commercetype', 'name', 'xss_clean');
      $this->form_validation->set_rules('channel', 'name', 'xss_clean');
      $this->form_validation->set_rules('name', 'name', 'xss_clean');
      $this->form_validation->set_rules('code', 'name', 'xss_clean');
      $this->form_validation->set_rules('city', 'name', 'xss_clean');
      $this->form_validation->set_rules('area', 'name', 'xss_clean');
      $this->form_validation->set_rules('subarea', 'name', 'xss_clean');
      $this->form_validation->set_rules('orderSelect', 'name', 'xss_clean');

      //dateStart  dateFinish  status   searchuser  commercetype  channel   name  code  city  area  subarea   orderSelect


      $this->form_validation->set_message('xss_clean', 'security: danger value.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE){
        $data_view = $this->Transaction_Model->report();

        $this->redirect_tab("t_search", $data_view, $search_parameters);
      }else{
        // filter_tab1_city  filter_tab1_area  filter_tab1_client  filter_tab1_user  status  dateStart   dateFinish
        $data_in['dateStart'] = $this->input->post('dateStart');
        $data_in['dateFinish'] = $this->input->post('dateFinish');
        $data_in['status'] = $this->input->post('status');
        $data_in['name'] = $this->input->post('name');
        $data_in['code'] = $this->input->post('code');
        $data_in['city'] = $this->input->post('city');
        $data_in['disctrict'] = $this->input->post('disctrict');
        $data_in['area'] = $this->input->post('area');
        $data_in['subarea'] = $this->input->post('subarea');
        $data_in['commercetype'] = $this->input->post('commercetype');
        $data_in['channel'] = $this->input->post('channel');
        $data_in['user'] = $this->input->post('searchuser');
        $data_in['order'] = $this->input->post('orderSelect');

        //print_r($data_in);
        $data_view = $this->Transaction_Model->search_tab($data_in);
        $search_parameters = http_build_query($data_in);

//        $this->redirect_tab("search", $data_view, $search_parameters);
        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != "0"){
          $data['area'] = $this->Area_Model->get_area_for_city($data_in['city']);
          //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());

          if(isset($data_in['area']) AND $data_in['area'] != "" AND $data_in['area'] != "0"){
            $data['subarea'] = $this->Area_Model->get_subarea_for_area($data_in['area']);
            //$data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
          }else{
            $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
          }
        }else{
          $data['area'] = array($dropdown[""] = 'Seleccione Zona');
          $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
        }

        $data['commerce'] = $this->Commerce_Model->get_commerce();
        //$data['city'] = array($dropdown[""] = 'Seleccione Ciudad');
        //$data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
        //$data['district'] = $this->District_Model->get_disctricts();
        $data['channel'] = $this->Channel_Model->get_channels();
        //$data['area'] = array($dropdown[""] = 'Seleccione Area');
        //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
        //$data['subarea'] = array($dropdown[""] = 'Seleccione Sub Area');
        //$data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
        $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
        $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());


        $data['search'] = $data_view;
        $data['transaction'] = $data_view;
        $data['search_parameters'] = $search_parameters;
        $data['category'] = 'transaction';
        $data['mark'] = "search";
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }      
    }


    function search_tab_report (){
      $this->form_validation->set_rules('dateStart', 'dateStart ', 'xss_clean');
      $this->form_validation->set_rules('dateFinish', 'dateFinish ', 'xss_clean');
      $this->form_validation->set_rules('status', 'status ', 'xss_clean');
      $this->form_validation->set_rules('searchuser', 'searchuser ', 'xss_clean');
      $this->form_validation->set_rules('commercetype', 'commercetype ', 'xss_clean');
      $this->form_validation->set_rules('channel', 'channel ', 'xss_clean');
      $this->form_validation->set_rules('name', 'name ', 'xss_clean');
      $this->form_validation->set_rules('code', 'code ', 'xss_clean');
      $this->form_validation->set_rules('city', 'city ', 'xss_clean');
      $this->form_validation->set_rules('area', 'area ', 'xss_clean');
      $this->form_validation->set_rules('subarea', 'subarea ', 'xss_clean');
      $this->form_validation->set_rules('orderSelect', 'orderSelect', 'xss_clean');

      $this->form_validation->set_message('xss_clean', 'security: danger value.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE){
        $data_view = $this->Transaction_Model->report();

        $this->redirect_tab("t_search", $data_view, $search_parameters);
      }else{
        // filter_tab1_city  filter_tab1_area  filter_tab1_client  filter_tab1_user  status  dateStart   dateFinish
        $data_in['dateStart'] = $this->input->post('dateStart');
        $data_in['dateFinish'] = $this->input->post('dateFinish');
        $data_in['status'] = $this->input->post('status');
        $data_in['name'] = $this->input->post('name');
        $data_in['code'] = $this->input->post('code');
        $data_in['city'] = $this->input->post('city');
        //$data_in['disctrict'] = $this->input->post('disctrict');
        $data_in['area'] = $this->input->post('area');
        $data_in['subarea'] = $this->input->post('subarea');
        $data_in['commercetype'] = $this->input->post('commercetype');
        $data_in['channel'] = $this->input->post('channel');
        $data_in['user'] = $this->input->post('searchuser');
        $data_in['order'] = $this->input->post('orderSelect');

        //echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
        //print_r($data_in);
        $data_view = $this->Transaction_Model->search_tab_report_1($data_in);
        $search_parameters = http_build_query($data_in);

//        $this->redirect_tab("productsTransaction", $data_view, $data_in);

        // LOAD productsTransaction
        
        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != "0"){
          $data['area'] = $this->Area_Model->get_area_for_city($data_in['city']);
          //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());

          if(isset($data_in['area']) AND $data_in['area'] != "" AND $data_in['area'] != "0"){
            $data['subarea'] = $this->Area_Model->get_subarea_for_area($data_in['area']);
            //$data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
          }else{
            $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
          }
        }else{
          $data['area'] = array($dropdown[""] = 'Seleccione Zona');
          $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
        }

        $data['commerce'] = $this->Commerce_Model->get_commerce();        
        $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
        //$data['district'] = $this->District_Model->get_disctricts();
        $data['channel'] = $this->Channel_Model->get_channels();
        $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
        $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());

        $data['sum_products'] = $this->Transaction_Model->get_sum_products($data_in);
        $data['data_products'] = $this->Transaction_Model->report_products($data_in);

        $data['search'] = $data_view;
        $data['transaction'] = $data_view;
        $data['search_parameters'] = $search_parameters;
        $data['category'] = 'transaction';
        $data['mark'] = 'productsTransaction';
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }      
    }

    function search_tab_simple (){
     // filter_tab1_city  filter_tab1_area  filter_tab1_client  filter_tab1_user  status  dateStart   dateFinish
      $this->form_validation->set_rules('dateStart', 'dateStart ', 'xss_clean');
      $this->form_validation->set_rules('dateFinish', 'dateFinish ', 'xss_clean');
      $this->form_validation->set_rules('status', 'status ', 'xss_clean');
      $this->form_validation->set_rules('filter_tab1_user', 'filter_tab1_user ', 'xss_clean');
      $this->form_validation->set_rules('filter_tab1_commerce', 'filter_tab1_commerce ', 'xss_clean');
      $this->form_validation->set_rules('filter_tab1_channel', 'filter_tab1_channel ', 'xss_clean');
      $this->form_validation->set_rules('namecommerce', 'namecommerce ', 'xss_clean');
      $this->form_validation->set_rules('code', 'code ', 'xss_clean');
      $this->form_validation->set_rules('city', 'city ', 'xss_clean');
      $this->form_validation->set_rules('area', 'area ', 'xss_clean');
      $this->form_validation->set_rules('subarea', 'subarea ', 'xss_clean');
      $this->form_validation->set_rules('orderSelect', 'orderSelect', 'xss_clean');

      $this->form_validation->set_message('xss_clean', 'security: danger value.');
      $this->form_validation->set_message('numeric', '%s es numeric.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE){
        //$data_view = $this->Transaction_Model->report();

        $this->redirect_tab("tab1", $data_view);
      }else{
        $data_in['dateStart'] = $this->input->post('dateStart');
        $data_in['dateFinish'] = $this->input->post('dateFinish');
        $data_in['status'] = $this->input->post('status');
        $data_in['user'] = $this->input->post('filter_tab1_user');
        $data_in['commerce'] = $this->input->post('filter_tab1_commerce');
        $data_in['channel'] = $this->input->post('filter_tab1_channel');
        $data_in['name'] = $this->input->post('namecommerce');
        $data_in['code'] = $this->input->post('code');
        $data_in['city'] = $this->input->post('city');
        $data_in['area'] = $this->input->post('area');
        $data_in['subarea'] = $this->input->post('subarea');
        $data_in['client'] = $this->input->post('filter_tab1_client');
        $data_in['order'] = $this->input->post('orderSelect');

        //echo "<br><br><br><br>//////////**********************//////////////<br><br><br><br>";
        //print_r($data_in);
        $data_view = $this->Transaction_Model->search_tab($data_in);

        //print_r($data_view);
        $this->redirect_tab($this->input->post('tab'), $data_view);
      }
    }

    function create() {
      $data['category'] = 'transaction';
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
      $data['client'] = $this->Client_Model->get_clients();
      $data['action'] = 'new';
      $data['page'] = 'form';
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($id != "") {
        $transaction = $this->Transaction_Model->get($id);
        if (empty($transaction)) {
          show_404();
        }
        $data['idtransaction'] = $id;

        $data['transaction'] = $transaction;

        $data['category'] = 'transaction';
        $data['action'] = 'edit';
        $data['page'] = 'form';
        //$data['client'] = $this->Client_Model->get_clients();
        $this->load->view('template/template', $data);
        //print_r($data);
      }
      else
        redirect('transaction');
    }

    function code_check() {
      if ($this->Client_Model->customer_exists($this->_code) === TRUE) {
        if ($this->Client_Model->client_valide_bycode($this->_code) === TRUE) {
          return TRUE;
        } else {
          $this->form_validation->set_message('code_check', 'Usuario no puede crear transacciones para este cliente!');
          return FALSE;
        }
      } else {
        $this->form_validation->set_message('code_check', 'NO existe un cliente con este codigo!');
        return FALSE;
      }
    }

    function save() {
      $this->form_validation->set_rules('code', 'Codigo', 'xss_clean|required|callback_code_check');
      $this->form_validation->set_rules('status', 'Tipo de Transaccion', 'xss_clean|required');
      $this->form_validation->set_message('required', 'El %s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>'); 
      $this->_code = $this->input->post('code');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $data['action'] = 'new';
        }else {
          $data['action'] = 'edit';
        }
        $data['client'] = $this->Client_Model->get_clients();
        $data['category'] = 'transaction';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);
      } else {
        $data_in['idCustomer'] = $this->Client_Model->get_id_by_code($this->input->post('code'));
        $data_in['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        //$data_in['Observacion'] = $this->input->post('obs');
        if ($this->input->post('obs') == ""){
          $data_in['Observacion'] = "Web";
        }else{
          $data_in['Observacion'] = $this->input->post('obs');
        }
        
        //idUser  idCustomer  Observacion   Estado  Conciliado 

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          $data_in['Estado'] = $this->input->post('status');
          $data_in['Conciliado'] = "1";
          $insertcode = $this->Transaction_Model->create($data_in);  // get new transaction code

          if ( $insertcode === FALSE) {
            $data['category'] = 'transaction';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $data['client'] = $this->Client_Model->get_clients();
            $this->load->view('template/template', $data);
          } else {
            $data_blog['idTransaction'] = $insertcode;
            $data_blog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
            if ( $data_in['Estado'] == "1")
              $data_blog['Operation'] = 'Preventa';
            if ( $data_in['Estado'] == "6")
              $data_blog['Operation'] = 'Venta Directa';
            if ( $data_in['Estado'] == "7")
              $data_blog['Operation'] = 'Transaccion 0';
            $data_blog['FechaHoraInicio'] = date("y-m-d, g:i");
            $data_blog['FechaHoraFin'] = date("y-m-d, g:i");
            $data_blog['CoordenadaInicio'] = '0.0;0.0';
            $data_blog['CoordenadaFin'] = '0.0;0.0';

            if ($this->Blog_Model->create($data_blog) === TRUE) {
              if ($this->input->post('status') != '7'){
                $datainsert['statuscreate'] = "create";
                redirect('transaction/products/'.$insertcode, $datainsert);
              }
              else
                redirect('transaction');
            } else {
              $data['category'] = 'transaction';
              $data['action'] = 'new';
              $data['page'] = 'form';
              $data['client'] = $this->Client_Model->get_clients();
              $this->load->view('template/template', $data);
            }
          }
        }else{
          if ($this->Transaction_Model->update($data_in, $idtransaction) === TRUE) {
            redirect('transaction');
          } else {
            $data['category'] = 'transaction';
            $data['action'] = 'edit';
            $data['page'] = 'form';
            $data['client'] = $this->Client_Model->get_clients();
            $this->load->view('template/template', $data);
          }
        }
      }
    }

    public function products($id = "") {
      if ($this->Account_Model->logged_in() === TRUE) {
        if ($id != "") {
          $products = $this->Product_Model->get_all();
          $transaction = $this->Transaction_Model->get($id);

          if (empty($transaction)) {
            show_404();
          }

            $data['transaction'] = $this->Transaction_Model->get_info($id);
            $data['blog'] = $this->Blog_Model->get_by_transaction($id);
            $data['idtransaction'] = $id;
            $data['category'] = 'transaction';
            $data['page'] = 'products';
            $this->load->view('template/template', $data);
        }
        else
          redirect('transaction');
      } else {
        redirect('account/login');
      }
    }

    public function product_save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('product', 'Producto', 'xss_clean|required|greater_than[0]');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'xss_clean|required');
        //$this->form_validation->set_rules('obs', 'O', 'xss_clean|required');

        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('greater_than', '%s es obligatorio.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          $data['transaction'] = $transaction;
          $data['products'] = $products;
          $data['transdetail'] = $transdetail;
          $data['idtransaction'] = $this->input->post();
          $data['category'] = 'transaction';
          $data['page'] = 'products';
          $data['action'] = 'new';
          $data['page'] = 'form';
          $this->load->view('template/template', $data);

        } else {
          /*$data_in['idCustomer'] = $this->input->post('product');
          $data_in['idCustomer'] = $this->input->post('cantidad');
          $data_in['Observacion'] = $this->input->post('obs');


          if ($this->Detailtransaction_Model->create($data_in) === TRUE) {
            redirect('transaction');
          } else {
            $data['transaction'] = $transaction;
            $data['products'] = $products;
            $data['category'] = 'transaction';
            $data['page'] = 'products';
            $this->load->view('template/template', $data);
          }*/
        }
      } else {
        redirect('account/login');
      }
    }

    // activate permission
    public function activate() {
      $transaction = $this->input->post('transaction');
      $module = $this->input->post('module');
      $this->Transaction_Model->activate($transaction, $module);
    }

    // deactivate permission
    public function deactivate() {
      $transaction = $this->input->post('transaction');
      $module = $this->input->post('module');
      $this->Transaction_Model->deactivate($transaction, $module);
    }

    // cancel transaction
    public function cancel($id) {
      $data['Estado'] = '4';
      if ($this->Transaction_Model->update($data, $id) === TRUE) {

        // cancel all products
        $this->Detailtransaction_Model->changestatus($id, "4");

        // Save log for this action
        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '21';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);

        redirect('transaction');
      } else {

      }
    }

    public function asignTo() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('customerCode', 'Codigo de Cliente', 'xss_clean|required|integer|callback_customercheck');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('integer', '%s debes introducir un numero entero.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

         $this->_customercode = $this->input->post('customerCode');
         $this->_idtransaction = $this->input->post('id_transaction');
         
        if($this->input->post('transactionType') == "venta_directa")
          $this->_status = "6";
        else
          $this->_status = "2";

        if ($this->form_validation->run() == FALSE) {
          $data_view = $this->Transaction_Model->report("idTransaction");
          $this->redirect_tab("tab7", $data_view);

        } else {
          $data['idCustomer'] = $this->Client_Model->get_id_by_code($this->_customercode);
          $data['Estado'] = $this->_status;
          $this->Transaction_Model->update($data, $this->_idtransaction);

          $data_view = $this->Transaction_Model->report("idTransaction");
          $this->redirect_tab("tab7", $data_view);
        }
      } else {
        redirect('account/login');
      }
    }

    public function customercheck(){
      if ($this->Client_Model->customer_exists($this->_customercode) === TRUE) {
        return TRUE;
      } else {
        return FALSE;
      }
    }

    function pdf() {
      $this->load->helper('pdfexport_helper.php');
      $parameters_string = $this->input->post('parameters');
      $parameters = "";
      parse_str(html_entity_decode($parameters_string), $parameters);
      $transactions = $this->Transaction_Model->search_tab($parameters);

      $user_email = $this->Account_Model->get_email();
      $user = $this->Account_Model->get_user_by_email($user_email);

      if (isset($parameters['status']) && ($parameters['status']!="") && ($parameters['status']!="0")) {
        $options = array(
          '1'  => 'Prevendido',
          '2'  => 'Conciliado',
          '3'  => 'Distribuido',
          '4'  => 'Cancelado',
          '5'  => 'Temporal',
          '6'  => 'Venta Directa',
          '7'  => 'Transaccion 0',
        );
        $parameters['status'] = $options[$parameters['status']];
      }

      if (isset($parameters['city']) && ($parameters['city']!="") && ($parameters['city']!="0")) {
        $city = $this->City_Model->get($parameters['city']);
        $parameters['city'] = $city[0]->NombreCiudad;
      }

      if (isset($parameters['disctrict']) && ($parameters['disctrict']!="") && ($parameters['disctrict']!="0")) {
        $disctrict = $this->District_Model->get($parameters['disctrict']);
        $parameters['disctrict'] = $disctrict[0]->Descripcion;
      }

      if (isset($parameters['area']) && ($parameters['area']!="") && ($parameters['area']!="0")) {
        $area = $this->Area_Model->get($parameters['area']);
        $parameters['area'] = $area[0]->Descripcion;
      }

      if (isset($parameters['subarea']) && ($parameters['subarea']!="") && ($parameters['subarea']!="0")) {
        $subarea = $this->Area_Model->get($parameters['subarea']);
        $parameters['subarea'] = $subarea[0]->Descripcion;
      }

      if (isset($parameters['commercetype']) && ($parameters['commercetype']!="") && ($parameters['commercetype']!="0")) {
        $commercetype = $this->Commerce_Model->get($parameters['commercetype']);
        $parameters['commercetype'] = $commercetype[0]->Descripcion;
      }

      if (isset($parameters['channel']) && ($parameters['channel']!="") && ($parameters['channel']!="0")) {
        $channel = $this->Channel_Model->get($parameters['channel']);
        $parameters['channel'] = $channel[0]->Descripcion;
      }

      $data['user_name'] = $user->Nombre . ' ' . $user->Apellido;
      $data['parameters'] = $parameters;
      $data['title'] = 'TRANSACCIONES';
      $data['transactions'] = $transactions;
      $data['category'] = 'transaction';
      $data['page'] = 'pdf';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/systems/horizon/';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('template/template_pdf', $data);
      $templateView = $this->load->view('template/template_pdf', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
      
      //print_r($parameters);
    }

    function pdfProducts() {
      $this->load->helper('pdfexport_helper.php');
      $parameters_string = $this->input->post('parameters');
      $parameters = "";
      $parameters = $parameters_string;
      parse_str(html_entity_decode($parameters_string), $parameters);
      $transactions = $this->Transaction_Model->search_tab($parameters);
      $more_parameters = $parameters;
      //print_r($parameters_string);
      $user_email = $this->Account_Model->get_email();
      $user = $this->Account_Model->get_user_by_email($user_email);
      
      if (isset($parameters['status']) && ($parameters['status']!="") && ($parameters['status']!="0")) {
        $options = array(
          '1'  => 'Prevendido',
          '2'  => 'Conciliado',
          '3'  => 'Distribuido',
          '4'  => 'Cancelado',
          '5'  => 'Temporal',
          '6'  => 'Venta Directa',
          '7'  => 'Transaccion 0',
        );
        $parameters['status'] = $options[$parameters['status']];
      }

      if (isset($parameters['city']) && ($parameters['city']!="") && ($parameters['city']!="0")) {
        $city = $this->City_Model->get($parameters['city']);
        $parameters['city'] = $city[0]->NombreCiudad;
      }

      if (isset($parameters['disctrict']) && ($parameters['disctrict']!="") && ($parameters['disctrict']!="0")) {
        $disctrict = $this->District_Model->get($parameters['disctrict']);
        $parameters['disctrict'] = $disctrict[0]->Descripcion;
      }

      if (isset($parameters['area']) && ($parameters['area']!="") && ($parameters['area']!="0")) {
        $area = $this->Area_Model->get($parameters['area']);
        $parameters['area'] = $area[0]->Descripcion;
      }

      if (isset($parameters['subarea']) && ($parameters['subarea']!="") && ($parameters['subarea']!="0")) {
        $subarea = $this->Area_Model->get($parameters['subarea']);
        $parameters['subarea'] = $subarea[0]->Descripcion;
      }

      if (isset($parameters['commercetype']) && ($parameters['commercetype']!="") && ($parameters['commercetype']!="0")) {
        $commercetype = $this->Commerce_Model->get($parameters['commercetype']);
        $parameters['commercetype'] = $commercetype[0]->Descripcion;
      }

      if (isset($parameters['channel']) && ($parameters['channel']!="") && ($parameters['channel']!="0")) {
        $channel = $this->Channel_Model->get($parameters['channel']);
        $parameters['channel'] = $channel[0]->Descripcion;
      }

      if (isset($parameters['user']) && ($parameters['user']!="") && ($parameters['user']!="0")) {
        $userx = $this->User_Model->get($parameters['user']);
        $parameters['user'] = $userx[0]->Nombre." ".$userx[0]->Apellido;
      }
      $data['user_name'] = $user->Nombre . ' ' . $user->Apellido;
      $data['parameters'] = $parameters;
      $data['data_products'] = $this->Transaction_Model->report_products($more_parameters);
      $data['sum_products'] = $this->Transaction_Model->get_sum_products($more_parameters);
      $data['title'] = 'TRANSACCIONES';
      $data['transactions'] = $transactions;
      $data['category'] = 'transaction';
      $data['page'] = 'pdfProducts';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/systems/horizon/';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('template/template_pdf', $data);
      //print_r($parameters);
      $templateView = $this->load->view('template/template_pdf', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
    }

    function pdfResumeTransaction() {
      $this->load->helper('pdfexport_helper.php');
      $parameters_string = $this->input->post('parameters');
      $parameters = "";
      parse_str(html_entity_decode($parameters_string), $parameters);

      //print_r($parameters);

      $transactions = $this->Transaction_Model->search_tab($parameters);
      $data['data_products'] = $this->Transaction_Model->report_products($parameters);
      $data['sum_products'] = $this->Transaction_Model->get_sum_products($parameters);
      $data['data_lines'] = $this->Transaction_Model->report_lines($parameters);

      $user_email = $this->Account_Model->get_email();
      $user = $this->Account_Model->get_user_by_email($user_email);

      if (isset($parameters['status']) && ($parameters['status']!="")) {
        $options = array(
          '1'  => 'Prevendido',
          '2'  => 'Conciliado',
          '3'  => 'Distribuido',
          '4'  => 'Cancelado',
          '5'  => 'Temporal',
          '6'  => 'Venta Directa',
          '7'  => 'Transaccion 0',
        );
        $parameters['status'] = $options[$parameters['status']];
      }

      if (isset($parameters['city']) && ($parameters['city']!="") && ($parameters['city']!="0")) {
        $city = $this->City_Model->get($parameters['city']);
        $parameters['city'] = $city[0]->NombreCiudad;
      }

      if (isset($parameters['disctrict']) && ($parameters['disctrict']!="") && ($parameters['disctrict']!="0")) {
        $disctrict = $this->District_Model->get($parameters['disctrict']);
        $parameters['disctrict'] = $disctrict[0]->Descripcion;
      }

      if (isset($parameters['area']) && ($parameters['area']!="") && ($parameters['area']!="0")) {
        $area = $this->Area_Model->get($parameters['area']);
        $parameters['area'] = $area[0]->Descripcion;
      }

      if (isset($parameters['subarea']) && ($parameters['subarea']!="") && ($parameters['subarea']!="0")) {
        $subarea = $this->Area_Model->get($parameters['subarea']);
        $parameters['subarea'] = $subarea[0]->Descripcion;
      }

      if (isset($parameters['commercetype']) && ($parameters['commercetype']!="") && ($parameters['commercetype']!="0")) {
        $commercetype = $this->Commerce_Model->get($parameters['commercetype']);
        $parameters['commercetype'] = $commercetype[0]->Descripcion;
      }

      if (isset($parameters['channel']) && ($parameters['channel']!="") && ($parameters['channel']!="0")) {
        $channel = $this->Channel_Model->get($parameters['channel']);
        $parameters['channel'] = $channel[0]->Descripcion;
      }

     
      //$data['data_trans'] = $this->Transaction_Model->report_clients();
      //$data['clients_by_area'] = $this->Client_Model->count_customers_by_area("8");
      //$data['clients_by_sub_area'] = $this->Client_Model->count_customers_by_sub_area("13");

      $data['user_name'] = $user->Nombre . ' ' . $user->Apellido;
      $data['parameters'] = $parameters;
      $data['title'] = 'TRANSACCIONES';
      $data['transactions'] = $transactions;
      $data['category'] = 'transaction';
      $data['page'] = 'pdfResumeTransaction';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/systems/horizon/';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('template/template_pdf', $data);
      $templateView = $this->load->view('template/template_pdf', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
    }

    function Todas(){
      $data_view = $this->Transaction_Model->report();
      $this->redirect_tab("tab1", $data_view);
    }

    function Pendientes(){
      $data_view = $this->Transaction_Model->report_2();
      $this->redirect_tab("tab2", $data_view);
    }

    function Distribuidas(){
      $data_view = $this->Transaction_Model->report();
      $this->redirect_tab("tab3", $data_view);
    }
    function Canceladas(){
      $data_in['status'] = "4";
      $data_view = $this->Transaction_Model->report_4($data_in);
      //echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br>**************";
      //print_r($data_view);
      //echo "**************";
      $this->redirect_tab("tab5", $data_view);
    }
    function Transaccion_Temporal(){
      $data_view = $this->Transaction_Model->report_3();
      $this->redirect_tab("tab7", $data_view);
    }

    function Venta_Directa(){
      $data_view = $this->Transaction_Model->report();
      $this->redirect_tab("tab6", $data_view);
    }

    function Transaccion_0(){
      $data_view = $this->Transaction_Model->report();
      $this->redirect_tab("tab8", $data_view);
    }

    function search(){
      $data_view = $this->Transaction_Model->report();
      $this->redirect_tab("search", $data_view);
    }

    function reporte1(){
      /*$search_parameters = array();

      // solo mostrar  5 dias atras
      $days = -5;
      $fecha = date ('Y-m-j');
      $nuevafecha = strtotime ( $days.' day' , strtotime ( $fecha ) ) ;
      $search_parameters["dateStart"] = date ( 'Y-m-j' , $nuevafecha );

      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['area'] = array($dropdown[""] = 'Seleccione Zona');
      $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
      $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
      $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());
      $data['sum_products'] = $this->Transaction_Model->get_sum_products($search_parameters);
      $data['data_products'] = $this->Transaction_Model->report_products($search_parameters);

      $data_view = $this->Transaction_Model->report();
      //$this->redirect_tab("productsTransaction", $data_view);  
      $data['search'] = $data_view;
      $data['transaction'] = $data_view;
      $data['search_parameters'] = $search_parameters;
      $data['category'] = 'transaction';
      $data['mark'] = "productsTransaction";
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
      */
      //$data_view = $this->Transaction_Model->report();
      //$this->redirect_tab("productsTransaction", $data_view);  



      $data['commerce'] = $this->Commerce_Model->get_commerce();
      //$data['city'] = array($dropdown[""] = 'Seleccione Ciudad');
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      //$data['district'] = array($dropdown[""] = 'Seleccione Barrio');
      $data['district'] = $this->District_Model->get_disctricts();
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['area'] = array($dropdown[""] = 'Seleccione Area');
        //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
      $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Area');
      //$data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
      $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
      $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());
      //$data['sum_products'] = $this->Transaction_Model->get_sum_products(array());
      $data['data_products'] = array();
 /*   

      
*/
      $data['search'] = array();
      $data['transaction'] = array();
      $data['search_parameters'] = array();
      $data['category'] = 'transaction';
      $data['mark'] = 'productsTransaction';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    // redirect tab
    function redirect_tab_report_2($datasearch, $searching, $search_parameters){
      $data['data_trans'] = $this->Transaction_Model->report_clients();
      $data['data_products'] = $this->Transaction_Model->report_products($searching);
      //$data['data_products'] = Array();
      $data['data_lines'] = $this->Transaction_Model->report_lines($searching);
      //$data['data_lines'] = Array();
      $data['sum_products'] = $this->Transaction_Model->get_sum_products($searching);
      //$data['sum_products'] = Array();

      $data['clients_by_area'] = $this->Client_Model->count_customers_by_area("all");
      //$data['clients_by_sub_area'] = $this->Client_Model->count_customers_by_sub_area("all");     



      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());

      if(isset($searching['city']) AND $searching['city'] != "" AND $searching['city'] > 0){
        $data['area'] = $this->Area_Model->get_area_for_city($searching['city']);

        if(isset($searching['area']) AND $searching['area'] != "" AND $searching['area'] > 0){
          $data['subarea'] = $this->Area_Model->get_subarea_for_area($searching['area']);
        }else{
          $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
        }
      }else{
        $data['area'] = array($dropdown[""] = 'Seleccione Zona');
        $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
      }

      $data['commerce'] = $this->Commerce_Model->get_commerce();
      //$data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['district'] = $this->District_Model->get_disctricts();
      $data['channel'] = $this->Channel_Model->get_channels();
      //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
      //$data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
      $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
      $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());

      $data_view = $this->Transaction_Model->report();
      //$data['searching'] = $datasearch;
      //$data['search'] = $data_view;
      $data['values_counter'] = $this->clients_visited($datasearch);
      $data['transaction'] = $data_view;
      $data['search_parameters'] = $search_parameters;
      $data['category'] = 'transaction';
      $data['mark'] = "productsTransaction2";
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }


    function search_tab_report_2 (){
      $this->form_validation->set_rules('dateStart', 'dateStart', 'xss_clean');
      $this->form_validation->set_rules('dateFinish', 'dateFinish', 'xss_clean');
      $this->form_validation->set_rules('status', 'status', 'xss_clean');
      $this->form_validation->set_rules('searchuser', 'searchuser', 'xss_clean');
      $this->form_validation->set_rules('commercetype', 'commercetype', 'xss_clean');
      $this->form_validation->set_rules('channel', 'channel', 'xss_clean');
      $this->form_validation->set_rules('name', 'name', 'xss_clean');
      $this->form_validation->set_rules('code', 'code', 'xss_clean');
      $this->form_validation->set_rules('city', 'city', 'xss_clean');
      $this->form_validation->set_rules('area', 'area', 'xss_clean');
      $this->form_validation->set_rules('subarea', 'subarea', 'xss_clean');
      $this->form_validation->set_rules('orderSelect', 'orderSelect', 'xss_clean');

//dateStart   dateFinish  status  searchuser  commercetype  channel   name  code city area subarea orderSelect

      $this->form_validation->set_message('xss_clean', 'security: danger value.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE){
        $data_view = $this->Transaction_Model->report();
        $this->redirect_tab("reporte2", $data_view, $search_parameters);
      }else{
        $data_in['dateStart'] = $this->input->post('dateStart');
        $data_in['dateFinish'] = $this->input->post('dateFinish');
        $data_in['status'] = $this->input->post('status');
        $data_in['name'] = $this->input->post('name');
        $data_in['code'] = $this->input->post('code');
        $data_in['city'] = $this->input->post('city');
        $data_in['disctrict'] = $this->input->post('disctrict');
        $data_in['area'] = $this->input->post('area');
        $data_in['subarea'] = $this->input->post('subarea');
        $data_in['commercetype'] = $this->input->post('commercetype');
        $data_in['channel'] = $this->input->post('channel');
        $data_in['user'] = $this->input->post('searchuser');
        $data_in['order'] = $this->input->post('orderSelect');

        //$data_view = $this->Transaction_Model->search_tab($data_in);
        $data_view = $this->Transaction_Model->search_tab_report_1($data_in);
        $search_parameters = http_build_query($data_in);
        $search_params = $data_in;



        $this->redirect_tab_report_2($data_view, $data_in, $search_parameters);

/*

        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());

        if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] > 0){
          $data['area'] = $this->Area_Model->get_area_for_city($data_in['city']);

          if(isset($data_in['area']) AND $data_in['area'] != "" AND $data_in['area'] > 0){
            $data['subarea'] = $this->Area_Model->get_subarea_for_area($data_in['area']);
          }else{
            $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
          }
        }else{
          $data['area'] = array($dropdown[""] = 'Seleccione Zona');
          $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
        }

          
        $data['data_trans'] = $this->Transaction_Model->report_clients();
        $data['data_products'] = $this->Transaction_Model->report_products($data_in);
        //$data['data_products'] = Array();
        $data['data_lines'] = $this->Transaction_Model->report_lines($data_in);
        //$data['data_lines'] = Array();
        $data['sum_products'] = $this->Transaction_Model->get_sum_products($data_in);
        //$data['sum_products'] = Array();

        $data['clients_by_area'] = $this->Client_Model->count_customers_by_area("all");
        //$data['clients_by_sub_area'] = $this->Client_Model->count_customers_by_sub_area("all");     

        $data['commerce'] = $this->Commerce_Model->get_commerce();
        //$data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        $data['district'] = $this->District_Model->get_disctricts();
        $data['channel'] = $this->Channel_Model->get_channels();
        //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
        //$data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
        $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
        $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());

        $data_view = $this->Transaction_Model->report();
        //$data['searching'] = $datasearch;
        //$data['search'] = $data_view;
        $data['values_counter'] = $this->clients_visited($data_view);
        $data['transaction'] = $data_view;
        $data['search_parameters'] = $search_parameters;
        $data['category'] = 'transaction';
        $data['mark'] = "productsTransaction2";
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
*/

        //function redirect_tab_report_2($datasearch, $searching, $search_parameters){

      /*  $data['data_trans'] = $this->Transaction_Model->report_clients();
        $data['data_products'] = $this->Transaction_Model->report_products();
        $data['data_lines'] = $this->Transaction_Model->report_lines();
        $data['clients_by_area'] = $this->Client_Model->count_customers_by_area($data_in['area']);
        //$data['clients_by_sub_area'] = $this->Client_Model->count_customers_by_sub_area("13");     

        $data['commerce'] = $this->Commerce_Model->get_commerce();
        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        $data['district'] = $this->District_Model->get_disctricts();
        $data['channel'] = $this->Channel_Model->get_channels();
        $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
        $data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
        $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
        $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());

        $data_view = $this->Transaction_Model->report();
        $data['search'] = $data_view;
        $data['transaction'] = $data_view;
        $data['search_parameters'] = Array();
        $data['category'] = 'transaction';
        $data['mark'] = "productsTransaction2";
        $data['page'] = 'index';
        $this->load->view('template/template', $data);*/
      }
    }

    function reporte2(){
      $searching = array();
      $searching['city'] = $this->Account_Model->get_city();
/*
      // solo mostrar  5 dias atras
      $days = -5;
      $fecha = date ('Y-m-j');
      $nuevafecha = strtotime ( $days.' day' , strtotime ( $fecha ) ) ;
      $searching['dateStart'] = date ( 'Y-m-j' , $nuevafecha );
*/
      //$this->redirect_tab_report_2(Array(), Array());



      //$dateata['data_trans'] = $this->Transaction_Model->report_clients();
      //$data['data_products'] = $this->Transaction_Model->report_products($searching);

      $data['data_products'] = "";
      //$data['data_lines'] = $this->Transaction_Model->report_lines($searching);
      $data['data_lines'] = "";
      //$data['sum_products'] = $this->Transaction_Model->get_sum_products($searching);
      $data['sum_products'] = "";

      $data['clients_by_area'] = $this->Client_Model->count_customers_by_area("all");
      //$data['clients_by_sub_area'] = $this->Client_Model->count_customers_by_sub_area("all");     

      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
	    //$data['city'] = array($dropdown[""] = 'Seleccione Ciudad');
      $data['district'] = $this->District_Model->get_disctricts();
      $data['channel'] = $this->Channel_Model->get_channels();
      //$data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
	$data['area'] = array($dropdown[""] = 'Seleccione Zona');
//      $data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
	$data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
      $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
      $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());

      $data_view = $this->Transaction_Model->report();
      //$data['searching'] = $datasearch;
      //$data['search'] = $data_view;
      $data['values_counter'] = $this->clients_visited(array());
      $data['transaction'] = $data_view;
      $data['search_parameters'] = Array();
      $data['category'] = 'transaction';
      $data['mark'] = "productsTransaction2";
      $data['page'] = 'index';
      $this->load->view('template/template', $data);

    }

    // clientes visitados
    function clients_visited($datasearch){
      $counters = array();
      $count = 0;
      $prevendido = 0;
      $conciliado = 0;
      $cancelado = 0;
      $temporal = 0;
      $ventadirecta = 0;
      $transaccion0 = 0;
      
      foreach ($datasearch as $search) {
        if($search->Operation == 'creacion')
          $prevendido ++;
        if($search->Operation == 'conciliado')
          $conciliado ++;
        if($search->Operation == 'temporal')
          $temporal ++;
        if($search->Operation == 'venta_directa')
          $ventadirecta ++;
        if($search->Operation == 'transaccion_0')
          $transaccion0 ++;
        $count++;
      }
      $counters['prevendido'] = $prevendido;
      $counters['conciliado'] = $conciliado;
      $counters['cancelado'] = $cancelado;
      $counters['temporal'] = $temporal;
      $counters['ventadirecta'] = $ventadirecta;
      $counters['transaccion0'] = $transaccion0;
      $counters['count'] = $count;
      return $counters;
    } 

    function finish($idtransaction) {
      $data['Conciliado'] = "0";
      $this->Transaction_Model->update($data, $idtransaction);
      redirect("transaction");
    }

    function search_csv(){
      $this->load->helper('download');
      $parameters_string = $this->input->post('parameters');
      parse_str(html_entity_decode($parameters_string), $parameters);
      $transactions = $this->Transaction_Model->report_1_Products_csv($parameters);

      $name = 'reporte1_transacciones.csv';

      force_download($name, $transactions); 
    }

    function report1_csv(){
      $this->load->helper('download');
      $parameters_string = $this->input->post('parameters');
      parse_str(html_entity_decode($parameters_string), $parameters);
      $transactions = $this->Transaction_Model->search_tab_csv($parameters);

      $name = 'transacciones_reporte1.csv';

      force_download($name, $transactions); 
    }

    function report2_csv(){
      $this->load->helper('download');
      $parameters_string = $this->input->post('parameters');
      parse_str(html_entity_decode($parameters_string), $parameters);
      $products = $this->Transaction_Model->report_products_csv($parameters);
      //$lines = $this->Transaction_Model->report_lines_csv($parameters);

      $name = 'reporte1_productos.csv';

      force_download($name, $products); 
    }

    function report_lines_csv(){
      $this->load->helper('download');
      $parameters_string = $this->input->post('parameters');
      parse_str(html_entity_decode($parameters_string), $parameters);
      $lines = $this->Transaction_Model->report_lines_csv($parameters);

      $name = 'reporte2_lineas.csv';

      force_download($name, $lines); 
    }

    function report_2_products(){
      $this->load->helper('download');
      $parameters_string = $this->input->post('parameters');
      parse_str(html_entity_decode($parameters_string), $parameters);
      $products = $this->Transaction_Model->report_products_csv($parameters);
      //$lines = $this->Transaction_Model->report_lines_csv($parameters);

      $name = 'reporte2_productos.csv';

      force_download($name, $products); 
    }
  }
?>
