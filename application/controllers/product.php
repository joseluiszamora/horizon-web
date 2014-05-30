<?php
  class Product extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Product_Model');
      $this->load->model('Linevolume_Model');
      $this->load->model('City_Model');
      $this->load->model('Line_Model');
      $this->load->model('Volume_Model');
      $this->load->model('Area_Model');
      $this->load->model('Channel_Model');
      $this->load->model('Commerce_Model');
      $this->load->model('Transaction_Model');
    }

    function index($order="Nombre") {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'productos'))) {
        show_404();
      }
      $this->activos();
    }

    // send product list for android client
    function report_android(){
      $products = json_encode($this->Product_Model->report_android());
      echo $products;
    }

    function create() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'productos'))) {
        show_404();
      }
      $data['category'] = 'product';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $data['lines'] = $this->Linevolume_Model->get_lines();
      $data['linesvolumes'] = array($dropdown[""] = 'Seleccione Volumen');
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'productos'))) {
        show_404();
      }
      if ($id != "") {
        $data['idproduct'] = $id;
        $product = $this->Product_Model->get($id);
        if (empty($product)) {
            show_404();
        } else {
          $data['product'] = $product[0];

          $data['lines'] = $this->Linevolume_Model->get_lines();
          $linevolumes = $this->Linevolume_Model->get($product[0]->idLineVolume);
          if (empty($linevolumes)) {
            $data['linesvolumes'] = array();
          } else {
            $linevolume = $linevolumes[0];
            $data['linesvolumes'] = $this->Linevolume_Model->get_linesvolumes($linevolume->idLine);
          }

          $data['category'] = 'product';
          $data['action'] = 'edit';
          $data['page'] = 'form';
          $this->load->view('template/template', $data);
        }
      }
      else
        redirect('product');
    }

    function save() {
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'productos'))) {
        show_404();
      }
      if($this->input->post('form_action') == "save") {
        $this->form_validation->set_rules('codigoProduct', 'Codigo de Producto', 'xss_clean|required|numeric|is_unique[products.idProduct]');
      }else {
        $this->form_validation->set_rules('codigoProduct', 'Codigo de Producto', 'xss_clean');
      }
      $this->form_validation->set_rules('line', 'Línea', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('productname', 'Nombre del Producto', 'xss_clean|required');
      $this->form_validation->set_rules('volume', 'Volumen', 'xss_clean|required|greater_than[0]');
      $this->form_validation->set_rules('price', 'Precio Unitario', 'xss_clean|required|numeric');
      $this->form_validation->set_rules('uxp', 'Unidades por Paquete', 'xss_clean|required|numeric');

      $this->form_validation->set_message('required', '%s es obligatorio.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');
      $this->form_validation->set_message('is_unique', 'Ya existe un Producto con este Codigo.');
      $this->form_validation->set_message('numeric', 'Ingrese un valor numerico.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        $data['lines'] = $this->Linevolume_Model->get_lines();
        $data['idLine'] = $this->input->post('line');
        $data['linesvolumes'] = $this->Linevolume_Model->get_linesvolumes($data['idLine']);
        if($this->input->post('form_action') == "save") {
          $data['action'] = 'new';
        }else {
          $data['action'] = 'edit';
        }
        $data['category'] = 'product';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);
      } else {
        $data_in['Nombre'] = $this->input->post('productname');
        $data_in['idLineVolume'] = $this->input->post('volume');
        $data_in['PrecioUnit'] = $this->input->post('price');
        $data_in['uxp'] = $this->input->post('uxp');
        $data_in['Descripcion'] = $this->input->post('desc');

        // Check if Save or Edit
        if($this->input->post('form_action') == "save") {
          $data_in['idProduct'] = $this->input->post('codigoProduct');
          if ($this->Product_Model->create($data_in) === TRUE) {
            redirect('product');
          } else {
            $data['category'] = 'product';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }else{
          $data_in['idProduct'] = $this->input->post('idproduct');
          if ($this->Product_Model->update($data_in, $data_in['idProduct']) === TRUE) {
            redirect('product');
          } else {
            $data['category'] = 'product';
            $data['action'] = 'edit';
            $data['page'] = 'form';
            $this->load->view('template/template', $data);
          }
        }
      }
    }

    function get_linesvolumes($idLine=-1) {
      echo(json_encode($this->Linevolume_Model->get_linesvolumes($idLine)));
    }

    function get_products_by_line($idLine=-1) {
      $idLine = $this->input->post('line');
      echo(json_encode($this->Product_Model->get_products_by_line($idLine)));
    }

    function get_products_by_line_volume($idLine=-1, $idVolume=-1) {
      $idLine = $this->input->post('line');
      $idVolume = $this->input->post('volume');
      echo(json_encode($this->Product_Model->get_products_by_line_volume($idLine, $idVolume)));
    }

    // redirect tab
    function redirect_tab($tab, $viewx, $search_parameters=Array()){
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'productos'))) {
        show_404();
      }
      $data['linea'] = $this->Linevolume_Model->get_lines();
      //$data['volumen'] = array($dropdown[""] = 'Seleccione Volumen');
      $data['volumen'] = $this->Linevolume_Model->get_volumes();
      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['district'] = $this->District_Model->get_disctricts();
      $data['channel'] = $this->Channel_Model->get_channels();
      $data['area'] = $this->Area_Model->get_area($this->Account_Model->get_city());
      $data['subarea'] = $this->Area_Model->get_sub_area_for_city($this->Account_Model->get_city());

      $data['search'] = $viewx;
      //$data['clients'] = $this->Client_Model->report($order);
      $data['products'] = $viewx;
      $data['search_parameters'] = $search_parameters;
      $data['category'] = 'product';
      $data['mark'] = $tab;
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function search_tab (){
      $this->form_validation->set_rules('line', 'line', 'xss_clean');
      $this->form_validation->set_rules('volume', 'volume', 'xss_clean');
      $this->form_validation->set_rules('dateStart', 'dateStart', 'xss_clean');
      $this->form_validation->set_rules('dateFinish', 'dateFinish', 'xss_clean');
      $this->form_validation->set_rules('city', 'city', 'xss_clean');
      $this->form_validation->set_rules('area', 'area', 'xss_clean');
      $this->form_validation->set_rules('subarea', 'subarea', 'xss_clean');

      $this->form_validation->set_message('xss_clean', 'security: danger value.');

      if ($this->form_validation->run() == FALSE){
        $search_parameters = $search_parameters;
        $data['products'] = $data_view;
        $data['search_parameters'] = $search_parameters;
        $data['category'] = 'product';
        $data['mark'] = 'search';
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }else{
        //line  volume  dateStart   dateFinish  city  area  subarea
        $data_in['line'] = $this->input->post('line');
        $data_in['volume'] = $this->input->post('volume');
        $data_in['dateStart'] = $this->input->post('dateStart');
        $data_in['dateFinish'] = $this->input->post('dateFinish');
        $data_in['city'] = $this->input->post('city');
        $data_in['area'] = $this->input->post('area');
        $data_in['subarea'] = $this->input->post('subarea');
        $data_in['order'] = "products.Nombre";
        
        $data_view = $this->Product_Model->search($data_in);
        $search_parameters = http_build_query($data_in);
        
        // add filters
        $data['linea'] = $this->Linevolume_Model->get_lines();
        if(isset($data_in['line']) AND $data_in['line'] != "" AND $data_in['line'] > 0){
          $data['volumen'] = $this->Linevolume_Model->get_linesvolumes($data_in['line']);
        }else{
          $data['volumen'] = array($dropdown[""] = 'Seleccione Volumen');
        }
        
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


        $search_parameters = $search_parameters;
        $data['products'] = $data_view;
        $data['search_parameters'] = $search_parameters;
        $data['category'] = 'product';
        $data['mark'] = 'search';
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      }
    }

    // desactivar usuario
    function deactive($pro) {
      $this->Product_Model->set_product_status($pro, '0');
      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '18';
      $data['idReferencia'] = $pro;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);
      redirect('product');
    }

    // activar usuario
    function active($pro) {
      $this->Product_Model->set_product_status($pro, '1');

      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '17';
      $data['idReferencia'] = $pro;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);

      redirect('product');
    }

    // eliminar usuario
    function delete($pro) {
      $this->Product_Model->set_product_status($pro, '2'); 
      redirect('product');
    }

    function pdf() {
      $this->load->helper('pdfexport_helper.php');
      $parameters_string = $this->input->post('parameters');
      parse_str(html_entity_decode($parameters_string), $parameters);
      $products = $this->Product_Model->search($parameters);

      $user_email = $this->Account_Model->get_email();
      $user = $this->Account_Model->get_user_by_email($user_email);

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

      if (isset($parameters['line']) && ($parameters['line']!="") && ($parameters['line']!="0")) {
        $line = $this->Line_Model->get($parameters['line']);
        $parameters['line'] = $line[0]->Descripcion;
      }

      if (isset($parameters['volume']) && ($parameters['volume']!="") && ($parameters['volume']!="0")) {
        $volume = $this->Volume_Model->get($parameters['volume']);
        $parameters['volume'] = $volume[0]->Descripcion;
      }

      $data['user_name'] = $user->Nombre . ' ' . $user->Apellido;
      $data['parameters'] = $parameters;
      $data['title'] = 'PRODUCTOS';
      $data['products'] = $products;
      $data['category'] = 'product';
      $data['page'] = 'pdf';
      //$data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/systems/horizon/';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('template/template_pdf', $data);
      $templateView = $this->load->view('template/template_pdf', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
    }

    function activos(){
      $datasearch['status'] = "1";
      $data_view = $this->Product_Model->report($datasearch);
      $data['products'] = $data_view;
      $data['category'] = 'product';
      $data['mark'] = "tab1";
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function inactivos(){
      $datasearch['status'] = "0";
      $data_view = $this->Product_Model->report($datasearch);
      $data['products'] = $data_view;
      $data['category'] = 'product';
      $data['mark'] = "tab2";
      $data['page'] = 'index';
      $this->load->view('template/template', $data); 
    }

    function search(){
      $data['linea'] = $this->Linevolume_Model->get_lines();
      $data['volumen'] = array($dropdown[" "] = 'Seleccione Volumen');
      $data['commerce'] = $this->Commerce_Model->get_commerce();
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['district'] = array($dropdown[" "] = 'Seleccione Area');
      $data['channel'] = array($dropdown[" "] = 'Seleccione Canal');
      $data['area'] = array($dropdown[" "] = 'Seleccione Zona');
      $data['subarea'] = array($dropdown[" "] = 'Seleccione Sub Zona');
      
      //$datasearch['status'] = "1";
      //$data_view = $this->Product_Model->search($datasearch);
      $data_view = array();

      $data_index['order'] = "products.Nombre";
      $search_parameters = http_build_query($data_index);
      $data['products'] = $data_view;
      $data['search_parameters'] = $search_parameters;
      $data['category'] = 'product';
      $data['mark'] = 'search';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

  	function csv(){
      $this->load->helper('download');
      $parameters_string = $this->input->post('parameters');
      parse_str(html_entity_decode($parameters_string), $parameters);
      $products = $this->Product_Model->csv($parameters);

      $name = 'products.csv';

      force_download($name, $products); 
  	}
  }
?>
