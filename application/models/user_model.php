<?php

class User_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
    }

    function report($order='users.idUser') {
      $this->db->select(
        'users.idUser, 
        users.ci, 
        users.Nombre, 
        users.Apellido, 
        users.Email, 
        users.Password, 
        users.FechaIngreso, 
        users.Telefono, 
        users.TelfCelular, 
        users.Enable, 
        users.Observacion, 
        users.idCiudadOpe, 
        users.idZona, 
        users.Web, 
        profile.Descripcion as perfil'
      );
      $this->db->from('users');
      
      $this->db->join('profile', 'users.NivelAcceso = profile.idProfile');
      $this->db->order_by($order, "asc"); 
      // filters by city
      if($this->Account_Model->get_profile() == 3){
        $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());
        $this->db->where('users.NivelAcceso !=', 1);
        $this->db->where('users.NivelAcceso !=', 2);
        $this->db->where('users.NivelAcceso !=', 3);
      }
      if($this->Account_Model->get_profile() == 4 || $this->Account_Model->get_profile() == 5){
        $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());
        $this->db->where('users.NivelAcceso !=', 1);
        $this->db->where('users.NivelAcceso !=', 2);
        $this->db->where('users.NivelAcceso !=', 3);
        $this->db->where('users.NivelAcceso !=', 4);
        $this->db->where('users.NivelAcceso !=', 5);
      }
      $query = $this->db->get();
      return $query->result();
    }


    // get all users for city
    function get_users_by_city($city) {
      $this->db->select(
        'users.idUser, 
        users.ci, 
        users.Nombre, 
        users.Apellido, 
        users.Email'
      );
      $this->db->from('users');
      $this->db->order_by('idUser', "asc"); 
      // filters by city
      if($this->Account_Model->get_profile() == 3){
        $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());
        $this->db->where('users.NivelAcceso !=', 1);
        $this->db->where('users.NivelAcceso !=', 2);
      }
      $query = $this->db->get();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Usuario';

      $result = $query->result_array();
      foreach ($result as $r) {
        $dropdown[$r['idUser']] = $r['Email'];
      }

      return $dropdown;
    }

    // get all users for city
    function get_users_by_city_mail($mail) {
      $this->db->select(
        'users.idUser, 
        users.ci, 
        users.Nombre, 
        users.Apellido, 
        users.Email'
      );
      $this->db->from('users');
      $this->db->order_by('idUser', "asc"); 
      // filters by city
      if($this->Account_Model->get_profile() == 3){
        $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());
        $this->db->where('users.NivelAcceso !=', 1);
        $this->db->where('users.NivelAcceso !=', 2);
      }
      $query = $this->db->get();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Usuario';

      $result = $query->result_array();
      foreach ($result as $r) {
        $dropdown[$r['Email']] = $r['Email'];
      }

      return $dropdown;
    }


    public function get($id) {
      $query = $this->db->get_where('users',array('idUser'=>$id,'Enable'=>'1'));
      return $query->result();
    }

    // get user category/profile list
    function get_user_category($idprofile) {
      /*1   Administrador
      2   Supervisor
      3   Agencia
      4   Distribuidor
      5   Preventista*/
      $query = $this->db->get('profile');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[""] = "Seleccione Perfil de usuario";
      if ($idprofile == 1){
        $dropdown[1] = "Administrador";
        $dropdown[2] = "Supervisor";
        $dropdown[3] = "Agencia";
        $dropdown[4] = "Distribuidor";
        $dropdown[5] = "Preventista";
      }
      if ($idprofile == 3){
        $dropdown[4] = "Distribuidor";
        $dropdown[5] = "Preventista";
      }
      /*$query = $this->db->get('profile');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[""] = "Seleccione Perfil de usuario";
      foreach ($result as $r) {
        $dropdown[$r['idProfile']] = $r['Descripcion'];
      }*/
      return $dropdown;
    }

    function get_profile($mail) {     
      $this->db->select('users.NivelAcceso as profile');
      $this->db->from('users');
      $this->db->where('users.Email', $mail);
      $query = $this->db->get();      
      $result = $query->result_array();
      foreach ($result as $r) {
        $perfil = $r['profile'];
      }
      return $perfil; 
    }

    function get_city($mail) {
      $this->db->select('ciudad.idCiudad as ciudad');
      $this->db->from('ciudad');
      $this->db->join('users', 'users.idCiudadOpe = ciudad.idCiudad');
      $this->db->where('users.Email', $mail);
      $query = $this->db->get();      
      $result = $query->result_array();
      $city = "all";
      foreach ($result as $r) {
        $city = $r['ciudad'];
      }
      return $city;   
    }

    function get_area($mail) {
      $this->db->select('zona.idZona as zona');
      $this->db->from(' zona');
      $this->db->join('users', 'users.idZona = zona.idZona');
      $this->db->where('users.Email', $mail);
      $query = $this->db->get();      
      $result = $query->result_array();
      $area = "all";
      foreach ($result as $r) {
        $area = $r['zona'];
      }
      return $area;   
    }

    function set_user_status($usr, $val) {
      $data = array('Enable' => $val);

      $this->db->where('idUser', $usr);
      $this->db->update('users', $data);
    }



    function search ($data_in){
      $this->db->select(
        'users.idUser, 
        users.ci, 
        users.Nombre, 
        users.Apellido, 
        users.Email, 
        users.Password, 
        users.FechaIngreso, 
        users.Telefono, 
        users.TelfCelular, 
        users.Enable, 
        users.Observacion, 
        users.idCiudadOpe, 
        users.idZona, 
        profile.Descripcion as perfil'
      );

      $this->db->from('users');
      
      $this->db->join('profile', 'users.NivelAcceso = profile.idProfile');
    //  $this->db->order_by($order, "asc"); 
      // filters by city
      if($this->Account_Model->get_profile() == 3){
        $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());
        $this->db->where('users.NivelAcceso !=', 1);
        $this->db->where('users.NivelAcceso !=', 2);
      }
