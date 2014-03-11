<?php

class District_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
    }

    function report() {
      $this->db->select(
        'barrio.idBarrio, 
        barrio.Descripcion,
        ciudad.NombreCiudad as ciudad,
        zona.Descripcion as Zona'
      );
      $this->db->from('barrio');
      $this->db->join('zona', 'barrio.idZona = zona.idZona');
      $this->db->join('ciudad', 'zona.idCiudad = ciudad.idCiudad' );

      if($this->Account_Model->get_city() != "all")
        $this->db->where('zona.idCiudad', $this->Account_Model->get_city());
      $query = $this->db->get();
      return $query->result();
    }

    function create($data_in) {
      if ($this->db->insert('barrio', $data_in)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '40';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idBarrio', $id);
      if ($this->db->update('barrio', $data)) {
        // Save log for this action
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '41';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
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
 
    function get($id) {
      $query = $this->db->get_where('barrio',array('idBarrio'=>$id));
      return $query->result();
    }

    // districts dropdown
    function get_disctricts() {
      $query = $this->db->get('barrio');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Barrio';
      foreach ($result as $r) {
        $dropdown[$r['idBarrio']] = $r['Descripcion'];
      }
      return $dropdown;
    }


    // get volumes dropdown
    function get_disctricts_for_city($city=-1) {
      $this->db->select('barrio.idBarrio, barrio.Descripcion');
      $this->db->from('barrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');
      $this->db->join('ciudad', 'ciudad.idCiudad = zona.idCiudad');
      $this->db->where('ciudad.idCiudad', $city);
      $query = $this->db->get();
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Barrio';
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

    function search ($data_in){
      $this->db->select(
        'barrio.idBarrio, 
        barrio.Descripcion,
        ciudad.NombreCiudad as ciudad,
        zona.Descripcion as Zona'
      );
      $this->db->from('barrio');
      $this->db->join('zona', 'barrio.idZona = zona.idZona', 'left');
      $this->db->join('ciudad', 'zona.idCiudad = ciudad.idCiudad' , 'left');

      if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != "0" AND $data_in['city'] != "all") 
        $this->db->where('ciudad.idCiudad', $data_in['city']);
      
      if(isset($data_in['area']) && $data_in['area'] != "" AND $data_in['area'] != "0" AND $data_in['area'] != "all") 
        $this->db->where('zona.idZona', $data_in['area']);

      //if($this->Account_Model->get_city() != "all")
      //  $this->db->where('zona.idCiudad', $this->Account_Model->get_city());
      
      $this->db->order_by('barrio.Descripcion', "asc");
      $query = $this->db->get();
      return $query->result();
    }
}

?>