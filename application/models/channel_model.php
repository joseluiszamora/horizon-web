<?php

class Channel_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // get user category/profile list
    function get_channels() {
      $query = $this->db->get('channel');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Canal';
      foreach ($result as $r) {
        $dropdown[$r['idChannel']] = $r['Descripcion'];
      }
      return $dropdown;
    }

    function get($id) {
      $query = $this->db->get_where('channel',array('idChannel'=>$id));
      return $query->result();
    }
}

?>