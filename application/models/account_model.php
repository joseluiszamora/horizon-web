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
      //$this->db->where('Enable', '1');
      $query = $this->db->get('users');
      $result = $query->result_array();
      foreach ($result as $r) {
        $id = $r['idUser'];
      }
      return $id;

    }


    function get_profile_by_mail($mail) {
      $this->db->where('Email', $mail);
      //$this->db->where('Enable', '1');
      $query = $this->db->get('users');
      $result = $query->result_array();
      foreach ($result as $r) {
        $profile = $r['NivelAcceso'];
      }
      return $profile;

    }


    function get_city_by_mail($mail) {
      $this->db->where('Email', $mail);
      //$this->db->where('Enable', '1');
      $query = $this->db->get('users');
      $result = $query->result_array();
      foreach ($result as $r) {
        $city = $r['idCiudadOpe'];
      }
      return $city;
    }

    function get_area_by_mail($mail) {
      $this->db->where('Email', $mail);
      //$this->db->where('Enable', '1');
      $query = $this->db->get('users');
      $result = $query->result_array();
      foreach ($result as $r) {
        $area = $r['idZona'];
      }
      return $area;
    }

    function get_user_by_email($mail) {
      $this->db->where('Email', $mail);
      //$this->db->where('Enable', '1');
      $this->db->limit(1);
      $query = $this->db->get('users');
      $result = $query->result();
      if (count($result)==0) {
        return FALSE;
      } else {
        return $result[0];
      }
    }

    function get_initials_by_email($mail) {
      $user = $this->get_user_by_email($mail);
      $code = substr($user->Nombre, 0, 1)."".substr($user->Apellido, 0, 1)."".$user->idZona;
      return $code;
    }

    function get_user($mail) {
      $this->db->where('Email', $mail);
      //$this->db->where('Enable', '1');
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
        // Save log for this action
        $id = $this->db->insert_id();
        $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data['idAction'] = '25';
        $data['idReferencia'] = $id;
        $data['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data);
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
        //$data['Password'] =  $this->encrypt->sha1($data['Password']);
        $this->db->where('idUser', $id);
        if ($this->db->update('users', $data)) {
          // Save log for this action
          $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
          $datalog['idAction'] = '26';
          $datalog['idReferencia'] = $id;
          $datalog['FechaHora'] = date("y-m-d, g:i");
          $this->Log_Model->create($datalog);
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

      // log info
      $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $datalog['idAction'] = '44';
      $datalog['idReferencia'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $datalog['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($datalog);
    }

    function logged_in() {
      if ($this->session->userdata('logged_in') == TRUE) {
        return TRUE;
      }
      return FALSE;
    }

    function logout(){
      // log info
      $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $datalog['idAction'] = '45';
      $datalog['idReferencia'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $datalog['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($datalog);

      // session destroy
      $this->session->sess_destroy();
      return TRUE;
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
    function web_access_check($var) {
      $this->db->where('Email', $var);
      $this->db->where('Web', '1');
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

    function check_if_is_valid_user($mail) {
      $this->db->where('Email', $mail);
      $this->db->where('Enable', '1');
      $query = $this->db->get('users');

      if ($query->num_rows() > 0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }    
}
?>