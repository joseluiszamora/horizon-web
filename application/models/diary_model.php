<?php

class Diary_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
    }

    function create($data_in) {
      if ($this->db->insert('daily', $data_in)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '1';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }

    // get all diaries
    function get_diaries() {
      $query = $this->db->get('daily');

      return $query->result();
    }
/*
    function report() {
      $this->db->select(
        'ciudad.idCiudad, 
        ciudad.NombreCiudad'
      );
      $this->db->from('ciudad');
      $query = $this->db->get();
      return $query->result();
    }

    function get($id) {
      $query = $this->db->get_where('ciudad',array('idCiudad'=>$id));
      return $query->result();
    }

    function update($data, $id) {
      $this->db->where('idCiudad', $id);
      if ($this->db->update('ciudad', $data)) {
        // Save log for this action
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '2';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;                        
    }

    function create($data_in) {
      if ($this->db->insert('ciudad', $data_in)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '1';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }

    // get user category/profile list
    function get_cities($idprofile) {
      $dropdown = array();
      $dropdown[0] = 'Seleccione Ciudad';

      if ($idprofile == 3) {
        $this->db->where('idCiudad', $this->session->userdata('city'));
        $query = $this->db->get('ciudad');
        $result = $query->result_array();
        foreach ($result as $r) {
          $dropdown[$r['idCiudad']] = $r['NombreCiudad'];
        }
      }else{
        $query = $this->db->get('ciudad');
        $result = $query->result_array();
        foreach ($result as $r) {
          $dropdown[$r['idCiudad']] = $r['NombreCiudad'];
        }
      }
      return $dropdown;
    }

     // get user category/profile list
    function get_city($id) {
      $var = "";
      $this->db->where('idCiudad', $id);
      $query = $this->db->get('ciudad');
      $result = $query->result_array();
      foreach ($result as $r) {
        $var = $r['NombreCiudad'];
      }
      return $var;
    }

    */
}

?>