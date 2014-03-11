<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_access {
  public function __construct() {
    $CI =& get_instance();    
    $CI->load->library('session');   
  }

  public function sessi() {
    //return $this->session->userdata('profile');
  }

  public function is_admin($var) {
    if ($var == '1') {
      return TRUE;
    }
    return FALSE;
  }

  public function is_supervisor($var) {
    if ($var == '2') {
      return TRUE;
    }
    return FALSE;
  }

  public function is_preventista($var) {
    if ($var == '3') {
      return TRUE;
    }
    return FALSE;
  }
  
}