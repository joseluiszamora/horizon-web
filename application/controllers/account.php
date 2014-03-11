<?php

class Account extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->model('User_Model');
      $this->load->model('City_Model');
      $this->load->model('Area_Model');
    }

    function index() {
      if ($this->Account_model->logged_in() === TRUE) {
          $this->login();
      } else {
          $this->load->view('account/details');
      }
    }

    function dashboard($condition = FALSE) {
      if ($condition === TRUE OR $this->Account_model->logged_in() === TRUE) {
          $this->load->view('account/dashboard');
      } else {
          $this->load->view('account/details');
      }
    }

    function login() {
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
      $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email');
      $this->form_validation->set_rules('pass', 'Password', 'xss_clean|required|callback_password_check');
      $this->form_validation->set_message('required', 'El %s es obligatorio.');
      $this->_email = $this->input->post('email');
      //$this->_password = $this->encrypt->encode($this->input->post('password'));
      //$this->_password = $this->input->post('password');
      $this->_password = $this->input->post('pass');
      if ($this->form_validation->run() == FALSE) {
        $data['page'] = 'login';
        $this->load->view('template/template_account', $data);
      } else {
        $profile = $this->User_Model->get_profile($this->input->post('email'));
        if($profile == '1'){
          $city = 'all';
          $area = 'all';
        }elseif($profile == '2' || $profile == '3'){
          $city = $this->User_Model->get_city($this->input->post('email'));
          $area = 'all';
        }else{
          $city = $this->User_Model->get_city($this->input->post('email'));
          $area = $this->User_Model->get_area($this->input->post('email'));
        }
        
        $this->Account_Model->login($this->input->post('email'), $profile, $city, $area);
        redirect('home');
      }
    }


/*
    function register() {
      $this->form_validation->set_rules('ci', 'Carnet de identidad', 'xss_clean|required');
      $this->form_validation->set_rules('username', 'Nombre', 'xss_clean|required');
      $this->form_validation->set_rules('userlastname', 'Apellido', 'xss_clean|required');
      $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email|is_unique[users.Email]');
      $this->form_validation->set_rules('password', 'Password', 'xss_clean|required|min_length[4]|max_length[12]|matches[password_conf]');
      $this->form_validation->set_rules('password_conf', 'Confirmacion de Password', 'xss_clean|required|matches[password]');
      $this->form_validation->set_message('required', 'El %s es obligatorio.');
      $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        $data['page'] = 'register';
        $data['users'] = $this->get_user_category();
        $data['city'] = $this->City_Model->get_cities();
        $data['area'] = $this->Area_Model->get_area();
        $this->load->view('template/template_account', $data);
      } else {
        $data_in['ci'] = $this->input->post('ci');
        $data_in['Nombre'] = $this->input->post('username');
        $data_in['Apellido'] = $this->input->post('userlastname');
        $data_in['Email'] = $this->input->post('email');
        $data_in['Password'] = $this->input->post('password');
        $data_in['Telefono'] = $this->input->post('phone');
        $data_in['TelfCelular'] = $this->input->post('cellphone');
        $data_in['Enable'] = '1';
        $data_in['Observacion'] = $this->input->post('obs');
        $data_in['idCiudadOpe'] = $this->input->post('city');
        $data_in['idZona'] = $this->input->post('area');
        $data_in['NivelAcceso'] = '1';

        if ($this->Account_Model->create($data_in) === TRUE) {
          redirect('register');
        } else {
          redirect('register');
        }
      }
    }
*/


    
    // get user category/profile list ()
    function get_user_category() {
      $users_list = $this->User_Model->get_user_category();
      return $users_list;
    }

    function logout() {
      if($this->Account_Model->logout())
        redirect('account/login');   
    }
    
    function password_check() {
      if ($this->Account_Model->user_exists($this->_email) === TRUE) {
        if ($this->Account_Model->web_access_check($this->_email) === TRUE) {
          if ($this->Account_Model->password_check($this->_email, $this->_password) === TRUE) {
            //echo "YESSSS<br>";        
          } else {
            $this->form_validation->set_message('password_check', 'Password Incorrecto!');
            return FALSE;
          }
        } else {
          $this->form_validation->set_message('password_check', 'Este usuario no tiene permiso para acceder via web');
          return FALSE;
        }
      } else {
        $this->form_validation->set_message('password_check', 'Usuario no registrado!');
        $this->form_validation->set_message('user_check', 'Usuario No existe!');
        return FALSE;
      }
      //echo $this->Account_Model->password_check($this->_email, $this->_password);
    }

}

?>