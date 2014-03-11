<?php
  class Webservice extends  CI_Controller {    
    public function __construct() {
      parent::__construct();
      $this->load->model('Account_Model');
      $this->load->model('Permission_Model');
      $this->load->model('Transaction_Model');
      $this->load->model('Detailtransaction_Model');
      $this->load->model('Product_Model');
      $this->load->model('Client_Model');
      $this->load->model('Blog_Model');
      $this->load->model('Product_Model');
      $this->load->model('Line_Model');
      $this->load->model('Volume_Model');
      $this->load->model('Linevolume_Model');
      $this->load->model('User_Model');
      $this->load->model('Track_Model');
    }

    function index() {
    }

    function check_if_user(){
      $result = "FAIL";  //default var

      $mail = $this->input->Post('userMail');
      $pass = $this->input->Post('userPassword');

      if (!isset($mail) && !isset($pass)){
        $result = "FAIL";
      }else{
        //$result = "OK";
        $res = $this->Account_Model->user_exist_check($mail, $pass);

        if (isset($res) && $res != "" && $res != null){
          if($res == "OK"){
            $user = json_encode($this->Account_Model->get_user($mail));
            $result = $user;            
          }else{
            $result = $res;
          }
        }else
          $result = "FAIL";
//        OK PASS MAIL
      }
      
      echo $result;
    }


    function check_user_mail(){
      $verifyMail = $this->Account_Model->user_exists($code = $this->input->Post('codeCustomer'));
      echo $verifyMail;
    }

    function get_products(){
      $products = json_encode($this->Product_Model->report_android());
      echo $products;
    }

    function get_lines(){
      $lines = json_encode($this->Line_Model->report_android());
      echo $lines;
    }

    function get_volumes(){
      $volumes = json_encode($this->Volume_Model->report_android());
      echo $volumes;
    }

    function get_linevolumes(){
      $linevolumes = json_encode($this->Linevolume_Model->report_android());
      echo $linevolumes;
    }

    function get_customers(){
      $code = $this->input->Post('codeCustomer');
      $JSON_decode = json_decode($code);

      $profile = $this->Account_Model->get_profile_by_mail($JSON_decode->userMail);
      $city = $this->Account_Model->get_city_by_mail($JSON_decode->userMail);
      $area = $this->Account_Model->get_area_by_mail($JSON_decode->userMail);

      $clients = array();

      $client_list  = $this->Client_Model->report_android($profile, $city, $area, $JSON_decode->userMail);
      // looping through each album
      foreach ($client_list as $row) {
        $tmp = array();
        
        $tmp["CodeCustomer"] = $row->CodeCustomer;
        $tmp["NombreTienda"] = $row->NombreTienda;
        $tmp["NombreContacto"] = $row->NombreContacto;
        $tmp["Direccion"] = $row->Direccion;
        $tmp["Telefono"] = $row->Telefono;
        $tmp["TelfCelular"] = $row->TelfCelular;

        // push album
        array_push($clients, $tmp);
      }
        
      // printing json
      echo json_encode($clients);
    }


    function check_if_is_valid_user() {
      $code = $this->input->Post('codeCustomer');
      $JSON_decode = json_decode($code);

      if ($this->Account_Model->check_if_is_valid_user($JSON_decode->userMail) == TRUE) {
        echo "TRUE";
      }else{
        echo "FALSE";
      }
    }

    function save_transaction(){
      $result = "SAVED";
      // get android info

      $code = $this->input->Post('codeCustomer');

      if (!isset($code)){
        $result = "FAIL";
      }

      $JSON_decode = json_decode($code);
      
      $userc = $this->Account_Model->get_user_id($JSON_decode->userMail);
      $userq = $JSON_decode->transactionType;
      $userd1 = date("Y-m-d H:i:s",strtotime($JSON_decode->timeStart));
      $userd2 = date("Y-m-d H:i:s",strtotime($JSON_decode->timeFinish));

      $ifexist = $this->Blog_Model->check_if_exist_transaction($userc, $userq, $userd1, $userd2);


      if (!$ifexist){
        // verify if is valid user
        if ($this->Account_Model->check_if_is_valid_user($JSON_decode->userMail) == TRUE) {
          $data_in['idUser'] = $this->Account_Model->get_user_id($JSON_decode->userMail);
          if(isset($JSON_decode->obs))
            $data_in['Observacion'] = $JSON_decode->obs;
          else
            $data_in['Observacion'] = " ";

          // verify transaction type
          if ($JSON_decode->clientType == "temporal") {
            $data_in['Estado'] = "5";
            $data_in['idCustomer'] = "607";   // ojo con esta huevada
            if ($JSON_decode->transactionType == "transaccion_0") 
              $data_in['Estado'] = "7";
          }else{
            //$data_in['Observacion'] = $JSON_decode->obs;
            // get client id
            $client_id = $this->Client_Model->get_client_by_code($JSON_decode->codeCustomer);
            foreach ($client_id as $row) {
              $data_in['idCustomer'] = $row->idCustomer;
            }

            if ($JSON_decode->transactionType == "preventa") {
              $data_in['Estado'] = "1";
            }

            if ($JSON_decode->transactionType == "venta_directa") {
              $data_in['Estado'] = "6";
            }

            if ($JSON_decode->transactionType == "transaccion_0") {
              $data_in['Estado'] = "7";
            }  
          }

          // save transaction and get insert code
          $insertcode = $this->Transaction_Model->create($data_in); 
          
          // Save Blog Transaction
          if ( $insertcode === FALSE) {
            $result = "FAIL";
          } else {
            $data_blog['idTransaction'] = $insertcode;
            $data_blog['idUser'] = $this->Account_Model->get_user_id($JSON_decode->userMail);
            $data_blog['Operation'] = $JSON_decode->transactionType;              
            $data_blog['FechaHoraInicio'] = date("Y-m-d H:i:s",strtotime($JSON_decode->timeStart));
            $data_blog['FechaHoraFin'] = date("Y-m-d H:i:s",strtotime($JSON_decode->timeFinish));
            $data_blog['CoordenadaInicio'] = $JSON_decode->coordinateStart;
            $data_blog['CoordenadaFin'] = $JSON_decode->coordinateFinish;

            if ($this->Blog_Model->create($data_blog) === TRUE) {
              //echo "SAVE_BLOG";
            } else {
              $result = "FAIL";
            }
          } 

          // Save Product for this transaction
          foreach ( $JSON_decode->TransactionsArray as $transactions ){
            $data_products['idTransaction'] = $insertcode;
            
            // get client id
            $product = $this->Product_Model->get($transactions[0]);
            foreach ($product as $row) {
              $data_products['idProduct'] = $row->idProduct;
            }

            $data_products['Cantidad'] = $transactions[1];
            //$data_products['Observacion'] = $transactions[2];
            $data_products['Observacion'] = "";

            if ($JSON_decode->transactionType == "venta_directa")
              $data_products['Estado'] = "3";


            if ($this->Detailtransaction_Model->create($data_products) === TRUE) {
            } else {          
              $result = "FAIL";
            }
          }
        }else{
          $result = "FAIL_USER";
        }
      } 

      echo $result;     
      //echo $userc."##".$userq."##".$userd1."##".$userd2;
      //echo $ifexist;
    }  

    // SAVE GPS POSITION
    function trackGPS (){
      $code = $this->input->Post('codeCustomer');
      $JSON_decode = json_decode($code);
      //echo $code;

      $data_in['Email'] = $JSON_decode->userMail;
      $data_in['Codcel'] = $JSON_decode->idphone;
      $data_in['Fecha'] = $JSON_decode->date;
      $data_in['Hora'] = $JSON_decode->hour;
      $data_in['Coordenada'] = $JSON_decode->coordinate;

      if ($this->Track_Model->create($data_in) === TRUE) {
        echo "ok";
      } else {
        echo "fail";
      }
    }

    function update_transaction() {
      $result = "SAVED";
      $code = $this->input->Post('codeCustomer');

      if (!isset($code)){
        $result = "FAIL11";
      }

      $JSON_decode = json_decode($code);
      $swStatus = TRUE;
      // Update Transaction Details for this transaction
      if(count($JSON_decode->TransactionsArray) > 0){
        foreach ( $JSON_decode->TransactionsArray as $transactions ){
          $statusCode = "";
          if($transactions[1] == "por_entregar")
            $statusCode = "1";
          if($transactions[1] == "entregado")
            $statusCode = "2";
          if($transactions[1] == "cancelado")
            $statusCode = "4";

          $data_detail['Estado'] = $statusCode;
          $data_detail['Observacion'] = $transactions[2];

          if ($this->Detailtransaction_Model->update($data_detail, $transactions[0]) === TRUE) {
            if ($transactions[1] == "por_entregar")
              $swStatus = FALSE;
          } else {        
            $result = "FAIL22";
          }
        }
      }else{
        $swStatus = FALSE;
      }

      // Save Blog Transaction
      $data_blog['idTransaction'] = $JSON_decode->idWeb;      
      $data_blog['idUser'] = $this->Account_Model->get_user_id($JSON_decode->userMail);
      if($swStatus){
        $data_blog['Operation'] = 'transaccion entregada';
      }else{
        $data_blog['Operation'] = 'entrega parcial';
      }
      $data_blog['FechaHoraInicio'] = date("Y-m-d H:i:s",strtotime($JSON_decode->timeStart));
      $data_blog['FechaHoraFin'] = date("Y-m-d H:i:s",strtotime($JSON_decode->timeFinish));
      $data_blog['CoordenadaInicio'] = $JSON_decode->coordinateStart;
      $data_blog['CoordenadaFin'] = $JSON_decode->coordinateFinish;

      if ($this->Blog_Model->create($data_blog) === TRUE) {
      } else {
        $result = "FAIL33";
      }

      // Update Transaction
      if($swStatus){
        $data_transaction['Estado'] = "3";
      }else{
        $data_transaction['Estado'] = "1";
      }

      if ($this->Transaction_Model->update($data_transaction, $JSON_decode->idWeb) === TRUE) {
        //echo "SAVE_BLOG";
      } else {
        $result = "FAIL44";
      }  

      echo $result;
    }


    function get_transactions_for_this_user(){
      $code = $this->input->Post('codeCustomer');
      $JSON_decode = json_decode($code);
      $mail = $JSON_decode->userMail;
      $mainArray = array();
      //$mail = "aticona@horizon.com";
      //echo $mail."<br>";

      $transactions = $this->Transaction_Model->get_deliveries_for_this_user($mail);
      //print_r($transactions);
      
    
      
      foreach ($transactions as $row) {
       
        $transactionsDetailContainer = array();
        $transactionsDetail = $this->Detailtransaction_Model->get_detailtransactions_for_this_transaction($row->idTransaction);
        foreach ($transactionsDetail as $rowt) {
          $arrayTransactionDetail = array(
            'idDetailTransaction' =>    $rowt->idDetailTransaction,
            'idTransaction'       =>    $rowt->idTransaction,
            'idProduct'           =>    $rowt->idProduct,
            'productName'         =>    $rowt->productName,
            'precio'              =>    $rowt->precio,
            'Cantidad'            =>    $rowt->Cantidad,
            'priceTotal'          =>    ($rowt->precio * $rowt->Cantidad)
          );

          array_push($transactionsDetailContainer, $arrayTransactionDetail);
        }

        $transaction = array(
          'idTransaction'   =>    $row->idTransaction,
          'customer'    =>    $row->customer,          
          'transactionsList'=>    $transactionsDetailContainer
        ); 
        array_push($mainArray, $transaction);
      }

      echo json_encode($mainArray);
    }


    function get_transactions_details_for_this_user(){
      //$mail = $this->input->Post('codeCustomer');
      $mail = "distribuidorlp8@horizon.com";

      $transactions = json_encode($this->Detailtransaction_Model->get_detailtransactions_for_this_user($mail));
      echo $transactions;      
    }
  }
?>