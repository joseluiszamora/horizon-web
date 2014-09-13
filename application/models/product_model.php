<?php

class Product_model extends CI_Model {

    function __construct() {
      parent::__construct();
      $this->load->database();
    }

    function report($datasearch) {
      $this->db->select(
        'products.idProduct,
        products.idLineVolume,
        products.Nombre,
        products.PrecioUnit,
        products.uxp,
        products.Estado,
        products.Descripcion,
        line.Descripcion as lineDescription,
        volume.Descripcion as volumeDescription'
      );
      $this->db->from('products');
      $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
      $this->db->join('line', 'linevolume.idLine = line.idLine');
      $this->db->join('volume', 'linevolume.idVolume = volume.idVolume');
      $this->db->order_by("products.Nombre", "asc");
      if(isset($datasearch['status']) && $datasearch['status'] != "")
        $this->db->where('products.Estado',$datasearch['status']);
      $query = $this->db->get();
      return $query->result();
    }

    function report_android() {
      $this->db->select(
        'products.idProduct,
        products.Nombre,
        products.idLineVolume,
        products.PrecioUnit,
        products.uxp,
        products.Descripcion'
      );
      $this->db->from('products');
      $this->db->where('products.Estado', '1');
      $query = $this->db->get();
      return $query->result();
    }

    function get_regular_products() {
      $this->db->select(
        'products.idProduct,
        products.Nombre,
        products.idLineVolume,
        products.PrecioUnit,
        products.uxp,
        products.Descripcion'
      );
      $this->db->from('products');
      $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
      $this->db->join('line', 'linevolume.idLine = line.idLine');
      $this->db->where('products.Estado', '1');
      $this->db->where('line.regular', 'si');
      $query = $this->db->get();
      return $query->result();
    }

