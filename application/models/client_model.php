<?php

class Client_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->model('District_Model');
    }

    function report($order="customer.idCustomer") {
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
        customer.Telefono,
        customer.TelfCelular,
        customer.Email,
        customer.Contactop01,
        customer.Telfcontop01,
        customer.Contactop02,
        customer.Telfcontop02,
        customer.Estado,
        customer.FechaAlta,
        customer.Observacion,
        customer.idSubZona,
        customer.Coordenada,
        customer.Frecuencia'
      );

      $this->db->from('customer');

      $this->db->join('comercio', 'customer.idComercio = comercio.idComercio');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');
      $this->db->order_by($order, "asc");

      // filters by city
      if($this->Account_Model->get_profile() == 3){
        $this->db->where('customer.idCiudad', $this->Account_Model->get_city());
      }
      // filters by Area
      if($this->Account_Model->get_profile() == 4 OR $this->Account_Model->get_profile() == 5){
        $this->db->where('zona.idZona', $this->Account_Model->get_area());
      }

      $query = $this->db->get();
      return $query->result();
    }

    function report_android($profile, $city, $area, $user) {
      $this->db->select(
        'customer.idCustomer,
        customer.CodeCustomer,
        customer.NombreTienda,
        customer.NombreContacto,
        customer.Direccion,
        customer.Telefono,
        customer.idCiudad,
        customer.TelfCelular,
        customer.Estado,
        rank.Days'
      );

      $this->db->from('customer');


      //$this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');
      $this->db->join('rank', 'customer.idrank = rank.idrank');

      // filters by city
      if($profile != '1'){
        $this->db->where('customer.idCiudad', $city);

        if($profile == '4' OR $profile == '5'){
          $this->db->where('zona.idZona', $area);
        }
      }

      $this->db->where('customer.Estado', '1');

      $query = $this->db->get();
      return $query->result();
    }

    function create($data) {
      if ($this->db->insert('customer', $data)) {
        $id = $this->db->insert_id();
        $id_zone = $this->District_Model->get_area_code($data['idBarrio']);

        $this->db->select("COUNT(*) AS num_users");
        $this->db->from('customer');
        $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
        $this->db->where('idZona ',$id_zone);
        $query = $this->db->get();
        $array_result = $query->result();
        $num_users = $array_result[0] -> num_users;       

        $city = str_pad($data['idCiudad'], 2, '0', STR_PAD_LEFT);
        $zone = str_pad($id_zone, 2, '0', STR_PAD_LEFT);
        $channel = str_pad($data['idChannel'], 1, '0', STR_PAD_LEFT);
        $district = str_pad($data['idBarrio'], 2, '0', STR_PAD_LEFT);    

        $new_code = $zone."".$data['Ref0']."".$num_users;     

	
        $data = array('CodeCustomer' => $new_code);
        $this->db->where('idCustomer', $id);
        $this->db->update('customer', $data);


        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '5';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);

        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idCustomer', $id);
      if ($this->db->update('customer', $data)) {
        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '6';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);
        return TRUE;
      }
      return FALSE;
    }

    // get Clients dropdown
    function get_clients() {
      $query = $this->db->get('customer');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Cliente';
      foreach ($result as $r) {
        $dropdown[$r['idCustomer']] = $r['CodeCustomer']." - ".$r['NombreTienda'];
      }
      return $dropdown;
    }

    // get Clients dropdown
    function get_clients_by_city($city) {
      $this->db->select("*");
      $this->db->from('customer');
      $this->db->where('idCiudad ',$city);
      $query = $this->db->get();
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Cliente';
      foreach ($result as $r) {
        $dropdown[$r['idCustomer']] = $r['NombreTienda'];
      }
      return $dropdown;
    }

    function get($id) {
      $query = $this->db->get_where('customer',array('idCustomer'=>$id,'Estado'=>'1'));
      return $query->result();
    }

    function get_client_by_code($Code) {
      $query = $this->db->get_where('customer',array('CodeCustomer'=>$Code, 'Estado'=>'1'));
      return $query->result();
    }

    function get_id_by_code($code) {
      $this->db->where('CodeCustomer', $code);
      $query = $this->db->get('customer');
      $result = $query->result_array();
      foreach ($result as $r) {
        $id = $r['idCustomer'];
      }
      return $id;
    }

    function get_id_by_code_and_name($codename) {
      // ejm:   031000908 - SUSANA NINA
      
      $porciones = explode(" - ", $codename);
      $this->db->where('CodeCustomer', $porciones[0]);
      $query = $this->db->get('customer');
      $result = $query->result_array();
      foreach ($result as $r) {
        $id = $r['idCustomer'];
      }
      return $id;
    }

    function get_code_by_id($code) {
      $this->db->where('idCustomer', $code);
      $query = $this->db->get('customer');
      $result = $query->result_array();
      foreach ($result as $r) {
        $code = $r['CodeCustomer'];
      }
      return $code;
    }

    function set_client_status($cli, $val) {
      $data = array('Estado' => $val);
      $this->db->where('idCustomer', $cli);
      $this->db->update('customer', $data);
    }

    function customer_exists($var) {
      $this->db->where('CodeCustomer', $var);
      $this->db->where('Estado', '1');
      $query = $this->db->get('customer');

      if ($query->num_rows() > 0) {
          return TRUE;
      } else {
          return FALSE;
      }
    }


    function get_credit_limit($id){
      $this->db->select('rank.Limit as limitXXX');
      $this->db->from('rank');
      $this->db->join('customer', 'customer.idrank = rank.idrank');
      $this->db->where('customer.idCustomer', $id);
      $query = $this->db->get();      
      $result = $query->result_array();
      $limit = "0";
      foreach ($result as $r) {
        $limit = $r['limitXXX'];
      }
      return $limit;   
    }


    function client_valide_bycode($code){
      if ($this->Account_Model->get_profile() != "1" || $this->Account_Model->get_profile() != "2"){
        $client = $this->get_client_by_code($code);
        foreach ($client as $cli) {
          $city = $cli->idCiudad;
        }
        if($this->Account_Model->get_city() == "all" || $city == $this->Account_Model->get_city())
          return TRUE;
        else
          return FALSE;
      }else
        return TRUE;
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
        customer.Telefono,
        customer.TelfCelular,
        customer.Email,
        customer.Contactop01,
        customer.Telfcontop01,
        customer.Contactop02,
        customer.Telfcontop02,
        customer.Estado,
        customer.FechaAlta,
        customer.Observacion,
        customer.idSubZona,
        customer.Coordenada,
        customer.Frecuencia,
        last_transaction.FechaHoraInicio as ff
        '
      );
