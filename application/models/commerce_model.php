<?php

class Commerce_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();        
    }

     function report() {
      $this->db->select(
        'comercio.idComercio, 
        comercio.Descripcion'
      );
      $this->db->from('comercio');      
      $query = $this->db->get();
      return $query->result();
    }

    function create($data_in) {
      if ($this->db->insert('comercio', $data_in)) {
        $id = $this->db->insert_id();
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '3';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idComercio', $id);
      if ($this->db->update('comercio', $data)) {
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '4';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;                        
    }

    function delete($id) {
      if ($id != NULL) {
        $this->db->where('idComercio', $id);
        $this->db->delete('comercio');
      }
      return TRUE;
    }
 
    function get($id) {
      $query = $this->db->get_where('comercio',array('idComercio'=>$id));
      return $query->result();
    }

    // get commerce dropdown
    function get_commerce() {
      $query = $this->db->get('comercio');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Tipo de comercio';
      foreach ($result as $r) {
        $dropdown[$r['idComercio']] = $r['Descripcion'];
      }
      return $dropdown;
    }
}

?>