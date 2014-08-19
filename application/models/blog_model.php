<?php

class Blog_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function report() {
      $this->db->select(
        'blog.idBlog, 
        blog.idTransaction, 
        blog.idUser, 
        blog.Operation, 
        blog.FechaHoraInicio, 
        blog.FechaHoraFin, 
        blog.CoordenadaInicio, 
        blog.CoordenadaFin'
      );
      $this->db->from('blog');
      $query = $this->db->get();
      return $query->result();
    }

    function create($data) {
      if ($this->db->insert('blog', $data)) {
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idBlog', $id);
      if ($this->db->update('blog', $data)) {
        return TRUE;
      }
      return FALSE;
    }

    function delete($id) {
      if ($id != NULL) {
        $this->db->where('idBlog', $id);
        $this->db->delete('blog');
      }
      return TRUE;
    }
 
    function get($id) {
      $query = $this->db->get_where('blog',array('idBlog'=>$id));
      return $query->result();
    }
    
    function get_by_transaction($id) {
      $query = $this->db->get_where('blog',array('idTransaction'=>$id));
      return $query->result();
    }

    function get_by_transaction_status($id, $operation) {
      $query = $this->db->get_where('blog',array('idTransaction'=>$id, 'Operation'=>$operation));
      return $query->result();
    }

    // verifica si la transaccion ya existe
    function check_if_exist_transaction($idUser, $operation, $FechaHoraInicio, $FechaHoraFin) {
      
      $this->db->where('idUser', $idUser);
      $this->db->where('Operation', $operation);
      $this->db->where('FechaHoraInicio', $FechaHoraInicio); 
      $this->db->where('FechaHoraFin', $FechaHoraFin);
            
      $query = $this->db->get('blog');

      if ($query->num_rows() > 0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}
?>