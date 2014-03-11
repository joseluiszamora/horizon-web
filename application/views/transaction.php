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
