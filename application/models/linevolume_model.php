<?php

class Linevolume_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->model('District_Model');
    }

    function report() {
      $this->db->select('*');
      $this->db->from('line');
      $query = $this->db->get();
      return $query->result();
    }

    function report_android() {
      $this->db->select('*');
      $this->db->from('linevolume');
      $query = $this->db->get();
      return $query->result();
    }

    function create($data) {
      if ($this->db->insert('linevolume', $data)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '11';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idLineVolume', $id);
      if ($this->db->update('linevolume', $data)) {
        // Save log for this action
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '12';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }

    // get lines dropdown
    function get_lines() {
      $query = $this->db->get('line');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Línea';
      foreach ($result as $r) {
        $dropdown[$r['idLine']] = $r['Descripcion'];
      }
      return $dropdown;
    }

    // get volumes dropdown
    function get_volumes() {
      $query = $this->db->get('volume');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Volumen';
      foreach ($result as $r) {
        $dropdown[$r['idVolume']] = $r['Descripcion'];
      }
      return $dropdown;
    }

    // get volumes dropdown
    function get_linesvolumes($id=-1) {
      $this->db->select('');
      $this->db->from('linevolume');
      $this->db->join('volume', 'linevolume.idVolume = volume.idVolume');
      $this->db->where('linevolume.idLine', $id);
      $this->db->order_by("linevolume.idLine", "asc");
      $query = $this->db->get();
      $result = $query->result_array();
      
      $dropdown = array();
      $dropdown[0] = 'Seleccione Volumen';
      foreach ($result as $r) {
        $dropdown[$r['idLineVolume']] = $r['Descripcion'];
      }
      return $dropdown;
    }

    function get($id) {
      $query = $this->db->get_where('linevolume',array('idLineVolume'=>$id));
      return $query->result();
    }

    function set_client_status($cli, $val) {
      $data = array('Estado' => $val);

      $this->db->where('idCustomer', $cli);
      $this->db->update('Customer', $data);
    }
}

?>