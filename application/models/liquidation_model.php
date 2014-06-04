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

  function report($status="active", $mark="creado") {
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
    if(isset($mark) AND $mark != ""){
      $this->db->where('liquidacion.mark', $mark);
    }

    $query = $this->db->get();
    return $query->result();
  }
}

?>