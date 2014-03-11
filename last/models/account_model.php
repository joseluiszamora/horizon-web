<?php

class Account_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->library('session');
      $this->load->library('encrypt');
    }

    /* get account info */
    function get_email() {
      return $this->session->userdata('email');
    }
    function get_profile() {
      return $this->session->userdata('profile');
    }
    function get_city() {
      return $this->session->userdata('city');
    }
    function get_area() {
      return $this->session->userdata('area');
    }
    function get_user_id($mail) {
      $this->db->where('Email', $mail);
      $this->db->where('Enable', '1');
      $query = $this->db->get('users');
      $result = $query->result_array();
      foreach ($result as $r) {
        $id = $r['idUser'];
      }
      return $id;

    }

    function get_user_by_email($mail) {
      $this->db->where('Email', $mail);
      $this->db->where('Enable', '1');
      $this->db->limit(1);
      $query = $this->db->get('users');
      $result = $query->result();
      if (count($result)==0) {
        return FALSE;
      } else {
        return $result[0];
      }
    }

    function get_user($mail) {
      $this->db->where('Email', $mail);
      $this->db->where('Enable', '1');
      $query = $this->db->get('users');
      return $query->result();

    }
    /* End get account info */

    function create($data_in) {
      if($data_in['NivelAcceso'] == '1') {
        $data_in['idCiudadOpe'] = '6';
        $data_in['idZona'] = '17';
      }




      $data_in['Password'] = $this->encrypt->sha1($data_in['Password']);
      if ($this->db->insert('users', $data_in)) {
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
        $data['Password'] =  $this->encrypt->sha1($data['Password']);
        $this->db->where('idUser', $id);
        if ($this->db->update('users', $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function changePassword($id, $password) {

        $data = array(
            'pass' => $this->encrypt->sha1($password)
        );

        $this->db->where('cUserId', $id);
        $this->db->update('usuarios', $data);
    }

    function login($email, $profile, $city, $area) {
      $data = array('email' => $email, 'profile' => $profile, 'city' => $city, 'area' => $area, 'logged_in' => TRUE);
      $this->session->set_userdata($data);
    }

    function logged_in() {
      if ($this->session->userdata('logged_in') == TRUE) {
        return TRUE;
      }
      return FALSE;
    }

    function user_exists($var) {
        $this->db->where('Email', $var);
        $this->db->where('Enable', '1');
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function password_check($mail, $pass) {
      $this->db->where('Email', $mail);
      $this->db->where('Enable', '1');
      $query = $this->db->get('users');

      if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
          if ($row->Password == $this->encrypt->sha1($pass)) {
            return TRUE;
          } else {
            echo "JAMAS";
          }
        }
      } else {
        return FALSE;
      }
    }

    function user_exist_check($mail, $pass) {
      $this->db->where('Email', $mail);
      $this->db->where('Enable', '1');
      $query = $this->db->get('users');

      if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
          if ($row->Password == $this->encrypt->sha1($pass)) {
            return "OK";
          } else {
            return "PASS";
          }
        }
      } else {
        return "MAIL";
      }
    }
}
?>