<?php

class Permission_model extends CI_Model {

  function __construct() {
      parent::__construct();
      $this->load->database();
  }

  function report_modules() {
    $this->db->select(
      'modulos.idModulo,
      modulos.Descripcion'
    );
    $this->db->from('modulos');
    $query = $this->db->get();
    return $query->result();
  }

  // check if this profile has this permission (by Id)
  function check_access($profile, $module) {
    $this->db->where('idProfile', $profile);
    $this->db->where('idModulo', $module);
    $query = $this->db->get('modulosprofile');
    if ($query->num_rows() > 0) {
      return TRUE;
    }
    return FALSE;
  }

  // check if this profile has this permission (by Name)
  function check_if_access($profile, $module_name) {
    $query = $this->db->get_where('modulos', array('nombre' => $module_name));
    $result = $query->result_array();
    $module = "";

    foreach ($result as $r) {
      $module = $r['idModulo'];
    }

    $this->db->where('idProfile', $profile);
    $this->db->where('idModulo', $module);
    $query = $this->db->get('modulosprofile');
    if ($query->num_rows() > 0) {
      return TRUE;
    }
    return FALSE;
  }

  // activate permission
  function activate($profile, $module) {
    $data_per['idProfile'] = $profile;
    $data_per['idModulo'] = $module;
    $this->db->insert('modulosprofile', $data_per);

    // Save log for this action
    $id = $this->db->insert_id();
    $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
    $data['idAction'] = '14';
    $data['idReferencia'] = $id;
    $data['FechaHora'] = date("y-m-d, g:i");
    $this->Log_Model->create($data);
  }

  // deactivate permission
  function deactivate($profile, $module) {
    $this->db->where('idProfile', $profile);
    $this->db->where('idModulo', $module);
    $this->db->delete('modulosprofile');

    // Save log for this action
    $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
    $data['idAction'] = '14';
    $data['idReferencia'] = $module;
    $data['FechaHora'] = date("y-m-d, g:i");
    $this->Log_Model->create($data);
  }
}

?>