<?php

class Line_model extends CI_Model {

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
      $this->db->from('line');
      $query = $this->db->get();
      return $query->result();
    }

    function get_all_json() {
      $this->db->select('*');
      $this->db->from('line');
      $query = $this->db->get();
      return $query->result();
    }

    function create($data) {
      if ($this->db->insert('line', $data)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '9';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idLine', $id);
      if ($this->db->update('line', $data)) {
        // Save log for this action
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '10';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }

    function get_volumes($id) {
      $this->db->select('*');
      $this->db->from('volume');
      $this->db->join('linevolume', 'volume.idVolume = linevolume.idVolume');
      $this->db->where('idLine', $id);
      $query = $this->db->get();
      return $query->result();
    }

    // get Clients dropdown
    function get_clients() {
      $query = $this->db->get('Customer');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Cliente';
      foreach ($result as $r) {
        $dropdown[$r['idCustomer']] = $r['NombreTienda'];
      }
      return $dropdown;
    }

    function get($id) {
      $query = $this->db->get_where('line',array('idLine'=>$id));
      return $query->result();
    }

    function set_client_status($cli, $val) {
      $data = array('Estado' => $val);

      $this->db->where('idCustomer', $cli);
      $this->db->update('Customer', $data);
    }
}

?>