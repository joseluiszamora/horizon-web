<?php

class Diary_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  function create($data_in) {
    if ($this->db->insert('daily', $data_in)) {
      // Save log for this action
      $id = $this->db->insert_id();
      $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data_log['idAction'] = '1';
      $data_log['idReferencia'] = $id;
      $data_log['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data_log);
      return TRUE;
    }
    return FALSE;
  }

  function get($id) {
    $query = $this->db->get_where('daily',array('iddiario'=>$id));
    return $query->result();
  }

  // get all diaries
  function get_diaries() {
    $this->db->select(
      'daily.iddiario,
      daily.FechaRegistro,
      daily.FechaTransaction,
      daily.idUser,
      daily.idUserSupervisor,
      daily.idTransaction,
      daily.NumVoucher,
      daily.idCustomer,
      daily.Type,
      daily.Monto,
      daily.Estado,
      daily.Detalle,
      customer.idCustomer,
      customer.CodeCustomer as code,
      customer.NombreTienda as custname,
      customer.Direccion as custaddress,
      users.Email as customer'
    );

    $this->db->from('daily');
    $this->db->join('customer', 'daily.idCustomer = customer.idCustomer');
    $this->db->join('users', 'daily.idUser = users.idUser');
    $this->db->where('daily.Type','P');
    $this->db->where('daily.Estado','1');
    $this->db->group_by('daily.NumVoucher'); 
    $this->db->group_by('daily.idCustomer'); 
    $this->db->order_by('daily.iddiario', "asc");

    $query = $this->db->get();
    return $query->result();
    /*$querystring = "
      SELECT 
        daily.iddiario,
        daily.FechaRegistro,
        daily.FechaTransaction,
        daily.idUser,
        daily.idUserSupervisor,
        daily.idTransaction,
        daily.NumVoucher,
        daily.idCustomer,
        daily.Type,
        daily.Monto,
        daily.Estado,
        daily.Detalle,
        customer.idCustomer,
        customer.CodeCustomer as code,
        customer.NombreTienda as custname,
        users.Email as customer
      FROM daily, customer, users
      WHERE daily.idCustomer = customer.idCustomer
      AND daily.idUser = users.idUser
      AND daily.Type = 'P'
      AND daily.Estado = 1
      GROUP BY daily.NumVoucher, daily.idCustomer
      ORDER BY daily.iddiario asc
    ";

    $query = $this->db->query($querystring);

    return $query->result();*/
  }

  // get all diaries
  function get_diaries_by_params($voucher, $customer, $type) {
    $this->db->select( '*' );
    $this->db->from('daily');
    $this->db->where('NumVoucher', $voucher);
    //$this->db->where('idCustomer', $customer);
    $this->db->where('Type', $type);

    $query = $this->db->get();
    return $query->result();
  }


/*
iddiario
FechaRegistro
FechaTransaction
idUser
idUserSupervisor
idTransaction
NumVoucher
idCustomer
Type
Monto
Estado
Detalle
*/
  function get_balance() {
    $querystring = '
      SELECT NumVoucher, SUM(Monto) as total
      FROM daily
      WHERE Type = "C"
      GROUP BY NumVoucher
    ';
    $query = $this->db->query($querystring);
    return $query->result();
  }

  function getpays($data_in){
    $querystring = '
      SELECT * 
      FROM daily
      WHERE NumVoucher = "'.$data_in['voucher'].'"
      AND Type = "C"
    ';
    $query = $this->db->query($querystring);
    return $query->result();
  }

/*
  // monto maximo para realizar prestamos
  function get_loan_limit($idclient) {
    $this->db->select(
      'daily.iddiario,
      daily.FechaRegistro,
      daily.FechaTransaction,
      daily.idUser,
      daily.idUserSupervisor,
      daily.idTransaction,
      daily.NumVoucher,
      daily.idCustomer,
      daily.Type,
      daily.Monto,
      daily.Estado,
      daily.Detalle,
      customer.idCustomer,
      customer.CodeCustomer as code,
      customer.NombreTienda as custname,
      customer.Direccion as custaddress
    ');

    $this->db->from('daily');
    $this->db->join('customer', 'daily.idCustomer = customer.idCustomer');
    $this->db->where('daily.Type','P');
    $this->db->where('daily.Estado','1');
    $this->db->group_by('daily.NumVoucher'); 
    $this->db->group_by('daily.idCustomer'); 
    $this->db->order_by('daily.iddiario', "asc");

//    $query = $this->db->get();
//    return $query->result();



    $query = $this->db->get();
    $dropdown = array();
    $dropdown[0] = 'Seleccione Usuario';

    $result = $query->result_array();
    foreach ($result as $r) {
      $dropdown[$r['idUser']] = $r['Email'];
    }

    return($dropdown);
  }*/

