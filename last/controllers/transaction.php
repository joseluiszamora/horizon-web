<?php
  class Transaction extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Account_Model');
      $this->load->model('Transaction_Model');
      $this->load->model('Detailtransaction_Model');
      $this->load->model('Profile_Model');
      $this->load->model('Permission_Model');
      $this->load->model('Client_Model');
      $this->load->model('Product_Model');
      $this->load->model('Blog_Model');
      $this->load->model('User_Model');
      $this->load->model('Commerce_Model');
      $this->load->model('City_Model');
      $this->load->model('Area_Model');
      $this->load->model('District_Model');
      $this->load->model('Channel_Model');
    }

    function index($order="idTransaction") {
      //$data_index['order'] = "customer.NombreTienda";
      //$data_view = $this->Client_Model->search($data_index);
      $data_view = $this->Transaction_Model->report();
      $this->redirect_tab("t_1", $data_view);
    }

    // redirect tab
    function redirect_tab($tab, $viewx, $search_parameters=Array()){
      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['district'] = $this->District_Model->get_disctricts();
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
      $data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
      $data['user'] = $this->User_Model->get_users_by_city($this->Account_Model->get_city());
      $data['customer'] = $this->Client_Model->get_clients_by_city($this->Account_Model->get_city());

      $data['search'] = $viewx;
      $data['transaction'] = $viewx;
      $data['search_parameters'] = $search_parameters;
      $data['category'] = 'transaction';
      $data['mark'] = $tab;
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function search_tab (){
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
      $data_in['order'] = "idTransaction";

      //print_r($data_in);
      $data_view = $this->Transaction_Model->search_tab($data_in);
      $search_parameters = http_build_query($data_in);

      $this->redirect_tab("t_search", $data_view, $search_parameters);
    }

    function search_tab_simple (){
     // filter_tab1_city  filter_tab1_area  filter_tab1_client  filter_tab1_user  status  dateStart   dateFinish
      $data_in['dateStart'] = $this->input->post('dateStart');
      $data_in['dateFinish'] = $this->input->post('dateFinish');
      $data_in['status'] = $this->input->post('status');
      $data_in['user'] = $this->input->post('filter_tab1_user');
      $data_in['area'] = $this->input->post('filter_tab1_area');
      $data_in['city'] = $this->input->post('filter_tab1_city');
      $data_in['client'] = $this->input->post('filter_tab1_client');
      $data_in['order'] = "idTransaction";

      //print_r($data_in);
      $data_view = $this->Transaction_Model->search_tab($data_in);

      $this->redirect_tab($this->input->post('tab'), $data_view);
    }

    function create() {
      $data['category'] = 'transaction';
      $data['client'] = $this->Client_Model->get_clients();
      $data['action'] = 'new';
      $data['page'] = 'form';
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($this->Account_Model->logged_in() === TRUE) {
     if ($id != "") {
         // $data['idpermission'] = $id;
          $transaction = $this->Transaction_Model->get($id);
          //$transactionTitle = $this->transaction_Model->get_name($id);

          if (empty($transaction)) {
            show_404();
          }
          $data['transaction'] = $transaction;
          //$data['modules'] = $this->Permission_Model->report_modules();
          //$data['transaction'] = $this->transaction_Model->report();

          $data['category'] = 'transaction';
          $data['action'] = 'edit';
          $data['page'] = 'form';
          $data['client'] = $this->Client_Model->get_clients();
          $this->load->view('template/template', $data);
        }
        else
          redirect('transaction');
      } else {
        redirect('account/login');
      }
    }

    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('custom', 'Cliente', 'xss_clean|required');

        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

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
          $data_in['idCustomer'] = $this->input->post('custom');
          $data_in['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
          $data_in['Observacion'] = $this->input->post('obs');

          // Check if Save or Edit
          if($this->input->post('form_action') == "save") {

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
              $data_blog['Operation'] = 'creacion';
              $data_blog['FechaHoraInicio'] = date("y-m-d, g:i");
              $data_blog['FechaHoraFin'] = date("y-m-d, g:i");
              $data_blog['CoordenadaInicio'] = '0.0';
              $data_blog['CoordenadaFin'] = '0.0';

              if ($this->Blog_Model->create($data_blog) === TRUE) {
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
      } else {
        redirect('account/login');
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
        $this->form_validation->set_rules('product', 'Producto', 'xss_clean|required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'xss_clean|required');
        //$this->form_validation->set_rules('obs', 'O', 'xss_clean|required');

        $this->form_validation->set_message('required', '%s es obligatorio.');
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

        if ($this->form_validation->run() == FALSE) {
          $data['transaction'] = $this->Transaction_Model->report("idTransaction");
          $data['category'] = 'transaction';
          $data['page'] = 'index';
          $this->load->view('template/template', $data);

        } else {
          $data['idCustomer'] = $this->Client_Model->get_id_by_code($this->_customercode);
          $data['Estado'] = "2";
          $this->Transaction_Model->update($data, $this->_idtransaction);

          // redirect
          $data['transaction'] = $this->Transaction_Model->report("idTransaction");
          $data['category'] = 'transaction';
          $data['page'] = 'index';
          $this->load->view('template/template', $data);
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
      parse_str(html_entity_decode($parameters_string), $parameters);
      $transactions = $this->Transaction_Model->search_tab($parameters);

      $user_email = $this->Account_Model->get_email();
      $user = $this->Account_Model->get_user_by_email($user_email);

      if (isset($parameters['status']) && ($parameters['status']!="")) {
        $options = array(
          '1'  => 'Creado',
          '2'  => 'Conciliado',
          '3'  => 'Distribuido',
          '4'  => 'Cancelado',
          '5'  => 'Temporal',
          '6'  => 'Venta Directa',
          '7'  => 'Transaccion 0',
        );
        $parameters['status'] = $options[$parameters['status']];
      }

      if (isset($parameters['city']) && ($parameters['city']!="")) {
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

      if (isset($parameters['commercetype']) && ($parameters['commercetype']!="")) {
        $commercetype = $this->Commerce_Model->get($parameters['commercetype']);
        $parameters['commercetype'] = $commercetype[0]->Descripcion;
      }

      if (isset($parameters['channel']) && ($parameters['channel']!="")) {
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
    }
  }
?>