/*
      $data_in['dateStart'] = $this->input->post('dateStart');
      $data_in['dateFinish'] = $this->input->post('dateFinish');
      $data_in['name'] = $this->input->post('name');
      $data_in['city'] = $this->input->post('city');
      $data_in['area'] = $this->input->post('area');
      $data_in['profile'] = $this->input->post('profile');
      $data_in['order'] 
*/
      //$data_in['name'] = $this->input->post('name');
      if(isset($data_in['name']) AND $data_in['name'] != "" AND $data_in['name'] > 0)
        $this->db->like('users.Nombre', $data_in['name']);
      
      /*if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] > 0)
        $this->db->where('users.idCiudadOpe', $data_in['city']);
      if(isset($data_in['area']) && $data_in['area'] != "" && $data_in['area'] > 0)
        $this->db->where('users.idZona', $data_in['area']);
      */
        
      if(isset($data_in['city']) && $data_in['city'] != "" && $data_in['city'] != "all" && $data_in['city'] != "0"){
        $this->db->where('users.idCiudadOpe', $data_in['city']);
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
          $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());
      }
      if(isset($data_in['area']) && $data_in['area'] != "" && $data_in['area'] != "all" && $data_in['area'] != "0"){
        $this->db->where('users.idZona', $data_in['area']);
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $this->db->where('users.idZona', $this->Account_Model->get_area());
      }


      if(isset($data_in['profile']) && $data_in['profile'] != "" && $data_in['profile'] > 0)
        $this->db->where('profile.idProfile', $data_in['profile']);      
      if(isset($data_in['dateStart']) && $data_in['dateStart'] != "" && $data_in['dateStart'] > 0){
        $fecha = $data_in['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(users.FechaIngreso) >', $nuevafecha);
      }
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != "" && $data_in['dateFinish'] > 0){
        $fecha = $data_in['dateFinish'];
        $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
        $this->db->where('DATE(users.FechaIngreso) <', $nuevafecha2);
      }






      if(isset($data_in['name']) && $data_in['name'] != "")
        $this->db->like('users.Nombre',$data_in['name']);
      if(isset($data_in['order']) && $data_in['order'] != "")
        $this->db->order_by($data_in['order'], "asc");
      $query = $this->db->get();
      return $query->result();
    }
}
?>