<?php

class Detailtransaction_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();

      $this->load->model('Account_Model');
      $this->load->model('Transaction_Model');
    }

    function check_if_exist_product($idtrans, $codeprod) {
      $this->db->where('idTransaction', $idtrans);
      $this->db->where('idProduct', $codeprod);
      $query = $this->db->get('detailtransaction');

      if ($query->num_rows() > 0) {
          return TRUE;
      } else {
          return FALSE;
      }
    }

    function get_by_trans_prod($idtrans, $codeprod) {
      $this->db->where('idTransaction', $idtrans);
      $this->db->where('idProduct', $codeprod);
      $query = $this->db->get('detailtransaction');
      /*$result = $query->result_array();
      foreach ($result as $r) {
        $Cantidad = $r['Cantidad'];
      }
      return $Cantidad;*/
      return $query->result();
    }

    function get($id) {
      $this->db->select(
        'detailtransaction.idDetailTransaction,
        detailtransaction.idTransaction,
        detailtransaction.idProduct,
        detailtransaction.Cantidad,
        detailtransaction.Estado,
        detailtransaction.Observacion,
        products.Nombre as productName,
        products.Descripcion as description,
        products.PrecioUnit as precio'
      );
      $this->db->from('detailtransaction');
      $this->db->join('products', 'products.idProduct = detailtransaction.idProduct');
       $this->db->where('idTransaction', $id); 
      $query = $this->db->get();
      return $query->result();
    }

    function get_actives($id) {
      $this->db->select(
        'detailtransaction.idDetailTransaction,
        detailtransaction.idTransaction,
        detailtransaction.idProduct,
        detailtransaction.Cantidad,
        detailtransaction.Estado,
        detailtransaction.Observacion,
        products.Nombre as productName,
        products.Descripcion as description,
        products.PrecioUnit as precio'
      );
      $this->db->from('detailtransaction');
      $this->db->join('products', 'products.idProduct = detailtransaction.idProduct');
       $this->db->where('idTransaction', $id);
       $this->db->where('detailtransaction.Estado !=', '4'); 
      $query = $this->db->get();
      return $query->result();
    }

    function create($data_in) {
      if ($this->db->insert('detailtransaction', $data_in)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '23';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idDetailTransaction', $id);
      if ($this->db->update('detailtransaction', $data)) {
        // Save log for this action
        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '24';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);
        return TRUE;
      }
      return FALSE;
    }

    function delete($id_transaction, $id_product) {
      $this->db->delete('detailtransaction', array('idTransaction' => $id_transaction, 'idProduct' => $id_product)); ;
    }

    function changestatus($id_transaction, $status) {
      $data = array(
        'Estado' => $status 
      );

      $this->db->where('idTransaction', $id_transaction);
      $this->db->update('detailtransaction', $data);
    }

    function get_detailtransactions_for_this_user($mail) {
       $this->db->select(
        'detailtransaction.idDetailTransaction,
        detailtransaction.idTransaction,
        detailtransaction.idProduct,
        detailtransaction.Cantidad,
        detailtransaction.Estado,
        detailtransaction.Observacion,
        products.Nombre as productName,
        products.Descripcion as description,
        products.PrecioUnit as precio'
      );
      $this->db->from('detailtransaction');
      $this->db->join('products', 'products.idProduct = detailtransaction.idProduct');
      $this->db->join('transaction', 'transaction.idTransaction = detailtransaction.idTransaction');
      $this->db->where('detailtransaction.Estado', "1");
      $this->db->where('transaction.Estado', "1");
      $this->db->or_where('transaction.Estado', "2");
      $query = $this->db->get();
      return $query->result();
    }




    function get_detailtransactions_for_this_transaction($idtrans) {
      //return $idtrans;
      
       /*$this->db->select(
        'detailtransaction.idDetailTransaction,
        detailtransaction.idTransaction,
        detailtransaction.idProduct,
        detailtransaction.Cantidad,
        detailtransaction.Estado,
        detailtransaction.Observacion,
        products.Nombre as productName,
        products.Descripcion as description,
        products.PrecioUnit as precio'
      );      
      $this->db->from('transaction');
      $this->db->join('detailtransaction', 'transaction.idTransaction = detailtransaction.idTransaction');
      $this->db->join('products', 'products.idProduct = detailtransaction.idProduct');
      $this->db->where('transaction.idTransaction', $idtrans);
      $this->db->where('detailtransaction.Estado', "1");
      $this->db->where('transaction.Estado', "1");
      $this->db->or_where('transaction.Estado', "2");*/
      $this->db->select(
        'detailtransaction.idDetailTransaction,
        detailtransaction.idTransaction,
        detailtransaction.idProduct,
        detailtransaction.Cantidad,
        detailtransaction.Estado,
        detailtransaction.Observacion,
        products.Nombre as productName,
        products.Descripcion as description,
        products.PrecioUnit as precio'
      );      
      $this->db->from('detailtransaction');    
      $this->db->where('detailtransaction.idTransaction', $idtrans);
      $this->db->join('products', 'products.idProduct = detailtransaction.idProduct');
      $this->db->where('detailtransaction.Estado', "1");     

      $query = $this->db->get();
      return $query->result();
    }

    /*function report() {
      $this->db->select(
        'Transaction.idTransaction,
        Users.Email as user,
        Customer.NombreTienda as customer,
        Transaction.Observacion,
        Transaction.Conciliado'

      );
      $this->db->from('Transaction');
      $this->db->join('Users', 'Users.idUser = Transaction.idUser');
      $this->db->join('Customer', 'Customer.idCustomer = Transaction.idCustomer');
      $query = $this->db->get();
      return $query->result();
    }


    function get($id) {
      $query = $this->db->get_where('Transaction',array('idTransaction'=>$id));
      return $query->result();
    }

    function get_name($id) {
      $this->db->where('idTransaction', $id);
      $query = $this->db->get('Transaction');
      $result = $query->result_array();
      foreach ($result as $r) {
        $name = $r['Descripcion'];
      }
      return $name;
    }

    function create($data_in) {
      if ($this->db->insert('Transaction', $data_in)) {
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idTransaction', $id);
      if ($this->db->update('Transaction', $data)) {
        return TRUE;
      }
      return FALSE;
    }*/
}

?>