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
      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
    }

  

    function search_tab ($data_in){
      //echo "<br><br><br><br><br><br><br><br><br><br><br>";
      //print_r($data_in);
      $this->db->select(
        '
        transaction.idTransaction,
        users.Email as user,
        customer.idCustomer,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        customer.idSubZona,
        transaction.Observacion,
        blog.Operation,
        blog.FechaHoraInicio,
        blog.FechaHoraFin,
        transaction.Estado'
      );
 
      $this->db->from('transaction');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer', 'left');
      $this->db->join('users', 'users.idUser = transaction.idUser', 'left');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad', 'left');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio', 'left');
      $this->db->join('zona', 'zona.idZona = barrio.idZona', 'left');
      $this->db->join('blog', 'transaction.idTransaction = blog.idTransaction', 'left');

      /*if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != "0"){
        $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2"){
          $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());  
        }
      }*/
      if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != "0"){
        //$this->db->where('customer.idCiudad', $this->Account_Model->get_city());
        $this->db->where('customer.idCiudad', $data_in['city']);
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2"){
          $this->db->where('customer.idCiudad', $this->Account_Model->get_city());  
        }
      }

      if(isset($data_in['client']) AND $data_in['client'] != "" AND $data_in['client'] != "0")
        $this->db->where('customer.idCustomer', $data_in['client']);

      if(isset($data_in['area']) && $data_in['area'] != "" && $data_in['area'] != "0") {
        $this->db->where('zona.idZona', $data_in['area']);
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $this->db->where('zona.idZona', $this->Account_Model->get_area());
      }
        
      if(isset($data_in['subarea']) &&  $data_in['subarea'] != "" &&  $data_in['subarea'] != "0")
        $this->db->where('customer.idSubZona', $data_in['subarea']);
        
      if(isset($data_in['status']) && $data_in['status'] != "" && $data_in['status'] != "0")
        $this->db->where('transaction.Estado', $data_in['status']);

      if(isset($data_in['user']) && $data_in['user'] != "" && $data_in['user'] != "0")
        $this->db->where('users.idUser', $data_in['user']);

      if(isset($data_in['name']) && $data_in['name'] != "")
        $this->db->like('customer.NombreTienda', $data_in['name']);
      
      if(isset($data_in['code']) AND $data_in['code'] != "")
        $this->db->where('customer.CodeCustomer', $data_in['code']);

      if(isset($data_in['commercetype']) AND $data_in['commercetype'] != "" AND $data_in['commercetype'] != "0")
        $this->db->where('customer.idComercio', $data_in['commercetype']);
      
      if(isset($data_in['channel']) AND $data_in['channel'] != "" AND $data_in['channel'] != "0")
        $this->db->where('customer.idChannel', $data_in['channel']);

      if(isset($data_in['dateStart']) && $data_in['dateStart'] != ""){
        $fecha = $data_in['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(blog.FechaHoraInicio) >', $nuevafecha);

        //print_r($nuevafecha);
      }
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != ""){
        $fecha = $data_in['dateFinish'];
        $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
        $this->db->where('DATE(blog.FechaHoraInicio) <', $nuevafecha2);

        //print_r($nuevafecha2);
      }

      if(isset($data_in['order']) && $data_in['order'] != "")
        $this->db->order_by($data_in['order'], "asc");

      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
    }



    function search_tab_csv ($data_in){
      $this->db->select(
        '
        blog.idTransaction AS idTr,
        users.Email,
        customer.CodeCustomer,
        customer.NombreTienda,
        blog.FechaHoraInicio,
        blog.CoordenadaInicio,
        blog.FechaHoraFin,
        blog.CoordenadaFin,
        blog.Operation,
        transaction.Estado,
        transaction.Observacion,
        detailtransaction.idProduct,
        products.Nombre,
        products.PrecioUnit,
        detailtransaction.Cantidad,
        detailtransaction.Estado'
      );
 
      $this->db->from('blog');
      $this->db->join('transaction', 'transaction.idTransaction = blog.idTransaction');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      $this->db->join('detailtransaction', 'detailtransaction.idTransaction = transaction.idTransaction');
      
      $this->db->join('products', 'products.idProduct = detailtransaction.idProduct');
      /*$this->db->select(
        '
        transaction.idTransaction,
        users.Email as user,
        customer.idCustomer,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        customer.idSubZona,
        transaction.Observacion,
        blog.Operation,
        blog.FechaHoraInicio,
        blog.FechaHoraFin,
        transaction.Estado'
      );
 
      $this->db->from('transaction');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer', 'left');
      $this->db->join('users', 'users.idUser = transaction.idUser', 'left');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad', 'left');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio', 'left');
      $this->db->join('zona', 'zona.idZona = barrio.idZona', 'left');
      $this->db->join('blog', 'transaction.idTransaction = blog.idTransaction', 'left');
*/
/*      if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != "0"){
        $this->db->where('users.idCiudadOpe', $data_in['city']);
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2"){
          $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());  
        }
      }*/
      if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != "0"){
        $this->db->where('customer.idCiudad', $data_in['city']);
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2"){
          $this->db->where('customer.idCiudad', $this->Account_Model->get_city());  
        }
      }

      if(isset($data_in['client']) AND $data_in['client'] != "" AND $data_in['client'] != "0")
        $this->db->where('customer.idCustomer', $data_in['client']);

