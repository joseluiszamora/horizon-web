<?php

class Area_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();        
    }

    function report($idcity, $order) {
      $this->db->select(
        'zona.idZona, 
        zona.Estado, 
        zona.idCiudad, 
        zona.level, 
        zona.parent, 
        zona.Estado, 
        ciudad.NombreCiudad as ciudad,
        zona.Descripcion'
      );
      $this->db->from('zona');
      $this->db->join('ciudad', 'zona.idCiudad = ciudad.idCiudad' );

       // filters by city
      if(isset($idcity) AND $idcity != "" AND $idcity != "all" AND $idcity != "0")
        $this->db->where('zona.idCiudad', $idcity);

      $this->db->order_by($order, "asc"); 
      $query = $this->db->get();
      return $query->result();
    }

    function create($data) {
      if ($this->db->insert('zona', $data)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '32';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);
        return TRUE;
      }
      return FALSE;
    }  

    function update($data, $id) {
      $this->db->where('idZona', $id);
      if ($this->db->update('zona', $data)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '33';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);
        return TRUE;
      }
      return FALSE;                        
    }

    function delete($id) {
      if ($id != NULL) {
        $this->db->where('idZona', $id);
        $this->db->delete('zona');
      }
      return TRUE;
    }
 
    function get($id) {
      $query = $this->db->get_where('zona',array('idZona'=>$id));
      return $query->result();
    }

    // zona list
    function get_area_list($city, $level) {
      if ($city != "all"){
        //$this->db->where('idCiudad', $city);
      }
      $this->db->where('level', $level);
      $query = $this->db->get('zona');
      //echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
      //print_r($city);
      //print_r($query->result());
      return $query->result();
    }

    // get area dropdown
    function get_area($idcity="1") {
      
      /*if(isset($idcity) AND $idcity != "" AND $idcity != "all"){
        $this->db->where('idCiudad', $idcity);
      }elseif($this->Account_Model->get_city() != "all"){
        $this->db->where('idCiudad', $this->Account_Model->get_city());
      }*/
      if($this->Account_Model->get_city() != "all"){
        $this->db->where('idCiudad', $this->Account_Model->get_city());
      }
      
      $this->db->where('Estado', "1");
      $this->db->where('level', "0");
      $query = $this->db->get('zona');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Zona';
      foreach ($result as $r) {
        $dropdown[$r['idZona']] = $r['Descripcion'];
      }
      return $dropdown;
    }

    // get area name
    function get_area_name($id) {
      $var = "";
      $this->db->where('idZona', $id);
      $query = $this->db->get('zona');
      $result = $query->result_array();
      foreach ($result as $r) {
        $var = $r['Descripcion'];
      }
      return $var;
    }

    // get area name
    function get_city($id) {
      $this->db->where('idZona', $id);
      $query = $this->db->get('zona');
      $result = $query->result_array();
      foreach ($result as $r) {
        $var = $r['idCiudad'];
      }
      return $var;
    }

    function set_status($cli, $val) {
      $data = array('Estado' => $val);

      $this->db->where('idZona', $cli);
      $this->db->update('zona', $data);
    }

    function get_area_for_district($disctrict){
      $this->db->select('zona.idZona, zona.Descripcion');
      $this->db->from('zona');
      $this->db->join('barrio', 'zona.idZona = barrio.idZona');
      $this->db->where('barrio.idBarrio', $disctrict);
      $query = $this->db->get();
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Zona';
      foreach ($result as $r) {
        $dropdown[$r['idZona']] = $r['Descripcion'];
      }
      return $dropdown;
    }


    function get_one_area_for_one_district($disctrict){
      $this->db->select('zona.idZona');
      $this->db->from('zona');
      $this->db->join('barrio', 'zona.idZona = barrio.idZona');
      $this->db->where('barrio.idBarrio', $disctrict);
      $this->db->limit(1);
      $query = $this->db->get();
      return $query->result();
    }

    function get_subarea_for_area($area){
      $this->db->select('zona.idZona, zona.Descripcion');
      $this->db->from('zona');      
      $this->db->where('zona.level', '1');
      $this->db->where('zona.Estado', '1');
      $this->db->where('zona.parent', $area);
      $query = $this->db->get();
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Sub Zona';

      foreach ($result as $r) {
        $dropdown[$r['idZona']] = $r['Descripcion'];
      }
      return $dropdown;
    }

    function get_area_for_city($idcity) {
      $this->db->select('zona.idZona, zona.Descripcion');
      $this->db->from('zona');      
      $this->db->where('zona.level', '0');
      $this->db->where('zona.Estado', '1');

      if (isset($idcity) && ($idcity!="") && ($idcity!="all"))
        $this->db->where('zona.idCiudad', $idcity);
      $query = $this->db->get();
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Zona';
      foreach ($result as $r) {
        $dropdown[$r['idZona']] = $r['Descripcion'];
      }
      return $dropdown;
    }

    function get_sub_area_for_city($idcity) {
      $this->db->select('zona.idZona, zona.Descripcion');
      $this->db->from('zona');      
      $this->db->where('zona.level', '1');
      $this->db->where('zona.Estado', '1');
      if(isset($idcity) && $idcity != "all" && $idcity != ""){
        $this->db->where('zona.idCiudad', $idcity);
      }
      $query = $this->db->get();
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Sub Zona';
      foreach ($result as $r) {
        $dropdown[$r['idZona']] = $r['Descripcion'];
      }
      return $dropdown;
    }
}

?>