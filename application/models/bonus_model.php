<?php

class Bonus_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  function report($datasearch) {
    $this->db->select(
      'bonus.idbonus,
      bonus.type,
      bonus.idLine,
      bonus.idProduct,
      bonus.cantidad,
      bonus.idProduct_bonus,
      bonus.cantidad_bonus,
      bonus.status,
      line.Descripcion as line,
      products.Nombre as nombreproduct,
      volume.Descripcion as volume'
    );
    $this->db->from('bonus');
    $this->db->join('products', 'bonus.idProduct = products.idProduct', 'left');
    $this->db->join('line', 'bonus.idLine = line.idLine', 'left');
    $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume', 'left');
    $this->db->join('volume', 'linevolume.idVolume = volume.idVolume', 'left');
    $this->db->where('bonus.status',"1");

    //$this->db->order_by("products.Nombre", "asc");
    $query = $this->db->get();
    return $query->result();
  }
  function get($id) {
    $query = $this->db->get_where('bonus',array('idbonus'=>$id));
    return $query->result();
  }

  function create($data_in) {
    if ($this->db->insert('bonus', $data_in)) {
      // Save log for this action
      $id = $this->db->insert_id();
      /*$data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data_log['idAction'] = '1';
      $data_log['idReferencia'] = $id;
      $data_log['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data_log);*/
      return TRUE;
    }
    return FALSE;
  }

  function update($data, $id) {
    $this->db->where('idbonus', $id);
    if ($this->db->update('bonus', $data)) {
      /*// Save log for this action
      $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data_log['idAction'] = '2';
      $data_log['idReferencia'] = $id;
      $data_log['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data_log);*/
      return TRUE;
    }
    return FALSE;
  }

  function delete($id) {
    $data_in['status'] = "2";
    $this->db->where('idbonus', $id);
    if ($this->db->update('bonus', $data_in)) {
      /*// Save log for this action
      $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data_log['idAction'] = '2';
      $data_log['idReferencia'] = $id;
      $data_log['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data_log);*/
      return TRUE;
    }
    return FALSE;
  }
}

?>