//dateStart   dateFinish  name   city   disctrict   area  subarea   channel   datelasttransaction
      $this->db->from('customer');

      $this->db->join('comercio', 'customer.idComercio = comercio.idComercio');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');
      $this->db->join('last_transaction', 'customer.idCustomer = last_transaction.idCustomer', "left");

      if(isset($data_in['dateStart']) && $data_in['dateStart'] != "" && $data_in['dateStart'] != "0"){
        $fecha = $data_in['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(customer.FechaAlta) >', $nuevafecha);
      }
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != "" && $data_in['dateFinish'] != "0"){
        $fecha = $data_in['dateFinish'];
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(customer.FechaAlta) <', $nuevafecha);
      }
      if(isset($data_in['commercetype']) && $data_in['commercetype'] != "" && $data_in['commercetype'] != "all" && $data_in['commercetype'] != "0"){
        $this->db->where('comercio.idComercio', $data_in['commercetype']);
      }
        
      if(isset($data_in['status']) && $data_in['status'] != "" && $data_in['status'] != "0") 
        $this->db->where('customer.Estado',$data_in['status']);
      if(isset($data_in['name']) && $data_in['name'] != "")
        $this->db->like('customer.NombreTienda',$data_in['name']);
      if(isset($data_in['code']) && $data_in['code'] != "")
        $this->db->where('customer.CodeCustomer',$data_in['code']);
      if(isset($data_in['city']) && $data_in['city'] != "" && $data_in['city'] != "all" && $data_in['city'] != "0"){
        $this->db->where('customer.idCiudad', $data_in['city']);
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
          $this->db->where('customer.idCiudad', $this->Account_Model->get_city());
      }
      if(isset($data_in['disctrict']) && $data_in['disctrict'] != "" && $data_in['disctrict'] != "all" && $data_in['disctrict'] != "0")
        $this->db->where('customer.idBarrio', $data_in['disctrict']);
      if(isset($data_in['area']) && $data_in['area'] != "" && $data_in['area'] != "all" && $data_in['area'] != "0"){
        $this->db->where('zona.idZona', $data_in['area']);
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $this->db->where('zona.idZona', $this->Account_Model->get_area());
      }
      if(isset($data_in['subarea']) &&  $data_in['subarea'] != "" && $data_in['subarea'] != "all" &&  $data_in['subarea'] != "0")
        $this->db->where('customer.idSubZona', $data_in['subarea']);
      if(isset($data_in['channel']) && $data_in['channel'] != "" &&  $data_in['channel'] != "0")
        $this->db->where('customer.idChannel', $data_in['channel']);

      if(isset($data_in['datelast']) && $data_in['datelast'] != ""){
        $days = $data_in['datelast'];
        $days = intval($days)*-1;
        $days--;
        $fecha = date ('Y-m-j');
        $nuevafecha = strtotime ( $days.' day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(last_transaction.FechaHoraInicio) >', $nuevafecha);
      }

      if(isset($data_in['order']) && $data_in['order'] != "" &&  $data_in['order'] != "0"){
        $this->db->order_by($data_in['order'], "asc");
      }else{
        $this->db->order_by('last_transaction.FechaHoraInicio', "desc");
      }
      $query = $this->db->get();
      return $query->result();
    }


    function csv ($data_in){
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
        customer.Telefono,
        customer.TelfCelular,
        customer.Email,
        customer.Contactop01,
        customer.Telfcontop01,
        customer.Contactop02,
        customer.Telfcontop02,
        customer.Estado,
        customer.FechaAlta,
        customer.Observacion,
        customer.idSubZona,
        customer.Coordenada,
        customer.Frecuencia,
        last_transaction.FechaHoraInicio as ff
        '
      );
      $this->db->from('customer');

      $this->db->join('comercio', 'customer.idComercio = comercio.idComercio');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');
      $this->db->join('last_transaction', 'customer.idCustomer = last_transaction.idCustomer', "left");

      if(isset($data_in['dateStart']) && $data_in['dateStart'] != "" && $data_in['dateStart'] != "0"){
        $fecha = $data_in['dateStart'];
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(customer.FechaAlta) >', $nuevafecha);
      }
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != "" && $data_in['dateFinish'] != "0"){
        $fecha = $data_in['dateFinish'];
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(customer.FechaAlta) <', $nuevafecha);
      }
      if(isset($data_in['commercetype']) && $data_in['commercetype'] != "" && $data_in['commercetype'] != "all" && $data_in['commercetype'] != "0"){
        $this->db->where('comercio.idComercio', $data_in['commercetype']);
      }
        
      if(isset($data_in['status']) && $data_in['status'] != "" && $data_in['status'] != "0") 
        $this->db->where('customer.Estado',$data_in['status']);
      if(isset($data_in['name']) && $data_in['name'] != "")
        $this->db->like('customer.NombreTienda',$data_in['name']);
      if(isset($data_in['code']) && $data_in['code'] != "")
        $this->db->where('customer.CodeCustomer',$data_in['code']);
      if(isset($data_in['city']) && $data_in['city'] != "" && $data_in['city'] != "all" && $data_in['city'] != "0"){
        $this->db->where('customer.idCiudad', $data_in['city']);
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
          $this->db->where('customer.idCiudad', $this->Account_Model->get_city());
      }
      if(isset($data_in['disctrict']) && $data_in['disctrict'] != "" && $data_in['disctrict'] != "all" && $data_in['disctrict'] != "0")
        $this->db->where('customer.idBarrio', $data_in['disctrict']);
      if(isset($data_in['area']) && $data_in['area'] != "" && $data_in['area'] != "all" && $data_in['area'] != "0"){
        $this->db->where('zona.idZona', $data_in['area']);
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $this->db->where('zona.idZona', $this->Account_Model->get_area());
      }
      if(isset($data_in['subarea']) &&  $data_in['subarea'] != "" && $data_in['subarea'] != "all" &&  $data_in['subarea'] != "0")
        $this->db->where('customer.idSubZona', $data_in['subarea']);
      if(isset($data_in['channel']) && $data_in['channel'] != "" &&  $data_in['channel'] != "0")
        $this->db->where('customer.idChannel', $data_in['channel']);

      if(isset($data_in['datelast']) && $data_in['datelast'] != ""){
        $days = $data_in['datelast'];
        $days = intval($days)*-1;
        $days--;
        $fecha = date ('Y-m-j');
        $nuevafecha = strtotime ( $days.' day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $this->db->where('DATE(last_transaction.FechaHoraInicio) >', $nuevafecha);
      }

      if(isset($data_in['order']) && $data_in['order'] != "" &&  $data_in['order'] != "0"){
        $this->db->order_by($data_in['order'], "asc");
      }else{
        $this->db->order_by('last_transaction.FechaHoraInicio', "desc");
      }
      $query = $this->db->get();

      $this->load->dbutil();

      $delimiter = ",";
      $newline = "\r\n";

      return $this->dbutil->csv_from_result($query, $delimiter, $newline); 
    }

    function search_pdf ($data_in){
      $this->db->select(
        'customer.idCustomer,
        customer.CodeCustomer,
        customer.NombreTienda,
        comercio.Descripcion as comercio,
        customer.Direccion,
        customer.FechaAlta'
      );

      $this->db->from('customer');

      $this->db->join('comercio', 'customer.idComercio = comercio.idComercio');
      $this->db->join('ciudad', 'customer.idCiudad = ciudad.idCiudad');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      $this->db->join('zona', 'zona.idZona = barrio.idZona');

      if(isset($data_in['city']) && $data_in['city'] != "" && $data_in['city'] != "all" && $data_in['city'] != "0"){
        $this->db->where('customer.idCiudad', $data_in['city']);
      }else{
        if($this->Account_Model->get_profile() != "1" && $this->Account_Model->get_profile() != "2")
          $this->db->where('customer.idCiudad', $this->Account_Model->get_city());
      }
      if(isset($data_in['disctrict']) && $data_in['disctrict'] != "" && $data_in['disctrict'] != "0")
        $this->db->where('customer.idBarrio', $data_in['disctrict']);
      if(isset($data_in['area']) && $data_in['area'] != "" && $data_in['area'] != "all" && $data_in['area'] != "0"){
        $this->db->where('zona.idZona', $data_in['area']);
      }else{
        if($this->Account_Model->get_profile() == "4" && $this->Account_Model->get_profile() == "5")
          $this->db->where('zona.idZona', $this->Account_Model->get_area());
      }
      if(isset($data_in['subarea']) &&  $data_in['subarea'] != "" && $data_in['subarea'] != "0")
        $this->db->where('customer.idSubZona', $data_in['subarea']);
      if(isset($data_in['commercetype']) && $data_in['commercetype'] != "" && $data_in['commercetype'] != "0")
        $this->db->where('customer.idComercio', $data_in['commercetype']);
      if(isset($data_in['channel']) && $data_in['channel'] != "" && $data_in['channel'] != "0")
        $this->db->where('customer.idChannel', $data_in['channel']);



      if(isset($data_in['dateStart']) && $data_in['dateStart'] != "" && $data_in['dateStart'] != "0")
        $this->db->where('customer.FechaAlta >=', $data_in['dateStart']);
      if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != "" && $data_in['dateFinish'] != "0")
        $this->db->where('customer.FechaAlta <=', $data_in['dateFinish']);

      if(isset($data_in['name']) && $data_in['name'] != "")
        $this->db->like('customer.NombreTienda',$data_in['name']);
      if(isset($data_in['order']) && $data_in['order'] != "")
        $this->db->order_by($data_in['order'], "asc");

      $query = $this->db->get();
      return $query->result();
    }

    // get all users for city
    function get_customers_by_area($area) {
      $this->db->select(
        'customer.idCustomer,
        customer.CodeCustomer,
        customer.NombreTienda'
      );
      $this->db->from('customer');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      if(isset($area) && $area != "all" && $area != "" && $area != "0") 
        $this->db->where('barrio.idZona', $area);

      $this->db->order_by('NombreTienda', "asc");
      $query = $this->db->get();
      $dropdown = array();
      $dro0own[""] = 'Seleccione Cliente';

      $result = $query->result_array();
      foreach ($result as $r) {
        $dropdown[$r['idCustomer']] = $r['CodeCustomer']." - ".$r['NombreTienda'];
      }

      return $dropdown;
    }


    function count_customers_by_area($area){
      $this->db->from('customer');
      $this->db->join('barrio', 'customer.idBarrio = barrio.idBarrio');
      if(isset($area) && $area != "all" && $area != "" && $area != "0")
        $this->db->where('barrio.idZona', $area);

      return $this->db->count_all_results();
    }

    function count_customers_by_sub_area($area){
      $this->db->from('customer');
      if(isset($area) && $area != "all" && $area != "" && $area != "0")
        $this->db->where('customer.idSubZona', $area);

      return $this->db->count_all_results();
    }

}

?>