  function search ($data_in){
    $this->db->select( 'daily.iddiario,
    daily.FechaRegistro,
    daily.FechaTransaction,
    daily.idUser,
    daily.idUserSupervisor,
    daily.idTransaction,
    daily.NumVoucher,
    daily.idCustomer,
    daily.Type,
    daily.Monto,
    daily.Estado,
    daily.Detalle,
    customer.idCustomer,
    customer.CodeCustomer as code,
    customer.NombreTienda as custname,
    customer.Direccion as custaddress,
    users.Email as customer' );
    $this->db->from('daily');
    $this->db->join('customer', 'daily.idCustomer = customer.idCustomer');
    $this->db->join('users', 'daily.idUser = users.idUser');
    $this->db->where('Type','P');

    if(isset($data_in['status']) && $data_in['status'] != ""){
      $this->db->where('daily.Estado', $data_in['status']);
    }
    if(isset($data_in['distributor']) && $data_in['distributor'] != "" && $data_in['distributor'] != "0"){
      $this->db->where('daily.idUser',$data_in['distributor']);
    }
    if(isset($data_in['dateStart']) && $data_in['dateStart'] != ""){
      $fecha = $data_in['dateStart'];
      $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
      $nuevafecha = date ( 'y-m-d' , $nuevafecha );
      $this->db->where('DATE(daily.FechaTransaction) >', $nuevafecha);
    }
    if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != ""){
      $fecha = $data_in['dateFinish'];
      $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
      $nuevafecha2 = date ( 'y-m-d' , $nuevafecha2 );
      $this->db->where('DATE(daily.FechaTransaction) <', $nuevafecha2);
    }

    $this->db->group_by('daily.NumVoucher'); 
    $this->db->group_by('daily.idCustomer'); 
    $this->db->order_by('daily.iddiario', "asc");
    $query = $this->db->get();
    return $query->result();
  }




  function ammounts_search($data_in){
    $this->db->select( '
      SUM(daily.Monto) as saldo
    ' );
    $this->db->from('daily');

    if(isset($data_in['status']) && $data_in['status'] != ""){
      $this->db->where('daily.Type', $data_in['type']);
    }
    if(isset($data_in['status']) && $data_in['status'] != ""){
      $this->db->where('daily.Estado', $data_in['status']);
    }
    if(isset($data_in['distributor']) && $data_in['distributor'] != "" && $data_in['distributor'] != "0"){
      $this->db->where('daily.idUser',$data_in['distributor']);
    }
    if(isset($data_in['dateStart']) && $data_in['dateStart'] != ""){
      $fecha = $data_in['dateStart'];
      $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
      $nuevafecha = date ( 'y-m-d' , $nuevafecha );
      $this->db->where('DATE(daily.FechaTransaction) >', $nuevafecha);
    }
    if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != ""){
      $fecha = $data_in['dateFinish'];
      $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
      $nuevafecha2 = date ( 'y-m-d' , $nuevafecha2 );
      $this->db->where('DATE(daily.FechaTransaction) <', $nuevafecha2);
    }

    $query = $this->db->get();
    return $query->result();
  }


  /*function search_sum_ammounts ($data_in){
    $this->db->select( 'daily.iddiario,
    SUM(daily.Monto) as monto' );
    $this->db->from('daily');
    $this->db->join('customer', 'daily.idCustomer = customer.idCustomer');
    $this->db->join('users', 'daily.idUser = users.idUser');
    $this->db->where('Type','P');

    if(isset($data_in['status']) && $data_in['status'] != ""){
      $this->db->where('daily.Estado', $data_in['status']);
    }
    if(isset($data_in['distributor']) && $data_in['distributor'] != "" && $data_in['distributor'] != "0"){
      $this->db->where('daily.idUser',$data_in['distributor']);
    }
    if(isset($data_in['dateStart']) && $data_in['dateStart'] != ""){
      $fecha = $data_in['dateStart'];
      $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
      $nuevafecha = date ( 'y-m-d' , $nuevafecha );
      $this->db->where('DATE(daily.FechaTransaction) >', $nuevafecha);
    }
    if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != ""){
      $fecha = $data_in['dateFinish'];
      $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
      $nuevafecha2 = date ( 'y-m-d' , $nuevafecha2 );
      $this->db->where('DATE(daily.FechaTransaction) <', $nuevafecha2);
    }

    $this->db->group_by('daily.NumVoucher'); 
    $this->db->group_by('daily.idCustomer'); 
    $this->db->order_by('daily.iddiario', "asc");
    $query = $this->db->get();
    return $query->result();
  }*/

  function roundnumber ($numero, $decimales) {
    //$factor = pow(10, $decimales);
    //return (round($numero*$factor)/$factor); 
    return (number_format($numero, $decimales));
  }

  function set_status($id, $val) {
    $data = array('Estado' => $val);
    $this->db->where('iddiario', $id);
    $this->db->update('daily', $data);

  }

  function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $start_ts - $end_ts;
    $diff = round($diff / 86400);
    if ($diff < 0)
      $diff = 0;
    return $diff;
  }
/*
  function set_status_pagos($id, $val){
    print_r("++++++++++++++");
    print_r("********************");
    $data = array('Estado' => $val);
    $this->db->where('iddiario', $id);
    $query = $this->db->get('daily');
    $result = $query->result_array();
    foreach ($result as $r) {
      print_r($r);
      $this->db->where('iddiario', $r['iddiario']);
      $this->db->update('daily', $data);
    }
  }*/
}

?>