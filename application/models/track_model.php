<?php

class Track_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
    }

    function create($data_in) {
      if ($this->db->insert('tracker', $data_in)) {
        return TRUE;
      }
      return FALSE;
    }

    function report() {
      $this->db->select('*');
      $this->db->from('tracker');
      $query = $this->db->get();
      return $query->result();
    }

    function search($search) {
      $querystring = "
      SELECT * FROM tracker ";

      $querystring .= 'WHERE idNum != 0';

      if(isset($search['searchuser']) && $search['searchuser'] != ""){
        $querystring .= " AND Email = '".$search['searchuser']."'";
      }
      if(isset($search['dateStart']) && $search['dateStart'] != ""){
        $querystring .= " AND Fecha = '".$search['dateStart']."'";
      }
      if(isset($search['startHour']) && $search['startHour'] != ""){
        $querystring .= " AND Hora > '".$search['startHour']."'";
      }
      if(isset($search['startFinish']) && $search['startFinish'] != ""){
        $querystring .= " AND Hora <  '".$search['startFinish']."'";
      }

      $querystring .= " ORDER BY Fecha DESC, Hora DESC LIMIT 300 ";

      //print_r("OOOOOOOOOOOOO <br>".$querystring."<br>AAAAAAAAAAAAAAAAAAAA");
      $query = $this->db->query($querystring);
      return $query->result();


    }

    function last($search) {
      $querystring = "
      SELECT * FROM tracker ";

      $querystring .= 'WHERE idNum != 0';

      if(isset($search['searchuser']) && $search['searchuser'] != ""){
        $querystring .= " AND Email = '".$search['searchuser']."'";
      }

      $querystring .= " ORDER BY Fecha DESC, Hora DESC LIMIT 5";
      $query = $this->db->query($querystring);
      return $query->result();
    }
}

?>