//      if(isset($data_in['area']) && $data_in['area'] != "" && $data_in['area'] != "0") {
//        $this->db->where('zona.idZona', $data_in['area']);
//      }else{
//        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
//          $this->db->where('zona.idZona', $this->Account_Model->get_area());
//      }
        
      if(isset($data_in['subarea']) &&  $data_in['subarea'] != "" &&  $data_in['subarea'] != "0")
        $this->db->where('customer.idSubZona', $data_in['subarea']);
        
      if(isset($data_in['status']) && $data_in['status'] != "" && $data_in['status'] != "0")
        $this->db->where('transaction.Estado', $data_in['status']);

      if(isset($data_in['user']) && $data_in['user'] != "" && $data_in['user'] != "0")
        $this->db->where('users.idUser', $data_in['user']);

      if(isset($data_in['name']) && $data_in['name'] != "")
        $this->db->like('customer.NombreTienda', $data_in['name']);
      
      if(isset($data_in['code']) AND $data_in['code'] != "")
        $this->db->where('customer.CodeCustomer', $data_in['code']);

      if(isset($data_in['commercetype']) AND $data_in['commercetype'] != "" AND $data_in['commercetype'] != "0")
        $this->db->where('customer.idComercio', $data_in['commercetype']);
      
      if(isset($data_in['channel']) AND $data_in['channel'] != "" AND $data_in['channel'] != "0")
        $this->db->where('customer.idChannel', $data_in['channel']);

      if(isset($data_in['dateStart']) && $data_in['dateStart'] != ""){
        $fecha = $data_in['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(blog.FechaHoraInicio) >', $nuevafecha);
      }
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != ""){
        $fecha = $data_in['dateFinish'];
        $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
        $this->db->where('DATE(blog.FechaHoraInicio) <', $nuevafecha2);
      }
      
      $this->db->order_by("idTr", "asc");


      //$this->db->group_by('transaction.idTransaction'); 
      $query = $this->db->get();
      

      $this->load->dbutil();
      $delimiter = ",";
      $newline = "\r\n";

      return $this->dbutil->csv_from_result($query, $delimiter, $newline); 
    }


    function report_1_Products_csv ($search){
      $querystring = '
      SELECT 
        detailtransaction.idTransaction,
        detailtransaction.idDetailTransaction,
        detailtransaction.idProduct,
        detailtransaction.Cantidad,
        detailtransaction.Estado,
        detailtransaction.Observacion,
        products.Nombre as productName,
        products.Descripcion as description,
        products.PrecioUnit as precio,
        detailtransaction.Cantidad * products.PrecioUnit subtotal
      FROM detailtransaction
      INNER JOIN products ON products.idProduct = detailtransaction.idProduct
      INNER JOIN linevolume ON linevolume.idLineVolume = products.idLineVolume
      INNER JOIN line ON line.idLine = linevolume.idLine
      INNER JOIN volume ON volume.idVolume = linevolume.idVolume
      
      WHERE detailtransaction.Estado != 4 

      AND detailtransaction.idTransaction IN (

        SELECT `transactionfilter`.idTransaction
        FROM `transactionfilter`
        WHERE transactionfilter. idTransaction != "0000"
        ';

        if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all"){
          $querystring .= ' AND transactionfilter.idCiudad = '.$search['city'];
        }else{
          if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
            $querystring .= ' AND transactionfilter.idCiudad = '.$this->Account_Model->get_city();
        }
        
        if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" AND $search['area'] != "all"){
          $querystring .= ' AND transactionfilter.idZona = '.$search['area'];
        }else{
          if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
            $querystring .= ' AND transactionfilter.idZona = '.$this->Account_Model->get_area();
        }
        
        if(isset($search['code']) AND $search['code'] != "" AND $search['code'] != "0")
          $querystring .= ' AND transactionfilter.idCustomer = '.$search['code'];
        
        if(isset($search['subarea']) &&  $search['subarea'] != "" &&  $search['subarea'] != "0")
          $querystring .= ' AND transactionfilter.idSubZona = '.$search['subarea'];
        
        if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
          $querystring .= ' AND transactionfilter.Estado = '.$search['status']; 
        
        if(isset($search['user']) && $search['user'] != "" && $search['user'] != "0")
          $querystring .= ' AND transactionfilter.idUser = '.$search['user'];
          
        if(isset($search['name']) && $search['name'] != "")
          $querystring .= ' AND transactionfilter.NombreTienda = '.$search['name'];
          
        if(isset($search['code']) AND $search['code'] != "")
          $querystring .= ' AND transactionfilter.CodeCustomer = '.$search['code'];
        if(isset($search['commercetype']) AND $search['commercetype'] != "" AND $search['commercetype'] != "0")
          $querystring .= ' AND transactionfilter.idComercio = '.$search['commercetype'];
        if(isset($search['channel']) AND $search['channel'] != "" AND $search['channel'] != "0")
          $querystring .= ' AND transactionfilter.idChannel = '.$search['channel'];

        if(isset($search['dateStart']) && $search['dateStart'] != ""){
          $fecha = $search['dateStart'];
          $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
          $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
          $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) > '".$nuevafecha."'";
        }
        if(isset($search['dateFinish']) && $search['dateFinish'] != ""){
          $fecha = $search['dateFinish'];
          $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
          $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
          $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) < '".$nuevafecha2."'";
        }

        if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
          $querystring .= ' AND transactionfilter.Estado = '.$search['status']; 

        $querystring .=  ' ) ';
        //$querystring .=  'GROUP BY detailtransaction.idProduct;';
        $querystring .=  'ORDER BY detailtransaction.idTransaction;';
        //$querystring .=  ';';
      $query = $this->db->query($querystring);

      $this->load->dbutil();
      $delimiter = ",";
      $newline = "\r\n";

      return $this->dbutil->csv_from_result($query, $delimiter, $newline); 
    }

    function search_tab_report_1 ($data_in){
      //echo "<br><br><br><br><br><br><br><br><br><br><br>";
      //print_r("@@@@@@@@@ ".$this->Account_Model->get_city()." @@@@@@@@@");
      $this->db->select(
        '
        transaction.idTransaction,
        users.Email as user,
        customer.idCustomer,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        customer.idSubZona,
        transaction.Observacion,
        blog.Operation,
        blog.FechaHoraInicio,
        blog.FechaHoraFin,
        transaction.Estado'
      );
 
      $this->db->from('transaction');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer', 'left');
      $this->db->join('users', 'users.idUser = transaction.idUser', 'left');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad', 'left');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio', 'left');
      $this->db->join('zona', 'zona.idZona = barrio.idZona', 'left');
      $this->db->join('blog', 'transaction.idTransaction = blog.idTransaction', 'left');

      // todo menos temporales
      $this->db->where('transaction.Estado !=', "5");
      
      if(isset($data_in['city']) AND $data_in['city'] != "" AND $data_in['city'] != "0"){
        $this->db->where('customer.idCiudad', $data_in['city']);
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2"){
          $this->db->where('customer.idCiudad', $this->Account_Model->get_city());  
        }
      }

      if(isset($data_in['client']) AND $data_in['client'] != "" AND $data_in['client'] != "0")
        $this->db->where('customer.idCustomer', $data_in['client']);

      if(isset($data_in['area']) && $data_in['area'] != "" && $data_in['area'] != "0") {
        $this->db->where('zona.idZona', $data_in['area']);
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $this->db->where('zona.idZona', $this->Account_Model->get_area());
      }
        
      if(isset($data_in['subarea']) &&  $data_in['subarea'] != "" &&  $data_in['subarea'] != "0")
        $this->db->where('customer.idSubZona', $data_in['subarea']);
        
      if(isset($data_in['status']) && $data_in['status'] != "" && $data_in['status'] != "0")
        $this->db->where('transaction.Estado', $data_in['status']);

      if(isset($data_in['user']) && $data_in['user'] != "" && $data_in['user'] != "0")
        $this->db->where('users.idUser', $data_in['user']);

      if(isset($data_in['name']) && $data_in['name'] != "")
        $this->db->like('customer.NombreTienda', $data_in['name']);
      
      if(isset($data_in['code']) AND $data_in['code'] != "")
        $this->db->where('customer.CodeCustomer', $data_in['code']);

      if(isset($data_in['commercetype']) AND $data_in['commercetype'] != "" AND $data_in['commercetype'] != "0")
        $this->db->where('customer.idComercio', $data_in['commercetype']);
      
      if(isset($data_in['channel']) AND $data_in['channel'] != "" AND $data_in['channel'] != "0")
        $this->db->where('customer.idChannel', $data_in['channel']);

      if(isset($data_in['dateStart']) && $data_in['dateStart'] != ""){
        $fecha = $data_in['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(blog.FechaHoraInicio) >', $nuevafecha);
      }
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != ""){
        $fecha = $data_in['dateFinish'];
        $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
        $this->db->where('DATE(blog.FechaHoraInicio) <', $nuevafecha2);
      }

      if(isset($data_in['order']) && $data_in['order'] != "")
        $this->db->order_by($data_in['order'], "asc");

      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
    }

    function report($order="idTransaction") {
      $this->db->select(
        'transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        customer.idSubZona,
        transaction.Observacion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser', 'left');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer', 'left');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad', 'left');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio', 'left');
      $this->db->join('zona', 'zona.idZona = barrio.idZona', 'left');
      $this->db->join('blog', 'blog.idTransaction = transaction.idTransaction', 'left');

      // solo mostrar  5 dias atras
      $days = -5;
      $fecha = date ('Y-m-j');
      $nuevafecha = strtotime ( $days.' day' , strtotime ( $fecha ) ) ;
      $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
      $this->db->where('DATE(blog.FechaHoraInicio) >', $nuevafecha);

      if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
        $this->db->where('ciudad.idCiudad', $this->Account_Model->get_city());

      if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
        $this->db->where('zona.idZona', $this->Account_Model->get_area());
      //$this->db->where('transaction.Estado !=', '4');

      $this->db->order_by($order, "asc");
      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
    }

    function report_2($order="idTransaction") { // temporales y canceladas
      $this->db->select(
        'transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        customer.idSubZona,
        transaction.Observacion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser', 'left');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer', 'left');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad', 'left');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio', 'left');
      $this->db->join('zona', 'zona.idZona = barrio.idZona', 'left');
      $this->db->join('blog', 'blog.idTransaction = transaction.idTransaction', 'left');

      if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
        $this->db->where('customer.idCiudad', $this->Account_Model->get_city());

      if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
        $this->db->where('zona.idZona', $this->Account_Model->get_area());
      
      $this->db->where('transaction.Estado', '1');
      $this->db->or_where('transaction.Estado', '2');

      $this->db->order_by($order, "asc");
      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
    }
    function report_3($order="idTransaction") { // temporales y canceladas
      $this->db->select(
        'transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        customer.idSubZona,
        transaction.Observacion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser', 'left');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer', 'left');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad', 'left');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio', 'left');
      $this->db->join('zona', 'zona.idZona = barrio.idZona', 'left');
      $this->db->join('blog', 'blog.idTransaction = transaction.idTransaction', 'left');

      if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2"){
        $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());
        $this->db->or_where('customer.idCiudad', $this->Account_Model->get_city());
      //  $this->db->or_where('customer.idCiudad', "10");
      }

      if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
        $this->db->where('zona.idZona', $this->Account_Model->get_area());


      $this->db->where('transaction.Estado', '5');

      $this->db->order_by($order, "asc");
      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
 /*     $this->db->select(
        'transactionfilter.idTransaction,
        users.Email as user,
        transactionfilter.NombreTienda as customer,
        transactionfilter.CodeCustomer as codecustomer,
        transactionfilter.idSubZona,
        transaction.Observacion,
        transactionfilter.Estado'
      );
      $this->db->from('transactionfilter');
      $this->db->join('users', 'users.idUser = transactionfilter.idUser');
      $this->db->join('transaction', 'transactionfilter.idTransaction = transaction.idTransaction', 'left');
      
      if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
        $this->db->where('users.idCiudadOpe', $this->Account_Model->get_city());

      if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
        $this->db->where('transactionfilter.idZona', $this->Account_Model->get_area());
      
      $this->db->where('transaction.Estado', '5');

      $this->db->order_by($order, "asc");
      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
      
/*

idTransaction 
idComercio
idCiudad
idBarrio
FechaHoraInicio 
Estado
idSubZona 
idUser
NombreTienda
idCustomer
idZona
CodeCustomer
idChannel */
}
    function report_4($data_in) { // temporales y canceladas
      $this->db->select(
        'transaction.idTransaction,
        users.Email as user,
        customer.NombreTienda as customer,
        customer.CodeCustomer as codecustomer,
        customer.idSubZona,
        transaction.Observacion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('users', 'users.idUser = transaction.idUser');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');

      if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
        $this->db->where('customer.idCiudad', $this->Account_Model->get_city());

      if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
        $this->db->where('zona.idZona', $this->Account_Model->get_area());
      if(isset($data_in['status']) && $data_in['status'] != "" && $data_in['status'] != "0"){
        $this->db->where('transaction.Estado', $data_in['status']);
      }

      $this->db->order_by("transaction.idTransaction", "asc");
      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      //echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br>**************";
      //print_r($query->result());
      //echo "**************";
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
      $this->db->group_by('idTransaction'); 
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
      $this->db->group_by('idTransaction'); 
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
      $this->db->group_by('idTransaction'); 
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
      date_default_timezone_set("America/La_Paz");
      if ($this->db->insert('transaction', $data_in)) {
        $insertcode = $this->db->insert_id();

        // Save log for this action
        $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $data['idAction'] = '19';
        $data['idReferencia'] = $insertcode;
        $data['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($data);
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
        // Save log for this action
        $newdatalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $newdatalog['idAction'] = '20';
        $newdatalog['idReferencia'] = $id;
        $newdatalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($newdatalog);
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
      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
    }

    function get_deliveries_for_this_user($mail) {
      $profile = $this->Account_Model->get_profile_by_mail($mail);
      $city = $this->Account_Model->get_city_by_mail($mail);
      $area = $this->Account_Model->get_area_by_mail($mail);

      $this->db->select(
        'transaction.idTransaction,
        customer.NombreTienda as customerName,
        customer.CodeCustomer as customer,
        customer.Direccion as direccion,
        transaction.Estado'
      );
      $this->db->from('transaction');
      $this->db->join('customer', 'customer.idCustomer = transaction.idCustomer');
      //$this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');

      // filters by city
      if($profile != '1'){
        $this->db->where('customer.idCiudad', $city);

        if($profile == '4' OR $profile == '5'){
          $this->db->where('zona.idZona', $area);
        }
      }

      //$this->db->where('customer.idCiudad', '2');
      $this->db->where('customer.Estado', '1');

      $this->db->where('transaction.Estado', "1");
      $this->db->or_where('transaction.Estado', "2");


      
      
      
      // filters by city
      //if($profile == 2 || $profile == 3){ 
      //if($city !="all"){
      //  $this->db->where('customer.idCiudad', $city);
      //}
      // filters by Area
      //if($profile == 4 || $profile == 5){
      //if($area !="all"){
      //  $this->db->where('zona.idZona', $area);
      //}

      
      //$this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      return $query->result();
    }



    function get_start_date_for_this_transaction($idtransaction){
      $this->db->select(
        'blog.FechaHoraInicio'
      );

      $this->db->from('blog');
      //$this->db->join('transaction', 'transaction.idTransaction = blog.idTransaction');
      $this->db->where('blog.idTransaction', $idtransaction);
      //$this->db->where('blog.Operation', "venta_directa");
      //$this->db->or_where('blog.Operation', "transaccion_0");
      //$this->db->or_where('blog.Operation', "creacion");
      $this->db->group_by('idTransaction'); 
      $query = $this->db->get();
      $result = $query->result_array();
      foreach ($result as $r) {
        $startdate = $r['FechaHoraInicio'];
      }
      return $startdate;
    }

    function get_literal_status($idtrans) {
      $status = "";
      if($transaction->Estado == '1')
        $status = 'Prevendido';
      if($transaction->Estado == '2')
        $status = 'Conciliado';
      if($transaction->Estado == '3')
        $status = 'Distribuido';
      if($transaction->Estado == '4')
        $status = 'Cancelado';
      if($transaction->Estado == '5')
        $status = 'Temporal';
      if($transaction->Estado == '6')
        $status = 'Venta Directa';
      if($transaction->Estado == '7')
        $status = 'Transaccion 0';
    }


    function report_clients() {
      $query = $this->db->query('
        SELECT Estado, count( * ) as co
        FROM `transaction`
        GROUP BY Estado
      ');    
      return $query->result();
    }

    function report_products($search) {
      $querystring = '
      SELECT detailtransaction.idProduct,
       products.Nombre,
       line.Descripcion as line,
       volume.Descripcion as volume,
       SUM(detailtransaction.Cantidad) AS Cantidad,
       
       products.PrecioUnit,
       SUM(detailtransaction.Cantidad * products.PrecioUnit) AS Total 
      
      FROM detailtransaction
      INNER JOIN products ON products.idProduct = detailtransaction.idProduct
      INNER JOIN linevolume ON linevolume.idLineVolume = products.idLineVolume
      INNER JOIN line ON line.idLine = linevolume.idLine
      INNER JOIN volume ON volume.idVolume = linevolume.idVolume
      
      WHERE detailtransaction.Estado != 4 

      AND detailtransaction.idTransaction IN (

        SELECT `transactionfilter`.idTransaction
        FROM `transactionfilter`
        WHERE transactionfilter. idTransaction != "0000"
        ';

        if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all"){
          $querystring .= ' AND transactionfilter.idCiudad = '.$search['city'];
        }else{
          if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
            $querystring .= ' AND transactionfilter.idCiudad = '.$this->Account_Model->get_city();
        }
        
        if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" AND $search['area'] != "all"){
          $querystring .= ' AND transactionfilter.idZona = '.$search['area'];
        }else{
          if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
            $querystring .= ' AND transactionfilter.idZona = '.$this->Account_Model->get_area();
        }
        
        if(isset($search['code']) AND $search['code'] != "" AND $search['code'] != "0")
          $querystring .= ' AND transactionfilter.idCustomer = '.$search['code'];
        
        if(isset($search['subarea']) &&  $search['subarea'] != "" &&  $search['subarea'] != "0")
          $querystring .= ' AND transactionfilter.idSubZona = '.$search['subarea'];
        
        if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
          $querystring .= ' AND transactionfilter.Estado = '.$search['status']; 
        
        if(isset($search['user']) && $search['user'] != "" && $search['user'] != "0")
          $querystring .= ' AND transactionfilter.idUser = '.$search['user'];
          
        if(isset($search['name']) && $search['name'] != "")
          $querystring .= ' AND transactionfilter.NombreTienda = '.$search['name'];
          
        if(isset($search['code']) AND $search['code'] != "")
          $querystring .= ' AND transactionfilter.CodeCustomer = '.$search['code'];
        if(isset($search['commercetype']) AND $search['commercetype'] != "" AND $search['commercetype'] != "0")
          $querystring .= ' AND transactionfilter.idComercio = '.$search['commercetype'];
        if(isset($search['channel']) AND $search['channel'] != "" AND $search['channel'] != "0")
          $querystring .= ' AND transactionfilter.idChannel = '.$search['channel'];

        if(isset($search['dateStart']) && $search['dateStart'] != ""){
          $fecha = $search['dateStart'];
          $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
          $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
          $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) > '".$nuevafecha."'";
        }
        if(isset($search['dateFinish']) && $search['dateFinish'] != ""){
          $fecha = $search['dateFinish'];
          $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
          $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
          $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) < '".$nuevafecha2."'";
        }

        if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
          $querystring .= ' AND transactionfilter.Estado = '.$search['status']; 


        //$querystring .=  ' GROUP BY transactionfilter.idTransaction) ';
        $querystring .=  ' ) ';
        $querystring .=  'GROUP BY detailtransaction.idProduct;';

        //$querystring .=  ') ;';
      //print_r("WWWWWWWWWWWWWWWWW");
      //print_r($querystring);
      $query = $this->db->query($querystring);
      return $query->result();
    }

    function report_products_csv($search) {
      $querystring = '
      SELECT detailtransaction.idProduct,
       products.Nombre,
       line.Descripcion as line,
       volume.Descripcion as volume,
       SUM(detailtransaction.Cantidad) AS Cantidad,
       
       products.PrecioUnit,
       SUM(detailtransaction.Cantidad * products.PrecioUnit) AS Total 
      
      FROM detailtransaction
      INNER JOIN products ON products.idProduct = detailtransaction.idProduct
      INNER JOIN linevolume ON linevolume.idLineVolume = products.idLineVolume
      INNER JOIN line ON line.idLine = linevolume.idLine
      INNER JOIN volume ON volume.idVolume = linevolume.idVolume
      WHERE detailtransaction.Estado != 4 
      
      AND detailtransaction.idTransaction IN (

        SELECT `transactionfilter`.idTransaction
        FROM `transactionfilter`
        WHERE transactionfilter. idTransaction != "0000"
        ';

        if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all"){
          $querystring .= ' AND transactionfilter.idCiudad = '.$search['city'];
        }else{
          if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
            $querystring .= ' AND transactionfilter.idCiudad = '.$this->Account_Model->get_city();
        }
        
        if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" AND $search['area'] != "all"){
          $querystring .= ' AND transactionfilter.idZona = '.$search['area'];
        }else{
          if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
            $querystring .= ' AND transactionfilter.idZona = '.$this->Account_Model->get_area();
        }
        
        if(isset($search['code']) AND $search['code'] != "" AND $search['code'] != "0")
          $querystring .= ' AND transactionfilter.idCustomer = '.$search['code'];
        
        if(isset($search['subarea']) &&  $search['subarea'] != "" &&  $search['subarea'] != "0")
          $querystring .= ' AND transactionfilter.idSubZona = '.$search['subarea'];
        
        if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
          $querystring .= ' AND transactionfilter.Estado = '.$search['status']; 
        
        if(isset($search['user']) && $search['user'] != "" && $search['user'] != "0")
          $querystring .= ' AND transactionfilter.idUser = '.$search['user'];
          
        if(isset($search['name']) && $search['name'] != "")
          $querystring .= ' AND transactionfilter.NombreTienda = '.$search['name'];
          
        if(isset($search['code']) AND $search['code'] != "")
          $querystring .= ' AND transactionfilter.CodeCustomer = '.$search['code'];
        if(isset($search['commercetype']) AND $search['commercetype'] != "" AND $search['commercetype'] != "0")
          $querystring .= ' AND transactionfilter.idComercio = '.$search['commercetype'];
        if(isset($search['channel']) AND $search['channel'] != "" AND $search['channel'] != "0")
          $querystring .= ' AND transactionfilter.idChannel = '.$search['channel'];

        if(isset($search['dateStart']) && $search['dateStart'] != ""){
          $fecha = $search['dateStart'];
          $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
          $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
          $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) > '".$nuevafecha."'";
        }
        if(isset($search['dateFinish']) && $search['dateFinish'] != ""){
          $fecha = $search['dateFinish'];
          $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
          $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
          $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) < '".$nuevafecha2."'";
        }

        if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
          $querystring .= ' AND transactionfilter.Estado = '.$search['status']; 

        $querystring .=  ' ) ';
        $querystring .=  'GROUP BY detailtransaction.idProduct;';

      $query = $this->db->query($querystring);

      $this->load->dbutil();

      $delimiter = ",";
      $newline = "\r\n";

      return $this->dbutil->csv_from_result($query, $delimiter, $newline); 
    }

    function report_lines($search) {
      $querystring = '

      SELECT line.Descripcion as line,
      volume.Descripcion as volume,
      Sum(detailtransaction.Cantidad) AS TotalProd,
      Sum(detailtransaction.Cantidad * products.PrecioUnit) AS Total
      FROM detailtransaction
      INNER JOIN products ON products.idProduct = detailtransaction.idProduct
      INNER JOIN linevolume ON linevolume.idLineVolume = products.idLineVolume
      INNER JOIN line ON line.idLine = linevolume.idLine
      INNER JOIN volume ON volume.idVolume = linevolume.idVolume 

      WHERE detailtransaction.Estado != 4 

      AND detailtransaction.idTransaction IN (
        SELECT `transactionfilter`.idTransaction
        FROM `transactionfilter`
        WHERE transactionfilter. idTransaction != "0000"
        ';
      
      if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all"){
        $querystring .= ' AND transactionfilter.idCiudad = '.$search['city'];
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
          $querystring .= ' AND transactionfilter.idCiudad = '.$this->Account_Model->get_city();
      }
      
      if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" AND $search['area'] != "all"){
        $querystring .= ' AND transactionfilter.idZona = '.$search['area'];
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $querystring .= ' AND transactionfilter.idZona = '.$this->Account_Model->get_area();
      }

      //if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all")
      //  $querystring .= ' AND transactionfilter.idCiudad = '.$search['city'];
      if(isset($search['client']) AND $search['client'] != "" AND $search['client'] != "0")
        $querystring .= ' AND transactionfilter.idCustomer = '.$search['client'];
      //if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" && $search['area'] != "all")
      //  $querystring .= ' AND transactionfilter.idZona = '.$search['area'];
      if(isset($search['subarea']) &&  $search['subarea'] != "" &&  $search['subarea'] != "0" &&  $search['subarea'] != "all")
        $querystring .= ' AND transactionfilter.idSubZona = '.$search['subarea'];
      if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
        $querystring .= ' AND transactionfilter.Estado = '.$search['status'];
      if(isset($search['user']) && $search['user'] != "" && $search['user'] != "0")
        $querystring .= ' AND transactionfilter.idUser = '.$search['user'];
        
      if(isset($search['name']) && $search['name'] != "" && $search['name'] != "0")
        $querystring .= ' AND customer.NombreTienda = '.$search['name'];
        //$this->db->like('customer.NombreTienda',$search['name']);
        
      if(isset($search['code']) AND $search['code'] != "" AND $search['code'] != "0")
        $querystring .= ' AND transactionfilter.CodeCustomer = '.$search['code'];
      if(isset($search['commercetype']) AND $search['commercetype'] != "" AND $search['commercetype'] != "0")
        $querystring .= ' AND transactionfilter.idComercio = '.$search['commercetype'];
      if(isset($search['channel']) AND $search['channel'] != "" AND $search['channel'] != "0")
        $querystring .= ' AND transactionfilter.idChannel = '.$search['channel'];
      
      if(isset($search['dateStart']) && $search['dateStart'] != ""){
        $fecha = $search['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) > '".$nuevafecha."'";
      }
      if(isset($search['dateFinish']) && $search['dateFinish'] != ""){
        $fecha = $search['dateFinish'];
        $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
        $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) < '".$nuevafecha2."'";
      }

      $querystring .=  ' ) GROUP BY linevolume.idLine,
      line.Descripcion,
      linevolume.idVolume,
      volume.Descripcion;';
        
      $query = $this->db->query($querystring);
      //print_r($querystring);
      return $query->result();
    }

    function report_lines_csv($search) {
      $querystring = '

      SELECT line.Descripcion as line,
      volume.Descripcion as volume,
      Sum(detailtransaction.Cantidad) AS TotalProd,
      Sum(detailtransaction.Cantidad * products.PrecioUnit) AS Total
      FROM detailtransaction
      INNER JOIN products ON products.idProduct = detailtransaction.idProduct
      INNER JOIN linevolume ON linevolume.idLineVolume = products.idLineVolume
      INNER JOIN line ON line.idLine = linevolume.idLine
      INNER JOIN volume ON volume.idVolume = linevolume.idVolume 
      WHERE detailtransaction.Estado != 4 
      AND detailtransaction.idTransaction IN (
        SELECT `transactionfilter`.idTransaction
        FROM `transactionfilter`
        WHERE transactionfilter. idTransaction != "0000"
        ';
      
      if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all"){
        $querystring .= ' AND transactionfilter.idCiudad = '.$search['city'];
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
          $querystring .= ' AND transactionfilter.idCiudad = '.$this->Account_Model->get_city();
      }
      
      if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" AND $search['area'] != "all"){
        $querystring .= ' AND transactionfilter.idZona = '.$search['area'];
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $querystring .= ' AND transactionfilter.idZona = '.$this->Account_Model->get_area();
      }

      //if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all")
      //  $querystring .= ' AND transactionfilter.idCiudad = '.$search['city'];
      if(isset($search['client']) AND $search['client'] != "" AND $search['client'] != "0")
        $querystring .= ' AND transactionfilter.idCustomer = '.$search['client'];
      //if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" && $search['area'] != "all")
      //  $querystring .= ' AND transactionfilter.idZona = '.$search['area'];
      if(isset($search['subarea']) &&  $search['subarea'] != "" &&  $search['subarea'] != "0" &&  $search['subarea'] != "all")
        $querystring .= ' AND transactionfilter.idSubZona = '.$search['subarea'];
      if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
        $querystring .= ' AND transactionfilter.Estado = '.$search['status'];
      if(isset($search['user']) && $search['user'] != "" && $search['user'] != "0")
        $querystring .= ' AND transactionfilter.idUser = '.$search['user'];
        
      if(isset($search['name']) && $search['name'] != "" && $search['name'] != "0")
        $querystring .= ' AND customer.NombreTienda = '.$search['name'];
        //$this->db->like('customer.NombreTienda',$search['name']);
        
      if(isset($search['code']) AND $search['code'] != "" AND $search['code'] != "0")
        $querystring .= ' AND transactionfilter.CodeCustomer = '.$search['code'];
      if(isset($search['commercetype']) AND $search['commercetype'] != "" AND $search['commercetype'] != "0")
        $querystring .= ' AND transactionfilter.idComercio = '.$search['commercetype'];
      if(isset($search['channel']) AND $search['channel'] != "" AND $search['channel'] != "0")
        $querystring .= ' AND transactionfilter.idChannel = '.$search['channel'];
      
      if(isset($search['dateStart']) && $search['dateStart'] != ""){
        $fecha = $search['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) > '".$nuevafecha."'";
      }
      if(isset($search['dateFinish']) && $search['dateFinish'] != ""){
        $fecha = $search['dateFinish'];
        $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
        $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) < '".$nuevafecha2."'";
      }

      $querystring .=  ' ) GROUP BY linevolume.idLine,
      line.Descripcion,
      linevolume.idVolume,
      volume.Descripcion;';
        
      $query = $this->db->query($querystring);
      $this->load->dbutil();

      $delimiter = ",";
      $newline = "\r\n";

      return $this->dbutil->csv_from_result($query, $delimiter, $newline); 
    }

    function get_sum_products($search){
      $querystring = '
        SELECT SUM(detailtransaction.Cantidad) AS CuentaProductos,
        SUM(detailtransaction.Cantidad*products.PrecioUnit) AS Total
        FROM detailtransaction
        INNER JOIN products ON products.idProduct = detailtransaction.idProduct
        WHERE detailtransaction.Estado != 4 
        AND detailtransaction.idTransaction IN
        (
          SELECT `transactionfilter`.idTransaction
          FROM `transactionfilter`
          WHERE transactionfilter. idTransaction != "0000"
          ';

      /*if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all"){
        $querystring .= ' AND customer.idCiudad = '.$search['city'];
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
          $querystring .= ' AND customer.idCiudad = '.$this->Account_Model->get_city();
      }
      
      if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" AND $search['area'] != "all"){
        $this->db->where('zona.idZona', $search['area']);
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $this->db->where('zona.idZona', $this->Account_Model->get_area());
      }*/


      if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all"){
        $querystring .= ' AND transactionfilter.idCiudad = '.$search['city'];
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
          $querystring .= ' AND transactionfilter.idCiudad = '.$this->Account_Model->get_city();
      }
      
      if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" AND $search['area'] != "all"){
        $querystring .= ' AND transactionfilter.idZona = '.$search['area'];
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $querystring .= ' AND transactionfilter.idZona = '.$this->Account_Model->get_area();
      }

      //if(isset($search['city']) AND $search['city'] != "" AND $search['city'] != "0" AND $search['city'] != "all")
      //  $querystring .= ' AND customer.idCiudad = '.$search['city'];
      if(isset($search['client']) AND $search['client'] != "" AND $search['client'] != "0")
        $querystring .= ' AND transactionfilter.idCustomer = '.$search['client'];
      //if(isset($search['area']) && $search['area'] != "" && $search['area'] != "0" && $search['area'] != "all")
      //  $querystring .= ' AND zona.idZona = '.$search['area'];
      if(isset($search['subarea']) &&  $search['subarea'] != "" &&  $search['subarea'] != "0" &&  $search['subarea'] != "all")
        $querystring .= ' AND transactionfilter.idSubZona = '.$search['subarea'];
      if(isset($search['status']) &&  $search['status'] != "" &&  $search['status'] != "0")
        $querystring .= ' AND transactionfilter.Estado = '.$search['status'];
      if(isset($search['user']) && $search['user'] != "" && $search['user'] != "0")
        $querystring .= ' AND transactionfilter.idUser = '.$search['user'];
        
      if(isset($search['name']) && $search['name'] != "")
        $querystring .= ' AND transactionfilter.NombreTienda = '.$search['name'];
        //$this->db->like('customer.NombreTienda',$search['name']);
        
      if(isset($search['code']) AND $search['code'] != "")
        $querystring .= ' AND transactionfilter.CodeCustomer = '.$search['code'];
      if(isset($search['commercetype']) AND $search['commercetype'] != "" AND $search['commercetype'] != "0")
        $querystring .= ' AND transactionfilter.idComercio = '.$search['commercetype'];
      if(isset($search['channel']) AND $search['channel'] != "" AND $search['channel'] != "0")
        $querystring .= ' AND transactionfilter.idChannel = '.$search['channel'];

      if(isset($search['dateStart']) && $search['dateStart'] != ""){
        $fecha = $search['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) > '".$nuevafecha."'";
      }
      if(isset($search['dateFinish']) && $search['dateFinish'] != ""){
        $fecha = $search['dateFinish'];
        $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );
        $querystring .= " AND DATE(transactionfilter.FechaHoraInicio) < '".$nuevafecha2."'";
      }

      $querystring .=  ' ) ;';
        
      $query = $this->db->query($querystring);
      
      //print_r("XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
      //print_r($querystring);
      return $query->result();
    }

    // caclcula la diferencia entre 2 fechas
    function dateDiff($time1, $time2, $precision = 6) {
      // Time format is UNIX timestamp or
      // PHP strtotime compatible strings
      // Set timezone
      date_default_timezone_set("UTC");
      // If not numeric then convert texts to unix timestamps
      if (!is_int($time1)) {
        $time1 = strtotime($time1);
      }
      if (!is_int($time2)) {
        $time2 = strtotime($time2);
      }
   
      // If time1 is bigger than time2
      // Then swap time1 and time2
      if ($time1 > $time2) {
        $ttime = $time1;
        $time1 = $time2;
        $time2 = $ttime;
      }
   
      // Set up intervals and diffs arrays
      $intervals = array('year','month','day','hour','minute','second');
      $diffs = array();
   
      // Loop thru all intervals
      foreach ($intervals as $interval) {
        // Set default diff to 0
        $diffs[$interval] = 0;
        // Create temp time from time1 and interval
        $ttime = strtotime("+1 " . $interval, $time1);
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
          $time1 = $ttime;
          $diffs[$interval]++;
          // Create new temp time from time1 and interval
          $ttime = strtotime("+1 " . $interval, $time1);
        }
      }
   
      $count = 0;
      $times = array();
      // Loop thru all diffs
      foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
          break;
        }
        // Add value and interval 
        // if value is bigger than 0
        if ($value > 0) {
          // Add s if value is not 1
          if ($value != 1) {
            $interval .= "s";
          }
          // Add value and interval to times array
          $times[] = $value . " " . $interval;
          $count++;
        }
      }
   
      // Return string with times
      return implode(", ", $times);
    }

    // funcion para redondear numeros
    function roundnumber ($numero, $decimales) {
      //$factor = pow(10, $decimales);
      //return (round($numero*$factor)/$factor); 
      return (number_format($numero, $decimales));
    }






}

?>
