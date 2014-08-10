<?php

class Routes_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
    }

//idprogrutas idUser fecha idZona

    function report() {
      $this->db->select(
        'progrutas.idprogrutas,
        progrutas.fecha,
        users.idUser,
        users.Nombre,
        users.Apellido,
        zona.idZona,
        zona.Descripcion'
      );
      $this->db->from('progrutas');
      $this->db->join('users', 'users.idUser = progrutas.idUser');
      $this->db->join('zona', 'zona.idZona = progrutas.idZona');
      $query = $this->db->get();
      return $query->result();
    }

    function get($id) {
      $this->db->select(
        'progrutas.idprogrutas,
        progrutas.fecha,
        users.idUser,
        users.Nombre,
        users.Apellido,
        zona.idZona,
        zona.Descripcion'
      );
      $this->db->from('progrutas');
      $this->db->join('users', 'users.idUser = progrutas.idUser');
      $this->db->join('zona', 'zona.idZona = progrutas.idZona');
      $this->db->where('progrutas.idprogrutas', $id);
      $query = $this->db->get();

      return $query->result();
    }

    // get route for parameters
    function get_route($user, $date) {
      $this->db->select(
        'progrutas.idprogrutas,
        progrutas.fecha,
        progrutas.idZona,
        progrutas.idUser'
      );

      $this->db->from('progrutas');
      $this->db->where('progrutas.idUser', $user);
      $this->db->where('progrutas.fecha', $date);

      if ($this->db->count_all_results() > 0) {
        //$query = $this->db->get();
        //return $query->result();
        $this->db->select(
          'progrutas.idprogrutas,
          progrutas.fecha,
          progrutas.idZona,
          progrutas.idUser'
        );

        $this->db->from('progrutas');
        $this->db->where('progrutas.idUser', $user);
        $this->db->where('progrutas.fecha', $date);
        
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $r) {
          $val = $r['idZona'];
        }
        return $val;
      }else{
        return 0;
      }
      //return $query->result();
    }

    function get_dates_and_zones() {
      $this->db->select(
        'progrutas.idprogrutas,
        progrutas.fecha,
        users.idUser,
        users.Nombre,
        users.Apellido,
        zona.idZona,
        zona.Descripcion'
      );
      $this->db->from('progrutas');
      $this->db->join('users', 'users.idUser = progrutas.idUser');
      $this->db->join('zona', 'zona.idZona = progrutas.idZona');
      //$this->db->where('users.idUser', $id);
      $query = $this->db->get();

      return $query->result();
    }
/*
    function update($data, $id) {
      $this->db->where('idCiudad', $id);
      if ($this->db->update('ciudad', $data)) {
        // Save log for this action
        $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data_log['idAction'] = '2';
        $data_log['idReferencia'] = $id;
        $data_log['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data_log);
        return TRUE;
      }
      return FALSE;
    }
*/
    function create($data_in) {
      if ($this->db->insert('progrutas', $data_in)) {
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
/*
    // get user category/profile list
    function get_cities($idprofile) {
      $dropdown = array();
      $dropdown[0] = 'Seleccione Ciudad';

      if ($idprofile == 3) {
        $this->db->where('idCiudad', $this->session->userdata('city'));
        $query = $this->db->get('ciudad');
        $result = $query->result_array();
        foreach ($result as $r) {
          $dropdown[$r['idCiudad']] = $r['NombreCiudad'];
        }
      }else{
        $query = $this->db->get('ciudad');
        $result = $query->result_array();
        foreach ($result as $r) {
          $dropdown[$r['idCiudad']] = $r['NombreCiudad'];
        }
      }
      return $dropdown;
    }

     // get user category/profile list
    function get_city($id) {
      $var = "";
      $this->db->where('idCiudad', $id);
      $query = $this->db->get('ciudad');
      $result = $query->result_array();
      foreach ($result as $r) {
        $var = $r['NombreCiudad'];
      }
      return $var;
    }
    */
}
?>