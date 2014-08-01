<?php

class Liquidation_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  function create($data_in) {
    if ($this->db->insert('liquidacion', $data_in)) {
      $id = $this->db->insert_id();
      return $id;
    }
  }

  function get($id) {
    $this->db->select('
      liquidacion.idLiquidacion,
      liquidacion.fechaRegistro,
      liquidacion.horaRegistro,
      users.Nombre,
      users.Apellido,
      liquidacion.detalle,
      liquidacion.fechaFin,
      liquidacion.horaFin,
      liquidacion.mark,
      liquidacion.status,
      zona.Descripcion
    ');
    $this->db->from('liquidacion');
    $this->db->join('users', 'users.idUser = liquidacion.idUser');
    $this->db->join('zona', 'zona.idZona = liquidacion.ruta');
    $this->db->where(array('liquidacion.idLiquidacion'=>$id,'status'=>'active'));
    $query = $this->db->get();
    return $query->result();
  }


  // get all users distributor, with his zones
  function get_users_and_zones() {
    $this->db->select(
      'users.idUser,
      users.Nombre, 
      users.Apellido,
      zona.idZona,
      zona.Descripcion'
    );
    $this->db->from('users');
    $this->db->join('zona', 'zona.idZona = users.idZona');
    $this->db->order_by('idUser', "asc");
    $this->db->where('users.NivelAcceso !=', 1);

    $query = $this->db->get();
    $drop = '<select class="form-control chosen-select" name="distributor"><option value="0">Seleccione Distribuidor</option>';

    $result = $query->result_array();
    foreach ($result as $r) {
      $drop .= '<option value="'.$r['idUser'].'">'.$r['Nombre']." ".$r['Apellido']." ".$r['Apellido'].'</option>';
    }

    $drop .= '</select>';
    return $drop;
  }

  function get_enabled_users_and_zones() {
    $this->db->select(
      'users.idUser,
      users.Nombre, 
      users.Apellido,
      zona.idZona,
      zona.Descripcion'
    );
    $this->db->from('users');
    $this->db->join('zona', 'zona.idZona = users.idZona');
    $this->db->order_by('idUser', "asc");
    $this->db->where('users.NivelAcceso !=', 1);

    $query = $this->db->get();
    $drop = '<select class="form-control" name="distributor"><option value="0">Seleccione Distribuidor</option>';

    $result = $query->result_array();
    foreach ($result as $r) {
      // check if this user dont have pending liquidations
      $this->db->where('liquidacion.idUser', $r['idUser']);
      $this->db->where('liquidacion.mark !=', 'completado');
      $this->db->where('liquidacion.status', 'active');
      $this->db->from('liquidacion');
      if ($this->db->count_all_results() <= 0) {
        $drop .= '<option data-zone="'.$r['idZona'].'" value="'.$r['idUser'].'">'.$r['Nombre']." ".$r['Apellido']." ".$r['Apellido'].'</option>';
      }
    }

    $drop .= '</select>';
    return $drop;
  }

  function get_detail_list($id, $line) {
    $this->db->select(
      'products.idProduct as idProduct,
      volume.Descripcion as volume,
      products.Nombre as Nombre,
      products.PrecioUnit as price,
      products.uxp as uxp,
      detalleliquidacion.idDetalleLiquidacion as idDetalleLiquidacion,
      detalleliquidacion.carga0 as previousDay,
      detalleliquidacion.carga1 as charge,
      detalleliquidacion.carga2 as chargeExtra1,
      detalleliquidacion.carga3 as chargeExtra2,
      detalleliquidacion.carga4 as chargeExtra3,
      detalleliquidacion.venta as venta,
      detalleliquidacion.prestamo as prestamo,
      detalleliquidacion.bonificacion as bonificacion,
      detalleliquidacion.devolucion as devolucion,
      detalleliquidacion.status as estado,
      detalleliquidacion.detalle as detalle,
      detalleliquidacion.excepcion as excepcion
      '
    );

    $this->db->from('detalleliquidacion');
    $this->db->join('products', 'products.idProduct = detalleliquidacion.idProduct');
    $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
    $this->db->join('line', 'linevolume.idLine = line.idLine');
    $this->db->join('volume', 'linevolume.idVolume = volume.idVolume');
    $this->db->where(array( 'detalleliquidacion.idLiquidacion' => $id, 'line.idLine' => $line ));
    $query = $this->db->get();
    return $query->result();
  }

  function get_no_regular_lines($idLiquidation) {
    $dropdown = array();
    $this->db->select('*');
    $this->db->from('line');
    $this->db->order_by('Descripcion', "asc");
    $this->db->where('regular', "no");
    $query = $this->db->get();
    
    $result = $query->result_array();
    foreach ($result as $r) {
/*
      $this->db->from('detalleliquidacion');
      $this->db->join('products', 'products.idProduct = detalleliquidacion.idProduct');
      $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
      $this->db->join('line', 'linevolume.idLine = line.idLine');
      $this->db->where('line.idLine', $r['idLine']);

      if ($this->db->count_all_results() <= 0) {
        $dropdown[$r['idLine']] = $r['Descripcion'];
      }
*/
      $dropdown[$r['idLine']] = $r['Descripcion'];
    }
    return $dropdown;
  }

  function get_lines_actives($idLiquidation) {
    $this->db->select(
      'line.idLine,
      line.Descripcion,
      line.uxplinea,
      line.regular
      '
    );

    $this->db->from('detalleliquidacion');
    $this->db->join('products', 'products.idProduct = detalleliquidacion.idProduct');
    $this->db->join('linevolume', 'products.idLineVolume = linevolume.idLineVolume');
    $this->db->join('line', 'linevolume.idLine = line.idLine');
    $this->db->where('detalleliquidacion.idLiquidacion', $idLiquidation);
    $this->db->group_by("line.idLine");
    $query = $this->db->get();
    return $query->result();
  }

  function report($status="active", $mark="all") {
    $this->db->select(
      'liquidacion.idLiquidacion, 
      liquidacion.fechaRegistro, 
      liquidacion.horaRegistro, 
      users.Nombre,
      users.Apellido,
      liquidacion.ruta, 
      liquidacion.detalle,
      liquidacion.fechaFin,
      liquidacion.horaFin,
      liquidacion.mark,
      liquidacion.status,
      zona.Descripcion'
    );
    $this->db->from('liquidacion');
    $this->db->join('users', 'users.idUser = liquidacion.idUser');
    $this->db->join('zona', 'zona.idZona = liquidacion.ruta');

    if(isset($status) AND $status != ""){
      $this->db->where('liquidacion.status', $status);
    }
    if(isset($mark) AND $mark != "all"){
      if($mark == "charges"){
        $marks = array('creado', 'cargado', 'cargaextra1', 'cargaextra2', 'cargaextra3');
        $this->db->where_in('liquidacion.mark', $marks);
      }elseif ($mark == "devolutions") {
        $this->db->where('liquidacion.mark', "cargafinal");
      }else{
        $this->db->where('liquidacion.mark', $mark);
      }
    }
    
    $query = $this->db->get();
    return $query->result();
  }


  function search($data_in) {
    $this->db->select(
      'liquidacion.idLiquidacion,
      liquidacion.fechaRegistro,
      liquidacion.horaRegistro,
      users.Nombre,
      users.Apellido,
      liquidacion.ruta,
      liquidacion.detalle,
      liquidacion.fechaFin,
      liquidacion.horaFin,
      liquidacion.mark,
      liquidacion.status,
      zona.Descripcion'
    );
    $this->db->from('liquidacion');
    $this->db->join('users', 'users.idUser = liquidacion.idUser');
    $this->db->join('zona', 'zona.idZona = liquidacion.ruta');

    if(isset($data_in['status']) && $data_in['status'] != ""){
      //$this->db->where('liquidacion.status', $data_in['status']);
    }
    if(isset($data_in['distributor']) && $data_in['distributor'] != "" && $data_in['distributor'] != "0"){
      $this->db->where('liquidacion.idUser',$data_in['distributor']);
    }
    if(isset($data_in['dateStart']) && $data_in['dateStart'] != ""){
      $fecha = $data_in['dateStart'];
      $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
      $nuevafecha = date ( 'y-m-d' , $nuevafecha );
      $this->db->where('DATE(liquidacion.fechaRegistro) >', $nuevafecha);
    }
    if(isset($data_in['dateFinish']) && $data_in['dateFinish'] != ""){
      $fecha = $data_in['dateFinish'];
      $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
      $nuevafecha2 = date ( 'y-m-d' , $nuevafecha2 );
      $this->db->where('DATE(liquidacion.fechaRegistro) <', $nuevafecha2);
    }

    $this->db->order_by('liquidacion.fechaRegistro', "asc");
    $query = $this->db->get();
    return $query->result();
  }

  function count($status="active", $mark="all"){
    $this->db->from('liquidacion');
    $this->db->join('users', 'users.idUser = liquidacion.idUser');
    $this->db->join('zona', 'zona.idZona = liquidacion.ruta');
    //$this->db->where('status', "active");

    if(isset($status) AND $status != ""){
      $this->db->where('liquidacion.status', $status);
    }

    if(isset($mark) AND $mark != "all"){
      if($mark == "charges"){
        $marks = array('creado', 'cargado', 'cargaextra1', 'cargaextra2', 'cargaextra3');
        $this->db->where_in('liquidacion.mark', $marks);
      }elseif ($mark == "devolutions") {
        $this->db->where('liquidacion.mark', "cargafinal");
      }else{
        $this->db->where('liquidacion.mark', $mark);
      }
    }
    return $this->db->count_all_results();
  }

  function create_detail($data) {
    if ($this->db->insert('detalleliquidacion', $data)) {
      return TRUE;
    }
    return FALSE;
  }

  function update($data, $id) {
    $this->db->where('idLiquidacion', $id);

    if ($this->db->update('liquidacion', $data)) {
      return TRUE;
    }
    return FALSE;
  }

  function update_detail_liquidations($data, $id) {
    $this->db->where('idLiquidacion', $id);
    if ($this->db->update('detalleliquidacion', $data)) {
      return TRUE;
    }
    return FALSE;
  }

  function update_detail($data, $id) {
    $this->db->where('idDetalleLiquidacion', $id);
    if ($this->db->update('detalleliquidacion', $data)) {
      return TRUE;
    }
    return FALSE;
  }

  // remove detalle_liquidation without any charge
  function clean_products_without_charges($id) {
    $this->db->where('idLiquidacion', $id);
    $this->db->where('carga0', 0);
    $this->db->where('carga1', 0);
    $this->db->where('carga2', 0);
    $this->db->where('carga3', 0);
    $this->db->where('carga4', 0);
    $this->db->delete('detalleliquidacion');
  }

}

?>