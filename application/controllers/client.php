<?php
  class Client extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Client_Model');
      $this->load->model('Commerce_Model');
      $this->load->model('City_Model');
      $this->load->model('Area_Model');
      $this->load->model('District_Model');
      $this->load->model('Channel_Model');
      $this->load->model('Rank_Model');
    }

    function index() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'customer'))) {
        show_404();
      }
      /*$data_index['order'] = "customer.NombreTienda";
      $data_index['city'] =  $this->Account_Model->get_city();
      $data_index['status'] =  "0";
      $data_view = $this->Client_Model->search($data_index);
      //$data_view = array();
      $search_parameters = http_build_query($data_index);
      $this->redirect_tab("tab1", $data_view, $search_parameters);*/
      $this->activos();
    }

    function sort($sort) {
      $data_index['order'] = $sort;
      $data_view = $this->Client_Model->search($data_index);
      $this->redirect_tab("tab1", $data_view);
    }

    function create() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'customer'))) {
        show_404();
      }
      $this->redirect_form('new');
    }

    public function edit($id = "") {
      if ($id != "") {
        $data['idclient'] = $id;
        $client = $this->Client_Model->get($id);
        if (empty($client)) {
            show_404();
        }
        $data['client'] = $client[0];
        $data['category'] = 'client';
        $data['action'] = 'edit';
        $data['page'] = 'form';
        $data['commerce'] = $this->Commerce_Model->get_commerce();
        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        $data['district'] = $this->District_Model->get_disctricts();
        $data['channel'] = $this->Channel_Model->get_channels();
        $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
        $data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
        $data['rank'] = $this->Rank_Model->get_ranks();

        $this->load->view('template/template', $data);
      }
      else
        redirect('client');
    }

    function search_tab (){
      //dateStart   dateFinish   name   city  disctrict   area  subarea  commercetype  datelasttransaction
      $this->form_validation->set_rules('dateStart', 'dateStart', 'xss_clean');
      $this->form_validation->set_rules('dateFinish', 'dateFinish', 'xss_clean');
      $this->form_validation->set_rules('name', 'name', 'xss_clean');
      $this->form_validation->set_rules('city', 'city', 'xss_clean');
      $this->form_validation->set_rules('disctrict', 'disctrict', 'xss_clean');
      $this->form_validation->set_rules('area', 'area', 'xss_clean');
      $this->form_validation->set_rules('subarea', 'subarea', 'xss_clean');
      $this->form_validation->set_rules('commercetype', 'commercetype', 'xss_clean');
      $this->form_validation->set_rules('datelasttransaction', 'datelasttransaction', 'xss_clean');
      
      $this->form_validation->set_message('xss_clean', 'security: danger value.');

      if ($this->form_validation->run() == FALSE){
        $data['commerce'] = $this->Commerce_Model->get_commerce();
        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        $data['channel'] = $this->Channel_Model->get_channels();
        $data['area'] = array($dropdown[""] = 'Seleccione Zona');
        $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
        $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
        
        $data['clients'] = array();

        $data_index['order'] = "customer.NombreTienda";
        //$data_view = $this->Client_Model->search($data_index);
        $search_parameters = http_build_query($data_index);
        //$data['clients'] = $data_view;
        $data['search_parameters'] = $search_parameters;
        $data['category'] = 'client';
        $data['mark'] = 'search';
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }else{
        $data_in['dateStart'] = $this->input->post('dateStart');
        $data_in['dateFinish'] = $this->input->post('dateFinish');
        $data_in['name'] = $this->input->post('name');
        $data_in['city'] = $this->input->post('city');
        $data_in['disctrict'] = $this->input->post('disctrict');
        $data_in['area'] = $this->input->post('area');
        $data_in['subarea'] = $this->input->post('subarea');
        $data_in['commercetype'] = $this->input->post('commercetype');
        $data_in['datelast'] = $this->input->post('datelasttransaction');
        $data_in['order'] = $this->input->post('orderSelect');
        
        $data_view = $this->Client_Model->search($data_in);
        $search_parameters = http_build_query($data_in);


        $data['commerce'] = $this->Commerce_Model->get_commerce();
        $data['channel'] = $this->Channel_Model->get_channels();

        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] > 0){
          $data['area'] = $this->Area_Model->get_area_for_city($data_in['city']);

          if(isset($data_in['area']) AND $data_in['area'] != "" AND $data_in['area'] > 0){
            $data['subarea'] = $this->Area_Model->get_subarea_for_area($data_in['area']);
          }else{
            $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
          }
          if(isset($data_in['disctrict']) AND $data_in['disctrict'] != "" AND $data_in['disctrict'] > 0){
            $data['district'] = $this->District_Model->get_disctricts_for_city($data_in['city']);
          }else{
            $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
          }
        }else{
          $data['area'] = array($dropdown[""] = 'Seleccione Zona');
          $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
          $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
        }

        $data['clients'] = $data_view;
        $data['search_parameters'] = $search_parameters;
        $data['category'] = 'client';
        $data['mark'] = 'search';
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }
    }

    function client_active (){  //filtro de clientes
      $this->form_validation->set_rules('dateStart', 'dateStart', 'xss_clean');
      $this->form_validation->set_rules('dateFinish', 'dateFinish', 'xss_clean');
      $this->form_validation->set_rules('commercetype', 'commercetype', 'xss_clean');
      $this->form_validation->set_rules('city', 'city', 'xss_clean');
      $this->form_validation->set_rules('area', 'area', 'xss_clean');
      $this->form_validation->set_rules('subarea', 'subarea', 'xss_clean');
      $this->form_validation->set_rules('name', 'name', 'xss_clean');
      $this->form_validation->set_rules('code', 'code', 'xss_clean');
      $this->form_validation->set_rules('channel', 'channel', 'xss_clean');
      $this->form_validation->set_rules('disctrict', 'disctrict', 'xss_clean');
      $this->form_validation->set_rules('orderSelect', 'orderSelect', 'xss_clean');
      
//dateStart   dateFinish  commercetype   city   area  subarea   name  code  channel   orderSelect
      $this->form_validation->set_message('xss_clean', 'security: danger value.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');

      if ($this->form_validation->run() == FALSE){
        redirect("client");
      }else{
        $data_in['dateStart'] = $this->input->post('dateStart');
        $data_in['dateFinish'] = $this->input->post('dateFinish');
        $data_in['commercetype'] = $this->input->post('commercetype');
        $data_in['city'] = $this->input->post('city');
        $data_in['area'] = $this->input->post('area');
        $data_in['subarea'] = $this->input->post('subarea');
        $data_in['name'] = $this->input->post('name');
        $data_in['code'] = $this->input->post('code');
        $data_in['channel'] = $this->input->post('channel');
        //$data_in['disctrict'] = $this->input->post('disctrict');
        $data_in['order'] = $this->input->post('orderSelect');
        $data_view = $this->Client_Model->search($data_in);
        $search_parameters = http_build_query($data_in);


        $data['commerce'] = $this->Commerce_Model->get_commerce();
        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != 0 AND $data_in['city'] != "all"){
          $data['area'] = $this->Area_Model->get_area_for_city($data_in['city']);

          if(isset($data_in['area']) AND $data_in['area'] != "" AND $data_in['area'] != 0 AND $data_in['area'] != "all"){
            $data['subarea'] = $this->Area_Model->get_subarea_for_area($data_in['area']);
          }else{
            $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
          }
          /*if(isset($data_in['disctrict']) AND $data_in['disctrict'] != "" AND $data_in['disctrict'] > 0){
            $data['district'] = $this->District_Model->get_disctricts_for_city($data_in['city']);
          }else{
            $data['district'] = array($dropdown[""] = 'Seleccione Sub Zona');
          }*/
        }else{
          $data['area'] = array($dropdown[""] = 'Seleccione Zona');
          $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
        }
        $data['channel'] = $this->Channel_Model->get_channels();

        $data['clients'] = $data_view;
        $data['category'] = 'client';
        $data['mark'] = "tab1";
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }
    }

    function save() {
      $this->form_validation->set_rules('commercetype', 'Tipo de Comercio', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('city', 'Ciudad', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('disctrict', 'Barrio', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('area', 'Zona', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('subarea', 'Sub Zona', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('channel', 'Canal', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('name', 'Nombre del Negocio', 'xss_clean|required');
      $this->form_validation->set_rules('address', 'Direccion', 'xss_clean|required');
      $this->form_validation->set_rules('username', 'Nombre del Encargado', 'xss_clean|required');
      $this->form_validation->set_rules('email', 'Email', 'xss_clean|valid_email');
      $this->form_validation->set_rules('phone', 'Telefono', 'xss_clean|integer');
      $this->form_validation->set_rules('cellphone', 'Celular', 'xss_clean|integer');
      $this->form_validation->set_rules('latitude', 'Latitud', 'xss_clean');
      $this->form_validation->set_rules('longitude', 'Longitud', 'xss_clean');      
      $this->form_validation->set_rules('manualcode', 'Codigo', 'xss_clean|integer');
      $this->form_validation->set_rules('limit', 'Limite', 'xss_clean|integer');

      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_message('integer', 'Debe ser un valor numerico.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        if($this->input->post('form_action') == "save") {
          $this->redirect_form('new');
        }else {
          $this->redirect_form('edit');
        }

      } else {
        $data_in['idComercio'] = $this->input->post('commercetype');
        $data_in['idCiudad'] = $this->input->post('city');
        $data_in['idBarrio'] = $this->input->post('disctrict');
        $data_in['idChannel'] = $this->input->post('channel');
        $data_in['NombreTienda'] = $this->input->post('name');
        $data_in['Direccion'] = $this->input->post('address');
        $data_in['NombreContacto'] = $this->input->post('username');
        $data_in['Email'] = $this->input->post('email');
        $data_in['Telefono'] = $this->input->post('phone');
        $data_in['TelfCelular'] = $this->input->post('cellphone');
        $data_in['Contactop01'] = $this->input->post('contactop1');
        $data_in['Telfcontop01'] = $this->input->post('telfcontactop1');
        $data_in['Contactop02'] = $this->input->post('contactop2');
        $data_in['Telfcontop02'] = $this->input->post('telfcontactop2');
        $data_in['Observacion'] = $this->input->post('obs');
        $data_in['idSubZona'] = $this->input->post('subarea');
        $data_in['Coordenada'] = $this->input->post('latitude').";".$this->input->post('longitude');
        $data_in['Ref0'] = $this->input->post('manualcode');
        $data_in['idrank'] = $this->input->post('limit');

        $data_in['Estado'] = '1';
        $data_in['FechaAlta'] = mdate("%Y-%m-%d %h:%i:%a");

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          if ($this->Client_Model->create($data_in) == TRUE) {
            redirect("client");
          } else {
            $this->redirect_form('new');
          }
        }else{
          if ($this->Client_Model->update($data_in, $this->input->post('idclient')) === TRUE) {
            $data_view = $this->Client_Model->report();
            redirect("client");
          } else {
            $this->redirect_form('edit');
          }
        }
      }
    }

    // redirect form
    //$this->redirect_form('new');
    function redirect_form($action){
      $data['category'] = 'client';
      $data['action'] = $action;
      $data['page'] = 'form';
      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['rank'] = $this->Rank_Model->get_ranks();

      if ($action == 'new'){
        $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
        $data['area'] = array($dropdown[""] = 'Seleccione Zona');        
        $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
      }else{
        $data['district'] = $this->District_Model->get_disctricts();
        $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
        $data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());
      }

      $this->load->view('template/template', $data);
    }

    // redirect tab
    function redirect_tab($tab, $viewx, $search_parameters=Array()){
      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['district'] = $this->District_Model->get_disctricts();
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
      $data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());

      $data['search'] = $viewx;
      //$data['clients'] = $this->Client_Model->report($order);
      $data['clients'] = $viewx;
      $data['search_parameters'] = $search_parameters;
      $data['category'] = 'client';
      $data['mark'] = $tab;
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    // desactivar usuario
    function deactive($cli) {
      $this->Client_Model->set_client_status($cli, '0');
      $data_view = $this->Client_Model->report();
      $this->redirect_tab("tab1", $data_view);
    }

    // activar usuario
    function active($cli) {
      $this->Client_Model->set_client_status($cli, '1');
      $data_view = $this->Client_Model->report();
      $this->redirect_tab("tab2", $data_view);
    }

    // eliminar usuario
    function delete($cli) {
      $this->Client_Model->set_client_status($cli, '2');
      $data_view = $this->Client_Model->report();
      $this->redirect_tab("tab1", $data_view);
    }

    function get_customers_by_area($idArea=-1) {
      echo(json_encode($this->Client_Model->get_customers_by_area($idArea)));
    }

    function pdf() {
      $this->load->helper('pdfexport_helper.php');
      $parameters_string = $this->input->post('parameters');

      parse_str(html_entity_decode($parameters_string), $parameters);
      $clients = $this->Client_Model->search($parameters);

      $user_email = $this->Account_Model->get_email();
      $user = $this->Account_Model->get_user_by_email($user_email);

      if (isset($parameters['city']) && $parameters['city']!="" && $parameters['city']!="all" && $parameters['city'] != "0") {
        $city = $this->City_Model->get($parameters['city']);
        $parameters['city'] = $city[0]->NombreCiudad;
      }

      if (isset($parameters['disctrict']) && $parameters['disctrict']!="" && $parameters['disctrict']!="0" && $parameters['disctrict']!="all") {
        $disctrict = $this->District_Model->get($parameters['disctrict']);
        $parameters['disctrict'] = $disctrict[0]->Descripcion;
      }

      if (isset($parameters['area']) && $parameters['area']!="" && $parameters['area']!="0" && $parameters['area']!="all") {
        $area = $this->Area_Model->get($parameters['area']);
        $parameters['area'] = $area[0]->Descripcion;
      }

      if (isset($parameters['subarea']) && $parameters['subarea']!="" && $parameters['subarea']!="0" && $parameters['subarea']!="all") {
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

      if (isset($parameters['datelast']) && ($parameters['datelast']!="")) {
        $days = $parameters['datelast'];
        $days = intval($days)*-1;
        $fecha = date ('Y-m-j');
        $nuevafecha = strtotime ( $days.' day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $parameters['datelast'] = $nuevafecha;
      }

      $data['user_name'] = $user->Nombre . ' ' . $user->Apellido;
      $data['parameters'] = $parameters;
      $data['title'] = 'REPORTE DE CLIENTES';
      $data['clients'] = $clients;
      $data['category'] = 'client';
      $data['page'] = 'pdf';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/systems/horizon/';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('template/template_pdf', $data);
      //print_r($data);
      $templateView = $this->load->view('template/template_pdf', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
    }

    function activos(){
      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['district'] = $this->District_Model->get_disctricts();
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['area'] = array($dropdown[""] = 'Seleccione Zona');
      $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');

      $data['clients'] = array();
      $data['category'] = 'client';
      $data['mark'] = "tab1";
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function inactivos(){
      $datasearch['status'] = "0";
      $data_view = $this->Client_Model->search($datasearch);

      $data['clients'] = $data_view;  
      $data['category'] = 'client';
      $data['mark'] = "tab2";
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function search(){
      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['area'] = array($dropdown[""] = 'Seleccione Zona');
      $data['subarea'] = array($dropdown[""] = 'Seleccione Sub Zona');
      $data['district'] = array($dropdown[""] = 'Seleccione Barrio');
      
      $data['clients'] = array();

      $data_index['order'] = "customer.NombreTienda";
      //$data_view = $this->Client_Model->search($data_index);
      $search_parameters = http_build_query($data_index);
      //$data['clients'] = $data_view;
      $data['search_parameters'] = $search_parameters;
      $data['category'] = 'client';
      $data['mark'] = 'search';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function csv(){
      $this->load->helper('download');
      $parameters_string = $this->input->post('parameters');
      parse_str(html_entity_decode($parameters_string), $parameters);
      $clients = $this->Client_Model->csv($parameters);
      $name = 'clients.csv';
      force_download($name, $clients); 
    }
  }
?>
