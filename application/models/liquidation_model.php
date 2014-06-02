<?php

class Liquidation_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  function create($data_in) {
    if ($this->db->insert('liquidacion', $data_in)) {

      // Save log for this action
      /*if ($data_in['Type'] == "P") {
        $data_log['idAction'] = '46';
      }else {
        $data_log['idAction'] = '48';
      }*/
      $id = $this->db->insert_id();
      /*$data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data_log['idReferencia'] = $id;
      $data_log['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data_log);*/
      return $id;
    }
    return null;
  }
}

?>