    function create($data_in) {
      if ($this->db->insert('products', $data_in)) {
        // Save log for this action
        $id = $this->db->insert_id();
        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '15';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);
        return TRUE;
      }
      return FALSE;
    }

    function update($data, $id) {
      $this->db->where('idProduct', $id);
      if ($this->db->update('products', $data)) {
        // Save log for this action
        $datalog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
        $datalog['idAction'] = '16';
        $datalog['idReferencia'] = $id;
        $datalog['FechaHora'] = date("y-m-d, g:i");
        $this->Log_Model->create($datalog);
        return TRUE;
      }
      return FALSE;
    }

    function get($id) {
      //$query = $this->db->get_where('products',array('idProduct'=>$id,'Estado'=>'1'));
      $this->db->select(
        'products.idProduct,
        products.idLineVolume,
        products.Nombre,
        products.PrecioUnit,
        products.uxp,
        products.Estado,
        products.Descripcion,
        line.idLine,
        line.Descripcion as lineDescription,
        volume.idVolume,
        volume.Descripcion as volumeDescription,
        linevolume.idLineVolume'
      );
      $this->db->from('products');
      $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
      $this->db->join('line', 'linevolume.idLine = line.idLine');
      $this->db->join('volume', 'linevolume.idVolume = volume.idVolume');
      $this->db->where(array('idProduct'=>$id,'Estado'=>'1'));
      $query = $this->db->get();
      return $query->result();
    }



    function get_name_by_code($id) {
      $this->db->select(
        'products.Nombre,
        volume.Descripcion as volumeDescription'
      );
      $this->db->from('products');
      $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
      $this->db->join('line', 'linevolume.idLine = line.idLine');
      $this->db->join('volume', 'linevolume.idVolume = volume.idVolume');
      $this->db->where(array('idProduct'=>$id,'Estado'=>'1'));
      $query = $this->db->get();

      $result = $query->result_array();
      $name = "";
      foreach ($result as $r) {
        $name = $r['volumeDescription']." - ".$r['Nombre'];
      }
      return $name;
    }


    function get_price($id) {
      $this->db->where('idProduct', $id);
      $this->db->where('Estado', '1');
      $query = $this->db->get('products');
      $result = $query->result_array();
      $price = 0;
      foreach ($result as $r) {
        $price = $r['PrecioUnit'];
      }
      return $price;
    }

    function get_all() {
      $this->db->where('Estado', '1');
      $query = $this->db->get('products');
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Producto';
      foreach ($result as $r) {
        $dropdown[$r['idProduct']] = $r['Nombre'];
      }
      return $dropdown;
    }

    function get_all_json() {
      $this->db->select(
       'products.idProduct,
        products.idLineVolume,
        products.Nombre,
        products.PrecioUnit,
        products.uxp,
        products.Estado,
        products.Descripcion,
        line.idLine,
        line.Descripcion as lineDescription,
        volume.idVolume,
        volume.Descripcion as volumeDescription,
        linevolume.idLineVolume'
      );
      $this->db->from('products');
      $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
      $this->db->join('line', 'linevolume.idLine = line.idLine');
      $this->db->join('volume', 'linevolume.idVolume = volume.idVolume');
      $this->db->order_by("idLine", "desc"); 
      $this->db->order_by("idVolume", "desc"); 
      $this->db->where(array('Estado'=>'1'));
      $query = $this->db->get();
      return $query->result();
    }

    function set_product_status($pro, $val) {
      $data = array('Estado' => $val);

      $this->db->where('idProduct', $pro);
      $this->db->update('products', $data);
    }

    function search ($search){
      $querystring = '
      SELECT 
      detailtransaction.idProduct,
      products.idProduct, 
      products.Nombre, 
      products.PrecioUnit, 
      products.uxp, 
      products.Estado, 
      products.Descripcion, 
      line.Descripcion lineDescription,
      volume.Descripcion as volumeDescription,
      SUM(detailtransaction.Cantidad) as sum
      
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
        $querystring .=  'GROUP BY detailtransaction.idProduct';

        //$querystring .=  ') ;';
      //print_r($querystring);
      $querystring .=  ' ORDER BY sum desc;';
      $query = $this->db->query($querystring);
      return $query->result();
    }

    function get_products_by_line($line=-1) {
      $this->db->select(
        'products.idProduct,
        products.Nombre,
        products.idLineVolume,
        products.PrecioUnit,
        products.uxp,
        products.Descripcion'
      );
      $this->db->from('products');
      $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
      $this->db->join('line', 'linevolume.idLine = line.idLine');
      $this->db->where('products.Estado', '1');
      $this->db->where('line.idLine', $line);
      $query = $this->db->get();
      return $query->result();
    }

    function get_products_by_line_dropdown($line=-1) {
      $this->db->select(
        'products.idProduct,
        products.Nombre,
        products.idLineVolume,
        products.PrecioUnit,
        products.uxp,
        products.Descripcion,
        volume.Descripcion as volume'
      );
      $this->db->from('products');
      $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
      $this->db->join('line', 'linevolume.idLine = line.idLine');
      $this->db->join('volume', 'volume.idVolume = linevolume.idVolume');
      $this->db->where('products.Estado', '1');
      $this->db->where('line.idLine', $line);
      $query = $this->db->get();
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Producto';

      foreach ($result as $r) {
        $dropdown[$r['idProduct']] = $r['volume']." - ".$r['Nombre'];
      }
      return $dropdown;
    }

    // get lines volumes dropdown
    function get_products_by_line_volume($line=-1, $volume=-1) {
      $this->db->select('*');
      $this->db->from('products');
      $this->db->join('linevolume', 'linevolume.idLineVolume = products.idLineVolume');
      $this->db->where('linevolume.idLine', $line);
      $this->db->where('linevolume.idLineVolume', $volume);
      $this->db->where('products.Estado', "1");
      $query = $this->db->get();
      $result = $query->result_array();
      $dropdown = array();
      $dropdown[0] = 'Seleccione Producto';

      foreach ($result as $r) {
        $dropdown[$r['idProduct']] = $r['Nombre'];
      }
      return $dropdown;
    }


    // get products by linevolume
    function get_by_linevolume($linevolume=-1) {
      $this->db->select('*');
      $this->db->from('products');
      $this->db->join('linevolume', 'linevolume.idLineVolume = products.idLineVolume');
      $this->db->where('linevolume.idLineVolume', $linevolume);
      $this->db->where('products.Estado', "1");
      $query = $this->db->get();
      return $query->result();
    }

    function csv ($search){
      $querystring = '
      SELECT 
      detailtransaction.idProduct,
      products.idProduct, 
      products.Nombre, 
      products.PrecioUnit, 
      products.uxp, 
      products.Estado, 
      products.Descripcion, 
      line.Descripcion lineDescription,
      volume.Descripcion as volumeDescription,
      SUM(detailtransaction.Cantidad) as sum
      
      FROM detailtransaction
      INNER JOIN products ON products.idProduct = detailtransaction.idProduct
      INNER JOIN linevolume ON linevolume.idLineVolume = products.idLineVolume
      INNER JOIN line ON line.idLine = linevolume.idLine
      INNER JOIN volume ON volume.idVolume = linevolume.idVolume
      
      
      WHERE detailtransaction.idTransaction IN (

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
      //return $query->result();









      $this->load->dbutil();

      //$query = $this->db->query("SELECT * FROM products");
      $delimiter = ",";
      $newline = "\r\n";

      return $this->dbutil->csv_from_result($query, $delimiter, $newline); 
    }
}
?>