<style type="text/css">
  strong{
    color: #000;
  }
  table{
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-collapse: separate;
    border-color: #000000 #000000 #000000 -moz-use-text-color ;
    border-radius: 4px 4px 4px 4px;
    border-style: solid solid solid none;
    border-width: 1px 1px 1px 0;   
  }
  .maintable tbody tr th {
    background-color: #F9F9F9;
    border-bottom: 1px solid #DDDDDD;
  }
  .maintable tbody tr td{
    background-color: #FFFFFF;
    border-bottom: 1px solid #DDDDDD;
  }

  .table th, .table td {
    font-size: 9px !important;
    padding: 0 4px !important;
  }

  .table-bordered th, .table-bordered td {
    border-left: 1px solid #000000 !important;
  }
  .table th, .table td {
    border-top: 1px solid #000000 !important;
  }

  .table-bordered {
    border-color: transparent #000000 #000000 transparent -moz-use-text-color !important;
    border-top: 0px;
    border-left: 0px; 
  }


  .td_1{
    width: 55px; 
    text-align: right;
  }
  .td_2{
    width: 60px; 
    text-align: right !important;
  }
  .td_3{
    width: 100px; 
  }
  .td_4{
    text-align: right !important;
  }
  .container table{
    width: 100% !important;    
  }
  .nomargin{
    border: 0 !important;
  }
</style>

<table class="tableHorizon table table-bordered table-striped" border="0" >
  <thead>
    <tr>
      <th>FECHA</th>
      <th>MORA <br>(dias)</th>
      <th>RECIBO</th>
      <th>NOMBRE</th>
      <th>DIRECCIÓN</th>
      <th class="td_4">MONTO</th>
      <th>
        PAGOS
        <table class="nomargin">
          <thead>
          <tr>
            <th class="td_1">Fecha</th>
            <th class="td_2">Monto</th>
            <th>Detalle</th>
          </tr>
        </thead>
        </table>
      </th>
      <th class="td_4">SALDO</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $montototal = 0;
      $saldototal = 0;

      foreach ($diaries as $diary): 
        $montototal += $diary->Monto;
    ?>

      <tr>
        <td><?php echo $diary->FechaTransaction; ?></td>
        <td><?php echo $this->Diary_Model->dateDiff(date("Y-m-d"), $diary->FechaTransaction); //echo dateDiff(date("Y-m-d"), $row->FechaTransaction); ?></td>
        <td><?php echo $diary->NumVoucher; ?></td>
        <td><?php echo $diary->custname; ?></td>
        <td><?php echo $diary->custaddress; ?></td>
        <!--<td><?php //echo $this->Area_Model->get_area_name($diary->idSubZona); ?></td>-->
        <td class="td_4"><?php echo $this->Diary_Model->roundnumber($diary->Monto, 2); ?></td>
        <td><?php 
          $data['distributor'] = $diary->idUser;
          $data['voucher'] = $diary->NumVoucher;
          $pays = $this->Diary_Model->getpays($data);
          $pagado = 0;

          if (count($pays) > 0) {
?>            
            <table cellpadding="0" cellspacing="0" border="0" class="tableHorizon table table-bordered" >
              <tbody >
                <?php foreach ($pays as $row){
                  $pagado += $row->Monto;
                ?>
                <tr class='even gradeX'>
                  <td class="td_1"><?php echo $row->FechaTransaction;?></td>
                  <td class="td_2"><?php echo $this->Diary_Model->roundnumber($row->Monto, 2);?></td>
                  <td class=""><?php echo $row->Detalle;?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          <?php } ?>
        </td>
        <td class="td_4"><?php 
          $saldo = $diary->Monto - $pagado;
          echo $this->Diary_Model->roundnumber($saldo, 2);

          $saldototal += $saldo;
        ?></td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="4">&nbsp;</td>
      <td class="td_4"><strong>MONTO TOTAL:</strong></td>
      <td class="td_4"><strong><?php echo $this->Diary_Model->roundnumber($montototal, 2);?></strong></td>
      <td class="td_4"><strong>SALDO TOTAL:</strong></td>
      <td class="td_4"><strong><?php echo $this->Diary_Model->roundnumber($saldototal, 2);?></strong></td>
    </tr>
  </tbody>
</table>