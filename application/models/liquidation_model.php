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
    $this->db->select('*');
    $this->db->from('liquidacion');
    $this->db->where(array('idLiquidacion'=>$id,'status'=>'active'));
    $query = $this->db->get();
    return $query->result();
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
      detalleliquidacion.estado as estado,
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


  function report($status="active", $mark="all") {
    $this->db->select(
      'liquidacion.idLiquidacion, 
      liquidacion.fechaRegistro, 
      liquidacion.horaRegistro, 
      liquidacion.idUser, 
      liquidacion.ruta, 
      liquidacion.detalle,
      liquidacion.fechaFin,
      liquidacion.horaFin,
      liquidacion.mark,
      liquidacion.status'
    );
    $this->db->from('liquidacion');

    if(isset($status) AND $status != ""){
      $this->db->where('liquidacion.status', $status);
    }
    if(isset($mark) AND $mark != "all"){
      $this->db->where('liquidacion.mark', $mark);
    }

    $query = $this->db->get();
    return $query->result();
  }

  function count($mark="creado"){
    if (isset($mark) && $mark != "all" ) {
      $this->db->like('mark', $mark);
    }
    $this->db->from('liquidacion');
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