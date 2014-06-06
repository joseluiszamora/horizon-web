<?php

class Liquidation_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  function create($data_in) {
    if ($this->db->insert('liquidacion', $data_in)) {
      $id = $this->db->insert_id();
      return $id;
    }
  }

  function report($status="active", $mark="all") {
    $this->db->select(
      'liquidacion.idLiquidacion, 
      liquidacion.fechaRegistro, 
      liquidacion.horaRegistro, 
      liquidacion.idUser, 
      liquidacion.ruta, 
      liquidacion.detalle,
      liquidacion.fechaFin,
      liquidacion.horaFin,
      liquidacion.mark,
      liquidacion.status'
    );
    $this->db->from('liquidacion');

    if(isset($status) AND $status != ""){
      $this->db->where('liquidacion.status', $status);
    }
    if(isset($mark) AND $mark != "all"){
      $this->db->where('liquidacion.mark', $mark);
    }

    $query = $this->db->get();
    return $query->result();
  }

  function count($mark="creado"){
    if (isset($mark) && $mark != "all" ) {
      $this->db->like('mark', $mark);
    }
    $this->db->from('liquidacion');
    return $this->db->count_all_results();
  }

  function create_detail($data) {
    if ($this->db->insert('detalleliquidacion', $data)) {
      return TRUE;
    }
    return FALSE;
  }

  function update($data, $id) {
    $this->db->where('idLiquidacion', $id);

    if ($this->db->update('liquidacion', $data)) {
      return TRUE;
    }
    return FALSE;
  }
}

?>