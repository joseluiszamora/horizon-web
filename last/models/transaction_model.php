<?php

class Transaction_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
    }



    function search ($data_in){
      $this->db->select(
        'customer.idCustomer,
        customer.CodeCustomer,
        customer.NombreTienda,
        comercio.Descripcion as comercio,
        customer.NombreContacto,
        customer.Direccion,
        ciudad.NombreCiudad as Ciudad,
        barrio.Descripcion as Barrio,
        zona.Descripcion as Zona,
        customer.Estado,
        customer.FechaAlta,
        customer.Observacion,
        customer.idSubZona,
        customer.Frecuencia,
        transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        transaction.Observacion,
        transaction.Estado'
      );

      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      $this->db->join('comercio', 'customer.idComercio = comercio.idComercio');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');

      /*if(isset($data_in['city']) AND $data_in['city'] != "")
        $this->db->where('customer.idCiudad', $data_in['city']);
      if(isset($data_in['disctrict']) && $data_in['disctrict'] != "")
        $this->db->where('customer.idBarrio', $data_in['disctrict']);
      if(isset($data_in['area']) && $data_in['area'] != "")
        $this->db->where('zona.idZona', $data_in['area']);
      if(isset($data_in['subarea']) &&  $data_in['subarea'] != "")
        $this->db->where('customer.idSubZona', $data_in['subarea']);
      if(isset($data_in['commercetype']) && $data_in['commercetype'] != "")
        $this->db->where('customer.idComercio', $data_in['commercetype']);
      if(isset($data_in['channel']) && $data_in['channel'] != "")
        $this->db->where('customer.idChannel', $data_in['channel']);



      if(isset($data_in['dateStart']) && $data_in['dateStart'] != "")
        $this->db->where('customer.FechaAlta >=', $data_in['dateStart']);
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != "")
        $this->db->where('customer.FechaAlta <=', $data_in['dateFinish']);
*/

      if(isset($data_in['name']) && $data_in['name'] != "")
        $this->db->like('customer.NombreTienda',$data_in['name']);
/*      if(isset($data_in['order']) && $data_in['order'] != "")
        $this->db->order_by($data_in['order'], "asc");
*/
      $query = $this->db->get();
      return $query->result();
    }



    function search_tab ($data_in){
      $this->db->select(
        '
        transaction.idTransaction,
        users.Email as user,
        customer.idCustomer,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        transaction.Observacion,
        blog.Operation,
        blog.FechaHoraInicio,
        blog.FechaHoraFin,
        transaction.Estado'
      );
 //city  area status  user  client  order  dateStart  dateFinish
      // FechaHoraInicio  CoordenadaInicio  FechaHoraFin  CoordenadaFin
      $this->db->from('transaction');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');
      $this->db->join('blog', 'transaction.idTransaction = blog.idTransaction');

      if(isset($data_in['city']) AND $data_in['city'] != "")
        $this->db->where('customer.idCiudad', $data_in['city']);
      if(isset($data_in['client']) AND $data_in['client'] != "")
        $this->db->where('customer.idCustomer', $data_in['client']);
      if(isset($data_in['area']) && $data_in['area'] != "")
        $this->db->where('zona.idZona', $data_in['area']);
      if(isset($data_in['status']) && $data_in['status'] != "")
        $this->db->where('transaction.Estado', $data_in['status']);
      if(isset($data_in['user']) && $data_in['user'] != "")
        $this->db->where('users.idUser', $data_in['user']);

      if(isset($data_in['dateStart']) && $data_in['dateStart'] != "")
        //echo date('Y-m-d', strtotime($row->FechaHoraInicio));
        $this->db->where('blog.FechaHoraInicio >=', $data_in['dateStart']);
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != "")
        $this->db->where('blog.FechaHoraInicio <=', $data_in['dateFinish']);

      if(isset($data_in['order']) && $data_in['order'] != "")
        $this->db->order_by($data_in['order'], "asc");



      $query = $this->db->get();
      return $query->result();
    }

    function report($order="idTransaction") {
      $this->db->select(
        'transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        transaction.Observacion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      $this->db->order_by($order, "asc");
      $query = $this->db->get();
      return $query->result();
    }

    function report_open($order="idTransaction") {
      $this->db->select(
        'transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        transaction.Observacion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      //condicion para transaccion abierta
      //$this->db->where('customer.idCustomer', $client);
      $this->db->order_by($order, "asc");
      $query = $this->db->get();
      return $query->result();
    }

    function report_finish($order="idTransaction") {
      $this->db->select(
        'transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        transaction.Observacion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      //condicion para transaccion cerrada
      //$this->db->where('customer.idCustomer', $client);
      $this->db->order_by($order, "asc");
      $query = $this->db->get();
      return $query->result();
    }

    function report_filter($date_from="", $date_to="", $client="") {
      $order="idTransaction";
      $this->db->select(
        'transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        transaction.Observacion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');

      /* no hay fecha en las transacciones
      if ($date_from != "") {
        $this->db->where('transaction.date >=', $date_from);
      }
      if ($date_to != "") {
        $this->db->where('transaction.date <=', $date_to);
      }
      */
      //echo $client;
      if ($client != "") {
        $this->db->where('customer.idCustomer', $client);
      }
      $this->db->order_by($order, "asc");
      $query = $this->db->get();
      return $query->result();
    }


    function get($id) {
      $query = $this->db->get_where('transaction',array('idTransaction'=>$id));
      return $query->result();
    }

    function get_info($id) {
      $this->db->select(
        'transaction.idTransaction,
        users.Nombre as userName,
        users.Apellido as userLastName,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        customer.Direccion as customAddres,
        comercio.Descripcion as comercio,
        transaction.Observacion,
        transaction.Estado'

      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      $this->db->join('comercio', 'comercio.idComercio = customer.idComercio');
      $this->db->where('idTransaction', $id);
      $query = $this->db->get();
      return $query->result();
    }

    function get_name($id) {
      $this->db->where('idTransaction', $id);
      $query = $this->db->get('transaction');
      $result = $query->result_array();
      foreach ($result as $r) {
        $name = $r['Descripcion'];
      }
      return $name;
    }

    function create($data_in) {
      if ($this->db->insert('transaction', $data_in)) {
        $insertcode = $this->db->insert_id();
       /*
        $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data['Operation'] = 'creacion';
        $data['FechaHoraInicio'] = date("m-d-y, g:i a");
        $data['FechaHoraFin'] = date("m-d-y, g:i a");
        $data['CoordenadaInicio'] = '0.0';
        $data['CoordenadaFin'] = '0.0';
        $this->db->insert('blog', $data_in)
        */
        return $insertcode;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idTransaction', $id);
      if ($this->db->update('transaction', $data)) {
        return TRUE;
      }
      return FALSE;
    }


    function get_transactions_for_this_user($mail) {
      //$city = $this->User_Model->get_city($mail);
      //$area = $this->User_Model->get_area($mail);

      $this->db->select(
        'transaction.idTransaction,
        customer.NombreTienda as customerName,
        customer.CodeCustomer as customer,
        customer.Direccion as direccion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      //$this->db->where('users.Email', $mail);
      $this->db->where('transaction.Estado', "1");
      $this->db->or_where('transaction.Estado', "2");
      $query = $this->db->get();
      return $query->result();
    }
}

?>