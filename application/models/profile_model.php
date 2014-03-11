<?php

class Profile_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
    }

    function report() {
      $this->db->select(
        'profile.idProfile, 
        profile.Descripcion'
      );
      $this->db->from('profile');      
      $query = $this->db->get();
      return $query->result();
    }

    function get($id) {
      $query = $this->db->get_where('profile',array('idProfile'=>$id));
      return $query->result();
    }

    function get_name($id) {
      $this->db->where('idProfile', $id);
      $query = $this->db->get('profile');
      $result = $query->result_array();
      foreach ($result as $r) {
        $name = $r['Descripcion'];
      }
      return $name;
    }

    function get_profiles($profile) {
      $query = $this->db->get('profile');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Perfil';
      foreach ($result as $r) {
        if($r['idProfile'] > $profile)
          $dropdown[$r['idProfile']] = $r['Descripcion'];
      }
      return $dropdown;
    }
/*
    function create($data_in) {
      if ($this->db->insert('barrio', $data_in)) {
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idBarrio', $id);
      if ($this->db->update('barrio', $data)) {
        return TRUE;
      }
      return FALSE;                        
    }

    function delete($id) {
      if ($id != NULL) {
        $this->db->where('idBarrio', $id);
        $this->db->delete('barrio');
      }
      return TRUE;
    }

    // districts dropdown
    function get_disctricts() {
      $query = $this->db->get('barrio');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione barrio';
      foreach ($result as $r) {
        $dropdown[$r['idBarrio']] = $r['Descripcion'];
      }
      return $dropdown;
    }

    // districts list
    function get_disctrict_list() {
      $query = $this->db->get('barrio');
      return $query->result();
    }

     // get the area code for district
    function get_area_code($id) {
      $query = $this->db->get_where('barrio',array('idBarrio'=>$id));
      $result = $query->result_array();
      foreach ($result as $r) {
        $area = $r['idZona'];
      }
      return $area;
    }
    */
}

?>