<?php
  function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $start_ts - $end_ts;
    $diff = round($diff / 86400);
    if ($diff < 0)
      $diff = 0;
    return $diff;
  }

?>

<div class="row" style="overflow:hidden;">

  <div class="container">
    <div class="span10 offset1">
      <div class="block_content row">
          <fieldset>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data-table" width="100%">
                <thead>
                  <tr>
                    <th class="center">Fecha(Registro)</th>
                    <th class="center">Fecha(Transacción)</th>
                    <th class="center">idUser</th>
                    <th class="center">idUserSupervisor</th>
                    <th class="center">idTransaction</th>
                    <th class="center">Distribuidor</th>
                    <th class="center">Cliente</th>
                    <th class="center">Recibo</th>
                    <th class="center">Total</th>
                    <th class="center">Saldo</th>
                    <th class="center">Origen</th>
                    <th class="center">Detalle</th>
                  </tr>
                </thead>
                <tbody id="diaryTable">
                  <?php
                    foreach ($diaries as $row) {
                      $data_in['NumVoucher'] = $row->NumVoucher;
                      $data_in['idCustomer'] = $row->idCustomer;

                      $pagado = $this->Diary_Model->get_all_pay_for($data_in);                      
                      $saldo = $row->Monto - $pagado;
                  ?>
                    <tr class="even gradeX">
                      <td class="center"><?php echo $row->FechaRegistro; ?></td>
                      <td class="center"><?php echo $row->FechaTransaction; ?></td>
                      
                      <td class="center"><?php echo $row->idUser; ?></td>
                      <td class="center"><?php echo $row->idUserSupervisor; ?></td>
                      <td class="center"><?php echo $row->idTransaction; ?></td>

                      <td class="center"><?php echo $row->customer; ?></td>
                      <td class="center"><?php echo $row->code." - ".$row->custname; ?></td>
                      <td class="center"><?php echo $row->NumVoucher; ?></td>
                      <td class="center"><?php echo $this->Diary_Model->roundnumber($row->Monto, 2); ?></td>
                      <td class="center"><?php echo $this->Diary_Model->roundnumber($saldo, 2); ?></td>
                      <td class="center"><?php 
                      if ($row->Origen == "A") {
                        echo "Android";
                      }else{
                        echo "Web";
                      }
                      ?></td>
                      <td class="center"><?php echo $row->Detalle; ?></td>
                    </tr>
                  <?php
                    }
                  ?>           
                </tbody>
            </table>

          </fieldset>
      </div>
    </div>
  </div>
</div>