<?php

class Log_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();        
  }

  function create($datalog) {
    if ($this->db->insert('log', $datalog)) {
      return TRUE;
    }
    return FALSE;
  }
}
?>