<?php
  class User extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('User_Model');
      $this->load->model('City_Model');
      $this->load->model('Area_Model');
      $this->load->model('Profile_Model');

      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      } else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'usuarios'))) {
        show_404();
      }
    }

    function index($order="idUser") {
      $this->activos($order);
    }

    function create() {
      //$this->redirect_tab('t_1', 'form', 'idUser', 'new');
      $data['profile'] = $this->Profile_Model->get_profiles($this->Account_Model->get_profile());
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      //$data['area'] = $this->Area_Model->get_area_for_city($this->session->userdata('city'));
      $data['area'] = array($dropdown[""] = 'Seleccione Zona');
      $data['users'] = $this->User_Model->report('idUser');
      $data['action'] = 'new';
      $data['page'] = 'form';
      $data['mark'] = 't_1';
      $data['category'] = 'user';
      
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($id != "") {
        $data['idUser'] = $id;
        $user = $this->User_Model->get($id);
        if (empty($user)) {
            show_404();
        }
        $data['user'] = $user[0];
        $data['category'] = 'user';
        $data['action'] = 'edit';
        $data['page'] = 'form';
        $data['profile'] = $this->Profile_Model->get_profiles($this->Account_Model->get_profile());
        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        $data['area'] = $this->Area_Model->get_area_for_city($this->session->userdata('city'));
        $data['users'] = $this->User_Model->report('idUser');      
        $this->load->view('template/template', $data);
      }
      else
        redirect('user');
    }

    function search_tab (){
      /*
      $data['profile'] = $this->Profile_Model->get_profiles($this->Account_Model->get_profile());
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['area'] = $this->Area_Model->get_area_for_city($this->session->userdata('city'));
      $data['users'] = $this->User_Model->report();
      $data['page'] = "index";
      $data['mark'] = "search";
      $data['category'] = 'user';
      
      $this->load->view('template/template', $data);    
      */

      $this->form_validation->set_rules('dateStart', 'dateStart', 'xss_clean');
      $this->form_validation->set_rules('dateFinish', 'dateFinish', 'xss_clean');
      $this->form_validation->set_rules('city', 'city', 'xss_clean');
      $this->form_validation->set_rules('area', 'area', 'xss_clean');
      $this->form_validation->set_rules('name', 'name', 'xss_clean');
      $this->form_validation->set_rules('profile', 'profile', 'xss_clean');
      $this->form_validation->set_rules('order', 'order', 'xss_clean');

      $this->form_validation->set_message('xss_clean', 'security: danger value.');
      $this->form_validation->set_message('greater_than', '%s es obligatorio.');

//dateStart   dateFinish  city  name  area  profile
      if ($this->form_validation->run() == FALSE){
      }else{
        $data_in['dateStart'] = $this->input->post('dateStart');
        $data_in['dateFinish'] = $this->input->post('dateFinish');
        $data_in['name'] = $this->input->post('name');
        $data_in['city'] = $this->input->post('city');
        $data_in['area'] = $this->input->post('area');
        $data_in['profile'] = $this->input->post('profile');
        $data_in['order'] = $this->input->post('order');

        $data_view = $this->User_Model->search($data_in);

        $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] > 0){
          $data['area'] = $this->Area_Model->get_area_for_city($data_in['city']);
        }else{
          $data['area'] = array($dropdown[""] = 'Seleccione Zona');
        }

        $data['profile'] = $this->Profile_Model->get_profiles($this->Account_Model->get_profile());
        //$data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
        //$data['area'] = $this->Area_Model->get_area_for_city($this->session->userdata('city'));
        $data['users'] = $data_view;
        $data['category'] = 'user';
        $data['page'] = "index";
        $data['mark'] = "search";
        $this->load->view('template/template', $data);
      }







      /*$data_in['dateStart'] = $this->input->post('dateStart');
      $data_in['dateFinish'] = $this->input->post('dateFinish');
      $data_in['name'] = $this->input->post('name');
      $data_in['city'] = $this->input->post('city');
      $data_in['area'] = $this->input->post('area');
      $data_in['profile'] = $this->input->post('profile');
      $data_in['order'] = $this->input->post('order');

      $data_view = $this->User_Model->search($data_in);

      $data['profile'] = $this->Profile_Model->get_profiles($this->Account_Model->get_profile());
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['area'] = $this->Area_Model->get_area_for_city($this->session->userdata('city'));
      $data['users'] = $this->User_Model->report('idUser');      
      $data['category'] = 'user';
      $data['page'] = 'search';
      $data['mark'] = 't_3';
      
      $this->load->view('template/template', $data);*/
    }


    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        if($this->input->post('form_action') == "save") {
          $this->form_validation->set_rules('ci', 'Carnet de identidad', 'xss_clean|required|is_unique[users.ci]');
          $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email|is_unique[users.Email]');
        }else {
          $this->form_validation->set_rules('ci', 'Carnet de identidad', 'xss_clean|required');
          $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email');
        }
        $this->form_validation->set_rules('usertype', 'Tipo de Usuario', 'xss_clean|required|greater_than[0]');

        if($this->input->post('usertype') != "1") {
          $this->form_validation->set_rules('city', 'Ciudad', 'xss_clean|required|greater_than[0]');
          
          if($this->input->post('usertype') != "2" && $this->input->post('usertype') != "3" )
            $this->form_validation->set_rules('area', 'Zona', 'xss_clean|required');
        }
        
        $this->form_validation->set_rules('username', 'Nombre', 'xss_clean|required');
        $this->form_validation->set_rules('userlastname', 'Apellido', 'xss_clean|required');
        // if flag change pass is checked
        if($this->input->post('changepass')) {
          $this->form_validation->set_rules('pass', 'Password', 'xss_clean|required|min_length[4]|max_length[12]|matches[password_conf]');
          $this->form_validation->set_rules('password_conf', 'Confirmacion de Password', 'xss_clean|required|matches[pass]');
        }else{
          $this->form_validation->set_rules('pass', 'Password', 'xss_clean');
          $this->form_validation->set_rules('password_conf', 'Confirmacion de Password', 'xss_clean');
        }
        //$this->form_validation->set_rules('phone', 'Telefono', 'xss_clean|required|integer');
        //$this->form_validation->set_rules('cellphone', 'Celular', 'xss_clean|required|integer');

        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('greater_than', '%s es obligatorio.');
        $this->form_validation->set_message('is_unique', 'Ya existe un usuario con este %s.');
        $this->form_validation->set_message('matches', 'Los password no son iguales.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          if($this->input->post('form_action') == "save") 
            $this->redirect_tab('t_3', 'form', 'idUser', 'new');
          else
            $this->redirect_tab('t_3', 'form', 'idUser', 'edit');
        } else {
          $data_in['idUser'] = $this->input->post('iduser');
          $data_in['ci'] = $this->input->post('ci');
          $data_in['Nombre'] = $this->input->post('username');
          $data_in['Apellido'] = $this->input->post('userlastname');
          $data_in['Email'] = $this->input->post('email');

          // if flag change pass is checked
          if($this->input->post('changepass')) 
            //$data_in['Password'] =  $this->input->post('pass');
            $data_in['Password'] =  $this->encrypt->sha1($this->input->post('pass'));
            
          
          $data_in['Telefono'] = $this->input->post('phone');
          $data_in['TelfCelular'] = $this->input->post('cellphone');
          $data_in['Enable'] = '1';
          $data_in['Observacion'] = $this->input->post('obs');
          $data_in['idCiudadOpe'] = $this->input->post('city');
          $data_in['idZona'] = $this->input->post('area');
          $data_in['NivelAcceso'] = $this->input->post('usertype');
          if ($this->input->post('webaccess')) 
            $data_in['Web'] = '1';
          else
            $data_in['Web'] = '0';

          // Check if Save or Edit
          if($this->input->post('form_action') == "save") {
            $data_in['FechaIngreso'] = mdate("%Y-%m-%d %h:%i:%a");
            if ($this->Account_Model->create($data_in) === TRUE) {
              redirect('user');
            } else {
              $this->redirect_tab('t_3', 'form', 'idUser', 'new');
            }
          }else {
            $id = $this->input->post('iduser');
            if ($this->Account_Model->update($data_in, $id) === TRUE) {
              redirect('user');
            } else {
              $this->redirect_tab('t_3', 'form', 'idUser', 'edit');
            }
          }
          //print_r($data_in);
        }
      } else {
        redirect('account/login');
      }
    }


    // redirect tab
    function redirect_tab($tab, $page, $order, $action){
      $data['profile'] = $this->Profile_Model->get_profiles($this->Account_Model->get_profile());
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      $data['area'] = $this->Area_Model->get_area_for_city($this->session->userdata('city'));
      $data['users'] = $this->User_Model->report($order);
      $data['action'] = $action;
      $data['page'] = $page;
      $data['mark'] = $tab;
      $data['category'] = 'user';
      
      $this->load->view('template/template', $data);
    }


    //get_users_by_city

    function get_user_category($profile) {
      $users_list = $this->User_Model->get_user_category($profile);
      return $users_list;
    }

    function get_my_city($profile) {
      $users_list = $this->User_Model->get_user_category($profile);
      return $users_list;
    }

    // desactivar usuario
    function deactive($usr) {
      $this->User_Model->set_user_status($usr, '0');

      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '29';
      $data['idReferencia'] = $usr;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);
      redirect('user');

    }

    // activar usuario
    function active($usr) {
      $this->User_Model->set_user_status($usr, '1');

      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '28';
      $data['idReferencia'] = $usr;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);

      redirect('user');
    }

    // eliminar usuario
    function delete($usr) {
      $this->User_Model->set_user_status($usr, '2');
      redirect('user');
    }

    function activos($order='users.idUser'){
      $data['users'] = $this->User_Model->report($order);
      $data['page'] = "index";
      $data['mark'] = "tab1";
      $data['category'] = 'user';
      
      $this->load->view('template/template', $data);
    }

    function inactivos(){
      $data['users'] = $this->User_Model->report();
      $data['page'] = "index";
      $data['mark'] = "tab2";
      $data['category'] = 'user';
      $this->load->view('template/template', $data);
    }

    function search(){
      $data['profile'] = $this->Profile_Model->get_profiles($this->Account_Model->get_profile());
      $data['city'] = $this->City_Model->get_cities($this->Account_Model->get_profile());
      //$data['area'] = $this->Area_Model->get_area_for_city($this->session->userdata('city'));
      $data['area'] = array($dropdown[""] = 'Seleccione Zona');
      $data['users'] = $this->User_Model->report();
      $data['page'] = "index";
      $data['mark'] = "search";
      $data['category'] = 'user';
      
      $this->load->view('template/template', $data);    
    }
  }
?>