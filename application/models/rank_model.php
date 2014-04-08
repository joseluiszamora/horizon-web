<?php

class Rank_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  function report() {
    $this->db->select('*');
    $this->db->from('rank');
    $query = $this->db->get();
    return $query->result();
  }

  function create($data) {
    if ($this->db->insert('rank', $data)) {
      $id = $this->db->insert_id();
      // Save log for this action
      $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data_log['idAction'] = '50';
      $data_log['idReferencia'] = $id;
      $data_log['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data_log);
      return TRUE;
    }
    return FALSE;
  }

  // get allranksin dropdown
  function get_ranks() {
    $dropdown = array();
    $this->db->order_by('Limit', "asc");
    $query = $this->db->get('rank');
    $result = $query->result_array();
    foreach ($result as $r) {
      $dropdown[$r['idrank']] = $r['Limit'];
    }
    return $dropdown;
  }

  function delete($id) {
    if ($id != NULL) {
      $this->db->where('idrank', $id);
      $this->db->delete('rank');
    }
    return TRUE;
  }

  function update($data, $id) {
    $this->db->where('idrank', $id);
    if ($this->db->update('rank', $data)) {
      return TRUE;
    }
    return FALSE;
  }
/*
  function report_from_lines() {
    $this->db->select('*');
    $this->db->from('volume');
    $this->db->join('linevolume', 'volume.idVolume = linevolume.idVolume');
    $query = $this->db->get();
    return $query->result();
  }

  function report_android() {
    $this->db->select('*');
    $this->db->from('volume');
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
    $query = $this->db->get_where('volume',array('idVolume'=>$id));
    return $query->result();
  }

  function set_client_status($cli, $val) {
    $data = array('Estado' => $val);

    $this->db->where('idCustomer', $cli);
    $this->db->update('Customer', $data);
  }

  */
}
?>